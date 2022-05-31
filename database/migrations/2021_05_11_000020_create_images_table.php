<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('images')) {

            Schema::create('images', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('path');
                $table->text('name')->nullable();
                $table->string('extension')->nullable();
                $table->string('size')->nullable()->default(0);
                $table->integer('order')->default(0);
                $table->string('type')->nullable();
                $table->unsignedInteger('imageable_id');
                $table->string('imageable_type');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
