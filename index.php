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
$image = "";
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
		}

		h1 {
			text-align: center;
			font-family: "Open Sans";
			font-size: 4em;

		}

		strong {
			font-size: 1.5em;
		}

		section#items {
			width: 80%;
			margin-left: 10%;
			text-align: center;
		}

		.item {
			width: 18%;
			margin: 5px;
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


		<section id="items">
<?php
foreach($items as $item) {
	$image_url = "http://cdn.steamcommunity.com/economy/image/";

	if($item["icon_url_large"]) {
		$image_url = $image_url . $item["icon_url_large"];
	} else {
		$image_url = $image_url . $item["icon_url"];
	}

	$hash = str_replace("+", "%20", urlencode($item["market_hash_name"]));
	echo "<a href='http://steamcommunity.com/market/listings/730/".$hash."'>" . PHP_EOL;
	echo "<img class='item";
	if(substr($item["name"], 0, 4) == "Stat") echo " stattrack ";
	echo "' src='".$image_url."' />";
	echo "</a>" . PHP_EOL;

	echo PHP_EOL;
}
?>
		</section>
	</body>
</html>
