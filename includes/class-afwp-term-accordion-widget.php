<?php
/**
* The class for accordion shortcode
*
* @link       http://themeegg.com/
* @since      1.1.0
*
* @package    Accordion_For_WP
* @subpackage Accordion_For_WP/public
*/

class AFWP_Term_Accordion_Widgets extends WP_Widget{

    /**
     * Sets up a new Accordion WIdget instance.
     *
     * @since 1.1.0
     * @access public
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'afwp_term_accordion_widget',
            'description' => __( 'Widget for Term Accordion' ),
            'customize_selective_refresh' => true,
        );
        $control_ops = array( 'width' => 300, 'height' => 350 );
        parent::__construct( 'afwp_term_accordion_widget', __( 'Accordion Term Widget' ), $widget_ops, $control_ops );
    }

    /**
     * Outputs the content for the current Accordion widget instance.
     *
     * @since 1.1.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Accordion widget instance.
     */
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $taxonomy = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
        $no_of_term = ! empty( $instance['no_of_term'] ) ? $instance['no_of_term'] : '';

        $templates = ! empty( $instance['templates'] ) ? $instance['templates'] : '';
        $style = ! empty( $instance['style'] ) ? $instance['style'] : '';

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $all_terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));
        if($all_terms):
            ?>
            <div class="afwp-accordion-template afwp-widget afwp-<?php echo $templates; ?>">
                <div class="afwp-accordion <?php echo $style; ?>">
                    <ul class="afwp-accordion-list">
                        <?php foreach($all_terms as $key=>$term_detail): ?>
                            <?php
                            if($key>=$no_of_term){
                                break;
                            }
                            ?>
                            <li class="afwp-accordian-item-wrap">
                                <input type="radio" id="afwp-widget-term-radio-<?php echo $term_detail->term_id; ?>" name="afwp-widget-term-<?php echo $taxonomy; ?>-radio-accordion" checked="checked" />
                                <label for="afwp-widget-term-radio-<?php echo $term_detail->term_id; ?>"><?php echo $term_detail->name; ?></label>
                                <div class="afwp-content">
                                    <p><?php echo $term_detail->description; ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Handles updating settings for the current Text widget instance.
     *
     * @since 1.1.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['taxonomy'] = sanitize_text_field( $new_instance['taxonomy'] );
        $instance['term'] = sanitize_text_field( $new_instance['term'] );
        $instance['no_of_term'] = absint( $new_instance['no_of_term'] );

        $instance['templates'] = sanitize_text_field( $new_instance['templates'] );
        $instance['style'] = sanitize_text_field( $new_instance['style'] );

        return $instance;
    }

    /**
     * Outputs the Accordion widget settings form.
     *
     * @since 1.1.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'taxonomy' => '', 'no_of_term'=>'5', 'templates'=>'default', 'style'=>'vertical' ) );
        $title = sanitize_text_field( $instance['title'] );
        $taxonomy = sanitize_text_field($instance['taxonomy']);
        $no_of_term = absint($instance['no_of_term']);

        $templates = sanitize_text_field($instance['templates']);
        $style = sanitize_text_field($instance['style']);
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:'); ?></label>
            <?php
            $all_object_taxonomies = get_taxonomies();
            ?>
            <select class="widefat afwp-widget-taxonomy" data-accordion-value="taxonomy" data-accordion-change-id="#<?php echo $this->get_field_id('term'); ?>" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="text" value="<?php echo esc_attr($taxonomy); ?>">
                <?php foreach($all_object_taxonomies as $taxonomy_key=>$taxonomy_value): ?>
                    <?php
                    $taxonomy_details = get_taxonomy( $taxonomy_key );
                    ?>
                    <option <?php echo ($taxonomy_key==$taxonomy) ? 'selected="selected"' : ''; ?> value="<?php echo $taxonomy_key; ?>"><?php echo $taxonomy_details->label; ?></option>
                <?php endforeach; ?>
            </select></p>

        <p><label for="<?php echo $this->get_field_id('no_of_term'); ?>"><?php _e('Show no of term:'); ?></label>
            <input class="widefat" min="1" max="99" id="<?php echo $this->get_field_id('no_of_term'); ?>" name="<?php echo $this->get_field_name('no_of_term'); ?>" type="number" value="<?php echo $no_of_term; ?>" /></p>
        <hr/>
        <p><label for="<?php echo $this->get_field_id('templates'); ?>"><?php _e('Template:'); ?></label>
        <?php
            $all_templates = array(
                    'default'=>'Default',
                    'template-1'=>'Template 1'
                );
        ?>
            <select class="widefat"  id="<?php echo $this->get_field_id('templates'); ?>" name="<?php echo $this->get_field_name('templates'); ?>" type="text" value="<?php echo esc_attr($templates); ?>">
                <?php foreach($all_templates as $template_key=>$template_value): ?>
                    <option <?php selected($templates, $template_key, true); ?> value="<?php echo $template_key; ?>"><?php echo $template_value; ?></option>
                <?php endforeach; ?>
            </select></p>
        <p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:'); ?></label>
        <?php
            $all_style = array(
                'vertical'=>'Vertical',
                'horizontal'=>'Horizontal',
            );
        ?>
            <select class="widefat"  id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="text" value="<?php echo esc_attr($style); ?>">
                <?php foreach($all_style as $style_key=>$style_value): ?>
                    <option <?php selected($style, $style_key, true); ?> value="<?php echo $style_key; ?>"><?php echo $style_value; ?></option>
                <?php endforeach; ?>
            </select></p>
        <?php
    }

}

register_widget( 'AFWP_Term_Accordion_Widgets' );