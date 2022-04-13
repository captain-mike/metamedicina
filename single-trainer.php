<?php
get_header();

$nome = get_the_title();
$id = get_the_ID();
?>
<script>
    const TRAINER_ID = <?php echo $id?>;
    console.log(TRAINER_ID);
</script>
<div class="breadcrumb-wrapper grey_bg">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
    ?>
</div>

<div class="container mt-3">
    <div class="row text-center">
        <div class="col calendar-icon-block">
            <b>Lingue</b><br> 
            <i class="bi bi-translate"></i>
            <p><?php the_field('lingue')?></p>
        </div>
        <div class="col calendar-icon-block">
            <b>Luogo</b><br> 
            <i class="bi bi-geo-alt"></i>
            <p><?php the_field('luoghi')?></p>
        </div>
        <div class="col calendar-icon-block">
            <b>Telefono</b><br> 
            <i class="bi bi-telephone"></i>
            <p><?=get_field('tel')?></p>
        </div>
        <div class="col calendar-icon-block">
            <b>E-mail</b><br> 
            <i class="bi bi-envelope"></i>
            <p><?=get_field('e-mail')?></p>
        </div>
        <div class="col calendar-icon-block">
            <b>Sito</b><br> 
            <i class="bi bi-globe2"></i>
            <p><?=get_field('sito')?></p>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">
    <div class="row">
        <main class="col-12 col-md-12 calendar-main">
        <h1 class="page-title py-2 red_bg mb-4">
            <?php the_title() ?>
        </h1>
            <span class="calendar-detail-thumbnail"><?=the_post_thumbnail()?></span>
            <?php the_content() ?>
        </main>
        
    </div>
</div>

<section class="container">
    <h3 class="red_bg text-center"><?php _e('Next events')?></h3>
    
<?php
    $args = [
        'post_type'         => 'calendar',
        'posts_per_page'     => -1,
        'suppress_filters' => 0,
        'meta_query'       => [
            [
                'key'      => 'trainer',
                'value'    => '"'.$id.'"',
                'compare'  => 'LIKE'
            ]
        ],
        'order' => 'ASC',
        'orderby' => 'title',
        'post_status' => 'publish'
    ];

    $calendars = new WP_Query($args);

    //var_dump($trainers);

    if($calendars->have_posts() ) :
        while($calendars->have_posts() ) : 
            $calendars->the_post();?>

            <div class="row pl-4">
               <h5>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title()?>">
                        <?php the_title();?>
                    </a>
                </h5> 
                <time class="event-dates mb-3 ml-2">
                    <i class="bi bi-calendar-heart"></i>  <?php the_field('start') ?>
                     - 
                    <i class="bi bi-calendar2-check"></i> <?php the_field('end') ?>
                </time>
            </div>

       <?php endwhile;
    else:
        echo '<p>Nessun evento in programma<p>';
    endif;
    wp_reset_postdata()
    ?>

</section>

<section class="container">
    <h3 class="red_bg text-center"><?php _e('Incoming events for') ?> <?=$nome?></h3>
    <div id="calendar-area">
        <div class="no-calendars"><?php _e('No events found')?></div>
    </div>
</section>



<?php
get_footer()
?>