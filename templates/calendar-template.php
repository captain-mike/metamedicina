<?php
//Template Name: Calendar

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

<h1 class="page-title py-2 red_bg mt-4 mb-2">
    <?php the_title() ?> <?php _e('incoming', 'metamedicina')?>
</h1>

<section id="calendar-icons" class="my-lg-5 pb-5 pt-3">

        <?php
$relations = array(
    'relation'		=> 'AND',
    [
        'key'	 	=> 'categoria',
        'value'	  	=> get_field('categoria'),
        'compare' 	=> '='
    ]
    
);

if(isset($_GET['filter'])){ 
    if(isset($_GET['r'])){

        $relations[] = [
            'key'	 	=> 'regioni_italiane',
            'value'	  	=>  $_GET['r'],
            'compare' 	=> 'LIKE',
        ];

    }
}





        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = [
            'post_type'         => 'calendar',
            'post_per_page'     => 10,
            'meta_key'			=> 'start',
            'orderby'			=> 'meta_value_num',
            'order'				=> 'ASC',
            'meta_query'	=> $relations,
            'paged' => $paged
        ];
        
        
        if(isset($_GET['n'])){
        
            $args['s'] = $_GET['n'];
        }

        $calendar = new WP_Query($args);
        
        
        if($calendar->have_posts() ) : ?>

        <?php    
        $regions = [];
                while($calendar->have_posts() ) : 
                    $calendar->the_post();
                    $post_regions = get_field('regioni_italiane');
                    if(!empty($post_regions)){
                        foreach($post_regions as $r){
                            $regions[$r] = $r;
                        }
                    }

                endwhile;
        ?>

        <div id="filter-row1" class="row p-1 mb-5">
            <div class="col-12">
                <h6><?php _e('Filter','metamedicina') ?></h4>
            </div>
            <div class="col-12 col-md-2 grey_bg">
                <label for="name_filter"><?php _e('Nome','metamedicina')?></label>
                <input type="text" id="name_filter" name="n" placeholder="<?php _e('Event name','metamedicina')?>" class="form-control">
            </div>
            <div class="col-12 col-md-2 grey_bg">
                <label for="region_filter"><?php _e('Region','metamedicina')?></label>
                <select id="region_filter" name="r" class="form-control">
                    <option value=""><?php _e('Choose place','metamedicina')?></option>
                    <?php
                    
                        foreach($regions as $region){
                            ?>
                            <option value="<?=$region?>"><?=$region?></option>
                            <?php
                        }

                    ?>
                </select>
            </div>
            <div class="col-12 col-md-2 grey_bg">
                <button id="search_other" class="btn btn-primary mt-4"><?php _e('Search', 'metamedicina')?></button>
            </div>
            <?php if(isset($_GET['filter'])): 
                
                ?>
            <div class="col-12 col-md-12">
                <a href="/<?=$post_slug?>#filter-row2" id="reset_filter" class="btn btn-danger mt-4"><?php _e('Reset filters', 'metamedicina')?></a>
                </div>
            <?php endif; ?>
        </div>

        <?php 
        while($calendar->have_posts() ) : 
                $calendar->the_post();
                
                $icon_map = empty(get_field('indirizzo')) ? '' : '<i class="bi bi-geo-alt"></i>';
                
                ?>
        <article class="row mb-5 mt-3 mt-lg-0 mb-lg-3 calendar-row">
            <a href="<?php the_permalink()?>" class="col-12 col-lg-4">
                <div class="event-image" style="background-image:url(<?php the_post_thumbnail_url()?>)">
                    <div class="event-date">
                        <?php the_field('start') ?>
                    </div>
                </div>
            </href=>
            <a href="<?php the_permalink()?>" class="col-12 col-lg-8 calendar-details">
                <h3 class="event-title"><?php the_title()?></h3>
                <div class="event-trainer grey_bg mb-2">
                    <?php _e('Conducted by', 'metamedicina')?> 
                    <b><?=get_field('trainer')[0]->post_title ?></b> 
                    <i class="bi bi-person-video3"></i>
                </div>
                <time class="event-dates mb-3 text-center text-sm-left">
                    <span class="d-block d-sm-inline">
                        <i class="bi bi-calendar-heart"></i>  <?php the_field('start') ?>
                    </span>
                    <?php if(get_field('start') != get_field('end')){?>
                    <span class="d-none d-sm-inline"> - </span>
                    <span class="d-block d-sm-inline">
                        <i class="bi bi-calendar2-check"></i> <?php the_field('end') ?>
                    </span>
                    <?php } ?>
                </time>
               
                <h4 class="event-place"> <?=$icon_map?> <?php the_field('indirizzo') ?></h4>
                <?php the_excerpt() ?>
            </a>
        </article>
        <?php
        endwhile;
        endif;
        ?>
    <div class="row">
        <div class="col mt-5">

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
                        'total' => $calendar->max_num_pages //$q is your custom query
                    )
                );
                ?>
        </div>
    </div>

</section>

<?php get_footer(); ?>