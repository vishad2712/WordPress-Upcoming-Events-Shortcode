<?php
function create_event_post_type() {
    // Register custom post type for events
    register_post_type( 'event',
        array(
            'labels' => array(
                'name' => __( 'Events' ),
                'singular_name' => __( 'Event' ),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'events' ),
            'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        )
    );
}
add_action( 'init', 'create_event_post_type' );

function upcoming_events_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'posts_per_page' => 6,
        ),
        $atts,
        'upcoming_events'
    );

    // Query upcoming events
    $args = array(
        'post_type'      => 'event',
        'posts_per_page' => $atts['posts_per_page'],
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'event_date',
                'value'   => date( 'Ymd' ),
                'compare' => '>=', // Show events with event_date greater than or equal to today
            ),
        ),
        'meta_key'       => 'event_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    );

    $events_query = new WP_Query( $args );

    if ( $events_query->have_posts() ) {

        ob_start();
        ?>
        <div class="container py-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                while ( $events_query->have_posts() ) {
                    $events_query->the_post();
                    
                    // Get event details
                    $featured_image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                    $event_date = get_field( 'event_date' );
                    $event_location = get_field( 'event_location' );
                    $event_time = get_field( 'event_time' );
                    $event_permalink = get_permalink();
                    $formatted_date = date( 'm/d/Y', strtotime( $event_date ) ) . ' at ' . $event_time;

                    ?>
                    <div class="col">
                        <div class="card h-100">
                            <?php if ( $featured_image_url ) : ?>
                                <img src="<?php echo esc_url( $featured_image_url ); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text">Date: <?php echo $formatted_date; ?></p>
                                <p class="card-text">Location: <?php echo $event_location; ?></p>
                                <p class="card-text"><?php the_excerpt(); ?></p>
                                <a href="<?php echo $event_permalink; ?>" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php

        wp_reset_postdata();

        return ob_get_clean();
    } else {
        return 'No upcoming events.';
    }
}
add_shortcode( 'upcoming_events', 'upcoming_events_shortcode' );
?>