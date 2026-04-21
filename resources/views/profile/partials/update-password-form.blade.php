<section>
    <header class="mb-4">
        <p class="text-sm text-muted">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="form-group mb-4">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-weight-600 mb-2" />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-lock text-muted"></i></span>
                </div>
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control border-left-0 pl-0" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="form-group mb-4">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-weight-600 mb-2" />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-key text-muted"></i></span>
                </div>
                <x-text-input id="update_password_password" name="password" type="password" class="form-control border-left-0 pl-0" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="form-group mb-4">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-weight-600 mb-2" />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-check-shield text-muted"></i></span>
                </div>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control border-left-0 pl-0" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-warning rounded-pill px-4 font-weight-bold shadow-sm">
                <i class="fas fa-shield-alt mr-1"></i> {{ __('Perbarui Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success font-weight-bold"
                ><i class="fas fa-check-circle mr-1"></i> {{ __('Berhasil diperbarui.') }}</span>
            @endif
        </div>
    </form>
</section>
