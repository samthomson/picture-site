<?php

    $sqlCategories = "
    select wp_term_taxonomy.term_id, wp_term_taxonomy.parent, wp_term_taxonomy.count, wp_terms.name, wp_terms.slug from wp_terms
    right join wp_term_taxonomy  on wp_term_taxonomy.term_id = wp_terms.term_id
    where wp_term_taxonomy.taxonomy = 'category'
    ";

    $sqlPosts = "
    select wp_posts.ID, wp_posts.post_title, wp_posts.post_name, wp_term_relationships.term_taxonomy_id as category, wp_postmeta.meta_value as thumb_id from wp_posts 
    left join wp_term_relationships on wp_posts.ID = wp_term_relationships.object_id
    join wp_postmeta on wp_posts.ID = wp_postmeta.post_id
    where wp_posts.post_type='ps_gallery' and wp_posts.post_status='publish' 
    and wp_postmeta.meta_key='_thumbnail_id'
    and wp_term_relationships.term_taxonomy_id=". $iCategoryId;

    $aoCategories = $wpdb->get_results($sqlCategories);
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

    _displayTree($aPostTree);

    function _displayTree($aPostBranch) {
        echo '<ul>';
        foreach($aPostBranch as $aPost) {
            if ($aPost['type'] == 'gallery') {
                $sUrl = '/pictures/' . implode('/', $aPost['slug']);
                echo '<a href="', $sUrl,'" class="gallery-link">';
                echo '<img src="', wp_get_attachment_image_url($aPost['thumb_id'], 'medium'), '" /><br/>';
                echo  $aPost['title'], '</a>';
            }else{
                echo 'not a match';
            }
        }
        echo '</ul>';
    }
