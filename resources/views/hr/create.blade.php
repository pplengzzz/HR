@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">เพิ่มข้อมูลพนักงาน</h4>
                        <a href="{{ route('hr.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> กลับ
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('hr.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h5>ข้อมูลพื้นฐาน</h5>
                                <div class="mb-3">
                                    <label for="EmployeeID" class="form-label">รหัสพนักงาน *</label>
                                    <input type="text" class="form-control @error('EmployeeID') is-invalid @enderror" 
                                           id="EmployeeID" name="EmployeeID" required>
                                    @error('EmployeeID')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="Title" class="form-label">ตำแหน่ง *</label>
                                    <input type="text" class="form-control @error('Title') is-invalid @enderror" 
                                           id="Title" name="Title" required>
                                </div>

                                <div class="mb-3">
                                    <label for="DepartmentType" class="form-label">แผนก *</label>
                                    <input type="text" class="form-control @error('DepartmentType') is-invalid @enderror" 
                                           id="DepartmentType" name="DepartmentType" required>
                                </div>

                                <div class="mb-3">
                                    <label for="BusinessUnit" class="form-label">หน่วยธุรกิจ</label>
                                    <input type="text" class="form-control" id="BusinessUnit" name="BusinessUnit">
                                </div>

                                <div class="mb-3">
                                    <label for="EmployeeStatus" class="form-label">สถานะ *</label>
                                    <select class="form-select @error('EmployeeStatus') is-invalid @enderror" 
                                            id="EmployeeStatus" name="EmployeeStatus" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="EmployeeType" class="form-label">ประเภทพนักงาน</label>
                                    <select class="form-select" id="EmployeeType" name="EmployeeType">
                                        <option value="Full-Time">Full-Time</option>
                                        <option value="Part-Time">Part-Time</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>ข้อมูล Performance</h5>
                                <div class="mb-3">
                                    <label for="PerformanceScore" class="form-label">คะแนน Performance</label>
                                    <input type="text" class="form-control" id="PerformanceScore" name="PerformanceScore">
                                </div>

                                <div class="mb-3">
                                    <label for="CurrentEmployeeRating" class="form-label">Rating ปัจจุบัน</label>
                                    <input type="number" class="form-control" id="CurrentEmployeeRating" 
                                           name="CurrentEmployeeRating" min="1" max="5">
                                </div>

                                <div class="mb-3">
                                    <label for="EngagementScore" class="form-label">คะแนน Engagement</label>
                                    <input type="number" class="form-control" id="EngagementScore" 
                                           name="EngagementScore" min="1" max="5">
                                </div>

                                <div class="mb-3">
                                    <label for="SatisfactionScore" class="form-label">คะแนน Satisfaction</label>
                                    <input type="number" class="form-control" id="SatisfactionScore" 
                                           name="SatisfactionScore" min="1" max="5">
                                </div>

                                <div class="mb-3">
                                    <label for="WorkLifeBalanceScore" class="form-label">คะแนน Work-Life Balance</label>
                                    <input type="number" class="form-control" id="WorkLifeBalanceScore" 
                                           name="WorkLifeBalanceScore" min="1" max="5">
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> บันทึก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection