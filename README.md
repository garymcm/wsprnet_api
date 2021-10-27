# wsprnet_api - Documentation for using the API

At this point in time the API is invite only. Please send me a note if you want to be included. There are some infrastructure concerns that we need  to deal with before we open this up.

# Good citizenship
- Do not request the same query more frequently than every 2 minutes.
- Avoid the 2 minute boundaries, since that's when the user uploads all hit, and the server is busiest.
- Always take the minimal amount data you need.
- If you want a full feed of every spot **DO NOT USE THIS API**. We  will work directly with sites for peering arrangements, so please reach out to the admins.

# Endpoints
Three endpoints are provided:

* `https://www.wsprnet.org/drupal/wsprnet/spots/json`
* `https://www.wsprnet.org/drupal/wsprnet/paths/json`
* `https://www.wsprnet.org/drupal/wsprnet/status/json`

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

- **spotnum_start** - each Spot gets a Unique ID. The API returns spots **greater than** the passed value.
- **band** - see 'Band Values' below
- **minutes** - number of minutes to retrieve. 24 hours of Spots are available from this API. Should be an even number<sup>1</sup>.
- **callsign** - filters by the Transmitting Station's call sign.
- **reporter** - filters by the Reporting Station's call sign<sup>2</sup>.
- **exclude_special** - 0 or 1. Excludes balloon station telemetry call signs.

<sup>1</sup> Spots are timestamped with the __start__ of the 2 minute cycle they were decoded, i.e. xx:00, xx:02 etc. So at any instant the database will be populated with spots from 2 cycles back, i.e. -4 minutes from the current time.

<sup>2</sup> When the Call and Reporter call signs are identical, then the results will include Spots where Call **or** Reporter match; otherwise, it's where Call **and**  Reporter match.

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
| All | All bands |

# Sample Output
## Spots
```json
[
    {
        "Spotnum": "1451509949",
        "Date": "1548761280",
        "Reporter": "AE2EA",
        "ReporterGrid": "FN12fr",
        "dB": "-12",
        "MHz": "0.475674",
        "CallSign": "AA1A",
        "Grid": "FN42pb",
        "Power": "30",
        "Drift": "0",
        "distance": "566",
        "azimuth": "280",
        "Band": "0",
        "version": "4.0 r4889",
        "code": "0"
    },
    {
        "Spotnum": "1451509948",
        "Date": "1548761280",
        "Reporter": "F5VBD",
        "ReporterGrid": "JN25xo",
        "dB": "-15",
        "MHz": "10.140152",
        "CallSign": "2E0XVX",
        "Grid": "IO92ml",
        "Power": "23",
        "Drift": "0",
        "distance": "915",
        "azimuth": "144",
        "Band": "10",
        "version": "1.3 Kiwi",
        "code": "0"
    }
]
```
## Paths
```json
[
    {
        "CallSign": "UR5MLG",
        "Reporter": "DK0ABT",
        "distance": "2139",
        "Grid": "KN99",
        "ReporterGrid": "JN49pb"
    },
    {
        "CallSign": "MW0CWF",
        "Reporter": "DK0ABT",
        "distance": "932",
        "Grid": "IO81ik",
        "ReporterGrid": "JN49pb"
    }
]
```
## Statuses
```json
[
    {
        "callsign": "AE0CV",
        "grid": "DM79",
        "rx": "10.140200",
        "tx": "10.140200",
        "tpct": "0",
        "dbm": "37",
        "band": "10"
    },
    {
        "callsign": "BM4AIK",
        "grid": "PL02DP",
        "rx": "10.140180",
        "tx": "10.140200",
        "tpct": "0",
        "dbm": "0",
        "band": "10"
    },
    {
        "callsign": "DC6EB",
        "grid": "JN49",
        "rx": "10.140200",
        "tx": "10.140200",
        "tpct": "0",
        "dbm": "37",
        "band": "10"
    }
]
```

# Session Management
 
In order to access the endpoints the following has been created:

## 1. Login 
 
`POST https://www.wsprnet.org/drupal/rest/user/login`

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
`"token": "DYjQo4GYmnT9NHELLxe5efARQ0yfZByr0DY5VC94cUM"`  
 
Going forward add the header:
 
`Cookie: SESS70f94c916a4e1b4938c6d4158a067062=e8T0xDx-FkgT-Cwd6FPjdWaZqGxi8GXLFm1rPdSWI9Q`  
 
i.e. Cookie: {sesssion_name}={sessid}
 
## 3. Logout

Headers:
 
`X-CSRF-Token: {token from step 2 above}`  
`Cookie: {from step 2}`   
`Content-Type: application/json`  

then:

`POST https://www.wsprnet.org/drupal/rest/user/logout.json`
