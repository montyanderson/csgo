<?php
$id = str_replace("/", "", $_SERVER["QUERY_STRING"]);
$query = "http://steamcommunity.com/id/".$id."/inventory/json/730/2/";
$json = file_get_contents($query);
$data = json_decode($json, true);

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
		<title><?php echo $id ?>'s Profile</title>

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

		<h1><strong><?php echo $id; ?></strong>'s Profile</h1>

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
