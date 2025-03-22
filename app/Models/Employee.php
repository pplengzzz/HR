<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee_1';
    protected $primaryKey = 'EmployeeID';
    public $timestamps = false;

    protected $fillable = [
        'EmployeeID',
        'StartDate',
        'ExitDate',
        'EmployeeType',
        'PayZone',
        'EmployeeStatus',
        'GenderCode',
        'DOB',
        'State',
        'Age',
        'RaceDesc',
        'MaritalDesc',
        'DepartmentID',
        'BusinessUnitID'
    ];

    protected $casts = [
        'EmployeeID' => 'integer',
        'Age' => 'integer',
        'StartDate' => 'string',
        'ExitDate' => 'string',
        'DOB' => 'string'
    ];
}
