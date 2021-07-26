<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('category_id')->index();
            $table->integer('type_id')->index();
            $table->string('title', 255);
            $table->point('coordinates')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('businesses');
    }
}
