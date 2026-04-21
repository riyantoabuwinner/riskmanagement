<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-center">
                    <div style="font-size: 4rem; color: #fbbf24; margin-bottom: 20px;">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">Akun Anda Menunggu Approval</h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Maaf, akun Anda saat ini belum memiliki role yang ditetapkan oleh Admin. 
                        Sesuai prosedur keamanan, fitur transaksi dan data risiko hanya dapat diakses setelah role Anda disetujui.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 inline-block text-left">
                        <p class="text-blue-700 font-medium">
                            Silakan hubungi Administrator atau Super Admin untuk aktivasi role Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
