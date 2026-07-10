<?php

class Taxonomie_Categorie {
    public function __construct() {
        add_action( 'init', array( $this, 'equipe_foot_custom_register_taxonomie_categorie' ) );
    }

   public function equipe_foot_custom_register_taxonomie_categorie() {
    $labels = array(
        'name'          => 'Catégories',
        'singular_name' => 'Catégorie',
        'menu_name'     => 'Catégories',
    );

    register_taxonomy( 'categorie_joueur', 'joueurs', array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
    ) );
}
}