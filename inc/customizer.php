<?php
/**
 * _s Theme Customizer
 *
 * @package schools
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function schools_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'schools_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function schools_customize_preview_js() {
	wp_enqueue_script( 'schools_customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'schools_customize_preview_js' );

/**
 * Options for Schools Theme Customizer.
 */
function schools_customizer( $wp_customize ) {
    
    /* Main option Settings Panel */
    $wp_customize->add_panel('schools_main_options', array(
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('Schools Options', 'schools'),
        'description' => __('Panel to update schools theme options', 'schools'), // Include html tags such as <p>.
        'priority' => 10 // Mixed with top-level-section hierarchy.
    ));

        $wp_customize->add_section('schools_layout_options', array(
            'title' => __('Layout options', 'schools'),
            'priority' => 31,
            'panel' => 'schools_main_options'
        ));
            // Layout options
            global $blog_layout;
            $wp_customize->add_setting('schools[blog_settings]', array(
                 'default' => '1',
                 'type' => 'option',
                 'sanitize_callback' => 'schools_sanitize_blog_layout'
            ));
            $wp_customize->add_control('schools[blog_settings]', array(
                 'label' => __('Blog Layout', 'schools'),
                 'section' => 'schools_layout_options',
                 'type'    => 'select',
                 'choices'    => $blog_layout
            ));
            
            global $site_layout;
            $wp_customize->add_setting('schools[site_layout]', array(
                 'default' => 'side-pull-left',
                 'type' => 'option',
                 'sanitize_callback' => 'schools_sanitize_layout'
            ));
            $wp_customize->add_control('schools[site_layout]', array(
                 'label' => __('Website Layout Options', 'schools'),
                 'section' => 'schools_layout_options',
                 'type'    => 'select',
                 'description' => __('Choose between different layout options to be used as default', 'schools'),
                 'choices'    => $site_layout
            ));

            $wp_customize->add_setting('schools[element_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[element_color]', array(
                'label' => __('Element Color', 'schools'),
                'description'   => __('Default used if no color is selected','schools'),
                'section' => 'schools_layout_options',
                'settings' => 'schools[element_color]',
            )));

            $wp_customize->add_setting('schools[element_color_hover]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[element_color_hover]', array(
                'label' => __('Element color on hover', 'schools'),
                'description'   => __('Default used if no color is selected','schools'),
                'section' => 'schools_layout_options',
                'settings' => 'schools[element_color_hover]',
            )));

        /* Schools Typography Options */
        $wp_customize->add_section('schools_typography_options', array(
            'title' => __('Typography', 'schools'),
            'priority' => 31,
            'panel' => 'schools_main_options'
        ));
            // Typography Defaults
            $typography_defaults = array(
                    'size'  => '14px',
                    'face'  => 'helvetica-neue',
                    'style' => 'normal',
                    'color' => '#6B6B6B'
            );
            // Typography Options
            global $typography_options;
            $wp_customize->add_setting('schools[main_body_typography][size]', array(
                'default' => $typography_defaults['size'],
                'type' => 'option',
                'sanitize_callback' => 'schools_sanitize_typo_size'
            ));
            $wp_customize->add_control('schools[main_body_typography][size]', array(
                'label' => __('Main Body Text', 'schools'),
                'description' => __('Used in p tags', 'schools'),
                'section' => 'schools_typography_options',
                'type'    => 'select',
                'choices'    => $typography_options['sizes']
            ));
            $wp_customize->add_setting('schools[main_body_typography][face]', array(
                'default' => $typography_defaults['face'],
                'type' => 'option',
                'sanitize_callback' => 'schools_sanitize_typo_face'
            ));
            $wp_customize->add_control('schools[main_body_typography][face]', array(
                'section' => 'schools_typography_options',
                'type'    => 'select',
                'choices'    => $typography_options['faces']
            ));
            $wp_customize->add_setting('schools[main_body_typography][style]', array(
                'default' => $typography_defaults['style'],
                'type' => 'option',
                'sanitize_callback' => 'schools_sanitize_typo_style'
            ));
            $wp_customize->add_control('schools[main_body_typography][style]', array(
                'section' => 'schools_typography_options',
                'type'    => 'select',
                'choices'    => $typography_options['styles']
            ));
            $wp_customize->add_setting('schools[main_body_typography][color]', array(
                'default' => $typography_defaults['color'],
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[main_body_typography][color]', array(
                'section' => 'schools_typography_options',
            )));

            $wp_customize->add_setting('schools[heading_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[heading_color]', array(
                'label' => __('Heading Color', 'schools'),
                'description'   => __('Color for all headings (h1-h6)','schools'),
                'section' => 'schools_typography_options',
            )));
            $wp_customize->add_setting('schools[link_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[link_color]', array(
                'label' => __('Link Color', 'schools'),
                'description'   => __('Default used if no color is selected','schools'),
                'section' => 'schools_typography_options',
            )));
            $wp_customize->add_setting('schools[link_hover_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[link_hover_color]', array(
                'label' => __('Link:hover Color', 'schools'),
                'description'   => __('Default used if no color is selected','schools'),
                'section' => 'schools_typography_options',
            )));
            
            $wp_customize->add_setting('schools[social_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[social_color]', array(
                'label' => __('Social icon color', 'schools'),
                'description' => sprintf(__('Default used if no color is selected', 'schools')),
                'section' => 'schools_typography_options',
            )));
            
            /* Schools Header Options */
        $wp_customize->add_section('schools_header_options', array(
            'title' => __('Header', 'schools'),
            'priority' => 31,
            'panel' => 'schools_main_options'
        ));
            $wp_customize->add_setting('schools[top_nav_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[top_nav_bg_color]', array(
                'label' => __('Top nav background color', 'schools'),
                'description'   => __('Default used if no color is selected','schools'),
                'section' => 'schools_header_options',
            )));
            $wp_customize->add_setting('schools[top_nav_link_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[top_nav_link_color]', array(
                'label' => __('Top nav item color', 'schools'),
                'description'   => __('Link color','schools'),
                'section' => 'schools_header_options',
            )));

            $wp_customize->add_setting('schools[top_nav_dropdown_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[top_nav_dropdown_bg]', array(
                'label' => __('Top nav dropdown background color', 'schools'),
                'description'   => __('Background of dropdown item hover color','schools'),
                'section' => 'schools_header_options',
            )));

            $wp_customize->add_setting('schools[top_nav_dropdown_item]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[top_nav_dropdown_item]', array(
                'label' => __('Top nav dropdown item color', 'schools'),
                'description'   => __('Dropdown item color','schools'),
                'section' => 'schools_header_options',
            )));

        /* Schools Footer Options */
        $wp_customize->add_section('schools_footer_options', array(
            'title' => __('Footer', 'schools'),
            'priority' => 31,
            'panel' => 'schools_main_options'
        ));

            $wp_customize->add_setting('schools[footer_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[footer_bg_color]', array(
                'label' => __('Footer background color', 'schools'),
                'section' => 'schools_footer_options',
            )));

            $wp_customize->add_setting('schools[footer_text_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[footer_text_color]', array(
                'label' => __('Footer text color', 'schools'),
                'section' => 'schools_footer_options',
            )));

            $wp_customize->add_setting('schools[footer_link_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'schools_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'schools[footer_link_color]', array(
                'label' => __('Footer link color', 'schools'),
                'section' => 'schools_footer_options',
            )));

            $wp_customize->add_setting('schools[custom_footer_text]', array(
                'default' => '',
                'type' => 'option',
                'sanitize_callback' => 'schools_sanitize_strip_slashes'
            ));
            $wp_customize->add_control('schools[custom_footer_text]', array(
                'label' => __('Footer information', 'schools'),
                'description' => sprintf(__('Copyright text in footer', 'schools')),
                'section' => 'schools_footer_options',
                'type' => 'textarea'
            ));

        /* Schools Content Options */
        $wp_customize->add_section('schools_content_options', array(
            'title' => __('Content Options', 'schools'),
            'priority' => 31,
            'panel' => 'schools_main_options'
        ));
            $wp_customize->add_setting('schools[single_post_image]', array(
                'default' => 1,
                'type' => 'option',
                'sanitize_callback' => 'schools_sanitize_strip_slashes'
            ));
            $wp_customize->add_control('schools[single_post_image]', array(
                'label' => __('Display Featured Image on Single Post', 'schools'),
                'section' => 'schools_content_options',
                'type' => 'checkbox'
            ));

        /* Schools Other Options */
        $wp_customize->add_section('schools_other_options', array(
            'title' => __('Other', 'schools'),
            'priority' => 31,
            'panel' => 'schools_main_options'
        ));
            $wp_customize->add_setting('schools[custom_css]', array(
                'default' => '',
                'type' => 'option',
                'sanitize_callback' => 'schools_sanitize_strip_slashes'
            ));
            $wp_customize->add_control('schools[custom_css]', array(
                'label' => __('Custom CSS', 'schools'),
                'description' => sprintf(__('Additional CSS', 'schools')),
                'section' => 'schools_other_options',
                'type' => 'textarea'
            ));

        $wp_customize->add_section('schools_important_links', array(
            'priority' => 5,
            'title' => __('Support and Documentation', 'schools')
        ));
            $wp_customize->add_setting('schools[imp_links]', array(
              'sanitize_callback' => 'esc_url_raw'
            ));
            $wp_customize->add_control(
            new Schools_Important_Links(
            $wp_customize,
                'schools[imp_links]', array(
                'section' => 'schools_important_links',
                'type' => 'schools-important-links'
            )));

}
add_action( 'customize_register', 'schools_customizer' );



/**
 * Sanitize checkbox for WordPress customizer
 */
function schools_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
/**
 * Adds sanitization callback function: colors
 * @package Schools
 */
function schools_sanitize_hexcolor($color) {
    if ($unhashed = sanitize_hex_color_no_hash($color))
        return '#' . $unhashed;
    return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package Schools
 */
function schools_sanitize_nohtml($input) {
    return wp_filter_nohtml_kses($input);
}

/**
 * Adds sanitization callback function: Number
 * @package Schools
 */
function schools_sanitize_number($input) {
    if ( isset( $input ) && is_numeric( $input ) ) {
        return $input;
    }
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package Schools
 */
function schools_sanitize_strip_slashes($input) {
    return wp_kses_stripslashes($input);
}

/**
 * Adds sanitization callback function: Slider Category
 * @package Schools
 */
function schools_sanitize_slidecat( $input ) {
    global $options_categories;
    if ( array_key_exists( $input, $options_categories ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package Schools
 */
function schools_sanitize_blog_layout( $input ) {
    global $blog_layout;
    if ( array_key_exists( $input, $blog_layout ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package Schools
 */
function schools_sanitize_layout( $input ) {
    global $site_layout;
    if ( array_key_exists( $input, $site_layout ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Typography Size
 * @package Schools
 */
function schools_sanitize_typo_size( $input ) {
    global $typography_options,$typography_defaults;
    if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
        return $input;
    } else {
        return $typography_defaults['size'];
    }
}
/**
 * Adds sanitization callback function: Typography Face
 * @package Schools
 */
function schools_sanitize_typo_face( $input ) {
    global $typography_options,$typography_defaults;
    if ( array_key_exists( $input, $typography_options['faces'] ) ) {
        return $input;
    } else {
        return $typography_defaults['face'];
    }
}
/**
 * Adds sanitization callback function: Typography Style
 * @package Schools
 */
function schools_sanitize_typo_style( $input ) {
    global $typography_options,$typography_defaults;
    if ( array_key_exists( $input, $typography_options['styles'] ) ) {
        return $input;
    } else {
        return $typography_defaults['style'];
    }
}

/**
 * Add CSS for custom controls
 */
function schools_customizer_custom_control_css() {
	?>
    <style>
        #customize-control-schools-main_body_typography-size select, #customize-control-schools-main_body_typography-face select,#customize-control-schools-main_body_typography-style select { width: 60%; }
    </style><?php
}
add_action( 'customize_controls_print_styles', 'schools_customizer_custom_control_css' );

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
/**
 * Class to create a Schools important links
 */
class Schools_Important_Links extends WP_Customize_Control {

   public $type = "schools-important-links";

   public function render_content() {?>
        <!-- Twitter -->
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

        <!-- Facebook -->
        <div id="fb-root"></div>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=328285627269392";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <div class="inside">
            <div id="social-share">
              <div class="fb-like" data-href="https://www.facebook.com/colorlib" data-send="false" data-layout="button_count" data-width="90" data-show-faces="true"></div>
              <div class="tw-follow" ><a href="https://twitter.com/colorlib" class="twitter-follow-button" data-show-count="false">Follow @colorlib</a></div>
            </div>
            <p><b><a href="http://colorlib.com/wp/support/schools"><?php _e('Schools Documentation','schools'); ?></a></b></p>
            <p><?php _e('The best way to contact us with <b>support questions</b> and <b>bug reports</b> is via','schools') ?> <a href="http://colorlib.com/wp/forums"><?php _e('Colorlib support forum','schools') ?></a>.</p>
            <p><?php _e('If you like this theme, I\'d appreciate any of the following:','schools') ?></p>
            <ul>
                <li><a class="button" href="http://wordpress.org/support/view/theme-reviews/schools?filter=5" title="<?php esc_attr_e('Rate this Theme', 'schools'); ?>" target="_blank"><?php printf(__('Rate this Theme','schools')); ?></a></li>
                <li><a class="button" href="http://www.facebook.com/colorlib" title="Like Colorlib on Facebook" target="_blank"><?php printf(__('Like on Facebook','schools')); ?></a></li>
                <li><a class="button" href="http://twitter.com/colorlib/" title="Follow Colrolib on Twitter" target="_blank"><?php printf(__('Follow on Twitter','schools')); ?></a></li>
            </ul>
        </div><?php
   }

}

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'customizer_custom_scripts' );

function customizer_custom_scripts() { ?>
<style>
    li#accordion-section-schools_important_links h3.accordion-section-title, li#accordion-section-schools_important_links h3.accordion-section-title:focus { background-color: #00cc00 !important; color: #fff !important; }
    li#accordion-section-schools_important_links h3.accordion-section-title:hover { background-color: #00b200 !important; color: #fff !important; }
    li#accordion-section-schools_important_links h3.accordion-section-title:after { color: #fff !important; }
</style>
<?php
}