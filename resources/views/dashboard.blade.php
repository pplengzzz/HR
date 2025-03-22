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

    <!-- Performance Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header performance-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>ผลการปฏิบัติงาน</h5>
                </div>
                <div class="card-body bg-white">
                    <div class="row g-4">
                        <!-- Performance Ratings -->
                        <div class="col-md-6">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">การประเมินผลงาน</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="performanceChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Scores -->
                        <div class="col-md-6">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">คะแนนการทำงาน</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="scoresChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Department Performance Heatmap -->
                        <div class="col-md-6">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">คะแนน Performance ตามแผนก</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="departmentPerformanceChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Satisfaction Ratio -->
                        <div class="col-md-6">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">สัดส่วนความพึงพอใจของพนักงาน</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="satisfactionRatioChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Engagement Trend -->
                        <div class="col-md-6">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">คะแนน Engagement เฉลี่ย</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="engagementTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance vs Satisfaction -->
                        <div class="col-md-6">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">Performance vs. Satisfaction</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="performanceSatisfactionChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Dashboard -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header employee-header">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>ข้อมูลพนักงาน</h5>
                </div>
                <div class="card-body bg-white">
                    <div class="row g-4">
                        <!-- Department Distribution -->
                        <div class="col-md-4">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">การกระจายตัวตามแผนก</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="departmentChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Demographics -->
                        <div class="col-md-4">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">ข้อมูลประชากร</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="demographicsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance -->
                        <div class="col-md-4">
                            <div class="card h-100 dashboard-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">การลาและการทำงานล่วงเวลา</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="attendanceChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

.filter-header, .performance-header, .employee-header {
    color: white;
}

.filter-header {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
    padding: 1rem;
    border-radius: 12px 12px 0 0;
}

.performance-header {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--accent-color) 100%);
    padding: 1rem;
    border-radius: 12px 12px 0 0;
}

.employee-header {
    background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-light) 100%);
    padding: 1rem;
    border-radius: 12px 12px 0 0;
}

.dashboard-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
    background-color: white;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(26, 35, 126, 0.1);
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

.card-title {
    color: white;
}

/* เพิ่มสไตล์ใหม่สำหรับ Navbar */
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

/* ปรับขนาดกราฟ */
.chart-container {
    position: relative;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.dashboard-card {
    height: 100%;
    min-height: 350px;
}

.dashboard-card .card-body {
    height: 100%;
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
}

.dashboard-card .card-title {
    margin-bottom: 1rem;
}

.chart-wrapper {
    flex: 1;
    position: relative;
    width: 100%;
}

canvas {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
</style>

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Objects
    let charts = {
        performanceChart: null,
        scoresChart: null,
        departmentChart: null,
        demographicsChart: null,
        attendanceChart: null,
        departmentPerformanceChart: null,
        satisfactionRatioChart: null,
        engagementTrendChart: null,
        performanceSatisfactionChart: null
    };

    // สีที่ใช้ในกราฟ
    const colors = {
        blue: ['#1976d2', '#2196f3', '#64b5f6', '#bbdefb'],
        green: ['#388e3c', '#4caf50', '#81c784', '#c8e6c9'],
        red: ['#d32f2f', '#f44336', '#e57373', '#ffcdd2'],
        orange: ['#f57c00', '#ff9800', '#ffb74d', '#ffe0b2'],
        purple: ['#7b1fa2', '#9c27b0', '#ba68c8', '#e1bee7']
    };

    // ฟังก์ชันสำหรับโหลดข้อมูล
    function loadDashboardData() {
        const formData = new FormData(document.getElementById('filterForm'));
        const params = new URLSearchParams(formData);

        fetch(`/dashboard/data?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                updateCharts(data);
            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
            });
    }

    // ฟังก์ชันสำหรับอัพเดทกราฟ
    function updateCharts(data) {
        if (!data || !data.performance || !data.employee) {
            console.error('Invalid data format');
            return;
        }

        // ปรับ options สำหรับทุกกราฟ
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        };

        // Performance Chart (Pie)
        if (charts.performanceChart) charts.performanceChart.destroy();
        charts.performanceChart = new Chart(document.getElementById('performanceChart'), {
            type: 'pie',
            data: {
                labels: data.performance.ratings.labels,
                datasets: [{
                    data: data.performance.ratings.data,
                    backgroundColor: colors.blue
                }]
            },
            options: commonOptions
        });

        // Scores Chart (Bar)
        if (charts.scoresChart) charts.scoresChart.destroy();
        charts.scoresChart = new Chart(document.getElementById('scoresChart'), {
            type: 'bar',
            data: {
                labels: ['ความผูกพัน', 'ความพึงพอใจ', 'สมดุลชีวิต'],
                datasets: [{
                    label: 'คะแนนเฉลี่ย',
                    data: [
                        data.performance.scores.engagement,
                        data.performance.scores.satisfaction,
                        data.performance.scores.worklife
                    ],
                    backgroundColor: colors.green[1]
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });

        // Department Performance Chart (Bar)
        if (charts.departmentPerformanceChart) charts.departmentPerformanceChart.destroy();
        if (data.performance.departmentScores) {
            charts.departmentPerformanceChart = new Chart(document.getElementById('departmentPerformanceChart'), {
                type: 'bar',
                data: {
                    labels: data.performance.departmentScores.labels,
                    datasets: [{
                        label: 'คะแนนเฉลี่ย',
                        data: data.performance.departmentScores.data,
                        backgroundColor: colors.purple[1]
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5
                        }
                    }
                }
            });
        }

        // Satisfaction Ratio Chart (Pie)
        if (charts.satisfactionRatioChart) charts.satisfactionRatioChart.destroy();
        if (data.performance.satisfaction_ratio) {
            charts.satisfactionRatioChart = new Chart(document.getElementById('satisfactionRatioChart'), {
                type: 'pie',
                data: {
                    labels: data.performance.satisfaction_ratio.labels,
                    datasets: [{
                        data: data.performance.satisfaction_ratio.data,
                        backgroundColor: [colors.green[1], colors.red[1]]
                    }]
                }
            });
        }

        // Engagement Trend Chart (Line)
        if (charts.engagementTrendChart) charts.engagementTrendChart.destroy();
        if (data.performance.engagement_trend) {
            charts.engagementTrendChart = new Chart(document.getElementById('engagementTrendChart'), {
                type: 'line',
                data: {
                    labels: data.performance.engagement_trend.labels,
                    datasets: [{
                        label: 'คะแนน Engagement',
                        data: data.performance.engagement_trend.data,
                        borderColor: colors.blue[1],
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5
                        }
                    }
                }
            });
        }

        // Performance vs Satisfaction Chart (Scatter)
        if (charts.performanceSatisfactionChart) charts.performanceSatisfactionChart.destroy();
        if (data.performance.performance_satisfaction) {
            const scatterData = data.performance.performance_satisfaction.performance.map((perf, i) => ({
                x: perf,
                y: data.performance.performance_satisfaction.satisfaction[i]
            }));

            charts.performanceSatisfactionChart = new Chart(document.getElementById('performanceSatisfactionChart'), {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'พนักงาน',
                        data: scatterData,
                        backgroundColor: colors.orange[1]
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Performance Score'
                            },
                            beginAtZero: true,
                            max: 5
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Satisfaction Score'
                            },
                            beginAtZero: true,
                            max: 5
                        }
                    }
                }
            });
        }

        // Department Chart (Bar)
        if (charts.departmentChart) charts.departmentChart.destroy();
        charts.departmentChart = new Chart(document.getElementById('departmentChart'), {
            type: 'bar',
            data: {
                labels: data.employee.departments.labels,
                datasets: [{
                    label: 'จำนวนพนักงาน',
                    data: data.employee.departments.data,
                    backgroundColor: colors.blue[1]
                }]
            }
        });

        // Demographics Chart (Pie)
        if (charts.demographicsChart) charts.demographicsChart.destroy();
        charts.demographicsChart = new Chart(document.getElementById('demographicsChart'), {
            type: 'pie',
            data: {
                labels: data.employee.demographics.gender.labels,
                datasets: [{
                    data: data.employee.demographics.gender.data,
                    backgroundColor: [colors.blue[1], colors.red[1]]
                }]
            }
        });

        // Attendance Chart (Line)
        if (charts.attendanceChart) charts.attendanceChart.destroy();
        charts.attendanceChart = new Chart(document.getElementById('attendanceChart'), {
            type: 'line',
            data: {
                labels: data.employee.attendance.labels,
                datasets: [
                    {
                        label: 'ลาป่วย',
                        data: data.employee.attendance.sick,
                        borderColor: colors.red[1],
                        tension: 0.1
                    },
                    {
                        label: 'ทำงานล่วงเวลา',
                        data: data.employee.attendance.overtime,
                        borderColor: colors.green[1],
                        tension: 0.1
                    }
                ]
            }
        });
    }

    // โหลดข้อมูลครั้งแรก
    loadDashboardData();

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
        loadDashboardData();
    });

    // Handle Form Reset
    filterForm.addEventListener('reset', function(e) {
        setTimeout(() => loadDashboardData(), 0);
    });
});
</script>
@endpush 