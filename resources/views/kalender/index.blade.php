@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<div class="max-w-[1440px] mx-auto px-4 md:px-8 py-6" 
     x-data="calendarComponent()">
    
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-600">Kalender Lab</h1>
        <p class="text-sm text-gray-500">Jadwal dan booking laboratorium secara real-time</p>
    </div>

    <section class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
        <div class="flex items-center justify-between mb-6 px-2">
            <button @click="prev()" class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer select-none border-0 bg-transparent">
                <span class="material-symbols-outlined align-middle">chevron_left</span>
            </button>
            <div class="text-center">
                <h2 class="text-lg md:text-xl font-bold text-gray-800" x-text="monthYearLabel"></h2>
                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-0.5" 
                   x-text="viewMode === 'weekly' ? 'Tampilan Mingguan' : 'Tampilan Bulanan'"></p>
            </div>
            <button @click="next()" class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer select-none border-0 bg-transparent">
                <span class="material-symbols-outlined align-middle">chevron_right</span>
            </button>
        </div>

        <div class="grid grid-cols-7 gap-1 text-center border-b border-gray-100 pb-2 mb-2">
            <template x-for="day in daysOfWeek">
                <div class="text-xs font-bold text-gray-500 py-1" x-text="day"></div>
            </template>
        </div>
        
        <div class="grid grid-cols-7 gap-1 text-center min-h-[120px]">
            <template x-if="viewMode === 'weekly'">
                <template x-for="item in currentWeekArray">
                    <div @click="selectDate(item.dateStr)"
                         :class="{
                            'bg-blue-600 text-white font-bold rounded-xl shadow-sm': isSelected(item.dateStr),
                            'hover:bg-gray-100 rounded-xl cursor-pointer': !isSelected(item.dateStr)
                         }"
                         class="py-3 flex flex-col items-center justify-center gap-1 transition-all select-none relative">
                        <span class="text-sm md:text-base" x-text="item.day"></span>
                        
                        <div class="flex gap-0.5 items-center justify-center h-1.5">
                            <div :class="isToday(item.dateStr) ? (isSelected(item.dateStr) ? 'bg-white' : 'bg-blue-600') : 'bg-transparent'" class="w-1.5 h-1.5 rounded-full"></div>
                            <template x-if="hasActivity(item.dateStr)">
                                <div :class="isSelected(item.dateStr) ? 'bg-white' : 'bg-amber-500'" class="w-1.5 h-1.5 rounded-full shadow-sm animate-pulse"></div>
                            </template>
                        </div>
                    </div>
                </template>
            </template>

            <template x-if="viewMode === 'monthly'">
                <template x-for="item in daysInMonthArray">
                    <div @click="selectDate(item.dateStr)"
                         :class="{
                            'bg-blue-600 text-white font-bold rounded-xl shadow-sm': isSelected(item.dateStr) && !item.disabled,
                            'hover:bg-gray-100 rounded-xl cursor-pointer': !isSelected(item.dateStr) && !item.disabled,
                            'opacity-20 pointer-events-none': item.disabled
                         }"
                         class="py-2 flex flex-col items-center justify-center gap-0.5 transition-all select-none relative">
                        <span class="text-sm md:text-base" x-text="item.day"></span>
                        
                        <div class="flex gap-0.5 items-center justify-center h-1.5">
                            <div :class="isToday(item.dateStr) ? (isSelected(item.dateStr) ? 'bg-white' : 'bg-blue-600') : 'bg-transparent'" class="w-1.5 h-1.5 rounded-full"></div>
                            <template x-if="hasActivity(item.dateStr) && !item.disabled">
                                <div :class="isSelected(item.dateStr) ? 'bg-white' : 'bg-amber-500'" class="w-1.5 h-1.5 rounded-full shadow-sm animate-pulse"></div>
                            </template>
                        </div>
                    </div>
                </template>
            </template>
        </div>

        <div class="mt-6 flex justify-center gap-3">
            <button @click="viewMode = 'weekly'" :class="viewMode === 'weekly' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-5 py-1.5 text-xs font-bold rounded-lg transition-all cursor-pointer border-0">Mingguan</button>
            <button @click="viewMode = 'monthly'" :class="viewMode === 'monthly' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-5 py-1.5 text-xs font-bold rounded-lg transition-all cursor-pointer border-0">Bulanan</button>
        </div>
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h3 class="text-base md:text-lg font-bold text-gray-800">Daftar Aktivitas Laboratorium</h3>
                <p class="text-xs text-gray-500 mt-0.5">Menampilkan agenda untuk hari <span class="font-bold text-blue-600" x-text="selectedDayName + ', ' + selectedDateReadable"></span></p>
            </div>
            <button @click="resetToToday()" class="text-xs text-blue-600 font-bold hover:underline bg-transparent border-0 cursor-pointer">Hari Ini</button>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @php $hasData = !$jadwals->isEmpty() || !$bookings->isEmpty(); @endphp

            @if($hasData)
                {{-- LOOP DATA JADWAL UTAMA --}}
                @foreach($jadwals as $jadwal)
                    <div x-show="shouldShowActivity('jadwal', '{{ $jadwal->hari }}')"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm flex items-start gap-4 hover:border-blue-500 transition-colors duration-200">
                        <div class="bg-blue-50 text-blue-600 p-3 rounded-lg flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">computer</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ $jadwal->lab->nama_lab ?? 'Lab' }}</h4>
                                <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0 border border-blue-200">Jadwal Rutin</span>
                            </div>
                            <p class="text-xs md:text-sm text-gray-600 mb-3 font-medium">{{ $jadwal->mata_pelajaran }}</p>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-400">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <span>Setiap Hari {{ $jadwal->hari }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <span>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- LOOP DATA BOOKING --}}
                @foreach($bookings as $booking)
                    @php $bookingDateFormated = \Carbon\Carbon::parse($booking->tanggal_booking)->format('Y-m-d'); @endphp
                    <div x-show="shouldShowActivity('booking', '{{ $bookingDateFormated }}')"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm flex items-start gap-4 hover:border-purple-300 transition-colors duration-200">
                        <div class="bg-purple-50 text-purple-700 p-3 rounded-lg flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">science</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ $booking->lab->nama_lab ?? 'Lab' }}</h4>
                                <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0 border border-purple-200">Booking User</span>
                            </div>
                            <p class="text-xs md:text-sm text-gray-600 mb-3 font-medium">Booking - {{ $booking->nama_pemohon ?? $booking->nama_peminjam ?? 'User' }}</p>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-400">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <span>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <span>{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div id="empty-state-card" class="py-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 hidden">
                <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">event_available</span>
                <p class="text-xs text-gray-500 italic">Tidak ada jadwal rutin ataupun booking terdaftar untuk hari ini.</p>
            </div>
        </div>
    </section>

    @if(session('role') == 'teknisi' || session('role') == 'guru')
        <a href="{{ route('booking.index') }}" class="fixed bottom-6 right-6 w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-blue-700 active:scale-95 transition-all z-20 decoration-none">
            <span class="material-symbols-outlined text-3xl">add</span>
        </a>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function calendarComponent() {
        return {
            viewMode: 'weekly', 
            currentDate: new Date(),
            selectedDateStr: new Date().toISOString().split('T')[0],
            daysOfWeek: ['MG', 'SN', 'SL', 'RB', 'KM', 'JM', 'SB'],
            months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            namaHari: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            activeDates: @json($activeDates ?? []),

            get monthYearLabel() {
                return this.months[this.currentDate.getMonth()] + ' ' + this.currentDate.getFullYear();
            },
            hasActivity(dateStr) {
                return this.activeDates.includes(dateStr);
            },
            get selectedDayName() {
                let d = new Date(this.selectedDateStr);
                return this.namaHari[d.getDay()];
            },
            get selectedDateReadable() {
                let d = new Date(this.selectedDateStr);
                return String(d.getDate()).padStart(2, '0') + ' ' + this.months[d.getMonth()] + ' ' + d.getFullYear();
            },
            get daysInMonthArray() {
                let year = this.currentDate.getFullYear();
                let month = this.currentDate.getMonth();
                let firstDay = new Date(year, month, 1).getDay();
                let numDays = new Date(year, month + 1, 0).getDate();
                
                let arr = [];
                for (let i = 0; i < firstDay; i++) {
                    arr.push({ day: '', dateStr: '', disabled: true });
                }
                for (let i = 1; i <= numDays; i++) {
                    arr.push({ 
                        day: i, 
                        dateStr: `${year}-${String(month+1).padStart(2, '0')}-${String(i).padStart(2, '0')}`,
                        disabled: false 
                    });
                }
                return arr;
            },
            get currentWeekArray() {
                let arr = [];
                let current = new Date(this.currentDate);
                let dayPosition = current.getDay();
                let startOfWeek = new Date(current.setDate(current.getDate() - dayPosition));

                for (let i = 0; i < 7; i++) {
                    let d = new Date(startOfWeek);
                    d.setDate(startOfWeek.getDate() + i);
                    arr.push({
                        day: d.getDate(),
                        dateStr: `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`,
                        disabled: false
                    });
                }
                return arr;
            },
            prev() {
                if (this.viewMode === 'monthly') {
                    this.currentDate = new Date(this.currentDate.setMonth(this.currentDate.getMonth() - 1));
                } else {
                    this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() - 7));
                }
                this.currentDate = new Date(this.currentDate);
            },
            next() {
                if (this.viewMode === 'monthly') {
                    this.currentDate = new Date(this.currentDate.setMonth(this.currentDate.getMonth() + 1));
                } else {
                    this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() + 7));
                }
                this.currentDate = new Date(this.currentDate);
            },
            isToday(dateStr) {
                let today = new Date();
                let check = `${today.getFullYear()}-${String(today.getMonth()+1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
                return dateStr === check;
            },
            isSelected(dateStr) {
                return dateStr === this.selectedDateStr;
            },
            selectDate(dateStr) {
                if(!dateStr) return;
                this.selectedDateStr = dateStr;
            },
            resetToToday() {
                this.selectedDateStr = new Date().toISOString().split('T')[0];
                this.currentDate = new Date();
            },
            shouldShowActivity(type, dayOrDate) {
                if (type === 'jadwal') {
                    return dayOrDate.toLowerCase() === this.selectedDayName.toLowerCase();
                } else if (type === 'booking') {
                    return dayOrDate === this.selectedDateStr;
                }
                return false;
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.effect(() => {
            setTimeout(() => {
                const items = document.querySelectorAll('.grid-cols-1 > div:not(#empty-state-card)');
                let visibleCount = 0;
                items.forEach(el => {
                    if (el.style.display !== 'none') visibleCount++;
                });
                
                const emptyState = document.getElementById('empty-state-card');
                if (emptyState) {
                    if (visibleCount === 0) {
                        emptyState.classList.remove('hidden');
                    } else {
                        emptyState.classList.add('hidden');
                    }
                }
            }, 50);
        });
    });
</script>
@endsection