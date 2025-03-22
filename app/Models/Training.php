<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';
    protected $primaryKey = 'TrainingID';
    public $timestamps = false;

    protected $fillable = [
        'TrainingID',
        'EmployeeID',
        'ProgramName',
        'TrainingType',
        'TrainingOutcome',
        'TrainingDuration',
        'TrainingCost',
        'Trainer'
    ];

    protected $casts = [
        'EmployeeID' => 'integer',
        'TrainingDuration' => 'integer',
        'TrainingCost' => 'decimal:2'
    ];

    // ความสัมพันธ์กับ Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }
} 