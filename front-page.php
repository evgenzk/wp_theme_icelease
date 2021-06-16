
<?php

/*
|-------------------------------------------------------------------------------
| Front Page Template
|-------------------------------------------------------------------------------
|
| Look template structure at /application/core/gourmetios.php:18
|
*/
use Core\Icelease as Icelease;



get_header();


foreach(Icelease::$templates['front-page'] as $template)
	get_template_part('template-parts/'.$template);


get_footer();