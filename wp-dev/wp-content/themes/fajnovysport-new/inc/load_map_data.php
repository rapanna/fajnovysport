<?php
header("Content-type:application/json;charset=utf-8");
require_once "../../../../wp-config.php";

//Kluby Sportoviste
$typ = ["Sportoviste", "Kluby"];
$sporty = $_GET["sport"]; // Všechny sporty podle zadání z koleček
$typ = $_GET["typ"];
if ($_GET["typ"] != "Sportoviste") {
	if (empty($typ)) {
		$typ = ["Sportoviste", "Kluby"];
	}
	$args = [
		"post_type" => $typ,
		"post_status" => "publish",
		"tax_query" => [
			[
				"taxonomy" => "typsportu",
				"field" => "slug",
				"terms" => $sporty,
			],
		],
		"posts_per_page" => -1,
		"orderby" => "title",
		"order" => "ASC",
	];
	if (empty($sporty)) {
		$args = [
			"post_type" => $typ,
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "title",
			"order" => "ASC",
		];
	}
	//$data = array();
	$data = (object) [];
	$query = new WP_Query($args);
	$i = 0;
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$id = get_the_id();
			$typ = get_post_type();
			$title = get_the_title();
			//vymazani dat
			$latitude = "";
			$longitude = "";
			$address = "";
			$mapbox = "";
			//souradnice + adresa
			if (have_rows("souradnice", get_the_id())) {
				while (have_rows("souradnice", get_the_id())) {
					the_row();
					$address = get_sub_field("label");
					$latitude = get_sub_field("latitude");
					$longitude = get_sub_field("longitude");
				}
			}
			$mapbox = get_field("mapbox");
			//latitude
			if (empty($latitude)) {
				$latitude = $mapbox["lat"];
			}

			//longitude
			if (empty($longitude)) {
				$longitude = $mapbox["lng"];
			}

			//address
			if (empty($address)) {
				$address = $mapbox["address"];
			}
			$data->latitude = $latitude;
			$data->longitude = $longitude;
			$data->address = $address;

			//marker style
			switch ($typ) {
				case "kluby":
					$marker_style = "marker--kluby";
					break;
				case "sportoviste":
					$marker_style = "marker--sportoviste";
					break;
				case "akce":
					$marker_style = "marker--akce";
					break;
				default:
					$marker_style = "marker--sportoviste";
			}
			$link = get_the_permalink(get_the_id()); //link

			//featured image
			$thumbnail = get_the_post_thumbnail_url(
				get_the_id(),
				"cahtegory-thumbnail"
			);
			if (empty($thumbnail)) {
				$thumbnail =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}

			$thumbnail_map = get_the_post_thumbnail_url(
				get_the_id(),
				"map-left"
			); //90x90
			if (empty($thumbnail_map)) {
				$thumbnail_map =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}
			$data->featuredImage = $featuredImage;
			$data->Data[$i] = (object) [];
			$data->Data[$i]->PostID = $id;
			$data->Data[$i]->typ = $typ;
			$data->Data[$i]->dataLoadedFrom = "wp";
			$data->Data[$i]->title = $title;
			$data->Data[$i]->latitude = $latitude;
			$data->Data[$i]->longitude = $longitude;
			$data->Data[$i]->marker_style = $marker_style;
			if (empty($address)) {
				$address = " - ";
			}
			$data->Data[$i]->address = $address;
			$data->Data[$i]->link = $link;
			$data->Data[$i]->thubmnail = $thumbnail;
			$data->Data[$i]->thubmnailMap = $thumbnail_map;
			$data->Data[$i]->mapbox = $mapbox;
			$i++;
		}
	}

	echo json_encode($data, true);
} else {
	$i = 0;

	function generateTokenFajn()
	{
		$ip_url = "81.91.221.244"; // for ovatest,production

		if ($_SERVER["HTTP_HOST"] == "localhost") {
			$ip_url = "81.91.218.170"; // localhost
		}
		$ip_url = "185.5.70.31"; //doma

		ob_start();
		$url = "https://mapy.ostrava.cz/arcgisserver/tokens/generateToken";
		$username = "Ovanet_Sport_us_Edit";
		$password = "E_0VaS@_1v4*qg~_45E!ba";
		$referer = $url;
		$postdata = http_build_query([
			"username" => $username,
			"password" => $password,
			"ip" => $ip_url,
			"client" => "ip",
			"expiration" => "1440",
			"f" => "json",
		]);

		$opts = [
			"http" => [
				"method" => "POST",
				"header" => "Content-Type: application/x-www-form-urlencoded",
				"content" => $postdata,
			],
		];
		$context = stream_context_create($opts);
		$jsonData = json_decode(file_get_contents($url, false, $context));
		return $jsonData->{"token"};
	}
	$url =
		"https://mapy.ostrava.cz/arcgisserver/rest/services/SMO_E/Sportoviste_E_PRO_gZRq52__0L1GDejn7z45__b14__PWRcaRh85_wE/MapServer/0/query?where=1=1&geometryType=esriGeometryEnvelope&spatialRel=esriSpatialRelIntersects&outFields=*&returnGeometry=false&returnTrueCurves=false&returnIdsOnly=false&returnCountOnly=false&returnZ=false&returnM=false&returnDistinctValues=false&returnExtentsOnly=false&f=json&token=" .
		generateTokenFajn();
	$data = file_get_contents($url);
	$data_decoded = json_decode($data, true); // save as associative
	$feateures = $data_decoded["features"];

	$data = (object) [];
	$i = 0;
	foreach ($feateures as $sportoviste) {
		// nastavení fitlu pro fajnový sport
		$show = false;
		$data_sportoviste = $sportoviste["attributes"];
		$web_sidlo = (string) $data_sportoviste["web_sidlo"];
		if (strlen($web_sidlo) == 3) {
			$web_sidlo = "00000" . $web_sidlo;
		} elseif (strlen($web_sidlo) == 2) {
			$web_sidlo = "000000" . $web_sidlo;
		} elseif (strlen($web_sidlo) == 1) {
			$web_sidlo = "0000000" . $web_sidlo;
		} elseif (strlen($web_sidlo) == 0) {
			$web_sidlo = "00000000";
		}
		if (!empty($web_sidlo[7])) {
			if ($web_sidlo[7] == "1") {
				$show = true;
			}
		}
		if ($show == false) {
			continue;
		}
		// nastavení fitlu pro fajnový sport
		$foto_1 = null;
		$foto_2 = null;
		if (!empty($data_sportoviste["fotka1"])) {
			$foto_1 = $data_sportoviste["fotka1"];
		}
		if (!empty($data_sportoviste["fotka2"])) {
			$foto_2 = $data_sportoviste["fotka2"];
		}

		$typy_sportu = $data_sportoviste["typy_sportu"];
		$sporty_list = explode("; ", $typy_sportu);
		$compare_sporty_list = explode("; ", $typy_sportu);
		$j = 0;

		/*    foreach($sporty_list as $sport){
            $sporty_list[$j] = str_replace(";", "", $sport);
            $compare_sporty_list[$j] = $sport;
            $j++;
        }*/

		if ($sporty) {
			$filter_ok = false;
			$sporty = array_map("strtolower", $sporty);
			$compare_sporty_list = array_map(
				"strtolower",
				$compare_sporty_list
			);

			//clean ';'
			for ($l = 0; $l < count($compare_sporty_list); $l++) {
				$compare_sporty_list[$l] = str_replace(
					";",
					"",
					$compare_sporty_list[$l]
				);
			}

			//  var_dump($sporty);
			//  var_dump($compare_sporty_list);

			foreach ($sporty as $s) {
				if (in_array($s, $compare_sporty_list)) {
					$filter_ok = true;
					continue;
				} else {
					$filter_ok = false;
				}
			}
		} else {
			$filter_ok = true;
		}

		//filter empty sporty list
		$sporty_list = array_filter($sporty_list, function ($value) {
			return !is_null($value) && $value !== "";
		});
		for ($m = 0; $m < count($sporty_list); $m++) {
			$sporty_list[$m] = str_replace(";", "", $sporty_list[$m]);
		}

		if ($filter_ok) {
			$data->Data[$i] = (object) [];
			$data->Data[$i]->PostID = $data_sportoviste["objectid"];
			$data->Data[$i]->dataLoadedFrom = "json";
			$data->Data[$i]->typ = "sportoviste";
			$data->Data[$i]->sporty = $sporty_list;
			$data->Data[$i]->title = $data_sportoviste["nazev"];
			$data->Data[$i]->latitude = $data_sportoviste["wgs_y"];
			$data->Data[$i]->longitude = $data_sportoviste["wgs_x"];
			$data->Data[$i]->marker_style = "marker--sportoviste";
			$data->Data[$i]->address = $data_sportoviste["adresa"];
			$data->Data[$i]->link = "";
			if (!empty($foto_1)) {
				$data->Data[$i]->thubmnail = $foto_1;
			} else {
				$data->Data[$i]->thubmnail =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}
			if (!empty($foto_1)) {
				$data->Data[$i]->thubmnailMap = $foto_1;
			} else {
				$data->Data[$i]->thubmnailMap =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}

			if (!empty($foto_2)) {
				$data->Data[$i]->thubmnail = $foto_2;
			} else {
				$data->Data[$i]->thubmnail =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}
			$data->Data[$i]->mapbox = "";
			$i++;
		}
	}
	echo json_encode($data, true);
}
?>
