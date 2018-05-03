<a href="/" id="home-link">
    <span id="name">Sam Thomson</span>
    <span id="tagline">travel pictures</span>
</a>
    
<div id="ul-menus">
    <?php
        $sqlCategories = "
        select wp_term_taxonomy.term_id, wp_term_taxonomy.parent, wp_term_taxonomy.count, wp_terms.name, wp_terms.slug from wp_terms
        right join wp_term_taxonomy  on wp_term_taxonomy.term_id = wp_terms.term_id
        where wp_term_taxonomy.taxonomy = 'category'
        ";

        $sqlPosts = "
        select wp_posts.ID, wp_posts.post_title, wp_posts.post_name, wp_term_relationships.term_taxonomy_id as category from wp_posts 
        left join wp_term_relationships on wp_posts.ID = wp_term_relationships.object_id
        where wp_posts.post_type='ps_gallery' and wp_posts.post_status='publish'
        ";

        $aoCategories = $wpdb->get_results($sqlCategories);
        $aoPosts = $wpdb->get_results($sqlPosts);

        // iterate through posts
        $aPostTree = [];
        foreach($aoPosts as $oPost) {
            $iCategory = $oPost->category;
            if (!isset($aPostTree[$iCategory])) {
                $aPostTree[$iCategory] = [];
            }
            $aPost = [
                'type' => 'gallery',
                'id' => $oPost->ID,
                'title' => $oPost->post_title,
                'slug' => $oPost->post_name
            ];
            array_push($aPostTree[$iCategory], $aPost);
        }

        $aTree = [];

        // iterate through categories.
        $aTree = findChildrenofCategory($aoCategories, 0, $aPostTree);

        function findChildrenofCategory($aCategories, $iFindChildrenOfThisCategoryID, $aPostTree) {
            // find children of category
            $aReturn = [];
            foreach ($aCategories as $oCategory) {

                if ($oCategory->parent == $iFindChildrenOfThisCategoryID) {
                    $oItem = ['type' => 'category', 'name' => $oCategory->name, 'slug' => $oCategory->slug, 'count' => $oCategory->count];

                    // // iterate through categories to see if I am parent to any
                    $aChildCategories = findChildrenofCategory($aCategories, $oCategory->term_id, $aPostTree);
                    $aChildrenToAdd = [];
                    // if yes, display it, and repeat
                    if (count($aChildCategories) > 0) {
                        $aChildrenToAdd = $aChildCategories;
                    }
                    
                    // look for child galleries too
                    if (isset($aPostTree[$oCategory->term_id])) {
                        $aChildrenToAdd = array_merge($aChildrenToAdd, $aPostTree[$oCategory->term_id]);
                    }
                        
                    $oItem['children'] = $aChildrenToAdd;

                    array_push($aReturn, $oItem);
                }
            }
            return $aReturn;
        }

        
        // display tree
        displayTree($aTree);

        function displayTree($aTree, $aCategorySlugs = []) {
            echo '<ul>';
            foreach($aTree as $aBranch) {
                if ($aBranch['type'] === 'category') {
                    
                    $sUrl = '/category/';
                    if (count($aCategorySlugs) > 0) {
                        $sUrl .= implode('/', array_filter($aCategorySlugs)) . '/';
                    }
                    $sUrl .= $aBranch['slug'] . '/';
                    if (isset($aBranch['children']) && count($aBranch['children']) > 0) {
                        echo makeLink($sUrl, $aBranch['name'], 'category');
                    }
                }
                if ($aBranch['type'] === 'gallery') {
                    $sUrl = '/pictures/' . implode('/', $aCategorySlugs) . '/'. $aBranch['slug'] . '/';
                    echo makeLink($sUrl, '- '. $aBranch['title']);
                }

                if (isset($aBranch['children'])) {
                    displayTree($aBranch['children'], array_merge($aCategorySlugs, array($aBranch['slug'])));
                }
            }
            echo '</ul>';
        }

        function makeLink($sUrl, $sLinkContents, $sClass = '') {
            $sCurrentURL = $_SERVER['REQUEST_URI'];
            $sClass .= $sCurrentURL === $sUrl ? ' active' : '';
            return '<a href="'. $sUrl.'" class="'. $sClass .'"><li>'. $sLinkContents. '</li></a>';
        }
    ?>

    <hr/>
    <ul>
        <?php echo makeLink('/about/', 'About');?>
    </ul>
</div>