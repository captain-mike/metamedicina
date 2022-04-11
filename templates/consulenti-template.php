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

<section class="my-5 py-5">

    <div id="page-slider" class="owl-carousel owl-theme">

        <?php
    
        if(have_rows('slider')){
            while(have_rows('slider')){
            the_row();
            $slide = get_sub_field('slide');
            ?>
                <div style="background-image:url(<?=$slide?>)" class="py-5">
                    
                </div>
                <?php
            }
        }
        
        ?>
    </div>


</section>

<?php get_footer(); ?>