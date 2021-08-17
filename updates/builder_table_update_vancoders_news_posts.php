<?php namespace Vancoders\News\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateVancodersNewsPosts extends Migration
{
    public function up()
    {
        Schema::table('vancoders_news_posts', function($table)
        {
            $table->smallInteger('status')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('vancoders_news_posts', function($table)
        {
            $table->dropColumn('status');
        });
    }
}
