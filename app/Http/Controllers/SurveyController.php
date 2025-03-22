<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Employee;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = Survey::with('employee');
        
        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ReviewID', 'LIKE', "%{$search}%")
                  ->orWhere('EmployeeID', 'LIKE', "%{$search}%");
            });
        }

        // กรองตามคะแนน Engagement
        if ($request->has('engagement_score') && $request->engagement_score != '') {
            $query->where('EngagementScore', $request->engagement_score);
        }

        $surveys = $query->get();
        $employees = Employee::all();
        $engagementScores = Survey::distinct()->pluck('EngagementScore');

        return view('surveys.index', compact('surveys', 'employees', 'engagementScores'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('surveys.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'EmployeeID' => 'required|exists:employee_1,EmployeeID',
            'EngagementScore' => 'required|integer|between:1,5',
            'SatisfactionScore' => 'required|integer|between:1,5',
            'Work-LifeBalanceScore' => 'required|integer|between:1,5'
        ]);

        Survey::create($request->all());

        return redirect()->route('surveys.index')->with('success', 'เพิ่มข้อมูลแบบสำรวจเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
        $employees = Employee::all();
        return view('surveys.edit', compact('survey', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'EmployeeID' => 'required|exists:employee_1,EmployeeID',
            'EngagementScore' => 'required|integer|between:1,5',
            'SatisfactionScore' => 'required|integer|between:1,5',
            'Work-LifeBalanceScore' => 'required|integer|between:1,5'
        ]);

        $survey = Survey::findOrFail($id);
        $survey->update($request->all());

        return redirect()->route('surveys.index')->with('success', 'อัพเดทข้อมูลแบบสำรวจเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();

        return redirect()->route('surveys.index')->with('success', 'ลบข้อมูลแบบสำรวจเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $survey = Survey::with('employee')->findOrFail($id);
        return view('surveys.show', compact('survey'));
    }

    // เพิ่มเติม: ดึงข้อมูลสรุปผลแบบสำรวจ
    public function summary()
    {
        $summary = [
            'avg_engagement' => Survey::avg('EngagementScore'),
            'avg_satisfaction' => Survey::avg('SatisfactionScore'),
            'avg_worklife' => Survey::avg('Work-LifeBalanceScore'),
            'total_surveys' => Survey::count()
        ];

        return view('surveys.summary', compact('summary'));
    }
} 