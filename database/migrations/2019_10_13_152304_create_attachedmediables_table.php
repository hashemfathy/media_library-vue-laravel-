<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachedmediablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachedmediables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attachedmediable_id');
            $table->string('attachedmediable_type');

            $table->unsignedBigInteger('attached_media_id');
            $table->foreign('attached_media_id')->references('id')->on('media')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachedmediables');
    }
}
