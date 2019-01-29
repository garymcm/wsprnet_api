# wsprnet_api - Documentation for using the API

At this point in time the API is invite only. Please send me a note if you want to be included. There are some infrastructure concerns that we need  to deal with before we open this up.

# Good citizenship
- Please take the minimal amount data you need.
- If you want a full feed of every spot **DO NOT USE THIS API**. We  will work directly with sites for peering arrangements, so please reach out to the admins.

# Endpoints
Three endpoints are provided:

* `http://wsprnet.org/drupal/wsprnet/spots/json`
* `http://wsprnet.org/drupal/wsprnet/paths/json`
* `http://wsprnet.org/drupal/wsprnet/status/json`

- **spots** - Returns all spots, unsummarized.
- **paths** - Returns one spot per `Call`, `Reporter`, `Call Grid`, `Reporter Grid`. This is exactly what the map query renders.
- **status** - Stations occasionally upload their status, which includes band and TX %. This API returns the recent statuses.

# API Parameters
The following table shows the parameters enabled on a specific endpoint. Parameters can be passed via GET or POST. All parameters are optional, but please note the values in parentheses are defaults.

| Endpoint | spotnum_start | band (30m) | minutes (4) | callsign | reporter | exclude_special (1) |
| ---------| :-----------: | :--: | :-----: | :------: | :------: | :-------------: |
| wsprnet/spots/json| X | X | X | X | X| X |
| wsprnet/paths/json |   | X | X | X | | X |
| wsprnet/status/json |   | X | X | X | | X |

- **spotnum_start** - each spot gets a unique id. The API returns spots **greater than** the passed value.
- **band** - see 'Band Values' below
- **minutes** - number of minutes to retrieve. Only 24 hours of spots are available from this API. Note that spots are timestamped with 2 minute cycle they were decoded, so it really only makes sense to ask for minutes more than 4 and in multiples of 2.
- **callsign** - filters by the Transmitting station's call sign.
- **reporter** - filters by the Reporting Station's call sing.
- **exclude_special** - 0 or 1. Excludes balloon station telemetry call signs.

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
