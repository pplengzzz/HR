<?php

namespace App\Http\Controllers;

use App\Models\Termination;
use App\Models\Employee;
use Illuminate\Http\Request;

class TerminationController extends Controller
{
    public function index(Request $request)
    {
        $query = Termination::with('employee');
        
        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('TerminationID', 'LIKE', "%{$search}%")
                  ->orWhere('EmployeeID', 'LIKE', "%{$search}%")
                  ->orWhere('TerminationType', 'LIKE', "%{$search}%")
                  ->orWhere('TerminationDescription', 'LIKE', "%{$search}%");
            });
        }

        // กรองตามประเภทการลาออก/เลิกจ้าง
        if ($request->has('type') && $request->type != '') {
            $query->where('TerminationType', $request->type);
        }

        $terminations = $query->get();
        $employees = Employee::all();
        $types = Termination::distinct()->pluck('TerminationType');

        return view('terminations.index', compact('terminations', 'employees', 'types'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('terminations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'EmployeeID' => 'required|exists:employee_1,EmployeeID',
            'TerminationType' => 'required',
            'TerminationDescription' => 'required'
        ]);

        // สร้างข้อมูลการลาออก/เลิกจ้าง
        Termination::create($request->all());

        // อัพเดทสถานะพนักงานเป็น Terminated
        $employee = Employee::find($request->EmployeeID);
        if ($employee) {
            $employee->update(['EmployeeStatus' => 'Terminated']);
        }

        return redirect()->route('terminations.index')->with('success', 'เพิ่มข้อมูลการลาออก/เลิกจ้างเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $termination = Termination::findOrFail($id);
        $employees = Employee::all();
        return view('terminations.edit', compact('termination', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'EmployeeID' => 'required|exists:employee_1,EmployeeID',
            'TerminationType' => 'required',
            'TerminationDescription' => 'required'
        ]);

        $termination = Termination::findOrFail($id);
        $termination->update($request->all());

        return redirect()->route('terminations.index')->with('success', 'อัพเดทข้อมูลการลาออก/เลิกจ้างเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $termination = Termination::findOrFail($id);
        
        // เก็บ EmployeeID ไว้ก่อนลบข้อมูล
        $employeeId = $termination->EmployeeID;
        
        $termination->delete();

        // อัพเดทสถานะพนักงานกลับเป็น Active
        $employee = Employee::find($employeeId);
        if ($employee) {
            $employee->update(['EmployeeStatus' => 'Active']);
        }

        return redirect()->route('terminations.index')->with('success', 'ลบข้อมูลการลาออก/เลิกจ้างเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $termination = Termination::with('employee')->findOrFail($id);
        return view('terminations.show', compact('termination'));
    }

    // เพิ่มเติม: ดึงข้อมูลสรุปการลาออก/เลิกจ้าง
    public function summary()
    {
        $summary = [
            'total_terminations' => Termination::count(),
            'by_type' => Termination::selectRaw('TerminationType, COUNT(*) as count')
                ->groupBy('TerminationType')
                ->get()
        ];

        return view('terminations.summary', compact('summary'));
    }
} 