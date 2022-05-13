<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php metamedicina_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link defer async href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Playfair+Display&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="loader">
        <div class="image-logo"></div>
    </div>
    <div id="wrapper" class="hfeed">
        <header id="header" role="banner">
            <div id="top-bar" class="grey_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-block d-sm-flex text-center col-sm-6 email-col">
                            <span class="d-none d-sm-block"><?=_('Contact us')?>: </span><a href="mailto:italia@metamedecine.com">italia@metamedecine.com</a>
                        </div>
                        <div class="col-12 d-block d-sm-flex text-center col-sm-6 language-col">
                            <?php do_action('wpml_add_language_selector'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-bar" class="red_bg py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-9 col-sm-4">
                            <a href="/" id="main-logo" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                <img src="<?=get_template_directory_uri()?>/img/logo-metamedicina.png" alt="">
                            </a>
                        </div>
                        <div class="col-3 col-sm-8">
                            <div class="mobile-bar">
                                <button class="toggle"><i class="bi bi-list"></i></button>
                            </div>
                            <nav id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'main-menu', 
                                    'link_before' => '<span itemprop="name">', 
                                    'link_after' => '</span>'
                                    )); ?>
                                <a class="header-youtube" target="_blank" href="https://www.youtube.com/channel/UCUkSeDrl7b0LA-SmFKEsbsA">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            
           