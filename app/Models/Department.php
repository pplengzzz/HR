<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'DepartmentID';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'DepartmentID',
        'DepartmentName'
    ];

    // ความสัมพันธ์กับ Employee
    public function employees()
    {
        return $this->hasMany(Employee::class, 'DepartmentID', 'DepartmentID');
    }

    // ความสัมพันธ์กับ Business Unit
    public function businessUnit()
    {
        return $this->belongsTo(Business::class, 'BusinessUnitID', 'BusinessUnitID');
    }
} 