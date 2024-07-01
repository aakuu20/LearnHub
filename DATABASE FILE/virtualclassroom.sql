-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2021 at 07:18 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtualclassroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `courseCode`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(175, 'copy that!', 'ca101_a', 'lue_worley', 'liam_moore', '2021-06-21 20:23:50', 'no', 651),
(176, 'demo comment!', 'ca101_a', 'stephanie_carter', 'liam_moore', '2021-06-28 23:07:57', 'no', 654),
(177, 'this is a demo comment from a student', 'ca101_a', 'stephanie_carter', 'liam_moore', '2021-06-28 23:08:18', 'no', 653),
(179, 'updated*', '', 'liam_moore', '', '2021-06-28 23:11:38', 'no', 655);

-- --------------------------------------------------------

--
-- Table structure for table `createclass`
--

CREATE TABLE `createclass` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `section` varchar(25) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `num_posts` int(11) NOT NULL,
  `student_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `createclass`
--

INSERT INTO `createclass` (`id`, `username`, `className`, `section`, `subject`, `courseCode`, `date`, `num_posts`, `student_array`) VALUES
(104, 'liam_moore', 'CA101', 'A', 'Databases', 'ca101_a', '2021-06-20', 0, 'will_williams ,luz_haynes ,lue_worley ,ben_shaw ,stephanie_carter ,'),
(105, 'liam_moore', 'CA10220', 'B', 'ApplicationDesign', 'ca10220_b', '2021-06-28', 0, 'will_williams ,luz_haynes ,ben_shaw ,'),
(106, 'liam_moore', 'CA2069', 'A', 'SoftwareEngineering', 'ca2069_a', '2021-06-28', 0, 'will_williams ,luz_haynes ,lue_worley ,ben_shaw ,'),
(107, 'liam_moore', 'CA6978', 'B', 'CyberSecurity', 'ca6978_b', '2021-06-28', 0, 'stephanie_carter ,');

-- --------------------------------------------------------

--
-- Table structure for table `joinclass`
--

CREATE TABLE `joinclass` (
  `user_id_fk` int(11) NOT NULL,
  `class_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `joinclass`
--

INSERT INTO `joinclass` (`user_id_fk`, `class_id_fk`) VALUES
(64, 0),
(65, 0),
(65, 104),
(65, 105),
(65, 106),
(66, 104),
(66, 105),
(66, 106),
(67, 104),
(67, 107),
(68, 104),
(68, 106),
(69, 104),
(69, 105),
(69, 106);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opended` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opended`, `viewed`) VALUES
(42, 'liam_moore', 'lue_worley', 'Lue Worley commented on your post', 'post.php?id=651', '2021-06-21 22:23:50', 'no', 'no'),
(43, 'liam_moore', 'stephanie_carter', 'Stephanie Carter commented on your post', 'post.php?id=654', '2021-06-28 23:07:57', 'no', 'no'),
(44, 'liam_moore', 'stephanie_carter', 'Stephanie Carter commented on your post', 'post.php?id=653', '2021-06-28 23:08:18', 'no', 'no'),
(45, 'liam_moore', 'stephanie_carter', 'Stephanie Carter posted on your class room', 'post.php?id=', '2021-06-28 23:08:44', 'no', 'no'),
(46, 'stephanie_carter', 'liam_moore', 'Liam Moore commented on your post', 'post.php?id=655', '2021-06-28 23:11:26', 'no', 'no'),
(47, '', 'liam_moore', 'Liam Moore commented on your post', 'post.php?id=655', '2021-06-28 23:11:38', 'no', 'no'),
(48, '', 'liam_moore', 'Liam Moore commented on your class room post', 'post.php?id=655', '2021-06-28 23:11:38', 'no', 'no'),
(49, 'liam_moore', 'stephanie_carter', 'Stephanie Carter posted on your class room', 'post.php?id=', '2021-06-28 23:12:24', 'no', 'no'),
(50, 'liam_moore', 'ben_shaw', 'Ben Shaw posted on your class room', 'post.php?id=', '2021-06-28 23:14:52', 'no', 'no'),
(51, 'liam_moore', 'stephanie_carter', 'Stephanie Carter posted on your class room', 'post.php?id=', '2021-06-28 23:15:14', 'no', 'no'),
(52, 'liam_moore', 'luz_haynes', 'Luz Haynes posted on your class room', 'post.php?id=', '2021-06-28 23:16:47', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `edited` varchar(3) NOT NULL,
  `files` varchar(500) DEFAULT NULL,
  `fileDestination` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `courseCode`, `user_to`, `date_added`, `user_closed`, `edited`, `files`, `fileDestination`) VALUES
(651, 'this is to announce you that your online classes will start from 22nd June. please be on time :)', 'liam_moore', 'ca101_a', 'none', '2021-06-20 18:18:50', 'no', 'no', 'none', 'none'),
(652, 'Sample Questions', 'liam_moore', 'ca101_a', 'none', '2021-06-25 21:03:58', 'no', 'no', ' 60d9e4ded24d12.08285662.pdf', 'uploads/sample. 60d9e4ded24d12.08285662.pdf'),
(653, 'this is a demo post for the students!', 'liam_moore', 'ca101_a', 'none', '2021-06-28 23:04:33', 'no', 'no', 'none', 'none'),
(654, 'Coursework 01, Due: August 03 Please download the attachment below!', 'liam_moore', 'ca101_a', 'none', '2021-06-28 23:05:34', 'no', 'no', ' 60da015e796f09.87969671.pdf', 'uploads/samplecw. 60da015e796f09.87969671.pdf'),
(656, 'demo post', 'stephanie_carter', 'ca6978_b', 'liam_moore', '2021-06-28 23:12:24', 'no', 'no', 'none', 'none'),
(657, 'dummy post from student account1', 'ben_shaw', 'ca101_a', 'liam_moore', '2021-06-28 23:14:52', 'no', 'no', 'none', 'none'),
(658, 'dummy post from student account2', 'stephanie_carter', 'ca101_a', 'liam_moore', '2021-06-28 23:15:14', 'no', 'no', 'none', 'none'),
(659, 'working format has been provided below:', 'luz_haynes', 'ca101_a', 'liam_moore', '2021-06-28 23:16:47', 'no', 'no', ' 60da03ff308b19.66538301.pdf', 'uploads/fmsamplecw. 60da03ff308b19.66538301.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `phoneNumber` int(50) NOT NULL,
  `bio` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `profilePic`, `signup_date`, `user_closed`, `num_posts`, `phoneNumber`, `bio`) VALUES
(64, 'Liam', 'Moore', 'liam_moore', 'liamoore@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profilePics/liam_moore1de7c6df4947a3d7ce3f7fe21aed86ecn.jpeg', '2021-06-20', 'no', 0, 2147483647, 'I am ready to learn. Thatâ€™s why I became a teacher.'),
(65, 'Will', 'Williams', 'will_williams', 'williams@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profilePics/deafultPP.png', '2021-06-20', 'no', 0, 0, ''),
(66, 'Luz', 'Haynes', 'luz_haynes', 'luz@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profilePics/deafultPP.png', '2021-06-20', 'no', 0, 0, ''),
(67, 'Stephanie', 'Carter', 'stephanie_carter', 'carter@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profilePics/stephanie_carter3a688342df54642ce2aa1e5b612f8b09n.jpeg', '2021-06-28', 'no', 0, 2147483647, 'none'),
(68, 'Lue', 'Worley', 'lue_worley', 'lue@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profilePics/deafultPP.png', '2021-06-28', 'no', 0, 2147483647, 'Demons in my head'),
(69, 'Ben', 'Shaw', 'ben_shaw', 'ben@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'assets/images/profilePics/deafultPP.png', '2021-06-28', 'no', 0, 2147483647, 'Nothing at the moment');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `createclass`
--
ALTER TABLE `createclass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `joinclass`
--
ALTER TABLE `joinclass`
  ADD PRIMARY KEY (`user_id_fk`,`class_id_fk`),
  ADD KEY `user_id_fk` (`user_id_fk`),
  ADD KEY `class_id_fk` (`class_id_fk`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
--
-- AUTO_INCREMENT for table `createclass`
--
ALTER TABLE `createclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=660;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
