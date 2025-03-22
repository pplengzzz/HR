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

    // ความสัมพันธ์กับตาราง surveys
    public function surveys()
    {
        return $this->hasMany(Survey::class, 'EmployeeID', 'EmployeeID');
    }

    // ความสัมพันธ์กับตาราง department
    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID', 'DepartmentID');
    }

    // ความสัมพันธ์กับตาราง business
    public function business()
    {
        return $this->belongsTo(Business::class, 'BusinessUnitID', 'BusinessUnitID');
    }
}
