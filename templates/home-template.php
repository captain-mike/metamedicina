<?php

//Template Name: Home

get_header();

?>

<h1 class="page-title py-2 red_bg my-4">
    <?php the_title() ?>
</h1>
<section id="main-content">
    <?php the_content() ?>
</section>

<section id="calendar-icons" class="my-5 py-5">

    <div class="row">

    <div class="col-12 col-sm-6 col-lg-3">
            <div class="calendar-icon">
                <a href="/seminari">
                    <img src="<?=get_template_directory_uri(); ?>/img/icona-seminari.png" class="img-responsive">
                    <h3><?php _e('Seminars')?></h3>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="calendar-icon">
                <a href="/workshop">
                    <img src="<?=get_template_directory_uri(); ?>/img/icona-workshop.png" class="img-responsive">
                    <h3><?php _e('Workshop')?></h3>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="calendar-icon">
                <a href="/conferenze">
                    <img src="<?=get_template_directory_uri(); ?>/img/icona-conferenze.png" class="img-responsive">
                    <h3><?php _e('Conferences')?></h3>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="calendar-icon">
                <a href="/eventi-online">
                    <img src="<?=get_template_directory_uri(); ?>/img/icona-online.png" class="img-responsive">
                    <h3><?php _e('Consultants')?></h3>
                </a>
            </div>
        </div>

    </div>

    </div>
</section>

<?php

get_footer();

?>