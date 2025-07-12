#!/usr/bin/env python3
import re
import ipaddress
from collections import Counter
import glob

ACCESS_LOG = "/var/www/logs/nginx/access.log"
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

print(f"Loaded {len(subnets)} deny subnets")

# 2. Baca log access & ambil IP (kolom ke-3)
ips = []
with open(ACCESS_LOG) as f:
    for line in f:
        parts = line.strip().split()
        if len(parts) >= 3:
            ip = parts[2]
            if ip:  # skip kalau kosong
                ips.append(ip)

# 3. Hitung IP terbanyak
counter = Counter(ips)

print("\nDaftar IP terbanyak di access log Nginx:")
print("----------------------------------------")

for ip, count in counter.most_common():
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
            #print(f"{ip:<40} : {count:5} kali - {found}")
    except Exception:
        print(f'{ip}\t: {count:5} kali - ⚠ invalid IP')
