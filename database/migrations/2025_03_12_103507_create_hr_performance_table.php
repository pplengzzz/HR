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
        Schema::create('hr_performance', function (Blueprint $table) {
            $table->string('EmployeeID', 11);
            $table->string('PerformanceScore', 17);
            $table->integer('CurrentEmployeeRating');
            $table->integer('EngagementScore');
            $table->integer('SatisfactionScore');
            $table->integer('WorkLifeBalanceScore');
            
            $table->foreign('EmployeeID')
                  ->references('EmployeeID')
                  ->on('hr_employees')
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
        Schema::dropIfExists('hr_performance');
    }
};
