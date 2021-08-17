<?php namespace Vancoders\News\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateVancodersNewsPosts2 extends Migration
{
    public function up()
    {
        Schema::table('vancoders_news_posts', function($table)
        {
            $table->timestamp('published_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('vancoders_news_posts', function($table)
        {
            $table->dropColumn('published_at');
        });
    }
}
