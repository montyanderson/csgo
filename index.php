<?php
//$id = str_replace("/", "", $_SERVER["QUERY_STRING"]);
$id = '';//players steam id
$appid = '730';//steam appid to get inventory of (730 is CSGO)
$api_key = '';//your steam api key
$image = 1;//1 = shows players steam avatar 0 = no avatar
//profile function gets basics from players profile
function profile($steamid)
{
    global $api_key;
    $data = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . $api_key . "&steamids=" . $steamid . ""));
    $main = $data->response->players[0];
    $name = $main->personaname;
    $profileurl = $main->profileurl;
    $avatar = $main->avatarfull;
    return array('name' => $name,  'profileurl' => $profileurl, 'avatar' => $avatar);
}
//gameid_name function gets the actual game name from appid number
function gameid_name($appid)
{
    $data = json_decode(file_get_contents("https://api.steampowered.com/ISteamApps/GetAppList/v0001/"), true);
    foreach ($data['applist']['apps']['app'] as $theentity2) {
        $appid1 = $theentity2['appid'];
        $name = $theentity2['name'];
        if ($appid1 == $appid) {
            return $name;
        } else {
        };
    };
}
$data = json_decode(file_get_contents("http://steamcommunity.com/profiles/".$id."/inventory/json/".$appid."/2/"), true);
if(!$data) {
    $id = false;
    exit();
}
$items = $data["rgDescriptions"];
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title><?php echo profile($id)['name']; ?>'s <?php echo gameid_name($appid); ?>  Inventory</title>

    <style>
        @import url(http://fonts.googleapis.com/css?family=Open+Sans);

        body {
            background-color: #1b2838;
            color: white;
            font-family: "Open Sans";
            text-align: center;
        }

        a {
            color: inherit !important;
        }

        h1 {
            text-align: center;
            font-size: 4em;
        }

        strong {
            font-size: 1.5em;
        }

        section#items {
            width: 80%;
            margin-left: 10%;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 14px #030303 inset;
        }

        .item {
            width: 18%;
            margin: 5px;
            transition: 0.2s opacity;
        }

        .item:hover {
            opacity: 0.5;
        }

        .item.stattrack {
            border: 5px solid orange;
            border-radius: 5px;
        }
    </style>

</head>
<body>

<h1><?php echo profile($id)['name']; ?>'s <?php echo gameid_name($appid); ?>  Inventory</h1>
<?php if ($image == 1) {?><a href="<?php echo profile($id)['profileurl'];?>"><img src="<?php echo profile($id)['avatar'];?>"></a><?php } else {} ?>
<h4>Built by <a href="http://github.com/montyanderson">@montyanderson</a></h4>

<section id="items">
    <?php
    foreach($items as $item) {
        $image_url = "http://cdn.steamcommunity.com/economy/image/";

        if($item["icon_url_large"]) {
            $image_url = $item["icon_url_large"];
        } else {
            $image_url = $item["icon_url"];
        }

        $hash = str_replace("+", "%20", urlencode($item["market_hash_name"]));
        echo "<a href='http://steamcommunity.com/market/listings/730/$hash'>" . PHP_EOL;
        echo "<img class='item";
        if(substr($item["name"], 0, 4) == "Stat") echo " stattrack ";
        echo "' src='http://cdn.steamcommunity.com/economy/image/$image_url' />";
        echo "</a>" . PHP_EOL;

        echo PHP_EOL;
    }
    ?>
</section>
</body>
</html>