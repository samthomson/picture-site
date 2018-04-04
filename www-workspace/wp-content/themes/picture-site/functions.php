<?php

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

    // set the default permalink structure for pages
    add_action( 'init', function() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
    } );

    // create the 'gallery' post type
    function create_post_type() {
      register_post_type( 'ps_gallery',
        array(
          'labels' => array(
            'name' => __( 'Galleries' ),
            'singular_name' => __( 'Gallery' )
          ),
          'public' => true,
          'has_archive' => false,
          'rewrite' => array('slug' => 'pictures'),
        )
      );
    }
    add_action( 'init', 'create_post_type' );