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
define('EQUIPE_FOOT_CUSTOM_LOG_DIR', EQUIPE_FOOT_CUSTOM_DIR . 'logs');
define('EQUIPE_FOOT_CUSTOM_LOG', EQUIPE_FOOT_CUSTOM_LOG_DIR . '/error.log');

function equipe_foot_custom_log( $message ) {
    if ( ! is_dir( EQUIPE_FOOT_CUSTOM_LOG_DIR ) ) {
        wp_mkdir_p( EQUIPE_FOOT_CUSTOM_LOG_DIR );
    }
    $line = '[' . date('H:i:s') . '] ' . print_r($message, true) . PHP_EOL;
    error_log($line, 3, EQUIPE_FOOT_CUSTOM_LOG);
}
equipe_foot_custom_log('Equipe Foot Custom plugin loaded');
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-cpt-joueurs.php';
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-meta-box-joueurs.php';
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-taxonomie-categorie.php';
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-calculs-joueurs.php';
require_once EQUIPE_FOOT_CUSTOM_DIR . 'includes/class-cpt-entraineurs.php';

require_once EQUIPE_FOOT_CUSTOM_DIR .  'includes/class-cron-recalcul.php';

new Cron_Recalcul();
new CPT_Joueurs();
new Meta_Box_Joueurs(); 
new Taxonomie_Categorie();
new Calculs_Joueurs();
new CPT_Entraineurs();

register_activation_hook( __FILE__, array( 'Cron_Recalcul', 'on_activate' ) );

  register_deactivation_hook( __FILE__, function() {
      wp_clear_scheduled_hook( 'equipe_foot_custom_cron_recalcul' );
  } );
