<?php namespace Vancoders\News\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Posts extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Vancoders.News', 'main-menu-item', 'side-menu-news');
    }
}
