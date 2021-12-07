<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_offers', function (Blueprint $table) {
            $table->id();
            $table->uuid('group_id')->nullable();
            $table->timestamps();
            $table->timestamp('synchronized_at')->nullable();
            $table->string('hash');
            $table->unsignedBigInteger('shop_id');
            $table->string('outer_id');
            $table->jsonb('data');
            $table->unsignedBigInteger('feed_category_id')->nullable();

            $table->unique(['shop_id', 'outer_id']);
            $table->foreign('feed_category_id')->references('id')->on('feed_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_offers');
    }
}
