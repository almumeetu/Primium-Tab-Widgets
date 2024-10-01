<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Email_Custom_Field_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'email_custom_field';
    }

    public function get_title() {
        return __( 'Email Custom Field', 'custom-tab' );
    }

    public function get_icon() {
        return 'eicon-email';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {
        // Content controls
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'custom-tab' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'email_placeholder',
            [
                'label' => __( 'Email Placeholder', 'custom-tab' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Enter your work email', 'custom-tab' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'custom-tab' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Start for free', 'custom-tab' ),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __( 'Button Link', 'custom-tab' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'https://phpstack-1295951-4709649.cloudwaysapps.com/user/login?email=',
            ]
        );

        $this->end_controls_section();

        // Style controls for the email input
        $this->start_controls_section(
            'input_style_section',
            [
                'label' => __( 'Input Field', 'custom-tab' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_padding',
            [
                'label' => __( 'Padding', 'custom-tab' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .banner-email input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => __( 'Border Radius', 'custom-tab' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner-email input[type="email"]' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label' => __( 'Border Color', 'custom-tab' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-email input[type="email"]' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style controls for the button
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __( 'Button', 'custom-tab' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Text Color', 'custom-tab' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-email a.start-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __( 'Background Color', 'custom-tab' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-email a.start-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __( 'Hover Background Color', 'custom-tab' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-email a.start-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => __( 'Padding', 'custom-tab' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .banner-email a.start-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        echo '<style>
.banner-email {
    position: relative;
}
.banner-email input[type="email"] {
    padding: 6px 10px;
    outline: none;
    border: 1px solid #0061a9;
    border-radius: 5px;
    width: 310px;
}
.banner-email a.start-btn {
    text-decoration: none;
    color: #fff;
    font-weight: 500;
    font-size: 14px;
    padding: 2px 12px;
    position: absolute;
    background: #0061a9;
    border-radius: 4px;
    left: 195px;
    top: 5px;
}
.banner-email a.start-btn:hover {
    background: #1B8FE7;
}
</style>';
        ?>
        <div class="banner-email">
            <input type="email" placeholder="<?php echo esc_attr( $settings['email_placeholder'] ); ?>">
            <a href="<?php echo esc_url( $settings['button_link'] ); ?>" class="start-btn"><?php echo esc_html( $settings['button_text'] ); ?></a>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <div class="banner-email">
            <input type="email" placeholder="{{ settings.email_placeholder }}">
            <a href="{{ settings.button_link }}" class="start-btn">{{ settings.button_text }}</a>
        </div>
        <?php
    }
    
}


// Register the widget and enqueue assets
add_action( 'elementor/widgets/widgets_registered', function() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Email_Custom_Field_Widget() );

    // Enqueue assets when the widget is loaded
    ( new Email_Custom_Field_Widget() )->enqueue_widget_assets();
});

// Register widget
add_action( 'elementor/widgets/widgets_registered', function() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Email_Custom_Field_Widget() );

});

