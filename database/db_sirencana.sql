-- MySQL dump 10.13  Distrib 9.1.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_sirencana
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `db_sirencana`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_sirencana` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_sirencana`;

--
-- Table structure for table `cpl`
--

DROP TABLE IF EXISTS `cpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cpl` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `prodi_id` int unsigned NOT NULL,
  `kode` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `cpl_prodi_id_foreign` (`prodi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpl`
--

LOCK TABLES `cpl` WRITE;
/*!40000 ALTER TABLE `cpl` DISABLE KEYS */;
INSERT INTO `cpl` VALUES (4,2,'CPL 2','Menguasai konsep teoritis dan aplikasi tentang pedagogi, psikologi  pendidikan, dan pembelajaran Bahasa Inggris. '),(5,2,'CPL 4','Mengintegrasikan konsep pedagogi, psikologi pendidikan,  pembelajaran Bahasa Inggris, Linguistik Bahasa dan Sastra Inggris,  kurikulum, metodologi, media, evaluasi, pengelolaan kelas, dan TIK  dalam pembelajaran Bahasa Inggris'),(6,2,'CPL 11','Menerapkan kompetensi digital dalam pembelajaran Bahasa Inggris  dan kehidupan sehari-hari yang relevan sebagai pembelajar sepanjang  hayat yang adaptif, dengan berlandaskan potensi, karakteristik, dan  nilai-nilai kearifan lokal wilayah maritim');
/*!40000 ALTER TABLE `cpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cpmk`
--

DROP TABLE IF EXISTS `cpmk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cpmk` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mk_id` int unsigned NOT NULL,
  `kode` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `cpmk_mk_id_foreign` (`mk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpmk`
--

LOCK TABLES `cpmk` WRITE;
/*!40000 ALTER TABLE `cpmk` DISABLE KEYS */;
INSERT INTO `cpmk` VALUES (3,4,'CPMK-1','Students are able to organize the creative process for public speaking'),(4,4,'CPMK-2','Students are able to produce a speech for various communicative purposes using appropriate verbal and non-verbal communication strategies.'),(5,4,'CPMK-3','Students are able to evaluate public speaking performances and provide constructive feedback for continuous improvement.');
/*!40000 ALTER TABLE `cpmk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cpmk_cpl`
--

DROP TABLE IF EXISTS `cpmk_cpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cpmk_cpl` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cpmk_id` int unsigned NOT NULL,
  `cpl_id` int unsigned NOT NULL,
  `bobot` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `cpmk_cpl_cpmk_id_foreign` (`cpmk_id`),
  KEY `cpmk_cpl_cpl_id_foreign` (`cpl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpmk_cpl`
--

LOCK TABLES `cpmk_cpl` WRITE;
/*!40000 ALTER TABLE `cpmk_cpl` DISABLE KEYS */;
INSERT INTO `cpmk_cpl` VALUES (1,1,3,20.00),(2,1,2,40.00),(3,1,1,40.00),(4,3,4,60.00),(5,3,5,40.00),(6,4,5,60.00),(7,4,6,40.00),(8,5,4,20.00),(9,5,5,40.00),(10,5,6,40.00);
/*!40000 ALTER TABLE `cpmk_cpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dosen`
--

DROP TABLE IF EXISTS `dosen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dosen` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `nidn` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosen`
--

LOCK TABLES `dosen` WRITE;
/*!40000 ALTER TABLE `dosen` DISABLE KEYS */;
INSERT INTO `dosen` VALUES (3,'Pradipta Agustina, S.Hum., M.Pd.','0017089007'),(4,'Satria Agust, S.S., M.Pd.','0018081501'),(5,'Dewi Murni, S.S., M.Hum.','1016067901'),(6,'Feri Irawan, S.Kom., M.Kom.','0117099601');
/*!40000 ALTER TABLE `dosen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epbm`
--

DROP TABLE IF EXISTS `epbm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `epbm` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fakultas` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_akademik` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `ketua_gkm` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anggota_gkm` text COLLATE utf8mb4_general_ci,
  `prakata` text COLLATE utf8mb4_general_ci,
  `latar_belakang` text COLLATE utf8mb4_general_ci,
  `tujuan` text COLLATE utf8mb4_general_ci,
  `metode` text COLLATE utf8mb4_general_ci,
  `evaluasi_mk` text COLLATE utf8mb4_general_ci,
  `evaluasi_dosen` text COLLATE utf8mb4_general_ci,
  `kepuasan_mahasiswa` text COLLATE utf8mb4_general_ci,
  `kelulusan` text COLLATE utf8mb4_general_ci,
  `simpulan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epbm`
--

LOCK TABLES `epbm` WRITE;
/*!40000 ALTER TABLE `epbm` DISABLE KEYS */;
/*!40000 ALTER TABLE `epbm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_penilaian`
--

DROP TABLE IF EXISTS `jenis_penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_penilaian` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rps_id` int unsigned NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bobot` decimal(5,2) NOT NULL DEFAULT '0.00',
  `kategori` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'tugas',
  `judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_cpmk` text COLLATE utf8mb4_general_ci,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `metode` text COLLATE utf8mb4_general_ci,
  `luaran_objek` text COLLATE utf8mb4_general_ci,
  `luaran_bentuk` text COLLATE utf8mb4_general_ci,
  `indikator` text COLLATE utf8mb4_general_ci,
  `kriteria` text COLLATE utf8mb4_general_ci,
  `jadwal` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lain_lain` text COLLATE utf8mb4_general_ci,
  `rujukan` text COLLATE utf8mb4_general_ci,
  `rubrik` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `jenis_penilaian_rps_id_foreign` (`rps_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_penilaian`
--

LOCK TABLES `jenis_penilaian` WRITE;
/*!40000 ALTER TABLE `jenis_penilaian` DISABLE KEYS */;
INSERT INTO `jenis_penilaian` VALUES (1,1,'Tugas',30.00,'tugas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,'UTS',30.00,'uts',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,'UAS',40.00,'uas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,2,'Tugas',30.00,'tugas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,2,'UTS',30.00,'uts',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,2,'UAS',40.00,'uas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,3,'Tugas',30.00,'tugas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,3,'UTS',25.00,'uts',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,3,'UAS',30.00,'uas',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,3,'Keaktifan',15.00,'lainnya',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `jenis_penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mk_id` int unsigned NOT NULL,
  `rps_id` int unsigned NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_akademik` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_pertemuan` tinyint unsigned NOT NULL DEFAULT '16',
  PRIMARY KEY (`id`),
  KEY `kelas_mk_id_foreign` (`mk_id`),
  KEY `kelas_rps_id_foreign` (`rps_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (2,3,2,'A','Genap','2026/2027',16);
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas_dosen`
--

DROP TABLE IF EXISTS `kelas_dosen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas_dosen` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `dosen_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_dosen_kelas_id_foreign` (`kelas_id`),
  KEY `kelas_dosen_dosen_id_foreign` (`dosen_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas_dosen`
--

LOCK TABLES `kelas_dosen` WRITE;
/*!40000 ALTER TABLE `kelas_dosen` DISABLE KEYS */;
INSERT INTO `kelas_dosen` VALUES (1,2,3),(2,2,4);
/*!40000 ALTER TABLE `kelas_dosen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kontrak_kuliah`
--

DROP TABLE IF EXISTS `kontrak_kuliah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kontrak_kuliah` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `jadwal_ruang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jadwal_hari` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jadwal_jam` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `klausa` text COLLATE utf8mb4_general_ci,
  `ttd` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_ttd` datetime DEFAULT NULL,
  `koordinator_kelas` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_id` (`kelas_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kontrak_kuliah`
--

LOCK TABLES `kontrak_kuliah` WRITE;
/*!40000 ALTER TABLE `kontrak_kuliah` DISABLE KEYS */;
INSERT INTO `kontrak_kuliah` VALUES (2,2,'5','Senin','12.00-15.00','Mahasiswa sah yang mengikuti perkuliahan ini adalah yang namanya tercantum dalam Daftar Peserta Perkuliahan di SIPA.\r\nMahasiswa wajib tergabung pada Google Classroom dan Grup WA Mata Kuliah ini.\r\nSatu orang perwakilan mahasiswa menandatangani kontrak perkuliahan bersama dosen pengajar.\r\nMahasiswa harus berada di dalam kelas 5 menit sebelum perkuliahan dimulai.\r\nMahasiswa diberi toleransi waktu terlambat 15 menit dari jadwal.\r\nMahasiswa yang datang lebih dari 15 menit maka dianggap tidak masuk tanpa keterangan namun masih diperbolehkan mengikuti perkuliahan.\r\nMahasiswa diperkenankan tidak mengikuti aktivitas perkuliahan jika sakit, terjadi keadaan mendesak atau mengikuti kegiatan di luar program studi dengan membuat surat izin yang dilengkapi dengan:\r\nJika sakit maka memberikan Surat Keterangan Dokter\r\nJika terjadi keadaan mendesak maka memberikan Surat Keterangan dari Orang Tua/ Wali Mahasiswa dan diketahui oleh Dosen PA\r\nJika ada tugas dari Fakultas dan/atau Universitas maka dilengkapi dengan Surat Tugas dari Fakultas/ Universitas\r\nMahasiswa diharuskan mengikuti 75% dari seluruh proses perkuliahan untuk memperoleh nilai akhir.\r\nMahasiswa harus memakai busana yang sopan, bersih, dan rapi. Sandal dan kaus oblong tidak diperkenankan. Mahasiswa wajib memakai sepatu.\r\nApabila terjadi hujan lebat, maka sandal diperbolehkan.\r\nMahasiswa harus bertutur kata yang sopan dan santun ketika berinteraksi dengan dosen dan mahasiswa lain.\r\nMahasiswa diwajibkan mengumpulkan tugas sesuai jadwal dan ketentuan yang telah ditentukan.\r\nTugas hasil copy paste atau plagiarisme lebih dari 30% bernilai 0\r\nMahasiswa yang tidak mengikuti pembelajaran suatu mata kuliah lebih dari 3 (tiga) pertemuan dari seluruh rencana pembelajaran dalam satu semester tidak dapat mengikuti ujian akhir semester.\r\nMahasiswa berhak mengikuti ujian susulan jika berhalangan hadir dengan alasan sakit, kedukaan atau mengikuti kegiatan dari fakultas/universitas dengan memberikan surat sesuai dengan poin nomor 6. Alasan terlambat atau kesalahan pada diri mahasiswa tidak diterima. Jadwal ujian susulan ditentukan oleh dosen.\r\nMahasiswa berhak mendapat nilai yang objektif dari dosen.\r\nMahasiswa berhak mempertanyakan nilai tugas dan ujian sesuai dengan kalender akademik.\r\n\r\nHAK DAN KEWAJIBAN DOSEN\r\nDosen mengajar sesuai dengan jadwal perkuliahan, bila ada perubahan dosen wajib memberikan informasi kepada mahasiswa maksimum 1 hari sebelum perkuliahan berlangsung.\r\nDosen pengajar wajib menandatangani kontrak perkuliahan bersama dengan koordinator kelas.\r\nDosen wajib memberikan materi perkuliahan dengan sungguh-sungguh.\r\nDosen wajib mengganti jam perkuliahan yang tidak terlaksana dengan terlebih dulu membuat kesepakatan bersama mahasiswa.\r\nDosen harus berpakaian rapi, sopan, dan bersih.\r\nDosen harus menilai mahasiswa secara objektif sesuai komponen penilaian yang ada.\r\nDosen wajib memberitahu nilai tugas dan ujian kepada mahasiswa.\r\nDosen berhak memberi sanksi bagi mahasiswa yang menyalahi aturan akademik.\r\nDosen berhak tidak menilai tugas mahasiswa yang tidak dikumpulkan pada waktu yang telah ditentukan.',1,'2026-10-07 03:40:04',NULL);
/*!40000 ALTER TABLE `kontrak_kuliah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `prodi_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`),
  KEY `mahasiswa_prodi_id_foreign` (`prodi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (2,'2301020030','Jovic Khidir Evta',2);
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mata_kuliah`
--

DROP TABLE IF EXISTS `mata_kuliah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mata_kuliah` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `tingkat_mk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Prodi',
  `prodi_id` int unsigned DEFAULT NULL,
  `rumpun_mk` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sifat_mk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Wajib',
  `sks` tinyint unsigned NOT NULL DEFAULT '3',
  `semester` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Ganjil',
  `deskripsi` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `mata_kuliah_prodi_id_foreign` (`prodi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mata_kuliah`
--

LOCK TABLES `mata_kuliah` WRITE;
/*!40000 ALTER TABLE `mata_kuliah` DISABLE KEYS */;
INSERT INTO `mata_kuliah` VALUES (4,'PBI11111','Public Speaking','Prodi',2,'Keterampilan Bahasa Inggris','Wajib',2,'Genap','This subject is specifically designed to give students an opportunity to develop and strengthen skills in presenting public oral presentations in a variety of situations where English is the medium of communication. The presentations are in the form of prepared speeches (informative, demonstrative and persuasive). The subject provides students with a basic background in the theories and principles of public speaking, as well as practical experience. The emphasis put on variety, language skills and the balance between input and practice throughout the course will help students become more confident, autonomous and competent speakers of English. All teaching learning activities are conducted through lecturing, discussion and presentation.');
/*!40000 ALTER TABLE `mata_kuliah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matriks_penilaian`
--

DROP TABLE IF EXISTS `matriks_penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matriks_penilaian` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rps_id` int unsigned NOT NULL,
  `jenis_penilaian_id` int unsigned NOT NULL,
  `cpmk_id` int unsigned NOT NULL,
  `bobot` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `matriks_penilaian_rps_id_foreign` (`rps_id`),
  KEY `matriks_penilaian_jenis_penilaian_id_foreign` (`jenis_penilaian_id`),
  KEY `matriks_penilaian_cpmk_id_foreign` (`cpmk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matriks_penilaian`
--

LOCK TABLES `matriks_penilaian` WRITE;
/*!40000 ALTER TABLE `matriks_penilaian` DISABLE KEYS */;
INSERT INTO `matriks_penilaian` VALUES (1,2,5,2,30.00),(2,2,6,2,30.00),(3,2,7,2,40.00),(4,3,8,3,10.00),(5,3,8,4,10.00),(6,3,8,5,10.00),(7,3,9,3,10.00),(8,3,9,4,15.00),(9,3,10,3,5.00),(10,3,10,4,10.00),(11,3,10,5,15.00),(12,3,11,3,5.00),(13,3,11,4,5.00),(14,3,11,5,5.00);
/*!40000 ALTER TABLE `matriks_penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-01-01-000001','App\\Database\\Migrations\\CreateObeSchema','default','App',1790561447,1),(2,'2026-01-02-000001','App\\Database\\Migrations\\CreateUsers','default','App',1790823976,2),(3,'2026-10-27-000001','App\\Database\\Migrations\\AddFormatLaporanUmrah','default','App',1793067797,3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai`
--

DROP TABLE IF EXISTS `nilai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `peserta_id` int unsigned NOT NULL,
  `jenis_penilaian_id` int unsigned NOT NULL,
  `nilai` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `nilai_peserta_id_foreign` (`peserta_id`),
  KEY `nilai_jenis_penilaian_id_foreign` (`jenis_penilaian_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai`
--

LOCK TABLES `nilai` WRITE;
/*!40000 ALTER TABLE `nilai` DISABLE KEYS */;
/*!40000 ALTER TABLE `nilai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta_kelas`
--

DROP TABLE IF EXISTS `peserta_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peserta_kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `mahasiswa_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `peserta_kelas_kelas_id_foreign` (`kelas_id`),
  KEY `peserta_kelas_mahasiswa_id_foreign` (`mahasiswa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta_kelas`
--

LOCK TABLES `peserta_kelas` WRITE;
/*!40000 ALTER TABLE `peserta_kelas` DISABLE KEYS */;
INSERT INTO `peserta_kelas` VALUES (1,1,1),(2,2,2);
/*!40000 ALTER TABLE `peserta_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portofolio`
--

DROP TABLE IF EXISTS `portofolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portofolio` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `tujuan` text COLLATE utf8mb4_general_ci,
  `metode` text COLLATE utf8mb4_general_ci,
  `isi` text COLLATE utf8mb4_general_ci,
  `pendahuluan` text COLLATE utf8mb4_general_ci,
  `peserta_ket` text COLLATE utf8mb4_general_ci,
  `kehadiran_ket` text COLLATE utf8mb4_general_ci,
  `sistem_evaluasi` text COLLATE utf8mb4_general_ci,
  `hasil_capaian` text COLLATE utf8mb4_general_ci,
  `rekomendasi` text COLLATE utf8mb4_general_ci,
  `tautan_rps` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tautan_kontrak` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tautan_presensi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tautan_soal` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelengkapan` text COLLATE utf8mb4_general_ci,
  `realisasi_tatap_muka` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_id` (`kelas_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portofolio`
--

LOCK TABLES `portofolio` WRITE;
/*!40000 ALTER TABLE `portofolio` DISABLE KEYS */;
INSERT INTO `portofolio` VALUES (1,1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,2,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `portofolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presensi`
--

DROP TABLE IF EXISTS `presensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presensi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `peserta_id` int unsigned NOT NULL,
  `pertemuan` tinyint unsigned NOT NULL,
  `status` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `presensi_peserta_id_foreign` (`peserta_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presensi`
--

LOCK TABLES `presensi` WRITE;
/*!40000 ALTER TABLE `presensi` DISABLE KEYS */;
INSERT INTO `presensi` VALUES (1,1,1,'H'),(2,2,1,'H'),(3,2,2,'H');
/*!40000 ALTER TABLE `presensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodi`
--

DROP TABLE IF EXISTS `prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fakultas` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodi`
--

LOCK TABLES `prodi` WRITE;
/*!40000 ALTER TABLE `prodi` DISABLE KEYS */;
INSERT INTO `prodi` VALUES (2,'Pendidikan Bahasa Inggris','Pendidikan Bahasa dan Seni','Keguruan dan Ilmu Pendidikan');
/*!40000 ALTER TABLE `prodi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rps`
--

DROP TABLE IF EXISTS `rps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rps` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mk_id` int unsigned NOT NULL,
  `tahun_akademik` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `pengembang_id` int unsigned DEFAULT NULL,
  `koor_prodi_id` int unsigned DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `ttd_dosen` tinyint(1) NOT NULL DEFAULT '0',
  `ttd_kaprodi` tinyint(1) NOT NULL DEFAULT '0',
  `arsip_gpm` tinyint(1) NOT NULL DEFAULT '0',
  `arsip_lokasi` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `kode_dokumen` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_penyusunan` date DEFAULT NULL,
  `bahan_kajian` text COLLATE utf8mb4_general_ci,
  `pustaka` text COLLATE utf8mb4_general_ci,
  `media_software` text COLLATE utf8mb4_general_ci,
  `media_hardware` text COLLATE utf8mb4_general_ci,
  `mk_syarat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sdgs` text COLLATE utf8mb4_general_ci,
  `analisis_pembelajaran` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `rps_mk_id_foreign` (`mk_id`),
  KEY `rps_pengembang_id_foreign` (`pengembang_id`),
  KEY `rps_koor_prodi_id_foreign` (`koor_prodi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rps`
--

LOCK TABLES `rps` WRITE;
/*!40000 ALTER TABLE `rps` DISABLE KEYS */;
INSERT INTO `rps` VALUES (3,4,'2026/2027 Ganjil',3,5,'diarsipkan',1,1,1,'','2026-10-07 02:38:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `rps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rps_pertemuan`
--

DROP TABLE IF EXISTS `rps_pertemuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rps_pertemuan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rps_id` int unsigned NOT NULL,
  `minggu` tinyint unsigned NOT NULL,
  `sub_cpmk` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `indikator` text COLLATE utf8mb4_general_ci,
  `materi` text COLLATE utf8mb4_general_ci,
  `model` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bentuk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Luring',
  `bobot` decimal(5,2) NOT NULL DEFAULT '0.00',
  `is_uts` tinyint(1) NOT NULL DEFAULT '0',
  `is_uas` tinyint(1) NOT NULL DEFAULT '0',
  `luring` text COLLATE utf8mb4_general_ci,
  `daring` text COLLATE utf8mb4_general_ci,
  `blended` text COLLATE utf8mb4_general_ci,
  `penilaian` text COLLATE utf8mb4_general_ci,
  `alokasi_waktu` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rps_pertemuan_rps_id_foreign` (`rps_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rps_pertemuan`
--

LOCK TABLES `rps_pertemuan` WRITE;
/*!40000 ALTER TABLE `rps_pertemuan` DISABLE KEYS */;
INSERT INTO `rps_pertemuan` VALUES (1,1,1,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(2,1,2,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(3,1,3,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(4,1,4,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(5,1,5,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(6,1,6,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(7,1,7,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(8,1,8,NULL,NULL,NULL,NULL,'Luring',0.00,1,0,NULL,NULL,NULL,NULL,NULL),(9,1,9,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(10,1,10,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(11,1,11,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(12,1,12,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(13,1,13,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(14,1,14,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(15,1,15,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(16,1,16,NULL,NULL,NULL,NULL,'Luring',0.00,0,1,NULL,NULL,NULL,NULL,NULL),(17,2,1,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(18,2,2,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(19,2,3,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(20,2,4,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(21,2,5,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(22,2,6,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(23,2,7,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(24,2,8,NULL,NULL,NULL,NULL,'Luring',0.00,1,0,NULL,NULL,NULL,NULL,NULL),(25,2,9,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(26,2,10,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(27,2,11,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(28,2,12,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(29,2,13,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(30,2,14,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(31,2,15,NULL,NULL,NULL,NULL,'Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(32,2,16,NULL,NULL,NULL,NULL,'Luring',0.00,0,1,NULL,NULL,NULL,NULL,NULL),(33,3,1,' Sub-CPMK 1.1: Students are able to explain the concepts, principles, and communication process in public speaking. (C2)','Agreeing course agreement Applying course agreement during the semester Understanding the basic concept in Public Speaking','1.  Course Syllabus 2. Course Contract 3. Public Speaking',' Small Group Discussion Forming small groups Discussing the chosen topic Presenting the result of th','Luring',1.00,0,0,NULL,NULL,NULL,NULL,NULL),(34,3,2,' Sub-CPMK 1.2: Students are able to select appropriate topics, supporting materials, and evidence for speeches. (C3)','Applying strategies in choosing a topic for public speaking',' Selecting topics',' Small Group Discussion Forming small groups Discussing the chosen topic Presenting the result of th','Luring',1.00,0,0,NULL,NULL,NULL,NULL,NULL),(35,3,3,' Sub-CPMK 1.2: Students are able to select appropriate topics, supporting materials, and evidence for speeches. (C3)',' Implementing strategies in choosing material for public speaking','Researching materials','Small Group Discussion Forming small groups Discussing the chosen topic Presenting the result of the','Luring',1.00,0,0,NULL,NULL,NULL,NULL,NULL),(36,3,4,' Sub-CPMK 1.3: Students are able to organize speech outlines using appropriate organizational patterns. (C3)','Understanding speech outline Organizing a speech outline','Understanding speech outline Organizing a speech outline',' Small Group Discussion Forming small groups Discussing the chosen topic Presenting the result of th','Luring',6.00,0,0,NULL,NULL,NULL,NULL,NULL),(37,3,5,'Sub-CPMK 1.4: Students are able to differentiate and prepare various types of speeches (informative, persuasive, demonstrative,). (C4)','Distinguishing types of speech: Informative, Demonstrative, Persuasive','Speech organization','Problem-based Learning (Case- based Method) Orientation on the problem Organize students Guide indiv','Luring',2.00,0,0,NULL,NULL,NULL,NULL,NULL),(38,3,6,'Sub-CPMK 2.1: Students are able to deliver effective speeches using appropriate language, vocal variety, body language, and visual aids. (P5)','Performing an informative speech Evaluating the performance',' Informative speech','Simulation Learning: Preparing the speech Individual simulation of the speech Evaluating the experie','Luring',4.00,0,0,NULL,NULL,NULL,NULL,NULL),(39,3,7,'Sub-CPMK 2.1: Students are able to deliver effective speeches using appropriate language, vocal variety, body language, and visual aids. (P5)','Performing an informative speech Evaluating the performance',' Informative speech','Simulation Learning: Preparing the speech Individual simulation of the speech Evaluating the experie','Luring',5.00,0,0,NULL,NULL,NULL,NULL,NULL),(40,3,8,'','','','','Luring',25.00,1,0,NULL,NULL,NULL,NULL,NULL),(41,3,9,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(42,3,10,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(43,3,11,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(44,3,12,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(45,3,13,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(46,3,14,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(47,3,15,'','','','','Luring',0.00,0,0,NULL,NULL,NULL,NULL,NULL),(48,3,16,'','','','','Luring',0.00,0,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `rps_pertemuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rps_status_log`
--

DROP TABLE IF EXISTS `rps_status_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rps_status_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rps_id` int unsigned NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_general_ci,
  `oleh` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rps_status_log_rps_id_foreign` (`rps_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rps_status_log`
--

LOCK TABLES `rps_status_log` WRITE;
/*!40000 ALTER TABLE `rps_status_log` DISABLE KEYS */;
INSERT INTO `rps_status_log` VALUES (11,3,'disetujui_gkm','Tanda tangan Kaprodi.','Dewi Murni, S.S., M.Hum. (KAPRODI)','2026-10-15 02:31:27'),(8,3,'diajukan','','Administrator (ADMIN)','2026-10-15 02:24:21'),(9,3,'disetujui_gkm','','Feri Irawan, S.Kom., M.Kom. (GKM)','2026-10-15 02:29:38'),(10,3,'disetujui_gkm','Tanda tangan Dosen.','Pradipta Agustina, S.Hum., M.Pd. (DOSEN)','2026-10-15 02:31:01'),(7,3,'draft','RPS dibuat sebagai draf.','Administrator (ADMIN)','2026-10-07 02:38:07'),(12,3,'ditandatangani','Ditandatangani Dosen & Kaprodi.','Dewi Murni, S.S., M.Hum. (KAPRODI)','2026-10-15 02:31:27'),(13,3,'diarsipkan','Diserahkan ke GPM dan diarsipkan.','Dewi Murni, S.S., M.Hum. (KAPRODI)','2026-10-15 02:31:32');
/*!40000 ALTER TABLE `rps_status_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `dosen_id` int unsigned DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `wajib_ganti_password` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `users_dosen_id_foreign` (`dosen_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Administrator','admin','$2y$12$kDDNVQF9hWzTZVQNWip2qejfWGEuZzy2T368ewlGXJrEiQoNf.0z2','admin',NULL,1,0,'2026-10-27 02:23:11','2026-10-05 02:19:04'),(3,'Pradipta Agustina, S.Hum., M.Pd.','pradipta','$2y$12$/apNitQK9K2nJW1ci/33VOrM03M1mkOn/Wgl7ji58szPBsbJE8J2G','dosen',3,1,0,'2026-10-15 02:33:04','2026-10-07 02:57:48'),(4,'Dewi Murni, S.S., M.Hum.','dewi','$2y$12$egR.ti1Eiw0NvBG2P4hasOPyaGkBrDS0Kz4FH1FeHZOzgk7bpiGZy','kaprodi',5,1,0,'2026-10-15 02:31:16','2026-10-07 02:58:31'),(5,'Feri Irawan, S.Kom., M.Kom.','feri','$2y$12$7XnpAxrh0EE5tmV6rJAbeuf7LwNh9cUq.2dcnGphvpTTQymiCE2Ya','gkm',6,1,0,'2026-10-15 02:29:06','2026-10-15 02:27:51'),(6,'Satria Agust, S.S., M.Pd.','satria','$2y$12$KH.8mKq8toW8qV1/0Sfk6uZ9Fi549qHJ8Z9yq.vNsVAXN4nnOVvaq','gpm',4,1,0,'2026-10-15 02:31:46','2026-10-15 02:28:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_sirencana'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-27  9:39:44
