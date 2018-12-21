
<?php
    $sTitle = get_bloginfo('name');
    $sClass = '';
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
            // gallery page
            $sTitle = $sGalleryTitle;
            $sClass = 'gallery-page';
        } else {
            $sClass = 'category-page';
            if (isset($sGalleryTitle)) {
                // category overview
                $sTitle = $sGalleryTitle;
            }
        }
    }
?>


<?php set_query_var('sTitle', $sTitle);get_header(); ?>

<div class="row">
    <a href="/" id="home-link">
        <span id="name">Sam Thomson</span>
        <span id="tagline">travel pictures</span>
    </a> 
</div>
<div class="row nav-content">
    <div id="nav">
        <?php get_template_part('partials/side', 'menu'); ?>
    </div>
    <div id="content" class="<?php echo $sClass; ?>">
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