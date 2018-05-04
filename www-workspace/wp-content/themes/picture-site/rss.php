<?php

    $sqlCategories = "
    select wp_term_taxonomy.term_id, wp_term_taxonomy.parent, wp_term_taxonomy.count, wp_terms.name, wp_terms.slug from wp_terms
    right join wp_term_taxonomy  on wp_term_taxonomy.term_id = wp_terms.term_id
    where wp_term_taxonomy.taxonomy = 'category'";

    $aoCategories = $wpdb->get_results($sqlCategories);

    $saCatIDs = [];
    
    $sqlPosts = "
    select wp_posts.ID, wp_posts.post_title, wp_posts.post_name, wp_posts.post_modified as date, wp_term_relationships.term_taxonomy_id as category, wp_postmeta.meta_value as thumb_id from wp_posts 
    left join wp_term_relationships on wp_posts.ID = wp_term_relationships.object_id
    join wp_postmeta on wp_posts.ID = wp_postmeta.post_id
    where wp_posts.post_type='ps_gallery' and wp_posts.post_status='publish' 
    and wp_postmeta.meta_key='_thumbnail_id'";

    $aoPosts = $wpdb->get_results($sqlPosts);

    // iterate through posts
    $aPostTree = [];
    foreach($aoPosts as $oPost) {
        $iCategory = 0;
        
        $aPost = [
            'type' => 'gallery',
            'id' => $oPost->ID,
            'title' => $oPost->post_title,
            'thumb_id' => $oPost->thumb_id,
            'date' => $oPost->date,
            'slug' => array_merge(catSlugs($oPost->category, [], $aoCategories), [$oPost->post_name])
        ];
        array_push($aPostTree, $aPost);
    }


echo '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>';
        echo '<title>', get_bloginfo('name'), '</title>';
        echo '<link>', get_bloginfo('url'), '</link>';
        echo '<description>', get_bloginfo('description'), '</description>';
        echo '<language>', get_bloginfo('language'), '</language>';
        echo '<atom:link href="', get_bloginfo('url'), '/feed/rss.xml" rel="self" type="application/rss+xml" />';

        foreach ($aPostTree as $aPost) {
            echo '<item>';
            echo '<title>', $aPost['title'], '</title>';
            echo '<description>', $aPost['title'], '</description>';
            echo '<link>', get_bloginfo('url'), '/pictures/' . implode('/', $aPost['slug']) . '/', '</link>';
            echo '<guid>', get_bloginfo('url'), '/pictures/' . implode('/', $aPost['slug']) . '/', '</guid>';
            echo '<pubDate>', gmdate(DATE_RSS, strtotime($aPost['date'])),'</pubDate>';
            echo '<media:thumbnail url="', wp_get_attachment_image_url($aPost['thumb_id'], 'medium'), '" />';  
            // echo '<![CDATA[<img src="',wp_get_attachment_image_url($aPost['thumb_id'], 'medium'),'" alt="', $aPost['title'],'">]>';
            echo '</item>';
        }
        
        // <item>
        //     <title>My News Story 3</title>
        //     <description>This is example news item</description>
        //     <link>http://www.mywebsite.com/news3.html</link>
        //     <pubDate>Mon, 23 Feb 2009 09:27:16 +0000</pubDate>
        // </item>
        // <item>
        //     <title>My News Story 2</title>
        //     <description>This is example news item</description>
        //     <link>http://www.mywebsite.com/news2.html</link>
        //     <pubDate>Wed, 14 Jan 2009 12:00:00 +0000</pubDate>
        // </item>
        // <item>
        //     <title>My News Story 1</title>
        //     <description>This is example news item</description>
        //     <link>http://www.mywebsite.com/news1.html</link>
        //     <pubDate>Wed, 05 Jan 2009 15:57:20 +0000</pubDate>
        // </item>
echo '    </channel>
</rss>';
