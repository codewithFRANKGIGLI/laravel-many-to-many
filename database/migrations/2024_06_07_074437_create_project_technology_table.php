<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_technology', function (Blueprint $table) {
            // tabella pivot tra project e technology
            $table->unsignedBigInteger('project_id');
            // foreign key
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');


            $table->unsignedBigInteger('technology_id');
            // foreign key
            $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('cascade');

            // primary key
            $table->primary(['project_id', 'technology_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_technology');
    }
};
