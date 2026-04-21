<x-app-layout>
    @section('title', 'Profil Saya')
    @section('page-title', 'Profil Pengguna')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Profil</li>
    @endsection

    <style>
        .profile-card {
            border-radius: 15px;
            border: none;
            overflow: hidden;
            background: #fff;
            transition: all 0.3s ease;
        }
        .profile-header-bg {
            background: linear-gradient(135deg, #065f46, #047857);
            height: 120px;
            position: relative;
        }
        .profile-avatar-wrapper {
            position: relative;
            margin-top: -60px;
            margin-bottom: 20px;
            text-align: center;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid #fff;
            background: #f8fafc;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #047857;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .profile-info {
            text-align: center;
            padding: 0 20px 30px;
        }
        .section-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            margin-bottom: 30px;
        }
        .section-title {
            font-weight: 700;
            color: #065f46;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }
        .section-title i {
            margin-right: 10px;
            color: #f59e0b;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <!-- Profile Overview Card -->
            <div class="col-lg-4">
                <div class="profile-card shadow-sm mb-4">
                    <div class="profile-header-bg"></div>
                    <div class="profile-avatar-wrapper">
                        <div class="profile-avatar shadow">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="profile-info">
                        <h4 class="font-weight-bold mb-1">{{ Auth::user()->name }}</h4>
                        <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            @foreach(Auth::user()->getRoleNames() as $role)
                                <span class="badge badge-success px-3 py-2 rounded-pill shadow-sm" style="background: #047857;">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                        
                        @if(Auth::user()->unit)
                            <div class="mt-3 p-3 bg-light rounded-lg border border-faint">
                                <small class="text-muted d-block mb-1">Unit Kerja:</small>
                                <span class="font-weight-bold text-dark">{{ Auth::user()->unit->nama_unit }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Settings Forms -->
            <div class="col-lg-8">
                <div class="section-card shadow-sm">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i> Informasi Profil
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="section-card shadow-sm">
                    <div class="section-title">
                        <i class="fas fa-shield-alt"></i> Keamanan Akun
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="section-card shadow-sm border-danger-faint">
                    <div class="section-title text-danger">
                        <i class="fas fa-exclamation-triangle text-danger"></i> Zona Bahaya
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
