<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget API: WP_Nav_Menu_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement the Custom Menu widget.
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class AFWP_Nav_Menu_Accordion_Widget extends WP_Widget {

	/**
	 * Sets up a new Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'description'                 => esc_html__( 'Add a custom accordion menu to your sidebar.', 'accordion-for-wp' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'accordion_nav_menu', esc_html__( 'Accordion Menu', 'accordion-for-wp' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Custom Menu widget instance.
	 */
	public function widget( $args, $instance ) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		$templates      = ! empty( $instance['templates'] ) ? $instance['templates'] : 'template-1';
		$style          = ! empty( $instance['style'] ) ? $instance['style'] : 'vertical';

		if ( ! $nav_menu ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu
		);

		/**
		 * Filters the arguments for the Custom Menu widget.
		 *
		 * @since 4.2.0
		 * @since 4.4.0 Added the `$instance` parameter.
		 *
		 * @param array $nav_menu_args {
		 *     An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
		 *
		 * @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
		 * @type mixed $menu Menu ID, slug, or name.
		 * }
		 *
		 * @param WP_Term $nav_menu Nav menu object for the current menu.
		 * @param array $args Display arguments for the current widget.
		 * @param array $instance Array of settings for the current widget.
		 */
		$menu_args = apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance );

			echo '<div class="afwp-accordion-template afwp-widget afwp-' . $templates . '">';
			$menu_args['container_class'] = 'afwp-accordion ' . $style;
			$menu_args['menu_class']      = 'afwp-accordion-list';
			wp_nav_menu( $menu_args );
			echo '</div>';

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}

		if ( ! empty( $new_instance['templates'] ) ) {
			$instance['templates'] = sanitize_text_field( $new_instance['templates'] );
		}

		if ( ! empty( $new_instance['style'] ) ) {
			$instance['style'] = sanitize_text_field( $new_instance['style'] );
		}

		return $instance;
	}

	/**
	 * Outputs the settings form for the Custom Menu widget.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 *
	 * @global WP_Customize_Manager $wp_customize
	 */
	public function form( $instance ) {
		global $wp_customize;
		$title    = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		$templates      = isset( $instance['templates'] ) ? $instance['templates'] : 'template-1';
		$style          = isset( $instance['style'] ) ? $instance['style'] : 'vertical';

		// Get menus
		$menus = wp_get_nav_menus();
		$general_tab_id = 'afwp_tab_general'.esc_attr($this->id);
		$design_tab_id = 'afwp_tab_design'.esc_attr($this->id);
		// If no menus exists, direct the user to go and create some.
		?>
		<div class="afwp-tab-wraper">
			<h5 class="afwp-tab-list nav-tab-wrapper">
				<a href="#<?php echo esc_attr($general_tab_id); ?>" class="nav-tab nav-tab-active"><?php esc_html_e('General', 'accordion-for-wp'); ?></a>
				<a href="#<?php echo esc_attr($design_tab_id); ?>" class="nav-tab"><?php esc_html_e('Design', 'accordion-for-wp'); ?></a>
			</h5>
			<div class="afwp-tab-content-wraper">
				<div id="<?php echo esc_attr($general_tab_id); ?>" class="afwp-tab-content afwp-content-active">
					<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) {
						echo ' style="display:none" ';
					} ?>>
						<?php
						if ( $wp_customize instanceof WP_Customize_Manager ) {
							$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
						} else {
							$url = admin_url( 'nav-menus.php' );
						}
						?>
						<?php echo sprintf( __( 'No menus have been created yet. <a href="%s">Create some</a>.', 'accordion-for-wp' ), esc_attr( $url ) ); ?>
					</p>
					<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) {
						echo ' style="display:none" ';
					} ?>>
						<p>
							<label
								for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'accordion-for-wp' ) ?></label>
							<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
							       name="<?php echo $this->get_field_name( 'title' ); ?>"
							       value="<?php echo esc_attr( $title ); ?>"/>
						</p>
						<p>
							<label
								for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php esc_html_e( 'Select Menu:', 'accordion-for-wp' ); ?></label>
							<select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>"
							        name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
								<option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'accordion-for-wp' ); ?></option>
								<?php foreach ( $menus as $menu ) : ?>
									<option
										value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
										<?php echo esc_html( $menu->name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</p>

						
					</div>
				</div>
				<div id="<?php echo esc_attr($design_tab_id); ?>" class="afwp-tab-content">
					<?php
						$all_templates = afwp_accordion_templates();
						?>
						<p>
							<label
								for="<?php echo $this->get_field_id( 'templates' ); ?>"><?php esc_html_e( 'Template:', 'accordion-for-wp' ); ?></label>
							<select class="widefat" id="<?php echo $this->get_field_id( 'templates' ); ?>"
							        name="<?php echo $this->get_field_name( 'templates' ); ?>">
								<?php foreach ( $all_templates as $template_key => $template_value ): ?>
									<option <?php selected( $templates, $template_key, true ); ?>
										value="<?php echo $template_key; ?>"><?php echo $template_value; ?></option>
								<?php endforeach; ?>
							</select>
						</p>
						<?php
						//$all_style = afwp_accordion_styles();
						$all_style=array('vertical'   => esc_html__( 'Vertical', 'accordion-for-wp' ));
						?>
						<p>
							<label
								for="<?php echo $this->get_field_id( 'style' ); ?>"><?php esc_html_e( 'Style:', 'accordion-for-wp' ); ?></label>
							<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>"
							        name="<?php echo $this->get_field_name( 'style' ); ?>">
								<?php foreach ( $all_style as $style_key => $style_value ): ?>
									<option <?php selected( $style, $style_key, true ); ?>
										value="<?php echo $style_key; ?>"><?php echo $style_value; ?></option>
								<?php endforeach; ?>
							</select>
						</p>
						<?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
							<p class="edit-selected-nav-menu" style="<?php if ( ! $nav_menu ) {
								echo 'display: none;';
							} ?>">
								<button type="button" class="button"><?php esc_html_e( 'Edit Menu', 'accordion-for-wp' ) ?></button>
							</p>
						<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}

register_widget( 'AFWP_Nav_Menu_Accordion_Widget' );