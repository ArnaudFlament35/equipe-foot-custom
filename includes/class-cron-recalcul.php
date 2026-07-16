<?php

class Cron_Recalcul
{
    public function __construct()
    {
        add_filter('cron_schedules', array($this, 'equipe_foot_custom_add_cron_schedule'));

        add_action('equipe_foot_custom_cron_recalcul', array($this, 'equipe_foot_custom_execute_cron_recalcul'));
    }
    public static function on_activate()
    {

        $date = new Datetime();
        $prochain_sept = new Datetime($date->format('Y') . '-09-01 00:00:00');

        if ($date > $prochain_sept) {
            $prochain_sept->modify('+1 year');
        }
        $timestamp = $prochain_sept->getTimestamp();

        if (! wp_next_scheduled('equipe_foot_custom_cron_recalcul')) {
            wp_schedule_event($timestamp, 'yearly', 'equipe_foot_custom_cron_recalcul');
        }
    }

    public function equipe_foot_custom_add_cron_schedule($schedules)
    {
        $schedules['yearly'] = array(
            'interval' => 31536000, // 1 an en secondes
            'display'  => __('Once Yearly'),
        );
        return $schedules;
    }


    public function equipe_foot_custom_execute_cron_recalcul()
    {
        $joueurs = get_posts(array(
            'post_type'      => array('joueurs'),
            'posts_per_page' => -1,
        ));
        $calculs_joueurs = new Calculs_Joueurs();
        foreach ($joueurs as $joueur) {
            $calculs_joueurs->equipe_foot_custom_assigner_categorie($joueur->ID);
        }
    }
}
