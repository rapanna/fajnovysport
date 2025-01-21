<?php $intro = get_field('fp_intro' , 'option'); ?>
<section class="advertising">
    <div class="advertising__azure"></div>
    <div class="advertising__red"></div>
    <div class="advertising__green"></div>
    <div class="advertising__info">
        <div class="advertising__text">
        <?php
        if ($intro) {
            echo '<h2 class="advertising__title">' . esc_html($intro['title']) . '</h2>'; 
            echo '<p>' . esc_html($intro['text']) . '</p>';
        }
        ?>
        </div>
        <div class="advertising__athletic"></div>
    </div>
</section>