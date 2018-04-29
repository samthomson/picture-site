<ul>
    <li><a href="/about">about</a></li>
</ul>

<ul>
<?php

    $args = array(
        'post_type' => 'ps_gallery',
        'posts_per_page' => -1,
        'cat' => $iCategoryId
    );

    $loop = new WP_Query($args);

    while ($loop->have_posts()) : $loop->the_post();
        echo '<a href="',the_permalink(),'"><li>', the_title(), '</li></a>';
    endwhile;

?>
</ul>