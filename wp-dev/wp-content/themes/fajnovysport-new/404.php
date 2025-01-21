<?php get_header(); ?>



<section class="block">
    <div class="block__container d-block my-404 text-center">
            <h1><?php _e('Stránka nenalezena', 'wpde'); ?></h1>
        <p class="mb-4"><?php _e('Omlouváme se, ale nemohli jsme najít stránku, kterou hledáte.', 'wpde'); ?></p>  
        <a href="<?php echo home_url(); ?>" class="news__link button"><?php _e('Vraťte se zpět domů', 'wpde'); ?></a>     
    </div>
</section>

<?php get_footer(); ?>
