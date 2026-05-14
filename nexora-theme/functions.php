<?php
/**
 * Nexora Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NEXORA_VERSION', '1.0.0' );
define( 'NEXORA_DIR', get_template_directory() );
define( 'NEXORA_URI', get_template_directory_uri() );

// ── Theme Setup ──────────────────────────────────────────────
function nexora_setup() {
    load_theme_textdomain( 'nexora', NEXORA_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'nexora' ),
        'footer'  => __( 'Footer Navigation', 'nexora' ),
    ] );
}
add_action( 'after_setup_theme', 'nexora_setup' );

// ── Enqueue Styles & Scripts ─────────────────────────────────
function nexora_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'nexora-fonts',
        'https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'nexora-style',
        NEXORA_URI . '/assets/css/main.css',
        [ 'nexora-fonts' ],
        NEXORA_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'nexora-main',
        NEXORA_URI . '/assets/js/main.js',
        [],
        NEXORA_VERSION,
        true // load in footer
    );

    // Pass PHP data to JS
    wp_localize_script( 'nexora-main', 'nexoraData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'nexora_nonce' ),
        'homeUrl' => home_url(),
    ] );
}
add_action( 'wp_enqueue_scripts', 'nexora_enqueue_assets' );

// ── Customizer Settings ───────────────────────────────────────
function nexora_customizer( $wp_customize ) {

    // ── Hero Section ──
    $wp_customize->add_section( 'nexora_hero', [
        'title'    => __( 'Hero Section', 'nexora' ),
        'priority' => 30,
    ] );

    $fields = [
        'hero_badge_text'  => [ 'label' => 'Badge Text',    'default' => 'Built on WordPress — Powered by Blocks' ],
        'hero_title_line1' => [ 'label' => 'Title Line 1',  'default' => 'Build stunning websites' ],
        'hero_title_line2' => [ 'label' => 'Title Line 2',  'default' => 'without writing code.' ],
        'hero_subtitle'    => [ 'label' => 'Subtitle',      'default' => 'Nexora is the WordPress theme and plugin suite that transforms the block editor into a full no-code design studio.' ],
        'hero_btn1_text'   => [ 'label' => 'Button 1 Text', 'default' => 'Start for free →' ],
        'hero_btn1_url'    => [ 'label' => 'Button 1 URL',  'default' => '#' ],
        'hero_btn2_text'   => [ 'label' => 'Button 2 Text', 'default' => 'See live demo' ],
        'hero_btn2_url'    => [ 'label' => 'Button 2 URL',  'default' => '#' ],
        'hero_stat1_num'   => [ 'label' => 'Stat 1 Number', 'default' => '50K+' ],
        'hero_stat1_label' => [ 'label' => 'Stat 1 Label',  'default' => 'Active websites' ],
        'hero_stat2_num'   => [ 'label' => 'Stat 2 Number', 'default' => '4.9★' ],
        'hero_stat2_label' => [ 'label' => 'Stat 2 Label',  'default' => 'Average rating' ],
        'hero_stat3_num'   => [ 'label' => 'Stat 3 Number', 'default' => '200+' ],
        'hero_stat3_label' => [ 'label' => 'Stat 3 Label',  'default' => 'Starter templates' ],
    ];

    foreach ( $fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'nexora_hero', 'type' => 'text' ] );
    }

    // ── CTA Section ──
    $wp_customize->add_section( 'nexora_cta', [
        'title'    => __( 'CTA Section', 'nexora' ),
        'priority' => 60,
    ] );
    $cta_fields = [
        'cta_title'    => [ 'label' => 'CTA Title',    'default' => 'Ready to build something beautiful?' ],
        'cta_subtitle' => [ 'label' => 'CTA Subtitle', 'default' => 'Join 50,000+ creators who already use Nexora to build stunning WordPress sites — no coding required.' ],
        'cta_btn1'     => [ 'label' => 'Button 1',     'default' => 'Start for free →' ],
        'cta_btn2'     => [ 'label' => 'Button 2',     'default' => 'View all templates' ],
    ];
    foreach ( $cta_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'nexora_cta', 'type' => 'text' ] );
    }

    // ── Footer ──
    $wp_customize->add_section( 'nexora_footer', [
        'title'    => __( 'Footer', 'nexora' ),
        'priority' => 70,
    ] );
    $wp_customize->add_setting( 'footer_description', [
        'default'           => 'The most powerful WordPress theme and plugin suite for creators, designers, and agencies.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ] );
    $wp_customize->add_control( 'footer_description', [
        'label'   => __( 'Footer Description', 'nexora' ),
        'section' => 'nexora_footer',
        'type'    => 'textarea',
    ] );
    $wp_customize->add_setting( 'footer_copyright', [
        'default'           => '© 2025 Nexora. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'footer_copyright', [
        'label'   => __( 'Copyright Text', 'nexora' ),
        'section' => 'nexora_footer',
        'type'    => 'text',
    ] );
}
add_action( 'customize_register', 'nexora_customizer' );

// ── Custom Post Type: Features ─────────────────────────────────
function nexora_register_post_types() {
    register_post_type( 'nexora_feature', [
        'labels'       => [
            'name'          => __( 'Features', 'nexora' ),
            'singular_name' => __( 'Feature', 'nexora' ),
            'add_new_item'  => __( 'Add New Feature', 'nexora' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => [ 'title', 'editor', 'custom-fields' ],
        'menu_icon'    => 'dashicons-star-filled',
        'menu_position' => 25,
    ] );

    register_post_type( 'nexora_testimonial', [
        'labels'       => [
            'name'          => __( 'Testimonials', 'nexora' ),
            'singular_name' => __( 'Testimonial', 'nexora' ),
            'add_new_item'  => __( 'Add New Testimonial', 'nexora' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => [ 'title', 'editor', 'custom-fields' ],
        'menu_icon'    => 'dashicons-format-quote',
        'menu_position' => 26,
    ] );

    register_post_type( 'nexora_pricing', [
        'labels'       => [
            'name'          => __( 'Pricing Plans', 'nexora' ),
            'singular_name' => __( 'Pricing Plan', 'nexora' ),
            'add_new_item'  => __( 'Add New Plan', 'nexora' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => [ 'title', 'custom-fields' ],
        'menu_icon'    => 'dashicons-tag',
        'menu_position' => 27,
    ] );
}
add_action( 'init', 'nexora_register_post_types' );

// ── Helper: get_theme_mod with fallback ───────────────────────
function nexora_mod( $key, $default = '' ) {
    return esc_html( get_theme_mod( $key, $default ) );
}

// ── Helper: get features from CPT ────────────────────────────
function nexora_get_features() {
    $query = new WP_Query( [
        'post_type'      => 'nexora_feature',
        'posts_per_page' => 6,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ] );

    // If no CPT posts, return defaults
    if ( ! $query->have_posts() ) {
        return [
            [ 'icon' => '🎨', 'title' => 'Visual Block Editor',    'desc' => 'Drag, drop, and design every part of your site with our extended Gutenberg block library — no coding required.' ],
            [ 'icon' => '⚡', 'title' => '99/100 PageSpeed',       'desc' => 'Critical CSS, lazy loading, and automatic WebP conversion baked in. Your site flies out of the box.' ],
            [ 'icon' => '📱', 'title' => 'Responsive by Default',  'desc' => 'Every template is mobile-first. Preview and fine-tune breakpoints directly in the editor with live feedback.' ],
            [ 'icon' => '🛒', 'title' => 'WooCommerce Ready',      'desc' => 'Beautiful shop pages, product blocks, and checkout templates pre-built and ready to sell from day one.' ],
            [ 'icon' => '🔒', 'title' => 'Security Hardened',      'desc' => 'Two-factor auth, login protection, malware scanning, and automated backups included in every plan.' ],
            [ 'icon' => '📊', 'title' => 'Built-in Analytics',     'desc' => 'Cookie-free, GDPR-compliant analytics right inside your dashboard. No third-party scripts needed.' ],
        ];
    }

    $features = [];
    while ( $query->have_posts() ) {
        $query->the_post();
        $features[] = [
            'icon'  => get_post_meta( get_the_ID(), '_feature_icon', true ) ?: '✨',
            'title' => get_the_title(),
            'desc'  => get_the_content(),
        ];
    }
    wp_reset_postdata();
    return $features;
}

// ── Helper: get testimonials from CPT ────────────────────────
function nexora_get_testimonials() {
    $query = new WP_Query( [
        'post_type'      => 'nexora_testimonial',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ] );

    if ( ! $query->have_posts() ) {
        return [
            [ 'text' => '"Nexora completely changed how I build client sites. What used to take days now takes a few hours. The templates are stunning."', 'name' => 'Sarah Rahman',  'role' => 'Freelance Web Designer',    'initials' => 'SR' ],
            [ 'text' => '"The performance alone sold me. My PageSpeed score jumped from 62 to 97 after switching. My clients noticed the difference immediately."',  'name' => 'Marco Klein',   'role' => 'Digital Marketing Agency',   'initials' => 'MK' ],
            [ 'text' => '"I built my entire online store in a weekend using Nexora\'s WooCommerce templates. Clean, fast, and easy. I can\'t recommend it enough."', 'name' => 'Ayesha Patel',  'role' => 'E-commerce Founder',         'initials' => 'AP' ],
        ];
    }

    $testimonials = [];
    while ( $query->have_posts() ) {
        $query->the_post();
        $name = get_post_meta( get_the_ID(), '_testi_name', true );
        $testimonials[] = [
            'text'     => get_the_content(),
            'name'     => $name ?: get_the_title(),
            'role'     => get_post_meta( get_the_ID(), '_testi_role', true ) ?: '',
            'initials' => strtoupper( substr( $name, 0, 2 ) ) ?: 'NX',
        ];
    }
    wp_reset_postdata();
    return $testimonials;
}

// ── Helper: get pricing from CPT ─────────────────────────────
function nexora_get_pricing() {
    $query = new WP_Query( [
        'post_type'      => 'nexora_pricing',
        'posts_per_page' => 3,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ] );

    if ( ! $query->have_posts() ) {
        return [
            [
                'name'     => 'Starter', 'price' => '0', 'period' => 'Free forever',
                'featured' => false,
                'features' => [ '1 website', '20 starter templates', 'Core blocks included', 'Community support', 'Basic analytics' ],
                'btn_text' => 'Get started free', 'btn_style' => 'ghost',
            ],
            [
                'name'     => 'Pro', 'price' => '29', 'period' => 'per month, billed annually',
                'featured' => true,
                'features' => [ '5 websites', '200+ premium templates', 'All Pro blocks', 'Priority email support', 'Advanced analytics', 'WooCommerce blocks' ],
                'btn_text' => 'Start 14-day trial →', 'btn_style' => 'primary',
            ],
            [
                'name'     => 'Agency', 'price' => '79', 'period' => 'per month, billed annually',
                'featured' => false,
                'features' => [ 'Unlimited websites', 'All templates + new drops', 'White-label option', '24/7 priority support', 'Client management portal', 'Team accounts (5 seats)' ],
                'btn_text' => 'Contact sales', 'btn_style' => 'ghost',
            ],
        ];
    }

    $plans = [];
    while ( $query->have_posts() ) {
        $query->the_post();
        $id = get_the_ID();
        $raw_features = get_post_meta( $id, '_pricing_features', true );
        $plans[] = [
            'name'      => get_the_title(),
            'price'     => get_post_meta( $id, '_pricing_price', true ) ?: '0',
            'period'    => get_post_meta( $id, '_pricing_period', true ) ?: '',
            'featured'  => (bool) get_post_meta( $id, '_pricing_featured', true ),
            'features'  => $raw_features ? explode( "\n", $raw_features ) : [],
            'btn_text'  => get_post_meta( $id, '_pricing_btn_text', true ) ?: 'Get started',
            'btn_style' => get_post_meta( $id, '_pricing_btn_style', true ) ?: 'ghost',
        ];
    }
    wp_reset_postdata();
    return $plans;
}
