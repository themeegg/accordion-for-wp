<?php
class AFWP_Shortcode_Generator{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct(){

        //add_action( 'admin_menu', array( $this, 'afwp_admin_menu' ) );

    }

    /**
     * Add Submenu page
     */
    public function afwp_admin_menu(){
        add_submenu_page(
            'edit.php?post_type=accordion-for-wp',
            esc_html__('Accordion WordPress Shortcode Generator', 'accordion-for-wp'),
            esc_html__('Shortcode Generator', 'accordion-for-wp'),
            'manage_options',
            'afwp-shortcode-generator',
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
            <h1><?php esc_html_e('Generate accordion shortcode from here.', 'accordion-for-wp'); ?></h1>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content" style="position: relative;">
                        
                    </div><!-- /post-body-content -->
                    <div id="postbox-container-1" class="postbox-container ">
                        <h2 class="afwp-top-title"><?php esc_html_e('Our Free Themes', 'accordion-for-wp'); ?></h2>
                        <?php 
                            $themeegg_themes = array(
                                array(
                                    'name'=> esc_html__('EggNews - Magazine Theme'),
                                    'theme_url'=> 'https://themeegg.com/downloads/eggnews/',
                                    'demo_url'=> 'https://demo.themeegg.com/themes/eggnews/',
                                    'docs_url'=> 'https://docs.themeegg.com/docs/eggnews/',
                                    'forum_url'=> 'https://themeegg.com/support-forum/forum/eggnews-wordpress-theme/',
                                    'thumbnail_url'=>'https://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/screenshot.png',
                                    'rate_url'=> 'https://wordpress.org/support/theme/eggnews/reviews/?filter=5',
                                ),
                                array(
                                    'name'=> esc_html__('Miteri - Blog Theme'),
                                    'theme_url'=> 'https://themeegg.com/downloads/miteri/',
                                    'demo_url'=> 'https://demo.themeegg.com/themes/miteri/',
                                    'docs_url'=> 'https://docs.themeegg.com/docs/miteri/',
                                    'forum_url'=> 'https://themeegg.com/support-forum/forum/miteri-wordpress-theme/',
                                    'thumbnail_url'=>'https://demo.themeegg.com/themes/miteri/wp-content/themes/miteri/screenshot.png',
                                    'rate_url'=> 'https://wordpress.org/support/theme/miteri/reviews/?filter=5',
                                ),
                                array(
                                    'name'=> esc_html__('Education Master - Educational Theme'),
                                    'theme_url'=> 'https://themeegg.com/downloads/education-master/',
                                    'demo_url'=> 'https://demo.themeegg.com/themes/education-master/',
                                    'docs_url'=> 'https://docs.themeegg.com/docs/education-master/',
                                    'forum_url'=> 'https://themeegg.com/support-forum/forum/education-master-wordpress-theme/',
                                    'thumbnail_url'=>'https://demo.themeegg.com/themes/education-master/wp-content/themes/education-master/screenshot.png',
                                    'rate_url'=> 'https://wordpress.org/support/theme/education-master/reviews/?filter=5',
                                ),
                            );
                            foreach ($themeegg_themes as $single_theme) {
                                ?>
                                <div id="submitdiv" class="postbox afwp-postbox">
                                    <h2 class="hndle ui-sortable-handle"><span><?php echo esc_attr($single_theme['name']); ?></span></h2>
                                    <div class="inside">
                                        <div class="submitbox">
                                            <div class="afwp-minor-publishing">
                                                <a href="<?php echo  esc_attr($single_theme['theme_url']); ?>" title="<?php echo  esc_attr($single_theme['name']); ?>" target="_blank">
                                                    <img src="<?php echo  esc_attr($single_theme['thumbnail_url']); ?>" alt="<?php echo  esc_attr($single_theme['name']); ?>"/>
                                                </a>
                                            </div>
                                            <div class="afwp-bottom-actions">
                                                <a href="<?php echo esc_attr($single_theme['demo_url']); ?>" target="_blank" class="btn button-primary"><?php echo esc_html_e('Demo', 'accordion-for-wp'); ?></a>
                                                <a href="<?php echo  esc_attr($single_theme['docs_url']); ?>" target="_blank" class="btn button-primary"><?php echo esc_html_e('Docs', 'accordion-for-wp'); ?></a>
                                                <a href="<?php echo  esc_attr($single_theme['forum_url']); ?>" target="_blank" class="btn button-primary"><?php echo esc_html_e('Support', 'accordion-for-wp'); ?></a>
                                                <a href="<?php echo  esc_attr($single_theme['rate_url']); ?>" target="_blank" class="btn button-primary"><?php echo esc_html_e('Rating', 'accordion-for-wp'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                        
                    </div>
                </div><!-- /post-body -->
                <br class="clear">
            </div>
        </div>
        <?php

    }

}

if( is_admin() )
    $afwp_settings_page = new AFWP_Shortcode_Generator();