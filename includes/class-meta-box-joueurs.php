<?php

class Meta_Box_Joueurs {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'equipe_foot_custom_add_meta_boxes' ) );
        add_action( 'save_post_joueurs', array( $this, 'equipe_foot_custom_sauvegarder_meta' ) );
    }
    // --- Meta box : informations du joueur ---


public function equipe_foot_custom_add_meta_boxes() {
    add_meta_box(
        'joueurs_infos',
        'Informations du joueur',
        array( $this, 'equipe_foot_custom_afficher_meta_box' ),
        'joueurs',
        'normal',
        'high'
    );
}

public function equipe_foot_custom_afficher_meta_box( $post ) {
    wp_nonce_field( 'joueurs_sauvegarder_meta', 'joueurs_meta_nonce' );

    $date_naissance = get_post_meta( $post->ID, 'date_naissance', true );
    $poste          = get_post_meta( $post->ID, 'poste', true );
    $numero_prefere = get_post_meta( $post->ID, 'numero_prefere', true );
?>
<p>
<label for="joueurs_date_naissance">Date de naissance</label><br>
  <input type="date" id="joueurs_date_naissance" name="joueurs_date_naissance" value="<?php echo esc_attr( $date_naissance ); ?>">
</p>
<p>
  <label for="joueurs_poste">Poste</label><br>
  <input type="text" id="joueurs_poste" name="joueurs_poste" value="<?php echo esc_attr( $poste ); ?>">
</p>
<p>
  <label for="joueurs_numero_prefere">Numéro préféré</label><br>
  <input type="number" id="joueurs_numero_prefere" name="joueurs_numero_prefere" value="<?php echo esc_attr( $numero_prefere ); ?>">
</p> 

<?php
}



public function equipe_foot_custom_sauvegarder_meta( $post_id ) {
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