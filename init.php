<?php defined('SYSPATH') or die('No direct script access.');
defined('PEOPLE_VERSION') OR define('PEOPLE_VERSION', '1.0.1');

Kohana::$config->load('menu')
    ->set('people', array(
        'title' => 'Сотрудники',
        'url' => 'people/peopleinfo',
        'icon' => 'fa-cog',
        'order' => 30,
       
    ));