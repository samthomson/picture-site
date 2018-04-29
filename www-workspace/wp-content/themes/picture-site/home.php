
<?php get_header(); ?>

<div id="nav-content-row">

    <div id="nav">
        <?php
            $oCurrentCategory = get_category(get_query_var('cat'));
            $iCategoryId = $oCurrentCategory->cat_ID;
        ?>

        <h2>category: <?php echo $oCurrentCategory->name; ?></h2>

        <?php get_template_part('partials/side', 'menu'); ?>

    </div>

    <div id="content">

        <?php get_template_part('partials/gallery', 'overview'); ?>

    </div>

</div>

<?php get_footer(); ?>