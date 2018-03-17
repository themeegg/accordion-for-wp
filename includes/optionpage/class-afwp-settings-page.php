<?php
class AFWP_Settings_Page{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct(){

        //add_action( 'admin_menu', array( $this, 'afwp_admin_menu' ) );
        //add_action( 'admin_init', array( $this, 'afwp_admin_init' ) );

    }

    /**
     * Add Submenu page
     */
    public function afwp_admin_menu(){
        add_submenu_page(
            'edit.php?post_type=accordion-for-wp',
            esc_html__('Accordion WordPress Settings', 'accordion-for-wp'),
            esc_html__('Settings', 'accordion-for-wp'),
            'manage_options',
            'afwp-settings',
            array( $this, 'afwp_add_submenu_page' )
        );
    }

    /**
     * Options page callback
     */
    public function afwp_add_submenu_page(){

        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Accordion for WordPress Settings  ', 'accordion-for-wp'); ?></h1>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content" style="position: relative;">
                        <div class="afwp-tab-wraper">
                            <h5 class="afwp-tab-list nav-tab-wrapper">
                                <label for="tab_afwp_accordion_nav_menu_general2" data-id="#afwp_accordion_nav_menu_general2" class="nav-tab nav-tab-active">general<input id="tab_afwp_accordion_nav_menu_general2" type="radio" name="widget-afwp_accordion_nav_menu[2][active_tab_type]" value="general" checked="checked" class="afwp-hidden"></label>
                                <label for="tab_afwp_accordion_nav_menu_design2" data-id="#afwp_accordion_nav_menu_design2" class="nav-tab ">design<input id="tab_afwp_accordion_nav_menu_design2" type="radio" name="widget-afwp_accordion_nav_menu[2][active_tab_type]" value="design" class="afwp-hidden"></label>
                                <label for="submit" class="button-primary" style="padding: 5px 10px; height:auto; margin-left: .5em; border:none;">Save Changes</label>
                            </h5>
                            <form class="afwp-tab-content-wraper" method="post" action="options.php">
                                <?php settings_fields( 'afwp_settings_group' ); ?>
                                <div id="afwp_accordion_nav_menu_general2" class="afwp-tab-content afwp-content-active">
                                    <?php do_settings_sections( 'afwp_settings_general_tab' ); ?>
                                </div>
                                <div id="afwp_accordion_nav_menu_design2" class="afwp-tab-content ">
                                    <p>Design Tab</p>
                                </div>
                                <?php submit_button(); ?>
                            </form>
                        </div>
                    </div><!-- /post-body-content -->
                    <div id="postbox-container-1" class="postbox-container">
                        <h2>Hello This is Sidebar</h2>
                    </div>
                </div><!-- /post-body -->
                <br class="clear">
            </div>
        </div>
        <?php

    }

    /**
     * Register and add settings
     */
    public function afwp_admin_init()
    {
        register_setting(
            'afwp_settings_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'afwp_settings_general_id', // ID
            esc_html__('General Settings', 'accordion-for-wp'), // Title
            array( $this, 'print_section_info' ), // Callback
            'afwp_settings_general_tab' // Page
        );

        add_settings_field(
            'id_number', // ID
            esc_html__('ID Number', 'accordion-for-wp'), // Title
            array( $this, 'afwp_checkbox_callback' ), // Callback
            'afwp_settings_general_tab', // Page
            'afwp_settings_general_id', // Section
            array(
                ''
            ) //Arguments
        );

        add_settings_field(
            'title',
            'Title',
            array( $this, 'title_callback' ),
            'afwp_settings_general_tab',
            'afwp_settings_general_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info(){

        ?>
        <p><?php esc_html_e('You can change general settings from here.', 'accordion-for-wp'); ?></p>
        <?php

    }

    /**
     * Get the settings option array and print one of its values
     */
    public function afwp_checkbox_callback($args){

        echo '</pre>';
            print_r($args);
        echo '</pre>';
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );

    }

    /**
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

if( is_admin() )
    $afwp_settings_page = new AFWP_Settings_Page();