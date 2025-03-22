<?php

namespace App\Http\Controllers;

use App\Models\HrEmployee;
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
        // สร้าง mock data สำหรับทดสอบ
        $performanceStats = [
            'ratings' => [
                'labels' => ['ดีเยี่ยม', 'ดี', 'พอใช้', 'ต้องปรับปรุง'],
                'data' => [30, 45, 15, 10]
            ],
            'scores' => [
                'engagement' => 4.2,
                'satisfaction' => 3.8,
                'worklife' => 3.5
            ],
            'departmentScores' => [
                'labels' => ['ฝ่ายผลิต', 'ฝ่ายขาย', 'ไอที'],
                'data' => [4.1, 3.9, 4.3]
            ],
            'satisfaction_ratio' => [
                'labels' => ['พึงพอใจ', 'ไม่พึงพอใจ'],
                'data' => [75, 25]
            ],
            'engagement_trend' => [
                'labels' => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                'data' => [3.8, 3.9, 4.0, 4.1, 4.2, 4.3]
            ],
            'performance_satisfaction' => [
                'performance' => [4.2, 3.8, 4.1, 3.9, 4.0, 3.7, 4.3, 3.6],
                'satisfaction' => [3.9, 3.7, 4.0, 3.8, 3.9, 3.6, 4.1, 3.5]
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

    public function getDataCSV(Request $request)
    {
        // สร้าง query builder
        $query = HrEmployee::with('performance');

        // กรองตามแผนก
        if ($request->department) {
            $query->where('DepartmentType', $request->department);
        }

        // กรองตามสถานะ
        if ($request->status) {
            $query->where('EmployeeStatus', $request->status);
        }

        // กรองตามวันที่
        if ($request->startDate && $request->endDate) {
            $query->whereBetween('StartDate', [$request->startDate, $request->endDate]);
        }

        // ดึงข้อมูลทั้งหมด
        $employees = $query->get();

        // ข้อมูล Performance
        $performanceStats = [
            'ratings' => [
                'labels' => ['ดีเยี่ยม', 'ดี', 'พอใช้', 'ต้องปรับปรุง'],
                'data' => [
                    $employees->filter(function($e) { 
                        return $e->performance && $e->performance->PerformanceScore === 'Outstanding'; 
                    })->count(),
                    $employees->filter(function($e) { 
                        return $e->performance && $e->performance->PerformanceScore === 'Good'; 
                    })->count(),
                    $employees->filter(function($e) { 
                        return $e->performance && $e->performance->PerformanceScore === 'Average'; 
                    })->count(),
                    $employees->filter(function($e) { 
                        return $e->performance && $e->performance->PerformanceScore === 'Poor'; 
                    })->count(),
                ]
            ],
            'scores' => [
                'engagement' => round($employees->avg(function($e) {
                    return $e->performance ? $e->performance->EngagementScore : 0;
                }), 2),
                'satisfaction' => round($employees->avg(function($e) {
                    return $e->performance ? $e->performance->SatisfactionScore : 0;
                }), 2),
                'worklife' => round($employees->avg(function($e) {
                    return $e->performance ? $e->performance->WorkLifeBalanceScore : 0;
                }), 2)
            ],
            'departmentScores' => [
                'labels' => $employees->pluck('DepartmentType')->unique()->values()->all(),
                'data' => $employees->groupBy('DepartmentType')->map(function($group) {
                    return round($group->avg(function($e) {
                        return $e->performance ? $e->performance->CurrentEmployeeRating : 0;
                    }), 1);
                })->values()->all()
            ],
            'satisfaction_ratio' => [
                'labels' => ['พึงพอใจ', 'ไม่พึงพอใจ'],
                'data' => [
                    $employees->filter(function($e) { 
                        return $e->performance && $e->performance->SatisfactionScore >= 3; 
                    })->count(),
                    $employees->filter(function($e) { 
                        return $e->performance && $e->performance->SatisfactionScore < 3; 
                    })->count()
                ]
            ],
            'engagement_trend' => [
                'labels' => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                'data' => $employees->map(function($e) {
                    return $e->performance ? $e->performance->EngagementScore : 0;
                })->take(6)->all()
            ],
            'performance_satisfaction' => [
                'performance' => $employees->map(function($e) {
                    return $e->performance ? $e->performance->CurrentEmployeeRating : 0;
                })->all(),
                'satisfaction' => $employees->map(function($e) {
                    return $e->performance ? $e->performance->SatisfactionScore : 0;
                })->all()
            ]
        ];

        // ข้อมูลพนักงาน
        $employeeStats = [
            'departments' => [
                'labels' => $employees->pluck('DepartmentType')->unique()->values()->all(),
                'data' => $employees->groupBy('DepartmentType')
                    ->map(function($group) { return $group->count(); })
                    ->values()->all()
            ],
            'demographics' => [
                'gender' => [
                    'labels' => ['ชาย', 'หญิง'],
                    'data' => [
                        $employees->where('GenderCode', 'M')->count(),
                        $employees->where('GenderCode', 'F')->count()
                    ]
                ]
            ],
            'attendance' => [
                'labels' => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                'sick' => [3, 4, 2, 5, 3, 4], // ตัวอย่างข้อมูล
                'overtime' => [2, 3, 4, 3, 5, 4] // ตัวอย่างข้อมูล
            ]
        ];

        return response()->json([
            'performance' => $performanceStats,
            'employee' => $employeeStats
        ]);
    }

    private function readCSV($filename)
    {
        $file = Storage::get($filename);
        $lines = explode("\n", $file);
        $headers = str_getcsv(array_shift($lines));
        $data = [];
        
        foreach ($lines as $line) {
            if (empty($line)) continue;
            $row = str_getcsv($line);
            if (count($headers) === count($row)) {
                $data[] = array_combine($headers, $row);
            }
        }
        
        return $data;
    }

    private function calculateRatings($data)
    {
        $ratings = array_count_values(array_column($data, 'Performance Score'));
        return [
            'labels' => array_keys($ratings),
            'data' => array_values($ratings)
        ];
    }

    private function calculateScores($data)
    {
        $scores = [
            'engagement' => array_column($data, 'Engagement Score'),
            'satisfaction' => array_column($data, 'Satisfaction Score'),
            'worklife' => array_column($data, 'Work-Life Balance Score')
        ];

        return array_map(function($scoreArray) {
            return round(array_sum($scoreArray) / count($scoreArray), 2);
        }, $scores);
    }

    private function calculateDepartments($data)
    {
        $departments = array_count_values(array_column($data, 'DepartmentType'));
        arsort($departments);
        return [
            'labels' => array_keys($departments),
            'data' => array_values($departments)
        ];
    }

    private function calculateDemographics($data)
    {
        $gender = array_count_values(array_column($data, 'GenderCode'));
        $race = array_count_values(array_column($data, 'RaceDesc'));
        
        return [
            'gender' => [
                'labels' => array_keys($gender),
                'data' => array_values($gender)
            ],
            'race' => [
                'labels' => array_keys($race),
                'data' => array_values($race)
            ]
        ];
    }

    private function calculateAttendance($data)
    {
        // จำลองข้อมูลการลาและ OT (เนื่องจากไม่มีในข้อมูล CSV)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $attendance = [];
        
        foreach ($months as $month) {
            $attendance[$month] = [
                'sick' => rand(1, 5),
                'overtime' => rand(1, 5)
            ];
        }
        
        return [
            'labels' => array_keys($attendance),
            'sick' => array_column($attendance, 'sick'),
            'overtime' => array_column($attendance, 'overtime')
        ];
    }
} 