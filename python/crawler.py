import sys
import time
import chromedriver_autoinstaller
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# 셀레니움 작동하기전 Chrome DevTools Protocol 실행해서 브라우저를 실행 시켜놓고 해당 브라우저로 크롤링
# 우분투인경우 /usr/bin/google-chrome --no-sandbox --headless --disable-gpu --remote-debugging-port=9222 --user-data-dir="~/ChromeProfile" --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36"
# 맥인경우 /Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-port=9222 --user-data-dir="~/ChromeProfile" --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36"

chromedriver_autoinstaller.install()

options = webdriver.ChromeOptions()
options.add_argument('--headless')
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')
options.add_argument("disable-gpu")
options.add_argument("--incognito")
options.add_argument("user-agent=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36")

options.add_experimental_option("debuggerAddress", "127.0.0.1:9222")

browser = webdriver.Chrome(chrome_options=options)

# url = 'https://www.coupang.com/vp/products/172073083?itemId=491955480&vendorItemId=4246128952&src=1139000&spec=10799999&addtag=400&ctag=172073083&lptag=AF0184469&itime=20220204210058&pageType=PRODUCT&pageValue=172073083&wPcid=16385851731236673923925&wRef=&wTime=20220204210058&redirect=landing&traceid=V0-113-448c4b0e26f94ae4&placementid=&clickBeacon=&campaignid=&contentcategory=&imgsize=&pageid=&deviceid=&token=&contenttype=&subid=&impressionid=&campaigntype=&contentkeyword=&subparam=&isAddedCart='
url = 'https://link.coupang.com/re/AFFSDP?lptag=AF0184469&pageKey=172073083&itemId=491955480&vendorItemId=4246128952&traceid=V0-113-448c4b0e26f94ae4'

browser.get(url)
browser.implicitly_wait(10)

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
print(html)
browser.quit()

with open('webpage.html', 'w') as f:
    f.write(html)