<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $primaryKey = 'ReviewID';
    public $timestamps = false;

    protected $fillable = [
        'ReviewID',
        'EmployeeID',
        'EngagementScore',
        'SatisfactionScore',
        'Work-LifeBalanceScore'
    ];

    protected $casts = [
        'EmployeeID' => 'integer',
        'EngagementScore' => 'integer',
        'SatisfactionScore' => 'integer',
        'Work-LifeBalanceScore' => 'integer'
    ];

    // ความสัมพันธ์กับ Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
    }
} 