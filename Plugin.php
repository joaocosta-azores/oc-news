<?php namespace Vancoders\News;

use System\Classes\PluginBase;

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
}
