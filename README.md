# TeamSpeak Query  bot - Anti VPN [![GitHub license](https://img.shields.io/github/license/Ondra3211/ts-antivpn)](https://github.com/Ondra3211/ts-antivpn/blob/master/LICENSE)

## What is this?

TeamSpeak query bot that can detect if user use VPN on connect.  
Bot use http://iphub.info API for VPN detection.

## Features

- It's query bot so does not use any slots.
- Fully configurable
- Build in most powerful ts3 php framework [TeamSpeak 3 PHP Framework](https://github.com/planetteamspeak/ts3phpframework)
- Works on Linux, macOS and Windows
- Open Source

## Installation
**Requirements**
* PHP 7.x, `curl`
* TeamSpeak Server - v3.4.0 (build >= 1536564584) or higher.
* Install the TS3 PHP Framework by [manually downloading](https://github.com/ronindesign/ts3phpframework/archive/master.zip) it or using Composer:
```
composer require planetteamspeak/ts3-php-framework
```  
## Configuration
<details>
	<summary>config.php</summary>
  
```php
$cf["connect"] = [
	"username" => "serveradmin",
	"password" => "2lM3Nop6",
	"host" => "127.0.0.1",
	"qport" => "10011",
	"vport" => "9987",
	"nickname" => "Anti VPN",
	"default_channel" => false // false to disable 
];

// https://iphub.info/

$cf["anti-vpn"] = [
	"API-Key" => "",
	"ignored_groups" => array(51594, 51618, 52335, 51601, 51606, 51620, 51602, 51607, 51604, 51608, 51605, 51609, 51592, 51622, 51610),
	"kick_message" => "VPN Is not allowed!"
];
```
  
</details>

## How to use?
```
screen -AmdS tsbot php bot.php
```

## License
```
MIT License

Copyright (c) 2019 Ondřej Niesner

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
