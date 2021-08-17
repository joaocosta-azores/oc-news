<?php namespace Vancoders\News\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateVancodersNewsPosts3 extends Migration
{
    public function up()
    {
        Schema::table('vancoders_news_posts', function($table)
        {
            $table->string('subhead', 191)->nullable();
            $table->text('introduction');
        });
    }

    public function down()
    {
        Schema::table('vancoders_news_posts', function($table)
        {
            $table->dropColumn('subhead');
            $table->dropColumn('introduction');
        });
    }
}