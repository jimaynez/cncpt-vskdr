<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('core_types', function (Blueprint $table) {
            $table->id();
            $table->integer('industry_id')->index();
            $table->integer('sector_id')->index();
            $table->string('name_short', 3);
            $table->string('name_long', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('core_types');
    }
}
