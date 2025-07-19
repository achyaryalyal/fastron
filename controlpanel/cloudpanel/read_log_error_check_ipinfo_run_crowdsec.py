#!/usr/bin/env python3
import re
import ipaddress
from collections import Counter
import urllib.request
import subprocess
import requests
from datetime import datetime
import time

LOG_FILE = "/var/www/logs/nginx/error.log"
IPINFO_TOKEN = 'xxxxxxxxxx'  # Ganti token di sini

now = datetime.now()
formatted_time = now.strftime("%A, %d %B %Y %H:%M:%S")
timezone = time.tzname[0]
print(f"{formatted_time} {timezone}")

# Fungsi untuk mendapatkan IP publik server
def get_public_ip():
    try:
        with urllib.request.urlopen('https://api.ipify.org') as response:
            return response.read().decode('utf-8')
    except:
        return None

# Fungsi untuk cek apakah subnet /24 sudah diblokir oleh CrowdSec
def is_subnet_blocked_by_crowdsec(subnet):
    try:
        result = subprocess.run(
            ["sudo", "cscli", "decisions", "list", "--scope", "range", "--value", subnet],
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE,
            text=True
        )
        return result.returncode == 0 and "No active decisions" not in result.stdout
    except Exception as e:
        print(f"⚠ Error saat cek subnet {subnet}: {e}")
        return False

# Fungsi untuk mendapatkan info negara & ASN dari IP
def get_geo_asn(ip):
    url = f'https://ipinfo.io/{ip}?token={IPINFO_TOKEN}'
    try:
        response = requests.get(url, timeout=5)
        data = response.json()
        city = data.get('city', 'City tidak diketahui')
        region = data.get('region', 'Region tidak diketahui')
        negara = data.get('country', 'Negara tidak diketahui')
        org = data.get('org', 'ASN tidak diketahui')
        return city, region, negara, org
    except Exception as e:
        return 'Tidak diketahui', f'ERROR: {e}'

# 1. Baca log & ambil IP ( setelah client: )
ips = []
with open(LOG_FILE) as f:
    for line in f:
        #if 'access forbidden by rule' in line:
        #    continue
        m = re.search(r'client: ([0-9a-fA-F:.]+)', line)
        if m:
            ips.append(m.group(1))

# 2. Hitung IP terbanyak
counter = Counter(ips)

# 3. Ambil IP publik server
my_ip = get_public_ip()
if my_ip:
    print(f"\nIP publik server saat ini: {my_ip}")
else:
    print("\n⚠ Gagal mendeteksi IP publik server.")
    my_ip = None

# 4. Tampilkan IP yang sering muncul & status blokir subnetnya
minimal = 500
printed = 0

print(f"\nDaftar IP terbanyak di error log Nginx (minimal {minimal}):")
print("-----------------------------------------------------")

checked_subnets = {}

for ip, count in counter.most_common():
    if count < minimal:
        continue
    if ip == my_ip:
        continue
    try:
        ip_obj = ipaddress.ip_address(ip)
        subnet_obj = ipaddress.ip_network(f"{ip}/24", strict=False)
        subnet = str(subnet_obj)

        if subnet not in checked_subnets:
            blocked = is_subnet_blocked_by_crowdsec(subnet)
            checked_subnets[subnet] = blocked
        else:
            blocked = checked_subnets[subnet]

        city, region, negara, org = get_geo_asn(ip)

        if blocked:
            status = '✅ sudah diblokir'
        else:
            if 'google' in org.lower():
                status = (
                    '🔎 ASN Google – silakan review manual\n'
                    f'\t→ Jalankan untuk blokir jika perlu:\n'
                    f'\t  sudo cscli decisions add --reason "permanent malicious subnet" '
                    f'--duration 1000d --range {subnet}'
                )
            elif negara != 'ID':
                subprocess.run([
                    "sudo", "cscli", "decisions", "add",
                    "--reason", "permanent malicious subnet",
                    "--duration", "1000d",
                    "--range", subnet
                ])
                status = '🚫 diblokir otomatis (bukan Indonesia/Google)'
            else:
                status = (
                    '🇮🇩 IP dari Indonesia – silakan review manual\n'
                    f'\t→ Jalankan untuk blokir jika perlu:\n'
                    f'\t  sudo cscli decisions add --reason "permanent malicious subnet" '
                    f'--duration 1000d --range {subnet}'
                )

        icon_khusus = "📌" if negara == "ID" else "🛡"
        print(f"https://ipinfo.io/{ip:<15} | {count:5} kali | {status} |  Negara: {negara} {icon_khusus} | {org} ({city}, {region})")
        printed += 1

    except Exception as e:
        print(f'{ip:<20}: {count:5} kali - ⚠ invalid IP - {e}')
        printed += 1

if printed == 0:
    print("Tidak ada IP yang memenuhi syarat.")

print(f"\n")
