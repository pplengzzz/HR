<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getData(Request $request)
    {
        // ดึงข้อมูลจากตาราง surveys
        $surveys = Survey::all();

        // คำนวณค่าเฉลี่ย engagement และ satisfaction
        $avgEngagement = round($surveys->avg('EngagementScore'), 2);
        $avgSatisfaction = round($surveys->avg('SatisfactionScore'), 2);
        $avgWorklife = round($surveys->avg('Work-LifeBalanceScore'), 2);

        // นับจำนวนคนที่พึงพอใจ/ไม่พึงพอใจ
        $satisfied = $surveys->where('SatisfactionScore', '>=', 3)->count();
        $unsatisfied = $surveys->where('SatisfactionScore', '<', 3)->count();

        // ดึงข้อมูล engagement trend 6 เดือนล่าสุด
        $engagementTrend = $surveys->sortByDesc('created_at')
            ->take(6)
            ->map(function($survey) {
                return $survey->EngagementScore;
            })->reverse()->values();

        $performanceStats = [
            'ratings' => [
                'labels' => ['ดีเยี่ยม', 'ดี', 'พอใช้', 'ต้องปรับปรุง'],
                'data' => [30, 45, 15, 10]
            ],
            'scores' => [
                'engagement' => $avgEngagement,
                'satisfaction' => $avgSatisfaction,
                'worklife' => $avgWorklife
            ],
            'departmentScores' => [
                'labels' => ['ฝ่ายผลิต', 'ฝ่ายขาย', 'ไอที'],
                'data' => [4.1, 3.9, 4.3]
            ],
            'satisfaction_ratio' => [
                'labels' => ['พึงพอใจ', 'ไม่พึงพอใจ'],
                'data' => [$satisfied, $unsatisfied]
            ],
            'engagement_trend' => [
                'labels' => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                'data' => $engagementTrend
            ],
            'performance_satisfaction' => [
                'performance' => $surveys->pluck('EngagementScore')->all(),
                'satisfaction' => $surveys->pluck('SatisfactionScore')->all()
            ]
        ];

        $employeeStats = [
            'departments' => [
                'labels' => ['ฝ่ายผลิต', 'ฝ่ายขาย', 'ไอที'],
                'data' => [50, 30, 20]
            ],
            'demographics' => [
                'gender' => [
                    'labels' => ['ชาย', 'หญิง'],
                    'data' => [60, 40]
                ]
            ],
            'attendance' => [
                'labels' => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                'sick' => [3, 4, 2, 5, 3, 4],
                'overtime' => [2, 3, 4, 3, 5, 4]
            ]
        ];

        return response()->json([
            'performance' => $performanceStats,
            'employee' => $employeeStats
        ]);
    }
} 