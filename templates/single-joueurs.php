<?php
/*
Template Name: Joueurs
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <?php wp_body_open(); ?>
    <?php if(have_posts()): ?>
        <?php while(have_posts()): the_post(); ?>
        
            <div class="content-single-joueurs">
                <div class="content-single-joueurs-image">
                    <?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid')); ?>
                </div>
            <div class="content-single-joueurs-date-naissance">
                <?php echo get_post_meta(get_the_ID(), 'date_naissance', true); ?>
            </div>
            <div class="content-single-joueurs-poste">
                <?php echo get_post_meta(get_the_ID(), 'poste', true); ?>
            </div>        
            <div class="content-single-joueurs-numero-prefere">
                <?php echo get_post_meta(get_the_ID(), 'numero_prefere', true); ?>
            </div>   
            <?php 
            $categories = get_the_terms( get_the_ID(), 'categorie_joueur' );     
            equipe_foot_custom_log('categories: ' . print_r($categories, true));
            ?>
            <?php the_content(); ?>
        </div>
        <?php
        endwhile;
    endif;
?>
    <?php wp_footer(); ?>
</body>
</html>
