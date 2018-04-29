<?php

    $POST_ID = get_the_ID();
    $THUMB_SIZE = 'medium';
    
    $attachments = get_children([
        'post_parent' => $POST_ID,
        'post_status' => 'inherit',
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'order' => 'ASC',
        'orderby' => 'menu_order'
    ]);

    $sGalleryHTML = '';

    foreach ( $attachments as $id  => $attachment ) {
        $title = esc_html($attachment->post_title, 1);
        $img = wp_get_attachment_image_src($id, $THUMB_SIZE);

        $sGalleryHTML .= '<div class="single-image"><img src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" /></div>';
    }

    echo $sGalleryHTML;
