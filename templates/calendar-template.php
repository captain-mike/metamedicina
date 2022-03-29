<?php

//Template Name: Calendar

get_header();

?>

<h1 class="page-title py-2 red_bg my-4">
    <?php the_title() ?> in programma
</h1>
<div class="breadcrumb-wrapper grey_bg">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
    ?>
</div>
<section id="main-content">
    <?php the_content() ?>
</section>

<section id="calendar-icons" class="my-5 py-5">

    <div class="container">
        <?php
        
        $args = [
            'post_type' => 'calendar',
            'post_per_page' => 10,
            'meta_key'			=> 'start',
            'orderby'			=> 'meta_value_num',
            'order'				=> 'ASC'
        ];

        $calendar = new WP_Query($args);

        
        if($calendar->have_posts() ) :
        while($calendar->have_posts() ) : 
            $calendar->the_post();
        ?>
        <article class="row mb-3">
            <div class="col-12 col-md-4">
                <div class="event-image" style="background-image:url(<?php the_post_thumbnail_url()?>)">
                    <div class="event-date">
                        <?php the_field('start') ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <h3 class="event-title"><?php the_title()?></h3>
                <div class="event-trainer">Condotto da: <b><?=get_field('trainer')[0]->post_title ?></b></div>
                <date class="event-dates mb-1">
                    <?php the_field('start') ?>
                     - 
                    <?php the_field('end') ?>
                </date>
                <h4 class="event-place mx-1"><?php the_field('indirizzo') ?></h4>
                <?php the_excerpt() ?>
            </div>
        </article>
        <?php
        endwhile;
        endif;
        ?>
    </div>

</section>

<?php

get_footer();

?>