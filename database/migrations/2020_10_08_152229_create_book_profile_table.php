<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('book_id');
            $table->string('pic');
            $table->string('author');
            $table->float('totalView');
            $table->boolean('hasPdf');
            $table->timestamps();
            $table->string('fileName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_profile');
    }
}
