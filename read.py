# pip install selenium
# python read.py or python3 read.py

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import time
import json
import requests
import random

user_agents = [
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36'
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36'
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36'
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36'
    'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36'
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Safari/605.1.15'
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 13_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Safari/605.1.15'
]
headers = {'User-Agent': random.choice(user_agents)}

# URL WordPress yang menyediakan data JSON berita terbaru
WORDPRESS_URL = "https://example.com/wp-json/wp/v2/posts?per_page=6&_embed"

# Ambil data JSON berita terbaru
response = requests.get(WORDPRESS_URL, headers=headers)
json_data = response.json()
#print(json_data)

# Pilih satu URL berita secara acak dari data JSON
random_news = random.choice(json_data)
news_url = random_news['link']

# Konfigurasi Chrome untuk mode incognito
chrome_options = Options()
chrome_options.add_argument("--incognito") # --kiosk --start-maximized --start-fullscreen
chrome_options.add_experimental_option("excludeSwitches", ["enable-automation"])

# Inisialisasi WebDriver Chrome
driver = webdriver.Chrome(options=chrome_options)

try:
	# Maximize current window
	driver.maximize_window()

	# Buka URL berita melalui Google Chrome dengan mode incognito
	driver.get(news_url)

	# Tunggu beberapa detik agar laman web selesai dimuat
	time.sleep(3)

	# Set jumlah scroll yang diinginkan
	jumlah_scroll = 60  # Misalnya, 100 kali scroll
	jumlah_scroll_bagi_dua = jumlah_scroll / 2

	# Berapa menit total waktu scroll
	menit_scroll = 2;
	waktu_total_scroll = menit_scroll * 60

	# Waktu tunggu antar scroll
	waktu_tunggu = waktu_total_scroll / jumlah_scroll

	# Lakukan scroll secara otomatis
	for i in range(jumlah_scroll):
		if i < jumlah_scroll_bagi_dua:
			# Scroll ke bawah
			driver.execute_script("window.scrollBy(0, 40);")
		else:
			# Scroll ke atas
			driver.execute_script("window.scrollBy(0, -40);")
		# Tunggu sebentar setelah setiap scroll
		time.sleep(waktu_tunggu)

except Exception as e:
	print("Terjadi kesalahan:", e)

finally:
	# Tutup browser
	driver.quit()
