<?php


    $id = get_query_var('id') ?: get_the_ID();

?>


<section class="u-pos-relative">
    <div class="square-bg u-bc@beige u-pos-absolute u-pos-l@329 u-pos-t@88"></div>
    <img src="<?= get_field('page_image', $id)?>" class="front-image">


    <div class="u-pos-absolute t-h1 u-block u-color@blue page-title u-pos-l@225 u-pos-t@280"><?= get_the_title(get_post($id));?></div>

    <a href="http://icelease.localhost/?page_id=17">About us</a>
</section>