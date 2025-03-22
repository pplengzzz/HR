<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::query();
        
        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('BusinessUnitID', 'LIKE', "%{$search}%")
                  ->orWhere('BusinessUnitName', 'LIKE', "%{$search}%");
            });
        }

        $businesses = $query->get();

        return view('business.index', compact('businesses'));
    }

    public function create()
    {
        return view('business.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'BusinessUnitID' => 'required|unique:business,BusinessUnitID|max:5',
            'BusinessUnitName' => 'required|max:4'
        ]);

        Business::create($request->all());

        return redirect()->route('business.index')->with('success', 'เพิ่มข้อมูลหน่วยธุรกิจเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('business.edit', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'BusinessUnitName' => 'required|max:4'
        ]);

        $business = Business::findOrFail($id);
        $business->update($request->all());

        return redirect()->route('business.index')->with('success', 'อัพเดทข้อมูลหน่วยธุรกิจเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        
        // ตรวจสอบว่ามีพนักงานในหน่วยธุรกิจนี้หรือไม่
        if ($business->employees()->count() > 0) {
            return redirect()->route('business.index')
                ->with('error', 'ไม่สามารถลบหน่วยธุรกิจนี้ได้เนื่องจากมีพนักงานอยู่');
        }
        
        $business->delete();

        return redirect()->route('business.index')->with('success', 'ลบข้อมูลหน่วยธุรกิจเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $business = Business::with('employees')->findOrFail($id);
        return view('business.show', compact('business'));
    }

    // เพิ่มเติม: ดึงข้อมูลสรุปหน่วยธุรกิจ
    public function summary()
    {
        $summary = [
            'total_units' => Business::count(),
            'employee_count' => Business::withCount('employees')
                ->get()
                ->map(function ($business) {
                    return [
                        'unit' => $business->BusinessUnitName,
                        'count' => $business->employees_count
                    ];
                })
        ];

        return view('business.summary', compact('summary'));
    }
} 