<?php

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

    $aColumns = [
        [],
        [],
        []
    ];

    $i = 0;
    foreach ( $attachments as $id  => $attachment) {
        $aColumns[$i % 3][$attachment->ID] = $attachment;
        // array_push($aColumns[$id % 3], $attachment);
        $i++;
    }

    // echo json_encode($aColumns);

    echo '<div class="column-layout">';
    foreach ($aColumns as $aColumn) {
        echo '<div class="single-column"><div class="column-inlet">';
        foreach ($aColumn as $id  => $attachment) {
            $title = esc_html($attachment->post_title, 1);
            $img = wp_get_attachment_image_src($id, $THUMB_SIZE);

            $sGalleryHTML = '';

            $sGalleryHTML .= '<div class="single-image"><img src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" /></div>';
            echo $sGalleryHTML;
        }
        echo '</div></div>';
    }
    echo '</div>';

    // echo $sGalleryHTML;
