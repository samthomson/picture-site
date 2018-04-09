
<?php get_header(); ?>

<hr/>

<h2>index.php</h2>

<?php 
    if ( have_posts() ) : while ( have_posts() ) : the_post();

        get_template_part( 'content', get_post_format() );

    endwhile; endif; 
?>

<hr/>

<?php get_footer(); ?>