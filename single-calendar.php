<?php
get_header();

$trainers = get_field('trainer');

function getStringsByKey($key)
{
    global $trainers;
    $string = '';
    foreach ($trainers as $person) {
        $id = $person->ID;
        $value = get_field($key, $id);
        if (empty($string)) {
            $string .= $value;
        } else {
            $string .= ', ' . $value;
        }
    }
    return $string;
}

?>

<div class="breadcrumb-wrapper grey_bg">
    <?php
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    }
    ?>
</div>

<div class="container mt-3 d-none d-lg-block">
    <div class="row text-center">
        <div class="col calendar-icon-block">
            <b><?php _('Start', 'metamedicina')?></b><br> <i class="bi bi-calendar-heart"></i>
            <p><?php the_field('start') ?></p>
        </div>
        <div class="col calendar-icon-block">
            <b><?php _('End', 'metamedicina')?></b><br> <i class="bi bi-calendar-x"></i>
            <p><?php the_field('end') ?></p>
        </div>
        <div class="col calendar-icon-block">
            <b><?php _('Place', 'metamedicina')?></b><br> <i class="bi bi-geo-alt"></i>
            <p><?php the_field('indirizzo') ?></p>
        </div>
        <div class="col calendar-icon-block">
            <b>Tel</b><br> <i class="bi bi-telephone"></i>
            <p><?= getStringsByKey('tel') ?></p>
        </div>
        <div class="col calendar-icon-block">
            <b>E-mail</b><br> <i class="bi bi-envelope"></i>
            <p><?= getStringsByKey('e-mail') ?></p>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <main class="col-12 col-lg-8 calendar-main">
            <h1 class="page-title py-2 red_bg mb-4">
                <?php the_title() ?>
            </h1>
            <span class="calendar-detail-thumbnail"><?= the_post_thumbnail() ?></span>
            <?php the_content() ?>
        </main>
        <aside id="calendar-sidebar" class="col-12 col-md-4 d-none d-lg-block">
            <div class="calendar-trainer mb-4">
                <h3><?php _('Conducted by', 'metamedicina')?>:</h3>
                <div class="row">
                    <?php
                    foreach ($trainers as $person) {
                        $id = $person->ID; ?>
                        <div class="col text-center">
                            <img loading="lazy" class="img-responsive trainer-foto" src="<?= get_the_post_thumbnail_url($id, 'thumbnail'); ?>" alt="trainer">
                            <p class="mt-2"><?php echo $person->post_title; ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="calendar-price">
                <h3><?php _('Price and Promotions', 'metamedicina')?></h3>
                <div class="row mt-4">
                    <div class="col-12">
                        <b><?php _('Price', 'metamedicina')?>:</b> <?php the_field('price') ?>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <?php
                        if (!empty(get_field('promo'))) {
                            echo '<b>Promo:</b> ' . get_field('promo');
                        } else {
                            echo 'Nessuna promozione attiva';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<section id="mobile-detail-bar" class="d-lg-none">
    <div>
        <button id="info-button"><?= _('Info & prices') ?> <i class="bi bi-arrow-up-circle-fill"></i></button>
        <div id="hidden-info">
            <div class="row text-center">

                <div class="col-6  calendar-icon-block">
                    <?php
                    foreach ($trainers as $person) {
                        $id = $person->ID; ?>
                        <div class="col text-center">
                            <img loading="lazy" class="img-responsive trainer-foto" src="<?= get_the_post_thumbnail_url($id, 'thumbnail'); ?>" alt="trainer">
                            <p class="mt-2"><?php echo $person->post_title; ?></p>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-6 calendar-icon-block">
                    <b><?= _('Costo') ?>:</b> <?php the_field('price') ?>
                    <div class="">
                        <?php
                        if (!empty(get_field('promo'))) {
                            echo '<b>' . _('Promo') . ':</b> ' . get_field('promo');
                        } else {
                            echo 'Nessuna promozione attiva';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-12 calendar-icon-block">
                    <i class="bi bi-envelope"></i>
                    <p><?= getStringsByKey('e-mail') ?></p>
                </div>
                <div class="col-12 col-sm d-sm-none calendar-icon-block">
                    <i class="bi bi-telephone"></i>
                    <p><?= getStringsByKey('tel') ?></p>
                </div>


            </div>
        </div>
        <div id="main-info">
            <div class="row">
                <!--<div class="col calendar-icon-block">
                    <i class="bi bi-calendar-heart"></i>
                    <p><b>Inizio:</b> <?php the_field('start') ?> <br> 
                    <b>Fine:</b> <?php the_field('end') ?></p>
                </div>-->
                <div class="col-4 col-sm calendar-icon-block">
                    <b><?= _('Inizio') ?></b><br>
                    <i class="bi bi-calendar-heart"></i>
                    <p><?php the_field('start') ?></p>
                </div>
                <div class="col-4 col-sm calendar-icon-block">
                    <b><?= _('Fine') ?></b><br>
                    <i class="bi bi-calendar-x"></i>
                    <p><?php the_field('end') ?></p>
                </div>
                <div class="col-4 col-sm calendar-icon-block">
                    <i class="bi bi-geo-alt"></i>
                    <p><?php the_field('indirizzo') ?></p>
                </div>
                <div class="col-6 col-sm d-none d-sm-block calendar-icon-block">
                    <i class="bi bi-telephone"></i>
                    <p><?= getStringsByKey('tel') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
get_footer()
?>