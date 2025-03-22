@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>อัพโหลดข้อมูล HR</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <ul class="nav nav-tabs mb-4" id="uploadTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab" aria-controls="employees" aria-selected="true">ข้อมูลพนักงาน</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="performance-tab" data-bs-toggle="tab" data-bs-target="#performance" type="button" role="tab" aria-controls="performance" aria-selected="false">ข้อมูลผลงาน</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="uploadTabsContent">
                        <!-- ข้อมูลพนักงาน -->
                        <div class="tab-pane fade show active" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                            <form action="{{ route('hr.upload.employees') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="employeesFile" class="form-label">เลือกไฟล์ CSV ข้อมูลพนักงาน</label>
                                    <input class="form-control" type="file" id="employeesFile" name="employeesFile" accept=".csv" required>
                                    <div class="form-text">
                                        ไฟล์ CSV ต้องมีข้อมูลตามลำดับ: EmployeeID, FirstName, LastName, Email, Phone, DepartmentType, PositionTitle, GenderCode, StartDate, EmployeeStatus
                                    </div>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="truncateEmployees" name="truncate">
                                    <label class="form-check-label" for="truncateEmployees">
                                        ลบข้อมูลพนักงานทั้งหมดก่อนอัพโหลด
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>อัพโหลดข้อมูลพนักงาน
                                </button>
                            </form>
                        </div>
                        
                        <!-- ข้อมูลผลงาน -->
                        <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                            <form action="{{ route('hr.upload.performance') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="performanceFile" class="form-label">เลือกไฟล์ CSV ข้อมูลผลงาน</label>
                                    <input class="form-control" type="file" id="performanceFile" name="performanceFile" accept=".csv" required>
                                    <div class="form-text">
                                        ไฟล์ CSV ต้องมีข้อมูลตามลำดับ: EmployeeID, ReviewDate, PerformanceScore, EngagementScore, SatisfactionScore, WorklifeScore, Comments
                                    </div>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="truncatePerformance" name="truncate">
                                    <label class="form-check-label" for="truncatePerformance">
                                        ลบข้อมูลผลงานทั้งหมดก่อนอัพโหลด
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>อัพโหลดข้อมูลผลงาน
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>คำแนะนำการอัพโหลด</h5>
                </div>
                <div class="card-body">
                    <h6>รูปแบบไฟล์</h6>
                    <ul>
                        <li>ไฟล์ต้องเป็นรูปแบบ CSV</li>
                        <li>ไม่ต้องใส่แถวหัวข้อคอลัมน์</li>
                        <li>ใช้เครื่องหมายจุลภาค (,) เป็นตัวคั่นระหว่างคอลัมน์</li>
                    </ul>
                    
                    <h6>คำเตือน</h6>
                    <ul>
                        <li>หากเลือก "ลบข้อมูลทั้งหมดก่อนอัพโหลด" ข้อมูลเดิมจะถูกลบทั้งหมด</li>
                        <li>ถ้าไม่เลือก ระบบจะพยายามอัพเดทข้อมูลที่มีรหัสพนักงานซ้ำกัน</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 