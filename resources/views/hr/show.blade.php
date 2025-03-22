@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    รายละเอียดพนักงาน #{{ $employee->EmployeeID }}
                    <a href="{{ route('hr.index') }}" class="btn btn-secondary btn-sm float-end">กลับ</a>
                </div>

                <div class="card-body">
                    <h5>ข้อมูลทั่วไป</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>ตำแหน่ง:</strong> {{ $employee->Title }}</p>
                            <p><strong>แผนก:</strong> {{ $employee->DepartmentType }}</p>
                            <p><strong>สายงาน:</strong> {{ $employee->Division }}</p>
                            <p><strong>หน่วยธุรกิจ:</strong> {{ $employee->BusinessUnit }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>วันที่เริ่มงาน:</strong> {{ $employee->StartDate }}</p>
                            <p><strong>สถานะ:</strong> {{ $employee->EmployeeStatus }}</p>
                            <p><strong>ประเภทพนักงาน:</strong> {{ $employee->EmployeeType }}</p>
                            <p><strong>ประเภทการจ้าง:</strong> {{ $employee->EmployeeClassificationType }}</p>
                        </div>
                    </div>

                    <h5>ข้อมูลส่วนตัว</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>อายุ:</strong> {{ $employee->Age }}</p>
                            <p><strong>เพศ:</strong> {{ $employee->GenderCode }}</p>
                            <p><strong>สถานภาพ:</strong> {{ $employee->MaritalDesc }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>วันเกิด:</strong> {{ $employee->DOB }}</p>
                            <p><strong>รัฐ:</strong> {{ $employee->State }}</p>
                            <p><strong>เชื้อชาติ:</strong> {{ $employee->RaceDesc }}</p>
                        </div>
                    </div>

                    @if($employee->performance)
                    <h5>ผลการปฏิบัติงาน</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>คะแนนผลงาน:</strong> {{ $employee->performance->Performance_Score }}</p>
                            <p><strong>เรตติ้งปัจจุบัน:</strong> {{ $employee->performance->Current_Employee_Rating }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>คะแนนการมีส่วนร่วม:</strong> {{ $employee->performance->Engagement_Score }}</p>
                            <p><strong>คะแนนความพึงพอใจ:</strong> {{ $employee->performance->Satisfaction_Score }}</p>
                            <p><strong>สมดุลชีวิตการทำงาน:</strong> {{ $employee->performance->{'Work-Life_Balance'} }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 