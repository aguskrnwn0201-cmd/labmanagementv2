<x-guest-layout>
    <div class="absolute inset-0 lab-pattern -z-10"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary opacity-5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary opacity-5 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[400px] z-10 mx-auto my-gutter">
        
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="bg-white border border-outline-variant rounded-lg shadow-sm p-6 md:p-8">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-container rounded-full mb-4">
                    <span class="material-symbols-outlined text-on-primary-container !text-3xl">biotech</span>
                </div>
                <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface mb-2">Selamat Datang</h1>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Silakan masuk ke akun Lab Management Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-label-sm text-label-sm text-on-surface mb-1.5" for="email">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">mail</span>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username" 
                               placeholder="nama@institusi.ac.id"
                               class="w-full pl-10 pr-4 py-2.5 bg-white border border-outline rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none text-body-md" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-error" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block font-label-sm text-label-sm text-on-surface" for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a class="font-label-sm text-label-sm text-primary hover:underline transition-all" href="{{ route('password.request') }}">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">lock</span>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password" 
                               placeholder="••••••••"
                               class="w-full pl-10 pr-12 py-2.5 bg-white border border-outline rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none text-body-md" />
                        
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface-variant transition-colors p-1 flex items-center justify-center">
                            <span class="material-symbols-outlined" id="passwordIcon">visibility</span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-error" />
                </div>

                <div class="flex items-center">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember" 
                           class="w-4 h-4 text-primary border-outline rounded focus:ring-primary transition-all" />
                    <label for="remember_me" class="ml-2 font-body-sm text-body-sm text-on-surface-variant cursor-pointer">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <button type="submit" class="w-full bg-primary text-on-primary font-headline-sm text-headline-sm py-3 rounded-lg hover:bg-opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-sm font-semibold">
                    <span>Masuk</span>
                    <span class="material-symbols-outlined">login</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-outline-variant text-center">
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Belum memiliki akses? <br/>
                    <a class="text-primary font-semibold hover:underline" href="#">Hubungi Administrator Lab</a>
                </p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="bg-surface-container-high rounded-lg p-4 flex flex-col items-center justify-center text-center border border-outline-variant/40">
                <span class="material-symbols-outlined text-primary mb-2">verified_user</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">Secure Access</span>
            </div>
            <div class="bg-surface-container-high rounded-lg p-4 flex flex-col items-center justify-center text-center border border-outline-variant/40">
                <span class="material-symbols-outlined text-primary mb-2">database</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">Real-time Sync</span>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.innerText = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                passwordIcon.innerText = 'visibility';
            }
        }
    </script>
</x-guest-layout>