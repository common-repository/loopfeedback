<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sample.com
 * @since      1.0.0
 *
 * @package    Loop_Feedback
 * @subpackage Loop_Feedback/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Loop_Feedback
 * @subpackage Loop_Feedback/admin
 * @author     Miguel <migueldevli014@gmail.com>
 */
class Loop_Feedback_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);  
        add_action('admin_init', array( $this, 'registerAndBuildFields' ));
        add_action('wp_footer', array( $this, 'displayFeedback'));

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/loop-feedback-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/loop-feedback-admin.js', array( 'jquery' ), $this->version, false );
    }


    public function displayFeedback() {
        $settings = array(
            'enable_loop_0',
            'screenshot_plugin_code_1',
            'enable_have_a_suggestion_button_in_footer_2'
        );

        $enableLoop = get_option($settings[0]) == 1? true : false;
        $pluginCode = get_option($settings[1]);
        $footerBtn = get_option($settings[2]) == 1? true : false;
        
        echo $enableLoop ? $pluginCode : '';		
        echo $footerBtn ? '<a href="https://loopuserfeedbacksite.loopinput.com/5d5da1c9fd0a26001650e912">Have a suggestion</a>' : '';
    }

    /**
     * Add plugin admin menu to the sidebar
     */

    public function addPluginAdminMenu() {
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page(  
            $this->plugin_name, 
            'Loop Feedback', 
            'administrator', 
            $this->plugin_name, 
            array( $this, 'displayPluginAdminDashboard' ), 
            'dashicons-nametag', 
            26			
        );
    }

    /**
     * Display Plugin Admin Dashboard
     */
    public function displayPluginAdminDashboard() {	
        require_once 'partials/'.$this->plugin_name.'-admin-display.php';
    }
    
    public function registerAndBuildFields() {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting
         */

        do_settings_sections('loop_feedback_section');
        add_settings_section(
            // ID used to identify this section and with which to register options
            'loop_feedback_section', 
            // Title to be displayed on the administration page
            '',  
            // Callback used to render the description of the section
            array( $this, 'plugin_name_display_general_account' ),    
            // Page on which to add this section of options
            'loop_feedback_settings'                   
        );
        unset($args);
        $args = array (
            'type'      => 'input',
            'subtype'   => 'checkbox',
            'id'    => 'enable_loop_0',
            'name'      => 'enable_loop_0',
            'required' => 'true',
            'get_options_list' => '',
            'value_type'=>'normal',
            'wp_data' => 'option'
        );
        
        add_settings_field(
            'enable_loop_0', // id
            'Enable Loop', // title
            array( $this, 'render_settings_field' ), // callback
            'loop_feedback_settings', // page
            'loop_feedback_section', // section
            $args
        );

        register_setting(
            'loop_feedback_settings',
            'enable_loop_0'			
        );
        
        unset($args);
        $args = array (
            'type'      => 'textarea',			
            'id'    => 'screenshot_plugin_code_1',
            'name'      => 'screenshot_plugin_code_1',
            'required' => 'true',
            'get_options_list' => '',
            'value_type'=>'normal',
            'wp_data' => 'option'
        );

        add_settings_field(
            'screenshot_plugin_code_1', // id
            'Screenshot Plugin Code', // title
            array( $this, 'render_settings_field' ), // callback
            'loop_feedback_settings', // page
            'loop_feedback_section', // section
            $args
        );

        register_setting(
            'loop_feedback_settings',
            'screenshot_plugin_code_1'	
        );

        unset($args);
        $args = array (
            'type'      => 'input',			
            'subtype' 	=> 'checkbox',
            'id'    => 'enable_have_a_suggestion_button_in_footer_2',
            'name'      => 'enable_have_a_suggestion_button_in_footer_2',
            'required' => 'true',
            'get_options_list' => '',
            'value_type'=>'normal',
            'wp_data' => 'option'
        );

        add_settings_field(
            'enable_have_a_suggestion_button_in_footer_2', // id
            'Enable Have a suggestion Button in Footer', // title
            array( $this, 'render_settings_field' ), // callback
            'loop_feedback_settings', // page
            'loop_feedback_section', // section
            $args
        );

           register_setting(
           'loop_feedback_settings',
           'enable_have_a_suggestion_button_in_footer_2'		   
        );
    }

    public function validate($input) {
        // All checkboxes inputs        
        $valid = array();
    
        //Cleanup
        $valid['myplugin_field_1'] = (isset($input['myplugin_field_1']) && !empty($input['myplugin_field_1'])) ? 1: 0;
        $valid['myplugin_field_2'] = (isset($input['myplugin_field_2']) && !empty($input['myplugin_field_2'])) ? 1 : 0;
        $valid['myplugin_field_3'] = (isset($input['myplugin_field_3']) && !empty($input['myplugin_field_3'])) ? 1 : 0;
        
        return $valid;
     }

    public function plugin_name_display_general_account() {		
        echo '<p>If you haven\'t already, create an account at app.loopinput.com/newuser</p>';
        echo '<p>Next create your feedback portal and click "Show Screenshot Widget Code".</p>';
        echo '<p>Copy and paste the code that pops up into the box below and click Save.</p>';
    } 

    public function render_settings_field($args) {

        if($args['wp_data'] == 'option'){
            $wp_data_value = get_option($args['name']);
        } elseif($args['wp_data'] == 'post_meta'){
            $wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
        }

        switch ($args['type']) {

            case 'input':
                    $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                    if($args['subtype'] != 'checkbox'){
                            $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
                            $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
                            $step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
                            $min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
                            $max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
                            if(isset($args['disabled'])){
                                    // hide the actual input bc if it was just a disabled input the info saved in the database would be wrong - bc it would pass empty values and wipe the actual information
                                    echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                            } else {
                                    echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
                            }
                            /*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/

                    } else {
                            $checked = ($value) ? 'checked' : '';
                            echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
                    }
                    break;
            case 'textarea':
                $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                echo '<textarea id="'.$args['id'].'" name="'.$args['name'].'" rows="6" cols="80">'. esc_attr($value) .'</textarea>';
            default:
                    # code...
                    break;
        }
    }	
}
