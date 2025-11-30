-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2025 at 02:49 PM
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
-- Database: `Destist2`
--

-- --------------------------------------------------------

--
-- Table structure for table `Appointment`
--

CREATE TABLE `Appointment` (
  `AppointmentID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `DentistID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL,
  `AvailabilityID` int(11) NOT NULL,
  `AppointmentDateTime` datetime NOT NULL,
  `Status` enum('Booked','Completed','Cancelled') DEFAULT 'Booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Appointment`
--

INSERT INTO `Appointment` (`AppointmentID`, `PatientID`, `DentistID`, `ServiceID`, `AvailabilityID`, `AppointmentDateTime`, `Status`) VALUES
(37, 32, 2, 5, 24, '2025-11-05 10:00:00', 'Booked'),
(38, 33, 2, 5, 25, '2025-11-07 14:00:00', 'Booked'),
(39, 34, 3, 3, 26, '2025-11-06 08:30:00', 'Booked'),
(43, 36, 3, 6, 27, '2025-11-08 13:00:00', 'Booked'),
(44, 36, 10, 2, 40, '2025-11-15 12:00:00', 'Booked'),
(45, 33, 6, 2, 32, '2025-11-12 09:00:00', 'Booked'),
(46, 38, 6, 2, 33, '2025-11-14 13:00:00', 'Booked'),
(54, 39, 2, 3, 24, '2025-11-05 10:00:00', 'Booked'),
(55, 43, 10, 1, 41, '2025-11-18 14:00:00', 'Booked'),
(58, 45, 8, 1, 36, '2025-11-15 08:00:00', 'Booked'),
(59, 46, 8, 1, 36, '2025-11-15 08:00:00', 'Booked'),
(60, 47, 8, 1, 37, '2025-11-17 10:00:00', 'Booked'),
(61, 47, 10, 2, 40, '2025-11-15 12:00:00', 'Booked'),
(62, 47, 3, 3, 26, '2025-11-06 08:30:00', 'Booked'),
(63, 48, 2, 5, 24, '2025-11-05 10:00:00', 'Booked'),
(64, 49, 10, 1, 41, '2025-11-18 14:00:00', 'Booked'),
(65, 50, 2, 5, 24, '2025-11-05 10:00:00', 'Booked');

-- --------------------------------------------------------

--
-- Table structure for table `Dentist`
--

CREATE TABLE `Dentist` (
  `DentistID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Specialization` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Detail` text DEFAULT NULL,
  `Image` varchar(255) DEFAULT 'default-doctor.jpg',
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Dentist`
--

INSERT INTO `Dentist` (`DentistID`, `FullName`, `Specialization`, `Phone`, `Email`, `Detail`, `Image`, `UserID`) VALUES
(2, 'Dr. Emily Johnson', 'Orthodontics, Dental Check-ups', '0401000002', 'emily.johnson@dentclinic.com', 'Orthodontics and dental check-ups work together to support long-term oral health by ensuring that teeth are properly aligned and continuously monitored for early signs of concern. Orthodontic care focuses on correcting alignment issues such as crowding, spacing, and bite irregularities using braces, clear aligners, and other modern treatments that improve both function and appearance. Regular dental check-ups complement this by providing routine examinations, professional cleanings, and preventative assessments that detect potential problems early, maintain gum health, and keep the teeth strong throughout treatment. Combined, these services create a healthy foundation for a confident, well-aligned smile.', 'images/Emily_Johnson.png', 15),
(3, 'Dr. Benedict Sloan', 'Endodontics', '0401000003', 'michael.lee@dentclinic.com', 'Endodontic services focus on diagnosing and treating issues related to the dental pulp and inner tooth structures. Specializing in root canal therapy and emergency dental pain treatment, Dr. Lee uses advanced techniques to relieve discomfort, preserve natural teeth, and restore oral health. His calm and precise approach ensures that even urgent or complex cases are handled with exceptional care and minimal stress. Whether you\'re experiencing sudden pain or require targeted endodontic treatment, Dr. Michael Lee provides reliable, compassionate care to help you recover comfortably and quickly.', 'images/DrBenedictSloan1.png', NULL),
(4, 'Dr. April Kepner', 'Pediatric Dentistry,Nutrition Guidance', '0401000004', 'sarah.nguyen@dentclinic.com', 'Nutrition Guidance is an important part of Pediatric Dentistry, helping children develop healthy eating habits that support strong teeth, proper jaw development, and long-term oral wellness. Because a child’s diet plays a major role in preventing cavities, strengthening enamel, and supporting gum health, this service focuses on educating families about the best nutritional choices for growing smiles.\r\nDuring a nutrition consultation, the dentist explains how certain foods and drinks can impact a child’s oral health. Parents receive guidance on reducing sugary snacks, limiting acidic beverages, and promoting tooth-friendly foods such as dairy products, fresh fruits, vegetables, lean proteins, and whole grains. The dentist also addresses common concerns, including bottle-feeding practices, snacking frequency, and managing picky eating.\r\nThis service helps families understand the connection between nutrition and dental health, empowering them to make daily choices that prevent early childhood cavities, gum problems, and enamel erosion. Proper nutrition supports not only a healthier mouth but also overall growth and development.', 'images/AprilKepner.jpg', NULL),
(5, 'Dr. David Brown', 'Periodontics', '0401000005', 'david.brown@dentclinic.com', 'Periodontic care focused on protecting the health of your gums and supporting long-term oral stability. Experienced in gum disease treatment and dental implant support, Dr. Brown uses advanced diagnostic and therapeutic techniques to manage periodontal conditions at every stage. His precise and patient-centred approach helps restore gum health, prevent future complications, and ensure strong foundations for dental implants. With Dr. Brown’s expertise, patients receive effective, evidence-based care tailored to their individual needs.', 'images/David_Brown.png', NULL),
(6, 'Dr. Olivia Wilson', 'Cosmetic Dentistry, Cleaning', '0401000006', 'olivia.wilson@dentclinic.com', 'Professional dental cleaning is an essential component of Cosmetic Dentistry, helping patients achieve a brighter, healthier, and more attractive smile. This procedure goes beyond everyday brushing and flossing by removing plaque, tartar, and surface stains that accumulate over time and affect the appearance of the teeth.\r\nDuring a cosmetic-focused cleaning, the dentist or hygienist uses specialized tools to thoroughly clean all surfaces of the teeth, including areas that are hard to reach at home. The process typically includes plaque and tartar removal, deep cleaning along the gumline, polishing to eliminate minor stains, and fluoride application for added protection. These steps help restore the natural shine of the teeth, improve gum health, and create a smooth, clean surface that enhances the overall aesthetics of the smile.\r\nCosmetic cleanings not only improve appearance but also support better oral health by preventing issues such as cavities, bad breath, and gum inflammation. Patients often notice immediate improvements, including a fresher feeling in the mouth and a visibly brighter smile.\r\n', 'images/Olivia_Wilson.png', 16),
(7, 'Dr. Richard Attam', 'Oral Surgery, Laboratory Works', '0401000007', 'daniel.kim@dentclinic.com', 'Laboratory Works play a crucial role in the success of Oral Surgery, providing the precise diagnostic information and custom-fabricated components needed for accurate treatment planning and predictable surgical outcomes. These behind-the-scenes processes support a wide range of surgical procedures by ensuring every step is guided by detailed, reliable data.\r\nAs part of this service, advanced laboratory techniques are used to analyze tissue samples, create accurate dental impressions, and develop 3D models of the patient’s oral structures. These models help in planning extractions, implant placements, bone grafts, and corrective surgeries with exceptional precision. Laboratory teams also fabricate custom surgical guides, dental prosthetics, crowns, bridges, and implant components that align perfectly with the patient’s anatomy.\r\nWorking closely with the surgical team, dental laboratories ensure that every restoration or appliance used during surgery is crafted to high clinical standards, contributing to improved healing, function, and aesthetics. Their work supports accurate diagnoses, minimizes complications, and allows for a smoother and more comfortable surgical experience.', 'images/RichardAttam1.png', NULL),
(8, 'Dr. Sophia Martinez', 'General Dentistry, X-Rays', '0401000008', 'sophia.martinez@dentclinic.com', 'Dental X-Rays are an essential part of modern General Dentistry, allowing for a deeper and more accurate understanding of a patient’s oral health. These diagnostic images help reveal conditions that are not visible during a standard visual examination, making them crucial for early detection and effective treatment planning.\r\nAs part of this service, the dentist uses safe, low-radiation imaging technology to capture detailed pictures of the teeth, gums, jawbone, and surrounding structures. X-Rays can identify hidden cavities, impacted teeth, bone loss, infections, developmental issues, cysts, and abnormalities long before they cause noticeable symptoms. This allows the dentist to address problems early, prevent complications, and maintain long-term oral health.\r\nDuring the procedure, the patient is comfortably positioned while digital sensors or traditional films capture the images. The dentist then carefully reviews the results, explains the findings, and recommends any necessary treatment or preventive steps. Dental X-Rays are quick, painless, and an important tool for monitoring changes over time, ensuring that every patient receives precise and personalized care.', 'images/Sophia_Martinez.png', NULL),
(9, 'Dr. Andrew Garcia', 'Orthodontics', '0401000009', 'andrew.garcia@dentclinic.com', 'Orthodontic care focus on creating well-aligned, confident smiles through modern and precise treatment methods. A certified orthodontist skilled in braces and digital orthodontics, Dr. Garcia uses the latest technology to deliver personalised solutions that improve both function and aesthetics. His patient-centred approach ensures clear communication, comfortable treatment experiences, and exceptional results for patients of all ages. With Dr. Garcia’s expertise, every smile transformation is guided with accuracy, care, and innovation.', 'images/Andrew_Garcia.png', NULL),
(10, 'Dr. Johanna Grey', 'Prosthodontics', '0401000010', 'johanna.grey@dentclinic.com', 'A highly skilled specialist in Prosthodontics, dedicated to restoring and enhancing the function, comfort, and aesthetics of the smile. With advanced training in dental prosthetics, this professional focuses on diagnosing and treating complex cases involving missing, damaged, or worn teeth. A meticulous and detail-oriented approach ensures restorations that improve both oral health and appearance.\r\nExpertise includes designing and placing dental crowns, bridges, veneers, dentures, and implant-supported restorations. Each prosthetic device is crafted to fit comfortably, function properly, and blend naturally with the patient’s existing teeth. Using modern digital tools, high-quality materials, and evidence-based techniques, results are tailored, durable, and aesthetic.\r\nIn addition to restorative treatments, comprehensive assessments of bite alignment, jaw function, and facial structure are performed to support long-term oral stability. A patient-centered approach ensures comfort, clear communication, and outcomes that restore confidence and quality of life.', 'images/Johanna_Grey1.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Dentist_Availability`
--

CREATE TABLE `Dentist_Availability` (
  `AvailabilityID` int(11) NOT NULL,
  `DentistID` int(11) NOT NULL,
  `AvailableDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Status` enum('Available','Not Available') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Dentist_Availability`
--

INSERT INTO `Dentist_Availability` (`AvailabilityID`, `DentistID`, `AvailableDate`, `StartTime`, `EndTime`, `Status`) VALUES
(24, 2, '2025-11-05', '10:00:00', '13:00:00', 'Not Available'),
(25, 2, '2025-11-07', '14:00:00', '17:00:00', 'Available'),
(26, 3, '2025-11-06', '08:30:00', '11:30:00', 'Available'),
(27, 3, '2025-11-08', '13:00:00', '16:00:00', 'Available'),
(30, 5, '2025-11-06', '10:00:00', '12:30:00', 'Available'),
(31, 5, '2025-11-10', '14:00:00', '17:00:00', 'Available'),
(32, 6, '2025-11-12', '09:00:00', '12:00:00', 'Available'),
(33, 6, '2025-11-14', '13:00:00', '16:00:00', 'Available'),
(34, 7, '2025-11-13', '11:00:00', '15:00:00', 'Available'),
(35, 7, '2025-11-19', '14:00:00', '17:00:00', 'Available'),
(36, 8, '2025-11-15', '08:00:00', '11:00:00', 'Available'),
(37, 8, '2025-11-17', '10:00:00', '13:00:00', 'Available'),
(38, 8, '2025-11-18', '09:00:00', '12:00:00', 'Available'),
(39, 9, '2025-11-16', '13:00:00', '16:00:00', 'Available'),
(40, 10, '2025-11-15', '12:00:00', '15:00:00', 'Available'),
(41, 10, '2025-11-18', '14:00:00', '17:00:00', 'Available'),
(42, 10, '2025-11-20', '09:00:00', '12:00:00', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `Dentist_Service`
--

CREATE TABLE `Dentist_Service` (
  `DentistServiceID` int(11) NOT NULL,
  `DentistID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Dentist_Service`
--

INSERT INTO `Dentist_Service` (`DentistServiceID`, `DentistID`, `ServiceID`) VALUES
(26, 2, 5),
(27, 2, 4),
(28, 3, 3),
(29, 3, 6),
(33, 5, 2),
(34, 5, 5),
(35, 6, 2),
(36, 6, 4),
(37, 7, 2),
(38, 7, 3),
(39, 8, 1),
(40, 8, 2),
(41, 9, 5),
(42, 9, 4),
(43, 10, 1),
(44, 10, 2),
(47, 4, 2),
(48, 4, 5),
(49, 4, 4),
(50, 4, 1),
(56, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `PatientID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Patient`
--

INSERT INTO `Patient` (`PatientID`, `FullName`, `Phone`, `Email`, `DOB`, `Postcode`, `UserID`) VALUES
(32, 'rita', '', 'abc2@gmail.com', NULL, NULL, 3),
(33, 'lala', '', 'rita.huynh@my.jcu.edu.au', NULL, NULL, 8),
(34, '', '', '', NULL, NULL, NULL),
(35, '', '', '', NULL, NULL, NULL),
(36, 'tina', '902679902', '1@a', NULL, '7000', NULL),
(37, 'lala', '902679902', 'rita.huynh@my.jcu.edu.au', NULL, NULL, 8),
(38, 'TI', '902679902', '23@gmail.com', NULL, NULL, 16),
(39, 'rita', '902679902', 'abc1@gmail.com', NULL, '7000', NULL),
(40, 'rita', '902679902', 'abc1234@gmail.com', NULL, NULL, 17),
(41, 'rita huynh', '902679902', 'ithuynhlang.2017@gmail.com', NULL, NULL, 19),
(42, '2 rita', '902679902', '1@gmail.com', NULL, NULL, 21),
(43, 'huynh ', '902679902', '2@gmail.com', NULL, '4004', NULL),
(45, 'TEST 1 ', '902679902', 'rita@gmail.com', NULL, '7000', 23),
(46, 'rita test ', NULL, '3@gmail.com', NULL, NULL, NULL),
(47, 'rita test2', NULL, '4@gmail.com', NULL, NULL, NULL),
(48, 'rita test4', '902679902', 'a1@gmail.com', NULL, '2323', 26),
(49, 'nikhil sakkeer', '422602815', 'nikhilsakkeer75580@gmail.com', NULL, '4006', 28),
(50, 'Rita huynh', '902679902', 'a12@gmail.com', NULL, '7000', 29);

-- --------------------------------------------------------

--
-- Table structure for table `Service`
--

CREATE TABLE `Service` (
  `ServiceID` int(11) NOT NULL,
  `ServiceName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `image` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Service`
--

INSERT INTO `Service` (`ServiceID`, `ServiceName`, `Description`, `Price`, `image`) VALUES
(1, 'Physical Examination', 'A physical examination is a routine clinical assessment where the doctor evaluates your overall health by checking vital signs, examining the body, and identifying any signs of illness or abnormalities. This assessment may include checking the heart, lungs, abdomen, skin, muscles, and joints, as well as reviewing medical history and symptoms.\r\nPhysical examinations help detect health issues early, guide diagnosis, and ensure appropriate treatment or follow-up care. They are an essential part of maintaining long-term wellness and monitoring your general health condition.', 120.00, 'images/AdobeStock_537857878.jpeg'),
(2, 'Dental Check-ups', 'Dental check-ups are routine examinations that help monitor the health of your teeth and gums. During the visit, the dentist assesses for cavities, gum disease, oral hygiene concerns, and early signs of other dental issues. These appointments often include a gentle cleaning, patient education, and personalised recommendations to maintain a healthy smile.\r\nRegular dental check-ups—typically every six months—help prevent problems before they become serious, ensuring long-term oral health and overall wellbeing.', 200.00, 'images/AdobeStock_71839952.jpeg'),
(3, 'X-Rays', 'Dental X-rays are diagnostic images used to detect issues that cannot be seen during a regular examination. They help identify cavities, infections, bone loss, impacted teeth, and other hidden dental concerns early. Modern digital X-rays use very low radiation and provide clear, detailed images that assist the dentist in accurate diagnosis and effective treatment planning.', 950.00, 'images/AdobeStock_454644101.jpeg'),
(4, 'Cleaning', 'Dental cleaning is a preventive procedure that removes plaque, tartar, and surface stains from the teeth to maintain healthy gums and a bright smile. It includes thorough scaling to eliminate buildup in hard-to-reach areas and polishing to smooth the tooth surfaces, helping prevent future plaque accumulation. Regular cleanings support fresher breath, reduced risk of cavities, and overall improved oral health.', 400.00, 'images/AdobeStock_244031852.jpeg'),
(5, 'Nutrition Guidance', 'Nutrition guidance provides personalised advice to help patients make healthier food choices that support overall wellbeing and oral health. During the consultation, the practitioner reviews dietary habits, identifies areas for improvement, and offers practical recommendations to reduce sugar intake, strengthen teeth, and promote balanced nutrition.\r\nThis service helps patients understand how diet affects both general and dental health, encouraging long-term healthy habits and improved lifestyle outcomes.', 3500.00, 'images/AdobeStock_372290824.jpeg'),
(6, 'Laboratory Works', 'Laboratory works involve the creation and refinement of custom dental appliances and restorations, such as crowns, bridges, dentures, veneers, and orthodontic devices. Using precise measurements and advanced materials, dental technicians ensure each piece is crafted to fit comfortably and function naturally for the patient.\r\nThese lab services play a crucial role in achieving accurate results, long-lasting durability, and high-quality aesthetic outcomes for a wide range of dental treatments.\r\n', 450.00, 'images/AdobeStock_3Dteeth.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `Phone` int(12) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `Postcode` varchar(4) NOT NULL,
  `Role` enum('Patient','Dentist') NOT NULL DEFAULT 'Patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Phone`, `Email`, `Password`, `Postcode`, `Role`) VALUES
(1, 'rita', 401000001, 'abc@gmail.com', '123', '', 'Patient'),
(3, 'rita', 902679902, 'abc2@gmail.com', '$2y$10$9lzhI.O5Qdi7yh9Y7J0t4OE99909LWr4.Lma7Yn.40LS5l8TtDoz2', '7000', 'Patient'),
(5, 'rita', 902679902, 'abc5@gmail.com', '$2y$10$d1K3a1myx1zSqf78sH9Q6OgUM0nwE3AXTS9wwblrMrRS9S68KTZ6m', '7000', 'Patient'),
(6, 'rita', 902679902, 'abc12@gmail.com', '$2y$10$t5yEoYpleeXb/laeygCh.uC6lBntZO4PVJ6aBnzRv/ZMPDGAET6rS', '7000', 'Patient'),
(7, 'rita', 902679902, 'abc122@gmail.com', '$2y$10$9Qq3UgVtDErjRl5hWta1HOkk7l80VIjN/.bfBSKaleZ/gQOSwXQrC', '7000', 'Patient'),
(8, 'lala', 902679902, 'rita.huynh@my.jcu.edu.au', '$2y$10$LPibMFSR6O2FyQHLeZZjN.azSHZZtzNCoznC7XFeZv7GySiaXGnuW', '7000', 'Patient'),
(9, 'tina', 902679902, '1@a', '$2y$10$NWU/PXW6y77H284HHxCwae.f7I/pu58ujWagn0a8EXzIzGvFlI2mu', '7000', 'Patient'),
(15, 'rita', 902679902, 'abc1@gmail.com', '$2y$10$ISWhw7SahB1DFZUyFzSu8e3H3be.nfvdHlMPf61PXDOAPG.MJukhO', '7000', 'Dentist'),
(16, 'TI', 902679902, '23@gmail.com', '$2y$10$c6GJxWy7XwSgKBvDLa/M/.Ul.gxnfO.OYPfOzgtJAqdNO85.isgka', '7000', 'Dentist'),
(17, 'rita', 902679902, 'abc1234@gmail.com', '$2y$10$c9CDugabwca1nNGRwqYsvOxTnjzsSKGQOvqEzhvCqLgI3T3xmU25G', '7000', 'Patient'),
(18, 'rita', 912323121, 'abc7878@gmail.com', '$2y$10$m8S6Zj4/7ES.WW1U4R1e6.qJUXFkc6IS6gqV1gQRoacynI7pjV0LK', '7000', 'Patient'),
(19, 'rita huynh', 902679902, 'ithuynhlang.2017@gmail.com', '$2y$10$JUViSt/v.9ez/yFjwO2r7OVClJRWmtT462NL0CyMPZzbTMTqTjjkq', '5000', 'Patient'),
(21, '2 rita', 902679902, '1@gmail.com', '$2y$10$zqhs6vqtIQMdHfCa/F8r..AtPFRt6CdBIwRIoIWS6kGpspbg3fjUi', '0044', 'Patient'),
(22, 'huynh ', 902679902, '2@gmail.com', '$2y$10$iMRADUAM/pTpSLJOB2qe0uUsHOkGA6U.KPi/mxm.qZQTVQc9u5nfm', '4004', 'Patient'),
(23, 'TEST 1 ', 902679902, 'rita@gmail.com', '$2y$10$z0C/uHMjEW7R6n1XNSXGZur/fxQ33k9hIDBFeAWbfFAaoD4muFyXW', '7000', 'Patient'),
(24, 'rita test ', 902679902, '3@gmail.com', '$2y$10$d5HqgNNmD9.LAN0zCIN0Ae3y3j4KYSMzE6WDLytOxMFa6rquS9Tgi', '1232', 'Patient'),
(25, 'rita test2', 902679902, '4@gmail.com', '$2y$10$ZC/AhdzeoP4s38PbimEm.OPdxqSFHSy30CRsZIae1djmgllxz7zp6', '6000', 'Patient'),
(26, 'rita test4', 902679902, 'a1@gmail.com', '$2y$10$x/y9U32sAjvtHMxL81ld4.JXJPuwC7LuZmg7l.NH0V4vVL3fnoBhy', '2323', 'Patient'),
(27, 'dfdfdfdf dfsf. fdfdf df ffd f', 902679902, '55@gmail.com', '$2y$10$ADv54JH67kQjMt5JLxGuhuUbQx9NtyWThxNPAGFCNDKy97gdG83e6', '7000', 'Patient'),
(28, 'nikhil sakkeer', 422602815, 'nikhilsakkeer75580@gmail.com', '$2y$10$6ACNKsmxIvMztgRFKRvWueM0aweZQ5Q1qPoc70ga/pzT7CeZUCyVa', '4006', 'Patient'),
(29, 'Rita huynh', 902679902, 'a12@gmail.com', '$2y$10$Twsgaz8DhtalAm9ZdMoB6e6Mga0k2rcVXGChp5LF7LQdPpxTUkOHW', '7000', 'Patient');

-- --------------------------------------------------------

--
-- Table structure for table `User_Feedback`
--

CREATE TABLE `User_Feedback` (
  `FeedbackID` int(11) NOT NULL,
  `FullName` varchar(45) NOT NULL,
  `Phone` int(11) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Message` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Feedback`
--

INSERT INTO `User_Feedback` (`FeedbackID`, `FullName`, `Phone`, `Email`, `Message`) VALUES
(1, 'rita', 902679902, 'abc1@gmail.com', 'dsdsd'),
(2, '344', 123456, 'ERER@gmail.com', 'ERER'),
(3, 'rita', 902679902, 'abc@gmail.com', 'hgjgj'),
(4, 'a12@gmail.com', 902679902, 'a12@gmail.com', 'hbdhsbf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `PatientID` (`PatientID`),
  ADD KEY `DentistID` (`DentistID`),
  ADD KEY `ServiceID` (`ServiceID`),
  ADD KEY `AvailabilityID` (`AvailabilityID`);

--
-- Indexes for table `Dentist`
--
ALTER TABLE `Dentist`
  ADD PRIMARY KEY (`DentistID`),
  ADD KEY `dentist_user_fk` (`UserID`);

--
-- Indexes for table `Dentist_Availability`
--
ALTER TABLE `Dentist_Availability`
  ADD PRIMARY KEY (`AvailabilityID`),
  ADD KEY `DentistID` (`DentistID`);

--
-- Indexes for table `Dentist_Service`
--
ALTER TABLE `Dentist_Service`
  ADD PRIMARY KEY (`DentistServiceID`),
  ADD KEY `DentistID` (`DentistID`),
  ADD KEY `ServiceID` (`ServiceID`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`PatientID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`ServiceID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `email` (`Email`);

--
-- Indexes for table `User_Feedback`
--
ALTER TABLE `User_Feedback`
  ADD PRIMARY KEY (`FeedbackID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Appointment`
--
ALTER TABLE `Appointment`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `Dentist`
--
ALTER TABLE `Dentist`
  MODIFY `DentistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Dentist_Availability`
--
ALTER TABLE `Dentist_Availability`
  MODIFY `AvailabilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `Dentist_Service`
--
ALTER TABLE `Dentist_Service`
  MODIFY `DentistServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `Patient`
--
ALTER TABLE `Patient`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `Service`
--
ALTER TABLE `Service`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `User_Feedback`
--
ALTER TABLE `User_Feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`DentistID`) REFERENCES `Dentist` (`DentistID`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`ServiceID`) REFERENCES `Service` (`ServiceID`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`AvailabilityID`) REFERENCES `Dentist_Availability` (`AvailabilityID`) ON DELETE CASCADE;

--
-- Constraints for table `Dentist`
--
ALTER TABLE `Dentist`
  ADD CONSTRAINT `dentist_user_fk` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `Dentist_Availability`
--
ALTER TABLE `Dentist_Availability`
  ADD CONSTRAINT `dentist_availability_ibfk_1` FOREIGN KEY (`DentistID`) REFERENCES `Dentist` (`DentistID`) ON DELETE CASCADE;

--
-- Constraints for table `Dentist_Service`
--
ALTER TABLE `Dentist_Service`
  ADD CONSTRAINT `dentist_service_ibfk_1` FOREIGN KEY (`DentistID`) REFERENCES `Dentist` (`DentistID`) ON DELETE CASCADE,
  ADD CONSTRAINT `dentist_service_ibfk_2` FOREIGN KEY (`ServiceID`) REFERENCES `Service` (`ServiceID`) ON DELETE CASCADE;

--
-- Constraints for table `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `patient_user_fk` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
