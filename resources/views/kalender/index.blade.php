@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<div class="w-full relative p-4 md:p-6" x-data="calendarComponent()">
    
    <div class="mb-8">
        <h1 class="font-headline-sm text-headline-sm md:font-headline-lg md:text-headline-lg font-bold text-primary dark:text-primary-fixed-dim mb-1">
            Kalender Lab
        </h1>
        <p class="font-body-md text-on-surface-variant">
            Jadwal dan booking laboratorium secara real-time
        </p>
    </div>

    {{-- KALENDER --}}
    <section class="bg-surface-container-lowest rounded-lg border border-outline-variant shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-6 px-2">
            <button @click="prev()" class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer select-none border-0 bg-transparent">
                <span class="material-symbols-outlined align-middle">chevron_left</span>
            </button>
            <div class="text-center">
                <h2 class="text-lg md:text-xl font-bold text-on-surface" x-text="monthYearLabel"></h2>
                <p class="text-[10px] font-bold text-primary uppercase tracking-widest mt-0.5" 
                   x-text="viewMode === 'weekly' ? 'Tampilan Mingguan' : 'Tampilan Bulanan'"></p>
            </div>
            <button @click="next()" class="p-2 hover:bg-gray-100 rounded-full transition-colors cursor-pointer select-none border-0 bg-transparent">
                <span class="material-symbols-outlined align-middle">chevron_right</span>
            </button>
        </div>

        <div class="grid grid-cols-7 gap-1 text-center border-b border-outline-variant pb-2 mb-2">
            <template x-for="day in daysOfWeek">
                <div class="text-xs font-bold text-on-surface-variant py-1" x-text="day"></div>
            </template>
        </div>
        
        <div class="grid grid-cols-7 gap-1 text-center min-h-[120px]">
            <template x-if="viewMode === 'weekly'">
                <template x-for="item in currentWeekArray">
                    <div @click="selectDate(item.dateStr)"
                         :class="{
                            'bg-primary text-white font-bold rounded-lg shadow-sm': isSelected(item.dateStr),
                            'hover:bg-gray-100 rounded-lg cursor-pointer': !isSelected(item.dateStr)
                         }"
                         class="py-3 flex flex-col items-center justify-center gap-1 transition-all select-none relative">
                        <span class="text-sm md:text-base" x-text="item.day"></span>
                        <div class="flex gap-0.5 items-center justify-center h-1.5">
                            <div :class="isToday(item.dateStr) ? (isSelected(item.dateStr) ? 'bg-white' : 'bg-primary') : 'bg-transparent'" class="w-1.5 h-1.5 rounded-full"></div>
                            <template x-if="hasActivity(item.dateStr)">
                                <div :class="isSelected(item.dateStr) ? 'bg-white' : 'bg-amber-500'" class="w-1.5 h-1.5 rounded-full shadow-sm"></div>
                            </template>
                        </div>
                    </div>
                </template>
            </template>

            <template x-if="viewMode === 'monthly'">
                <template x-for="item in daysInMonthArray">
                    <div @click="selectDate(item.dateStr)"
                         :class="{
                            'bg-primary text-white font-bold rounded-lg shadow-sm': isSelected(item.dateStr) && !item.disabled,
                            'hover:bg-gray-100 rounded-lg cursor-pointer': !isSelected(item.dateStr) && !item.disabled,
                            'opacity-20 pointer-events-none': item.disabled
                         }"
                         class="py-2 flex flex-col items-center justify-center gap-0.5 transition-all select-none relative">
                        <span class="text-sm md:text-base" x-text="item.day"></span>
                        <div class="flex gap-0.5 items-center justify-center h-1.5">
                            <div :class="isToday(item.dateStr) ? (isSelected(item.dateStr) ? 'bg-white' : 'bg-primary') : 'bg-transparent'" class="w-1.5 h-1.5 rounded-full"></div>
                            <template x-if="hasActivity(item.dateStr) && !item.disabled">
                                <div :class="isSelected(item.dateStr) ? 'bg-white' : 'bg-amber-500'" class="w-1.5 h-1.5 rounded-full shadow-sm"></div>
                            </template>
                        </div>
                    </div>
                </template>
            </template>
        </div>

        <div class="mt-6 flex justify-center gap-3">
            <button @click="viewMode = 'weekly'" :class="viewMode === 'weekly' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600'" class="px-5 py-1.5 text-xs font-bold rounded-lg transition-all cursor-pointer border-0">Mingguan</button>
            <button @click="viewMode = 'monthly'" :class="viewMode === 'monthly' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600'" class="px-5 py-1.5 text-xs font-bold rounded-lg transition-all cursor-pointer border-0">Bulanan</button>
        </div>
    </section>

    {{-- DAFTAR AKTIVITAS --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h4 class="font-headline-sm text-headline-sm text-on-surface">Daftar Aktivitas Laboratorium</h4>
                <p class="text-xs text-on-surface-variant mt-0.5">Menampilkan agenda untuk hari <span class="font-bold text-primary" x-text="selectedDayName + ', ' + selectedDateReadable"></span></p>
            </div>
            <button @click="resetToToday()" class="text-xs text-primary font-bold hover:underline bg-transparent border-0 cursor-pointer">Hari Ini</button>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @php $hasData = !$jadwals->isEmpty() || !$bookings->isEmpty(); @endphp

            @if($hasData)
                {{-- JADWAL RUTIN --}}
                @foreach($jadwals as $jadwal)
                <div x-show="shouldShowActivity('jadwal', '{{ $jadwal->hari }}')"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     @click="openModal('jadwal', {{ json_encode([
                        'id'            => $jadwal->id,
                        'lab'           => $jadwal->lab->nama_lab ?? '-',
                        'hari'          => $jadwal->hari,
                        'jam_mulai'     => substr($jadwal->jam_mulai, 0, 5),
                        'jam_selesai'   => substr($jadwal->jam_selesai, 0, 5),
                        'mata_pelajaran'=> $jadwal->mata_pelajaran,
                        'guru'          => $jadwal->guru,
                        'no_hp'         => $jadwal->no_hp ?? '-',
                        'kelas'         => $jadwal->kelas,
                        'semester'      => $jadwal->semester ?? '-',
                        'lembaga'       => $jadwal->lembaga ?? '-',
                     ]) }})"
                     class="bg-white p-5 rounded-lg border border-outline-variant shadow-sm hover:border-primary hover:shadow-md transition-all flex items-start gap-4 cursor-pointer">
                    <div class="bg-primary/10 text-primary p-3 rounded-lg flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">computer</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h4 class="text-sm font-bold text-on-surface truncate">{{ $jadwal->lab->nama_lab ?? 'Lab' }}</h4>
                            <span class="bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0 border border-blue-200">Jadwal Rutin</span>
                        </div>
                        <p class="text-xs md:text-sm text-on-surface-variant mb-3 font-medium">{{ $jadwal->mata_pelajaran }}</p>
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
                    <div class="shrink-0 text-gray-300 self-center">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </div>
                @endforeach

                {{-- BOOKING USER --}}
                @foreach($bookings as $booking)
                @php $bookingDateFormated = \Carbon\Carbon::parse($booking->tanggal_booking)->format('Y-m-d'); @endphp
                <div x-show="shouldShowActivity('booking', '{{ $bookingDateFormated }}')"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     @click="openModal('booking', {{ json_encode([
                        'id'             => $booking->id,
                        'lab'            => $booking->lab->nama_lab ?? '-',
                        'tipe_pemohon'   => $booking->tipe_pemohon,
                        'nama_pemohon'   => $booking->nama_pemohon,
                        'kelas'          => $booking->kelas ?? '-',
                        'no_hp'          => $booking->no_hp,
                        'tanggal'        => \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d F Y'),
                        'jam_mulai'      => substr($booking->jam_mulai, 0, 5),
                        'jam_selesai'    => substr($booking->jam_selesai, 0, 5),
                        'jumlah_peserta' => $booking->jumlah_peserta ?? '-',
                        'keperluan'      => $booking->keperluan,
                        'status'         => $booking->status,
                     ]) }})"
                     class="bg-white p-5 rounded-lg border border-outline-variant shadow-sm hover:border-purple-400 hover:shadow-md transition-all flex items-start gap-4 cursor-pointer">
                    <div class="bg-purple-50 text-purple-700 p-3 rounded-lg flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">science</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h4 class="text-sm font-bold text-on-surface truncate">{{ $booking->lab->nama_lab ?? 'Lab' }}</h4>
                            <span class="bg-purple-50 text-purple-700 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0 border border-purple-200">Booking User</span>
                        </div>
                        <p class="text-xs md:text-sm text-on-surface-variant mb-3 font-medium">{{ $booking->nama_pemohon }}</p>
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
                    <div class="shrink-0 text-gray-300 self-center">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </div>
                @endforeach
            @endif

            <div id="empty-state-card" class="py-12 text-center bg-surface-container-lowest rounded-lg border border-dashed border-outline-variant hidden">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">event_available</span>
                <p class="text-xs text-on-surface-variant italic">Tidak ada jadwal rutin ataupun booking terdaftar untuk hari ini.</p>
            </div>
        </div>
    </section>

    <div class="pb-16"></div>

    {{-- FAB --}}
    @if(Auth::check())
        <a href="{{ route('booking.index') }}" class="fixed bottom-6 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-blue-700 active:scale-95 transition-all z-20 no-underline">
            <span class="material-symbols-outlined text-3xl text-white">add</span>
        </a>
    @endif

    {{-- ============================================================ --}}
    {{-- MODAL DETAIL                                                  --}}
    {{-- ============================================================ --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="closeModal()"
         class="fixed inset-0 bg-black/50 z-50 flex items-end md:items-center justify-center p-0 md:p-4"
         style="display:none;">

        <div x-show="modalOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-8 md:translate-y-0 md:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 md:scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 md:scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 md:translate-y-0 md:scale-95"
             class="bg-white rounded-t-2xl md:rounded-2xl w-full md:max-w-md shadow-2xl overflow-hidden">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-outline-variant">
                <div class="flex items-center gap-3">
                    <div :class="modalType === 'booking' ? 'bg-purple-50 text-purple-700' : 'bg-primary/10 text-primary'"
                         class="p-2.5 rounded-lg">
                        <span class="material-symbols-outlined text-xl"
                              x-text="modalType === 'booking' ? 'science' : 'computer'"></span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest"
                           :class="modalType === 'booking' ? 'text-purple-600' : 'text-primary'"
                           x-text="modalType === 'booking' ? 'Detail Booking' : 'Detail Jadwal Rutin'"></p>
                        <h3 class="text-sm font-bold text-on-surface" x-text="modalData.lab"></h3>
                    </div>
                </div>
                <button @click="closeModal()" class="p-1.5 hover:bg-gray-100 rounded-full border-0 bg-transparent cursor-pointer">
                    <span class="material-symbols-outlined text-on-surface-variant">close</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-5 py-4 space-y-3 max-h-[70vh] overflow-y-auto">

                {{-- BOOKING FIELDS --}}
                <template x-if="modalType === 'booking'">
                    <div class="space-y-3">
                        {{-- Status badge --}}
                        <div class="flex justify-center mb-1">
                            <span :class="modalData.status === 'accepted' 
                                    ? 'bg-green-50 text-green-700 border-green-200' 
                                    : 'bg-red-50 text-red-600 border-red-200'"
                                  class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider border"
                                  x-text="modalData.status === 'accepted' ? '✓ Diterima' : '✗ Dibatalkan'">
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Nama Pemohon</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.nama_pemohon"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Tipe</p>
                                <p class="text-sm font-semibold text-on-surface capitalize" x-text="modalData.tipe_pemohon"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Kelas</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.kelas"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">No. HP</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.no_hp"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Tanggal</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.tanggal"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Waktu</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.jam_mulai + ' – ' + modalData.jam_selesai"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Jumlah Peserta</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.jumlah_peserta + ' orang'"></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Keperluan</p>
                            <p class="text-sm text-on-surface leading-relaxed" x-text="modalData.keperluan"></p>
                        </div>
                    </div>
                </template>

                {{-- JADWAL FIELDS --}}
                <template x-if="modalType === 'jadwal'">
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Guru</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.guru"></p>
                            </div>
                			<div class="bg-gray-50 rounded-xl p-3">
    							<p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">No. HP Guru</p>
    							<p class="text-sm font-semibold text-on-surface" x-text="modalData.no_hp"></p>
							</div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Mata Pelajaran</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.mata_pelajaran"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Kelas</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.kelas"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Hari</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="'Setiap ' + modalData.hari"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Waktu</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.jam_mulai + ' – ' + modalData.jam_selesai"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Semester</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.semester"></p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Lembaga</p>
                                <p class="text-sm font-semibold text-on-surface" x-text="modalData.lembaga"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Modal Footer --}}
            <div class="px-5 py-4 border-t border-outline-variant">
                <button @click="closeModal()" 
                        class="w-full py-2.5 rounded-xl bg-gray-100 text-on-surface text-sm font-bold hover:bg-gray-200 transition-colors border-0 cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function calendarComponent() {
        return {
            // === STATE KALENDER ===
            viewMode: 'weekly', 
            currentDate: new Date(),
            selectedDateStr: new Date().toISOString().split('T')[0],
            daysOfWeek: ['MG', 'SN', 'SL', 'RB', 'KM', 'JM', 'SB'],
            months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            namaHari: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            activeDates: @json($activeDates ?? []),

            // === STATE MODAL ===
            modalOpen: false,
            modalType: null,   // 'booking' | 'jadwal'
            modalData: {},

            // === MODAL METHODS ===
            openModal(type, data) {
                this.modalType = type;
                this.modalData = data;
                this.modalOpen = true;
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.modalOpen = false;
                this.modalType = null;
                this.modalData = {};
                document.body.style.overflow = '';
            },

            // === KALENDER GETTERS ===
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