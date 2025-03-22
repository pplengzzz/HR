<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';
    protected $primaryKey = 'BusinessUnitID';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'BusinessUnitID',
        'BusinessUnitName'
    ];

    // ความสัมพันธ์กับ Employee
    public function employees()
    {
        return $this->hasMany(Employee::class, 'BusinessUnitID', 'BusinessUnitID');
    }
} 