<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('targetsite_id')->constrained();
            $table->string('surname', 100);
            $table->integer('children_no')->default(0);
            $table->date('date_of_birth');
            $table->boolean('isRefugee')->default(false);
            $table->text('countryOrigin')->nullable();
            $table->text('history');
            $table->boolean('isDisabled')->default(false);
            $table->text('diasabilityDesc')->nullable();
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
        Schema::dropIfExists('families');
    }
}
