# wsprnet_api - Documentation for using the API

At this point in time the API is invite only. Please send me a note if you want to be included. There are some infrastructure concerns that we need  to deal with before we open this up.

# Endpoints
Three endpoints are provided: two for spots and one for statuses. A status record is the frequency, TX % data you see on the map when the station has no spots and comes from the WSPRNet client each user runs

* `http://wsprnet.org/drupal/wsprnet/spots/json`
* `http://wsprnet.org/drupal/wsprnet/paths/json`
* `http://wsprnet.org/drupal/wsprnet/status/json`

# API Parameters

The following table shows the parameters enabled on a specific endpoint. Parameters can be passed via GET or POST. Values in parentheses are defaults.

| Endpoint | spotnum_start | band (30m) | minutes (1) | callsign | reporter | exclude_special |
| ---------| :-----------: | :--: | :-----: | :------: | :------: | :-------------: |
| wsprnet/spots/json| X | X | X | X | X| X |
| wsprnet/paths/json |   | X | X | X | | X |
| wsprnet/status/json |   | X | X | X | | X |

spotnum_start - returns values greater than the passed value

# Band Values

| Band | `band` parameter |
| :--: | ---------------- |
| -1 | LF|
| 0 | MF |
| 1 | 160m |
| 3 | 80m |
| 5 | 60m |
| 7 | 40m |
| 10| 30m |
| 14 | 20m|
| 18 | 17m|
| 21 | 15m|
|	 24 | 12m|
| 28 | 10m|
| 50 | 6m|
| 70 | 4m|
| 144 | 2m|
| 432 | 70cm|
| 1296 | 23cm|
| ALL | All bands |

# Session Management
 
In order to access the endpoints the following has been created:

## 1. Login 
 
`POST http://wsprnet.org/drupal/rest/user/login`

Header:

`Content-Type: application/json`
 
Body:
 
`{`
`"name": "wsprnet_login"`
`"pass": "wsprnet_pass"`
`}`
 
 
## 2. Sesssion Cookie
 
Login will return a JSON body. In it find these properties:
 
`"sessid": "e8T0xDx-FkgT-Cwd6FPjdWaZqGxi8GXLFm1rPdSWI9Q"`
`"session_name": "SESS70f94c916a4e1b4938c6d4158a067062"`
 
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
