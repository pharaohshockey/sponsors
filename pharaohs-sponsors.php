<?php
    /*
    Plugin Name: Pharaohs Sponsors
    Plugin URI: https://github.com/pharaohshockey/
    Description: Create a custom post type for the Sponsors.
    Version: 0.1
    Author: Pat McGhen
    Author URI: http://mcghen.com
    License: WTFPL
    License URI: http://www.wtfpl.net/
    */

    function pharaohs_create_sponsors () {
        register_post_type('sponsors', array (
            'labels' => array (
                'name'          => __('Sponsors'),
                'singular_name' => __('Sponsor'),
                'add_new_item'  => __('Add New Sponsor'),
                'edit_item'     => __('Edit Sponsor')
                ),
            'description'   => 'A place to recognize our great sponsors!',
            'public'        => true,
            'menu_position' => 5,
            'menu_icon'     => 'dashicons-nametag',
            'has_archive'   => true,
            'supports'      => array (
                'title',
                'editor',
                'thumbnail',
                'page-attributes',
                'custom-fields'
                )
            )
        );
    }

    function pharaohs_sponsors_admin () {
        add_meta_box('pharaohs-sponsors-meta-box',
                     'Sponsor link:',
                     'pharaohs_display_sponsors_meta_box',
                     'normal',
                     'high');
    }

    function pharaohs_display_sponsors_meta_box ($sponsor) {
        // Retrieve the current sponsor's name and URL
        $sponsor_name = the_title();
        $sponsor_url  = esc_html(get_post_meta($sponsor->partner_url, 'sponsor_url', true));
    ?>
        <div class="pharaohs-meta-field">
            <label for="pharaohs-sponsor-name">Name:</label>
            <input name="pharaohs-sponsor-name">
        </div>
        <div class="pharaohs-meta-field">
            <label for="pharaohs-sponsor-url">Sponsor Link:</label>
            <input name="pharaohs-sponsor-url">
        </div>
    <?php
    }

    function pharaohs_add_sponsor ($sponsor_id, $sponsor) {
        // Check the post type for sponsor
        if ($sponsor->post_type == 'sponsors') {
            // Store data in post meta table
            if (isset($_POST['pharaohs-sponsor-name']) && $_POST['pharaohs-sponsor-name'] !== '') {
                update_post_meta($sponsor_id, 'sponsor', $_POST['pharaohs-sponsor-name']);
            }

            if (isset($_POST['pharaohs-sponsor-url']) && $_POST['pharaohs-sponsor-url'] !== '') {
                update_post_meta($sponsor_url, 'sponsor', $_POST['pharaohs-sponsor-url']);
            }
        }
    }

    add_action('save_post', 'pharaohs_add_sponsor', 10, 2);
    add_action('admin_init', 'pharaohs_sponsors_admin');
    add_action('init', 'pharaohs_create_sponsors');
?>
