<?php

class Topbanner {

    /**
     * Register hooks.
     */
    public function register_hooks() {
        // Enqueue styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));

        // Add banner to the frontend
        add_action('wp_footer', array($this, 'display_banner'));

        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Register settings
        add_action('admin_init', array($this, 'register_settings'));

    }

    /**
     * Enqueue styles.
     */
    public function enqueue_styles() {
        if (!is_admin()) {  
            wp_enqueue_style('tfb-banner-style', plugin_dir_url(__FILE__) . '../assets/css/tfb-style.css', array(), '1.0');
        }
    }

    /**
     * Display the banner on the front end.
     */
    public function display_banner() {
        $banner_text = get_option('tfb_banner_text', __('Default Banner Text', 'topbanner'));

        if (!empty($banner_text)) {
            echo '<div id="tfb-banner">' . esc_html($banner_text) . '</div>';
        }
    }

    /**
     * Add the banner settings menu to the admin panel.
     */
    public function add_admin_menu() {
        add_menu_page(
            __('TopBanner Settings', 'topbanner'),
            __('Banner Settings', 'topbanner'),
            'manage_options',
            'tfb-banner-settings',
            array($this, 'banner_settings_page'),
            'dashicons-welcome-widgets-menus',
            100
        );
    }

    /**
     * Register custom settings.
     */
    public function register_settings() {
        register_setting('tfb_settings_group', 'tfb_banner_text', array('sanitize_callback' => 'sanitize_text_field'));
    }

    /**
     * Display the settings page.
     */
    public function banner_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('TopBanner Settings', 'topbanner'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('tfb_settings_group');
                do_settings_sections('tfb_settings_group');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Banner Text', 'topbanner'); ?></th>
                        <td>
                            <input type="text" name="tfb_banner_text" value="<?php echo esc_attr(get_option('tfb_banner_text')); ?>" style="width: 400px;" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }


    /**
     * Plugin activation hook.
     */
    public static function activate() {
        // Default options
        if (!get_option('tfb_banner_text')) {
            update_option('tfb_banner_text', __('Default Banner Text', 'topbanner'));
        }
    }

    /**
     * Plugin deactivation hook.
     */
    public static function deactivate() {
        // Optionally clean up options here, or leave them for potential reactivation
    }
}
