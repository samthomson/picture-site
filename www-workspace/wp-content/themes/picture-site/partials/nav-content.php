
    <div id="nav-content-row">
        <div id="nav">
            <?php get_template_part('partials/side', 'menu'); ?>
        </div>
        <div id="content">

            <?php
                if (isset($POST_ID)) {
                    get_template_part('partials/gallery', 'content');
                } else {
                    get_template_part('partials/gallery', 'overview');
                }
            ?>
        </div>
    </div>