<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    protected $table = 'termination';
    protected $primaryKey = 'TerminationID';
    public $timestamps = false;

    protected $fillable = [
        'TerminationID',
        'EmployeeID',
        'TerminationType',
        'TerminationDescription'
    ];

    protected $casts = [
        'EmployeeID' => 'integer'
    ];

    // ความสัมพันธ์กับ Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }
} 