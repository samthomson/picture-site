<?php
    show_admin_bar(false);

    add_action( 'init', function() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
    } );