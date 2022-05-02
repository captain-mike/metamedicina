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
                                <img loading="lazy" class="img-responsive trainer-foto" src="<?=get_the_post_thumbnail_url($id,'thumbnail');?>" alt="<?=$nome?>">
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
    <?php


if(isset($_GET['cities'])){
    $relations = array(
        'relation'		=> 'OR',
        
    );

    foreach(explode(',',$_GET['cities']) as $id){
        
        $relations[] = [
            'key'	 	=> 'luoghi',
            'value'	  	=>  $id,
            'compare' 	=> 'LIKE',
        ];
        
    }

    var_dump(explode(',',$_GET['cities']));
    
}else{ 
    $relations = '';
}


$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = [
    'post_type'         => 'trainer',
    'posts_per_page'     => 18,
    'meta_query'	=> $relations,
    'paged' => $paged
];


    $trainers = new WP_Query($args);
    
    $langs = [];
    $cities = [];

    if($trainers->have_posts() ) :
        while($trainers->have_posts() ) : 
            $trainers->the_post();

            $values = explode(',', get_field('lingue'));
            if(count($values) > 1){
                foreach($values as $value):
                    $langs[] =  ucfirst($value);
                endforeach;
            }else{
                $langs[] = ucfirst(get_field('lingue'));
            }

            if(!empty(get_field('luoghi'))){
                foreach(get_field('luoghi') as $city){
                    $cities[$city->ID] = $city;
                }
            }


        endwhile;
    endif;


    ?>

        
        <div id="filter-row2" class="row p-1 mt-3">
            <div class="col-12">
                <h6>Trova consulenti vicini alla tua città</h4>
            </div>
            <div class="col-2 grey_bg d-relative">
                <label for="myCity_filter">La tua città</label>
                <input data-error="Devi inserire la tua città" data-error2="Devi cliccare una città nella tendina" type="text" id="myCity_filter" placeholder="ad es: Roma" class="form-control">
                <span class="error-area"></span>
                <div class="d-none" id="found-cities">
                </div>
            </div>
            <div class="col-2 grey_bg">
                <label for="km_filter">Distanza (Km)</label>
                <input data-error="Devi inserire la distanza" type="number" max="100" id="km_filter" class="form-control">
                <span class="error-area"></span>
            </div>
            <div class="col-2 grey_bg">
                <button id="search_nearest" class="btn btn-primary mt-4">Cerca</button>
            </div>
        </div>
        <div id="filter-row1" class="row p-1 d-none">
            <div class="col-12">
                <h6>Oppure</h4>
            </div>
            <div class="col-2 grey_bg">
                <label for="name_filter">Nome</label>
                <input type="text" id="name_filter" placeholder="Nome o Cognome" class="form-control">
            </div>
            <div class="col-2 grey_bg">
                <label for="lang_filter">Lingua</label>
                <select id="lang_filter" class="form-control">
                    <option value="">Scegli lingua</option>
                    <?php
                    
                        foreach(array_unique($langs) as $lang){
                            ?>
                            <option value="<?=$lang?>"><?=$lang?></option>
                            <?php
                        }

                    ?>
                </select>
            </div>
            <div class="col-2 grey_bg">
                <label for="city_filter">Città</label>
                <select id="city_filter" class="form-control">
                    <option value="">Scegli Luogo</option>
                    <?php
                    
                        foreach($cities as $city){
                            $id = $city->ID;
                            ?>
                            <option data-lat="<?=get_field('lat',$id)?>" data-lng="<?=get_field('lng',$id)?>" value="<?=$id?>"><?=get_field('name',$id)?></option>
                            <?php
                        }

                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">

    <?php if($trainers->have_posts() ) :
        while($trainers->have_posts() ) : 
            $trainers->the_post();

            $icon_map = empty(get_field('indirizzo')) ? '' : '<i class="bi bi-geo-alt"></i>';
                
        ?>
        <article class="col-12 col-sm-6 col-md-4 mb-5 trainers-block text-center">
            <div class="main-content">
                <a href="<?php the_permalink()?>">
                    <img loading="lazy" src="<?php the_post_thumbnail_url()?>">
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
                        <?= getCityNames(get_field('luoghi')) ?>
                    </div>
                </a>
            </address>
        </article>
        <?php
        endwhile;
        else:?>
            <article class="col-12 mb-5 trainers-block text-center">
            <h2>Non ci sono consulenti vicini alla tua città.</h2> 
            <a class="btn btn-primary" href="?cities=131523">
                scopri i consulenti che lavorano online
            </a>
            </article>
       <?php endif;
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