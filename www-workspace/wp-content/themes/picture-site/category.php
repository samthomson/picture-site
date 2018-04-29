
<?php get_header(); ?>

<div class="row">
    <div class="col-sm-8 blog-main">
        <?php
            $oCurrentCategory = get_category(get_query_var('cat'));
            $iCategoryId = $oCurrentCategory->cat_ID;
        ?>

        <?php
            set_query_var('iCategoryId', $iCategoryId);
            set_query_var('sGalleryTitle', $oCurrentCategory->name);
            get_template_part('partials/nav', 'content');
        ?>

    </div> <!-- /.blog-main -->
</div> <!-- /.row -->

<?php get_footer(); ?>