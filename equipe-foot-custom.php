<?php
/**
* Plugin Name: Equipe Foot Custom
* Plugin URI:  https://github.com/ArnaudFlament35/equipe-foot-custom
* Description: Ajoutez un CPT pour les joueurs de l'équipe de foot.
* Version:     1.0.0
* Author:      Arnaud Flament
* Author URI:  https://github.com/ArnaudFlament35
* Text Domain: equipe-foot-custom
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


define( 'EQUIPE_FOOT_CUSTOM_VERSION', '1.0.0' );
define( 'EQUIPE_FOOT_CUSTOM_DIR', plugin_dir_path( __FILE__ ) );
define( 'EQUIPE_FOOT_CUSTOM_URL', plugin_dir_url( __FILE__ ) );
define('EQUIPE_FOOT_CUSTOM_LOG', EQUIPE_FOOT_CUSTOM_DIR . '/logs/error.log');

function equipe_foot_custom_log( $message ) {
    $line = '[' . date('H:i:s') . '] ' . print_r($message, true) . PHP_EOL;
    error_log($line, 3, EQUIPE_FOOT_CUSTOM_LOG);
}
equipe_foot_custom_log('Equipe Foot Custom plugin loaded');
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-cpt-joueurs.php';
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-meta-box-joueurs.php';
new CPT_Joueurs();
new Meta_Box_Joueurs(); 