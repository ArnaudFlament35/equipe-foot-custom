<?php

class Calculs_Joueurs {
    public function __construct() {
        add_action( 'save_post_joueurs', array( $this, 'equipe_foot_custom_assigner_categorie' ) );
    }

    public function equipe_foot_custom_obtenir_annee_fin_saison() {
    $aujourdhui     = new DateTime();
    $annee_courante = (int) $aujourdhui->format( 'Y' );
    $debut_saison   = DateTime::createFromFormat( 'Y-m-d', $annee_courante . '-09-01' );

    if ( $aujourdhui < $debut_saison ) {
        return $annee_courante;
    }
    return $annee_courante + 1;
}

public function equipe_foot_custom_calculer_categorie( $date_naissance ) {
    if ( empty( $date_naissance ) ) {
        return '';
    }
    $naissance = DateTime::createFromFormat( 'Y-m-d', $date_naissance );
    if ( ! $naissance ) {
        return '';
    }

    $annee_naissance  = (int) $naissance->format( 'Y' );
    $annee_fin_saison = $this->equipe_foot_custom_obtenir_annee_fin_saison();
    if($annee_fin_saison - $annee_naissance > 18) {
        return 'Senior';
    }

    return 'U' . ( $annee_fin_saison - $annee_naissance );
}

public function equipe_foot_custom_calculer_age( $date_naissance ) {
    if ( empty( $date_naissance ) ) {
        return null;
    }
    $naissance = DateTime::createFromFormat( 'Y-m-d', $date_naissance );
    if ( ! $naissance ) {
        return null;
    }

    $aujourdhui = new DateTime();
    return (int) $aujourdhui->diff( $naissance )->y;
}
   public function equipe_foot_custom_assigner_categorie( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $date_naissance = get_post_meta( $post_id, 'date_naissance', true );
    $categorie      = $this->equipe_foot_custom_calculer_categorie( $date_naissance );

    if ( empty( $categorie ) ) {
        return;
    }

    wp_set_object_terms( $post_id, $categorie, 'categorie_joueur' );
}
}