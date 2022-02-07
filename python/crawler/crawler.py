import json
import sys
import time
import chromedriver_autoinstaller
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import subprocess
from bs4 import BeautifulSoup

# 셀레니움 작동하기전 Chrome DevTools Protocol 실행해서 브라우저를 실행 시켜놓고 해당 브라우저로 크롤링
# 우분투인경우 /usr/bin/google-chrome --no-sandbox --headless --disable-gpu --remote-debugging-port=9222 --user-data-dir="~/ChromeProfile" --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36"
# 맥인경우 /Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-port=9222 --user-data-dir="~/ChromeProfile" --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36"

chromedriver_autoinstaller.install()

options = webdriver.ChromeOptions()
# options.add_argument('--headless')
# options.add_argument('window-size=1200x600')
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')
options.add_argument("disable-gpu")
options.add_argument("--incognito")
options.add_argument("user-agent=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36")
options.add_experimental_option("debuggerAddress", "127.0.0.1:9222")

# browser = webdriver.Chrome(chrome_options=options, executable_path="/Users/jisungyoo/Dropbox/dev/driver/chromedriver_mac")
browser = webdriver.Chrome(chrome_options=options)
url = sys.argv[1]
browser.get(url)
browser.implicitly_wait(10)
time.sleep(5)

SCROLL_PAUSE_TIME = 1
scroll = 0
scrollSize = 500
prev_scrollTop = browser.execute_script("return document.scrollingElement.scrollTop")
while True:
    scroll = scrollSize + prev_scrollTop
    browser.execute_script(f"window.scrollTo(0, {scroll});")

    time.sleep(SCROLL_PAUSE_TIME)

    new_scrollTop = browser.execute_script("return document.scrollingElement.scrollTop")

    if new_scrollTop == prev_scrollTop:
        break

    prev_scrollTop = new_scrollTop

html = browser.page_source
soup = BeautifulSoup(html, 'html.parser')
contents = soup.select('.tab-contents')

result = {
    "html" : None,
}

try :
    result['result'] = True
    result['html'] = str(contents[0])
except :
    result['result'] = False
    result['html'] = html

print(json.dumps(result))
with open('webpage.html', 'w') as f:
        f.write(result['html'])

browser.quit()