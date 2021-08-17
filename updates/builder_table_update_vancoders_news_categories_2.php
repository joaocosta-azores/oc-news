<?php namespace Vancoders\News\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateVancodersNewsCategories2 extends Migration
{
    public function up()
    {
        Schema::table('vancoders_news_categories', function($table)
        {
            $table->smallInteger('hidden')->default(2);
            $table->smallInteger('status')->default(1);
        });
    }

    public function down()
    {
        Schema::table('vancoders_news_categories', function($table)
        {
            $table->dropColumn('hidden');
            $table->dropColumn('status');
        });
    }
}
