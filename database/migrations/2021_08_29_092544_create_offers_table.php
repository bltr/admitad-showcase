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
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('price');
            $table->jsonb('photos');
            $table->string('url');
            $table->unsignedBigInteger('shop_id');
            $table->string('hash');
            $table->string('vendor');
            $table->jsonb('params')->nullable();
            $table->string('for_categories')->nullable();
            $table->string('for_end_category')->nullable();
            $table->string('for_tags')->nullable();
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
