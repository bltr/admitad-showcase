<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->uuid('feed_offers_group_id');
            $table->timestamps();
            $table->timestamp('imported_at')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('shop_id');
            $table->string('hash');
            $table->unsignedInteger('price');
            $table->jsonb('photos');
            $table->string('url');
            $table->jsonb('feed_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
