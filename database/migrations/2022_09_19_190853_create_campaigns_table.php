<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name' , 191);
            $table->date('from');
            $table->date('to');
            // decimal defualt in Laravel 8 , 2
            $table->decimal('total');
            $table->decimal('daily_budget');
            $table->bigInteger('user_id');
            $table->timestamps();
        });
        Schema::create('campaign_images', function (Blueprint $table) {
            $table->uuid('slug');
            $table->bigInteger('campaign_id');
            // we can remove this driver col and use it Mode;
            $table->string('driver' , 191)->default('campaign');
            $table->string('file' , 250);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};
