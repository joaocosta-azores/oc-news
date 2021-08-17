<?php namespace Vancoders\News\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateVancodersNewsCategories extends Migration
{
    public function up()
    {
        Schema::create('vancoders_news_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('name');
            $table->text('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vancoders_news_categories');
    }
}
