<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Download extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file')->index();
            $table->unsignedBigInteger('number')->default(0);

            $table->foreign('file')
                ->references('filename')
                ->on('uploads')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('download');
    }
}
