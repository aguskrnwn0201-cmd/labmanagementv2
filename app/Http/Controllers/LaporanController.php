<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Jadwal;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    /**
     * Helper privat untuk menggabungkan data Booking (Isidentil) & Jadwal (Rutin)
     */
    private function getGabunganPenggunaan($bulan = null, $tahun = null)
    {
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        // 1. Ambil data Booking yang disetujui
        $bookings = Booking::with('lab')
            ->whereMonth('tanggal_booking', $bulan)
            ->whereYear('tanggal_booking', $tahun)
            ->where('status', 'accepted')
            ->get()
            ->map(function ($item) {
                $mulai = Carbon::parse($item->jam_mulai);
                $selesai = Carbon::parse($item->jam_selesai);
                $durasiJam = round($mulai->diffInMinutes($selesai) / 60, 1);

                return [
                    'nama_lab'     => $item->lab->nama_lab ?? 'Tidak Diketahui',
                    'tipe'         => 'Booking Isidentil',
                    'agenda'       => $item->keperluan,
                    'waktu'        => Carbon::parse($item->tanggal_booking)->translatedFormat('d F Y'),
                    'jam'          => $mulai->format('H:i') . ' - ' . $selesai->format('H:i'),
                    'pengguna'     => $item->nama_pemohon,
                    'keterangan'   => 'Kelas ' . $item->kelas,
                    'durasi_jam'   => $durasiJam
                ];
            });

        // 2. Ambil data Jadwal Rutin Mingguan
        $jadwals = Jadwal::with('lab')
            ->get()
            ->flatMap(function ($item) use ($bulan, $tahun) {
                $mulai = Carbon::parse($item->jam_mulai);
                $selesai = Carbon::parse($item->jam_selesai);
                $durasiJam = round($mulai->diffInMinutes($selesai) / 60, 1);

                $listJadwalBulanan = [];
                $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
                
                $hariMap = [
                    'senin' => Carbon::MONDAY, 'selasa' => Carbon::TUESDAY, 'rabu' => Carbon::WEDNESDAY,
                    'kamis' => Carbon::THURSDAY, 'jumat' => Carbon::FRIDAY, 'sabtu' => Carbon::SATURDAY, 'minggu' => Carbon::SUNDAY
                ];
                
                $hariTarget = $hariMap[strtolower($item->hari)] ?? null;

                if ($hariTarget !== null) {
                    for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
                        if ($date->dayOfWeek === $hariTarget) {
                            $listJadwalBulanan[] = [
                                'nama_lab'     => $item->lab->nama_lab ?? 'Tidak Diketahui',
                                'tipe'         => 'Jadwal Rutin',
                                'agenda'       => $item->mata_pelajaran,
                                'waktu'        => $date->translatedFormat('d F Y'),
                                'jam'          => $mulai->format('H:i') . ' - ' . $selesai->format('H:i'),
                                'pengguna'     => $item->guru,
                                'keterangan'   => 'Kelas ' . $item->kelas,
                                'durasi_jam'   => $durasiJam
                            ];
                        }
                    }
                }
                return $listJadwalBulanan;
            });

        return $bookings->merge($jadwals)->sortBy('waktu');
    }

    /**
     * Halaman Utama Rekapitulasi (Bisa diakses publik)
     */
    public function penggunaan(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $semuaAktivitas = $this->getGabunganPenggunaan($bulan, $tahun);

        return view('laporan.penggunaan', compact('semuaAktivitas', 'bulan', 'tahun'));
    }

    /**
     * Preview Halaman HTML untuk Cetak
     */
    public function previewPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $data = $this->getGabunganPenggunaan($bulan, $tahun);
        
        return view('laporan.pdf_penggunaan', compact('data', 'bulan', 'tahun'));
    }

    /**
     * Unduh PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $data = $this->getGabunganPenggunaan($bulan, $tahun);
        
        $pdf = Pdf::loadView('laporan.pdf_penggunaan', compact('data', 'bulan', 'tahun'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->stream('laporan-lab-' . $bulan . '-' . $tahun . '.pdf');
    }

	/**
 * Export Excel Penggunaan Laboratorium
 */
public function exportExcel(Request $request): StreamedResponse
{
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;
    $data  = $this->getGabunganPenggunaan($bulan, $tahun);

    $namaBulan = DateTime::createFromFormat('!m', $bulan)->format('F');
    $filename  = 'laporan-penggunaan-' . $bulan . '-' . $tahun . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    return response()->stream(function () use ($data, $namaBulan, $tahun) {
        $file = fopen('php://output', 'w');

        // BOM untuk Excel agar UTF-8 terbaca
        fputs($file, "\xEF\xBB\xBF");

        // Judul
        fputcsv($file, ['Rekap Penggunaan Laboratorium']);
        fputcsv($file, ['Periode: ' . $namaBulan . ' ' . $tahun]);
        fputcsv($file, ['Dicetak: ' . now()->format('d F Y, H:i')]);
        fputcsv($file, []); // baris kosong

        // ── Jadwal Tetap ──
        fputcsv($file, ['JADWAL TETAP']);
        fputcsv($file, ['Hari', 'Slot Waktu', 'Guru/Pengajar', 'Kelas', 'Mata Pelajaran', 'Durasi (Jam)']);

        foreach (collect($data)->where('tipe', 'Jadwal Rutin') as $item) {
            fputcsv($file, [
                $item['waktu'],
                $item['jam'],
                $item['pengguna'],
                $item['keterangan'],
                $item['agenda'],
                $item['durasi_jam'],
            ]);
        }

        fputcsv($file, []); // baris kosong

        // ── Booking Disetujui ──
        fputcsv($file, ['BOOKING DISETUJUI']);
        fputcsv($file, ['Tanggal', 'Slot Waktu', 'Pengajar', 'Kelas', 'Kegiatan / Mapel', 'Durasi (Jam)']);

        foreach (collect($data)->where('tipe', '!=', 'Jadwal Rutin') as $item) {
            fputcsv($file, [
                $item['waktu'],
                $item['jam'],
                $item['pengguna'],
                $item['keterangan'],
                $item['agenda'],
                $item['durasi_jam'],
            ]);
        }

        fclose($file);
    }, 200, $headers);
}
}