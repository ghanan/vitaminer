<?php
/* Information Header Goes here */
/*
  Plugin Name: Vitaminas-Minerales en cabecera
  Plugin URI: http://antovar.260mb.com
  Description: Plugin para mostrar vitaminas y minerales en la cabecera
  Author: Antonio Tovar
  Version: 1.0
  Author URI: http://antovar.260mb.com
*/
// include() or require() any necessary files here...
include_once('includes/captura_datos.php');
// Settings and/or Configuration Details go here...
// Tie into WordPress Hooks and any functions that should run on load.
add_action('admin_menu', 'atc_admin_actions');
// "Private" internal functions named with a leading underscore
//function _diggthis_get_post_url() { }
// The "Public" functions
function atc_admin_actions() {
    add_options_page("Vitaminas Display", "Vitaminas y Minerales", 1, "Minerales Display", "vitaminer_captura_datos");
    // add_options_page("Vitaminas Display", "Vitaminas y Minerales", 1, page, "vitaminer_captura_datos");
}
/* EOF */
