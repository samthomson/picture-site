<?php
/*
Template Name: Gallery overview
*/
?>

<?php get_header(); ?>
<h3>gallery overview</h3>

<?php

    $args = array( 'post_type' => 'ps_gallery', 'posts_per_page' => -1 );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
        
        echo '<a href="',the_permalink(),'">',the_title(),'</a>';
        echo '<br/><br/>';
    endwhile;


?>

<?php get_footer(); ?>