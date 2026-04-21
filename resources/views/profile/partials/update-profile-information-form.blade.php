<section>
    <header class="mb-4">
        <p class="text-sm text-muted">
            {{ __("Perbarui informasi profil akun dan alamat email Anda untuk tetap akurat.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="form-group mb-4">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-weight-600 mb-2" />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-signature text-muted"></i></span>
                </div>
                <x-text-input id="name" name="name" type="text" class="form-control border-left-0 pl-0" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="form-group mb-4">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-weight-600 mb-2" />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                </div>
                <x-text-input id="email" name="email" type="email" class="form-control border-left-0 pl-0" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-warning">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ __('Email Anda belum diverifikasi.') }}
                        <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline text-info font-weight-bold">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-warning rounded-pill px-4 font-weight-bold shadow-sm">
                <i class="fas fa-save mr-1"></i> {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success font-weight-bold"
                ><i class="fas fa-check-circle mr-1"></i> {{ __('Berhasil disimpan.') }}</span>
            @endif
        </div>
    </form>
</section>
