<?php

/*

Plugin Name: Recent Posts With Featured Image Widget

Description: Adds a widget that displays the 3 most recent posts, with featured image, within any widget area. Responsive design and code built-in to work with all themes. | <br>Version 1.0 | By <a href="http://merchantwebdesign.com">Merchant Web Design</a>

Version: 1.0

*/

/* Start Adding Functions Below this Line */



/**

 * Include CSS file for MyPlugin.

 */

function postJM_scripts() {

    wp_register_style( 'postJM-styles',  plugin_dir_url( __FILE__ ) . '/style.css' );

    wp_enqueue_style( 'postJM-styles' );

}

add_action( 'wp_enqueue_scripts', 'postJM_scripts' );





// Creating the widget 

class wpb_widget extends WP_Widget {



function __construct() {

parent::__construct(

// Base ID of your widget

'wpb_widget', 



// Widget name will appear in UI

__('Recent Posts with Image', 'wpb_widget_domain'), 



// Widget description

array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 

);

}



// Creating widget front-end

// This is where the action happens

public function widget( $args, $instance ) {

$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes

echo $args['before_widget'];

if ( ! empty( $title ) )

echo $args['before_title'] . $title . $args['after_title'];



// This is where you run the code and display the output


$my_query = "showposts=3"; $my_query = new WP_Query($my_query);
if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();

//Insert the regular template tags you would use within the loop here

	echo '<div class="postJM">';

		echo '<div ';

		echo post_class();

		echo 'id="post-';

		echo the_ID();

		echo '">';

			echo '<div class="post-imageJM">';

				echo '<a href="';

				echo the_permalink();

				echo '">';

				echo the_post_thumbnail("thumbnail");

				echo '</a>';

			echo '</div>';

			echo '<div class="post-contentJM">';

				echo '

					<h2><a href="';

				echo the_permalink();

				echo '">';

				echo the_title();

				echo '</a></h2>';

				echo the_excerpt();

				echo '<a class="btnJM" href="';

				echo the_permalink();

				echo '">Read More <i class="fa fa-chevron-circle-right"></i></a>';

			echo '</div>';
			echo '<div class="post-clearJM">';
			echo '</div>';

		echo '</div>';

	echo '</div>';

endwhile; // end of one post 
endif; //end of loop 


wp_reset_query(); // reset the query





echo $args['after_widget'];

}

		

// Widget Backend 

public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {

$title = $instance[ 'title' ];

}

else {

$title = __( 'New title', 'wpb_widget_domain' );

}

// Widget admin form

?>

<p>

<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

</p>

<?php 

}

	

// Updating widget replacing old instances with new

public function update( $new_instance, $old_instance ) {

$instance = array();

$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

return $instance;

}

} // Class wpb_widget ends here



// Register and load the widget

function wpb_load_widget() {

	register_widget( 'wpb_widget' );

}

add_action( 'widgets_init', 'wpb_load_widget' );





/* Stop Adding Functions Below this Line */

?>