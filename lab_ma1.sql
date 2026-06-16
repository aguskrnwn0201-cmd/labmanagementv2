-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2026 at 03:46 PM
-- Server version: 10.11.14-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab_ma`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lembaga` varchar(255) NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `tipe_pemohon` enum('guru','siswa') NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `jumlah_peserta` int(11) DEFAULT NULL,
  `keperluan` text NOT NULL,
  `status` enum('accepted','cancelled') NOT NULL DEFAULT 'accepted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `lembaga`, `lab_id`, `tipe_pemohon`, `nama_pemohon`, `kelas`, `no_hp`, `tanggal_booking`, `jam_mulai`, `jam_selesai`, `jumlah_peserta`, `keperluan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MA', 1, 'guru', 'agus kurniawan', '12 komunikasi 1', '08232565988', '2026-06-12', '11:00:00', '12:00:00', 23, 'belajr', 'accepted', '2026-06-10 17:52:37', '2026-06-10 17:52:37'),
(2, 'ma', 2, 'guru', 'anissa', '10', '085632352553', '2026-06-12', '08:30:00', '21:30:00', 19, 'pelatihan', 'accepted', '2026-06-12 11:42:05', '2026-06-12 11:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `baik` int(11) NOT NULL DEFAULT 0,
  `rusak` int(11) NOT NULL DEFAULT 0,
  `cadangan` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `nama_barang` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `lab_id`, `baik`, `rusak`, `cadangan`, `total`, `nama_barang`, `keterangan`, `created_at`, `updated_at`) VALUES
(12, 1, 1, 0, 0, 1, 'mikrotik', NULL, '2026-06-12 15:13:06', '2026-06-12 15:13:06'),
(13, 1, 1, 0, 0, 1, 'modem', NULL, '2026-06-12 15:17:23', '2026-06-12 15:17:23'),
(14, 1, 25, 5, 3, 33, 'komputer', NULL, '2026-06-12 15:17:47', '2026-06-12 15:17:47'),
(15, 2, 24, 6, 1, 31, 'komputer', NULL, '2026-06-12 15:18:09', '2026-06-12 15:18:09'),
(16, 1, 35, 5, 0, 40, 'kursi', NULL, '2026-06-12 15:41:38', '2026-06-12 15:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL,
  `guru` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `lembaga` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id`, `lab_id`, `hari`, `jam_mulai`, `jam_selesai`, `mata_pelajaran`, `guru`, `kelas`, `semester`, `lembaga`, `created_at`, `updated_at`) VALUES
(4, 2, 'Senin', '10:30:00', '11:30:00', 'TIK', 'husnul', '9', 'Ganjil', 'mts', '2026-06-12 11:20:13', '2026-06-12 11:20:13'),
(5, 1, 'Senin', '10:30:00', '11:30:00', 'TIK', 'FAIQ', '11', 'Ganjil', 'MA', '2026-06-12 11:21:04', '2026-06-12 11:21:04'),
(6, 1, 'Senin', '11:30:00', '12:30:00', 'TIK', 'AHMAD', '12', 'Ganjil', 'MA', '2026-06-12 11:22:09', '2026-06-12 11:22:09'),
(7, 1, 'Selasa', '08:00:00', '09:00:00', 'TIK', 'FAIQ', '8', 'Ganjil', 'mts', '2026-06-12 11:25:03', '2026-06-12 11:25:03'),
(8, 1, 'Selasa', '09:00:00', '10:00:00', 'TIK', 'FAIQ', '11', 'Ganjil', 'MA', '2026-06-12 11:25:55', '2026-06-12 11:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `jam_pelajaran`
--

CREATE TABLE `jam_pelajaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_slot` varchar(255) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `is_istirahat` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jam_pelajaran`
--

INSERT INTO `jam_pelajaran` (`id`, `nama_slot`, `waktu_mulai`, `waktu_selesai`, `is_istirahat`, `created_at`, `updated_at`) VALUES
(1, 'Jam 1', '08:00:00', '08:30:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(2, 'Jam 2', '08:30:00', '09:00:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(3, 'Jam 3', '09:00:00', '09:30:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(4, 'Jam 4', '09:30:00', '10:00:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(5, 'Istirahat', '10:00:00', '10:30:00', 1, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(6, 'Jam 5', '10:30:00', '11:00:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(7, 'Jam 6', '11:00:00', '11:30:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(8, 'Jam 7', '11:30:00', '12:00:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(9, 'Jam 8', '12:00:00', '12:30:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07'),
(10, 'Jam 9', '12:30:00', '13:00:00', 0, '2026-06-10 17:05:07', '2026-06-10 17:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lab` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 0,
  `komputer_ready` int(11) NOT NULL DEFAULT 0,
  `jumlah_komputer` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','maintenance','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `nama_lab`, `lokasi`, `kapasitas`, `komputer_ready`, `jumlah_komputer`, `deskripsi`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lab Komputer 1', 'gedung MA', 30, 0, 0, NULL, NULL, 'aktif', '2026-06-10 17:50:15', '2026-06-10 17:50:15'),
(2, 'Lab Komputer 2', 'gedung MA', 25, 0, 0, NULL, NULL, 'aktif', '2026-06-10 17:50:36', '2026-06-10 17:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kerusakans`
--

CREATE TABLE `laporan_kerusakans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `role_pelapor` enum('guru','siswa','teknisi') NOT NULL,
  `jenis_kerusakan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('pending','diproses','selesai') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `inventaris_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah_rusak` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_kerusakans`
--

INSERT INTO `laporan_kerusakans` (`id`, `lab_id`, `nama_pelapor`, `no_hp`, `role_pelapor`, `jenis_kerusakan`, `deskripsi`, `status`, `created_at`, `updated_at`, `inventaris_id`, `jumlah_rusak`) VALUES
(1, 1, 'robi', '082546546262', 'guru', 'ac mati', 'panas', 'selesai', '2026-06-12 11:42:54', '2026-06-12 15:35:45', NULL, 1),
(2, 1, 'Teknisi', '6282332671812', 'teknisi', 'Kerusakan Aset Awal: kursi', 'Data otomatis terbuat saat input inventaris baru dengan kondisi rusak.', 'diproses', '2026-06-12 15:41:38', '2026-06-12 15:41:38', 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_06_02_110128_create_labs_table', 1),
(6, '2026_06_02_110129_create_jadwals_table', 1),
(7, '2026_06_02_110130_create_bookings_table', 1),
(8, '2026_06_02_121950_add_fields_to_labs_table', 1),
(9, '2026_06_02_122658_alter_jadwals_table', 1),
(10, '2026_06_04_154716_create_laporan_kerusakans_table', 1),
(11, '2026_06_04_162349_update_role_pelapor_enum', 1),
(12, '2026_06_06_131013_add_no_hp_to_laporan_kerusakans_table', 1),
(13, '2026_06_07_100604_create_inventaris_table', 1),
(14, '2026_06_08_155642_add_role_to_users_table', 1),
(15, '2026_06_09_041147_add_username_to_users_table', 1),
(16, '2026_06_09_154945_add_lembaga_to_bookings_table', 1),
(17, '2026_06_10_082212_create_jam_pelajaran_table', 1),
(18, '2026_06_10_173551_create_sessions_table', 2),
(19, '2026_06_09_153357_update_jadwals_table', 99),
(20, '2026_06_12_145832_add_kondisi_fields_to_inventaris_table', 100),
(21, '2026_06_12_150819_clean_old_fields_from_inventaris_table', 101),
(22, '2026_06_12_152212_add_inventaris_id_to_laporan_kerusakans_table', 102),
(23, '2026_06_12_154630_add_komputer_ready_to_labs_table', 103);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('uwkgeuTOlu5YFm9zYz4n9Z4j2M8Guo5KsSbglw8S', 5, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:151.0) Gecko/20100101 Firefox/151.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidkVTcnI1QklsdVJubzdYaFVDZXQ0ajNJVm5uckh3VHhWVlpURE00UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ndXJ1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czo0OiJyb2xlIjtzOjQ6Imd1cnUiO30=', 1781283367);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'teknisi',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', 'admin@lab.com', NULL, '$2y$12$4t6flDwObbOVxw9WFhQrK.OUg4OOa.D2vDqcv9o9K21JjGe.lbKzi', 'admin', NULL, '2026-06-10 17:05:07', '2026-06-11 13:01:50'),
(3, 'teknisi@lab.com', 'Teknisi', 'teknisi@lab.com@lab.local', NULL, '$2y$12$jH1qmzwbuupBZ5w8zWJ2rOlpaj0BczE/vVHBtpfxA6yG45nmkcHs2', 'teknisi', NULL, '2026-06-10 17:53:33', '2026-06-10 17:53:33'),
(5, 'teknisi', 'Teknisi', 'teknisi@lab.local', NULL, '$2y$12$vy0dE..tiUUU6I.uHvYYpOuGUBcqT.cwMk2P1Be1M6AsyIc/tqrPC', 'teknisi', NULL, '2026-06-11 16:31:17', '2026-06-11 16:31:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_lab_id_foreign` (`lab_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventaris_lab_id_foreign` (`lab_id`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwals_lab_id_foreign` (`lab_id`);

--
-- Indexes for table `jam_pelajaran`
--
ALTER TABLE `jam_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_kerusakans`
--
ALTER TABLE `laporan_kerusakans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_kerusakans_lab_id_foreign` (`lab_id`),
  ADD KEY `laporan_kerusakans_inventaris_id_foreign` (`inventaris_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jam_pelajaran`
--
ALTER TABLE `jam_pelajaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan_kerusakans`
--
ALTER TABLE `laporan_kerusakans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
