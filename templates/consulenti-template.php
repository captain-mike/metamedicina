<?php
//Template Name: Trainers

get_header(); ?>

<div class="breadcrumb-wrapper grey_bg">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
    ?>
</div>

<h1 class="page-title py-2 red_bg mt-4 ">
    <?php the_title() ?> 
</h1>

<section class="mt-0 mb-0">

    <div id="page-slider" class="owl-carousel owl-theme">

        <?php
    
        if(have_rows('slider')){
            while(have_rows('slider')){
            the_row();
            $slide = get_sub_field('slide');
            ?>
                <div style="background-image:url(<?=$slide?>)" class="py-5"></div>
                <?php
            }
        }
        
        ?>
    </div>


</section>

<section class="mt-3">
    <?php the_content()?>
</section>

<section id="main-trainers" class="">
    <?php 
        if(have_rows('profili_in_rilievo')){
            while(have_rows('profili_in_rilievo')){
                the_row();?>
                <h4 class="mb-3 mt-4"><?php the_sub_field('nome_sezione');?></h4>
                <div class="row ">
                <?php
                    $profiles = get_sub_field('profili');
                    foreach($profiles as $profile){ 
                        $nome = $profile->post_title;
                        $id = $profile->ID;
                        $role = $profile->ruolo;
                        ?>
                        <div class="col text-center grey_bg main-trainer-block">
                                <img class="img-responsive trainer-foto" src="<?=get_the_post_thumbnail_url($id,'thumbnail');?>" alt="<?=$nome?>">
                                <div class="mt-3">
                                    <a href="<?=$profile->guid?>" class="mb-0"><?=$nome?></a>
                                </div>
                                <small class="role-name"><?=$role ?></small>
                            </div>
                <?php } ?>

                </div>

            <?php }
        }
    ?>
</section>

<section class="mt-5">
    <div class="mb-5 mt-4 pl-2">
        <h4>Consulenti</h4>
    </div>
    <div class="row">
    <?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = [
        'post_type'         => 'trainer',
        'posts_per_page'     => 20,
        'paged' => $paged
    ];

    $trainers = new WP_Query($args);

    if($trainers->have_posts() ) :
        while($trainers->have_posts() ) : 
            $trainers->the_post();

            $icon_map = empty(get_field('indirizzo')) ? '' : '<i class="bi bi-geo-alt"></i>';
                
        ?>
        <article class="col-3 mb-5 trainers-block text-center">
            <div class="main-content">
                <a href="<?php the_permalink()?>">
                    <img src="<?php the_post_thumbnail_url()?>)">
                </a>
                <a href="<?php the_permalink()?>" class=" trainers-details">
                    <h3 class="trainer-title"><?php the_title()?></h3>
                    <small class="role-name"><?=get_field('ruolo')?></small>
                </a>
            </div>
            <address class="hover-content pt-5">
                <a href="<?php the_permalink()?>" class=" trainers-details">
                    <div class="trainer-info mt-2">
                        <i class="bi bi-envelope"></i>
                        <?php the_field('e-mail') ?>
                    </div>
                    <div class="trainer-info mt-2">
                        <i class="bi bi-translate"></i>
                        <?php the_field('lingue') ?>
                    </div>
                    <div class="trainer-info mt-2">
                        <i class="bi bi-telephone"></i>
                        <?php the_field('tel') ?>
                    </div>
                    <div class="trainer-info mt-2">
                        <i class="bi bi-geo-alt"></i>
                        <?php the_field('luoghi') ?>
                    </div>
                </a>
            </address>
        </article>
        <?php
        endwhile;
        endif;
        ?>
    </div>
    <div class="row">
        <div class="col mt-5 mb-5">

            <?php 
                $big = 999999999; // need an unlikely integer
                echo paginate_links(
                    array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(
                            1,
                            get_query_var('paged')
                        ),
                        'total' => $trainers->max_num_pages //$q is your custom query
                    )
                );
                ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>