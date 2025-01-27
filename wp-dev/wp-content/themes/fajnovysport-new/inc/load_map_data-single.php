<?php
header("Content-type:application/json;charset=utf-8");
require_once "../../../../wp-config.php";
$id = $_GET["id"];
$args = [
	"p" => $id,
	"post_type" => "any",
];

$data = (object) [];

$single_query = new WP_Query($args);
if ($_GET["type"] != "JSON") {
	// WP load single
	if ($single_query->have_posts()) {
		while ($single_query->have_posts()) {
			$single_query->the_post();
			$data->title = get_the_title();

			$typsportu = get_the_terms(get_the_ID(), "typsportu");

			//typy sportu
			$i = 0;
			foreach ($typsportu as $sport) {
				$tax_id = $sport->taxonomy . "_" . $sport->term_id;
				$sport_image_name = get_field("obrazek_sportu", $tax_id);
				if (empty($sport_image_name)) {
					$data->cathegories[$i++] =
						get_template_directory_uri() . "/img/default_icon.png";
				} else {
					$data->cathegories[$i++] =
						get_template_directory_uri() .
						"/img/ikony-sportu/" .
						$sport_image_name .
						".svg";
				}
			}

			//typy sportu nazvy
			$i = 0;
			foreach ($typsportu as $sport) {
				$sport_title = $sport->name;
				$data->cathegoriesTitle[$i++] = $sport_title;
			}

			//featured image
			$featuredImage = get_the_post_thumbnail_url(
				get_the_id(),
				"cahtegory-thumbnail"
			);
			$data->featuredImage = $featuredImage;

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

			//content
			$data->content = get_the_content();

			//datum akce
			$datum_akce = get_field("datum_akce");
			$data->datum_akce = $datum_akce;

			//datum akce konec
			$datum_akce_konec = get_field("datum_akce_konec");
			$data->datum_akce_konec = $datum_akce_konec;

			//www
			$www = get_field("www");
			if (empty($www)) {
				$data->www = " - ";
			}
			$data->www = $www;

			//galerie
			if (have_rows("galerie", get_the_id())) {
				$i = 0;
				$data->images = [];
				while (have_rows("galerie", get_the_id())) {
					the_row();
					$data->images[$i++] = get_sub_field("obrazek");
				}
			}
		}
	}
} else {
	// JSON load single
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

	$terms = get_terms([
		"taxonomy" => "typsportu",
		"hide_empty" => false,
	]);

	$sports = [];
	foreach ($terms as $term) {
		array_push($sports, $term->name);
	}

	$final_sports = [];
	$final_sports_noimg = [];

	foreach ($feateures as $sportoviste) {
		$data_sportoviste = $sportoviste["attributes"];
		if ($data_sportoviste["objectid"] == (int) $id) {
			//    var_dump($data_sportoviste);

			$typy_sportu = $data_sportoviste["typy_sportu"];

			$sporty_list = explode("; ", $typy_sportu);

			$j = 0;
			foreach ($sporty_list as $sport) {
				$sporty_list[$j] = str_replace(";", "", $sport);
				$j++;
			}

			$compareArraySports = array_map("strtolower", $sports);

			//var_dump($sporty_list);
			foreach ($sporty_list as $sport) {
				$s = strtolower($sport);
				//var_dump($s);
				//if($sport == ''){continue;}
				if (in_array($s, $compareArraySports)) {
					if (!empty($sport)) {
						$terms = get_term_by("name", $sport, "typsportu");
						//var_dump($terms);
						if ($terms) {
							array_push($final_sports, $terms);
						}
					}
				} else {
					if (!empty($sport)) {
						array_push($final_sports_noimg, $sport);
					}
				}
			}

			$i = 0;

			$data->Data[$i] = (object) [];
			$data->Data[$i]->PostID = $data_sportoviste["objectid"];
			$data->Data[$i]->dataLoadedFrom = "json";
			$data->Data[$i]->title = $data_sportoviste["nazev"];
			$data->Data[$i]->typ = $data_sportoviste["typ"];
			$data->Data[$i]->www = $data_sportoviste["web"];
			$j = 0;
			foreach ($final_sports as $sport) {
				$tax_id = $sport->taxonomy . "_" . $sport->term_id;
				$sport_image_name = get_field("obrazek_sportu", $tax_id);

				if (empty($sport_image_name)) {
					$data->Data[$i]->cathegories[$j] =
						get_template_directory_uri() . "/img/default_icon.png";
				} else {
					$data->Data[$i]->cathegories[$j] =
						get_template_directory_uri() .
						"/img/ikony-sportu/" .
						$sport_image_name .
						".svg";
				}
				$sport_title = $sport->name;
				$data->Data[$i]->cathegoriesTitle[$j] = $sport_title;
				$j++;
			}
			foreach ($final_sports_noimg as $sport) {
				$data->Data[$i]->cathegories[$j] =
					get_template_directory_uri() . "/img/default_icon.png";
				$sport_title = $sport;
				$data->Data[$i]->cathegoriesTitle[$j] = $sport_title;
				$j++;
			}
			$data->Data[$i]->latitude = $data_sportoviste["wgs_x"];
			$data->Data[$i]->longitude = $data_sportoviste["wgs_y"];
			$data->Data[$i]->marker_style = "marker--sportoviste";
			$data->Data[$i]->address = $data_sportoviste["adresa"];
			$data->Data[$i]->content = $data_sportoviste["pozn_fajnovysport"];
			$data->Data[$i]->thubmnail = null;
			$data->Data[$i]->thubmnailMap = null;
			//var_dump($data_sportoviste);
			if (!empty($data_sportoviste["fotka1"])) {
				$foto_1 = $data_sportoviste["fotka1"];
			}
			if (!empty($data_sportoviste["fotka2"])) {
				$foto_2 = $data_sportoviste["fotka2"];
			}

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

			if (!empty($foto_2) && empty($data->Data[$i]->thubmnail)) {
				$data->Data[$i]->thubmnail = $foto_2;
			} else {
				$data->Data[$i]->thubmnail =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}

			if (!empty($foto_2)) {
				$data->Data[$i]->thubmnailMap = $foto_1;
			} else {
				$data->Data[$i]->thubmnailMap =
					get_template_directory_uri() . "/img/basic-image-icon.png";
			}
			$i++;
		}
	}
}
echo json_encode($data, true);
?>
