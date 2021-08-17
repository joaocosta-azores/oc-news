<?php namespace Vancoders\News\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateVancodersNewsPosts extends Migration
{
    public function up()
    {
        Schema::create('vancoders_news_posts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('name');
            $table->text('slug');
            $table->string('author')->nullable();
            $table->text('content');
            $table->integer('category_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vancoders_news_posts');
    }
}
