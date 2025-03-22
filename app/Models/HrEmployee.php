<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    use HasFactory;

    protected $table = 'hr_employees';
    protected $primaryKey = 'EmployeeID';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;

    protected $fillable = [
        'EmployeeID',
        'StartDate',
        'Title',
        'BusinessUnit',
        'EmployeeStatus',
        'EmployeeType',
        'PayZone',
        'EmployeeClassificationType',
        'DepartmentType',
        'Division',
        'DOB',
        'State',
        'GenderCode',
        'RaceDesc',
        'MaritalDesc',
        'Age'
    ];

    // เปลี่ยนชื่อ relation จาก performance เป็น hr_performance
    public function performance()
    {
        return $this->hasOne(HrPerformance::class, 'EmployeeID', 'EmployeeID');
    }
} 