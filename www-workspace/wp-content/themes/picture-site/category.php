
<?php get_header(); ?>

<div class="row">

    <div class="col-sm-8 blog-main">
        <?php
            $oCurrentCategory = get_category(get_query_var('cat'));
            $iCategoryId = $oCurrentCategory->cat_ID;
        ?>

        <h2>category: <?php echo $oCurrentCategory->name; ?></h2>

        <?php
            $args = array( 'post_type' => 'ps_gallery', 'posts_per_page' => -1, 'cat' => $iCategoryId );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
                echo '<a href="',the_permalink(),'">',the_title(),'</a>';
                echo '<br/><br/>';
            endwhile;
        ?>

    </div> <!-- /.blog-main -->

</div> <!-- /.row -->

<?php get_footer(); ?>