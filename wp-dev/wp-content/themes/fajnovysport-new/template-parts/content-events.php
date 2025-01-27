<section class="news">
    <ul class="news__list" role="list">
        <?php
        $args = [
        	"post_type" => "post",
        	"posts_per_page" => 4,
        	"category_name" => "akce",
        	"meta_key" => "datum_konani",
        	"orderby" => "meta_value",
        	"order" => "DESC",
        ];

        $query = new WP_Query($args);

        $days_of_the_week = [
        	"Monday" => "Pondělí",
        	"Tuesday" => "Úterý",
        	"Wednesday" => "Středa",
        	"Thursday" => "Čtvrtek",
        	"Friday" => "Pátek",
        	"Saturday" => "Sobota",
        	"Sunday" => "Neděle",
        ];

        if ($query->have_posts()):
        	while ($query->have_posts()):

        		$query->the_post();
        		$date_start = get_field("datum_konani");
        		?>
                <li class="news__item">
                    <a href="<?php the_permalink(); ?>" class="news__link event-link">
                        <img src="<?php echo get_the_post_thumbnail_url(
                        	get_the_ID(),
                        	"thumb-event"
                        ); ?>" alt="" />

                        <?php if ($date_start): ?>
                            <time datetime="<?php echo esc_attr(
                            	$date_start
                            ); ?>" class="item__time">
                                <span class="item__day"><?php echo $days_of_the_week[
                                	date("l", strtotime($date_start))
                                ]; ?></span>
                                <span class="item__date"><?php echo date(
                                	"d.m.Y",
                                	strtotime($date_start)
                                ); ?></span>
                            </time>
                        <?php endif; ?>

                        <h2 class="item__title"><?php the_title(); ?></h2>
                    </a>
                </li>
                <?php
        	endwhile;
        	wp_reset_postdata();
        else:
        	echo "<li>Žádné příspěvky nebyly nalezeny.</li>";
        endif;
        ?>
    </ul>
    <div class="news__more">
        <a href="<?php echo esc_url(
        	get_category_link(get_cat_ID("akce"))
        ); ?>" class="news__link button">Zobrazit více akcí</a>
    </div>
</section>
