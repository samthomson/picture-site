
<?php get_header(); ?>

<div id="nav-content-row">
    <div id="nav">
        <?php get_template_part('partials/side', 'menu'); ?>
    </div>
    <div id="content">
        <?php
            // are we on a 'normal page' - came here from index.php
            if (isset($bFromIndex)) {
                if (have_posts()) {
                    while (have_posts()) : the_post();
                        get_template_part('content', get_post_format());
                    endwhile;
                }else {
                    echo '<div class="page-title">404 - page not found</div>';
                }
            } else {
                if (isset($POST_ID)) {
                    // category overview
                    echo '<div class="page-title">', $sGalleryTitle, '</div>';
                    get_template_part('partials/gallery', 'content');
                } else {
                    if (isset($sGalleryTitle)) {
                        echo '<div class="page-title">', $sGalleryTitle, '</div>';
                    }
                    get_template_part('partials/gallery', 'overview');
                }
            }
        ?>
    </div>
</div>

<?php get_footer(); ?>