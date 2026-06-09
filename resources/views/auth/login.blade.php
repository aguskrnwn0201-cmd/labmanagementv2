<x-guest-layout>
    <div class="bg-gray-50 min-h-screen flex flex-col font-sans text-gray-900">
        
        <header class="w-full top-0 sticky bg-white border-b border-gray-200 shadow-sm z-50">
            <div class="flex items-center justify-between px-4 md:px-8 py-4 max-w-[1440px] mx-auto">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-blue-600">science</span>
                    <h1 class="text-lg md:text-2xl font-bold text-blue-600">Academic Core Lab Management</h1>
                </div>
            </div>
        </header>

        <main class="flex-grow flex flex-col items-center justify-center px-4 py-10">
            <div class="w-full max-w-[420px] bg-white border border-gray-200 rounded-xl shadow-sm p-8 mb-10">
                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-blue-600 text-3xl">biotech</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-sm text-gray-600">Silakan masuk ke akun Lab Management Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-700" for="email">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-xl"></span>
                            <input class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none transition-all" 
                                   id="username" type="text" name="username" value="{{ old('username') }}" required autofocus />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <div class="space-y-1.5" x-data="{ show: false }">
                        <label class="block text-xs font-semibold text-gray-700" for="password">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-xl"></span>
                            <input class="w-full pl-10 pr-12 py-2.5 rounded-lg border border-gray-300 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none transition-all" 
                                   id="password" :type="show ? 'text' : 'password'" name="password" required placeholder=""/>
                            <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
                                <span class="material-symbols-outlined text-xl" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all shadow-md active:scale-[0.98]">
                        Masuk
                    </button>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>