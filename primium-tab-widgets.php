<?php

/**
 * Plugin Name: Primium TabSlider Widget
 * Description: Custom Elementor extension which includes custom widgets.
 * Plugin URL: https://example.com
 * Version: 1.1.0
 * Author: Al Mumeetu Saikat
 * Text Domain: custom-tab
 * Domain Path: /languages
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * The main class that initiates the plugin.
 *
 * @since 1.1.0
 */
final class Elementor_Custom_Tab
{
    const VERSION = '1.1.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    /**
     * Singleton instance method.
     *
     * @return Elementor_Custom_Tab
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor initializes hooks and loads plugin files.
     */
    public function __construct()
    {
        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_widget_assets']); // Hook enqueue assets correctly
    }

    /**
     * Load plugin textdomain for translations.
     */
    public function i18n()
    {
        load_plugin_textdomain('custom-tab', false, basename(dirname(__FILE__)) . '/languages/');
    }

    /**
     * Initialize the plugin with all required checks.
     */
    public function init()
    {
        if (! did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        if (! version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        if (! version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        $this->register_widget_and_controls();
        add_action('elementor/init', [$this, 'elementor_custom_category']);
    }

    /**
     * Register widgets and controls dynamically using reflection.
     */
    public function register_widget_and_controls()
    {
        add_action('elementor/widgets/widgets_registered', function () {
            $this->load_classes(__DIR__ . '/widgets/', 'widget');
        });

        add_action('elementor/controls/controls_registered', function () {
            $this->load_classes(__DIR__ . '/controls/', 'control');
        });
    }

    /**
     * Load and register widget/control classes using Reflection.
     *
     * @param string $path
     * @param string $type (widget or control)
     */
    private function load_classes($path, $type)
    {
        foreach (glob($path . '*.php') as $file) {
            require_once $file;
            $class = $this->get_class_name_from_file($file);
            if ($type === 'widget') {
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class());
            } elseif ($type === 'control') {
                \Elementor\Plugin::$instance->controls_manager->register_control($class::CONTROL_NAME, new $class());
            }
        }
    }

    /**
     * Get class name from file using reflection.
     *
     * @param string $file
     * @return string
     */
    private function get_class_name_from_file($file)
    {
        $tokens = token_get_all(file_get_contents($file));
        $class_token = false;
        for ($i = 0; $i < count($tokens); $i++) {
            if ($tokens[$i][0] === T_CLASS) {
                $class_token = $tokens[$i + 2][1];
                break;
            }
        }
        return $class_token;
    }

    /**
     * Display admin notice if Elementor is not installed.
     */
    public function admin_notice_missing_main_plugin()
    {
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'custom-tab'),
            '<strong>' . esc_html__('Elementor Primium TabSlider Extension', 'custom-tab') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'custom-tab') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_elementor_version()
    {
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'custom-tab'),
            '<strong>' . esc_html__('Elementor Primium TabSlider Extension', 'custom-tab') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'custom-tab') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version()
    {
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'custom-tab'),
            '<strong>' . esc_html__('Elementor Primium TabSlider Extension', 'custom-tab') . '</strong>',
            '<strong>' . esc_html__('PHP', 'custom-tab') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Add custom Elementor category.
     */
    public function elementor_custom_category()
    {
        \Elementor\Plugin::$instance->elements_manager->add_category(
            'custom-tab-category',
            [
                'title' => __('Primium TabSlider Category', 'custom-tab'),
                'icon'  => 'fa fa-plug',
            ],
            2
        );
    }

    /**
     * Enqueue styles and scripts for the widget.
     */
    public function enqueue_widget_assets()
    {
        wp_enqueue_style('custom-tab-style', plugins_url('assets/style.css', __FILE__));
        wp_enqueue_script('custom-tab-js', plugins_url('assets/main.js', __FILE__), ['jquery'], '1.0', true);
    }
}

Elementor_Custom_Tab::instance();
