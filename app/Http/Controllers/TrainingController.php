<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Employee;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::with('employee');
        
        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('TrainingID', 'LIKE', "%{$search}%")
                  ->orWhere('ProgramName', 'LIKE', "%{$search}%")
                  ->orWhere('TrainingType', 'LIKE', "%{$search}%")
                  ->orWhere('Trainer', 'LIKE', "%{$search}%");
            });
        }

        // กรองตามประเภทการฝึกอบรม
        if ($request->has('type') && $request->type != '') {
            $query->where('TrainingType', $request->type);
        }

        $trainings = $query->get();
        $types = Training::distinct()->pluck('TrainingType');
        $employees = Employee::all();

        return view('training.index', compact('trainings', 'types', 'employees'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('training.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'EmployeeID' => 'required|exists:employee_1,EmployeeID',
            'ProgramName' => 'required',
            'TrainingType' => 'required',
            'TrainingOutcome' => 'required',
            'TrainingDuration' => 'required|integer',
            'TrainingCost' => 'required|numeric',
            'Trainer' => 'required'
        ]);

        Training::create($request->all());

        return redirect()->route('training.index')->with('success', 'เพิ่มข้อมูลการฝึกอบรมเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $training = Training::findOrFail($id);
        $employees = Employee::all();
        return view('training.edit', compact('training', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'EmployeeID' => 'required|exists:employee_1,EmployeeID',
            'ProgramName' => 'required',
            'TrainingType' => 'required',
            'TrainingOutcome' => 'required',
            'TrainingDuration' => 'required|integer',
            'TrainingCost' => 'required|numeric',
            'Trainer' => 'required'
        ]);

        $training = Training::findOrFail($id);
        $training->update($request->all());

        return redirect()->route('training.index')->with('success', 'อัพเดทข้อมูลการฝึกอบรมเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return redirect()->route('training.index')->with('success', 'ลบข้อมูลการฝึกอบรมเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $training = Training::with('employee')->findOrFail($id);
        return view('training.show', compact('training'));
    }
} 