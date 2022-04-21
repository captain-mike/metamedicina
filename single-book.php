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


<div class="container mt-4">
    <h1 class="page-title py-2 red_bg mb-4">
        <?php the_title() ?>
    </h1>
    <div class="row">
        <main class="col-12 col-lg-8 bok-main">
            <section class="book-detail-thumbnail"><?= the_post_thumbnail() ?></section>
            <section>
                <?php the_content() ?>
            </section>
        </main>
        <aside id="book-sidebar" class="col-12 col-md-4 d-none d-lg-block">
            <div class="mb-1">
                <b><?=_('Prima edizione:')?></b> <?php the_field('edition') ?>
            </div>
            <div class="mb-1">
                <b><?=_('Numero di pagine:')?></b> <?php the_field('pages') ?>
            </div>
            <div class="mb-1">
                <b><?=_('Prezzo:')?></b> <?php the_field('price') ?>
            </div>
            <?php if(have_rows('buy')){?>
                <div class="mb-1">
                    <b><?=_('Acquista qui:')?></b> 
                    <?php while(have_rows('buy')){
                        the_row();
                        ?>

                    <a target="_blank" href="<?php the_sub_field('link') ?>"><?php the_sub_field('nome') ?></a>
                    
                    <?php }?>
                </div>
            <?php } ?>
            <?php if(have_rows('campo_extra')){?>
                <?php while(have_rows('campo_extra')){
                    the_row();?>

                    <div class="mb-1">
                    <b><?php the_sub_field('titolo') ?>:</b> 
                    <?php the_sub_field('valore') ?><br>
                    </div>
                    
                    <?php } ?>
            <?php } ?>
        </aside>
    </div>
</div>


<?php
get_footer()
?>