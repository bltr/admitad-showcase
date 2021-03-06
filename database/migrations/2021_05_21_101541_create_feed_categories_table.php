<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateFeedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('synchronized_at')->nullable();
            $table->string('hash');
            $table->unsignedBigInteger('shop_id');
            $table->string('outer_id');
            $table->jsonb('data');
            $table->nestedSet();

            $table->unique(['shop_id', 'outer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_categories');
    }
}
