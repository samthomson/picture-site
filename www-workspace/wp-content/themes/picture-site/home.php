
<?php get_header(); ?>

<div class="row">

    <div class="col-sm-8 blog-main">
        <?php
            $oCurrentCategory = get_category(get_query_var('cat'));
            $iCategoryId = $oCurrentCategory->cat_ID;
            echo 'cat id: '.$iCategoryId;
        ?>

        <h2>category: <?php echo $oCurrentCategory->name; ?></h2>

        <?php displayMenu($iCategoryId); ?>

    </div> <!-- /.blog-main -->

</div> <!-- /.row -->

<?php get_footer(); ?>