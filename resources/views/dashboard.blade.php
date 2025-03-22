@extends('layouts.app')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--accent-color) 100%);">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-building me-2"></i>
            MyProject Company
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/dashboard">
                        <i class="fas fa-chart-bar me-1"></i>Dashboard
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid py-4">
    <!-- หัวข้อ Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 d-flex align-items-center">
                    <span class="dashboard-title-hr">HR</span>
                    <span class="dashboard-title-dashboard">DASHBOARD</span>
                </h2>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header filter-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>ตัวกรองข้อมูล
                        <button class="btn btn-light btn-sm float-end" id="toggleFilters">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </h5>
                </div>
                <div class="card-body bg-light" id="filterSection" style="display: none;">
                    <form id="filterForm" class="row g-3">
                        <!-- Date Range -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">ช่วงวันที่</label>
                            <div class="input-group">
                                <input type="date" class="form-control custom-input" id="startDate" name="startDate">
                                <span class="input-group-text bg-secondary text-white">ถึง</span>
                                <input type="date" class="form-control custom-input" id="endDate" name="endDate">
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">แผนก</label>
                            <select class="form-select custom-input" id="department" name="department">
                                <option value="">ทั้งหมด</option>
                                <option value="Production">ฝ่ายผลิต</option>
                                <option value="Sales">ฝ่ายขาย</option>
                                <option value="IT/IS">ไอที</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">สถานะ</label>
                            <select class="form-select custom-input" id="status" name="status">
                                <option value="">ทั้งหมด</option>
                                <option value="Active">ทำงานอยู่</option>
                                <option value="Terminated">ลาออก</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary custom-btn">
                                <i class="fas fa-search me-2"></i>ค้นหา
                            </button>
                            <button type="reset" class="btn btn-secondary custom-btn ms-2">
                                <i class="fas fa-redo me-2"></i>รีเซ็ต
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-dark: #1a237e;
    --primary-light: #534bae;
    --secondary-dark: #263238;
    --accent-color: #0d47a1;
}

.dashboard-title-hr {
    color: var(--primary-dark);
    font-weight: 600;
    font-size: 2rem;
}

.dashboard-title-dashboard {
    color: var(--accent-color);
    font-weight: 700;
    margin-left: 8px;
    font-size: 2rem;
}

.filter-header {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
    padding: 1rem;
    border-radius: 12px 12px 0 0;
    color: white;
}

.custom-input {
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    padding: 0.5rem;
    transition: all 0.3s ease;
}

.custom-input:focus {
    border-color: var(--primary-dark);
    box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.25);
}

.custom-btn {
    border-radius: 6px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--primary-dark) !important;
    border-color: var(--primary-dark) !important;
}

.btn-primary:hover {
    background-color: var(--primary-light) !important;
    border-color: var(--primary-light) !important;
}

.btn-secondary {
    background-color: var(--secondary-dark) !important;
    border-color: var(--secondary-dark) !important;
}

.card {
    border-radius: 12px;
    overflow: hidden;
}

.form-label {
    color: var(--secondary-dark);
}

/* Navbar styles */
.navbar {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.navbar-dark .navbar-nav .nav-link {
    color: rgba(255,255,255,0.9);
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.navbar-dark .navbar-nav .nav-link:hover {
    color: #ffffff;
    background-color: rgba(255,255,255,0.1);
    border-radius: 4px;
}

.navbar-dark .navbar-nav .nav-link.active {
    color: #ffffff;
    background-color: rgba(255,255,255,0.2);
    border-radius: 4px;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: rgba(26, 35, 126, 0.1);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Filters
    const toggleFilters = document.getElementById('toggleFilters');
    const filterSection = document.getElementById('filterSection');
    const chevronIcon = toggleFilters.querySelector('i');

    toggleFilters.addEventListener('click', function() {
        if (filterSection.style.display === 'none') {
            filterSection.style.display = 'block';
            chevronIcon.classList.replace('fa-chevron-down', 'fa-chevron-up');
        } else {
            filterSection.style.display = 'none';
            chevronIcon.classList.replace('fa-chevron-up', 'fa-chevron-down');
        }
    });

    // Handle Form Submit
    const filterForm = document.getElementById('filterForm');
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
    });

    // Handle Form Reset
    filterForm.addEventListener('reset', function(e) {
        setTimeout(() => {}, 0);
    });
});
</script>
@endpush 