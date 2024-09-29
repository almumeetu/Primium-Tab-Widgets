<?php

class Elementor_Tabslider_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Tabslider Widget';
    }

    public function get_title()
    {
        return esc_html__('Tabslider Widget', 'custom-tab');
    }

    public function get_icon()
    {
        return 'eicon-text';
    }

    public function get_categories()
    {
        return ['custom-tab-category'];
    }

    public function get_keywords()
    {
        return ['Tabslider', 'heading'];
    }

    public function get_custom_help_url()
    {
        return 'https://example.com/widget-name';
    }

    protected function get_upsale_data()
    {
        return [];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Tab Slider', 'custom-tab'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Dynamic Title Control
        $this->add_control(
            'slider_title',
            [
                'label' => __('Slider Title', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Reach your ideal customers when they are most likely to buy with:', 'custom-tab'),
            ]
        );

        // Tabs Repeater
        $this->add_control(
            'tabs',
            [
                'label' => __('Tabs', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'tab_title',
                        'label' => __('Title', 'custom-tab'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Tab Title', 'custom-tab'),
                    ],
                    [
                        'name' => 'tab_content',
                        'label' => __('Content', 'custom-tab'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => __('Tab Content', 'custom-tab'),
                    ],
                    [
                        'name' => 'media_type',
                        'label' => __('Media Type', 'custom-tab'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'image',
                        'options' => [
                            'image' => __('Image', 'custom-tab'),
                            'video' => __('Video', 'custom-tab'),
                        ],
                    ],
                    [
                        'name' => 'tab_image',
                        'label' => __('Image', 'custom-tab'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'media_type' => 'image',
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'media_type' => 'image',
                        ],
                    ],
                    [
                        'name' => 'tab_video',
                        'label' => __('Video URL', 'custom-tab'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'description' => __('Enter the video URL (YouTube, Vimeo, etc.). Use the embed link for YouTube.', 'custom-tab'),
                        'placeholder' => __('https://www.youtube.com/embed/video_id', 'custom-tab'),
                        'condition' => [
                            'media_type' => 'video',
                        ],
                    ],
                    
                    [
                        'name' => 'tab_icon', // New control for the icon
                        'label' => __('Icon', 'custom-tab'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'media_type' => 'image', // You can specify this to ensure it only accepts images
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );



        $this->end_controls_section();


        // Slider Title Styling Section

        $this->start_controls_section(
            'section_slider_title_style',
            [
                'label' => __('Slider Title Style', 'custom-tab'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        // Padding Control
        $this->add_responsive_control(
            'slider_title_padding',
            [
                'label' => __('Padding', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .features-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin Control
        $this->add_responsive_control(
            'slider_title_margin',
            [
                'label' => __('Margin', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .features-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'slider_title_typography',
                'label' => __('Typography', 'custom-tab'),
                'selector' => '{{WRAPPER}} .features-title',
            ]
        );

        // Title Color Control
        $this->add_control(
            'slider_title_color',
            [
                'label' => __('Title Color', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .features-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Title Alignment Control
        $this->add_responsive_control(
            'slider_title_alignment',
            [
                'label' => __('Alignment', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'custom-tab'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'custom-tab'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'custom-tab'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .features-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();


        // Tab Title Styling Section
        $this->start_controls_section(
            'section_tab_title_style',
            [
                'label' => __('Tab Title Style', 'custom-tab'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography Control for Tab Title
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_title_typography',
                'label' => __('Tab Title Typography', 'custom-tab'),
                'selector' => '{{WRAPPER}} .tabs-navigation__title',
            ]
        );

        // Color Control for Tab Title
        $this->add_control(
            'tab_title_color',
            [
                'label' => __('Tab Title Color', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .tabs-navigation__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Padding Control for Tab Title
        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label' => __('Padding', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tabs-navigation__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin Control for Tab Title
        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label' => __('Margin', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tabs-navigation__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Tab Content Styling Section
        $this->start_controls_section(
            'section_tab_content_style',
            [
                'label' => __('Tab Content Style', 'custom-tab'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography Control for Tab Content
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_content_typography',
                'label' => __('Tab Content Typography', 'custom-tab'),
                'selector' => '{{WRAPPER}} .feature-tab__text',
            ]
        );

        // Color Control for Tab Content
        $this->add_control(
            'tab_content_color',
            [
                'label' => __('Tab Content Color', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .feature-tab__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Padding Control for Tab Content
        $this->add_responsive_control(
            'tab_content_padding',
            [
                'label' => __('Padding', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .feature-tab__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin Control for Tab Content
        $this->add_responsive_control(
            'tab_content_margin',
            [
                'label' => __('Margin', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .feature-tab__text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tab_navigation_item_style',
            [
                'label' => __('Tab Navigation Item Style', 'custom-tab'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Width Control for Tab Navigation Item
        $this->add_responsive_control(
            'tab_navigation_item_width',
            [
                'label' => __('Width', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabs-navigation__item' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height Control for Tab Navigation Item
        $this->add_responsive_control(
            'tab_navigation_item_height',
            [
                'label' => __('Height', 'custom-tab'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabs-navigation__item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Generate a unique ID for this instance of the widget
        $widget_id = $this->get_id(); // Unique ID for the widget instance

?>
        <div class="container">
            <div class="features-wrapper">
                <h2 class="features-title mb-4"><?php echo esc_html($settings['slider_title']); ?></h2> <!-- Dynamic Title -->
                <div class="features-tabs-container d-flex">
                    <div class="features-tabs__navigation tabs-navigation">
                        <div class="tabs-navigation__wrapper">
                            <ul class="tabs-navigation__list">
                                <?php foreach ($settings['tabs'] as $index => $tab) : ?>
                                    <li class="tabs-navigation__item <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $index + 1; ?>"> <!-- Match with features-tabs__item -->
                                        <div class="tabs-navigation__icon-wrap">
                                            <img width="56" height="56" src="<?php echo esc_url($tab['tab_icon']['url']); ?>" class="icon" alt="">
                                        </div>
                                        <div class="tabs-navigation__content">
                                            <h3 class="tabs-navigation__title"><?php echo esc_html($tab['tab_title']); ?></h3>
                                            <p class="feature-tab__text"><?php echo esc_html($tab['tab_content']); ?></p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tabs-navigation__indicate">
                                <div class="runner" id="runner-<?php echo esc_attr($widget_id); ?>"></div> <!-- Unique Runner ID -->
                            </div>
                        </div>
                    </div>

                    <div class="features-tabs">
                        <?php foreach ($settings['tabs'] as $index => $tab) : ?>
                            <div class="features-tabs__item feature-tab d-flex justify-content-center <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $index + 1; ?>"> <!-- Make sure this matches -->
                                <div class="feature-tab__media">
                                    <?php if ('image' === $tab['media_type']) : ?>
                                        <img width="600" height="400" src="<?php echo esc_url($tab['tab_image']['url']); ?>" class="feature-img" alt="Feature Image <?php echo $index + 1; ?>">
                                    <?php elseif ('video' === $tab['media_type']) : ?>
                                        <div class="feature-video">
                                            <?php
                                            // Check if the video URL is not empty and format it for embedding
                                            $video_url = is_string($tab['tab_video']) ? esc_url($tab['tab_video']) : ''; // Ensure it's a string before escaping


                                            // Extract the video ID from the URL if it's a standard YouTube URL
                                            if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video_url, $matches)) {
                                                $video_id = $matches[1];
                                                // Construct the embed URL
                                                $video_url = 'https://www.youtube.com/embed/' . $video_id;
                                            }
                                            ?>
                                            <iframe width="600" height="400" src="<?php echo $video_url; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
