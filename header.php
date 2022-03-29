<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php metamedicina_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bubbler+One&family=Montserrat+Alternates:wght@300;400&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="wrapper" class="hfeed">
        <header id="header" role="banner">
            <div id="top-bar" class="grey_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-4 email-col">
                            <?=_('Contact us')?>: <a href="mailto:italia@metamedecine.com">italia@metamedecine.com</a>
                        </div>
                        <div class="col-8 language-col">
                            <?php do_action('wpml_add_language_selector'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-bar" class="red_bg py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <a href="/" id="main-logo" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                <img src="<?=get_template_directory_uri()?>/img/logo-metamedicina.png" alt="">
                            </a>
                        </div>
                        <div class="col-8">
                            <nav id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                                <?php wp_nav_menu(array('theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>')); ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            
           