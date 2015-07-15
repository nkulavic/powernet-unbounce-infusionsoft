<?php
/*
Plugin Name: Powernet Media Unbounce - Infusionsoft Referral API Link
Plugin URI: http://nickkulavic.com
Description: Allows Unbounce webforms to be integrated with Infusionsoft via webhooks to add a referral tracking entry to the contact.
Version: 0.10
Author: Nick Kulavic
Author Email: nick@nickkulavic.com
License:

  Copyright 2011 Nick Kulavic (nick@nickkulavic.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
class MFSUnbounceInfusionsoftSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array(
            $this,
            'add_plugin_page'
        ));
        add_action('admin_init', array(
            $this,
            'page_init'
        ));
    }
    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page('Settings Admin', 'MFS Unbounce Infusion', 'manage_options', 'mfs-unbounce-infusionsoft-setting-admin', array(
            $this,
            'create_admin_page'
        ));
    }
    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('MFSUnbounceInfusionsoft');
?>
        <div class="wrap">
            <h2>Powernet Media - Unbounce - Infusionsoft Settings</h2>
            <form method="post" action="options.php">
            <?php
        // This prints out all hidden setting fields
        settings_fields('MFSUnbounceInfusionsoft_option_group');
        do_settings_sections('mfs-unbounce-infusionsoft-admin');
        submit_button();
?>
            </form>
        </div>
        <?php
    }
    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting('MFSUnbounceInfusionsoft_option_group', // Option group
            'MFSUnbounceInfusionsoft', // Option name
            array(
            $this,
            'sanitize'
        ) // Sanitize
            );
        add_settings_section('setting_section_id', // ID
            '', // infusionsoft_key
            array(
            $this,
            'print_section_info'
        ), // Callback
            'mfs-unbounce-infusionsoft-admin' // Page
            );
        add_settings_field('infusionsoft_app', // ID
            'Infusionsoft Application Name', // infusionsoft_key
            array(
            $this,
            'infusionsoft_app_callback'
        ), // Callback
            'mfs-unbounce-infusionsoft-admin', // Page
            'setting_section_id' // Section
            );
        add_settings_field('infusionsoft_key', 'Infusionsoft API Key', array(
            $this,
            'infusionsoft_key_callback'
        ), 'mfs-unbounce-infusionsoft-admin', 'setting_section_id');
    }
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['infusionsoft_app']))
            $new_input['infusionsoft_app'] = $input['infusionsoft_app'];
        if (isset($input['infusionsoft_key']))
            $new_input['infusionsoft_key'] = sanitize_text_field($input['infusionsoft_key']);
        return $new_input;
    }
    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your Infusionsoft settings below:';
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function infusionsoft_app_callback()
    {
        printf('<input type="text" id="infusionsoft_app" name="MFSUnbounceInfusionsoft[infusionsoft_app]" value="%s" />', isset($this->options['infusionsoft_app']) ? esc_attr($this->options['infusionsoft_app']) : '');
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function infusionsoft_key_callback()
    {
        printf('<input type="text" id="infusionsoft_key" name="MFSUnbounceInfusionsoft[infusionsoft_key]" value="%s" />', isset($this->options['infusionsoft_key']) ? esc_attr($this->options['infusionsoft_key']) : '');
    }
}
if (is_admin())
    $MFSUnbounceInfusionsoft_settings_page = new MFSUnbounceInfusionsoftSettingsPage();
if(isset($_GET['action']) &  ($_GET['action'] === 'PowerNet')) {
    require_once("link.php");
  }
