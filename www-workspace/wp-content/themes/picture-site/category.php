

<?php
    $oCurrentCategory = get_category(get_query_var('cat'));
    $iCategoryId = $oCurrentCategory->cat_ID;
    
    set_query_var('iCategoryId', $iCategoryId);
    set_query_var('sGalleryTitle', $oCurrentCategory->name);
    get_template_part('partials/nav', 'content');
?>
