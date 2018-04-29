
<?php get_header(); ?>

<div class="row">
    <div class="col-sm-8 blog-main">
        <?php
            $oCurrentCategory = get_category(get_query_var('cat'));
            $iCategoryId = $oCurrentCategory->cat_ID;
        ?>

        <h2>category: <?php echo $oCurrentCategory->name; ?></h2>

        <?php set_query_var('iCategoryId', $iCategoryId);get_template_part('partials/side', 'menu'); ?>

    </div> <!-- /.blog-main -->
</div> <!-- /.row -->

<?php get_footer(); ?>