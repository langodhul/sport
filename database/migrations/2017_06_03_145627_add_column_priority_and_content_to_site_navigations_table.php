<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPriorityAndContentToSiteNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_navigations', function (Blueprint $table) {
            $table->tinyInteger('priority')->default(9);
            $table->text('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_navigations', function (Blueprint $table) {
            $table->dropColumn('priority');
            $table->dropColumn('content');
        });
    }
}
