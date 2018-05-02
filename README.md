# wsprnet_api - Documentation for using the API

At this point in time the API is invite only. Please send me a note if you want to be included. There are some infrastructure concerns that we need  to deal with before we open this up.

# Endpoints
Two endpoints are provided. One for spots and another for statuses. A status record is the frequency, TX % data you see on the map when the station has no spots and comes from the WSPRNet client each user runs

* `http://wsprnet.org/wsprnet/spots/json`
* `http://wsprnet.org/wsprnet/status/json`

Parameters are the same as the map page form and I'll list them here soon.
 
Spots are detailed, so same path and stations at different times will be in there. I will be creating a summary option to give the same output as the map.
 
 
# Session Management
 
In order to access the endpoints the following has been created:

## 1. Login 
 
`POST http://wsprnet.org/drupal/rest/user/login
 
Content Type: application/json
 
Body:
 
{
"name": "wsprnet_login"
"pass": "wsprnet_pass"
}
`
 
 
## 2. Sesssion Cookie
 
Login will return a JSON body. In it find these properties:
 
`"sessid": "e8T0xDx-FkgT-Cwd6FPjdWaZqGxi8GXLFm1rPdSWI9Q", 
 "session_name": "SESS70f94c916a4e1b4938c6d4158a067062"`
 
Going forward add the header:
 
`Cookie: SESS70f94c916a4e1b4938c6d4158a067062=e8T0xDx-FkgT-Cwd6FPjdWaZqGxi8GXLFm1rPdSWI9Q`
 
i.e. Cookie: {sesssion_name}={sessid}
 
## 3. Logout
 
`GET http://wsprnet.org/drupal/services/session/token`

With your Cookie header from 2.
 
Returns a single token. Then:
 
`POST http://wsprnet.org/drupal/rest/user/logout.json`
 
Headers
 
`X-CSRF-Token: {token from above} `


`Cookie:{from step 2} Content-Type:application/json`
