<?php defined('SYSPATH') or die('No direct script access.');

defined('PEOPLE_VERSION') OR define('PEOPLE_VERSION', '1.0.5');

Kohana::$config->load('menu')
    ->set('people', array(
        'title' => 'Сотрудники',
        'url' => 'people/peopleinfo',
        'icon' => 'fa-cog',
        'order' => 30,
        'children' => array(
            array(
                'title' => 'Поиск',
                'url' => 'people/index',
                'icon' => 'fa-search',
            ),
            array(
                'title' => 'По категориям доступа',
                'url' => 'people/access_search',
                'icon' => 'fa-lock',
            ),
            array(
                'title' => 'Просроченные карты',
                'url' => 'people/find_card_late',
                'icon' => 'fa-clock-o',
            ),
            array(
                'title' => 'Без карты',
                'url' => 'people/people_without_card',
                'icon' => 'fa-credit-card',
            ),
        )
    ));