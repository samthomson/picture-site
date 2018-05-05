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
        $i++;
    }

    echo '<div class="column-layout">';
    foreach ($aColumns as $aColumn) {
        echo '<div class="single-column"><div class="column-inlet">';
        foreach ($aColumn as $id  => $attachment) {
            $title = esc_html($attachment->post_excerpt, 1);
            $img = wp_get_attachment_image_src($id, $THUMB_SIZE);
            $sLightboxImageSrc = esc_url(wp_get_attachment_image_src($id, 'large')[0]);

            $sGalleryHTML = '';

            $sGalleryHTML .= '<div class="single-image"><img class="lightbox-image" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" lightbox-src="'.$sLightboxImageSrc.'" /></div>';
            echo $sGalleryHTML;
        }
        echo '</div></div>';
    }
    echo '</div>';

    // lightbox
    ?>
    <div id="lightbox-container" class="hide">
        <div id="lightbox-image-container"><img /></div>
        <div id="lightbox-image-controls">
            <div class="lightbox-button" id="close">close</div>
            <div class="lightbox-button" id="previous">previous</div>
            <div class="lightbox-button" id="next">next</div>
            <div id="caption"></div>
        </div>
    </div>
    <?php

