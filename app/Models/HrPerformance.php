<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrPerformance extends Model
{
    use HasFactory;

    protected $table = 'hr_performance';
    protected $primaryKey = null;
    public $incrementing = false;
    
    public $timestamps = false;

    protected $fillable = [
        'EmployeeID',
        'PerformanceScore',
        'performancescore',
        'CurrentEmployeeRating',
        'EngagementScore',
        'SatisfactionScore',
        'WorkLifeBalanceScore'
    ];

    // แปลงค่าก่อนบันทึกลงฐานข้อมูล
    public function setPerformancescoreAttribute($value)
    {
        $this->attributes['PerformanceScore'] = $value;
    }

    // แปลงค่าเมื่อดึงข้อมูล
    public function getPerformancescoreAttribute()
    {
        return $this->attributes['PerformanceScore'];
    }

    // ความสัมพันธ์กับตาราง employees
    public function employee()
    {
        return $this->belongsTo(HrEmployee::class, 'EmployeeID', 'EmployeeID');
    }
} 