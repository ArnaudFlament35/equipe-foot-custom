<?php

class CPT_Joueurs {
    public function __construct() {
        add_action( 'init', array( $this, 'equipe_foot_custom_register_joueurs_post_types' ) );
        add_action( 'init', array( $this, 'joueurs_register_meta' ) );
        add_action( 'save_post_joueurs', array( $this, 'joueurs_sauvegarder_meta' ));
    }
    public function equipe_foot_custom_register_joueurs_post_types() {
	// La déclaration de nos Custom Post Types et Taxonomies ira ici
     // CPT Portfolio
     $labels = array(
        'name' => 'Joueurs',
        'all_items' => 'Tous les joueurs',  // affiché dans le sous menu
        'singular_name' => 'Joueur',
        'add_new_item' => 'Ajouter un joueur',
        'edit_item' => 'Modifier le joueur',
        'menu_name' => 'Joueurs'
    );

	$args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor','thumbnail' ),
        'menu_position' => 5, 
        'menu_icon' => 'dashicons-buddicons-buddypress-logo',
	);

	register_post_type( 'joueurs', $args );

}

public function joueurs_register_meta() {
    $fields = array(
        'date_naissance' => array(
            'type'   => 'string',
            'format' => 'date',
        ),
        'poste' => array(
            'type' => 'string',
        ),
        'numero_prefere' => array(
            'type' => 'integer',
        ),
    );

    foreach ( $fields as $key => $config ) {
        register_post_meta( 'joueurs', $key, array(
            'type'              => $config['type'],
            'single'            => true,
            'show_in_rest'      => true, // indispensable : expose le champ dans l'API REST + block editor
            'sanitize_callback' => $config['type'] === 'integer' ? 'absint' : 'sanitize_text_field',
            'auth_callback'     => function() {
                return current_user_can( 'edit_posts' );
            },
        ) );
    }
}


public function joueurs_sauvegarder_meta( $post_id ) {
    if ( ! isset( $_POST['joueurs_meta_nonce'] ) || ! wp_verify_nonce( $_POST['joueurs_meta_nonce'], 'joueurs_sauvegarder_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['joueurs_date_naissance'] ) ) {
        update_post_meta( $post_id, 'date_naissance', sanitize_text_field( $_POST['joueurs_date_naissance'] ) );
    }
    if ( isset( $_POST['joueurs_poste'] ) ) {
        update_post_meta( $post_id, 'poste', sanitize_text_field( $_POST['joueurs_poste'] ) );
    }
    if ( isset( $_POST['joueurs_numero_prefere'] ) ) {
        update_post_meta( $post_id, 'numero_prefere', absint( $_POST['joueurs_numero_prefere'] ) );
    }
}

}