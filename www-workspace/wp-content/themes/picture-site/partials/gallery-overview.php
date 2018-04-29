<?php

    $args = array('post_type' => 'ps_gallery', 'posts_per_page' => -1, 'cat' => $iCategoryId);

    $loop = new WP_Query($args);

    while ($loop->have_posts()) : $loop->the_post();
        echo '<a href="',the_permalink(),'" class="gallery-link">';
        echo the_post_thumbnail('medium'), '<br/>';
        echo the_title(), '</a>';
    endwhile;
    