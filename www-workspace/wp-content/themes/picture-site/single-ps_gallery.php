
<?php get_header(); ?>


<?php
    set_query_var('sGalleryTitle', get_the_title());
    set_query_var('POST_ID', get_the_ID());
    get_template_part('partials/nav', 'content');
?>

<?php get_footer(); ?>