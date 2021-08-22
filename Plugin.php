<?php namespace Vancoders\News;

use Faker\Factory;
use System\Classes\PluginBase;
use Vancoders\News\Models\Post;
use Vancoders\News\Models\Category;
use Winter\Storm\Support\Facades\Flash;
use Illuminate\Support\Facades\DB;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'vancoders.news::lang.settings.title',
                'description' => 'vancoders.news::lang.settings.description',
                'category'    => 'vancoders.news::lang.settings.category',
                'icon'        => 'icon-newspaper-o',
                'class'       => 'Vancoders\News\Models\Settings',
                'order'       => 500,
                'keywords'    => 'vancoders.news::lang.settings.keywords',
                'permissions' => ['vancoders.news.news_settings']
            ]
        ];
    }

    public function boot()
    {
        \System\Controllers\Settings::extend(function($controller) {
            $controller->addDynamicMethod('onGenerateDummy', function() {
                Post::createDummy(1);
                Flash::success("Dummy data has been generated!");

            });
            $controller->addDynamicMethod('onImportData', function() {
                Post::importData();
                Flash::success("Data imported successfully");

            });
        });
    }
}
