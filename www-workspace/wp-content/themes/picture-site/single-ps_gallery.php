
<?php get_header(); ?>

<div class="row">

    <div class="col-sm-8 blog-main">
        <h2>gallery page</h2>

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

            foreach ( $attachments as $id  => $attachment ) {
                $title = esc_html($attachment->post_title, 1);
                $img = wp_get_attachment_image_src($id, $THUMB_SIZE);
        
                echo '<div class="single-image"><img src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" /></div>';
            }
  
        ?>

    </div> <!-- /.blog-main -->

</div> <!-- /.row -->

<?php get_footer(); ?>