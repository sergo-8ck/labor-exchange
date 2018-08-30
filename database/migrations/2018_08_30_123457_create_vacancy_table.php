<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('vacancy', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
      $table->string('title');
      $table->text('content');
      $table->string('status', 16);
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
    Schema::dropIfExists('vacancy');
  }
}
