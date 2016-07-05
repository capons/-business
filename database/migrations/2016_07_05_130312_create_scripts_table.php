<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScriptsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('scripts', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('parent_id')->default(0)->index();
      $table->integer('users_id')->unsigned();
      $table->string('name', 255);
      $table->string('desc', 255);
      $table->foreign('users_id')->references('id')->on('users');


      // Add needed columns here (f.ex: name, slug, path, etc.)
      // $table->string('name', 255);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('scripts');
  }

}
