<?php

class CPT_Entraineurs {
    public function __construct() {
        add_action( 'init', array( $this, 'equipe_foot_custom_register_entraineurs_post_types' ) );
    }
    public function equipe_foot_custom_register_entraineurs_post_types() {
    // La déclaration de nos Custom Post Types et Taxonomies ira ici

     $labels = array(
        'name' => 'Entraineurs',
        'all_items' => 'Tous les entraineurs',  // affiché dans le sous menu
        'singular_name' => 'Entraineur',
        'add_new_item' => 'Ajouter un entraineur',
        'edit_item' => 'Modifier l\'entraineur',
        'menu_name' => 'Entraineurs'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array( 'title','thumbnail' ),
        'menu_position' => 6, 
        'menu_icon' => 'dashicons-admin-users',
    );

    register_post_type( 'entraineurs', $args );

}
}