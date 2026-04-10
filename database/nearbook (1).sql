-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 11:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nearbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `short_bio` text DEFAULT NULL,
  `biography` longtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `slug`, `email`, `phone`, `nationality`, `date_of_birth`, `photo`, `short_bio`, `biography`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Brian W. Kernighan & Dennis M. Ritchie', '/Brian W-Kernighan-Dennis-M-Ritchie', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-02 10:57:13', '2026-02-02 10:57:13'),
(2, 'Tamim Shahriar Subeen', 'tamim-shahriar-subeen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-02 11:19:08', '2026-02-02 11:19:08'),
(3, 'Cormen, Leiserson, Rivest & Stein', 'Cormen-Leiserson-Rivest-Stein', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-04 00:46:17', '2026-02-04 00:46:24'),
(4, 'ইবন কাসীর, আব্দুল রহমান', 'ইবন কাসীর, আব্দুল রহমান', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-04 08:43:14', '2026-02-04 08:44:51'),
(5, 'সাঈদ বিন আলী আল-কাহতানি, মুহাম্মদ ফারুক', 'সাঈদ বিন আলী আল-কাহতানি, মুহাম্মদ ফারুক', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-02-04 08:47:39', '2026-02-04 08:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `link`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nearbooks', 'Nemo quidem ipsum qu', 'https://www.rokomari.com/', 'storage/banners/1769960387_banner.webp', 0, '2026-01-30 02:29:01', '2026-02-01 11:08:51'),
(2, 'Nearbooks', NULL, NULL, 'storage/banners/1769960433_banner.webp', 0, '2026-02-01 09:40:34', '2026-02-01 11:08:51'),
(3, 'fsasfsad', NULL, NULL, 'storage/banners/1769960445_banner.webp', 0, '2026-02-01 09:40:45', '2026-02-01 10:21:57'),
(4, 'Nearbook', NULL, NULL, 'storage/banners/1769965731_banner.png', 1, '2026-02-01 11:08:51', '2026-02-01 11:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) DEFAULT 0,
  `cover_image` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `publisher_id` bigint(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) DEFAULT NULL,
  `discount_parcentage` int(20) DEFAULT 0,
  `pdf_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `slug`, `author_id`, `isbn`, `price`, `stock`, `cover_image`, `short_description`, `description`, `publication_date`, `publisher_id`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `category_id`, `sub_category_id`, `discount_parcentage`, `pdf_price`) VALUES
(1, 'The C Programming Language', 'the-c-programming-language', 1, '2nd Edition', 120.00, 10, '/storage/covers/1770051911_the-c-programming-language.jpg', 'Classic foundational book for learning C programming, often recommended for structured programming courses.', 'The C Programming Language by Brian W. Kernighan and Dennis M. Ritchie is one of the most influential and foundational books in computer science. Written by the creators of the C language itself, the book serves as both an introduction to C programming and an authoritative reference for experienced programmers. First published in 1978, it played a major role in popularizing C and shaping modern programming languages.\r\n\r\nThe book is concise, practical, and example-driven. Rather than focusing on lengthy theory, it teaches programming through clear explanations and well-crafted code samples. Its writing style is minimal yet precise, encouraging readers to think logically and write efficient, readable programs.\r\n\r\nThe book begins with a tutorial introduction that familiarizes readers with the basics of C programming. It introduces fundamental concepts such as variables, data types, expressions, control structures (like if, while, and for loops), and functions. One of the most famous examples in programming history—printing “Hello, World!”—appears early in the book. This chapter is designed to quickly get readers writing real C programs, even with little prior programming experience.\r\n\r\nNext, the book explores types, operators, and expressions, explaining how C handles integers, floating-point numbers, characters, and type conversions. It also discusses operators, precedence, and bitwise operations, which are especially important in system-level programming. The explanations emphasize efficiency and low-level control, which are key strengths of the C language.\r\n\r\nA major portion of the book is dedicated to control flow and functions. Readers learn how to structure programs using conditional statements, loops, and modular functions. The authors stress good programming practices, such as clear function design and proper use of return values, helping readers write maintainable and reusable code.\r\n\r\nOne of the most important and challenging topics covered is pointers and arrays. The book explains memory addresses, pointer arithmetic, and the close relationship between arrays and pointers in C. While this section is demanding, it is crucial for understanding how C manages memory and why it is so powerful. Mastery of pointers allows programmers to write efficient programs and interact directly with hardware and operating systems.\r\n\r\nThe book also covers structures, unions, and typedef, which help organize complex data. These features enable programmers to build more sophisticated programs and data models. File input/output is explained in detail, teaching how to read from and write to files using the C standard library.\r\n\r\nIn later chapters, the authors introduce the C standard library, including utilities for string handling, memory allocation, and mathematical operations. The final chapters discuss advanced topics such as macros, the C preprocessor, and low-level programming techniques.\r\n\r\nOverall, The C Programming Language is more than just a tutorial—it is a timeless guide to disciplined programming. While modern languages offer more abstractions, the concepts taught in this book remain essential. It is especially valuable for students of computer science, system programmers, and anyone who wants to understand how software works close to the hardware. Even decades after its publication, it remains a classic and highly respected programming book.', NULL, 1, 1, NULL, NULL, '2026-02-02 11:05:11', '2026-02-05 12:04:48', 1, 1, 10, 20.00),
(2, 'Computer Programming – 1st Khondo', '/computer-programming-1st-khondo', 2, '9789848042014', 150.00, 10, '/storage/covers/1770052831_computer-programming-1st-khondo.jpg', 'A Bengali-language programming book focusing on C language basics, especially useful for beginners and first-year students who prefer learning in Bengali. It covers foundational topics like input/output, variables, control structures, and introductory program examples.', 'A Bengali-language programming book focusing on C language basics, especially useful for beginners and first-year students who prefer learning in Bengali. It covers foundational topics like input/output, variables, control structures, and introductory program examples.', NULL, 2, 1, NULL, NULL, '2026-02-02 11:20:31', '2026-02-04 11:58:24', 1, 1, 0, 30.00),
(3, 'Introduction to Algorithms', 'Introduction to Algorithms', 3, '978-0-262-04630-5', 200.00, 10, '/storage/covers/1770188915_introduction-to-algorithms.jpg', 'A comprehensive and widely used text on algorithms covering design, analysis, sorting, graph algorithms, dynamic programming and more — often referred to as “CLRS.”', 'A comprehensive and widely used text on algorithms covering design, analysis, sorting, graph algorithms, dynamic programming and more — often referred to as “CLRS.”', NULL, 3, 1, NULL, NULL, '2026-02-04 01:08:39', '2026-02-04 11:58:50', 1, 1, 0, 20.00),
(4, 'Artificial Intelligence: A Modern Approach', 'artificial-intelligence-a-modern-approach', 3, '0-13-461099-7', 400.00, 10, '/storage/covers/1770189135_artificial-intelligence-a-modern-approach.jpg', 'A leading university text on artificial intelligence, covering search algorithms, reasoning, machine learning, logic, and robotics — used globally for AI courses.', 'A leading university text on artificial intelligence, covering search algorithms, reasoning, machine learning, logic, and robotics — used globally for AI courses.', NULL, 3, 1, NULL, NULL, '2026-02-04 01:12:15', '2026-02-04 11:59:11', 1, 1, 0, 30.00),
(5, 'Operating System Concepts', 'operating-system-concepts', 1, '978-0-201-06097-3', 350.00, 10, '/storage/covers/1770189382_operating-system-concepts.jpg', 'Known as the “dinosaur book,” this classic text covers operating system principles including processes, scheduling, memory, I/O, and file systems.', 'Known as the “dinosaur book,” this classic text covers operating system principles including processes, scheduling, memory, I/O, and file systems.', NULL, 3, 1, NULL, NULL, '2026-02-04 01:16:22', '2026-02-04 11:59:40', 1, 1, 0, 20.00),
(6, 'Principles of Compiler Design', 'principles-of-compiler-design', 3, '0-201-00022-9', 550.00, 10, '/storage/covers/1770189821_principles-of-compiler-design.jpg', 'A foundational book on compiler construction, explaining lexical analysis, parsing, code generation and optimization.', 'A foundational book on compiler construction, explaining lexical analysis, parsing, code generation and optimization.', '2026-02-04', 5, 1, NULL, NULL, '2026-02-04 01:23:41', '2026-02-04 01:23:41', 1, 1, 0, 0.00),
(7, 'Database Management', 'student-management-system', NULL, NULL, 5000.00, NULL, '/storage/covers/1770207681_database-management.jpg', 'A full-stack web application to manage student records, courses, and grades. Built with Laravel, MySQL, and Bootstrap.', 'A full-stack web application to manage student records, courses, and grades. Built with Laravel, MySQL, and Bootstrap.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:21:21', '2026-02-04 06:24:09', 9, 13, 5, 0.00),
(8, 'E-Commerce Website', 'e-commerce-website', NULL, NULL, 6000.00, NULL, '/storage/covers/1770208060_e-commerce-website.jpg', 'An online shopping platform with product listing, cart, checkout, and payment integration. Built with React, Node.js, and MongoDB.', 'An online shopping platform with product listing, cart, checkout, and payment integration. Built with React, Node.js, and MongoDB.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:27:40', '2026-02-04 06:27:40', 9, 14, 10, 0.00),
(9, 'Machine Learning Spam Classifier', 'ml-spam-classifier', NULL, NULL, 6000.00, NULL, '/storage/covers/1770208233_machine-learning-spam-classifier.jpg', 'A machine learning project to classify emails as spam or not spam using Python, Scikit-learn, and Natural Language Processing.', 'A machine learning project to classify emails as spam or not spam using Python, Scikit-learn, and Natural Language Processing.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:30:33', '2026-02-04 06:30:33', 9, 15, 12, 0.00),
(10, 'Library Management System', 'library-management-system', NULL, NULL, 2000.00, NULL, '/storage/covers/1770208324_library-management-system.jpg', 'A desktop or web application to manage library books, members, and issue/return process. Built with Java and MySQL.', 'A desktop or web application to manage library books, members, and issue/return process. Built with Java and MySQL.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:32:04', '2026-02-04 06:32:04', 9, 13, 15, 0.00),
(11, 'Face Recognition Attendance System', 'face-recognition-attendance', NULL, NULL, 3000.00, NULL, '/storage/covers/1770208405_face-recognition-attendance-system.jpg', 'A Python-based machine learning project using OpenCV to record student attendance via face recognition.', 'A Python-based machine learning project using OpenCV to record student attendance via face recognition.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:33:25', '2026-02-04 06:33:25', 9, 15, 10, 0.00),
(12, 'Online Quiz Application', 'online-quiz-application', NULL, NULL, 2000.00, NULL, '/storage/covers/1770208482_online-quiz-application.jpg', 'A web app for creating and taking quizzes with timer, scoring, and leaderboard. Built with React.js and Firebase.', 'A web app for creating and taking quizzes with timer, scoring, and leaderboard. Built with React.js and Firebase.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:34:43', '2026-02-04 06:34:43', 9, 14, 5, 0.00),
(13, 'Chat Application', 'chat-application', NULL, NULL, 2500.00, NULL, '/storage/covers/1770208587_chat-application.jpg', 'A real-time chat application with multiple rooms, private messaging, and notifications. Built with Node.js, Socket.io, and React.', 'A real-time chat application with multiple rooms, private messaging, and notifications. Built with Node.js, Socket.io, and React.', NULL, NULL, 1, NULL, NULL, '2026-02-04 06:35:47', '2026-02-04 06:36:27', 9, 14, 5, 0.00),
(14, 'রিয়াদুস সালিহিন', 'riyad-us-saliheen', NULL, NULL, 150.00, NULL, '/storage/covers/1770215272_rizadus-salihin.jpg', 'ইমাম নবাওয়ীর সংগ্রহ করা আদি হাদিসের একটি সম্পূর্ণ সংকলন।', '\"রিয়াদুস সালিহিন (Gardens of the Righteous) হলো হাদিসের একটি বিখ্যাত সংকলন, যা ইমাম নবাওয়ী রচনা করেছেন। এটি ইসলামী আচরণ, নৈতিকতা, ইবাদত এবং দৈনন্দিন জীবনের নির্দেশনা নিয়ে বিস্তারিতভাবে আলোচনা করে। শিক্ষার্থী, শিক্ষক ও আলেমরা এটি নৈতিক শিক্ষা ও আধ্যাত্মিক উন্নতির জন্য ব্যবহার করে থাকেন।\"', NULL, 6, 1, NULL, NULL, '2026-02-04 08:27:52', '2026-02-04 08:29:40', 5, 16, 2, 0.00),
(15, 'তাফসীর ইবন কাসীর', '/tafsir-ibn-kathir', 4, NULL, 200.00, NULL, '/storage/covers/1770216357_tafseer-ibn-kaseer.jpg', 'কুরআনের অন্যতম প্রামাণিক ও ব্যাপক তাফসীর।', 'তাফসীর ইবন কাসীর হলো ইবন কাসীর কর্তৃক লেখা একটি বিস্তৃত কুরআন ব্যাখ্যা। এটি আয়াতের প্রসঙ্গ, পটভূমি ও অর্থ বিস্তারিতভাবে ব্যাখ্যা করে। মুসলিম বিশ্বে এর প্রামাণিকতা ও স্পষ্টতার কারণে এটি খুবই সম্মানিত।', NULL, 6, 1, NULL, NULL, '2026-02-04 08:45:57', '2026-02-04 08:45:57', 5, 17, NULL, 0.00),
(16, 'ফোর্ট্রেস অফ দ্য মুসলিম', 'fortress-of-the-muslim', 5, NULL, 420.00, NULL, '/storage/covers/1770216504_fortres-of-dz-muslim.jpg', 'কুরআন ও হাদিস থেকে দৈনন্দিন দু‘আ-এর সংক্ষিপ্ত ও শক্তিশালী সংকলন।', 'ফোর্ট্রেস অফ দ্য মুসলিম হলো দৈনন্দিন ব্যবহারের জন্য সংক্ষিপ্ত দু‘আ এবং ইসলামের নির্দেশিত অন্যান্য প্রার্থনা। এটি মুসলিমদের দৈনন্দিন জীবন ও আধ্যাত্মিক সুরক্ষার জন্য গুরুত্বপূর্ণ।', NULL, 6, 1, NULL, NULL, '2026-02-04 08:48:24', '2026-02-04 08:51:50', 5, 19, 10, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `serial` int(11) NOT NULL DEFAULT 0,
  `homepage_serial` int(11) DEFAULT NULL,
  `is_homepage` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `serial`, `homepage_serial`, `is_homepage`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'University Books', 'university-books', 'University Books', 0, 1, 0, 1, '2026-01-26 10:54:08', '2026-02-02 09:45:25'),
(2, 'Writer', '/writer', 'writer', 0, 4, 0, 1, '2026-01-31 12:37:37', '2026-02-02 09:46:24'),
(3, 'Academic', 'academic', 'Educational and scholarly materials', 0, 3, 0, 1, '2026-01-31 13:27:01', '2026-02-02 09:46:08'),
(4, 'Fiction', '/fiction', 'Fiction', 0, 5, 0, 1, '2026-01-31 13:30:52', '2026-02-02 09:46:30'),
(5, 'Islamic', '/islamic-books', NULL, 0, 6, 0, 1, '2026-01-31 13:32:55', '2026-02-02 09:46:39'),
(6, 'Mystery & Thriller', 'mystery-thriller', 'Suspenseful stories with puzzles to solve', 0, 9, 0, 0, '2026-01-31 13:34:20', '2026-02-02 09:47:37'),
(7, 'Children\'s Books', 'childrens-books', 'Books for young readers', 0, 7, 0, 1, '2026-01-31 13:36:55', '2026-02-02 09:46:50'),
(8, 'E-Books', '/ebooks', 'E-Books', 0, 8, 0, 1, '2026-02-01 13:06:46', '2026-02-02 09:47:31'),
(9, 'University Project', '/university-project', 'nearbooks', 0, 2, 0, 1, '2026-02-01 13:19:45', '2026-02-02 09:47:18'),
(10, 'Assignment Help', '/assignment-help', 'assignment help', 3, 2, 1, 1, '2026-02-02 08:56:00', '2026-02-02 08:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `contact_infos`
--

CREATE TABLE `contact_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `faculty` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `faculty`, `description`, `created_at`, `updated_at`) VALUES
(1, 'computer science and engineering', 'CSE', 'Engineering', NULL, '2026-02-04 06:13:22', '2026-02-04 06:13:22');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `order_by` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `icon`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Menus', '/menus', 'fa-solid fa-bars', 100, 1, '2026-01-26 16:40:45', '2026-01-26 16:40:45'),
(2, 'Books', NULL, 'fa-solid fa-book', 2, 1, '2026-01-26 10:45:16', '2026-01-26 10:45:16'),
(3, 'Setting', '/site-logo', 'fa-solid fa-gear', 99, 1, '2026-01-30 00:20:25', '2026-01-30 00:20:25'),
(4, 'University', NULL, 'fas fa-university', 98, 1, '2026-02-04 04:58:57', '2026-02-04 04:59:11');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_07_081035_create_categories_table', 1),
(5, '2026_01_09_064415_create_menus_table', 1),
(6, '2026_01_09_064512_create_submenus_table', 1),
(7, '2026_01_14_072121_create_sub_categories_table', 1),
(8, '2026_01_14_073431_create_authors_table', 1),
(9, '2026_01_14_075010_create_books_table', 1),
(10, '2026_01_26_172148_create_publishers_table', 2),
(12, '2026_01_30_055618_create_site_logos_table', 3),
(13, '2026_01_30_080649_create_contact_infos_table', 4),
(14, '2026_01_30_082150_create_banners_table', 5),
(15, '2026_01_30_143254_create_top_navbar_table', 6),
(16, '2026_01_30_152628_create_personal_access_tokens_table', 7),
(17, '2026_02_02_143115_add_serial_homepage_to_categories_table', 7),
(18, '2026_02_04_110737_create_departments_table', 8);

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
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `name`, `slug`, `email`, `phone`, `address`, `website`, `logo`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Vernon', 'Proident aut simili', 'symyjosa@mailinator.com', '+1 (485) 235-1631', 'Sequi sed harum tota', 'https://www.nazytura.cm', 'Illo aspernatur proi', 'Consequatur volupta', 1, '2026-01-29 23:27:06', '2026-01-29 23:27:47'),
(2, 'Marshall', 'Placeat quasi eaque', 'hojitoz@mailinator.com', '+1 (547) 925-7932', 'Dicta sed ea quae ir', 'https://www.hynytynupejif.ws', 'storage/publishers/1769751851_marshall-duncan.jpg', 'Veniam quia qui min', 1, '2026-01-29 23:44:12', '2026-01-29 23:46:25'),
(3, 'MIT Press', 'mit-press', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-04 01:05:35', '2026-02-04 01:07:25'),
(4, 'Prentice Hall', 'Prentice-Hall', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-04 01:11:20', '2026-02-04 01:22:13'),
(5, 'Addison-Wesley', 'Addison-Wesley', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-04 01:15:21', '2026-02-04 01:22:06'),
(6, 'দারুস সালাম', 'দারুস সালাম', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-04 08:28:18', '2026-02-04 08:28:55'),
(7, 'আল-মাকতাবাহ আল-আসরিয়্যাহ', 'আল-মাকতাবাহ আল-আসরিয়্যাহ', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-02-04 08:43:39', '2026-02-04 08:43:39');

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
('5fA90fMh3ayrUxweYfLKx4WxEV44Dcsfgu7jStMV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSmExRnhkWk9NV3VJVDFCOHBINTZzRWl2ODUwbklXdm93YkZ1N3R4dyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3N1Yi1jYXRlZ29yaWVzLzEiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3N1Yi1jYXRlZ29yaWVzLzEiO3M6NToicm91dGUiO3M6MjA6InN1Yi1jYXRlZ29yaWVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770213115),
('7BPwhqHZtypJhKXTm4QskiRThCWdkIWP1dfp7zsz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEtyMmJBVlhlR0ZRYThJYm5kZGxsbXV5eVJrSVlwMkhtVDlEVzVxdSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Jvb2tzIjtzOjU6InJvdXRlIjtzOjExOiJib29rcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770227981),
('bBbY2XuBpyNQw3SARRMgyZK8TA0a0KjKpb9ezpM3', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidDV0a28yRFpSNlJpTG12VHBERkY2RkJzVUFrRm1WMXhEMmpTcmFQNSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Jvb2tzIjtzOjU6InJvdXRlIjtzOjExOiJib29rcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770316753),
('CckvXEs4luFV0X2hfMMwD5NjUVY445L0ZJvvxYMU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEd5MEJRR3hNdndUQ2JiR1U5SHYwZWdKeWkxeDdEdjRaWnlQU09ocSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770213118),
('e5boqIr19iGipntxxWQdEMgQnLfEbNHYzFxQK07z', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkRMR3NEVlg0dWJiV2pTeTJzR1laMUwySWRVaVZqMDNwWjAxdmVyYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXRlZ29yaWVzIjtzOjU6InJvdXRlIjtzOjE2OiJjYXRlZ29yaWVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1770227876);

-- --------------------------------------------------------

--
-- Table structure for table `site_logos`
--

CREATE TABLE `site_logos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_logos`
--

INSERT INTO `site_logos` (`id`, `logo_path`, `alt_text`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'storage/site-logo/1769754665_site_logo.png', 'NearBooks', 1, '2026-01-30 00:31:05', '2026-01-30 00:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE `submenus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `order_by` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submenus`
--

INSERT INTO `submenus` (`id`, `menu_id`, `name`, `url`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Categories', '/categories', 1, 1, '2026-01-26 10:51:02', '2026-01-26 10:51:02'),
(2, 2, 'Authors', '/authors', 2, 1, '2026-01-26 10:52:28', '2026-01-26 10:52:28'),
(3, 2, 'Books', '/books', 4, 1, '2026-01-26 10:52:54', '2026-01-26 11:18:50'),
(4, 2, 'Publisher', '/publishers', 3, 1, '2026-01-26 11:19:07', '2026-01-26 11:27:44'),
(5, 3, 'Site Logo', '/site-logo', 5, 1, '2026-01-30 00:21:03', '2026-01-30 00:21:03'),
(6, 3, 'Contact Info', '/contact-info', 2, 1, '2026-01-30 02:12:52', '2026-01-30 02:12:52'),
(7, 3, 'Banner', '/banners', 1, 1, '2026-01-30 02:26:04', '2026-01-30 02:26:04'),
(8, 3, 'Top Navbar Items', '/top-navbar', 3, 1, '2026-01-30 08:52:49', '2026-01-30 08:52:49'),
(9, 4, 'Semesters', '/semesters', 2, 1, '2026-02-04 05:00:15', '2026-02-04 05:02:34'),
(10, 4, 'Departments', '/departments', 1, 1, '2026-02-04 05:00:52', '2026-02-04 05:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'CSE', 'cse', 'computer science and & ENG', 1, '2026-01-26 10:54:52', '2026-01-26 10:54:52'),
(2, 1, 'EEE', '/eee', 'Electrical & Electronics Engineering', 1, '2026-01-31 12:36:12', '2026-01-31 12:36:12'),
(3, 1, 'BBA', '/bba', 'Bachelor of Business Administration', 1, '2026-01-31 12:36:39', '2026-01-31 12:36:39'),
(4, 2, 'William Shakespeare', '/William-Shakespeare', 'William Shakespeare', 1, '2026-01-31 12:40:07', '2026-01-31 12:40:07'),
(5, 2, 'Taylor Otwell', '/laravel-framework-overview', 'An overview of the Laravel framework, explaining its core features, philosophy, and why it is widely used for modern web application development.', 1, '2026-01-31 12:40:43', '2026-01-31 12:40:43'),
(6, 3, 'Textbooks', 'textbooks', 'Educational books for students', 1, '2026-01-31 13:28:02', '2026-01-31 13:28:02'),
(7, 3, 'Reference', 'reference', 'Dictionaries, encyclopedias, and guides', 1, '2026-01-31 13:28:16', '2026-01-31 13:28:16'),
(8, 3, 'Research Papers', 'research-papers', 'Academic research and studies', 1, '2026-01-31 13:29:34', '2026-01-31 13:29:34'),
(9, 4, 'Literary Fiction', 'literary-fiction', 'Character-driven stories with artistic merit', 1, '2026-01-31 13:31:25', '2026-01-31 13:31:25'),
(10, 7, 'Picture Books', 'picture-books', 'Illustrated stories for young children', 1, '2026-01-31 13:37:29', '2026-01-31 13:37:29'),
(11, 8, 'CSE', '/university/cse', 'jlfsa', 1, '2026-02-01 13:07:29', '2026-02-01 13:07:29'),
(13, 9, 'Database Management', 'database-management', NULL, 1, '2026-02-04 06:17:21', '2026-02-04 06:17:21'),
(14, 9, 'Web Development', 'web-development', NULL, 1, '2026-02-04 06:25:05', '2026-02-04 06:25:05'),
(15, 9, 'Machine Learning', 'machine-learning', NULL, 1, '2026-02-04 06:29:02', '2026-02-04 06:29:02'),
(16, 5, 'হাদিস', '/hadid', NULL, 1, '2026-02-04 07:49:05', '2026-02-04 08:11:58'),
(17, 5, 'তাফসীর', '/tafsir', NULL, 1, '2026-02-04 07:49:22', '2026-02-04 08:12:05'),
(18, 5, 'দোয়া', '/dua', NULL, 1, '2026-02-04 07:49:37', '2026-02-04 08:12:10'),
(19, 5, 'আধ্যাত্মিকতা', '/আধ্যাত্মিকতা', NULL, 1, '2026-02-04 07:49:58', '2026-02-04 07:49:58'),
(21, 5, 'ইমাম নবাওয়ী, মুহাম্মদ ফারুক', 'ইমাম নবাওয়ী, মুহাম্মদ ফারুক', NULL, 0, '2026-02-04 08:25:12', '2026-02-04 08:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `top_navbar`
--

CREATE TABLE `top_navbar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `top_navbar`
--

INSERT INTO `top_navbar` (`id`, `name`, `label`, `url`, `is_active`, `position`, `created_at`, `updated_at`) VALUES
(1, 'title', 'Welcome To Nearbook', '/', 1, 1, '2026-01-30 08:54:32', '2026-01-30 08:55:19'),
(2, 'Track', 'Track Your Order', '/track-your-order', 1, 2, '2026-01-30 09:37:00', '2026-01-30 09:41:11'),
(3, 'Entrepreneur', 'Nearbook Entrepreneur', '/nearbook-entrepreneur', 1, 3, '2026-01-30 09:41:56', '2026-01-30 09:42:08'),
(4, 'Donation', 'Book Donation', '/book-donation', 1, 4, '2026-01-30 09:42:45', '2026-01-30 09:42:45');

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'a@gmail.com', NULL, '$2y$12$vhIipBt3NZdnvvsXiqOMeO9dPrZHj7X4jevoJsz5H/L4JSFgh/PDa', 'tNc7LweK5OYwua0Ve3pmLa2w5zxhTb80K1pg54WvF4BO4zHSHuIh7suGk4uJ', '2026-01-26 10:36:35', '2026-01-26 10:36:35'),
(2, 'Venus Dixon', 'heparu@mailinator.com', NULL, '$2y$12$Den0Pm4OnBZvmdjzVM3NBueJx5qyX7x6oFtwunotk0r./7bWUssaS', NULL, '2026-02-04 06:10:37', '2026-02-04 06:10:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `authors_slug_unique` (`slug`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_slug_unique` (`slug`),
  ADD KEY `books_author_id_foreign` (`author_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `contact_infos`
--
ALTER TABLE `contact_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `publishers_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_logos`
--
ALTER TABLE `site_logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submenus_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_slug_unique` (`slug`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `top_navbar`
--
ALTER TABLE `top_navbar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `top_navbar_name_unique` (`name`);

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
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_infos`
--
ALTER TABLE `contact_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `site_logos`
--
ALTER TABLE `site_logos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `submenus`
--
ALTER TABLE `submenus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `top_navbar`
--
ALTER TABLE `top_navbar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submenus`
--
ALTER TABLE `submenus`
  ADD CONSTRAINT `submenus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
