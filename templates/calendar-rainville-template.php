<?php
//Template Name: Calendar Claudia Rainville

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
    'relation'		=> 'AND'    
);


        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = [
            'post_type'         => 'calendar',
            'post_per_page'     => 10,
            'suppress_filters' => 0,
            //'meta_key'			=> 'start',
            //'orderby'			=> 'meta_value_num',
            'orderby'			=> 'menu_order',
            'order'				=> 'ASC',
            'post_status' => 'publish',
            'meta_query'       => [
                [
                    'key'      => 'trainer',
                    'value'    => '"268"',
                    'compare'  => 'LIKE'
                    ]
                ],
                'paged' => $paged
            ];
        

        $calendar = new WP_Query($args);
       
        
        if($calendar->have_posts() ) : ?>

    

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