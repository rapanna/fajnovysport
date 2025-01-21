<?php $intro = get_field('fp_promo' , 'option'); ?>
<section class="block block__grey">
    <div class="block__container">
        <div class="block__item">
        <?php
        if ($intro) {
            echo '<h2><strong>' . esc_html($intro['title']) . '</strong> ' . esc_html($intro['text'])  . '</h2>'; 
        }
        ?>
        </div>
        <div class="block__item block__item--bubliny">
            <?php
                if (!empty($intro['img'])) {
                    $img_url = $intro['img']['url'];
                    $img_alt = $intro['img']['alt'];
                    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($img_alt) . '">';
                }
            ?>
        </div>
    </div>
</section>