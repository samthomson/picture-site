<?php

    // disable top admin bar from showing
    show_admin_bar(false);


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