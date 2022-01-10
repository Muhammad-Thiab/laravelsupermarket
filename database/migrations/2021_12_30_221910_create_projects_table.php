<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->date('expiry_date');
            $table->string('photo');
            $table->integer('quantity');
            $table->integer('price');
            $table->text('social');
            $table->unsignedBigInteger('costumar_id');
            //$table->unsignedBigInteger('category_id');

            $table->softDeletes();
            $table->timestamps();

            //$table->foreign('category_id')->references('id')->on('categorys')->onDelete('cascade');
            $table->foreign('costumar_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');



    }
}
