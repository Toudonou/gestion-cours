-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2023 at 04:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_cours`
--

-- --------------------------------------------------------

--
-- Table structure for table `cours_locals`
--

CREATE TABLE `cours_locals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `masseHoraire` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `filiere` varchar(255) NOT NULL,
  `ue_id` bigint(20) UNSIGNED NOT NULL,
  `enseignant_local_id` bigint(20) UNSIGNED NOT NULL,
  `directeur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cours_locals`
--

INSERT INTO `cours_locals` (`id`, `intitule`, `masseHoraire`, `semestre`, `filiere`, `ue_id`, `enseignant_local_id`, `directeur_id`, `created_at`, `updated_at`) VALUES
(3, 'vcvcv', 6456, 5, 'Mathématiques', 2, 8, 1, '2023-06-21 07:11:05', '2023-06-21 07:11:05'),
(5, '1azaz', 444581, 445, 'Informatique', 1, 4, 1, '2023-06-20 08:46:08', '2023-06-20 09:32:53'),
(10, '656', 6, 6, 'Informatique', 5, 1, 1, '2023-06-21 07:25:33', '2023-06-21 07:25:33'),
(11, 'Cours 1', 25, 1, 'Informatique', 2, 2, 1, '2023-06-22 04:30:38', '2023-06-22 04:30:38'),
(12, 'fhkdbfhbdkh', 7, 55, 'Informatique', 2, 1, 1, '2023-06-22 04:58:34', '2023-06-22 04:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `cours_missions`
--

CREATE TABLE `cours_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `masseHoraire` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `filiere` varchar(255) NOT NULL,
  `ue_id` bigint(20) UNSIGNED NOT NULL,
  `enseignant_missionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `directeur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cours_missions`
--

INSERT INTO `cours_missions` (`id`, `intitule`, `masseHoraire`, `semestre`, `filiere`, `ue_id`, `enseignant_missionnaire_id`, `directeur_id`, `created_at`, `updated_at`) VALUES
(3, 'dsds', 8, 5, 'Mathématiques', 2, 5, 1, '2023-06-22 06:36:45', '2023-06-22 06:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `directeurs`
--

CREATE TABLE `directeurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `directeurs`
--

INSERT INTO `directeurs` (`id`, `nom`, `prenom`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Jancovici', 'Jean Luc', 'a@gmail.com', '$2y$10$AoGi8VVID9ENsYVAarucdOY9DMvjq2RqYmY.MHYeT8fisCMYN6ctu', NULL, '2023-06-22 09:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `enseignant_locals`
--

CREATE TABLE `enseignant_locals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `vacataire` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `directeur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enseignant_locals`
--

INSERT INTO `enseignant_locals` (`id`, `nom`, `prenom`, `vacataire`, `email`, `password`, `directeur_id`, `created_at`, `updated_at`) VALUES
(1, '1fdfdfdfdfdfdfdfdf', '1', 0, 'enseignant1@gmail.com', '$2y$10$J4sPtqYzC6pTc/Cx8VE4aeQhWLTdHSWqmzFuqRDp0pY2PPnivBE.e', 1, '2023-06-20 08:23:42', '2023-06-22 12:30:32'),
(2, 'Melonchon', 'Hean Luc uc', 0, 'enseignant2@gmail.com', '$2y$10$/dJNvkJvfy9BU/f7NBtutuYZGZQTEa0vqxlQjuFQFddTeZy25KxIi', 1, '2023-06-20 08:35:10', '2023-06-21 06:25:55'),
(3, 'Je suis au toop tu tu vas faire quoi', 'aa', 1, 'a@gmail.com', '$2y$10$lTPAoMT8Gb94dTCF1QjLmueyxgaZ7.qwOWaS5VaaeWL99clujv8g2', 1, '2023-06-21 06:26:15', '2023-06-22 06:43:57'),
(4, 'Jean', 'Luc', 0, 'enseignant100@gmail.com', '$2y$10$SlCwieH/4g3m5ZIEcq/aZePZr7qfrTqcvBx665xlx4gCGZO7P8WNu', 1, '2023-06-21 09:18:19', '2023-06-21 09:18:19'),
(5, 'Marine', 'lePen', 1, 'q@gmail.com', '$2y$10$5xwnTraP1ZuyXRXDZWlsJ.hGOMYJwZDI/O9pk84RKycg6rEmPfLfa', 1, '2023-06-21 10:54:50', '2023-06-22 13:58:07'),
(8, 'Tom', 'Jerryr', 0, 'z@gmail.com', '$2y$10$TxVjpuslhfDs36UhAPOHmO7EPsH//HItzVVRgBocDuqmbxpePl6By', 1, '2023-06-22 09:28:58', '2023-06-22 13:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `enseignant_missionnaires`
--

CREATE TABLE `enseignant_missionnaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `universite` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `directeur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enseignant_missionnaires`
--

INSERT INTO `enseignant_missionnaires` (`id`, `nom`, `prenom`, `universite`, `email`, `password`, `directeur_id`, `created_at`, `updated_at`) VALUES
(1, '454', '4', '4', 'enseignantMissionnaire3@gmail.com', '$2y$10$5HoutVA531X4mf0WjT/0G.ZooTj2iu8e5XQ03Oz12xRvC6sUTbATG', 1, '2023-06-20 09:59:46', '2023-06-20 09:59:46'),
(2, 'Je suis', 'fddf', 'fdf', 'fdf@gai', '$2y$10$2VpRvL84ngBlWB70qSpvgOFso6Bg/fB00VzOG5YVAjYKm6mdEEzTi', 1, '2023-06-21 07:59:13', '2023-06-22 06:40:36'),
(3, 'mission', 'naire', 'aaa', 'a@gmail.com', '$2y$10$9v37BUzYxkA3FCpqrj5g3.You67B4uLMcLSAgf9ERmndhJRHJ1hY6', 1, '2023-06-21 11:24:00', '2023-06-21 11:24:00'),
(4, 'Jean', 'Batuste', 'a1@gmail.com', 'a1@gmail.com', '$2y$10$O4WASLyR.VQj6cQX7BqwWe0HlFFzwsELKu98mpXOFzH0eFPEmCyjO', 1, '2023-06-22 06:36:25', '2023-06-22 06:36:25'),
(5, 'Marine', 'lePen', 'Imspd', 'q@gmail.com', '$2y$10$EKnekiKr.MrJkwyvdCjVVeIsoLaML0EdeoKK3Y8T37QO2B7KTBUda', 1, '2023-06-22 13:22:04', '2023-06-22 13:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matricule` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `filiere` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `directeur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `etudiants`
--

INSERT INTO `etudiants` (`id`, `matricule`, `nom`, `prenom`, `filiere`, `password`, `directeur_id`, `created_at`, `updated_at`) VALUES
(2, 14121414, 'sdsdsds', 'dsdsdsds', 'Mathématiques', '$2y$10$D6Lck25lVb/KoNwdRwDe1uhpk75BrWyXPn3K/A70ZXOabIuSfDuo.', 1, '2023-06-22 07:08:42', '2023-06-22 07:08:42'),
(3, 84646854, 'dfddfdf', 'fdfdfdfd', 'Mathématiques', '$2y$10$EKjSKo9X4Zcr2w/EkbXFe.IyxvWcQRK6z/ebnV8umkVMIupG/HDFq', 1, '2023-06-22 09:14:01', '2023-06-22 09:14:01'),
(4, 12345678, 'Jean :::', 'Louis', 'Mathématiques', '$2y$10$FtKWexIxu1Va3dn2HVRYNOwg5ExlpAjQYfPuJM8C.Q5OuLfT5oxgW', 1, '2023-06-22 14:33:35', '2023-06-22 15:22:57');

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
(6, '2023_06_11_091723_create_enseignants_table', 3),
(10, '2023_06_18_210326_create_u_e_s_table', 6),
(11, '2023_06_18_211717_create_u_e_s_table', 7),
(13, '2023_06_18_212226_create_ucs_table', 9),
(14, '2023_06_19_070904_create_ucs_table', 10),
(50, '2014_10_12_000000_create_users_table', 11),
(51, '2014_10_12_100000_create_password_reset_tokens_table', 11),
(52, '2019_08_19_000000_create_failed_jobs_table', 11),
(53, '2019_12_14_000001_create_personal_access_tokens_table', 11),
(54, '2023_06_10_221911_create_directeurs_table', 11),
(55, '2023_06_11_154046_create_enseignant_locals_table', 11),
(56, '2023_06_11_154104_create_enseignant_missionnaires_table', 11),
(57, '2023_06_14_195930_create_etudiants_table', 11),
(58, '2023_06_18_212136_create_ues_table', 11),
(59, '2023_06_19_092104_create_cours_locals_table', 11),
(60, '2023_06_19_092114_create_cours_missions_table', 11),
(61, '2023_06_22_114303_create_support_cours_table', 12),
(62, '2023_06_22_114310_create_support_tds_table', 12),
(63, '2023_06_22_135910_create_support_tds_table', 13),
(64, '2023_06_22_135918_create_support_cours_table', 13);

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
-- Table structure for table `support_cours`
--

CREATE TABLE `support_cours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `type_cours` varchar(255) NOT NULL,
  `cours_id` bigint(20) UNSIGNED NOT NULL,
  `enseignant_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_cours`
--

INSERT INTO `support_cours` (`id`, `nom`, `chemin`, `type_cours`, `cours_id`, `enseignant_id`, `created_at`, `updated_at`) VALUES
(2, 'Lettre aux primo-arrivants 2023.pdf', 'fichiers/pfADV7ybgD6Dh0RjjoO5mGisuQ8kqLdmV0s7ZkLJ.pdf', 'local', 10, 1, '2023-06-22 13:03:52', '2023-06-22 13:03:52'),
(4, 'Rentre e 2023.pdf', 'fichiers/1LZ1ftOlTO6roHxr4tCOGF7nYPqW1YVDiRXHbjX7.pdf', 'mission', 3, 5, '2023-06-22 14:15:49', '2023-06-22 14:15:49'),
(5, 'Rentre e 2023.pdf', 'fichiers/ZwgyoRe87U8G8SuhMmeCTKyVM6Ula5T33slU35i9.pdf', 'local', 8, 8, '2023-06-22 14:21:09', '2023-06-22 14:21:09'),
(6, 'Rentre e 2023.pdf', 'fichiers/JkFo9dVH2nETYQ6ZDIhJXPE9r9a77z0BCqUHcpno.pdf', 'local', 3, 8, '2023-06-22 15:19:33', '2023-06-22 15:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `support_tds`
--

CREATE TABLE `support_tds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `type_cours` varchar(255) NOT NULL,
  `cours_id` bigint(20) UNSIGNED NOT NULL,
  `enseignant_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tds`
--

INSERT INTO `support_tds` (`id`, `nom`, `chemin`, `type_cours`, `cours_id`, `enseignant_id`, `created_at`, `updated_at`) VALUES
(3, 'DOC-20220415-WA0019._', 'fichiers/0RKh8iEPNpmQkBzOlXR6ZDfuu6YNhYm2qik7NAHz.pdf', 'local', 3, 8, '2023-06-22 15:19:41', '2023-06-22 15:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `ues`
--

CREATE TABLE `ues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intituleUE` varchar(255) NOT NULL,
  `credit` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ues`
--

INSERT INTO `ues` (`id`, `intituleUE`, `credit`, `created_at`, `updated_at`) VALUES
(1, '11', 5, '2023-06-20 08:24:12', '2023-06-20 08:24:12'),
(2, 'Electro-Optique', 5, '2023-06-20 08:36:19', '2023-06-20 08:36:19'),
(3, 'vfxv x,,x:v,', 2, '2023-06-20 10:45:37', '2023-06-20 10:45:37'),
(4, '656', 656, '2023-06-21 07:11:49', '2023-06-21 07:11:49'),
(5, '655', 6, '2023-06-21 07:25:32', '2023-06-21 07:25:32'),
(6, 'New ue', 5, '2023-06-22 05:27:04', '2023-06-22 05:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cours_locals`
--
ALTER TABLE `cours_locals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cours_locals_ue_id_foreign` (`ue_id`),
  ADD KEY `cours_locals_enseignant_local_id_foreign` (`enseignant_local_id`),
  ADD KEY `cours_locals_directeur_id_foreign` (`directeur_id`);

--
-- Indexes for table `cours_missions`
--
ALTER TABLE `cours_missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cours_missions_ue_id_foreign` (`ue_id`),
  ADD KEY `cours_missions_enseignant_missionnaire_id_foreign` (`enseignant_missionnaire_id`),
  ADD KEY `cours_missions_directeur_id_foreign` (`directeur_id`);

--
-- Indexes for table `directeurs`
--
ALTER TABLE `directeurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `directeurs_email_unique` (`email`);

--
-- Indexes for table `enseignant_locals`
--
ALTER TABLE `enseignant_locals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enseignant_locals_email_unique` (`email`),
  ADD KEY `enseignant_locals_directeur_id_foreign` (`directeur_id`);

--
-- Indexes for table `enseignant_missionnaires`
--
ALTER TABLE `enseignant_missionnaires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enseignant_missionnaires_email_unique` (`email`),
  ADD KEY `enseignant_missionnaires_directeur_id_foreign` (`directeur_id`);

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiants_directeur_id_foreign` (`directeur_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `support_cours`
--
ALTER TABLE `support_cours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tds`
--
ALTER TABLE `support_tds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ues`
--
ALTER TABLE `ues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cours_locals`
--
ALTER TABLE `cours_locals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cours_missions`
--
ALTER TABLE `cours_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `directeurs`
--
ALTER TABLE `directeurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enseignant_locals`
--
ALTER TABLE `enseignant_locals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enseignant_missionnaires`
--
ALTER TABLE `enseignant_missionnaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_cours`
--
ALTER TABLE `support_cours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `support_tds`
--
ALTER TABLE `support_tds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ues`
--
ALTER TABLE `ues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cours_locals`
--
ALTER TABLE `cours_locals`
  ADD CONSTRAINT `cours_locals_directeur_id_foreign` FOREIGN KEY (`directeur_id`) REFERENCES `directeurs` (`id`),
  ADD CONSTRAINT `cours_locals_enseignant_local_id_foreign` FOREIGN KEY (`enseignant_local_id`) REFERENCES `enseignant_locals` (`id`),
  ADD CONSTRAINT `cours_locals_ue_id_foreign` FOREIGN KEY (`ue_id`) REFERENCES `ues` (`id`);

--
-- Constraints for table `cours_missions`
--
ALTER TABLE `cours_missions`
  ADD CONSTRAINT `cours_missions_directeur_id_foreign` FOREIGN KEY (`directeur_id`) REFERENCES `directeurs` (`id`),
  ADD CONSTRAINT `cours_missions_enseignant_missionnaire_id_foreign` FOREIGN KEY (`enseignant_missionnaire_id`) REFERENCES `enseignant_missionnaires` (`id`),
  ADD CONSTRAINT `cours_missions_ue_id_foreign` FOREIGN KEY (`ue_id`) REFERENCES `ues` (`id`);

--
-- Constraints for table `enseignant_locals`
--
ALTER TABLE `enseignant_locals`
  ADD CONSTRAINT `enseignant_locals_directeur_id_foreign` FOREIGN KEY (`directeur_id`) REFERENCES `directeurs` (`id`);

--
-- Constraints for table `enseignant_missionnaires`
--
ALTER TABLE `enseignant_missionnaires`
  ADD CONSTRAINT `enseignant_missionnaires_directeur_id_foreign` FOREIGN KEY (`directeur_id`) REFERENCES `directeurs` (`id`);

--
-- Constraints for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_directeur_id_foreign` FOREIGN KEY (`directeur_id`) REFERENCES `directeurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
