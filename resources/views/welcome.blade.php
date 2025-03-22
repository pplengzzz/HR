@extends('layouts.app')

@section('content')
<div class="background-container">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-8 text-center">
                <div class="welcome-content">
                    <h1 class="display-4 mb-4" style="color: #000080;">ระบบจัดการทรัพยากรบุคคล</h1>
                    <p class="lead mb-5" style="color: #555;">ยินดีต้อนรับสู่ระบบจัดการข้อมูลพนักงานและประเมินผลการปฏิบัติงาน</p>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3" 
                       style="background: linear-gradient(135deg, #000080 0%, #000046 100%); border: none; border-radius: 50px; font-size: 1.2rem;">
                        <i class="fas fa-sign-in-alt me-2"></i>เข้าสู่ระบบ
                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<style>
    .background-container {
        background-image: url("{{ asset('images/background-home.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: calc(100vh - 62px);
        position: relative;
    }

    .background-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.4);
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .welcome-content {
        padding: 3rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(3px);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 128, 0.3);
        transition: all 0.3s ease;
    }
</style>
@endsection
