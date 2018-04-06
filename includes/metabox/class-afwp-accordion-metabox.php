<?php
class AFWP_Accordion_Metabox{

    public function __construct(){

    }

    public static function metabox_template(){

        global $post;
        $post_id = $post->ID;

        $afwp_settings_meta_details = get_post_meta($post_id, 'afwp_meta_settings', true);
        echo '<pre>';
           // print_r($afwp_settings_meta_details);
        echo '</pre>';

        $active_tab_type = 'afwp_accordion';

        $afwp_order = array(
            'DESC' => esc_html__('Descending', 'accordion-for-wp'),
            'ASC' => esc_html__('Ascending', 'accordion-for-wp'),
        );
        $afwp_order_by = array(
            'date' => esc_html__('Date', 'accordion-for-wp'),
            'title' => esc_html__('Title', 'accordion-for-wp'),
            'ID' => esc_html__('ID', 'accordion-for-wp'),
            'author' => esc_html__('Author', 'accordion-for-wp'),
            'modified' => esc_html__('Modified', 'accordion-for-wp'),
            'rand' => esc_html__('Random', 'accordion-for-wp'),
            'comment_count' => esc_html__('Comment Count', 'accordion-for-wp'),
        );
        $afwp_permission = array(
            'readable' => esc_html__('Readable', 'accordion-for-wp'),
            'editable' => esc_html__('Editable', 'accordion-for-wp'),
        );
        $afwp_content_type = array(
            'excerpt'   => esc_html__('Short Description', 'accordion-for-wp'),
            'content'   => esc_html__('Full Content', 'accordion-for-wp'),
        );

        $afwp_template = afwp_accordion_templates();
        $afwp_style = afwp_accordion_styles();

        $list_all_tabs = array(
            'afwp_accordion'   =>  array(
                'id'    => 'afwp_settings_accordion',
                'label' => esc_html__('Accordion', 'accordion-for-wp'),
                'group' => array(
                    'general'=>array(
                        'group_title'=> esc_html__('Accordion General', 'accordion-for-wp'),
                        'fields'=> array(
                            array(
                                'type'      => 'number',
                                'default'   => '5',
                                'label'     => esc_html__('Posts per page', 'accordion-for-wp'),
                                'id'        => 'posts_per_page',
                            ),
                            array(
                                'type'      => 'select',
                                'default'   => 'DESC',
                                'label'     => esc_html__('Order', 'accordion-for-wp'),
                                'id'        => 'order',
                                'choices'   => $afwp_order,
                            ),
                        ),
                    ),
                    'layout'=>array(
                        'group_title'=> esc_html__('Accordion Layout', 'accordion-for-wp'),
                        'fields'=> array(
                            array(
                                'type'      => 'select',
                                'default'   => 'date',
                                'label'     => esc_html__('Order By', 'accordion-for-wp'),
                                'id'        => 'order',
                                'choices'   => $afwp_order_by,
                            ),
                            array(
                                'type'      => 'select',
                                'default'   => 'readable',
                                'label'     => esc_html__('Permission', 'accordion-for-wp'),
                                'id'        => 'perm',
                                'choices'   => $afwp_permission,
                            ),
                        ),
                    ),
                    'design'=>array(
                        'group_title'=> esc_html__('Accordion Design', 'accordion-for-wp'),
                        'fields'=> array(
                            array(
                                'type'      => 'number',
                                'default'   => '0',
                                'label'     => esc_html__('Offset', 'accordion-for-wp'),
                                'id'        => 'offset',
                            ),
                            array(
                                'type'      => 'select',
                                'default'   => '0',
                                'label'     => esc_html__('Content Type:', 'accordion-for-wp'),
                                'id'        => 'afwp_content_type',
                                'choices'   => $afwp_content_type,
                            ),
                        ),
                    ),
                ),
            ),
            'afwp_tab'   =>  array(
                'id'    => 'afwp_settings_tabs',
                'label' => esc_html__('Tabs', 'accordion-for-wp'),
                'group' => array(
                    'general'=>array(
                        'group_title'=> esc_html__('Tab General', 'accordion-for-wp'),
                        'fields'=> array(
                            array(
                                'type'      => 'number',
                                'default'   => '5',
                                'label'     => esc_html__('Posts per page', 'accordion-for-wp'),
                                'id'        => 'posts_per_page',
                            ),
                            array(
                                'type'      => 'select',
                                'default'   => 'DESC',
                                'label'     => esc_html__('Order', 'accordion-for-wp'),
                                'id'        => 'order',
                                'choices'   => $afwp_order,
                            ),
                        ),
                    ),
                    'layout'=>array(
                        'group_title'=> esc_html__('Tabs Layout', 'accordion-for-wp'),
                        'fields'=> array(
                            array(
                                'type'      => 'select',
                                'default'   => 'date',
                                'label'     => esc_html__('Order By', 'accordion-for-wp'),
                                'id'        => 'order',
                                'choices'   => $afwp_order_by,
                            ),
                            array(
                                'type'      => 'select',
                                'default'   => 'readable',
                                'label'     => esc_html__('Permission', 'accordion-for-wp'),
                                'id'        => 'perm',
                                'choices'   => $afwp_permission,
                            ),
                        ),
                    ),
                    'design'=>array(
                        'group_title'=> esc_html__('Tabs Design', 'accordion-for-wp'),
                        'fields'=> array(
                            array(
                                'type'      => 'number',
                                'default'   => '0',
                                'label'     => esc_html__('Offset', 'accordion-for-wp'),
                                'id'        => 'offset',
                            ),
                            array(
                                'type'      => 'select',
                                'default'   => '0',
                                'label'     => esc_html__('Content Type:', 'accordion-for-wp'),
                                'id'        => 'afwp_content_type',
                                'choices'   => $afwp_content_type,
                            ),
                        ),
                    ),
                ),
            ),
        );
    
        $afwp_post_settings = get_post_meta($post_id, 'afwp_meta_settings', true);
        ?>
        <h3><?php esc_html_e('Accordion settings section is comming soon....', 'accordion-for-wp'); ?></h3>
        <div class="afwp-tab-wraper">
            <h5 class="afwp-tab-list nav-tab-wrapper">
                <?php foreach($list_all_tabs as $tab_key=>$tab_details){ ?>
                    <label for="tab_<?php echo esc_attr($tab_details['id']); ?>" data-id="#<?php echo esc_attr($tab_details['id']); ?>" class="nav-tab <?php echo ($tab_key == $active_tab_type) ? 'nav-tab-active' : ''; ?>"><?php echo sanitize_text_field($tab_details['label']); ?></label>
                    <input id="tab_<?php echo esc_attr($tab_details['id']); ?>" type="radio" name="afwp_meta_settings[active_tab_type][<?php echo esc_attr($tab_details['id']); ?>]" value="<?php echo esc_attr($tab_key); ?>" <?php checked($active_tab_type, $tab_key); ?> class="afwp-hidden"/>
                <?php } ?>
            </h5>
            <div class="afwp-tab-content-wraper">
                <?php foreach($list_all_tabs as $tab_key=>$tab_details){ ?>
                    <div id="<?php echo esc_attr($list_all_tabs[$tab_key]['id']); ?>" class="afwp-tab-content <?php echo ($active_tab_type==$tab_key) ? 'afwp-content-active' : ''; ?>">
                    <?php
                        $accordion_group = $tab_details['group'];
                            foreach($accordion_group as $group_key=>$group_details){
                            ?>
                                <div class="afwp_settings_group_wraper">
                                    <div class="afwp_group_title"><?php echo $group_details['group_title']; ?></div>
                                    <div class="afwp_settings_field_wraper">
                                <?php
                                $tabs_fields = $group_details['fields'];
                                foreach($tabs_fields as $fields_details){
                                $field_type = $fields_details['type'];
                                $field_id = $fields_details['id'];
                                $field_label = $fields_details['label'];
                                $field_default = $fields_details['default'];
                                ?>
                                    <p>
                                        <label for="<?php echo esc_attr($field_id); ?>"><?php echo esc_attr($field_label); ?></label>
                                        <?php
                                            switch ($field_type){
                                                    case 'select':
                                                        $field_choices = $fields_details['choices'];
                                                        ?>
                                                            <select name="afwp_meta_settings[<?php echo esc_attr($tab_key); ?>][<?php echo esc_attr($field_id); ?>" id="<?php echo esc_attr($field_id); ?>]" class="widefat">
                                                                <?php
                                                                     foreach($field_choices as $field_value=>$field_label){
                                                                        ?>
                                                                            <option <?php selected($field_default, $field_value); ?> value="<?php echo $field_value; ?>"><?php echo $field_label; ?></option>
                                                                        <?php
                                                                     }

                                                                ?>
                                                            </select>
                                                        <?php
                                                        break;

                                                    case 'number':
                                                        ?>
                                                        <input name="afwp_meta_settings[<?php echo esc_attr($tab_key); ?>][<?php echo esc_attr($field_id); ?>]" id="<?php echo esc_attr($field_id); ?>" class="widefat" type="number" value="<?php echo $field_default; ?>"/>
                                                        <?php
                                                        break;
                                                    case 'icon':
                                                        ?>
                                                        <input name="afwp_meta_settings[<?php echo esc_attr($tab_key); ?>][<?php echo esc_attr($field_id); ?>]" id="<?php echo esc_attr($field_id); ?>" class="widefat afwp_icon_picker" type="text" value="<?php echo $field_default; ?>"/>
                                                        <?php
                                                        break;
                                                     case 'color':
                                                        ?>
                                                        <input name="afwp_meta_settings[<?php echo esc_attr($tab_key); ?>][<?php echo esc_attr($field_id); ?>]" id="<?php echo esc_attr($field_id); ?>" class="widefat afwp_color_picker" type="text" value="<?php echo $field_default; ?>"/>
                                                        <?php
                                                        break;

                                                    default:
                                                        ?>
                                                        <p><?php esc_html_e("There is no ".$field_type." field type exist", 'accordion-for-wp'); ?></p>
                                                        <?php
                                                        break;

                                                }
                                        ?>
                                    </p>
                                <?php
                            }
                                ?>
                                    </div>
                                </div>
                                    <?php
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
        </div>
        <?php
        wp_nonce_field('afwp_metabox_settings_nonce_action', 'afwp_metabox_settings_nonce_name', false);
    }

    public static function save_metabox($post_id){

        if ( ! isset( $_POST['afwp_metabox_settings_nonce_name'] ) ) {
            
            return;
        }
 
        if ( ! wp_verify_nonce( $_POST['afwp_metabox_settings_nonce_name'], 'afwp_metabox_settings_nonce_action' ) ) {

            return;
        }
     
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
     
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $afwp_meta_settings = isset($_POST['afwp_meta_settings']) ? $_POST['afwp_meta_settings'] : '';
        
        update_post_meta($post_id, 'afwp_meta_settings', $afwp_meta_settings);

        

    }

}