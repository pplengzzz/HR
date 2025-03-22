<?php

namespace App\Http\Controllers;

use App\Models\HrEmployee;
use App\Models\HrPerformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class HrUploadController extends Controller
{
    // แสดงหน้าอัพโหลด
    public function index()
    {
        return view('hr.upload');
    }

    // อัพโหลดข้อมูลพนักงาน
    public function uploadEmployees(Request $request)
    {
        try {
            // ลบข้อมูลเดิมถ้าผู้ใช้เลือก
            if ($request->has('truncate')) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                HrEmployee::truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            // อ่านไฟล์จาก storage/app
            $path = storage_path('app/HR-anlysis-Employees.csv');
            $records = array_map('str_getcsv', file($path));

            // คอลัมน์ที่ต้องการในตาราง hr_employees ตามลำดับในไฟล์
            $columns = [
                'EmployeeID', 'StartDate', 'Title', 'BusinessUnit', 
                'EmployeeStatus', 'EmployeeType', 'PayZone', 
                'EmployeeClassificationType', 'DepartmentType', 
                'Division', 'DOB', 'State', 'GenderCode', 
                'RaceDesc', 'MaritalDesc', 'Age'
            ];

            // อัพโหลดแต่ละแถว
            $totalRecords = 0;
            $successRecords = 0;

            foreach ($records as $record) {
                $totalRecords++;
                
                // กรณีแถวไม่มีข้อมูลครบตามคอลัมน์
                if (count($record) < count($columns)) {
                    continue;
                }

                // สร้างข้อมูลสำหรับบันทึก
                $data = [];
                for ($i = 0; $i < count($columns); $i++) {
                    $data[$columns[$i]] = $record[$i];
                }

                // อัพเดทหรือบันทึกข้อมูล
                $result = HrEmployee::updateOrCreate(
                    ['EmployeeID' => $data['EmployeeID']],
                    $data
                );

                if ($result) {
                    $successRecords++;
                }
            }

            return redirect()->back()->with('success', "อัพโหลดสำเร็จ: $successRecords/$totalRecords รายการ");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    // อัพโหลดข้อมูลผลงาน
    public function uploadPerformance(Request $request)
    {
        try {
            // ลบข้อมูลเดิมถ้าผู้ใช้เลือก
            if ($request->has('truncate')) {
                HrPerformance::truncate();
            }

            // อ่านไฟล์จาก storage/app
            $path = storage_path('app/HR-anlysis-Performance.csv');
            $records = array_map('str_getcsv', file($path));

            // คอลัมน์ที่ต้องการในตาราง hr_performance ตามลำดับในไฟล์
            $columns = [
                'EmployeeID', 'PerformanceScore', 'CurrentEmployeeRating',
                'EngagementScore', 'SatisfactionScore', 'WorkLifeBalanceScore'
            ];

            // อัพโหลดแต่ละแถว
            $totalRecords = 0;
            $successRecords = 0;

            foreach ($records as $record) {
                $totalRecords++;
                
                // กรณีแถวไม่มีข้อมูลครบตามคอลัมน์
                if (count($record) < count($columns)) {
                    continue;
                }

                // สร้างข้อมูลสำหรับบันทึก
                $data = [];
                for ($i = 0; $i < count($columns); $i++) {
                    $data[$columns[$i]] = $record[$i];
                }

                // อัพเดทหรือบันทึกข้อมูล
                $result = HrPerformance::updateOrCreate(
                    ['EmployeeID' => $data['EmployeeID']],
                    $data
                );

                if ($result) {
                    $successRecords++;
                }
            }

            return redirect()->back()->with('success', "อัพโหลดสำเร็จ: $successRecords/$totalRecords รายการ");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
} 