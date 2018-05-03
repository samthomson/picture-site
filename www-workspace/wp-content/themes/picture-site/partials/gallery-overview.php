<?php

    $sqlCategories = "
    select wp_term_taxonomy.term_id, wp_term_taxonomy.parent, wp_term_taxonomy.count, wp_terms.name, wp_terms.slug from wp_terms
    right join wp_term_taxonomy  on wp_term_taxonomy.term_id = wp_terms.term_id
    where wp_term_taxonomy.taxonomy = 'category'
    ";
    $aoCategories = $wpdb->get_results($sqlCategories);
    

    $saCatIDs = [];

    if (isset($iCategoryId)) {
        // we're on a category page
        $saCatIDs = catIDs($iCategoryId, $aoCategories);
        array_push($saCatIDs, $iCategoryId);
    } else {
        array_push($saCatIDs, 0);
        $saCatIDs = catIDs(0, $aoCategories);
    }
    
    $sqlPosts = "
    select wp_posts.ID, wp_posts.post_title, wp_posts.post_name, wp_term_relationships.term_taxonomy_id as category, wp_postmeta.meta_value as thumb_id from wp_posts 
    left join wp_term_relationships on wp_posts.ID = wp_term_relationships.object_id
    join wp_postmeta on wp_posts.ID = wp_postmeta.post_id
    where wp_posts.post_type='ps_gallery' and wp_posts.post_status='publish' 
    and wp_postmeta.meta_key='_thumbnail_id'
    and wp_term_relationships.term_taxonomy_id IN (". implode(',', $saCatIDs). ")";

    $aoPosts = $wpdb->get_results($sqlPosts);

    // iterate through posts
    $aPostTree = [];
    foreach($aoPosts as $oPost) {
        $iCategory = $oPost->category;
        
        $aPost = [
            'type' => 'gallery',
            'id' => $oPost->ID,
            'title' => $oPost->post_title,
            'thumb_id' => $oPost->thumb_id,
            'slug' => array_merge(catSlugs($iCategory, [], $aoCategories), [$oPost->post_name])
        ];
        array_push($aPostTree, $aPost);
    }

    function catSlugs($iCat, $aInitialSlugs = [], $aoCategories) {
        foreach($aoCategories as $oCategory) {
            if ($oCategory->term_id == $iCat) {
                array_push($aInitialSlugs, $oCategory->slug);
            
                return array_merge(
                    catSlugs(
                        $oCategory->parent,
                        [],
                        $aoCategories
                    ),
                    $aInitialSlugs
                );
            }
        }
        return $aInitialSlugs;
    }
    function catIDs($iCat, $aoCategories) {
        $aNewIds = [];
        foreach($aoCategories as $oCategory) {
            if ($oCategory->parent == $iCat) {
                array_push($aNewIds, $oCategory->term_id);
            
                // look for children
                $aNewIds = array_merge(
                    catIDs(
                        $oCategory->term_id,
                        $aoCategories
                    ),
                    $aNewIds
                );
            }
        }
        return $aNewIds;
    }

    displayColumns($aPostTree);

    function displayColumns($aCategories) {
        // split into columns
        $aaColumns = [[],[],[]];
        for($cCategory = 0; $cCategory < count($aCategories); $cCategory++) {
            array_push($aaColumns[$cCategory % 3], $aCategories[$cCategory]);
        }

        echo '<div class="column-layout">';
        foreach($aaColumns as $aColumn) {
            echo '<div class="single-column"><div class="column-inlet">';
            foreach($aColumn as $aCategory) {
                if ($aCategory['type'] == 'gallery') {
                    $sUrl = '/pictures/' . implode('/', $aCategory['slug']) . '/';
                    echo '<a href="', $sUrl,'" class="category-gallery-link">';
                    echo '<img src="', wp_get_attachment_image_url($aCategory['thumb_id'], 'medium'), '" /><br/>';
                    echo  $aCategory['title'], '</a>';
                }else{
                    echo 'not a match';
                }
            }
            echo '</div></div>';
        }
        echo '</div>';
    }
