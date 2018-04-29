
<?php get_header(); ?>

<div class="row">

    <div class="col-sm-8 blog-main">

        <?php
            set_query_var('sGalleryTitle', get_the_title());
            set_query_var('POST_ID', get_the_ID());
            get_template_part('partials/nav', 'content');
        ?>


    </div> <!-- /.blog-main -->

</div> <!-- /.row -->

<?php get_footer(); ?>