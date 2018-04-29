
<?php get_header(); ?>

<div id="nav-content-row">
    <div id="nav">
        <?php get_template_part('partials/side', 'menu'); ?>
    </div>
    <div id="content">

        <?php

            // are we on a 'normal page'
            if ( have_posts() ) {
                while (have_posts()) : the_post();
                    get_template_part('content', get_post_format());
                endwhile;
            } else {
                if (isset($POST_ID)) {
                    echo '<h2>', $sGalleryTitle, '</h2>';
                    get_template_part('partials/gallery', 'content');
                } else {
                    if (isset($sGalleryTitle)) {
                        echo '<h2>', $sGalleryTitle, '</h2>';
                    }
                    get_template_part('partials/gallery', 'overview');
                }
            }
        ?>
    </div>
</div>

<?php get_footer(); ?>