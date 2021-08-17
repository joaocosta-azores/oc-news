<?php namespace Vancoders\News\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'vancoders_news_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
