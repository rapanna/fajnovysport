<section class="block">
    <div class="block__container block__title">
        <h2>V roce <strong>2024</strong> jsme podpořili</h2>
    </div>
    <div class="block__container block__number">
        <?php if (have_rows('fp_numbers', 'option')) : ?>
            <?php while (have_rows('fp_numbers', 'option')) : the_row(); ?>
                <div class="block__item">
                    <h2 class="blocknumber">
                        <span class="blocknumber__number"><?php the_sub_field('number'); ?></span>
                        <span class="blocknumber__title"><?php the_sub_field('title'); ?></span>
                    </h2>
                    <h3 class="blocktext"><?php the_sub_field('text'); ?></h3>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
