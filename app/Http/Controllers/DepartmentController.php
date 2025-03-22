<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Business;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with(['businessUnit', 'employees']);
        
        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('DepartmentID', 'LIKE', "%{$search}%")
                  ->orWhere('DepartmentName', 'LIKE', "%{$search}%");
            });
        }

        // กรองตามหน่วยธุรกิจ
        if ($request->has('business_unit') && $request->business_unit != '') {
            $query->where('BusinessUnitID', $request->business_unit);
        }

        $departments = $query->get();
        $businessUnits = Business::all();

        return view('departments.index', compact('departments', 'businessUnits'));
    }

    public function create()
    {
        $businessUnits = Business::all();
        return view('departments.create', compact('businessUnits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'DepartmentID' => 'required|unique:department,DepartmentID|max:5',
            'DepartmentName' => 'required|max:50',
            'BusinessUnitID' => 'required|exists:business,BusinessUnitID'
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')->with('success', 'เพิ่มข้อมูลแผนกเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $businessUnits = Business::all();
        return view('departments.edit', compact('department', 'businessUnits'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'DepartmentName' => 'required|max:50',
            'BusinessUnitID' => 'required|exists:business,BusinessUnitID'
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'อัพเดทข้อมูลแผนกเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        
        // ตรวจสอบว่ามีพนักงานในแผนกนี้หรือไม่
        if ($department->employees()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'ไม่สามารถลบแผนกนี้ได้เนื่องจากมีพนักงานอยู่');
        }
        
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'ลบข้อมูลแผนกเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $department = Department::with(['businessUnit', 'employees'])->findOrFail($id);
        return view('departments.show', compact('department'));
    }

    // เพิ่มเติม: ดึงข้อมูลสรุปแผนก
    public function summary()
    {
        $summary = [
            'total_departments' => Department::count(),
            'by_business_unit' => Department::with('businessUnit')
                ->select('BusinessUnitID')
                ->selectRaw('COUNT(*) as department_count')
                ->groupBy('BusinessUnitID')
                ->get()
                ->map(function ($dept) {
                    return [
                        'business_unit' => $dept->businessUnit->BusinessUnitName,
                        'count' => $dept->department_count
                    ];
                }),
            'employee_count' => Department::withCount('employees')
                ->get()
                ->map(function ($dept) {
                    return [
                        'department' => $dept->DepartmentName,
                        'count' => $dept->employees_count
                    ];
                })
        ];

        return view('departments.summary', compact('summary'));
    }
} 