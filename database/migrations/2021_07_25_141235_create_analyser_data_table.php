<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyserDataTable extends Migration {
    /**
     * Run the migrations.

     * @return void
     */
    public function up() {
        Schema::create('analyser_data', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->index();
            $table->integer('radius');
            $table->integer('number_of_businesses');
            $table->double('category_compatiblity_score');
            $table->double('type_compatiblity_score');
            $table->integer('distinct_categories');
            $table->integer('distinct_types');
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
        Schema::dropIfExists('analyser_data');
    }
}
