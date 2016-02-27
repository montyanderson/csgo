# csgo

[![GitHub issues](https://img.shields.io/github/issues-raw/montyanderson/csgo.svg)](https://github.com/montyanderson/csgo/issues)
![GitHub stars](https://img.shields.io/github/stars/montyanderson/csgo.svg?style=social&label=Star)

A php-powered web page that shows a Steam user's Counter Strike: Global Offensive items.

![](http://i.imgur.com/z0daY2d.jpg)

## Hacking / Changing

To use a different Steam game for the inventory, simple change the app id on line 3.

``` php
<?php
// Change
$query = "http://steamcommunity.com/id/".$id."/inventory/json/730/2/";
// to
$query = "http://steamcommunity.com/id/".$id."/inventory/json/440/2/";
```

![](http://i.imgur.com/LpVHXZv.jpg)

## Helper Function

``` php
<?php

function getUserInventory($id, $app = 730) {
    $url = "http://steamcommunity.com/id/" . $id . "/inventory/json/" . $app . "/2/";
    $res = file_get_contents($url);
    $data = json_decode($res, true);
    return $data["rgDescriptions"];
}

$items = getUserInventory("m0nty_tv");

```

## Steam API Example

``` php
<?php
// Steam ID of user
$id = "m0nty_tv";

// Get JSON Data from Steam API
$json = file_get_contents("http://steamcommunity.com/id/".$id."/inventory/json/730/2/");

// Convert JSON string to array
$data = json_decode($json, true);

// Get the array of items
$items = $data["rgDescriptions"];

// Log a list of the items
foreach($items as $item) {
    echo $item["name"] . "<br>";
}
```

```
XM1014 | Blue Spruce
Dual Berettas | Contractor
PP-Bizon | Urban Dashed
MP7 | Army Recon
SCAR-20 | Sand Mesh
G3SG1 | Desert Storm
MAG-7 | Metallic DDPAT
Operation Vanguard Weapon Case
Huntsman Weapon Case
MP9 | Dart
Operation Breakout Weapon Case
AK-47 | Redline
M4A1-S | Guardian
Souvenir MAG-7 | Irradiated Alert
P250 | Supernova
StatTrak™ Galil AR | Blue Titanium
Operation Vanguard Challenge Coin
```

### $item

In the example, you can use any of the following attributes.

``` php
<?php

// Instead of
foreach($items as $item) {
    echo $item["name"] . "<br>";
}

// You could use
foreach($items as $item) {
    echo "<img src='http://cdn.steamcommunity.com/economy/image/" . $item["icon_url_large"] . "'><br>";
}

// Please note that images must have "http://cdn.steamcommunity.com/economy/image/" prepended before $item["icon_url_large"]
```

```
appid
classid
instanceid
icon_url
icon_url_large
icon_drag_url
name
market_hash_name
market_name
name_color
background_color
type
tradable
marketable
commodity
market_tradable_restriction
descriptions
actions
market_actions
tags
```
