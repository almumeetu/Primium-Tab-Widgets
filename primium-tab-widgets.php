<?php

/**
 * Plugin Name: Primium TabSlider Widget
 * Description: Custom Elementor extension which includes custom widgets.
 * Plugin URL: https://example.com
 * Version: 1.0.0
 * Author: Al Mumeetu Saikat
 * Text Domain: custom-tab
 * Domain Path: /languages
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * The main class that initiates directly.
 * 
 * @since 1.0.0
 */
final class Elementor_Custom_Tab
{

    /**
     * Plugin Version
     * 
     * @since 1.0.0
     * 
     * @var string The Plugin Version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     * 
     * @since 1.0.0
     * 
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     * 
     * @since 1.0.0
     * 
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';


    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @access private
     * @static
     * 
     * @var Elementor_Custom_Tab The single instance of the Class.
     */
    private static $_instance = null;

    /**
     * Instance
     * 
     * Ensures only one instance of the class is loaded or can be loaded
     * 
     * @since 1.0.0
     * 
     * @access public
     * @static
     * 
     * @return Elementor_Custom_Tab The single instance of the class.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     * 
     * @access public
     */
    public function __construct()
    {
        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
    }

    /**
     * Load Textdomain
     * 
     * Load plugin localization files.
     * 
     * Fired by `init` action hook.
     * 
     * @since 1.0.0
     * 
     * @access public
     */
    public function i18n()
    {
        load_plugin_textdomain('custom-tab', false, basename(dirname(__FILE__)) . '/languages/');
    }

    /**
     * Initialize the plugin
     * 
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fails don't continue,
     * if all checks have passed load the files required to run the plugin.
     * 
     * Fired by `plugins_loaded` action hook.
     * 
     * @since 1.0.0
     * 
     * @access public
     */
    public function init()
    {

        //Check if Elementor is installed and activated
        if (! did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (! version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (! version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Add Plugin Action
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
        add_action('elementor/controls/controls_registered', [$this, 'init_controls']);

        // Category Init
        add_action('elementor/init', [$this, 'elementor_horigental_category']);
    }

    /**
     * Admin Notice
     * 
     * Warning when the site doesn't have Elementor installed or activated.
     * 
     * @since 1.0.0
     * 
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'custom-tab'),
            '<strong>' . esc_html__('Elementor horigental Extension', 'custom-tab') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'custom-tab') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin Notice
     * 
     * Warning when the site doesn't have the minimum required Elementor version.
     * 
     * @since 1.0.0
     * 
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'custom-tab'),
            '<strong>' . esc_html__('Elementor horigental Extension', 'custom-tab') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'custom-tab') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin Notice
     * 
     * Warning when the site doesn't have the minimum required PHP version.
     * 
     * @since 1.0.0
     * 
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'custom-tab'),
            '<strong>' . esc_html__('Elementor horigental Extension', 'custom-tab') . '</strong>',
            '<strong>' . esc_html__('PHP', 'custom-tab') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Init Widgets
     * 
     * Include widget files and register them.
     * 
     * @since 1.0.0
     * 
     * @access public
     */
    public function init_widgets()
    {
        require_once(__DIR__ . '/widgets/elementor-Tabslider.php');
        // Register widgets, loading all widget names
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Tabslider_Widget());
    }

    /**
     * Init Controls
     * 
     * Include control files and register them.
     * 
     * @since 1.0.0
     * 
     * @access public                    
     */
    public function init_controls()
    {
        // Include control files
        // require_once(__DIR__ . '/controls/Tabslider-control.php');
        // Register control
        // \Elementor\Plugin::$instance->controls_manager->register_control('control-type', new \Tabslider_Control());
    }

    // Custom CSS
    public function widget_styles()
    {
        wp_register_style('custom-tab-style', plugins_url('style.css', __FILE__));
        wp_enqueue_style('custom-tab-style');
    }

    // Custom JS
    public function widget_scripts()
    {
        wp_register_script('custom-tab-js', plugins_url('main.js', __FILE__));
        wp_enqueue_script('custom-tab-js');
    }

    // Custom Category
    public function elementor_horigental_category()
    {
        \Elementor\Plugin::$instance->elements_manager->add_category(
            'custom-tab-category',
            [
                'title' => __('Elementor horigental Category', 'custom-tab'),
                'icon' => 'fa fa-plug',
            ],
            2
        );
    }
}


// Register and enqueue styles and scripts
function eh_enqueue_scripts()
{
    // Enqueue CSS file
    wp_enqueue_style(
        'eh-style', // Handle
        plugin_dir_url(__FILE__) . 'assets/style.css', // Path to the CSS file
        array(), // Dependencies
        '1.0' // Version number
    );

    // Enqueue JS file
    wp_enqueue_script(
        'eh-main-js', // Handle
        plugin_dir_url(__FILE__) . 'assets/main.js', // Path to the JS file
        array('jquery'), // Dependencies (if any)
        '1.0', // Version number
        true // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'eh_enqueue_scripts');

Elementor_Custom_Tab::instance();
