<?php
//Template Name: Books

get_header(); ?>

<div class="breadcrumb-wrapper grey_bg">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
    ?>
</div>

<h1 class="page-title py-2 red_bg mt-4 mb-2">
    <?php the_title() ?>
</h1>

<section id="calendar-icons" class="my-lg-5 py-5">

    <div class="row">

    <?php
        
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = [
            'post_type'         => 'book',
            'post_per_page'     => 10,
            'order'				=> 'ASC',
            'paged' => $paged
        ];
        
        $calendar = new WP_Query($args);
        
        
        if($calendar->have_posts() ) :
            while($calendar->have_posts() ) : 
                $calendar->the_post();        
                ?>
        <article class="col-4 mb-5 mt-3 mt-lg-0 mb-lg-3 book-item">
            <a href="<?php the_permalink()?>" class="col-12 col-lg-4">
                <div class="book-3d-scene">
                    <div class="book-wrap">
                        <div class="book-side" style="background-image:url(<?php the_post_thumbnail_url()?>)"></div>
                        <img lazy="true" src="<?php the_post_thumbnail_url()?>">
                    </div>
                </div>
                <h3 class="event-title text-center"><?php the_title()?></h3>
            </a>
        </article>
        <?php
        endwhile;
    endif;
    ?>
    </div>
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