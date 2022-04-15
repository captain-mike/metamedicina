<?php get_header(); ?>
<main id="content" role="main">
    <div class="breadcrumb-wrapper grey_bg">
        <?php
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
        }
        ?>
    </div>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
        <h1 class="page-title py-2 red_bg mt-4 mb-2">
            <?php the_title() ?>
        </h1>
        <article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>
        
                <div class="entry-content my-5" itemprop="mainContentOfPage">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('itemprop' => 'image'));
                    } ?>
                    <?php the_content(); ?>
                    
                </div>
        </article>
            
    <?php endwhile;
    endif; ?>
</main>
<?php get_footer(); ?>