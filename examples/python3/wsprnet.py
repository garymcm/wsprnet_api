# pip install requests.
import requests

# Change to your wsprnet.org credentials.
USER =  'UUUUU'
PASS = 'XXXXXXXXX'

ses=requests.Session()
r=ses.post('https://www.wsprnet.org/drupal/rest/user/login',json={"name":USER ,"pass": PASS})
print(r.status_code)
d=r.json()
print("========================================")
print(d)
print("-------------------------------------------")
print(r.cookies)
sessid=d["sessid"]
sessname=d["session_name"]
# Uses your callsign.
r2=ses.post('https://www.wsprnet.org/drupal/wsprnet/spots/json/',cookies=r.cookies,data={"band":10,"callsign":USER,"minutes":10})
print("-------------------------------------------")
print(r2.status_code)
print(r2)
print(r2.text)