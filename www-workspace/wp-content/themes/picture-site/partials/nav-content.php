
<?php
    $sTitle = get_bloginfo('name');
    // are we on a 'normal page' - came here from index.php
    if (isset($bFromIndex)) {
        if (have_posts()) {
            while (have_posts()) : the_post();
                $sTitle = get_the_title();
            endwhile;
        } else {
            $sTitle = '404 - page not found';
        }
    } else {
        if (isset($POST_ID)) {
            // category overview
            $sTitle = $sGalleryTitle;
        } else {
            if (isset($sGalleryTitle)) {
                $sTitle = $sGalleryTitle;
            }
        }
    }
?>


<?php set_query_var('sTitle', $sTitle);get_header(); ?>

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
                    echo '<div class="page-title">'.$sTitle.'</div>';
                }
            } else {
                if (isset($POST_ID)) {
                    // category overview
                    echo '<div class="page-title">', $sTitle, '</div>';
                    get_template_part('partials/gallery', 'content');
                } else {
                    if (isset($sGalleryTitle)) {
                        echo '<div class="page-title">', $sTitle, '</div>';
                    }
                    get_template_part('partials/gallery', 'overview');
                }
            }
        ?>
    </div>
</div>

<?php get_footer(); ?>