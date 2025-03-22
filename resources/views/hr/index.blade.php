@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>จัดการข้อมูล HR</h1>
        <div>
            <a href="{{ route('hr.upload') }}" class="btn btn-info">
                <i class="fas fa-upload me-2"></i>อัพโหลดข้อมูล CSV
            </a>
            <a href="{{ route('hr.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>เพิ่มข้อมูลใหม่
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-users"></i> รายการพนักงาน
                            <small class="text-muted fs-6">พบข้อมูลทั้งหมด {{ $employees->count() }} รายการ</small>
                        </h4>
                        <a href="{{ route('hr.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> เพิ่มพนักงาน
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- ส่วนค้นหาและกรอง -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <form action="{{ route('hr.index') }}" method="GET">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-search"></i> ค้นหา</label>
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="ค้นหารหัส, ตำแหน่ง, แผนก..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-building"></i> แผนก</label>
                                        <select name="department" class="form-select">
                                            <option value="">ทั้งหมด</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department }}" 
                                                    {{ request('department') == $department ? 'selected' : '' }}>
                                                    {{ $department }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-user-clock"></i> สถานะ</label>
                                        <select name="status" class="form-select">
                                            <option value="">ทั้งหมด</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status }}" 
                                                    {{ request('status') == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> ค้นหา
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ตารางแสดงข้อมูล -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 80px">รหัส</th>
                                    <th style="width: 200px">ตำแหน่ง</th>
                                    <th style="width: 150px">แผนก</th>
                                    <th style="width: 100px">สถานะ</th>
                                    <th class="text-center" style="width: 120px">Performance</th>
                                    <th class="text-center" style="width: 120px">Engagement</th>
                                    <th class="text-center" style="width: 120px">Satisfaction</th>
                                    <th style="width: 100px">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr>
                                        <td class="text-center fw-bold">{{ $employee->EmployeeID }}</td>
                                        <td>{{ $employee->Title }}</td>
                                        <td>
                                            <span class="badge bg-info text-dark rounded-pill px-3">
                                                <i class="fas fa-building me-1"></i>
                                                {{ $employee->DepartmentType }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($employee->EmployeeStatus == 'Active')
                                                <span class="badge bg-success rounded-pill px-3">
                                                    <i class="fas fa-check-circle me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3">
                                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ $employee->performance->PerformanceScore ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $score = $employee->performance->EngagementScore ?? 0;
                                            @endphp
                                            <span class="badge bg-light text-dark border">
                                                {{ $score }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $score = $employee->performance->SatisfactionScore ?? 0;
                                            @endphp
                                            <span class="badge bg-light text-dark border">
                                                {{ $score }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('hr.edit', $employee->EmployeeID) }}" 
                                                   class="btn btn-icon btn-edit" 
                                                   data-bs-toggle="tooltip" 
                                                   title="แก้ไข">
                                                    <i class="fas fa-user-edit fa-fw"></i>
                                                </a>
                                                <form action="{{ route('hr.destroy', $employee->EmployeeID) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('คุณแน่ใจที่จะลบข้อมูลนี้?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-icon btn-delete"
                                                            data-bs-toggle="tooltip" 
                                                            title="ลบ">
                                                        <i class="fas fa-user-minus fa-fw"></i>
                                                    </button>
                                                </form>
                                                <a href="#" 
                                                   class="btn btn-icon btn-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="ดูข้อมูล">
                                                    <i class="fas fa-user-check fa-fw"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-folder-open me-2"></i>ไม่พบข้อมูล
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-size: 0.9em;
}
.table > :not(caption) > * > * {
    padding: 1rem 0.5rem;
}
.btn-icon {
    width: 35px;
    height: 35px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.btn-icon i {
    font-size: 0.95rem;
}
.btn-edit {
    background-color: #fff8e1;
    color: #ffa000;
    border: 1px solid #ffe082;
}
.btn-edit:hover {
    background-color: #ffa000;
    color: #fff;
    border-color: #ffa000;
}
.btn-delete {
    background-color: #ffebee;
    color: #f44336;
    border: 1px solid #ffcdd2;
}
.btn-delete:hover {
    background-color: #f44336;
    color: #fff;
    border-color: #f44336;
}
.btn-info {
    background-color: #e3f2fd;
    color: #1976d2;
    border: 1px solid #bbdefb;
}
.btn-info:hover {
    background-color: #1976d2;
    color: #fff;
    border-color: #1976d2;
}
</style>
@endsection 