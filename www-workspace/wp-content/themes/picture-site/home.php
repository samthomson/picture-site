
<?php get_header(); ?>

<?php

    $oCurrentCategory = get_category(get_query_var('cat'));
    $iCategoryId = $oCurrentCategory->cat_ID;

    set_query_var('iCategoryId', $iCategoryId);
    get_template_part('partials/nav', 'content');
?>

<?php get_footer(); ?>