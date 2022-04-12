<?php
get_header();
?>

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



<?php
get_footer()
?>