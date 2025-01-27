<?php
/* Template Name: Mapa */
?>
<?php get_header("mapa"); ?>
<style>
.marker--sportoviste {
    background-image: url(<?php echo get_template_directory_uri(); ?>/_statika/img/marker-sportoviste.png);
    background-size: cover;
    width: 27px;
    height: 45px;
    margin-top: -22px;
    cursor: pointer;
}
.marker--kluby {
    background-image: url(<?php echo get_template_directory_uri(); ?>/_statika/img/marker-kluby.png);
    background-size: cover;
    width: 27px;
    height: 45px;
    margin-top: -22px;
    cursor: pointer;
}
</style>
<?php if (have_posts()) {
	while (have_posts()) {

		the_post();
		the_content();
		?>
        <section class="sec sec--selectmapa">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-sm-9">

                        <div class="select">
                            <?php
                            $categories = get_terms([
                            	"taxonomy" => "typsportu",
                            	"hide_empty" => false,
                            ]);
                            $max_priority_sports = 15;
                            $current_priority_sports = 1;
                            if (!empty($categories) && is_array($categories)) {
                            	foreach ($categories as $category) { ?>

                                    <?php
                            		/* Primární sporty */
                            		?>
                                    <?php if (
                                    	$current_priority_sports <=
                                    	$max_priority_sports
                                    ) {
                                    	$categoryID =
                                    		"category_" . $category->term_id;
                                    	$display = get_field(
                                    		"zobrazit_na_webu",
                                    		$categoryID
                                    	);
                                    	if ($display) {
                                    		$sport_image_name = get_field(
                                    			"obrazek_sportu",
                                    			$categoryID
                                    		);
                                    		if (empty($sport_image_name)) {
                                    			$url =
                                    				get_template_directory_uri() .
                                    				"/img/svg/ostatni.svg";
                                    		} else {
                                    			$url =
                                    				get_template_directory_uri() .
                                    				"/img/ikony-sportu/" .
                                    				$sport_image_name .
                                    				".svg";
                                    		}
                                    		$priority = get_field(
                                    			"prioritni_sport",
                                    			$categoryID
                                    		);
                                    		$sport_title = $category->name;
                                    		if ($priority) {
                                    			$current_priority_sports++; ?>
                                                <img src="<?php echo $url; ?>" class="sport_icon"  width="69"
                                                    height="70" alt="<?php echo $sport_title; ?>"
                                                    onclick="addSport(this)"
                                                    data-sport-title="<?php echo $sport_title; ?>" title="<?php echo $sport_title; ?>">
                                                <?php
                                    		}
                                    	}
                                    }} ?><br>
                                <div id="more_sports--div">
                                    <?php
                            	/* Další sporty */
                            	?>
                                    <?php foreach (
                                    	$categories
                                    	as $category
                                    ) { ?>
                                        <?php
                                        $categoryID =
                                        	"category_" . $category->term_id;
                                        $display = get_field(
                                        	"zobrazit_na_webu",
                                        	$categoryID
                                        );
                                        if ($display) {
                                        	$sport_image = get_field(
                                        		"obrazek_sportu",
                                        		$categoryID
                                        	);
                                        	$priority = get_field(
                                        		"prioritni_sport",
                                        		$categoryID
                                        	);
                                        	$sport_title = $category->name;
                                        	$sport_image_name = get_field(
                                        		"obrazek_sportu",
                                        		$categoryID
                                        	);
                                        	if (empty($sport_image_name)) {
                                        		$url =
                                        			get_template_directory_uri() .
                                        			"/img/svg/ostatni.svg";
                                        	} else {
                                        		$url =
                                        			get_template_directory_uri() .
                                        			"/img/ikony-sportu/" .
                                        			$sport_image_name .
                                        			".svg";
                                        	}
                                        	if (!$priority) { ?>
                                                <img src="<?php echo $url; ?>" class="sport_icon" width="69"
                                                    height="70" alt="<?php echo $sport_title; ?>"
                                                    onclick="addSport(this)"
                                                    data-sport-title="<?php echo $sport_title; ?>" title="<?php echo $sport_title; ?>">
                                                <?php }
                                        }
                                        } ?>
                                    <?php
                            	/* Skryté sporty */
                            	?>
                                    <?php foreach (
                                    	$categories
                                    	as $category
                                    ) { ?>
                                        <?php
                                        $categoryID =
                                        	"category_" . $category->term_id;
                                        $display = get_field(
                                        	"zobrazit_na_webu",
                                        	$categoryID
                                        );
                                        if (!$display) {

                                        	$sport_image = get_field(
                                        		"obrazek_sportu",
                                        		$categoryID
                                        	);
                                        	$priority = get_field(
                                        		"prioritni_sport",
                                        		$categoryID
                                        	);
                                        	$sport_title = $category->name;
                                        	$sport_image_name = get_field(
                                        		"obrazek_sportu",
                                        		$categoryID
                                        	);
                                        	$url =
                                        		get_template_directory_uri() .
                                        		"/img/ikony-sportu/" .
                                        		$sport_image_name .
                                        		".svg";
                                        	?>
                                                <img src="<?php echo $url; ?>" class="sport_icon" width="69"
                                                    height="70" alt="<?php echo $sport_title; ?>"
                                                    onclick="addSport(this)"
                                                    data-sport-title="<?php echo $sport_title; ?>" title="<?php echo $sport_title; ?>" style="display:none">
                                                <?php
                                        }
                                        } ?>
                                </div><?php
                            }
                            ?>
                        </div>

                        <div class="mapa-select" id="selected-sports">
                            <?php foreach ($categories as $category) { ?>
                                    <?php
                                    $categoryID =
                                    	"category_" . $category->term_id;
                                    $sport_image_name = get_field(
                                    	"obrazek_sportu",
                                    	$categoryID
                                    );
                                    $url =
                                    	get_template_directory_uri() .
                                    	"/img/ikony-sportu/" .
                                    	$sport_image_name .
                                    	".svg";
                                    $display = get_field(
                                    	"zobrazit_na_webu",
                                    	$categoryID
                                    );
                                    } ?>
                        </div>


                        <div class="mapa-search">
                            <form class="mapa-search-form">
                                <label for="search-sport" class="mapa-search-form__label"><?php _e(
                                	"Search",
                                	"fajnovysport"
                                ); ?></label>
                                <input id="search-sport" name="search" class="mapa-search-form__input" type="text" placeholder="<?php _e(
                                	"Vyhledat sport",
                                	"fajnovysport"
                                ); ?>" autocomplete="off" />
                                <button id="serach-sport-button" class="search__btn2"><?php _e(
                                	"Odeslat",
                                	"fajnovysport"
                                ); ?></button>
                            </form>
                        </div>

                    </div>
                    <div class="col-md-2 col-sm-3">

                        <div class="mapa-more">
                            <a id="more_sports" class="btn btn--more align-middle"><?php _e(
                            	"Více&nbsp;>>",
                            	"fajnovysport"
                            ); ?></a>
                            <a id="less_sports" class="btn btn--more align-middle"><?php _e(
                            	"<<&nbsp;Méně",
                            	"fajnovysport"
                            ); ?></a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="sec sec--mapa">
            <div class="container-fluid container-fluid--bez container--flex">
                <div class="row no-gutters row--flex">
                   <div class="col-md-5 col-lg-4" id="js-mapa_height">
                        <?php
		/* <div class="mapa-tip" id="mapa-tip">
                             Nacházíte se v sekci Kluby. Pro vyhledávání jiného typu například sportoviště, musíte použít záložku níže
                        </div> */
		?>

                        <div class="mapa-sport">
                            <nav class="mapa-sport-list">
                            <?php $id = $_GET["id"]; ?>
                                <?php if (get_post_type($id) == "kluby") { ?>
                                    <li><a href="#" class="selected" id="clubs"><?php _e(
                                    	"Kluby",
                                    	"fajnovysport"
                                    ); ?></a></li>
                                    <li><a href="#" id="sports_grounds"><?php _e(
                                    	"Sportoviště",
                                    	"fajnovysport"
                                    ); ?></a></li>
                                <?php } elseif (
                                	get_post_type($id) == "sportoviste"
                                ) { ?>
                                    <li><a href="#" id="clubs"><?php _e(
                                    	"Kluby",
                                    	"fajnovysport"
                                    ); ?></a></li>
                                    <li><a href="#" class="selected" id="sports_grounds"><?php _e(
                                    	"Sportoviště",
                                    	"fajnovysport"
                                    ); ?></a></li>
                                <?php } else { ?>
                                    <li><a href="#" class="selected" id="clubs"><?php _e(
                                    	"Kluby",
                                    	"fajnovysport"
                                    ); ?></a></li>
                                    <li><a href="#" id="sports_grounds"><?php _e(
                                    	"Sportoviště",
                                    	"fajnovysport"
                                    ); ?></a></li>
                                 <?php } ?>
                                <?php
		/*<li><a href="#" id="sport_events"><?php _e('Sportovní akce', 'fajnovysport'); ?></a></li>*/
		?>
                            </nav>
                        </div>
                        <div id="loader-left" class="loader loader-left"></div>
                        <div class="mapa-show" id="mapa-show">

                        </div>
                        <div class="mapa-back" id="js-mapa-back">
                            <div class="mapa-back__link js-mapa-back__link" id="js-mapa-back__link" onclick="clearData();updateData();scrollBackToDefault();">Zpět «</div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-8" id="js-mapa_detail">
                        <div id="loader-right" class="loader loader-right"></div>
                        <div class="js-maps maps" id="map" style="width:1200px; height:600px;"></div>
                        <div id="js-menu-map" class="menu-map" style="background: white; z-index: 998; position: absolute; padding: 1rem; border-radius: 4px; margin: 10px 0px 0px 10px;">
                            <label for="streets-v11">Základní</label>
                            <input id="streets-v11" type="radio" name="rtoggle" value="streets"  checked="checked">
                            <label for="satellite-v9">Letecká</label>
                            <input id="satellite-v9" type="radio" name="rtoggle" value="satellite">
                            <label for="outdoors-v11">Cyklistická</label>
                            <input id="outdoors-v11" type="radio" name="rtoggle" value="outdoors">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php
	}
} ?>
<?php get_footer("mapka"); ?>
