<?php
/* 
  Plugin Name: Okinawa - Widgets
  Plugin URI:
  Description: Agrega widgets personalizados al sidebar del sitio okinawa karate Rionegro.
  Version: 1.0.0
  Author: Harlynton Castaño García
  Author URI: https://harlynton.github.io/
  Text Domain: okinawa
*/

if(!defined('ABSPATH')) die();

/**
 * Adds okinawa_clases_widget widget.
 */
class okinawa_clases_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'okinawa_clases_widget', // Base ID
			esc_html__( 'Okinawa Clases Widget', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Muestra las clases guardadas.', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
    ?>
    <ul>
      <?php 
        $args = array(
          'post_type' => 'okinawa_clases',
          'posts_per_page' => 3,
        );
        $clases = new WP_Query($args);
        while ($clases->have_posts()): $clases -> the_post();
      ?>
        <li class="clase-sidebar">
          <div class="imagen-sidebar">
            <?php the_post_thumbnail('thumbnail');?>
          </div>
          <div class="contenido-clase">
            <a href="<?php the_permalink();?>">
              <h4><?php the_title(); ?></h4>
            </a>

            <?php 
              $hora_inicio = get_field('hora_inicio');
              $hora_fin = get_field('hora_fin');
            ?>
            <p><?php the_field('dias_de_clase');?> - <?php echo $hora_inicio . " a ". $hora_fin?></p>
          </div>
        </li>

        <?php endwhile; wp_reset_postdata()?>
      
    </ul>

		<p>

		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

} // class okinawa_clases_widget

// register okinawa_clases_widget widget
function register_okinawa_clases_widget() {
  register_widget( 'okinawa_clases_widget' );
}
add_action( 'widgets_init', 'register_okinawa_clases_widget' );

?>