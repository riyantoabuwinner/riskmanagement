<x-app-layout>
    @section('title', 'Menunggu Persetujuan')
    @section('page-title', 'Status Akun')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Menunggu Persetujuan</li>
    @endsection

    <div style="min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
        <div style="max-width: 560px; width: 100%; text-align: center;">

            {{-- Animated Icon --}}
            <div style="margin-bottom: 32px;">
                <div style="
                    width: 110px; height: 110px; border-radius: 50%;
                    background: linear-gradient(135deg, #fef3c7, #fde68a);
                    display: flex; align-items: center; justify-content: center;
                    margin: 0 auto;
                    box-shadow: 0 0 0 16px rgba(251,191,36,0.1), 0 0 0 32px rgba(251,191,36,0.05);
                    animation: pulse-ring 2s ease-in-out infinite;
                ">
                    <i class="fas fa-user-clock" style="font-size: 2.8rem; color: #d97706;"></i>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="card" style="border-radius: 20px !important; overflow: hidden; border: none !important; box-shadow: 0 8px 32px rgba(0,0,0,0.08) !important;">
                {{-- Top accent bar --}}
                <div style="height: 4px; background: linear-gradient(90deg, #f59e0b, #fbbf24, #fcd34d);"></div>

                <div class="card-body" style="padding: 40px !important;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin-bottom: 12px;">
                        Akun Anda Sedang Menunggu Persetujuan
                    </h2>
                    <p style="color: #6b7280; font-size: 0.95rem; line-height: 1.7; margin-bottom: 28px;">
                        Terima kasih telah mendaftar di <strong>RiskManagement</strong>. Akun Anda telah berhasil dibuat,
                        namun belum memiliki <strong>role/peran</strong> yang diperlukan untuk mengakses sistem.
                    </p>

                    {{-- Info box --}}
                    <div style="
                        background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px;
                        padding: 18px 20px; margin-bottom: 28px; text-align: left;
                    ">
                        <div style="display: flex; align-items: flex-start; gap: 12px;">
                            <i class="fas fa-info-circle" style="color: #d97706; font-size: 1.1rem; margin-top: 2px; flex-shrink: 0;"></i>
                            <div>
                                <div style="font-weight: 700; color: #92400e; font-size: 0.88rem; margin-bottom: 6px;">
                                    Apa yang perlu dilakukan?
                                </div>
                                <ul style="color: #78350f; font-size: 0.85rem; line-height: 1.8; padding-left: 16px; margin: 0;">
                                    <li>Hubungi <strong>Administrator</strong> atau <strong>Super Admin</strong> sistem</li>
                                    <li>Minta agar akun Anda diberikan role yang sesuai</li>
                                    <li>Setelah role ditetapkan, Anda dapat mengakses dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- User info --}}
                    <div style="
                        background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px;
                        padding: 16px 20px; margin-bottom: 28px;
                        display: flex; align-items: center; gap: 14px;
                    ">
                        <div style="
                            width: 44px; height: 44px; border-radius: 50%;
                            background: linear-gradient(135deg, #047857, #10b981);
                            display: flex; align-items: center; justify-content: center;
                            color: #fff; font-weight: 800; font-size: 1.1rem; flex-shrink: 0;
                        ">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div style="text-align: left;">
                            <div style="font-weight: 700; color: #111827; font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                            <div style="color: #6b7280; font-size: 0.82rem;">{{ Auth::user()->email }}</div>
                            <span style="
                                display: inline-block; margin-top: 4px;
                                background: #fef3c7; color: #d97706;
                                font-size: 0.7rem; font-weight: 700; padding: 2px 10px; border-radius: 20px;
                            ">
                                <i class="fas fa-clock" style="margin-right: 4px;"></i> Menunggu Role
                            </span>
                        </div>
                    </div>

                    {{-- Contact info --}}
                    <div style="
                        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
                        border: 1px solid #bbf7d0; border-radius: 12px;
                        padding: 18px 20px; margin-bottom: 28px; text-align: left;
                    ">
                        <div style="font-weight: 700; color: #065f46; font-size: 0.88rem; margin-bottom: 10px;">
                            <i class="fas fa-headset" style="margin-right: 6px;"></i>
                            Hubungi Administrator
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.83rem; color: #047857;">
                                <i class="fas fa-envelope" style="width: 16px; text-align: center;"></i>
                                <span>admin@uinsc.ac.id</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.83rem; color: #047857;">
                                <i class="fas fa-building" style="width: 16px; text-align: center;"></i>
                                <span>Bagian Perencanaan & Manajemen Risiko — UIN Siber Syekh Nurjati Cirebon</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                        <button onclick="window.location.reload()" style="
                            padding: 11px 24px; border-radius: 10px;
                            background: linear-gradient(135deg, #047857, #10b981);
                            color: #fff; font-weight: 700; font-size: 0.88rem;
                            border: none; cursor: pointer;
                            box-shadow: 0 4px 12px rgba(4,120,87,0.3);
                            transition: all 0.2s;
                            display: flex; align-items: center; gap: 8px;
                        " onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fas fa-sync-alt"></i> Cek Status Akun
                        </button>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="
                                padding: 11px 24px; border-radius: 10px;
                                background: #fff; color: #6b7280;
                                font-weight: 600; font-size: 0.88rem;
                                border: 1.5px solid #e5e7eb; cursor: pointer;
                                transition: all 0.2s;
                                display: flex; align-items: center; gap: 8px;
                            " onmouseover="this.style.borderColor='#d1d5db';this.style.color='#374151'" onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Footer note --}}
            <p style="margin-top: 20px; color: #9ca3af; font-size: 0.78rem;">
                Jika sudah lebih dari 24 jam, segera hubungi administrator sistem.
            </p>
        </div>
    </div>

    @push('styles')
    <style>
        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 16px rgba(251,191,36,0.1), 0 0 0 32px rgba(251,191,36,0.05); }
            50% { box-shadow: 0 0 0 20px rgba(251,191,36,0.15), 0 0 0 40px rgba(251,191,36,0.07); }
        }
    </style>
    @endpush
</x-app-layout>
