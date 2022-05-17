<?php
//Template Name: Trainers

get_header(); 

global $post;
$post_slug = $post->post_name;
?>

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
        <h4><?php _e('Consultants', 'metamedicina')?></h4>
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

    
}else if(isset($_GET['filter'])){ 
    $relations = array(
        'relation'		=> 'AND',
        
    );
    if(isset($_GET['r'])){

        $relations[] = [
            'key'	 	=> 'regioni_italiane',
            'value'	  	=>  $_GET['r'],
            'compare' 	=> 'LIKE',
        ];

    }
    if(isset($_GET['l'])){

        $relations[] = [
            'key'	 	=> 'lingue',
            'value'	  	=>  $_GET['l'],
            'compare' 	=> 'LIKE',
        ];
    }
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

if(isset($_GET['n'])){

    $args['s'] = $_GET['n'];
}


    $trainers = new WP_Query($args);
    
    $langs = [];
    $regions = get_trainer_regions();

    if($trainers->have_posts() ) :
        while($trainers->have_posts() ) : 
            $trainers->the_post();

            //creates a unique array of languages
            $values = explode(',', get_field('lingue'));
            if(count($values) > 1){
                foreach($values as $value):
                    $langs[] =  trim(ucfirst($value));
                endforeach;
            }else{
                $langs[] = ucfirst(get_field('lingue'));
            }
        endwhile;
    endif;


    ?>

        
        <div id="filter-row2" class="row p-1 mt-3">
            <div class="col-12">
                <h6><?php _e('Do you want a personalized meeting to see how Metamedicine can help you? Find the consultant closest to you', 'metamedicina')?></h4>
            </div>
            <div class="col-12 col-md-2 grey_bg d-relative">
                <label for="myCity_filter"><?php _e('Write your city', 'metamedicina')?></label>
                <input data-error="<?php _e('You need to insert your city', 'metamedicina')?>" data-error2="<?php _e('You need to click on a city in the dropdown', 'metamedicina')?>" type="text" id="myCity_filter" placeholder="<?php _e('Example: Roma', 'metamedicina')?>" class="form-control">
                <span class="error-area"></span>
                <div class="d-none" id="found-cities">
                </div>
            </div>
            <div class="col-12 col-md-5 grey_bg">
                <label for="km_filter"><?php _e('How many kilometers can you travel?', 'metamedicina')?> (Km)</label>
                <input data-error="<?php _e('Please set a distance', 'metamedicina')?>" type="number" max="100" id="km_filter" class="form-control w-50">
                <span class="error-area"></span>
            </div>
            <div class="col-12 col-md-2 grey_bg">
                <button id="search_nearest" class="btn btn-primary mt-4"><?php _e('Search', 'metamedicina')?></button>
            </div>
        </div>
        <div id="filter-row1" class="row p-1">
            <div class="col-12">
                <h6><?php _e('Advanced filters','metamedicina') ?>:</h4>
            </div>
            <div class="col-12 col-md-2 grey_bg">
                <label for="name_filter"><?php _e('Name','metamedicina')?></label>
                <input type="text" id="name_filter" name="n" placeholder="<?php _e('Name and lastname','metamedicina') ?>" class="form-control">
            </div>
            <div class="col-12 col-md-2 grey_bg">
                <label for="lang_filter"><?php _e('Language','metamedicina')?></label>
                <select id="lang_filter" name="l" class="form-control">
                    <option value=""><?php _e('Select Language','metamedicina')?></option>
                    <?php
                    
                        foreach(array_unique($langs) as $lang){
                            ?>
                            <option value="<?=$lang?>"><?=$lang?></option>
                            <?php
                        }

                    ?>
                </select>
            </div>
            <?php $my_current_lang = apply_filters( 'wpml_current_language', NULL ); 
            if($my_current_lang == 'it'):
            ?>
            <div class="col-12 col-md-2 grey_bg">
                <label for="region_filter"><?php _e('Region','metamedicina')?></label>
                <select id="region_filter" name="r" class="form-control">
                    <option value=""><?php _e('Select place','metamedicina')?></option>
                    <?php
                    
                        foreach($regions as $region){
                            ?>
                            <option value="<?=$region?>"><?=$region?></option>
                            <?php
                        }

                    ?>
                </select>
            </div>
            <?php endif;?>
            <div class="col-12 col-md-2 grey_bg">
                <button id="search_other" class="btn btn-primary mt-4"><?php _e('Search', 'metamedicina')?></button>
            </div>
        </div>
        <div class="row p-1 mt-3">
            <div class="col-12 col-md-8 grey_bg">
                <h6><?php _e('We are also available for online sessions.', 'metamedicina') ?></h6>
                <a class="btn btn-primary" href="?cities=<?=get_page_by_title('Online',OBJECT,'city')->ID?>">
                    <?php _e('Find the Consultants who also receive online', 'metamedicina')?>    
                </a>
            </div>
            <?php if(isset($_GET['filter'])): ?>
                <div class="col-12 col-md-12">
                    <a href="/<?=$post_slug?>#filter-row2" id="reset_filter" class="btn btn-danger mt-4"><?php _e('Reset filters', 'metamedicina')?></a>
                </div>
            <?php endif; ?>
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
            <h2><?php _e('No consultants were found', 'metamedicina')?>.</h2> 
            <h4><?php _e('We are also available for online sessions.', 'metamedicina')?>.</h4> 
            <a class="btn btn-primary" href="?cities=<?=get_page_by_title('Online',OBJECT,'city')->ID?>">
                <?php _e('Find the Consultants who also receive online', 'metamedicina')?>    
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