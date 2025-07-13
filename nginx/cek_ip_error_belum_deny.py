#!/usr/bin/env python3
import re
import ipaddress
from collections import Counter
import glob

LOG_FILE = "/var/www/logs/nginx/error.log"
DENY_DIR = "/etc/nginx/daftarblokir/*.conf"

# 1. Baca semua subnet dari file deny
subnets = []
for filename in glob.glob(DENY_DIR):
    with open(filename) as f:
        for line in f:
            m = re.search(r'deny\s+([0-9a-fA-F:./]+)', line)
            if m:
                try:
                    net = ipaddress.ip_network(m.group(1), strict=False)
                    subnets.append(net)
                except Exception:
                    pass

# 2. Baca log & ambil IP
ips = []
with open(LOG_FILE) as f:
    for line in f:
        if 'access forbidden by rule' in line:
            continue
        m = re.search(r'client: ([0-9a-fA-F:.]+)', line)
        if m:
            ips.append(m.group(1))

# 3. Hitung IP terbanyak
counter = Counter(ips)

minimal = 20
printed = 0

print(f"\nDaftar IP terbanyak di error log Nginx yang BELUM di-deny (minimal {minimal}):")
print("-----------------------------------------------------------------------")

for ip, count in counter.most_common():
    if count < minimal:
        continue
    try:
        ip_obj = ipaddress.ip_address(ip)
        found = '❌ belum di-deny'
        for net in subnets:
            if ip_obj.version != net.version:
                continue
            if ip_obj in net:
                found = '✅ sudah di-deny'
                break
        if found == '❌ belum di-deny':
            print(f'https://ipinfo.io/{ip:<20}: {count:5} kali - {found}')
            printed += 1
    except Exception:
        print(f"{ip:<40} : {count:5} kali - ⚠ invalid IP")
        printed += 1

if printed == 0:
    print("Tidak ada IP yang memenuhi syarat.")
