<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <?php wp_head(); ?>


</head>
<body <?php body_class()?>>




    <?php

        get_template_part('template-parts/preloader');

    ?>


    <header class="u-pad-lr@120 u-absolute">
        <a href="<?= get_site_url()?>" class="logo u-inline-block">
            <img src="<?= get_field('logo', 'options')?>" alt="">
        </a>
        <nav>
            <div class="menu-hamburger">
                Menu
                <svg width="30" height="18" viewBox="0 0 30 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="30" height="2" fill="#2B1A67"/>
                    <rect x="10" y="8" width="20" height="2" fill="#2B1A67"/>
                    <rect x="4" y="16" width="26" height="2" fill="#2B1A67"/>
                </svg>
            </div>

        </nav>
    </header>

    <main>