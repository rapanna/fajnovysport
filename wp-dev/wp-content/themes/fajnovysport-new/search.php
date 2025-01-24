<?php get_header(); ?>
        <section class="block">
            <div class="block__container flex-column">
                <h1 class="title title--h1 title--top"><?php single_cat_title(); ?></h1>
                <div class="category-wrap">
                <?php
                $categories = get_the_category();
                $category_id = $categories[0]->cat_ID;
                $paged = get_query_var("paged") ? get_query_var("paged") : 1;
                $args = [
                	"post_type" => "post",
                	"posts_per_page" => 1,
                	"cat" => [$category_id],
                	"paged" => $paged,
                ];
                $cat_query = new WP_Query($args);

                if (have_posts()) {
                	while (have_posts()) {
                		the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="no-decoration">
                            <div class="category-card">
                                <div>
                                    <?php if (has_post_thumbnail()) {
                                    	the_post_thumbnail("large");
                                    } else {
                                    	 ?><img src="<?php echo get_template_directory_uri(); ?>/img/news-small-basic-single.jpg" class="" alt="<?php the_title(); ?>" /><?php
                                    } ?>
                                </div>

                                <div class="category-meta">
                                    <h3 class="category-card-title"><?php the_title(); ?></h3>
                                    <small><?php echo get_the_excerpt(); ?></small>
                                </div>
                            </div>
                            </a>
                        <?php
                	} ?>

                <?php
                echo '<div class="category-pagination">';
                echo paginate_links();
                echo "</div>";
                ?>
            <?php
                }
                ?>
    <?php  ?>
   </div>
   </div>
</section>
<?php get_footer(); ?>
