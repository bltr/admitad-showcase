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
            $table->string('hash');
            $table->unsignedBigInteger('shop_id');
            $table->string('outer_id');
            $table->jsonb('data');

            $table->index(['shop_id', 'outer_id']);

            // nested set
            $table->unsignedInteger(NestedSet::LFT)->default(0);
            $table->unsignedInteger(NestedSet::RGT)->default(0);
            $table->string(NestedSet::PARENT_ID)->nullable();
            $table->index(NestedSet::getDefaultColumns());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
