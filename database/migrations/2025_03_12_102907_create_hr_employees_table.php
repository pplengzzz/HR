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
        Schema::create('hr_employees', function (Blueprint $table) {
            $table->string('EmployeeID', 11)->primary();
            $table->string('StartDate', 10);
            $table->string('Title', 50);
            $table->string('BusinessUnit', 50);
            $table->string('EmployeeStatus', 10);
            $table->string('EmployeeType', 20);
            $table->string('PayZone', 10);
            $table->string('EmployeeClassificationType', 20);
            $table->string('DepartmentType', 50);
            $table->string('Division', 50);
            $table->string('DOB', 10);
            $table->string('State', 5);
            $table->string('GenderCode', 6);
            $table->string('RaceDesc', 20);
            $table->string('MaritalDesc', 20);
            $table->integer('Age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_employees');
    }
};
