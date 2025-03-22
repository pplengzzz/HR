<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\HrPerformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();
        
        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('EmployeeID', 'LIKE', "%{$search}%")
                  ->orWhere('EmployeeType', 'LIKE', "%{$search}%")
                  ->orWhere('DepartmentID', 'LIKE', "%{$search}%");
            });
        }

        // กรองตามแผนก
        if ($request->has('department') && $request->department != '') {
            $query->where('DepartmentID', $request->department);
        }

        // กรองตามสถานะ
        if ($request->has('status') && $request->status != '') {
            $query->where('EmployeeStatus', $request->status);
        }

        $employees = $query->get();
        $departments = Employee::distinct()->pluck('DepartmentID');
        $statuses = Employee::distinct()->pluck('EmployeeStatus');

        return view('hr.index', compact('employees', 'departments', 'statuses'));
    }

    public function create()
    {
        return view('hr.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'EmployeeID' => 'required|unique:employee_1',
            'EmployeeType' => 'required',
            'DepartmentID' => 'required',
            'EmployeeStatus' => 'required',
        ]);

        // สร้าง array ของข้อมูลที่จะบันทึก
        $employeeData = $request->all();
        
        // กำหนดค่าเริ่มต้นสำหรับฟิลด์ที่จำเป็น
        $employeeData['StartDate'] = now()->format('Y-m-d');
        $employeeData['PayZone'] = $employeeData['PayZone'] ?? 'Zone A';
        $employeeData['BusinessUnitID'] = $employeeData['BusinessUnitID'] ?? 'MAIN';
        $employeeData['DOB'] = $employeeData['DOB'] ?? '1990-01-01';
        $employeeData['State'] = $employeeData['State'] ?? 'BKK';
        $employeeData['GenderCode'] = $employeeData['GenderCode'] ?? 'M';
        $employeeData['RaceDesc'] = $employeeData['RaceDesc'] ?? 'Asian';
        $employeeData['MaritalDesc'] = $employeeData['MaritalDesc'] ?? 'Single';
        $employeeData['Age'] = $employeeData['Age'] ?? 30;

        $employee = Employee::create($employeeData);

        return redirect()->route('hr.index')->with('success', 'เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('hr.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'EmployeeType' => 'required',
            'DepartmentID' => 'required',
            'EmployeeStatus' => 'required',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('hr.index')->with('success', 'อัพเดทข้อมูลพนักงานเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('hr.index')->with('success', 'ลบข้อมูลพนักงานเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('hr.show', compact('employee'));
    }
} 