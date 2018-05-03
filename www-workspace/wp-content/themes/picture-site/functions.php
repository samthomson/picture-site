<?php

    //
    // Disabling wordpress stuff
    //

    // disable top admin bar from showing
    show_admin_bar(false);
    // disable comments and ping
    update_option('default_comment_status', '');
    update_option('default_ping_status', '');
    // remove menu items from admin section
    add_action( 'admin_init', 'my_remove_admin_menus' );
    function my_remove_admin_menus() {
      remove_menu_page('edit-comments.php');
      remove_menu_page('plugins.php');
    }
    // Remove comments from post and pages
    add_action('init', 'remove_comment_support', 100);
    function remove_comment_support() {
        remove_post_type_support('post', 'comments');
        remove_post_type_support('page', 'comments');
    }
    // Remove comments menu item from admin bar
    function mytheme_admin_bar_render() {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu('comments');
    }
    add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');

    // remove 'howdy' text
    function replace_howdy($wp_admin_bar) {
      $my_account = $wp_admin_bar->get_node('my-account');
      $wp_admin_bar->add_node([
        'id' => 'my-account',
        'title' => str_replace('Howdy,', '', $my_account->title),
      ]);
    }
    add_filter('admin_bar_menu', 'replace_howdy', 25);

    // remove wordpress thank you
    function remove_thankyou_footer() {
      add_filter('admin_footer_text', '', 11 );
    } 
    add_action('admin_init', 'remove_thankyou_footer');

    // remove dashboard nonsense
    function remove_dashboard_widgets() {
      global $wp_meta_boxes;
   
      unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
      unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
      unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
      unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    }
    add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
    remove_action('welcome_panel', 'wp_welcome_panel');

    // remove screen options menu tab
    function remove_screen_options() { return false; }
    add_filter('screen_options_show_screen', 'remove_screen_options');

    // remove help menu tab
    add_action('admin_head', 'mytheme_remove_help_tabs');
    function mytheme_remove_help_tabs() {
      $screen = get_current_screen();
      $screen->remove_help_tabs();
    }

    // store new db entry for each save
    define('WP_POST_REVISIONS', false );

    //
    // CUSTOMISATIONS
    //

    // set the default permalink structure for pages
    add_action( 'init', function() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%category%/%postname%/');
    } );

    //
    // ADDING STUFF
    //
    add_theme_support('post-thumbnails');
    add_post_type_support('ps_gallery', 'thumbnail');    
    
    // create the 'gallery' post type
    function create_post_type() {
      register_post_type( 'ps_gallery',
        array(
          'labels' => array(
            'name' => __( 'Galleries' ),
            'singular_name' => __( 'Gallery' ),
            'add_new_item' => 'Add new Gallery'
          ),
          'public' => true,
          'has_archive' => false,
          'rewrite' => array(
            'slug' => 'pictures/%category%',
            'with_front' => true,
          ),
          'taxonomies' => array('category'),
        )
      );
    }

    add_action('init', 'create_post_type');

    function ps_gallery_link($post_link, $id = 0) {

      /*
      $sqlCategories = "
      select wp_term_taxonomy.term_id, wp_term_taxonomy.parent, wp_term_taxonomy.count, wp_terms.name, wp_terms.slug from wp_terms
      right join wp_term_taxonomy  on wp_term_taxonomy.term_id = wp_terms.term_id
      where wp_term_taxonomy.taxonomy = 'category'
      ";

      $aoCategories = $wpdb->get_results($sqlCategories);

      $aCategories = [];
      foreach ($aoCategories as $oCategory) {
        array_push($aCategories, [
          'name' => $oCategory->name,
          'slug' => $oCategory->slug,
          'parent' => $oCategory->parent
        ]);
      }
      */

      // return json_encode($aCategories);


      $post = get_post($id);  
      if (is_object($post)) {
          $terms = wp_get_object_terms($post->ID, 'category');

          if ($terms) {
            $saCategories = [];
            foreach($terms as $oTerm) {
              array_push($saCategories, $oTerm->slug);
            }
            $sCategory = implode('/', $saCategories);
            return str_replace('%category%', $sCategory, $post_link);
          }else{
            return str_replace('%category%', 'no-category', $post_link);
          }
      }
      return $post_link;  
    }
    add_filter('post_type_link', 'ps_gallery_link', 1, 3);
    
    // custom thumbnail size
    update_option('medium_size_w', 500);
    update_option('medium_size_h', 1600);

    // don't store uploads in nested year/month folders
    update_option( 'uploads_use_yearmonth_folders', '0' );