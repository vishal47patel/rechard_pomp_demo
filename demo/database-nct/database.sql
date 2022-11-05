-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2021 at 06:35 PM
-- Server version: 5.6.45-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asgncryp_dbnm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(8) NOT NULL,
  `uName` varchar(100) NOT NULL,
  `uPass` varchar(100) NOT NULL,
  `uEmail` varchar(100) NOT NULL,
  `ipAddress` varchar(100) NOT NULL,
  `adminType` enum('s','g') NOT NULL DEFAULT 'g' COMMENT 's = super, g = global(sub admin)',
  `permissions` text,
  `isActive` enum('a','d','t') NOT NULL DEFAULT 'd',
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `uName`, `uPass`, `uEmail`, `ipAddress`, `adminType`, `permissions`, `isActive`, `created_date`, `updated_date`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'pinal.dave@ncrypted.com', '27.61.228.207', 's', '0', 'a', '2016-12-01 17:19:32', '2021-06-11 08:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminrole`
--

CREATE TABLE `tbl_adminrole` (
  `id` int(8) UNSIGNED NOT NULL,
  `sectionid` int(8) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `pagenm` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `page_action` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `table_field` varchar(255) NOT NULL,
  `table_primary_field` varchar(255) NOT NULL COMMENT 'table primary key field',
  `status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a=Active, d=Deactive',
  `seq` int(8) NOT NULL,
  `page_permission` varchar(255) DEFAULT '1,2,3,4,5,6,13'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_adminrole`
--

INSERT INTO `tbl_adminrole` (`id`, `sectionid`, `title`, `pagenm`, `image`, `page_action`, `table_name`, `table_field`, `table_primary_field`, `status`, `seq`, `page_permission`) VALUES
(1, 1, 'Home', 'home-nct', 'fa-home', '', '', '', '', 'd', 1, ''),
(2, 1, 'Change Password', 'cPass-nct', 'fa-key', '1', '', '', '', 'a', 2, '1,13'),
(3, 1, 'Content', 'content-nct', 'fa-file', '1,2,3,4,5,6', 'tbl_content', 'pageTitle', 'pId', 'a', 3, '1,2,3,4,5,6,13'),
(4, 1, 'Email Templates', 'templates-nct', 'fa-envelope', '1,2,3,4,5,6', 'tbl_email_templates', 'types', 'id', 'a', 4, '1,2,3,6,13'),
(9, 2, 'Customer Management', 'users-nct', 'fa-user', '1,2,3,4,5,6', 'tbl_users', 'firstName', '', 'a', 1, '1,3,4,5,6,13'),
(28, 1, 'Site Settings', 'sitesetting-nct', 'fa fa-cogs', '1', '', '', '', 'a', 1, '1,13'),
(111, 30, 'Manage Contact Us', 'contactus-nct', 'fa-pen', '1,2,3,4,5,6', 'tbl_contact_us', 'id', 'id', 'a', 1, '1,9,4,13'),
(112, 2, 'Manage Reported Users', 'reported_user-nct', 'fa-user', '1,2,5,6', 'tbl_report_users', 'firstName', '', 'd', 1, '1,5,6,13'),
(113, 1, 'Manage Banner', 'banner-nct', 'fa-file', '1,2,3,4,5,6', 'tbl_banner', '', '', 'a', 5, '1,2,3,4,5,6,13'),
(119, 33, 'Payment History', 'transaction_history-nct', 'fa-money', '1,2,3,4,5,6', 'tbl_payment_history', '', '', 'a', 2, '1,2,3,4,5,6,13'),
(122, 35, 'Manage Language', 'language-nct', 'fa-language', '1,2,3,4,5,6', 'tbl_language', '', '', 'a', 1, '1,2,3,4,5,6,13'),
(123, 35, 'Manage Constant', 'constant-nct', 'fa-language', '1,2,3,4,5,6', 'tbl_constant', '', '', 'a', 1, '1,2,3,4,5,6,13'),
(125, 37, 'Manage Redemption Request', 'redeem_request-nct', 'fa-gift', '1,2,3,4,5,6', 'tbl_redeem_requests', 'id', '', 'a', 1, '1,2,3,4,5,6,13'),
(126, 38, 'Manage reviews', 'manage_review-nct', 'fa fa-newspaper-o', '1,2,3,4,5,6', 'tbl_reviews', 'id', '', 'a', 1, '1,2,3,4,5,6,13'),
(131, 2, 'Provider Management', 'mechanics-nct', 'fa-user', '1,2,3,4,5,6', 'tbl_users', 'firstName', '', 'a', 2, '1,3,4,5,6,13'),
(132, 1, 'Google AdSense Code', 'adsense_code-nct', 'fa-file', '1,2,3,4,5,6', 'tbl_googleadsense_code', '', '', 'a', 6, '1,2,3,4,5,6,13'),
(133, 39, 'Service Request Management', 'request_management-nct', 'fa-money', '1,2,3,4,5,6', 'tbl_service_requests', '', '', 'a', 1, '1,2,3,4,5,6,13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminsection`
--

CREATE TABLE `tbl_adminsection` (
  `id` int(8) UNSIGNED NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(8) UNSIGNED DEFAULT NULL,
  `order` int(4) NOT NULL,
  `isActive` enum('y','n') NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_adminsection`
--

INSERT INTO `tbl_adminsection` (`id`, `section_name`, `image`, `type`, `order`, `isActive`) VALUES
(1, 'Common Menu', 'fa-list', 1, 1, 'y'),
(2, 'User Management', 'fa-users', 1, 2, 'y'),
(30, 'Manage Conatct Us', 'fa-phone', 1, 9, 'y'),
(33, 'Payment History', 'fa-money', 1, 7, 'y'),
(35, 'Manage Language', 'fa-language', 1, 5, 'y'),
(37, 'Manage Redemption Request', 'fa-gift', 1, 6, 'n'),
(38, 'Manage Reviews', 'fa fa-newspaper-o', 1, 8, 'y'),
(39, 'Service Request Management', 'fa fa-newspaper-o', 1, 9, 'y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_activity`
--

CREATE TABLE `tbl_admin_activity` (
  `id` int(11) NOT NULL,
  `activity_type` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `entity_id` int(25) NOT NULL,
  `entity_action` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_notifications`
--

CREATE TABLE `tbl_admin_notifications` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `type` varchar(128) CHARACTER SET latin1 NOT NULL,
  `is_read` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
  `createdDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin_notifications`
--

INSERT INTO `tbl_admin_notifications` (`id`, `admin_id`, `entity_id`, `type`, `is_read`, `createdDate`) VALUES
(0, 1, 0, 'contact_us', 'n', '2021-03-09 09:12:10'),
(0, 1, 0, 'contact_us', 'n', '2021-03-15 12:12:09'),
(0, 1, 0, 'contact_us', 'n', '2021-03-15 12:36:21'),
(0, 1, 0, 'contact_us', 'n', '2021-05-28 14:33:59'),
(0, 1, 0, 'contact_us', 'n', '2021-05-31 06:31:32'),
(0, 1, 0, 'contact_us', 'n', '2021-06-02 11:55:41'),
(0, 1, 0, 'contact_us', 'n', '2021-06-08 08:41:42'),
(0, 1, 0, 'contact_us', 'n', '2021-06-18 10:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_permission`
--

CREATE TABLE `tbl_admin_permission` (
  `id` int(11) NOT NULL,
  `admin_id` int(8) NOT NULL,
  `page_id` int(11) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_1` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `detail` text CHARACTER SET utf8 NOT NULL,
  `detail_1` text CHARACTER SET utf8,
  `file_type` varchar(20) NOT NULL,
  `file` varchar(255) NOT NULL,
  `isActive` enum('y','n') NOT NULL DEFAULT 'y' COMMENT 'y= active,n=incactive',
  `createdDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id`, `title`, `title_1`, `detail`, `detail_1`, `file_type`, `file`, `isActive`, `createdDate`) VALUES
(1, '', 'Auto Service Global', '', '<p>Auto Service Global</p>', 'image', '4347822701617257085.png', '', '2018-02-23 06:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_constant`
--

CREATE TABLE `tbl_constant` (
  `id` int(11) NOT NULL,
  `constantName` varchar(255) NOT NULL,
  `value` text,
  `value_1` varchar(255) DEFAULT NULL,
  `type` enum('f','m','t','s') NOT NULL DEFAULT 'm' COMMENT 'f=fields,m=msg,t=title,s=system',
  `status` enum('w','a','b') NOT NULL DEFAULT 'w' COMMENT 'w-web , a- apps, b- both',
  `created_date` datetime DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_constant`
--

INSERT INTO `tbl_constant` (`id`, `constantName`, `value`, `value_1`, `type`, `status`, `created_date`, `updated_date`) VALUES
(1, 'FILL_VALUES', 'Please fill all the values.', 'Please fill all the values.', 't', 'w', '2021-02-19 16:21:33', '2021-06-09 11:44:50'),
(2, 'PWD_RESET_SUCC', 'Password reset successfully.', 'Password reset successfully.', 't', 'w', '2021-02-19 16:22:30', '2021-06-09 11:44:50'),
(3, 'NEW_CNFM_PASS_MATCH', 'New Password and Confirm Password Must Match.', 'New Password and Confirm Password Must Match.', 't', 'w', '2021-02-19 16:23:11', '2021-06-09 11:44:50'),
(4, 'WENT_WRONG', 'Something went wrong.', 'Something went wrong.', 't', 'w', '2021-02-19 16:23:46', '2021-06-09 11:44:50'),
(5, 'PROVIDE_CODE', 'Please provide a verification code.', 'Please provide a verification code.', 't', 'w', '2021-02-19 16:24:45', '2021-06-09 11:44:50'),
(6, 'RESET_PASSWORD', 'Reset Password', 'Reset Password', 't', 'w', '2021-02-19 16:25:26', '2021-06-09 11:44:50'),
(7, 'ENTER_NEW_PASS', 'Please enter new password.', 'Please enter new password.', 't', 'w', '2021-02-19 16:26:48', '2021-06-09 11:44:50'),
(8, 'MIN_SIX_CHAR_REQUIRED', 'Minimum 6 character required.', 'Minimum 6 character required.', 't', 'w', '2021-02-19 16:27:23', '2021-06-09 11:44:50'),
(9, 'ENTER_CNFM_PASS', 'Please enter confirm password.', 'Please enter confirm password.', 't', 'w', '2021-02-19 16:28:42', '2021-06-09 11:44:50'),
(10, 'MSG_EMAIL_REQ', 'Please enter email address.', 'Please enter email address.', 't', 'w', '2021-02-19 16:29:36', '2021-06-09 11:44:50'),
(11, 'MSG_VALID_EMAIL', 'Please enter valid email address.', 'Please enter valid email address.', 't', 'w', '2021-02-19 16:29:55', '2021-06-09 11:44:50'),
(12, 'MSG_PASS_REQ', 'Please enter password.', 'Please enter password.', 't', 'w', '2021-02-19 16:30:14', '2021-06-09 11:44:50'),
(13, 'MSG_ACTIVATION_MAIL_SENT', 'Activation mail sent successfully.', 'Activation mail sent successfully.', 't', 'w', '2021-02-19 16:31:52', '2021-06-09 11:44:50'),
(14, 'MSG_EMAIL_NOT_EXIST', 'This email address does not exist.', 'This email address does not exist.', 't', 'w', '2021-02-19 16:32:44', '2021-06-09 11:44:50'),
(15, 'MSG_ACCOUNT_ACTIVATED', 'Your account is already activated.', 'Your account is already activated.', 't', 'w', '2021-02-19 16:33:24', '2021-06-09 11:44:50'),
(16, 'MSG_RESET_PASSWORD_MAIL_SEND', 'Reset password link sent successfully. Please check your mail.', 'Reset password link sent successfully. Please check your mail.', 't', 'w', '2021-02-19 16:39:07', '2021-06-09 11:44:50'),
(17, 'MSG_ACCT_DEACTIVED', 'Admin has deactivated your account. Please contact admin.', 'Admin has deactivated your account. Please contact admin.', 't', 'w', '2021-02-19 16:40:02', '2021-06-09 11:44:50'),
(18, 'MSG_ACTIVATE_ACC', 'Please activate your account first.', 'Please activate your account first.', 't', 'w', '2021-02-19 16:40:40', '2021-06-09 11:44:50'),
(19, 'MSG_ACCOUNT_SUC_ACTIVATED', 'Account successfully activated.', 'Your account is successfully activated.', 't', 'w', '2021-02-19 16:44:36', '2021-06-09 11:44:50'),
(20, 'MSG_INVALID_VERI_CODE', 'Entered verification code is invalid.', 'Given activation link is expired.', 't', 'w', '2021-02-19 16:45:39', '2021-06-09 11:44:50'),
(21, 'MSG_LOGIN_SUC', 'Successfully logged in to', 'Successfully logged in to', 't', 'w', '2021-02-19 16:46:47', '2021-06-09 11:44:50'),
(22, 'MSG_INVALID_LOGIN', 'Entered login details are invalid.', 'Entered login details are invalid.', 't', 'w', '2021-02-19 16:48:08', '2021-06-09 11:44:50'),
(23, 'WIN_LOGIN', 'Login', 'Log in', 't', 'w', '2021-02-19 16:49:18', '2021-06-09 11:44:50'),
(24, 'REMEMBER_ME', 'Remember Me', 'Remember Me', 't', 'w', '2021-02-19 16:51:05', '2021-06-09 11:44:50'),
(25, 'FORGOT_PASSWORD', 'Forgot Password?', 'Forgot Password', 't', 'w', '2021-02-19 16:51:19', '2021-06-09 11:44:50'),
(26, 'RESEND_ONE', 'Haven’t received activation email yet?', 'Haven’t received activation email yet?', 't', 'w', '2021-02-19 16:52:24', '2021-06-09 11:44:50'),
(27, 'RESEND_TWO', 'to receive again.', 'to receive again.', 't', 'w', '2021-02-19 16:52:46', '2021-06-09 11:44:50'),
(28, 'SUBMIT', 'Submit', 'Submit', 't', 'w', '2021-02-19 16:53:11', '2021-06-09 11:44:50'),
(29, 'CLOSE', 'Close', 'Close', 't', 'w', '2021-02-19 16:53:19', '2021-06-09 11:44:50'),
(30, 'EMAIL', 'Email ID', 'Email ID', 't', 'w', '2021-02-19 16:53:37', '2021-06-09 11:44:50'),
(31, 'PASSWORD', 'Password', 'Password', 't', 'w', '2021-02-19 16:53:46', '2021-06-09 11:44:50'),
(32, 'CLICK_HERE', 'Click Here', 'Click Here', 't', 'w', '2021-02-19 16:55:40', '2021-06-09 11:44:50'),
(33, 'SIGNUP', 'Sign Up', 'Sign Up', 't', 'w', '2021-02-19 16:56:34', '2021-06-09 11:44:50'),
(34, 'LOGIN', 'Log In', 'Sign In', 't', 'w', '2021-02-19 16:56:42', '2021-06-09 11:44:50'),
(35, 'EMAIL_OR_CONTACT_NO', 'Email ID/Contact No.', 'Email ID/Contact No.', 't', 'w', '2021-02-19 16:57:43', '2021-06-09 11:44:50'),
(36, 'MSG_EMAIL_OR_NO_REQ', 'Please enter email ID / Contact no.', 'Please enter email ID / Contact no.', 't', 'w', '2021-02-19 17:10:37', '2021-06-09 11:44:50'),
(37, 'MSG_INVALID_PASSWORD', 'Entered password is invalid.', 'Entered password is invalid.', 't', 'w', '2021-02-19 17:34:00', '2021-06-09 11:44:50'),
(38, 'MSG_INVALID_EMAIL_NO', 'Entered Email ID or Contact no. is invalid ', 'Entered Email ID or Contact no. is invalid ', 't', 'w', '2021-02-19 17:35:14', '2021-06-09 11:44:50'),
(39, 'MSG_MIN_10_CHAR', 'Minimum 10 characters required.', 'Minimum 10 characters required.', 't', 'w', '2021-02-19 19:55:08', '2021-06-09 11:44:50'),
(40, 'MSG_MAX_15_CHAR', 'Maximum 15 characters allowed.', 'Maximum 15 characters allowed.', 't', 'w', '2021-02-19 19:55:25', '2021-06-09 11:44:50'),
(41, 'NO_DEVICE_ID_FOUND', 'Please provide device ID.', 'Please provide device ID.', 't', 'w', '2021-02-20 13:55:11', '2021-06-09 11:44:50'),
(42, 'SUC_LOG_OUT', 'You have successfully logged out.', 'You have successfully logged out.', 't', 'w', '2021-02-20 13:58:38', '2021-06-09 11:44:50'),
(43, 'PLEASE_PROVIDE_VALID_DATA', 'Please provide all data.', 'Please provide all data.', 't', 'w', '2021-02-20 14:00:45', '2021-06-09 11:44:50'),
(44, 'FNAME', 'First Name', 'First Name', 't', 'w', '2021-02-22 14:48:59', '2021-06-09 11:44:50'),
(45, 'LNAME', 'Last Name', 'Last Name', 't', 'w', '2021-02-22 14:49:13', '2021-06-09 11:44:50'),
(46, 'CONTACT_NO', 'Contact No.', 'Contact No.', 't', 'w', '2021-02-22 14:50:02', '2021-06-09 11:44:50'),
(47, 'CONFIRM_PASSWORD', 'Confirm Password', 'Confirm Password', 't', 'w', '2021-02-22 14:53:54', '2021-06-09 11:44:50'),
(48, 'MSG_FNAME_REQ', 'Please enter first name.', 'Please enter first name.', 't', 'w', '2021-02-22 15:26:24', '2021-06-09 11:44:50'),
(49, 'MSG_LNAME_REQ', 'Please enter last name.', 'Please enter last name.', 't', 'w', '2021-02-22 15:26:43', '2021-06-09 11:44:50'),
(50, 'MSG_MIN_3_CHAR', 'Please enter minimum 3 characters.', 'Please enter minimum 3 characters.', 't', 'w', '2021-02-22 15:27:21', '2021-06-09 11:44:50'),
(51, 'MSG_EMAIL_EXISTS', 'This email address already exists.', 'This email address already exists.', 't', 'w', '2021-02-22 15:29:04', '2021-06-09 11:44:50'),
(52, 'MSG_CONTACT_REQ', 'Please enter contact no.', 'Please enter contact no.', 't', 'w', '2021-02-22 15:29:24', '2021-06-09 11:44:50'),
(53, 'MSG_ONLY_DIGIT', 'Please enter only digits.', 'Please enter only digits.', 't', 'w', '2021-02-22 15:29:58', '2021-06-09 11:44:50'),
(54, 'MSG_CONTACT_EXISTS', 'This contact no. already exists.', 'This contact no. already exists.', 't', 'w', '2021-02-22 15:30:21', '2021-06-09 11:44:50'),
(56, 'MSG_PASS_CONF_NOT_MATCH', 'Password and confirm password must match.', 'Password and confirm password must match.', 't', 'w', '2021-02-22 15:32:57', '2021-06-09 11:44:50'),
(57, 'SELECT_USER_TYPE', 'Select User Type', 'Select User Type', 't', 'w', '2021-02-22 16:54:28', '2021-06-09 11:44:50'),
(58, 'SELECT_SERVICE_TYPE', 'Select Service Type', 'Select Service Type', 't', 'w', '2021-02-22 16:54:44', '2021-06-09 11:44:50'),
(59, 'SELECT_VEHICLE_TYPE', 'Select Vehicle Type', 'Select Vehicle Type', 't', 'w', '2021-02-22 16:55:45', '2021-06-09 11:44:50'),
(60, 'CUSTOMER', 'Customer', 'Customer', 't', 'w', '2021-02-22 16:56:03', '2021-06-09 11:44:50'),
(61, 'SERVICE_PROVIDER', 'Service Provider', 'Service Provider', 't', 'w', '2021-02-22 16:56:27', '2021-06-09 11:44:50'),
(62, 'MECHANIC', 'Mechanic', 'Mechanic', 't', 'w', '2021-02-22 16:57:16', '2021-06-09 11:44:50'),
(63, 'TAXI', 'Taxi', 'Taxi', 't', 'w', '2021-02-22 16:57:23', '2021-06-09 11:44:50'),
(64, 'CAR', 'Car', 'Car', 't', 'w', '2021-02-22 16:59:55', '2021-06-09 11:44:50'),
(65, 'BIKE', 'Bike', 'Bike', 't', 'w', '2021-02-22 17:00:03', '2021-06-09 11:44:50'),
(66, 'BOTH', 'Both', 'Both', 't', 'w', '2021-02-22 17:00:11', '2021-06-09 11:44:50'),
(67, 'MSG_USER_TYPE_REQ', 'Please select user type.', 'Please select user type.', 't', 'w', '2021-02-22 17:05:33', '2021-06-09 11:44:50'),
(68, 'MSG_SERVICE_TYPE_REQ', 'Please select service type.', 'Please select service type.', 't', 'w', '2021-02-22 17:05:50', '2021-06-09 11:44:50'),
(69, 'MSG_VEHI_TYPE_REQ', 'Please select vehicle type.', 'Please select vehicle type.', 't', 'w', '2021-02-22 17:06:07', '2021-06-09 11:44:50'),
(70, 'MSG_REGISTERED_SUC', 'You have successfully registered. Please check your mail for activating your account.', 'You have successfully registered. Please check your mail for activating your account.', 't', 'w', '2021-02-22 17:23:52', '2021-06-09 11:44:50'),
(71, 'ACTIVATE_NOW', 'Activate Now', 'Activate Now', 't', 'w', '2021-02-22 17:27:19', '2021-06-09 11:44:50'),
(72, 'HOME', 'Home', 'Home', 't', 'w', '2021-02-23 10:46:53', '2021-06-09 11:44:50'),
(73, 'AFTER_REGISTRATION', 'After Registration', 'After Registration', 't', 'w', '2021-02-23 10:59:35', '2021-06-09 11:44:50'),
(74, 'BUSINESS_NAME', 'Business Name', 'Business Name', 't', 'w', '2021-02-23 11:56:24', '2021-06-09 11:44:50'),
(75, 'MSG_BNAME_REQ', 'Please enter business name.', 'Please enter business name.', 't', 'w', '2021-02-23 11:58:34', '2021-06-09 11:44:50'),
(76, 'SAVE', 'Save', 'Save', 't', 'w', '2021-02-23 11:59:31', '2021-06-09 11:44:50'),
(77, 'CANCEL', 'Cancel', 'Cancel', 't', 'w', '2021-02-23 11:59:40', '2021-06-09 11:44:50'),
(78, 'MSG_DETAILS_SAVED_SUC', 'Details saved successfully.', 'Details saved successfully.', 't', 'w', '2021-02-23 12:01:35', '2021-06-09 11:44:50'),
(79, 'MSG_PASS_CHANGE_SUC', 'Password changed successfully.', 'Your password has been changed successfully.', 't', 'w', '2021-03-12 16:31:23', '2021-06-09 11:44:50'),
(80, 'MSG_NOTI_UPDATED_SUC', 'Notification has been updated successfully.', 'Notification has been updated successfully.', 't', 'w', '2021-03-12 16:32:23', '2021-06-09 11:44:50'),
(81, 'MSG_ACC_DELETED_SUC', 'Account has been deleted.', 'Account has been deleted.', 't', 'w', '2021-03-12 16:32:53', '2021-06-09 11:44:50'),
(82, 'MSG_COMPLETE_RIDE_FIRST', 'Please complete service first.', 'Please complete service first.', 't', 'w', '2021-03-12 16:33:27', '2021-06-09 11:44:50'),
(83, 'MSG_NO_PAGE_FOUND', 'Page not found!', 'Page not found!', 't', 'w', '2021-03-12 16:34:47', '2021-06-09 11:44:50'),
(84, 'MSG_PAYPAL_EXIST', 'This PayPal email already exists.', 'This PayPal email already exists.', 't', 'w', '2021-03-12 16:36:07', '2021-06-09 11:44:50'),
(85, 'MSG_PROFILE_UPDATE_SUC', 'Your profile has been updated successfully.', 'Your profile has been updated successfully.', 't', 'w', '2021-03-12 16:36:31', '2021-06-09 11:44:50'),
(86, 'MSG_FILL_ALL_VALUE', 'Please fill all fields.', 'Please fill all fields.', 't', 'w', '2021-03-12 16:36:53', '2021-06-09 11:44:50'),
(87, 'MSG_CONTACT_US_SUC', 'Contact us send successfully.', 'Your query is submitted successfully.', 't', 'w', '2021-03-12 16:38:16', '2021-06-09 11:44:50'),
(88, 'MSG_CURR_PASS_NOT_MATCH', 'Current password did not match.', 'Current password did not match.', 't', 'w', '2021-03-12 16:40:59', '2021-06-09 11:44:50'),
(89, 'MSG_PASS_EQUAL', 'New and confirm password not equal.', 'New and confirm password not equal.', 't', 'w', '2021-03-12 16:41:45', '2021-06-09 11:44:50'),
(90, 'MSG_PASS_SAME', 'Old and new password are same.', 'Old and new password are same.', 't', 'w', '2021-03-12 16:42:10', '2021-06-09 11:44:50'),
(91, 'LANGUAGE_CHANGED', 'Language has been changed.', 'Language has been changed.', 't', 'w', '2021-03-12 16:42:56', '2021-06-09 11:44:50'),
(92, 'DEVICE_REGI_SUC', 'Device registered successfully.', 'Device registered successfully.', 't', 'w', '2021-03-12 16:44:06', '2021-06-09 11:44:50'),
(93, 'CONTACT_US', 'Contact Us', 'Contact Us', 't', 'w', '2021-03-19 12:16:21', '2021-06-09 11:44:50'),
(94, 'LOOKING_FOR_PROVIDER', 'Looking for provider?', 'Looking for provider?', 't', 'w', '2021-03-19 15:14:45', '2021-06-09 11:44:50'),
(95, 'ENTER_SEARCH_RADIUS', 'Enter Search Radius', 'Enter Search Radius', 't', 'w', '2021-03-19 15:27:30', '2021-06-09 11:44:50'),
(96, 'SEARCH', 'Search', 'Search', 't', 'w', '2021-03-19 15:33:16', '2021-06-09 11:44:50'),
(97, 'PLZ_ENTER_SEARCH_RADIUS', 'Please enter search radius.', 'Please enter search radius.', 't', 'w', '2021-03-19 15:35:54', '2021-06-09 11:44:50'),
(98, 'MSG_ENTER_MIN_ONE', 'Please enter minimum 1.', 'Please enter minimum 1.', 't', 'w', '2021-03-19 16:01:20', '2021-06-09 11:44:50'),
(99, 'CREATE_ACCOUNT', 'Create Account', 'Create Account', 't', 'w', '2021-03-19 16:42:23', '2021-06-09 11:44:50'),
(100, 'ENTER', 'Enter', 'Enter', 't', 'w', '2021-03-19 17:08:58', '2021-06-09 11:44:50'),
(101, 'ALREADY_HAVE_ACCOUNT', 'Already have an Account?', 'Already have an Account?', 't', 'w', '2021-03-19 17:15:09', '2021-06-09 11:44:50'),
(102, 'PROFILE', 'Profile', 'Profile', 't', 'w', '2021-03-19 18:01:43', '2021-06-09 11:44:50'),
(103, 'SIGN_OUT', 'Logout', 'Logout', 't', 'w', '2021-03-19 18:01:54', '2021-06-09 11:44:50'),
(104, 'INBOX', 'Inbox', 'Inbox', 't', 'w', '2021-03-19 18:04:38', '2021-06-09 11:44:50'),
(105, 'MY_WALLET', 'My Wallet', 'My Wallet', 't', 'w', '2021-03-19 18:05:20', '2021-06-09 11:44:50'),
(106, 'ACCOUNT_SETTINGS', 'Account Settings', 'Account Settings', 't', 'w', '2021-03-19 18:06:00', '2021-06-09 11:44:50'),
(107, 'UPLOAD_IMAGE', 'Upload Image', 'Upload Image', 't', 'w', '2021-03-20 12:05:25', '2021-06-09 11:44:50'),
(108, 'CROP', 'Crop', 'Crop', 't', 'w', '2021-03-20 12:29:44', '2021-06-09 11:44:50'),
(109, 'ENTER_NEW_PASSWORD', 'Enter New Password', 'Enter New Password', 't', 'w', '2021-03-20 17:39:16', '2021-06-09 11:44:50'),
(110, 'REENTER_NEW_PASSWORD', 'Re-enter Password', 'Re-enter Password', 't', 'w', '2021-03-20 17:39:45', '2021-06-09 11:44:50'),
(111, 'NO_NEARBY_PROVIDER_FOUND', 'No nearby provider found.', 'No nearby provider found.', 't', 'w', '2021-03-22 11:14:48', '2021-06-09 11:44:50'),
(112, 'NEARBY_PROVIDERS', 'Nearby Providers', 'Nearby Providers', 't', 'w', '2021-03-22 12:23:25', '2021-06-09 11:44:50'),
(113, 'ARE_YOU_PROVIDER', 'Are you a provider?', 'Are you a provider?', 't', 'w', '2021-03-22 12:51:00', '2021-06-09 11:44:50'),
(114, 'SIGN_UP_NOW', 'Sign Up Now', 'Sign Up Now', 't', 'w', '2021-03-22 12:52:06', '2021-06-09 11:44:50'),
(115, 'WIN_SEARCH', 'Search Providers', 'Search Providers', 't', 'w', '2021-03-22 13:59:04', '2021-06-09 11:44:50'),
(116, 'RADIUS', 'Radius', 'Radius', 't', 'w', '2021-03-22 16:59:05', '2021-06-09 11:44:50'),
(117, 'SEARCH_RESULT', 'Search Result', 'Search Result', 't', 'w', '2021-03-23 15:47:06', '2021-06-09 11:44:50'),
(118, 'CURRENT_PASSWORD', 'Enter current password', 'Enter current password', 't', 'w', '2021-03-24 11:58:46', '2021-06-09 11:44:50'),
(119, 'WIN_ACCOUNT_SETTING', 'Account settings', 'Account settings', 't', 'w', '2021-03-24 12:08:16', '2021-06-09 11:44:50'),
(120, 'LBL_UPDATE', 'Update', 'Update', 't', 'w', '2021-03-24 12:16:07', '2021-06-09 11:44:50'),
(121, 'EDIT_PROFILE', 'Edit Profile', 'Edit Profile', 't', 'w', '2021-03-24 15:03:01', '2021-06-09 11:44:50'),
(122, 'MSG_NEW_EMAIL_REQ', 'Please enter new email address.', 'Please enter new email address.', 't', 'w', '2021-03-24 15:05:57', '2021-06-09 11:44:50'),
(123, 'PROFILE_PIC_UPDATED', 'Profile picture updated successfully.', 'Profile picture updated successfully.', 't', 'w', '2021-03-24 15:07:17', '2021-06-09 11:44:50'),
(124, 'MSG_ENT_PAY_GATE_ID', 'Please enter payment gateway ID', 'Please enter payment gateway ID', 't', 'w', '2021-03-24 15:09:55', '2021-06-09 11:44:50'),
(125, 'LOCATION', 'Location', 'Location', 't', 'w', '2021-03-24 15:53:11', '2021-06-09 11:44:50'),
(126, 'WHEN_SER_REQ_REC', 'When the Service Request is received', 'When the Service Request is received', 't', 'w', '2021-03-25 11:51:40', '2021-06-09 11:44:50'),
(127, 'WHEN_SER_COM', 'When the service is completed', 'When the service is completed', 't', 'w', '2021-03-25 11:51:58', '2021-06-09 11:44:50'),
(128, 'WHEN_SER_CAN_BY_PRO', 'When the service is cancelled by Customer/Service Provider', 'When the service is cancelled by Customer/Service Provider', 't', 'w', '2021-03-25 11:52:26', '2021-06-09 11:44:50'),
(129, 'WHEN_SER_ASSIGN_CUS', 'When the Service Provider assigned to the Customer', 'When the Service Provider assigned to the Customer', 't', 'w', '2021-03-25 11:52:59', '2021-06-09 11:44:50'),
(130, 'PAY_GATE_ID_UPDATED', 'Payment gateway id has been updated.', 'Payment gateway id has been updated.', 't', 'w', '2021-03-25 11:54:08', '2021-06-09 11:44:50'),
(131, 'PLE_CHECK_MAIL_CHANGE_MAIL', 'Please check your mail for change email address.', 'Please check your mail for change email address.', 't', 'w', '2021-03-25 11:54:37', '2021-06-09 11:44:50'),
(132, 'NO_ANY_SER_ADDED', 'No any services added.', 'No any services added.', 't', 'w', '2021-03-25 13:57:34', '2021-06-09 11:44:50'),
(133, 'NEW_SER_ADDED_SUC', 'New service has been added successfully.', 'New service has been added successfully.', 't', 'w', '2021-03-25 13:58:03', '2021-06-09 11:44:50'),
(134, 'SUBJECT', 'Subject', 'Subject', 't', 'w', '2021-03-25 15:48:35', '2021-06-09 11:44:50'),
(135, 'MESSAGE', 'Message', 'Message', 't', 'w', '2021-03-25 15:49:07', '2021-06-09 11:44:50'),
(136, 'MSG_SUBJECT_REQ', 'Please enter subject.', 'Please enter subject.', 't', 'w', '2021-03-25 16:01:35', '2021-06-09 11:44:50'),
(137, 'MSG_REQ', 'Please enter message.', 'Please enter message.', 't', 'w', '2021-03-25 16:02:16', '2021-06-09 11:44:50'),
(138, 'SER_NAME_AL_EXIST', 'Service name already exists.', 'Service name already exists.', 't', 'w', '2021-03-25 16:39:23', '2021-06-09 11:44:50'),
(139, 'MY_PRO_SERS', 'My Provided Services', 'My Provided Services', 't', 'w', '2021-03-25 16:56:41', '2021-06-09 11:44:50'),
(140, 'ADD_NEW_SER', 'Add new service', 'Add new service', 't', 'w', '2021-03-25 16:59:26', '2021-06-09 11:44:50'),
(141, 'CHANGE_EMAIL_ADD', 'Change Email Address', 'Change Email Address', 't', 'w', '2021-03-25 17:00:57', '2021-06-09 11:44:50'),
(142, 'MSG_LOCATION_REQUIRED', 'Please select location.', 'Please select location.', 't', 'w', '2021-03-25 17:01:21', '2021-06-09 11:44:50'),
(143, 'PAY_GATE_ID', 'Payment gateway ID', 'Payment gateway ID', 't', 'w', '2021-03-25 17:01:31', '2021-06-09 11:44:50'),
(144, 'CHANGE_PASS', 'Change password', 'Change password', 't', 'w', '2021-03-25 17:02:20', '2021-06-09 11:44:50'),
(145, 'ENT_PAY_GATE_ID', 'Enter payment gateway ID', 'Enter payment gateway ID', 't', 'w', '2021-03-25 17:02:51', '2021-06-09 11:44:50'),
(146, 'NOTI_PREFE', 'Notification preferences', 'Notification preferences', 't', 'w', '2021-03-25 17:03:10', '2021-06-09 11:44:50'),
(147, 'ENTER_NEW_EMAIL_ID', 'Enter new email address', 'Enter new email address', 't', 'w', '2021-03-25 17:03:34', '2021-06-09 11:44:50'),
(148, 'SERVICE_BOOK_DETAIL', 'Service Book Detail', 'Service Book Detail', 't', 'w', '2021-03-30 15:33:06', '2021-06-09 11:44:50'),
(149, 'PLZ_ENTER_VIN_NUMBER', 'Please enter VIN number.', 'Please enter VIN number.', 't', 'w', '2021-03-30 16:19:35', '2021-06-09 11:44:50'),
(150, 'ENTER_VIN', 'Enter VIN', 'Enter VIN', 't', 'w', '2021-03-30 16:20:43', '2021-06-09 11:44:50'),
(151, 'NO_DETAILS_FOUND', 'No details found.', 'No details found.', 't', 'w', '2021-03-30 16:28:27', '2021-06-09 11:44:50'),
(152, 'VEHICLE_DETAILS', 'Vehicle Details', 'Vehicle Details', 't', 'w', '2021-03-31 11:27:16', '2021-06-09 11:44:50'),
(153, 'ADD_SERVICE_RECORD', 'Add Service Record', 'Add Service Record', 't', 'w', '2021-03-31 11:28:45', '2021-06-09 11:44:50'),
(154, 'VEHICLE_MAKE', 'Vehicle Make', 'Vehicle Make', 't', 'w', '2021-03-31 11:43:59', '2021-06-09 11:44:50'),
(155, 'VEHICLE_MODEL', 'Vehicle Model', 'Vehicle Model', 't', 'w', '2021-03-31 11:45:42', '2021-06-09 11:44:50'),
(156, 'VEHICLE_YEAR', 'Vehicle Year', 'Vehicle Year', 't', 'w', '2021-03-31 12:01:07', '2021-06-09 11:44:50'),
(157, 'VEHICLE_ENGINE', 'Vehicle Engine', 'Vehicle Engine', 't', 'w', '2021-03-31 12:03:11', '2021-06-09 11:44:50'),
(158, 'ENGINE_POWER', 'Engine Power', 'Engine Power', 't', 'w', '2021-03-31 12:06:01', '2021-06-09 11:44:50'),
(159, 'SERVICE_DETAILS', 'Service Details', 'Service Details', 't', 'w', '2021-03-31 12:07:02', '2021-06-09 11:44:50'),
(160, 'NO_ANY_REC_REVIEWS', 'No any received reviews.', 'No any received reviews.', 't', 'w', '2021-03-31 15:12:14', '2021-06-09 11:44:50'),
(161, 'MY_REC_REVIEWS', 'My Received Reviews', 'My Received Reviews', 't', 'w', '2021-03-31 15:54:21', '2021-06-09 11:44:50'),
(162, 'LBL_REPLY', 'Reply', 'Reply', 't', 'w', '2021-03-31 15:55:34', '2021-06-09 11:44:50'),
(163, 'POST_REPLY', 'Post reply', 'Post reply', 't', 'w', '2021-03-31 15:55:50', '2021-06-09 11:44:50'),
(164, 'ADD_REPLY_REVIEW', 'Add a reply to this review...', 'Add a reply to this review...', 't', 'w', '2021-03-31 15:56:15', '2021-06-09 11:44:50'),
(165, 'SERVICE_ID', 'Services ID', 'Service ID', 't', 'w', '2021-03-31 15:56:39', '2021-06-09 11:44:50'),
(166, 'REVIEW_RPLY_ADDED', 'Review reply has been added successfully.', 'Review reply has been added successfully.', 't', 'w', '2021-03-31 15:57:16', '2021-06-09 11:44:50'),
(167, 'SELECT_SERVICE_DATE', 'Select Service Date', 'Select service date', 't', 'w', '2021-03-31 16:13:20', '2021-06-09 11:44:50'),
(168, 'DESCRIPTION', 'Description', 'Description', 't', 'w', '2021-03-31 16:15:35', '2021-06-09 11:44:50'),
(169, 'AMOUNT', 'Amount', 'Amount', 't', 'w', '2021-03-31 16:29:03', '2021-06-09 11:44:50'),
(170, 'MSG_DESCRIPTION_REQ', 'Please enter description.', 'Please enter description.', 't', 'w', '2021-03-31 16:53:44', '2021-06-09 11:44:50'),
(171, 'PLZ_SELECT_SERVICE_DATE', 'Please select service date.', 'Please select service date.', 't', 'w', '2021-03-31 17:02:29', '2021-06-09 11:44:50'),
(172, 'PLZ_ENTER_AMOUNT', 'Please enter amount.', 'Please enter amount.', 't', 'w', '2021-03-31 17:12:31', '2021-06-09 11:44:50'),
(173, 'PLZ_ENTER_VALID_NUMBER', 'Please enter valid number.', 'Please enter valid number.', 't', 'w', '2021-03-31 17:13:39', '2021-06-09 11:44:50'),
(174, 'SER_REC_ADDED_SUC', 'Service record added successfully.', 'Service record added successfully.', 't', 'w', '2021-03-31 18:36:23', '2021-06-09 11:44:50'),
(175, 'PROVIDER_DETAILS', 'Provider Details', 'Provider Details', 't', 'w', '2021-04-01 14:23:13', '2021-06-09 11:44:50'),
(176, 'DATE', 'Date', 'Date', 't', 'w', '2021-04-01 14:24:53', '2021-06-09 11:44:50'),
(177, 'MY_PROFILE', ' My Profile ', ' My Profile ', 't', 'w', '2021-04-01 18:56:00', '2021-06-09 11:44:50'),
(178, 'LBL_AVAILABILITY', 'Availability', 'Availability', 't', 'w', '2021-04-01 18:57:03', '2021-06-09 11:44:50'),
(179, 'OPEN', 'Open', 'Open', 't', 'w', '2021-04-01 18:57:19', '2021-06-09 11:44:50'),
(180, 'ADD_STATUS', 'Add status', 'Add status', 't', 'w', '2021-04-01 18:57:40', '2021-06-09 11:44:50'),
(181, 'EDIT', 'Edit', 'Edit', 't', 'w', '2021-04-01 18:57:52', '2021-06-09 11:44:50'),
(182, 'AVAILABILITY_SLOTS', 'Availability Slots', 'Availability Slots', 't', 'w', '2021-04-01 18:58:26', '2021-06-09 11:44:50'),
(183, 'PLZ_SELECT_SERVICE_TIME', 'Please select service time slot.', 'Please select service time slot.', 't', 'w', '2021-04-02 17:51:02', '2021-06-09 11:44:50'),
(184, 'SELECT_SERVICE_TIME', 'Select service time slot.', 'Select service time slot', 't', 'w', '2021-04-02 17:52:00', '2021-06-09 11:44:50'),
(185, 'PROV_NOT_AVAILABLE', 'Provider is not available for selected date and time slot.', 'Provider is not available for selected date and time slot.', 't', 'w', '2021-04-02 17:54:12', '2021-06-09 11:44:50'),
(186, 'PAST_TIME_NOT_ALLOWED', 'Past time not allowed.', 'Past time not allowed.', 't', 'w', '2021-04-03 10:54:19', '2021-06-09 11:44:50'),
(187, 'MSG_SERVICE_REQ_ADDED', 'New service request added successfully.', 'New service request added successfully.', 't', 'w', '2021-04-03 11:01:47', '2021-06-09 11:44:50'),
(188, 'BOOKED_SERVICE_DETAIL', 'Booked Service Detail', 'Booked Service Detail', 't', 'w', '2021-04-03 14:19:57', '2021-06-09 11:44:50'),
(189, 'CUSTOMER_DETAILS', 'Customer Details', 'Customer Details', 't', 'w', '2021-04-03 15:42:51', '2021-06-09 11:44:50'),
(190, 'AVAILABILITY_UPDATED_SUCCESSFULLY', 'Your availability has been updated successfully.', 'Your availability has been updated successfully.', 't', 'w', '2021-04-05 10:32:06', '2021-06-09 11:44:50'),
(191, 'MECHANIC_SERVICE', 'Mechanic Service', 'Auto Service', 't', 'w', '2021-04-05 10:32:33', '2021-06-09 11:44:50'),
(192, 'TAXI_SERVICE', 'Taxi Service', 'Taxi Service', 't', 'w', '2021-04-05 10:32:56', '2021-06-09 11:44:50'),
(193, 'SELECT_TIME_SLOT', 'Select time slot', 'Select time slot', 't', 'w', '2021-04-05 10:35:05', '2021-06-09 11:44:50'),
(194, 'START_DATE', 'Start date', 'Start date', 't', 'w', '2021-04-05 10:35:20', '2021-06-09 11:44:50'),
(195, 'END_DATE', 'End date', 'End date', 't', 'w', '2021-04-05 10:35:37', '2021-06-09 11:44:50'),
(196, 'SELECT_AVAILABILITY', 'Select Availability', 'Select Availability', 't', 'w', '2021-04-05 10:38:32', '2021-06-09 11:44:50'),
(197, 'LBL_YES', 'Yes', 'Yes', 't', 'w', '2021-04-05 10:38:46', '2021-06-09 11:44:50'),
(198, 'LBL_NO', 'No', 'No', 't', 'w', '2021-04-05 10:39:10', '2021-06-09 11:44:50'),
(199, 'INVALID_IMG_FILE', 'Invalid Image File', 'Invalid Image File', 't', 'w', '2021-04-05 10:41:46', '2021-06-09 11:44:50'),
(200, 'UPCOMING', 'Upcoming', 'Upcoming', 't', 'w', '2021-04-05 13:11:05', '2021-06-09 11:44:50'),
(201, 'COMPLETED', 'Completed', 'Completed', 't', 'w', '2021-04-05 13:33:53', '2021-06-09 11:44:50'),
(202, 'ONGOING', 'Ongoing', 'Ongoing', 't', 'w', '2021-04-05 13:34:23', '2021-06-09 11:44:50'),
(203, 'TEL', 'Tel', 'Tel', 't', 'w', '2021-04-05 13:37:02', '2021-06-09 11:44:50'),
(204, 'SERVICE_TYPE', 'Service Type', 'Service Type', 't', 'w', '2021-04-05 13:38:28', '2021-06-09 11:44:50'),
(205, 'BOOKING_DATE', 'Booking Date', 'Booking Date', 't', 'w', '2021-04-05 13:39:12', '2021-06-09 11:44:50'),
(206, 'SERVICE_DATE', 'Service Date', 'Service Date', 't', 'w', '2021-04-05 13:39:54', '2021-06-09 11:44:50'),
(207, 'SERVICE_SLOT', 'Service Slot', 'Service Slot', 't', 'w', '2021-04-05 13:40:48', '2021-06-09 11:44:50'),
(208, 'START_SERVICE', 'Start Service', 'Start Service', 't', 'w', '2021-04-05 13:41:23', '2021-06-09 11:44:50'),
(209, 'CANCEL_SERVICE', 'Cancel Service', 'Cancel Service', 't', 'w', '2021-04-05 13:43:45', '2021-06-09 11:44:50'),
(210, 'ACCEPT', 'Accept', 'Accept', 't', 'w', '2021-04-05 15:27:16', '2021-06-09 11:44:50'),
(211, 'REJECT', 'Reject', 'Reject', 't', 'w', '2021-04-05 15:27:51', '2021-06-09 11:44:50'),
(212, 'ACCEPTED', 'Accepted', 'Accepted', 't', 'w', '2021-04-05 15:28:13', '2021-06-09 11:44:50'),
(213, 'REJECTED', 'Rejected', 'Rejected', 't', 'w', '2021-04-05 15:28:29', '2021-06-09 11:44:50'),
(214, 'SER_REQ_ACCEPTED', 'Service request has been accepted.', 'Service request has been accepted.', 't', 'w', '2021-04-05 15:46:40', '2021-06-09 11:44:50'),
(215, 'SER_REQ_REJECTED', 'Service request has been rejected.', 'Service request has been rejected.', 't', 'w', '2021-04-05 15:47:03', '2021-06-09 11:44:50'),
(216, 'NEW_SERVICE_REQUEST', ' New Service Request ', ' Received Service Request ', 't', 'w', '2021-04-05 16:31:01', '2021-06-09 11:44:50'),
(217, 'NO_ANY_SER_REQ_REC', 'No any service request received.', 'No any service request received.', 't', 'w', '2021-04-05 17:32:01', '2021-06-09 11:44:50'),
(218, 'CANCELLED', 'Cancelled', 'Cancelled', 't', 'w', '2021-04-05 19:03:26', '2021-06-09 11:44:50'),
(219, 'AUTO_SERVICES', 'Auto Services', 'Auto Services', 't', 'w', '2021-04-05 19:04:48', '2021-06-09 11:44:50'),
(220, 'MSG_SURE_CANCEL_SERVICE', 'Are you sure you want to cancel this service?', 'Are you sure you want to cancel this service?', 't', 'w', '2021-04-06 16:47:26', '2021-06-09 11:44:50'),
(221, 'MSG_SERVICE_CANCELLED_SUC', 'Service request cancelled successfully.', 'Service request cancelled successfully.', 't', 'w', '2021-04-06 18:25:33', '2021-06-09 11:44:50'),
(222, 'CANCEL_BY_PROVIDER', 'Service request cancelled by provider.', 'Service request cancelled by provider.', 't', 'w', '2021-04-06 18:26:18', '2021-06-09 11:44:50'),
(223, 'CANCEL_BY_CUSTOMER', 'Service request cancelled by customer.', 'Service request cancelled by customer.', 't', 'w', '2021-04-06 18:26:52', '2021-06-09 11:44:50'),
(224, 'BOOK_NOW', 'Book Now', 'Book Now', 't', 'w', '2021-04-06 19:31:13', '2021-06-09 11:44:50'),
(225, 'CANT_REQUEST_OWN', 'You can not send service request to yourself.', 'You can not send service request to yourself.', 't', 'w', '2021-04-06 19:36:00', '2021-06-09 11:44:50'),
(226, 'MSG_SERVICE_STARTED_SUC', 'Service started successfully.', 'Service started successfully.', 't', 'w', '2021-04-07 12:17:39', '2021-06-09 11:44:50'),
(227, 'COMPLETE_SERVICE', 'Complete Service', 'Complete Service', 't', 'w', '2021-04-07 12:19:05', '2021-06-09 11:44:50'),
(228, 'MSG_SURE_COMPLETE_SERVICE', 'Are you sure you want to complete this service?', 'Are you sure you want to complete this service?', 't', 'w', '2021-04-07 12:21:26', '2021-06-09 11:44:50'),
(229, 'MSG_SURE_START_SERVICE', 'Are you sure you want to start this service?', 'Are you sure you want to start this service?', 't', 'w', '2021-04-07 12:22:35', '2021-06-09 11:44:50'),
(230, 'MSG_SERVICE_COMPLETED_SUC', 'Service marked as complete successfully.', 'Service marked as completed successfully.', 't', 'w', '2021-04-07 12:36:29', '2021-06-09 11:44:50'),
(231, 'COMPLETE_BY_PROVIDER', 'Service is marked as complete by provider.', 'Service is marked as complete by provider.', 't', 'w', '2021-04-07 12:37:52', '2021-06-09 11:44:50'),
(232, 'COMPLETE_BY_CUSTOMER', 'Service is marked as complete by customer.', 'Service is marked as complete by customer.', 't', 'w', '2021-04-07 12:38:31', '2021-06-09 11:44:50'),
(233, 'ENTER_REVIEW_DESC', 'Enter review description', 'Enter review description', 't', 'w', '2021-04-07 15:22:43', '2021-06-09 11:44:50'),
(234, 'MSG_ENTER_REVIEW', 'Please enter review.', 'Please enter review.', 't', 'w', '2021-04-07 15:41:22', '2021-06-09 11:44:50'),
(235, 'MSG_REVIEW_POSTED_SUC', 'Review posted successfully.', 'Review posted successfully.', 't', 'w', '2021-04-07 15:44:46', '2021-06-09 11:44:50'),
(236, 'MY_GIVEN_REVIEWS', 'My Given Reviews', 'My Given Reviews', 't', 'w', '2021-04-08 11:00:53', '2021-06-09 11:44:50'),
(237, 'REPLY_THIS_REVIEW', 'Please enter reply to this review.', 'Please enter reply to this review.', 't', 'w', '2021-04-08 11:45:54', '2021-06-09 11:44:50'),
(238, 'CUR_BAL', 'Current Balance', 'Current Balance', 't', 'w', '2021-04-08 11:58:09', '2021-06-09 11:44:50'),
(239, 'AMT_RECEIVABLE', 'Amount Receivable', 'Amount Receivable', 't', 'w', '2021-04-08 11:58:32', '2021-06-09 11:44:50'),
(240, 'RED_REQ', 'Redemption Request', 'Redemption Request', 't', 'w', '2021-04-08 11:58:52', '2021-06-09 11:44:50'),
(241, 'ENTER_RED_AMOUNT', 'Enter redemption amount', 'Enter redemption amount', 't', 'w', '2021-04-08 11:59:32', '2021-06-09 11:44:50'),
(242, 'WALLET_TRA_HIS', 'Wallet Transaction History', 'Wallet Transaction History', 't', 'w', '2021-04-08 11:59:59', '2021-06-09 11:44:50'),
(243, 'DEPOSIT_MONEY', 'Deposit Money', 'Deposit Money', 't', 'w', '2021-04-08 12:43:06', '2021-06-09 11:44:50'),
(244, 'ENTER_AMT_DEPOSIT', 'Enter Amount to be deposited', 'Enter Amount to be deposited', 't', 'w', '2021-04-08 12:43:32', '2021-06-09 11:44:50'),
(245, 'VAL_GRE_THAN_ZERO', ' Please enter a value greater than or equal to 1. ', ' Please enter a value greater than or equal to 1. ', 't', 'w', '2021-04-08 12:45:40', '2021-06-09 11:44:50'),
(246, 'VAL_LESS_THAN_NO_MORE', ' Please enter a value less than or equal to 50000. ', ' Please enter a value less than or equal to 50000. ', 't', 'w', '2021-04-08 12:46:18', '2021-06-09 11:44:50'),
(247, 'DOWNLOAD_FILE', 'Download File', 'Download File', 't', 'w', '2021-04-13 13:21:06', '2021-06-09 11:44:50'),
(248, 'MSG_NO_MSG_FOUND', 'No message found.', 'No message found.', 't', 'w', '2021-04-13 14:34:12', '2021-06-09 11:44:50'),
(249, 'MSG_MSG_MOVED_TO_TRASH', 'Messages moved to trash successfully.', 'Messages moved to trash successfully.', 't', 'w', '2021-04-13 14:34:50', '2021-06-09 11:44:50'),
(250, 'MSG_MSG_SENT_SUC', 'Message sent successfully.', 'Message sent successfully.', 't', 'w', '2021-04-13 14:43:06', '2021-06-09 11:44:50'),
(251, 'KM', 'Km', 'Km', 't', 'w', '2021-04-15 13:36:28', '2021-06-09 11:44:50'),
(252, 'PLZ_ENTER_MIZUTECH_DETAILS', 'Please enter your mizutech credentials from account settings.', 'Please enter your mizutech credentials from account settings.', 't', 'w', '2021-04-15 13:51:19', '2021-06-09 11:44:50'),
(253, 'CALL', 'Call', 'Call', 't', 'w', '2021-04-15 17:28:42', '2021-06-09 11:44:50'),
(254, 'HANG_UP', 'Hang Up', 'Hang Up', 't', 'w', '2021-04-15 17:29:47', '2021-06-09 11:44:50'),
(255, 'PROV_NOT_HAVE_MIZUTECH_DETAILS', 'Selected provider has not added mizutech account details yet.', 'Selected provider has not added mizutech credentials yet.', 't', 'w', '2021-04-16 10:44:49', '2021-06-09 11:44:50'),
(256, 'PLZ_LOGIN_TO_CONTINUE', 'Please first login to continue.', 'Please first login to continue.', 't', 'w', '2021-04-16 12:20:43', '2021-06-09 11:44:50'),
(257, 'CALL_SETUP', 'Call setup', 'Call setup', 't', 'w', '2021-04-19 11:06:05', '2021-06-09 11:44:50'),
(258, 'CALL_DISCONNECTED', 'Call disconnected', 'Call disconnected', 't', 'w', '2021-04-19 11:07:13', '2021-06-09 11:44:50'),
(259, 'CALL_TO_PROVIDER', 'Call to Provider', 'Call to Provider', 't', 'w', '2021-04-19 11:08:10', '2021-06-09 11:44:50'),
(260, 'INCOMING_CALL_FROM', 'Incoming Call From', 'Incoming Call From', 't', 'w', '2021-04-19 11:35:21', '2021-06-09 11:44:50'),
(261, 'CONVERSTION_WITH', 'Conversation With', 'Conversation With', 't', 'w', '2021-04-19 13:11:41', '2021-06-09 11:44:50'),
(262, 'ENTER_MSG', 'Enter Message', 'Enter Message', 't', 'w', '2021-04-19 13:12:17', '2021-06-09 11:44:50'),
(263, 'TRASH', 'Trash', 'Trash', 't', 'w', '2021-04-19 15:45:03', '2021-06-09 11:44:50'),
(264, 'NO_CHAT_FOUND', 'Your inbox is empty.', 'Your inbox is empty.', 't', 'w', '2021-04-19 15:56:23', '2021-06-09 11:44:50'),
(265, 'SEND', 'Send', 'Send', 't', 'w', '2021-04-19 16:37:51', '2021-06-09 11:44:50'),
(266, 'SEND_MSG', 'Send Message', 'Send Message', 't', 'w', '2021-04-19 16:38:34', '2021-06-09 11:44:50'),
(267, 'JUST_NOW', 'Just Now', 'Just Now', 't', 'w', '2021-04-19 17:14:07', '2021-06-09 11:44:50'),
(268, 'AGO', 'Ago', 'Ago', 't', 'w', '2021-04-19 17:14:49', '2021-06-09 11:44:50'),
(269, 'YEAR', 'Year', 'Year', 't', 'w', '2021-04-19 17:20:17', '2021-06-09 11:44:50'),
(270, 'MONTH', 'Month', 'Month', 't', 'w', '2021-04-19 17:20:38', '2021-06-09 11:44:50'),
(271, 'WEEK', 'Week', 'Week', 't', 'w', '2021-04-19 17:21:06', '2021-06-09 11:44:50'),
(272, 'DAY', 'Day', 'Day', 't', 'w', '2021-04-19 17:21:25', '2021-06-09 11:44:50'),
(273, 'HOUR', 'Hour', 'Hour', 't', 'w', '2021-04-19 17:21:44', '2021-06-09 11:44:50'),
(274, 'MINUTE', 'Minute', 'Minute', 't', 'w', '2021-04-19 17:22:04', '2021-06-09 11:44:50'),
(275, 'SECOND', 'Second', 'Second', 't', 'w', '2021-04-19 17:22:20', '2021-06-09 11:44:50'),
(276, 'TODAY', 'Today', 'Today', 't', 'w', '2021-04-19 17:23:13', '2021-06-09 11:44:50'),
(277, 'YESTERDAY', 'Yesterday', 'Yesterday', 't', 'w', '2021-04-19 17:23:57', '2021-06-09 11:44:50'),
(278, 'RCVD_MSG_FROM', 'You have received one new message from ', 'You have received one new message from ', 't', 'w', '2021-04-20 11:06:55', '2021-06-09 11:44:50'),
(279, 'TO_CHAT_WITH', 'to chat with', 'to chat with', 't', 'w', '2021-04-20 11:07:49', '2021-06-09 11:44:50'),
(280, 'INCOMING_MSG', 'Incoming Message', 'Incoming Message', 't', 'w', '2021-04-20 11:21:26', '2021-06-09 11:44:50'),
(281, 'IMEDIATE_AVAILABLE', 'Immediate Available ', 'Immediate Available ', 't', 'w', '2021-04-20 14:29:45', '2021-06-09 11:44:50'),
(282, 'ENTER_STATUS', 'Enter Status', 'Enter description', 't', 'w', '2021-04-20 15:10:04', '2021-06-09 11:44:50'),
(283, 'PLZ_ENTER_STATUS', 'Please enter status.', 'Please enter description.', 't', 'w', '2021-04-20 15:22:03', '2021-06-09 11:44:50'),
(284, 'SUC_STATUS_ADDED', 'Status added successfully.', 'Status added successfully.', 't', 'w', '2021-04-20 16:04:33', '2021-06-09 11:44:50'),
(285, 'MSG_SOMETHING_WRONG', 'Something went wrong.', 'Something went wrong.', 't', 'w', '2021-04-20 16:21:07', '2021-06-09 11:44:50'),
(286, 'UNAVAILABLE', 'Unavailable', 'Unavailable', 't', 'w', '2021-04-21 17:48:37', '2021-06-09 11:44:50'),
(287, 'BOOKED', 'Booked', 'Booked', 't', 'w', '2021-04-21 18:41:09', '2021-06-09 11:44:50'),
(288, 'PLZ_SELECT_AVAILABILITY', 'Please select availability.', 'Please select availability.', 't', 'w', '2021-04-22 17:59:22', '2021-06-09 11:44:50'),
(289, 'PLZ_SELECT_START_DATE', 'Please select start date.', 'Please select start date.', 't', 'w', '2021-04-22 21:54:03', '2021-06-09 11:44:50'),
(290, 'PLZ_SELECT_END_DATE', 'Please select end date.', 'Please select end date.', 't', 'w', '2021-04-22 21:54:46', '2021-06-09 11:44:50'),
(291, 'PLZ_SELECT_TIME_SLOT', 'Please select time slot.', 'Please select time slot.', 't', 'w', '2021-04-23 10:21:06', '2021-06-09 11:44:50'),
(292, 'MAKE_SLOT_AVAILABLE_MSG', 'Are you sure you want to make this slot available?', 'Are you sure you want to make this slot available?', 't', 'w', '2021-04-23 10:59:59', '2021-06-09 11:44:50'),
(293, 'MAKE_DATE_AVAILABLE_MSG', 'Are you sure you want to make this date available?', 'Are you sure you want to make this date available?', 't', 'w', '2021-04-23 14:39:20', '2021-06-09 11:44:50'),
(294, 'SERVICES_PROVIDED', 'Services Provided', 'Services Provided', 't', 'w', '2021-04-27 18:41:47', '2021-06-09 11:44:50'),
(295, 'RCVD_REVIEWS_RATINGS', 'Received Review and Ratings', 'Received Review and Ratings', 't', 'w', '2021-04-27 18:55:19', '2021-06-09 11:44:50'),
(296, 'ENTER_BRAND_NAME', 'Enter brand name', 'Enter vehicle brand name', 't', 'w', '2021-04-28 14:53:38', '2021-06-09 11:44:50'),
(297, 'ENTER_MODEL_NAME', 'Enter model name', 'Enter vehicle model name', 't', 'w', '2021-04-28 14:54:03', '2021-06-09 11:44:50'),
(298, 'ENTER_YEAR', 'Enter year', 'Enter vehicle year', 't', 'w', '2021-04-28 14:54:28', '2021-06-09 11:44:50'),
(299, 'ENTER_ENGINE_NO', 'Enter engine number', 'Enter VIN', 't', 'w', '2021-04-28 14:55:02', '2021-06-15 11:30:55'),
(300, 'MSG_VEHI_BRAND_REQ', 'Please enter vehicle brand name.', 'Please enter vehicle brand name.', 't', 'w', '2021-04-28 14:56:23', '2021-06-09 11:44:50'),
(301, 'MSG_VEHI_MODEL_REQ', 'Please enter vehicle model name.', 'Please enter vehicle model name.', 't', 'w', '2021-04-28 14:57:23', '2021-06-09 11:44:50'),
(302, 'MSG_VEHI_YEAR_REQ', 'Please enter vehicle year.', 'Please enter vehicle year.', 't', 'w', '2021-04-28 14:58:04', '2021-06-09 11:44:50'),
(303, 'MSG_VEHI_ENG_REQ', 'Please enter vehicle engine number.', 'Please enter VIN.', 't', 'w', '2021-04-28 15:01:49', '2021-06-15 11:30:14'),
(304, 'VEHI_BRAND', 'Vehicle Brand', 'Vehicle Brand', 't', 'w', '2021-04-28 16:03:46', '2021-06-09 11:44:50'),
(305, 'VEHI_MODEL', 'Vehicle Model', 'Vehicle Model', 't', 'w', '2021-04-28 16:04:22', '2021-06-09 11:44:50'),
(306, 'VEHI_YEAR', 'Vehicle Year', 'Vehicle Year', 't', 'w', '2021-04-28 16:04:54', '2021-06-09 11:44:50'),
(307, 'VEHI_ENGINE', 'Vehicle Engine No.', 'VIN', 't', 'w', '2021-04-28 16:05:43', '2021-06-15 11:29:26'),
(308, 'NEXT', 'Next', 'Next', 't', 'w', '2021-04-28 19:13:09', '2021-06-09 11:44:50'),
(309, 'SURE_MOVE_TO_TRASH', 'Are you sure you want to move this chat to trash?', 'Are you sure you want to move this chat to trash?', 't', 'w', '2021-04-30 12:16:40', '2021-06-09 11:44:50'),
(310, 'STATUS', 'Status', 'Status', 't', 'w', '2021-05-03 12:32:04', '2021-06-09 11:44:50'),
(311, 'BOOK', 'Book', 'Book', 't', 'w', '2021-05-03 12:34:08', '2021-06-09 11:44:50'),
(312, 'SERVICE', 'Service', 'Service', 't', 'w', '2021-05-03 15:29:38', '2021-06-09 11:44:50'),
(313, 'AUTO', 'Auto', 'Auto', 't', 'w', '2021-05-03 15:30:33', '2021-06-09 11:44:50'),
(314, 'MY_SERVICE_REQUEST', 'My Service Request', 'My Service Request', 't', 'w', '2021-05-04 15:08:02', '2021-06-09 11:44:50'),
(315, 'NO_REQUEST_SENT', 'No any service request sent.', 'No any service request sent.', 't', 'w', '2021-05-04 15:11:39', '2021-06-09 11:44:50'),
(316, 'PENDING', 'Pending', 'Pending', 't', 'w', '2021-05-04 15:13:34', '2021-06-09 11:44:50'),
(317, 'SERVICE_REQUEST', 'New Service Request', 'New Service Request', 't', 'w', '2021-05-06 12:05:51', '2021-06-09 11:44:50'),
(318, 'PROVIDER_AVAILABILITY', 'Provider Availability', 'Provider Availability', 't', 'w', '2021-05-06 12:16:23', '2021-06-09 11:44:50'),
(319, 'SELECT_SERVICE_START_DATE', 'Select start date', 'Select start date', 't', 'w', '2021-05-06 12:48:34', '2021-06-09 11:44:50'),
(320, 'SELECT_SERVICE_END_DATE', 'Select end date', 'Select end date', 't', 'w', '2021-05-06 12:50:08', '2021-06-09 11:44:50'),
(321, 'TAXI_PROV_NOT_AVAILABLE', 'Provider is not available for selected dates.', 'Provider is not available for selected dates.', 't', 'w', '2021-05-06 14:30:02', '2021-06-09 11:44:50'),
(322, 'ENTER_VALID_NUMBER', 'Please enter valid amount.', 'Please enter valid amount.', 't', 'w', '2021-05-10 16:06:09', '2021-06-09 11:44:50'),
(323, 'MSG_AMOUNT_ADDED_SUC', 'Booking amount saved successfully.', 'Booking amount saved successfully.', 't', 'w', '2021-05-10 16:16:08', '2021-06-09 11:44:50'),
(324, 'PROIVDER_ADDED_AMOUNT', 'Provided Added Amount', 'Provider Added Amount', 't', 'w', '2021-05-10 16:44:15', '2021-06-09 11:44:50'),
(325, 'ONLINE', 'Online', 'Online', 't', 'w', '2021-05-13 17:28:20', '2021-06-09 11:44:50'),
(326, 'OFFLINE', 'Offline', 'Offline', 't', 'w', '2021-05-13 17:28:43', '2021-06-09 11:44:50'),
(327, 'PLZ_SELECT_PAYMENT_METHOD', 'Please select payment method.', 'Please select payment method.', 't', 'w', '2021-05-13 17:33:40', '2021-06-09 11:44:50'),
(328, 'MSG_PAYMENT_METHOD_SUC', 'Payment method successfully set as offline payment.', 'Payment method successfully set as selected by you.', 't', 'w', '2021-05-13 18:27:05', '2021-06-09 11:44:50'),
(329, 'PROV_HAS_NOT_ADDED_PAYPAL', 'Provider has not added Paypal ID yet.', 'Provider has not added Paypal ID yet.', 't', 'w', '2021-05-13 18:41:01', '2021-06-09 11:44:50'),
(330, 'SERVICE_BOOKING_PAYMENT_FAILED', 'Service booking payment failed. Please try again.', 'Service booking payment failed. Please try again.', 't', 'w', '2021-05-14 13:01:48', '2021-06-09 11:44:50'),
(331, 'SERVICE_BOOKING_PAYMENT_suc', 'Thank you , Payment status for this transaction is pending. Your payment is confirmed once completed.', 'Thank you , Payment status for this transaction is pending. Your payment is confirmed once completed.', 't', 'w', '2021-05-14 13:04:38', '2021-06-09 11:44:50'),
(332, 'PAYMENT_HISTORY', 'Payment History', 'Payment History', 't', 'w', '2021-05-15 12:25:56', '2021-06-09 11:44:50'),
(333, 'NO_HISTORY_FOUND', 'No any payment history record found.', 'No any payment history record found.', 't', 'w', '2021-05-15 12:33:11', '2021-06-09 11:44:50'),
(334, 'TRANSACTION_ID', 'Transaction ID', 'Transaction ID', 't', 'w', '2021-05-15 14:05:03', '2021-06-09 11:44:50'),
(335, 'TRANS_DATE', 'Transaction Date', 'Transaction Date', 't', 'w', '2021-05-15 14:09:06', '2021-06-09 11:44:50'),
(336, 'USER_NAME', 'User Name', 'User Name', 't', 'w', '2021-05-15 14:11:01', '2021-06-09 11:44:50'),
(337, 'PAYMENT_METHOD', 'Payment Method', 'Payment Method', 't', 'w', '2021-05-15 14:11:44', '2021-06-09 11:44:50'),
(338, 'MIZUTECH_DETAILS', 'Mizutech Details', 'Mizutech Details', 't', 'w', '2021-05-17 14:44:59', '2021-06-09 11:44:50'),
(339, 'ENTER_MIZU_NAME', 'Enter mizutech name', 'Enter mizutech name', 't', 'w', '2021-05-17 14:46:05', '2021-06-09 11:44:50'),
(340, 'ENTER_MIZU_PWD', 'Enter mizutech password', 'Enter mizutech password', 't', 'w', '2021-05-17 14:46:31', '2021-06-09 11:44:50'),
(341, 'MSG_ENT_MIZU_NAME', 'Please enter mizutech name.', 'Please enter mizutech name.', 't', 'w', '2021-05-17 14:58:18', '2021-06-09 11:44:50'),
(342, 'MSG_ENT_MIZU_PWD', 'Please enter mizutech password.', 'Please enter mizutech password.', 't', 'w', '2021-05-17 14:58:46', '2021-06-09 11:44:50'),
(343, 'MIZU_DETAILS_SAVED_SUC', 'Mizutech details saved successfully.', 'Mizutech details saved successfully.', 't', 'w', '2021-05-17 15:02:29', '2021-06-09 11:44:50'),
(344, 'LOCATION_DETAILS', 'Location Details', 'Location Details', 't', 'w', '2021-05-17 15:33:25', '2021-06-09 11:44:50'),
(345, 'CANCEL_BY_YOU', 'Service request cancelled by you.', 'Service request cancelled by you.', 't', 'w', '2021-05-17 16:30:57', '2021-06-09 11:44:50'),
(346, 'REQUEST_RECEIVED_NOTI_MSG', 'New service request received.', 'New service request received.', 't', 'w', '2021-05-17 16:38:29', '2021-06-09 11:44:50'),
(347, 'REQUEST_ACCEPTED_NOTI_MSG', 'Service request accepted by provider.', 'Service request accepted by provider.', 't', 'w', '2021-05-17 16:57:14', '2021-06-09 11:44:50'),
(348, 'LOAD_PREVIOUS', 'Load Previous', 'Load Previous', 't', 'w', '2021-05-18 15:15:10', '2021-06-09 11:44:50'),
(349, 'SELECT_CUSTOMER', 'Select Customer', 'Select Customer', 't', 'w', '2021-05-19 14:48:05', '2021-06-09 11:44:50'),
(350, 'PLZ_SELECT_CUSTOMER', 'Please select customer.', 'Please select customer.', 't', 'w', '2021-05-19 15:17:12', '2021-06-09 11:44:50'),
(351, 'ADD_AMOUNT', 'Add Amount', 'Add Amount', 't', 'w', '2021-05-20 11:45:49', '2021-06-09 11:44:50'),
(352, 'ADD_REVIEW', 'Add Review', 'Add Review', 't', 'w', '2021-05-20 11:49:21', '2021-06-09 11:44:50'),
(353, 'ONE_LETTER_REQUIRED', 'Please enter at least one letter.', 'Please enter at least one letter.', 't', 'w', '2021-05-20 14:44:19', '2021-06-09 11:44:50'),
(354, 'INVALID_RESET_LINK', 'Given reset password link is invalid.', 'Given reset password link is expired.', 't', 'w', '2021-05-20 15:43:59', '2021-06-09 11:44:50'),
(355, 'ADD_REQUEST', 'Add Request', 'Add Request', 't', 'w', '2021-05-21 10:29:40', '2021-06-09 11:44:50'),
(356, 'RESEND_VERIFICATION_MAIL', 'Resend verification mail', 'Resend verification mail', 't', 'w', '2021-05-21 12:14:10', '2021-06-09 11:44:50'),
(357, 'invalidEmailId', 'Invalid EmaiId', 'Invalid EmaiId', 't', 'w', '2021-05-21 12:23:12', '2021-06-09 11:44:50'),
(358, 'HINT_FNAME', 'Enter first name*', 'Enter first name*', 't', 'w', '2021-05-21 13:50:21', '2021-06-09 11:44:50'),
(359, 'DONT_ACCOUNT', 'Don\\\'t you have an account?', 'Don\\\'t you have an account?', 't', 'w', '2021-05-21 13:52:40', '2021-06-09 11:44:50'),
(360, 'HINT_LNAME', 'Enter last name*', 'Enter last name*', 't', 'w', '2021-05-21 13:54:51', '2021-06-09 11:44:50'),
(361, 'HINT_CONTACT_NO', 'Enter contact number*', 'Enter contact number*', 't', 'w', '2021-05-21 13:58:11', '2021-06-09 11:44:50'),
(362, 'HINT_EMAIL_ID', 'Enter email id*', 'Enter email id*', 't', 'w', '2021-05-21 14:00:21', '2021-06-09 11:44:50'),
(363, 'HINT_PWD', 'Enter password*', 'Enter password*', 't', 'w', '2021-05-21 14:01:58', '2021-06-09 11:44:50'),
(364, 'HINT_PWD_CONFITM', 'Enter confirm password*', 'Enter confirm password*', 't', 'w', '2021-05-21 14:03:15', '2021-06-09 11:44:50'),
(365, 'ERR_MSG_INVALID_CONTACT', 'Invalid contact number', 'Invalid contact number', 't', 'w', '2021-05-21 14:13:45', '2021-06-09 11:44:50'),
(366, 'SETTINGS', 'Settings', 'Settings', 't', 'w', '2021-05-21 14:26:56', '2021-06-09 11:44:50'),
(367, 'MSG_SURE_LOGOUT', 'Are you sure to logout?', 'Are you sure to logout?', 't', 'w', '2021-05-21 14:36:46', '2021-06-09 11:44:50'),
(368, 'EXIT', 'Exit', 'Exit', 't', 'w', '2021-05-21 14:39:19', '2021-06-09 11:44:50'),
(369, 'MSG_SURE_EXIT', 'Are you sure to exit?', 'Are you sure to exit?', 't', 'w', '2021-05-21 14:40:34', '2021-06-09 11:44:50'),
(370, 'MORE', 'More', 'More', 't', 'w', '2021-05-21 14:53:14', '2021-06-09 11:44:50'),
(371, 'LOC_NOT_FOUND', 'Location not found', 'Location not found', 't', 'w', '2021-05-21 15:15:47', '2021-06-09 11:44:50'),
(372, 'FILTER_BY', 'Filter by', 'Filter by', 't', 'w', '2021-05-21 15:46:00', '2021-06-09 11:44:50'),
(373, 'APPLY_FILTER', 'Apply Filter', 'Apply Filter', 't', 'w', '2021-05-21 15:50:13', '2021-06-09 11:44:50'),
(374, 'ERR_MSG_RADIUS', 'Radius must be greater than zero', 'Radius must be greater than zero', 't', 'w', '2021-05-21 15:55:27', '2021-06-09 11:44:50'),
(375, 'ERR_MSG_FILTER', 'No data found for filter', 'No data found for filter', 't', 'w', '2021-05-21 15:58:01', '2021-06-09 11:44:50'),
(376, 'PROFILE_IMG', 'Upload Profile Picture', 'Upload Profile Picture', 't', 'w', '2021-05-21 16:19:51', '2021-06-09 11:44:50'),
(377, 'SEND_REQ', 'Send Request', 'Send Request', 't', 'w', '2021-05-21 16:54:18', '2021-06-09 11:44:50'),
(378, 'DELETE', 'Delete', 'Delete', 't', 'w', '2021-05-21 17:25:19', '2021-06-09 11:44:50'),
(379, 'MSG_SURE_DELETE', 'Are you sure want to delete?', 'Are you sure you want to delete?', 't', 'w', '2021-05-21 17:27:05', '2021-06-09 11:44:50'),
(380, 'LANG_SELECTION', 'Language Selection', 'Language Selection', 't', 'w', '2021-05-24 09:17:09', '2021-06-09 11:44:50'),
(381, 'UPDATE_BTN', 'Update', 'Update', 't', 'w', '2021-05-24 09:21:31', '2021-06-09 11:44:50'),
(382, 'VIN', 'VIN', 'VIN', 't', 'w', '2021-05-24 10:03:34', '2021-06-09 11:44:50'),
(383, 'ENGINE_POW_KW', 'Engine Power (kW)', 'Engine Power (kW)', 't', 'w', '2021-05-24 10:05:31', '2021-06-09 11:44:50'),
(384, 'ERR_MSG_SERVICE_AMT', 'Please enter service amount', 'Please enter service amount', 't', 'w', '2021-05-24 10:21:03', '2021-06-09 11:44:50'),
(385, 'ERR_MSG_SERVICE_AMT_GREATER_ZERO', 'Service amount must be greater than zero', 'Service amount must be greater than zero', 't', 'w', '2021-05-24 10:22:39', '2021-06-09 11:44:50'),
(386, 'ERR_MSG_SERVICE_DESC', 'Please enter service description', 'Please enter service description', 't', 'w', '2021-05-24 10:24:10', '2021-06-09 11:44:50');
INSERT INTO `tbl_constant` (`id`, `constantName`, `value`, `value_1`, `type`, `status`, `created_date`, `updated_date`) VALUES
(387, 'ENTER_SERVICE_NAME', 'Enter service name', 'Enter service name', 't', 'w', '2021-05-24 10:24:39', '2021-06-09 11:44:50'),
(388, 'VIN_NOT_FOUND', 'VIN number not found', 'VIN number not found', 't', 'w', '2021-05-24 10:25:49', '2021-06-09 11:44:50'),
(389, 'PLZ_ENTER_SERVICE_NAME', 'Please enter service name.', 'Please enter service name.', 't', 'w', '2021-05-24 10:28:59', '2021-06-09 11:44:50'),
(390, 'PREVIOUS', 'Previous', 'Previous', 't', 'w', '2021-05-24 10:39:29', '2021-06-09 11:44:50'),
(391, 'SERVICE_LOC_MAP', 'Service Location Map', 'Service Location Map', 't', 'w', '2021-05-24 10:39:51', '2021-06-09 11:44:50'),
(392, 'POST_REVIEW', 'Post Review', 'Post Review', 't', 'w', '2021-05-24 10:42:13', '2021-06-09 11:44:50'),
(393, 'PAY_BTN', 'Pay', 'Pay', 't', 'w', '2021-05-24 10:47:07', '2021-06-09 11:44:50'),
(394, 'MSG_GIVE_RATING', 'Please give rating', 'Please give rating', 't', 'w', '2021-05-24 11:00:27', '2021-06-09 11:44:50'),
(395, 'YOU_HAVe_PAID', 'You have paid', 'You have paid', 't', 'w', '2021-05-24 11:02:22', '2021-06-09 11:44:50'),
(396, 'LBL_TO', 'to', 'to', 't', 'w', '2021-05-24 11:04:06', '2021-06-09 11:44:50'),
(397, 'LBL_BY', 'by', 'by', 't', 'w', '2021-05-24 11:05:14', '2021-06-09 11:44:50'),
(398, 'PAYMENT_CANCELLED', 'Payment Cancelled', 'Payment Cancelled', 't', 'w', '2021-05-24 11:07:53', '2021-06-09 11:44:50'),
(399, 'SERVICE_CATEGORY', 'Service Category', 'Service Category', 't', 'w', '2021-05-24 11:19:48', '2021-06-09 11:44:50'),
(400, 'MAX_FIVE_IMG_ALLOW', 'Maximum five images allow', 'Maximum five images allow', 't', 'w', '2021-05-24 14:10:51', '2021-06-09 11:44:50'),
(401, 'UPLOAD_PICTURE', 'Upload Picture', 'Upload Picture', 't', 'w', '2021-05-24 14:22:59', '2021-06-09 11:44:50'),
(402, 'ALERT_LBL', 'Alert', 'Alert', 't', 'w', '2021-05-24 15:06:04', '2021-06-09 11:44:50'),
(403, 'ERR_MSG_CUS_MIZ_DETIAL_NOT_FOUND', 'You are not eligible to make a call or did not get live messages due to Mizutech account detail not found.', 'You are not eligible to make a call or did not get live messages due to Mizutech account detail not found.', 't', 'w', '2021-05-24 15:08:16', '2021-06-09 11:44:50'),
(404, 'OK_BTN', 'Ok', 'Ok', 't', 'w', '2021-05-24 15:09:34', '2021-06-09 11:44:50'),
(405, 'PLZ_UPLAOD_PROFILE_PIC', 'Please upload profile picture.', 'Please upload profile picture.', 't', 'w', '2021-05-24 15:13:07', '2021-06-09 11:44:50'),
(406, 'VIEW_DETAIL', 'View Detail', 'View Detail', 't', 'w', '2021-05-24 16:16:33', '2021-06-09 11:44:50'),
(407, 'LBL_FROM', 'from', 'from', 't', 'w', '2021-05-24 17:24:24', '2021-06-09 11:44:50'),
(408, 'YOU_HAVE_RECEIVED', 'You have received', 'You have received', 't', 'w', '2021-05-24 17:25:42', '2021-06-09 11:44:50'),
(409, 'PLZ_ENABLE_LOCATION', 'Please allow the access of your location from \r\n browser settings so that you can see proper result.', 'Please allow the access of your location from \r\n browser settings so that you can see proper result.', 't', 'w', '2021-05-24 17:43:38', '2021-06-09 11:44:50'),
(410, 'ERR_MSG_MIN_IMG', 'Please select  minimum one image', 'Please select  minimum one image', 't', 'w', '2021-05-25 12:53:15', '2021-06-09 11:44:50'),
(411, 'POST_REG', 'Post Registration', 'Post Registration', 't', 'w', '2021-05-25 12:56:04', '2021-06-09 11:44:50'),
(412, 'NO_GIVEN_REVIEW', 'No any given reviews.', 'No any given reviews.', 't', 'w', '2021-05-25 15:09:46', '2021-06-09 11:44:50'),
(413, 'TRY_OTHER_IMAGE', 'There seems some issue with this file. Please try to upload other image.', 'There seems some issue with this file. Please try to upload other image.', 't', 'w', '2021-05-25 18:24:30', '2021-06-09 11:44:50'),
(414, 'NOT_CANCEL_ONGOING_SERVICE', 'You can not cancel ongoing service.', 'You can not cancel ongoing service.', 't', 'w', '2021-05-29 11:35:05', '2021-06-09 11:44:50'),
(415, 'NOT_START_CANCEL_SERVICE', 'You can not start cancelled service.', 'You can not start cancelled service.', 't', 'w', '2021-05-29 11:44:29', '2021-06-09 11:44:50'),
(416, 'PROVIDER_PROFILE', 'Provider\\\'s Profile', 'Provider\\\'s Profile', 't', 'w', '2021-05-29 12:11:35', '2021-06-09 11:44:50'),
(417, 'CUSTOMER_PROFILE', 'Customer\\\'s Profile', 'Customer\\\'s Profile', 't', 'w', '2021-05-29 12:12:04', '2021-06-09 11:44:50'),
(418, 'ENTER_VALID_VIN', 'Please enter valid VIN.', 'Please enter valid VIN.', 't', 'w', '2021-05-29 12:34:09', '2021-06-09 11:44:50'),
(419, 'NOT_UPDATE_BOOKED_TIME', 'You have booking scheduled in selected days. You can not make it unavailable.', 'You have booking scheduled in selected days. You can not make it unavailable.', 't', 'w', '2021-05-31 17:55:52', '2021-06-09 11:44:50'),
(420, 'NOT_SELECT_PAST_TIME', 'You can not select past time.', 'You can not make any change in availability in  past date/time.', 't', 'w', '2021-05-31 18:41:11', '2021-06-22 11:22:14'),
(421, 'HINT_EMAIL_OR_CONTACT', 'Enter email ID/contact No.*', 'Enter email ID/contact No.*', 't', 'w', '2021-06-01 09:51:05', '2021-06-09 11:44:50'),
(422, 'NOT_ALLOWED_TO_ACCESS_PAGE', 'You are not allowed to access this page.', 'You are not allowed to access this page.', 't', 'w', '2021-06-02 18:18:34', '2021-06-09 11:44:50'),
(423, 'ADMIN_DELETED_ACCT', 'Admin has deleted your account. Please contact admin.', 'Admin has deleted your account. Please contact admin.', 't', 'w', '2021-06-03 10:55:06', '2021-06-09 11:44:50'),
(424, 'ALREADY_REVIEWED', 'You have already given reviews for this service.', 'You have already given reviews for this service.', 't', 'w', '2021-06-04 12:59:10', '2021-06-09 11:44:50'),
(425, 'CALL_TO_CUSTOMER', 'Call to Customer', 'Call to Customer', 't', 'w', '2021-06-04 13:19:32', '2021-06-09 11:44:50'),
(426, 'PLZ_SELECT_ATLEAST_ONE_USER', 'Please select at least one user for chat.', 'Please select at least one user for chat.', 't', 'w', '2021-06-04 14:56:39', '2021-06-09 11:44:50'),
(427, 'NAME_ALREADY_EXIST', 'Entered first name and last name already exists.', 'Entered first name and last name already exists.', 't', 'w', '2021-06-04 16:02:04', '2021-06-09 11:44:50'),
(428, 'ENTER_MILEAGE', 'Enter Mileage', 'Enter Mileage', 't', 'w', '2021-06-04 16:57:45', '2021-06-09 11:44:50'),
(429, 'VEHI_MILEAGE', 'Vehicle Mileage', 'Vehicle Mileage', 't', 'w', '2021-06-04 16:58:48', '2021-06-09 11:44:50'),
(430, 'MSG_VEHI_MILEAGE', 'Please enter vehicle mileage', 'Please enter vehicle mileage', 't', 'w', '2021-06-04 17:51:16', '2021-06-09 11:44:50'),
(431, 'HINT_SEARCH_RADIUS_KM', 'Enter Search Radius (Km)*', 'Enter Search Radius (Km)*', 't', 'w', '2021-06-08 17:15:37', '2021-06-09 11:44:50'),
(432, 'HINT_SUBJECT', 'Enter subject*', 'Enter subject*', 't', 'w', '2021-06-08 17:39:02', '2021-06-09 11:44:50'),
(433, 'HINT_DESC', 'Enter description *', 'Enter description*', 't', 'w', '2021-06-08 17:42:49', '2021-06-09 11:44:50'),
(434, 'PROVIDER_NAME', 'Provider Name', 'Provider Name', 't', 'w', '2021-06-09 10:39:55', '2021-06-09 11:44:50'),
(435, 'HINT_LOC_DETAIL', 'Please enter location detail', 'Please enter location detail', 't', 'w', '2021-06-09 15:39:10', '2021-06-09 11:44:50'),
(436, 'HINT_SERVICE_AMOUNT', 'Enter amount ($)*', 'Enter amount ($)*', 't', 'w', '2021-06-11 10:33:08', '2021-06-11 05:03:09'),
(437, 'ADD_OPENING_HOURS', 'Add Opening Hours', 'Add Opening Hours', 't', 'w', '2021-06-15 18:26:27', '2021-06-15 12:56:27'),
(438, 'ENTER_OPENING_HOURS', 'Enter opening hours', 'Enter opening hours', 't', 'w', '2021-06-15 18:45:42', '2021-06-15 13:15:42'),
(439, 'PLZ_ENTER_OPENING_HRS', 'Please enter opening hours.', 'Please enter opening hours.', 't', 'w', '2021-06-16 10:57:59', '2021-06-16 05:27:59'),
(440, 'SUC_HOURS_ADDED', 'Opening hours added successfully.', 'Opening hours added successfully.', 't', 'w', '2021-06-16 11:06:42', '2021-06-16 05:36:42'),
(441, 'OPENING_HOURS', 'Opening Hours', 'Opening Hours', 't', 'w', '2021-06-16 11:19:45', '2021-06-16 05:49:45'),
(442, 'MSG_REGISTERED_SUC_CUST', 'You have successfully registered.', 'You have successfully registered.', 't', 'w', '2021-06-16 11:47:51', '2021-06-16 06:17:51'),
(443, 'ENTER_BUSINESS_DETAILS', 'Enter business details', 'Enter business details', 't', 'w', '2021-06-16 13:14:44', '2021-06-16 07:44:44'),
(444, 'BUSINESS_DETAILS', 'Business Details', 'Business Details', 't', 'w', '2021-06-16 13:32:05', '2021-06-16 08:02:05'),
(445, 'SELECT_TIME', 'Select Time', 'Select Time', 't', 'w', '2021-06-18 09:26:44', '2021-06-18 03:56:44'),
(446, 'PLZ_SELECT_TIME', 'Please select time.', 'Please select time.', 't', 'w', '2021-06-18 09:28:04', '2021-06-18 03:58:04'),
(447, 'LBL_TIME', 'Time', 'Time', 't', 'w', '2021-06-18 16:04:20', '2021-06-18 10:34:20'),
(448, 'NO_USER_FOUND', 'No user found', 'No user found', 't', 'w', '2021-06-19 13:38:56', '2021-06-19 08:08:56'),
(449, 'INVALID_MIZUTECH_DETAILS', 'Invalid mizutech details.', 'Invalid mizutech details.', 't', 'w', '2021-06-19 14:53:27', '2021-06-19 09:23:27'),
(450, 'PAYMENT_SUCCESS', 'Payment has been success', 'Payment has been success', 't', 'w', '2021-06-19 17:06:19', '2021-06-19 11:36:19'),
(451, 'MSG_ALREADY_AMT_ADDED', 'You have already added amount.', 'You have already added amount.', 't', 'w', '2021-06-21 18:31:49', '2021-06-21 13:01:49'),
(452, 'MSG_INVALID_MIZUTECH_1', 'Mizutech credential invalid found, Please add correct credential to get call and live chat experience', 'Mizutech credential invalid found, Please add correct credential to get call and live chat experience', 't', 'w', '2021-06-22 10:34:02', '2021-06-22 05:04:02'),
(453, 'MSG_INVALID_MIZUTECH_2', 'Mizutech credential invalid/not found, Please update it from your setting for get call and live chat experience', 'Mizutech credential invalid/not found, Please update it from your setting for get call and live chat experience', 't', 'w', '2021-06-22 10:36:03', '2021-06-22 05:06:03'),
(454, 'ALRDY_PAID', 'You have already paid.', 'You have already paid.', 't', 'w', '2021-06-22 16:01:42', '2021-06-22 10:31:42'),
(455, 'ALRDY_INITIATED_PAYMENT', 'You have already initiated payment.', 'You have already initiated payment.', 't', 'w', '2021-06-22 16:02:11', '2021-06-22 10:32:11'),
(456, 'UPLD_VALID_FILE', 'Only images, video or audio file allowed.', 'Only images, video or audio file allowed.', 't', 'w', '2021-06-22 16:17:53', '2021-06-22 10:47:53'),
(457, 'ALRDY_INITIATED_PAYMENT_WAIT', 'You have already initiated payment. Please wait for 10 minutes.', 'You have already initiated payment. Please wait for 10 minutes.', 't', 'w', '2021-07-05 11:55:29', '2021-07-05 06:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_constant_copy`
--

CREATE TABLE `tbl_constant_copy` (
  `id` int(11) NOT NULL,
  `constantName` varchar(255) NOT NULL,
  `value` text,
  `value_2` text NOT NULL,
  `value_1` varchar(255) DEFAULT NULL,
  `type` enum('f','m','t','s') NOT NULL DEFAULT 'm' COMMENT 'f=fields,m=msg,t=title,s=system',
  `status` enum('w','a','b') NOT NULL DEFAULT 'w' COMMENT 'w-web , a- apps, b- both',
  `created_date` datetime DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_constant_copy`
--

INSERT INTO `tbl_constant_copy` (`id`, `constantName`, `value`, `value_2`, `value_1`, `type`, `status`, `created_date`, `updated_date`) VALUES
(1, 'FILL_VALUES', 'Please fill all the values.', 'Please fill all the values.', 'Please fill all the values.', 't', 'w', '2021-02-19 16:21:33', '2021-05-25 06:25:11'),
(2, 'PWD_RESET_SUCC', 'Password reset successfully.', 'Password reset successfully.', 'Password reset successfully.', 't', 'w', '2021-02-19 16:22:30', '2021-05-25 06:25:11'),
(3, 'NEW_CNFM_PASS_MATCH', 'New Password and Confirm Password Must Match.', 'New Password and Confirm Password Must Match.', 'New Password and Confirm Password Must Match.', 't', 'w', '2021-02-19 16:23:11', '2021-05-25 06:25:11'),
(4, 'WENT_WRONG', 'Something went wrong.', 'Something went wrong.', 'Something went wrong.', 't', 'w', '2021-02-19 16:23:46', '2021-05-25 06:25:11'),
(5, 'PROVIDE_CODE', 'Please provide a verification code.', 'Please provide a verification code.', 'Please provide a verification code.', 't', 'w', '2021-02-19 16:24:45', '2021-05-25 06:25:11'),
(6, 'RESET_PASSWORD', 'Reset Password', 'Reset Password', 'Reset Password', 't', 'w', '2021-02-19 16:25:26', '2021-05-25 06:25:11'),
(7, 'ENTER_NEW_PASS', 'Please enter new password.', 'Please enter new password.', 'Please enter new password.', 't', 'w', '2021-02-19 16:26:48', '2021-05-25 06:25:11'),
(8, 'MIN_SIX_CHAR_REQUIRED', 'Minimum 6 character required.', 'Minimum 6 character required.', 'Minimum 6 character required.', 't', 'w', '2021-02-19 16:27:23', '2021-05-25 06:25:11'),
(9, 'ENTER_CNFM_PASS', 'Please enter confirm password.', 'Please enter confirm password.', 'Please enter confirm password.', 't', 'w', '2021-02-19 16:28:42', '2021-05-25 06:25:11'),
(10, 'MSG_EMAIL_REQ', 'Please enter email address.', 'Please enter email address.', 'Please enter email address.', 't', 'w', '2021-02-19 16:29:36', '2021-05-25 06:25:11'),
(11, 'MSG_VALID_EMAIL', 'Please enter valid email address.', 'Please enter valid email address.', 'Please enter valid email address.', 't', 'w', '2021-02-19 16:29:55', '2021-05-25 06:25:11'),
(12, 'MSG_PASS_REQ', 'Please enter password.', 'Please enter password.', 'Please enter password.', 't', 'w', '2021-02-19 16:30:14', '2021-05-25 06:25:11'),
(13, 'MSG_ACTIVATION_MAIL_SENT', 'Activation mail sent successfully.', 'Activation mail sent successfully.', 'Activation mail sent successfully.', 't', 'w', '2021-02-19 16:31:52', '2021-05-25 06:25:11'),
(14, 'MSG_EMAIL_NOT_EXIST', 'This email address does not exist.', 'This email address does not exist.', 'This email address does not exist.', 't', 'w', '2021-02-19 16:32:44', '2021-05-25 06:25:11'),
(15, 'MSG_ACCOUNT_ACTIVATED', 'Your account is already activated.', 'Your account is already activated.', 'Your account is already activated.', 't', 'w', '2021-02-19 16:33:24', '2021-05-25 06:25:11'),
(16, 'MSG_RESET_PASSWORD_MAIL_SEND', 'Reset password link sent successfully. Please check your mail.', 'Reset password link sent successfully. Please check your mail.', 'Reset password link sent successfully. Please check your mail.', 't', 'w', '2021-02-19 16:39:07', '2021-05-25 06:25:11'),
(17, 'MSG_ACCT_DEACTIVED', 'Admin has deactivated your account. Please contact admin.', 'Admin has deactivated your account. Please contact admin.', 'Admin has deactivated your account. Please contact admin.', 't', 'w', '2021-02-19 16:40:02', '2021-05-25 06:25:11'),
(18, 'MSG_ACTIVATE_ACC', 'Please activate your account first.', 'Please activate your account first.', 'Please activate your account first.', 't', 'w', '2021-02-19 16:40:40', '2021-05-25 06:25:11'),
(19, 'MSG_ACCOUNT_SUC_ACTIVATED', 'Account successfully activated.', 'Account successfully activated.', 'Your account is successfully activated.', 't', 'w', '2021-02-19 16:44:36', '2021-05-25 06:25:11'),
(20, 'MSG_INVALID_VERI_CODE', 'Entered verification code is invalid.', 'Entered verification code is invalid.', 'Given activation link is invalid.', 't', 'w', '2021-02-19 16:45:39', '2021-05-25 06:25:11'),
(21, 'MSG_LOGIN_SUC', 'Successfully logged in to', 'Successfully logged in to', 'Successfully logged in to', 't', 'w', '2021-02-19 16:46:47', '2021-05-25 06:25:11'),
(22, 'MSG_INVALID_LOGIN', 'Entered login details are invalid.', 'Entered login details are invalid.', 'Entered login details are invalid.', 't', 'w', '2021-02-19 16:48:08', '2021-05-25 06:25:11'),
(23, 'WIN_LOGIN', 'Login', 'Login', 'Log in', 't', 'w', '2021-02-19 16:49:18', '2021-05-25 06:25:11'),
(24, 'REMEMBER_ME', 'Remember Me', 'Remember Me', 'Remember Me', 't', 'w', '2021-02-19 16:51:05', '2021-05-25 06:25:11'),
(25, 'FORGOT_PASSWORD', 'Forgot Password?', 'Forgot Password?', 'Forgot Password', 't', 'w', '2021-02-19 16:51:19', '2021-05-25 06:25:11'),
(26, 'RESEND_ONE', 'Haven’t received activation email yet?', 'Haven’t received activation email yet?', 'Haven’t received activation email yet?', 't', 'w', '2021-02-19 16:52:24', '2021-05-25 06:25:11'),
(27, 'RESEND_TWO', 'to receive again.', 'to receive again.', 'to receive again.', 't', 'w', '2021-02-19 16:52:46', '2021-05-25 06:25:11'),
(28, 'SUBMIT', 'Submit', 'Submit', 'Submit', 't', 'w', '2021-02-19 16:53:11', '2021-05-25 06:25:11'),
(29, 'CLOSE', 'Close', 'Close', 'Close', 't', 'w', '2021-02-19 16:53:19', '2021-05-25 06:25:11'),
(30, 'EMAIL', 'Email ID', 'Email ID', 'Email ID', 't', 'w', '2021-02-19 16:53:37', '2021-05-25 06:25:11'),
(31, 'PASSWORD', 'Password', 'Password', 'Password', 't', 'w', '2021-02-19 16:53:46', '2021-05-25 06:25:11'),
(32, 'CLICK_HERE', 'Click Here', 'Click Here', 'Click Here', 't', 'w', '2021-02-19 16:55:40', '2021-05-25 06:25:11'),
(33, 'SIGNUP', 'Sign Up', 'Sign Up', 'Sign Up', 't', 'w', '2021-02-19 16:56:34', '2021-05-25 06:25:11'),
(34, 'LOGIN', 'Log In', 'Log In', 'Sign In', 't', 'w', '2021-02-19 16:56:42', '2021-05-25 06:25:11'),
(35, 'EMAIL_OR_CONTACT_NO', 'Email ID/Contact No.', 'Email ID/Contact No.', 'Email ID/Contact No.', 't', 'w', '2021-02-19 16:57:43', '2021-05-25 06:25:11'),
(36, 'MSG_EMAIL_OR_NO_REQ', 'Please enter email ID / Contact no.', 'Please enter email ID / Contact no.', 'Please enter email ID / Contact no.', 't', 'w', '2021-02-19 17:10:37', '2021-05-25 06:25:11'),
(37, 'MSG_INVALID_PASSWORD', 'Entered password is invalid.', 'Entered password is invalid.', 'Entered password is invalid.', 't', 'w', '2021-02-19 17:34:00', '2021-05-25 06:25:11'),
(38, 'MSG_INVALID_EMAIL_NO', 'Entered Email ID or Contact no. is invalid ', 'Entered Email ID or Contact no. is invalid ', 'Entered Email ID or Contact no. is invalid ', 't', 'w', '2021-02-19 17:35:14', '2021-05-25 06:25:11'),
(39, 'MSG_MIN_10_CHAR', 'Minimum 10 characters required.', 'Minimum 10 characters required.', 'Minimum 10 characters required.', 't', 'w', '2021-02-19 19:55:08', '2021-05-25 06:25:11'),
(40, 'MSG_MAX_15_CHAR', 'Maximum 15 characters allowed.', 'Maximum 15 characters allowed.', 'Maximum 15 characters allowed.', 't', 'w', '2021-02-19 19:55:25', '2021-05-25 06:25:11'),
(41, 'NO_DEVICE_ID_FOUND', 'Please provide device ID.', 'Please provide device ID.', 'Please provide device ID.', 't', 'w', '2021-02-20 13:55:11', '2021-05-25 06:25:11'),
(42, 'SUC_LOG_OUT', 'You have successfully logged out.', 'You have successfully logged out.', 'You have successfully logged out.', 't', 'w', '2021-02-20 13:58:38', '2021-05-25 06:25:11'),
(43, 'PLEASE_PROVIDE_VALID_DATA', 'Please provide all data.', 'Please provide all data.', 'Please provide all data.', 't', 'w', '2021-02-20 14:00:45', '2021-05-25 06:25:11'),
(44, 'FNAME', 'First Name', 'First Name', 'First Name', 't', 'w', '2021-02-22 14:48:59', '2021-05-25 06:25:11'),
(45, 'LNAME', 'Last Name', 'Last Name', 'Last Name', 't', 'w', '2021-02-22 14:49:13', '2021-05-25 06:25:11'),
(46, 'CONTACT_NO', 'Contact No.', 'Contact No.', 'Contact No.', 't', 'w', '2021-02-22 14:50:02', '2021-05-25 06:25:11'),
(47, 'CONFIRM_PASSWORD', 'Confirm Password', 'Confirm Password', 'Confirm Password', 't', 'w', '2021-02-22 14:53:54', '2021-05-25 06:25:11'),
(48, 'MSG_FNAME_REQ', 'Please enter first name.', 'Please enter first name.', 'Please enter first name.', 't', 'w', '2021-02-22 15:26:24', '2021-05-25 06:25:11'),
(49, 'MSG_LNAME_REQ', 'Please enter last name.', 'Please enter last name.', 'Please enter last name.', 't', 'w', '2021-02-22 15:26:43', '2021-05-25 06:25:11'),
(50, 'MSG_MIN_3_CHAR', 'Please enter minimum 3 characters.', 'Please enter minimum 3 characters.', 'Please enter minimum 3 characters.', 't', 'w', '2021-02-22 15:27:21', '2021-05-25 06:25:11'),
(51, 'MSG_EMAIL_EXISTS', 'This email address already exists.', 'This email address already exists.', 'This email address already exists.', 't', 'w', '2021-02-22 15:29:04', '2021-05-25 06:25:11'),
(52, 'MSG_CONTACT_REQ', 'Please enter contact no.', 'Please enter contact no.', 'Please enter contact no.', 't', 'w', '2021-02-22 15:29:24', '2021-05-25 06:25:11'),
(53, 'MSG_ONLY_DIGIT', 'Please enter only digits.', 'Please enter only digits.', 'Please enter only digits.', 't', 'w', '2021-02-22 15:29:58', '2021-05-25 06:25:11'),
(54, 'MSG_CONTACT_EXISTS', 'This contact no. already exists.', 'This contact no. already exists.', 'This contact no. already exists.', 't', 'w', '2021-02-22 15:30:21', '2021-05-25 06:25:11'),
(56, 'MSG_PASS_CONF_NOT_MATCH', 'Password and confirm password must match.', 'Password and confirm password must match.', 'Password and confirm password must match.', 't', 'w', '2021-02-22 15:32:57', '2021-05-25 06:25:11'),
(57, 'SELECT_USER_TYPE', 'Select User Type', 'Select User Type', 'Select User Type', 't', 'w', '2021-02-22 16:54:28', '2021-05-25 06:25:11'),
(58, 'SELECT_SERVICE_TYPE', 'Select Service Type', 'Select Service Type', 'Select Service Type', 't', 'w', '2021-02-22 16:54:44', '2021-05-25 06:25:11'),
(59, 'SELECT_VEHICLE_TYPE', 'Select Vehicle Type', 'Select Vehicle Type', 'Select Vehicle Type', 't', 'w', '2021-02-22 16:55:45', '2021-05-25 06:25:11'),
(60, 'CUSTOMER', 'Customer', 'Customer', 'Customer', 't', 'w', '2021-02-22 16:56:03', '2021-05-25 06:25:11'),
(61, 'SERVICE_PROVIDER', 'Service Provider', 'Service Provider', 'Service Provider', 't', 'w', '2021-02-22 16:56:27', '2021-05-25 06:25:11'),
(62, 'MECHANIC', 'Mechanic', 'Mechanic', 'Mechanic', 't', 'w', '2021-02-22 16:57:16', '2021-05-25 06:25:11'),
(63, 'TAXI', 'Taxi', 'Taxi', 'Taxi', 't', 'w', '2021-02-22 16:57:23', '2021-05-25 06:25:11'),
(64, 'CAR', 'Car', 'Car', 'Car', 't', 'w', '2021-02-22 16:59:55', '2021-05-25 06:25:11'),
(65, 'BIKE', 'Bike', 'Bike', 'Bike', 't', 'w', '2021-02-22 17:00:03', '2021-05-25 06:25:11'),
(66, 'BOTH', 'Both', 'Both', 'Both', 't', 'w', '2021-02-22 17:00:11', '2021-05-25 06:25:11'),
(67, 'MSG_USER_TYPE_REQ', 'Please select user type.', 'Please select user type.', 'Please select user type.', 't', 'w', '2021-02-22 17:05:33', '2021-05-25 06:25:11'),
(68, 'MSG_SERVICE_TYPE_REQ', 'Please select service type.', 'Please select service type.', 'Please select service type.', 't', 'w', '2021-02-22 17:05:50', '2021-05-25 06:25:11'),
(69, 'MSG_VEHI_TYPE_REQ', 'Please select vehicle type.', 'Please select vehicle type.', 'Please select vehicle type.', 't', 'w', '2021-02-22 17:06:07', '2021-05-25 06:25:11'),
(70, 'MSG_REGISTERED_SUC', 'You have successfully registered. Please check your mail for activating your account.', 'You have successfully registered. Please check your mail for activating your account.', 'You have successfully registered. Please check your mail for activating your account.', 't', 'w', '2021-02-22 17:23:52', '2021-05-25 06:25:11'),
(71, 'ACTIVATE_NOW', 'Activate Now', 'Activate Now', 'Activate Now', 't', 'w', '2021-02-22 17:27:19', '2021-05-25 06:25:11'),
(72, 'HOME', 'Home', 'Home', 'Home', 't', 'w', '2021-02-23 10:46:53', '2021-05-25 06:25:11'),
(73, 'AFTER_REGISTRATION', 'After Registration', 'After Registration', 'After Registration', 't', 'w', '2021-02-23 10:59:35', '2021-05-25 06:25:11'),
(74, 'BUSINESS_NAME', 'Business Name', 'Business Name', 'Business Name', 't', 'w', '2021-02-23 11:56:24', '2021-05-25 06:25:11'),
(75, 'MSG_BNAME_REQ', 'Please enter business name.', 'Please enter business name.', 'Please enter business name.', 't', 'w', '2021-02-23 11:58:34', '2021-05-25 06:25:11'),
(76, 'SAVE', 'Save', 'Save', 'Save', 't', 'w', '2021-02-23 11:59:31', '2021-05-25 06:25:11'),
(77, 'CANCEL', 'Cancel', 'Cancel', 'Cancel', 't', 'w', '2021-02-23 11:59:40', '2021-05-25 06:25:11'),
(78, 'MSG_DETAILS_SAVED_SUC', 'Details saved successfully.', 'Details saved successfully.', 'Details saved successfully.', 't', 'w', '2021-02-23 12:01:35', '2021-05-25 06:25:11'),
(79, 'MSG_PASS_CHANGE_SUC', 'Password changed successfully.', 'Password changed successfully.', 'Your password has been changed successfully.', 't', 'w', '2021-03-12 16:31:23', '2021-05-25 06:25:11'),
(80, 'MSG_NOTI_UPDATED_SUC', 'Notification has been updated successfully.', 'Notification has been updated successfully.', 'Notification has been updated successfully.', 't', 'w', '2021-03-12 16:32:23', '2021-05-25 06:25:11'),
(81, 'MSG_ACC_DELETED_SUC', 'Account has been deleted.', 'Account has been deleted.', 'Account has been deleted.', 't', 'w', '2021-03-12 16:32:53', '2021-05-25 06:25:11'),
(82, 'MSG_COMPLETE_RIDE_FIRST', 'Please complete service first.', 'Please complete service first.', 'Please complete service first.', 't', 'w', '2021-03-12 16:33:27', '2021-05-25 06:25:11'),
(83, 'MSG_NO_PAGE_FOUND', 'Page not found!', 'Page not found!', 'Page not found!', 't', 'w', '2021-03-12 16:34:47', '2021-05-25 06:25:11'),
(84, 'MSG_PAYPAL_EXIST', 'This PayPal email already exists.', 'This PayPal email already exists.', 'This PayPal email already exists.', 't', 'w', '2021-03-12 16:36:07', '2021-05-25 06:25:11'),
(85, 'MSG_PROFILE_UPDATE_SUC', 'Your profile has been updated successfully.', 'Your profile has been updated successfully.', 'Your profile has been updated successfully.', 't', 'w', '2021-03-12 16:36:31', '2021-05-25 06:25:11'),
(86, 'MSG_FILL_ALL_VALUE', 'Please fill all fields.', 'Please fill all fields.', 'Please fill all fields.', 't', 'w', '2021-03-12 16:36:53', '2021-05-25 06:25:11'),
(87, 'MSG_CONTACT_US_SUC', 'Contact us send successfully.', 'Contact us send successfully.', 'Contact us send successfully.', 't', 'w', '2021-03-12 16:38:16', '2021-05-25 06:25:11'),
(88, 'MSG_CURR_PASS_NOT_MATCH', 'Current password did not match.', 'Current password did not match.', 'Current password did not match.', 't', 'w', '2021-03-12 16:40:59', '2021-05-25 06:25:11'),
(89, 'MSG_PASS_EQUAL', 'New and confirm password not equal.', 'New and confirm password not equal.', 'New and confirm password not equal.', 't', 'w', '2021-03-12 16:41:45', '2021-05-25 06:25:11'),
(90, 'MSG_PASS_SAME', 'Old and new password are same.', 'Old and new password are same.', 'Old and new password are same.', 't', 'w', '2021-03-12 16:42:10', '2021-05-25 06:25:11'),
(91, 'LANGUAGE_CHANGED', 'Language has been changed.', 'Language has been changed.', 'Language has been changed.', 't', 'w', '2021-03-12 16:42:56', '2021-05-25 06:25:11'),
(92, 'DEVICE_REGI_SUC', 'Device registered successfully.', 'Device registered successfully.', 'Device registered successfully.', 't', 'w', '2021-03-12 16:44:06', '2021-05-25 06:25:11'),
(93, 'CONTACT_US', 'Contact Us', 'Contact Us', 'Contact Us', 't', 'w', '2021-03-19 12:16:21', '2021-05-25 06:25:11'),
(94, 'LOOKING_FOR_PROVIDER', 'Looking for provider?', 'Looking for provider?', 'Looking for provider?', 't', 'w', '2021-03-19 15:14:45', '2021-05-25 06:25:11'),
(95, 'ENTER_SEARCH_RADIUS', 'Enter Search Radius', 'Enter Search Radius', 'Enter Search Radius', 't', 'w', '2021-03-19 15:27:30', '2021-05-25 06:25:11'),
(96, 'SEARCH', 'Search', 'Search', 'Search', 't', 'w', '2021-03-19 15:33:16', '2021-05-25 06:25:11'),
(97, 'PLZ_ENTER_SEARCH_RADIUS', 'Please enter search radius.', 'Please enter search radius.', 'Please enter search radius.', 't', 'w', '2021-03-19 15:35:54', '2021-05-25 06:25:11'),
(98, 'MSG_ENTER_MIN_ONE', 'Please enter minimum 1.', 'Please enter minimum 1.', 'Please enter minimum 1.', 't', 'w', '2021-03-19 16:01:20', '2021-05-25 06:25:11'),
(99, 'CREATE_ACCOUNT', 'Create Account', 'Create Account', 'Create Account', 't', 'w', '2021-03-19 16:42:23', '2021-05-25 06:25:11'),
(100, 'ENTER', 'Enter', 'Enter', 'Enter', 't', 'w', '2021-03-19 17:08:58', '2021-05-25 06:25:11'),
(101, 'ALREADY_HAVE_ACCOUNT', 'Already have an Account?', 'Already have an Account?', 'Already have an Account?', 't', 'w', '2021-03-19 17:15:09', '2021-05-25 06:25:11'),
(102, 'PROFILE', 'Profile', 'Profile', 'Profile', 't', 'w', '2021-03-19 18:01:43', '2021-05-25 06:25:11'),
(103, 'SIGN_OUT', 'Logout', 'Logout', 'Logout', 't', 'w', '2021-03-19 18:01:54', '2021-05-25 06:25:11'),
(104, 'INBOX', 'Inbox', 'Inbox', 'Inbox', 't', 'w', '2021-03-19 18:04:38', '2021-05-25 06:25:11'),
(105, 'MY_WALLET', 'My Wallet', 'My Wallet', 'My Wallet', 't', 'w', '2021-03-19 18:05:20', '2021-05-25 06:25:11'),
(106, 'ACCOUNT_SETTINGS', 'Account Settings', 'Account Settings', 'Account Settings', 't', 'w', '2021-03-19 18:06:00', '2021-05-25 06:25:11'),
(107, 'UPLOAD_IMAGE', 'Upload Image', 'Upload Image', 'Upload Image', 't', 'w', '2021-03-20 12:05:25', '2021-05-25 06:25:11'),
(108, 'CROP', 'Crop', 'Crop', 'Crop', 't', 'w', '2021-03-20 12:29:44', '2021-05-25 06:25:11'),
(109, 'ENTER_NEW_PASSWORD', 'Enter New Password', 'Enter New Password', 'Enter New Password', 't', 'w', '2021-03-20 17:39:16', '2021-05-25 06:25:11'),
(110, 'REENTER_NEW_PASSWORD', 'Re-enter Password', 'Re-enter Password', 'Re-enter Password', 't', 'w', '2021-03-20 17:39:45', '2021-05-25 06:25:11'),
(111, 'NO_NEARBY_PROVIDER_FOUND', 'No nearby provider found.', 'No nearby provider found.', 'No nearby provider found.', 't', 'w', '2021-03-22 11:14:48', '2021-05-25 06:25:11'),
(112, 'NEARBY_PROVIDERS', 'Nearby Providers', 'Nearby Providers', 'Nearby Providers', 't', 'w', '2021-03-22 12:23:25', '2021-05-25 06:25:11'),
(113, 'ARE_YOU_PROVIDER', 'Are you a provider?', 'Are you a provider?', 'Are you a provider?', 't', 'w', '2021-03-22 12:51:00', '2021-05-25 06:25:11'),
(114, 'SIGN_UP_NOW', 'Sign Up Now', 'Sign Up Now', 'Sign Up Now', 't', 'w', '2021-03-22 12:52:06', '2021-05-25 06:25:11'),
(115, 'WIN_SEARCH', 'Search Providers', 'Search Providers', 'Search Providers', 't', 'w', '2021-03-22 13:59:04', '2021-05-25 06:25:11'),
(116, 'RADIUS', 'Radius', 'Radius', 'Radius', 't', 'w', '2021-03-22 16:59:05', '2021-05-25 06:25:11'),
(117, 'SEARCH_RESULT', 'Search Result', 'Search Result', 'Search Result', 't', 'w', '2021-03-23 15:47:06', '2021-05-25 06:25:11'),
(118, 'CURRENT_PASSWORD', 'Enter current password', 'Enter current password', 'Enter current password', 't', 'w', '2021-03-24 11:58:46', '2021-05-25 06:25:11'),
(119, 'WIN_ACCOUNT_SETTING', 'Account settings', 'Account settings', 'Account settings', 't', 'w', '2021-03-24 12:08:16', '2021-05-25 06:25:11'),
(120, 'LBL_UPDATE', 'Update', 'Update', 'Update', 't', 'w', '2021-03-24 12:16:07', '2021-05-25 06:25:11'),
(121, 'EDIT_PROFILE', 'Edit Profile', 'Edit Profile', 'Edit Profile', 't', 'w', '2021-03-24 15:03:01', '2021-05-25 06:25:11'),
(122, 'MSG_NEW_EMAIL_REQ', 'Please enter new email address.', 'Please enter new email address.', 'Please enter new email address.', 't', 'w', '2021-03-24 15:05:57', '2021-05-25 06:25:11'),
(123, 'PROFILE_PIC_UPDATED', 'Profile picture updated successfully.', 'Profile picture updated successfully.', 'Profile picture updated successfully.', 't', 'w', '2021-03-24 15:07:17', '2021-05-25 06:25:11'),
(124, 'MSG_ENT_PAY_GATE_ID', 'Please enter payment gateway ID', 'Please enter payment gateway ID', 'Please enter payment gateway ID', 't', 'w', '2021-03-24 15:09:55', '2021-05-25 06:25:11'),
(125, 'LOCATION', 'Location', 'Location', 'Location', 't', 'w', '2021-03-24 15:53:11', '2021-05-25 06:25:11'),
(126, 'WHEN_SER_REQ_REC', 'When the Service Request is received', 'When the Service Request is received', 'When the Service Request is received', 't', 'w', '2021-03-25 11:51:40', '2021-05-25 06:25:11'),
(127, 'WHEN_SER_COM', 'When the service is completed', 'When the service is completed', 'When the service is completed', 't', 'w', '2021-03-25 11:51:58', '2021-05-25 06:25:11'),
(128, 'WHEN_SER_CAN_BY_PRO', 'When the service is cancelled by Customer/Service Provider', 'When the service is cancelled by Customer/Service Provider', 'When the service is cancelled by Customer/Service Provider', 't', 'w', '2021-03-25 11:52:26', '2021-05-25 06:25:11'),
(129, 'WHEN_SER_ASSIGN_CUS', 'When the Service Provider assigned to the Customer', 'When the Service Provider assigned to the Customer', 'When the Service Provider assigned to the Customer', 't', 'w', '2021-03-25 11:52:59', '2021-05-25 06:25:11'),
(130, 'PAY_GATE_ID_UPDATED', 'Payment gateway id has been updated.', 'Payment gateway id has been updated.', 'Payment gateway id has been updated.', 't', 'w', '2021-03-25 11:54:08', '2021-05-25 06:25:11'),
(131, 'PLE_CHECK_MAIL_CHANGE_MAIL', 'Please check your mail for change email address.', 'Please check your mail for change email address.', 'Please check your mail for change email address.', 't', 'w', '2021-03-25 11:54:37', '2021-05-25 06:25:11'),
(132, 'NO_ANY_SER_ADDED', 'No any services added.', 'No any services added.', 'No any services added.', 't', 'w', '2021-03-25 13:57:34', '2021-05-25 06:25:11'),
(133, 'NEW_SER_ADDED_SUC', 'New service has been added successfully.', 'New service has been added successfully.', 'New service has been added successfully.', 't', 'w', '2021-03-25 13:58:03', '2021-05-25 06:25:11'),
(134, 'SUBJECT', 'Subject', 'Subject', 'Subject', 't', 'w', '2021-03-25 15:48:35', '2021-05-25 06:25:11'),
(135, 'MESSAGE', 'Message', 'Message', 'Message', 't', 'w', '2021-03-25 15:49:07', '2021-05-25 06:25:11'),
(136, 'MSG_SUBJECT_REQ', 'Please enter subject.', 'Please enter subject.', 'Please enter subject.', 't', 'w', '2021-03-25 16:01:35', '2021-05-25 06:25:11'),
(137, 'MSG_REQ', 'Please enter message.', 'Please enter message.', 'Please enter message.', 't', 'w', '2021-03-25 16:02:16', '2021-05-25 06:25:11'),
(138, 'SER_NAME_AL_EXIST', 'Service name already exists.', 'Service name already exists.', 'Service name already exists.', 't', 'w', '2021-03-25 16:39:23', '2021-05-25 06:25:11'),
(139, 'MY_PRO_SERS', 'My Provided Services', 'My Provided Services', 'My Provided Services', 't', 'w', '2021-03-25 16:56:41', '2021-05-25 06:25:11'),
(140, 'ADD_NEW_SER', 'Add new service', 'Add new service', 'Add new service', 't', 'w', '2021-03-25 16:59:26', '2021-05-25 06:25:11'),
(141, 'CHANGE_EMAIL_ADD', 'Change Email Address', 'Change Email Address', 'Change Email Address', 't', 'w', '2021-03-25 17:00:57', '2021-05-25 06:25:11'),
(142, 'MSG_LOCATION_REQUIRED', 'Please select location.', 'Please select location.', 'Please select location.', 't', 'w', '2021-03-25 17:01:21', '2021-05-25 06:25:11'),
(143, 'PAY_GATE_ID', 'Payment gateway ID', 'Payment gateway ID', 'Payment gateway ID', 't', 'w', '2021-03-25 17:01:31', '2021-05-25 06:25:11'),
(144, 'CHANGE_PASS', 'Change password', 'Change password', 'Change password', 't', 'w', '2021-03-25 17:02:20', '2021-05-25 06:25:11'),
(145, 'ENT_PAY_GATE_ID', 'Enter payment gateway ID', 'Enter payment gateway ID', 'Enter payment gateway ID', 't', 'w', '2021-03-25 17:02:51', '2021-05-25 06:25:11'),
(146, 'NOTI_PREFE', 'Notification preferences', 'Notification preferences', 'Notification preferences', 't', 'w', '2021-03-25 17:03:10', '2021-05-25 06:25:11'),
(147, 'ENTER_NEW_EMAIL_ID', 'Enter new email address', 'Enter new email address', 'Enter new email address', 't', 'w', '2021-03-25 17:03:34', '2021-05-25 06:25:11'),
(148, 'SERVICE_BOOK_DETAIL', 'Service Book Detail', 'Service Book Detail', 'Service Book Detail', 't', 'w', '2021-03-30 15:33:06', '2021-05-25 06:25:11'),
(149, 'PLZ_ENTER_VIN_NUMBER', 'Please enter VIN number.', 'Please enter VIN number.', 'Please enter VIN number.', 't', 'w', '2021-03-30 16:19:35', '2021-05-25 06:25:11'),
(150, 'ENTER_VIN', 'Enter VIN', 'Enter VIN', 'Enter VIN', 't', 'w', '2021-03-30 16:20:43', '2021-05-25 06:25:11'),
(151, 'NO_DETAILS_FOUND', 'No details found.', 'No details found.', 'No details found.', 't', 'w', '2021-03-30 16:28:27', '2021-05-25 06:25:11'),
(152, 'VEHICLE_DETAILS', 'Vehicle Details', 'Vehicle Details', 'Vehicle Details', 't', 'w', '2021-03-31 11:27:16', '2021-05-25 06:25:11'),
(153, 'ADD_SERVICE_RECORD', 'Add Service Record', 'Add Service Record', 'Add Service Record', 't', 'w', '2021-03-31 11:28:45', '2021-05-25 06:25:11'),
(154, 'VEHICLE_MAKE', 'Vehicle Make', 'Vehicle Make', 'Vehicle Make', 't', 'w', '2021-03-31 11:43:59', '2021-05-25 06:25:11'),
(155, 'VEHICLE_MODEL', 'Vehicle Model', 'Vehicle Model', 'Vehicle Model', 't', 'w', '2021-03-31 11:45:42', '2021-05-25 06:25:11'),
(156, 'VEHICLE_YEAR', 'Vehicle Year', 'Vehicle Year', 'Vehicle Year', 't', 'w', '2021-03-31 12:01:07', '2021-05-25 06:25:11'),
(157, 'VEHICLE_ENGINE', 'Vehicle Engine', 'Vehicle Engine', 'Vehicle Engine', 't', 'w', '2021-03-31 12:03:11', '2021-05-25 06:25:11'),
(158, 'ENGINE_POWER', 'Engine Power', 'Engine Power', 'Engine Power', 't', 'w', '2021-03-31 12:06:01', '2021-05-25 06:25:11'),
(159, 'SERVICE_DETAILS', 'Service Details', 'Service Details', 'Service Details', 't', 'w', '2021-03-31 12:07:02', '2021-05-25 06:25:11'),
(160, 'NO_ANY_REC_REVIEWS', 'No any received reviews.', 'No any received reviews.', 'No any received reviews.', 't', 'w', '2021-03-31 15:12:14', '2021-05-25 06:25:11'),
(161, 'MY_REC_REVIEWS', 'My Received Reviews', 'My Received Reviews', 'My Received Reviews', 't', 'w', '2021-03-31 15:54:21', '2021-05-25 06:25:11'),
(162, 'LBL_REPLY', 'Reply', 'Reply', 'Reply', 't', 'w', '2021-03-31 15:55:34', '2021-05-25 06:25:11'),
(163, 'POST_REPLY', 'Post reply', 'Post reply', 'Post reply', 't', 'w', '2021-03-31 15:55:50', '2021-05-25 06:25:11'),
(164, 'ADD_REPLY_REVIEW', 'Add a reply to this review...', 'Add a reply to this review...', 'Add a reply to this review...', 't', 'w', '2021-03-31 15:56:15', '2021-05-25 06:25:11'),
(165, 'SERVICE_ID', 'Services ID', 'Services ID', 'Service ID', 't', 'w', '2021-03-31 15:56:39', '2021-05-25 06:25:11'),
(166, 'REVIEW_RPLY_ADDED', 'Review reply has been added successfully.', 'Review reply has been added successfully.', 'Review reply has been added successfully.', 't', 'w', '2021-03-31 15:57:16', '2021-05-25 06:25:11'),
(167, 'SELECT_SERVICE_DATE', 'Select Service Date', 'Select Service Date', 'Select service date', 't', 'w', '2021-03-31 16:13:20', '2021-05-25 06:25:11'),
(168, 'DESCRIPTION', 'Description', 'Description', 'Description', 't', 'w', '2021-03-31 16:15:35', '2021-05-25 06:25:11'),
(169, 'AMOUNT', 'Amount', 'Amount', 'Amount', 't', 'w', '2021-03-31 16:29:03', '2021-05-25 06:25:11'),
(170, 'MSG_DESCRIPTION_REQ', 'Please enter description.', 'Please enter description.', 'Please enter description.', 't', 'w', '2021-03-31 16:53:44', '2021-05-25 06:25:11'),
(171, 'PLZ_SELECT_SERVICE_DATE', 'Please select service date.', 'Please select service date.', 'Please select service date.', 't', 'w', '2021-03-31 17:02:29', '2021-05-25 06:25:11'),
(172, 'PLZ_ENTER_AMOUNT', 'Please enter amount.', 'Please enter amount.', 'Please enter amount.', 't', 'w', '2021-03-31 17:12:31', '2021-05-25 06:25:11'),
(173, 'PLZ_ENTER_VALID_NUMBER', 'Please enter valid number.', 'Please enter valid number.', 'Please enter valid number.', 't', 'w', '2021-03-31 17:13:39', '2021-05-25 06:25:11'),
(174, 'SER_REC_ADDED_SUC', 'Service record added successfully.', 'Service record added successfully.', 'Service record added successfully.', 't', 'w', '2021-03-31 18:36:23', '2021-05-25 06:25:11'),
(175, 'PROVIDER_DETAILS', 'Provider Details', 'Provider Details', 'Provider Details', 't', 'w', '2021-04-01 14:23:13', '2021-05-25 06:25:11'),
(176, 'DATE', 'Date', 'Date', 'Date', 't', 'w', '2021-04-01 14:24:53', '2021-05-25 06:25:11'),
(177, 'MY_PROFILE', ' My Profile ', ' My Profile ', ' My Profile ', 't', 'w', '2021-04-01 18:56:00', '2021-05-25 06:25:11'),
(178, 'LBL_AVAILABILITY', 'Availability', 'Availability', 'Availability', 't', 'w', '2021-04-01 18:57:03', '2021-05-25 06:25:11'),
(179, 'OPEN', 'Open', 'Open', 'Open', 't', 'w', '2021-04-01 18:57:19', '2021-05-25 06:25:11'),
(180, 'ADD_STATUS', 'Add status', 'Add status', 'Add status', 't', 'w', '2021-04-01 18:57:40', '2021-05-25 06:25:11'),
(181, 'EDIT', 'Edit', 'Edit', 'Edit', 't', 'w', '2021-04-01 18:57:52', '2021-05-25 06:25:11'),
(182, 'AVAILABILITY_SLOTS', 'Availability Slots', 'Availability Slots', 'Availability Slots', 't', 'w', '2021-04-01 18:58:26', '2021-05-25 06:25:11'),
(183, 'PLZ_SELECT_SERVICE_TIME', 'Please select service time slot.', 'Please select service time slot.', 'Please select service time slot.', 't', 'w', '2021-04-02 17:51:02', '2021-05-25 06:25:11'),
(184, 'SELECT_SERVICE_TIME', 'Select service time slot.', 'Select service time slot.', 'Select service time slot', 't', 'w', '2021-04-02 17:52:00', '2021-05-25 06:25:11'),
(185, 'PROV_NOT_AVAILABLE', 'Provider is not available for selected date and time slot.', 'Provider is not available for selected date and time slot.', 'Provider is not available for selected date and time slot.', 't', 'w', '2021-04-02 17:54:12', '2021-05-25 06:25:11'),
(186, 'PAST_TIME_NOT_ALLOWED', 'Past time not allowed.', 'Past time not allowed.', 'Past time not allowed.', 't', 'w', '2021-04-03 10:54:19', '2021-05-25 06:25:11'),
(187, 'MSG_SERVICE_REQ_ADDED', 'New service request added successfully.', 'New service request added successfully.', 'New service request added successfully.', 't', 'w', '2021-04-03 11:01:47', '2021-05-25 06:25:11'),
(188, 'BOOKED_SERVICE_DETAIL', 'Booked Service Detail', 'Booked Service Detail', 'Booked Service Detail', 't', 'w', '2021-04-03 14:19:57', '2021-05-25 06:25:11'),
(189, 'CUSTOMER_DETAILS', 'Customer Details', 'Customer Details', 'Customer Details', 't', 'w', '2021-04-03 15:42:51', '2021-05-25 06:25:11'),
(190, 'AVAILABILITY_UPDATED_SUCCESSFULLY', 'Your availability has been updated successfully.', 'Your availability has been updated successfully.', 'Your availability has been updated successfully.', 't', 'w', '2021-04-05 10:32:06', '2021-05-25 06:25:11'),
(191, 'MECHANIC_SERVICE', 'Mechanic Service', 'Mechanic Service', 'Auto Service', 't', 'w', '2021-04-05 10:32:33', '2021-05-25 06:25:11'),
(192, 'TAXI_SERVICE', 'Taxi Service', 'Taxi Service', 'Taxi Service', 't', 'w', '2021-04-05 10:32:56', '2021-05-25 06:25:11'),
(193, 'SELECT_TIME_SLOT', 'Select time slot', 'Select time slot', 'Select time slot', 't', 'w', '2021-04-05 10:35:05', '2021-05-25 06:25:11'),
(194, 'START_DATE', 'Start date', 'Start date', 'Start date', 't', 'w', '2021-04-05 10:35:20', '2021-05-25 06:25:11'),
(195, 'END_DATE', 'End date', 'End date', 'End date', 't', 'w', '2021-04-05 10:35:37', '2021-05-25 06:25:11'),
(196, 'SELECT_AVAILABILITY', 'Select Availability', 'Select Availability', 'Select Availability', 't', 'w', '2021-04-05 10:38:32', '2021-05-25 06:25:11'),
(197, 'LBL_YES', 'Yes', 'Yes', 'Yes', 't', 'w', '2021-04-05 10:38:46', '2021-05-25 06:25:11'),
(198, 'LBL_NO', 'No', 'No', 'No', 't', 'w', '2021-04-05 10:39:10', '2021-05-25 06:25:11'),
(199, 'INVALID_IMG_FILE', 'Invalid Image File', 'Invalid Image File', 'Invalid Image File', 't', 'w', '2021-04-05 10:41:46', '2021-05-25 06:25:11'),
(200, 'UPCOMING', 'Upcoming', 'Upcoming', 'Upcoming', 't', 'w', '2021-04-05 13:11:05', '2021-05-25 06:25:11'),
(201, 'COMPLETED', 'Completed', 'Completed', 'Completed', 't', 'w', '2021-04-05 13:33:53', '2021-05-25 06:25:11'),
(202, 'ONGOING', 'Ongoing', 'Ongoing', 'Ongoing', 't', 'w', '2021-04-05 13:34:23', '2021-05-25 06:25:11'),
(203, 'TEL', 'Tel', 'Tel', 'Tel', 't', 'w', '2021-04-05 13:37:02', '2021-05-25 06:25:11'),
(204, 'SERVICE_TYPE', 'Service Type', 'Service Type', 'Service Type', 't', 'w', '2021-04-05 13:38:28', '2021-05-25 06:25:11'),
(205, 'BOOKING_DATE', 'Booking Date', 'Booking Date', 'Booking Date', 't', 'w', '2021-04-05 13:39:12', '2021-05-25 06:25:11'),
(206, 'SERVICE_DATE', 'Service Date', 'Service Date', 'Service Date', 't', 'w', '2021-04-05 13:39:54', '2021-05-25 06:25:11'),
(207, 'SERVICE_SLOT', 'Service Slot', 'Service Slot', 'Service Slot', 't', 'w', '2021-04-05 13:40:48', '2021-05-25 06:25:11'),
(208, 'START_SERVICE', 'Start Service', 'Start Service', 'Start Service', 't', 'w', '2021-04-05 13:41:23', '2021-05-25 06:25:11'),
(209, 'CANCEL_SERVICE', 'Cancel Service', 'Cancel Service', 'Cancel Service', 't', 'w', '2021-04-05 13:43:45', '2021-05-25 06:25:11'),
(210, 'ACCEPT', 'Accept', 'Accept', 'Accept', 't', 'w', '2021-04-05 15:27:16', '2021-05-25 06:25:11'),
(211, 'REJECT', 'Reject', 'Reject', 'Reject', 't', 'w', '2021-04-05 15:27:51', '2021-05-25 06:25:11'),
(212, 'ACCEPTED', 'Accepted', 'Accepted', 'Accepted', 't', 'w', '2021-04-05 15:28:13', '2021-05-25 06:25:11'),
(213, 'REJECTED', 'Rejected', 'Rejected', 'Rejected', 't', 'w', '2021-04-05 15:28:29', '2021-05-25 06:25:11'),
(214, 'SER_REQ_ACCEPTED', 'Service request has been accepted.', 'Service request has been accepted.', 'Service request has been accepted.', 't', 'w', '2021-04-05 15:46:40', '2021-05-25 06:25:11'),
(215, 'SER_REQ_REJECTED', 'Service request has been rejected.', 'Service request has been rejected.', 'Service request has been rejected.', 't', 'w', '2021-04-05 15:47:03', '2021-05-25 06:25:11'),
(216, 'NEW_SERVICE_REQUEST', ' New Service Request ', ' New Service Request ', ' Received Service Request ', 't', 'w', '2021-04-05 16:31:01', '2021-05-25 06:25:11'),
(217, 'NO_ANY_SER_REQ_REC', 'No any service request received.', 'No any service request received.', 'No any service request received.', 't', 'w', '2021-04-05 17:32:01', '2021-05-25 06:25:11'),
(218, 'CANCELLED', 'Cancelled', 'Cancelled', 'Cancelled', 't', 'w', '2021-04-05 19:03:26', '2021-05-25 06:25:11'),
(219, 'AUTO_SERVICES', 'Auto Services', 'Auto Services', 'Auto Services', 't', 'w', '2021-04-05 19:04:48', '2021-05-25 06:25:11'),
(220, 'MSG_SURE_CANCEL_SERVICE', 'Are you sure you want to cancel this service?', 'Are you sure you want to cancel this service?', 'Are you sure you want to cancel this service?', 't', 'w', '2021-04-06 16:47:26', '2021-05-25 06:25:11'),
(221, 'MSG_SERVICE_CANCELLED_SUC', 'Service request cancelled successfully.', 'Service request cancelled successfully.', 'Service request cancelled successfully.', 't', 'w', '2021-04-06 18:25:33', '2021-05-25 06:25:11'),
(222, 'CANCEL_BY_PROVIDER', 'Service request cancelled by provider.', 'Service request cancelled by provider.', 'Service request cancelled by provider.', 't', 'w', '2021-04-06 18:26:18', '2021-05-25 06:25:11'),
(223, 'CANCEL_BY_CUSTOMER', 'Service request cancelled by customer.', 'Service request cancelled by customer.', 'Service request cancelled by customer.', 't', 'w', '2021-04-06 18:26:52', '2021-05-25 06:25:11'),
(224, 'BOOK_NOW', 'Book Now', 'Book Now', 'Book Now', 't', 'w', '2021-04-06 19:31:13', '2021-05-25 06:25:11'),
(225, 'CANT_REQUEST_OWN', 'You can not send service request to yourself.', 'You can not send service request to yourself.', 'You can not send service request to yourself.', 't', 'w', '2021-04-06 19:36:00', '2021-05-25 06:25:11'),
(226, 'MSG_SERVICE_STARTED_SUC', 'Service started successfully.', 'Service started successfully.', 'Service started successfully.', 't', 'w', '2021-04-07 12:17:39', '2021-05-25 06:25:11'),
(227, 'COMPLETE_SERVICE', 'Complete Service', 'Complete Service', 'Complete Service', 't', 'w', '2021-04-07 12:19:05', '2021-05-25 06:25:11'),
(228, 'MSG_SURE_COMPLETE_SERVICE', 'Are you sure you want to complete this service?', 'Are you sure you want to complete this service?', 'Are you sure you want to complete this service?', 't', 'w', '2021-04-07 12:21:26', '2021-05-25 06:25:11'),
(229, 'MSG_SURE_START_SERVICE', 'Are you sure you want to start this service?', 'Are you sure you want to start this service?', 'Are you sure you want to start this service?', 't', 'w', '2021-04-07 12:22:35', '2021-05-25 06:25:11'),
(230, 'MSG_SERVICE_COMPLETED_SUC', 'Service marked as complete successfully.', 'Service marked as complete successfully.', 'Service marked as complete successfully.', 't', 'w', '2021-04-07 12:36:29', '2021-05-25 06:25:11'),
(231, 'COMPLETE_BY_PROVIDER', 'Service is marked as complete by provider.', 'Service is marked as complete by provider.', 'Service is marked as complete by provider.', 't', 'w', '2021-04-07 12:37:52', '2021-05-25 06:25:11'),
(232, 'COMPLETE_BY_CUSTOMER', 'Service is marked as complete by customer.', 'Service is marked as complete by customer.', 'Service is marked as complete by customer.', 't', 'w', '2021-04-07 12:38:31', '2021-05-25 06:25:11'),
(233, 'ENTER_REVIEW_DESC', 'Enter review description', 'Enter review description', 'Enter review description', 't', 'w', '2021-04-07 15:22:43', '2021-05-25 06:25:11'),
(234, 'MSG_ENTER_REVIEW', 'Please enter review.', 'Please enter review.', 'Please enter review.', 't', 'w', '2021-04-07 15:41:22', '2021-05-25 06:25:11'),
(235, 'MSG_REVIEW_POSTED_SUC', 'Review posted successfully.', 'Review posted successfully.', 'Review posted successfully.', 't', 'w', '2021-04-07 15:44:46', '2021-05-25 06:25:11'),
(236, 'MY_GIVEN_REVIEWS', 'My Given Reviews', 'My Given Reviews', 'My Given Reviews', 't', 'w', '2021-04-08 11:00:53', '2021-05-25 06:25:11'),
(237, 'REPLY_THIS_REVIEW', 'Please enter reply to this review.', 'Please enter reply to this review.', 'Please enter reply to this review.', 't', 'w', '2021-04-08 11:45:54', '2021-05-25 06:25:11'),
(238, 'CUR_BAL', 'Current Balance', 'Current Balance', 'Current Balance', 't', 'w', '2021-04-08 11:58:09', '2021-05-25 06:25:11'),
(239, 'AMT_RECEIVABLE', 'Amount Receivable', 'Amount Receivable', 'Amount Receivable', 't', 'w', '2021-04-08 11:58:32', '2021-05-25 06:25:11'),
(240, 'RED_REQ', 'Redemption Request', 'Redemption Request', 'Redemption Request', 't', 'w', '2021-04-08 11:58:52', '2021-05-25 06:25:11'),
(241, 'ENTER_RED_AMOUNT', 'Enter redemption amount', 'Enter redemption amount', 'Enter redemption amount', 't', 'w', '2021-04-08 11:59:32', '2021-05-25 06:25:11'),
(242, 'WALLET_TRA_HIS', 'Wallet Transaction History', 'Wallet Transaction History', 'Wallet Transaction History', 't', 'w', '2021-04-08 11:59:59', '2021-05-25 06:25:11'),
(243, 'DEPOSIT_MONEY', 'Deposit Money', 'Deposit Money', 'Deposit Money', 't', 'w', '2021-04-08 12:43:06', '2021-05-25 06:25:11'),
(244, 'ENTER_AMT_DEPOSIT', 'Enter Amount to be deposited', 'Enter Amount to be deposited', 'Enter Amount to be deposited', 't', 'w', '2021-04-08 12:43:32', '2021-05-25 06:25:11'),
(245, 'VAL_GRE_THAN_ZERO', ' Please enter a value greater than or equal to 1. ', ' Please enter a value greater than or equal to 1. ', ' Please enter a value greater than or equal to 1. ', 't', 'w', '2021-04-08 12:45:40', '2021-05-25 06:25:11'),
(246, 'VAL_LESS_THAN_NO_MORE', ' Please enter a value less than or equal to 50000. ', ' Please enter a value less than or equal to 50000. ', ' Please enter a value less than or equal to 50000. ', 't', 'w', '2021-04-08 12:46:18', '2021-05-25 06:25:11'),
(247, 'DOWNLOAD_FILE', 'Download File', 'Download File', 'Download File', 't', 'w', '2021-04-13 13:21:06', '2021-05-25 06:25:11'),
(248, 'MSG_NO_MSG_FOUND', 'No message found.', 'No message found.', 'No message found.', 't', 'w', '2021-04-13 14:34:12', '2021-05-25 06:25:11'),
(249, 'MSG_MSG_MOVED_TO_TRASH', 'Messages moved to trash successfully.', 'Messages moved to trash successfully.', 'Messages moved to trash successfully.', 't', 'w', '2021-04-13 14:34:50', '2021-05-25 06:25:11'),
(250, 'MSG_MSG_SENT_SUC', 'Message sent successfully.', 'Message sent successfully.', 'Message sent successfully.', 't', 'w', '2021-04-13 14:43:06', '2021-05-25 06:25:11'),
(251, 'KM', 'Km', 'Km', 'Km', 't', 'w', '2021-04-15 13:36:28', '2021-05-25 06:25:11'),
(252, 'PLZ_ENTER_MIZUTECH_DETAILS', 'Please enter your mizutech credentials from account settings.', 'Please enter your mizutech credentials from account settings.', 'Please enter your mizutech credentials from account settings.', 't', 'w', '2021-04-15 13:51:19', '2021-05-25 06:25:11'),
(253, 'CALL', 'Call', 'Call', 'Call', 't', 'w', '2021-04-15 17:28:42', '2021-05-25 06:25:11'),
(254, 'HANG_UP', 'Hang Up', 'Hang Up', 'Hang Up', 't', 'w', '2021-04-15 17:29:47', '2021-05-25 06:25:11'),
(255, 'PROV_NOT_HAVE_MIZUTECH_DETAILS', 'Selected provider has not added mizutech account details yet.', 'Selected provider has not added mizutech account details yet.', 'Selected provider has not added mizutech credentials yet.', 't', 'w', '2021-04-16 10:44:49', '2021-05-25 06:25:11'),
(256, 'PLZ_LOGIN_TO_CONTINUE', 'Please first login to continue.', 'Please first login to continue.', 'Please first login to continue.', 't', 'w', '2021-04-16 12:20:43', '2021-05-25 06:25:11'),
(257, 'CALL_SETUP', 'Call setup', 'Call setup', 'Call setup', 't', 'w', '2021-04-19 11:06:05', '2021-05-25 06:25:11'),
(258, 'CALL_DISCONNECTED', 'Call disconnected', 'Call disconnected', 'Call disconnected', 't', 'w', '2021-04-19 11:07:13', '2021-05-25 06:25:11'),
(259, 'CALL_TO_PROVIDER', 'Call to Provider', 'Call to Provider', 'Call to User', 't', 'w', '2021-04-19 11:08:10', '2021-05-25 06:25:11'),
(260, 'INCOMING_CALL_FROM', 'Incoming Call From', 'Incoming Call From', 'Incoming Call From', 't', 'w', '2021-04-19 11:35:21', '2021-05-25 06:25:11'),
(261, 'CONVERSTION_WITH', 'Conversation With', 'Conversation With', 'Conversation With', 't', 'w', '2021-04-19 13:11:41', '2021-05-25 06:25:11'),
(262, 'ENTER_MSG', 'Enter Message', 'Enter Message', 'Enter Message', 't', 'w', '2021-04-19 13:12:17', '2021-05-25 06:25:11'),
(263, 'TRASH', 'Trash', 'Trash', 'Trash', 't', 'w', '2021-04-19 15:45:03', '2021-05-25 06:25:11'),
(264, 'NO_CHAT_FOUND', 'Your inbox is empty.', 'Your inbox is empty.', 'Your inbox is empty.', 't', 'w', '2021-04-19 15:56:23', '2021-05-25 06:25:11'),
(265, 'SEND', 'Send', 'Send', 'Send', 't', 'w', '2021-04-19 16:37:51', '2021-05-25 06:25:11'),
(266, 'SEND_MSG', 'Send Message', 'Send Message', 'Send Message', 't', 'w', '2021-04-19 16:38:34', '2021-05-25 06:25:11'),
(267, 'JUST_NOW', 'Just Now', 'Just Now', 'Just Now', 't', 'w', '2021-04-19 17:14:07', '2021-05-25 06:25:11'),
(268, 'AGO', 'Ago', 'Ago', 'Ago', 't', 'w', '2021-04-19 17:14:49', '2021-05-25 06:25:11'),
(269, 'YEAR', 'Year', 'Year', 'Year', 't', 'w', '2021-04-19 17:20:17', '2021-05-25 06:25:11'),
(270, 'MONTH', 'Month', 'Month', 'Month', 't', 'w', '2021-04-19 17:20:38', '2021-05-25 06:25:11'),
(271, 'WEEK', 'Week', 'Week', 'Week', 't', 'w', '2021-04-19 17:21:06', '2021-05-25 06:25:11'),
(272, 'DAY', 'Day', 'Day', 'Day', 't', 'w', '2021-04-19 17:21:25', '2021-05-25 06:25:11'),
(273, 'HOUR', 'Hour', 'Hour', 'Hour', 't', 'w', '2021-04-19 17:21:44', '2021-05-25 06:25:11'),
(274, 'MINUTE', 'Minute', 'Minute', 'Minute', 't', 'w', '2021-04-19 17:22:04', '2021-05-25 06:25:11'),
(275, 'SECOND', 'Second', 'Second', 'Second', 't', 'w', '2021-04-19 17:22:20', '2021-05-25 06:25:11'),
(276, 'TODAY', 'Today', 'Today', 'Today', 't', 'w', '2021-04-19 17:23:13', '2021-05-25 06:25:11'),
(277, 'YESTERDAY', 'Yesterday', 'Yesterday', 'Yesterday', 't', 'w', '2021-04-19 17:23:57', '2021-05-25 06:25:11'),
(278, 'RCVD_MSG_FROM', 'You have received one new message from ', 'You have received one new message from ', 'You have received one new message from ', 't', 'w', '2021-04-20 11:06:55', '2021-05-25 06:25:11'),
(279, 'TO_CHAT_WITH', 'to chat with', 'to chat with', 'to chat with', 't', 'w', '2021-04-20 11:07:49', '2021-05-25 06:25:11'),
(280, 'INCOMING_MSG', 'Incoming Message', 'Incoming Message', 'Incoming Message', 't', 'w', '2021-04-20 11:21:26', '2021-05-25 06:25:11'),
(281, 'IMEDIATE_AVAILABLE', 'Immediate Available ', 'Immediate Available ', 'Immediate Available ', 't', 'w', '2021-04-20 14:29:45', '2021-05-25 06:25:11'),
(282, 'ENTER_STATUS', 'Enter Status', 'Enter Status', 'Enter description', 't', 'w', '2021-04-20 15:10:04', '2021-05-25 06:25:11'),
(283, 'PLZ_ENTER_STATUS', 'Please enter status.', 'Please enter status.', 'Please enter description.', 't', 'w', '2021-04-20 15:22:03', '2021-05-25 06:25:11'),
(284, 'SUC_STATUS_ADDED', 'Status added successfully.', 'Status added successfully.', 'Status added successfully.', 't', 'w', '2021-04-20 16:04:33', '2021-05-25 06:25:11'),
(285, 'MSG_SOMETHING_WRONG', 'Something went wrong.', 'Something went wrong.', 'Something went wrong.', 't', 'w', '2021-04-20 16:21:07', '2021-05-25 06:25:11'),
(286, 'UNAVAILABLE', 'Unavailable', 'Unavailable', 'Unavailable', 't', 'w', '2021-04-21 17:48:37', '2021-05-25 06:25:11'),
(287, 'BOOKED', 'Booked', 'Booked', 'Booked', 't', 'w', '2021-04-21 18:41:09', '2021-05-25 06:25:11'),
(288, 'PLZ_SELECT_AVAILABILITY', 'Please select availability.', 'Please select availability.', 'Please select availability.', 't', 'w', '2021-04-22 17:59:22', '2021-05-25 06:25:11'),
(289, 'PLZ_SELECT_START_DATE', 'Please select start date.', 'Please select start date.', 'Please select start date.', 't', 'w', '2021-04-22 21:54:03', '2021-05-25 06:25:11'),
(290, 'PLZ_SELECT_END_DATE', 'Please select end date.', 'Please select end date.', 'Please select end date.', 't', 'w', '2021-04-22 21:54:46', '2021-05-25 06:25:11'),
(291, 'PLZ_SELECT_TIME_SLOT', 'Please select time slot.', 'Please select time slot.', 'Please select time slot.', 't', 'w', '2021-04-23 10:21:06', '2021-05-25 06:25:11'),
(292, 'MAKE_SLOT_AVAILABLE_MSG', 'Are you sure you want to make this slot available?', 'Are you sure you want to make this slot available?', 'Are you sure you want to make this slot available?', 't', 'w', '2021-04-23 10:59:59', '2021-05-25 06:25:11'),
(293, 'MAKE_DATE_AVAILABLE_MSG', 'Are you sure you want to make this date available?', 'Are you sure you want to make this date available?', 'Are you sure you want to make this date available?', 't', 'w', '2021-04-23 14:39:20', '2021-05-25 06:25:11'),
(294, 'SERVICES_PROVIDED', 'Services Provided', 'Services Provided', 'Services Provided', 't', 'w', '2021-04-27 18:41:47', '2021-05-25 06:25:11'),
(295, 'RCVD_REVIEWS_RATINGS', 'Received Review and Ratings', 'Received Review and Ratings', 'Received Review and Ratings', 't', 'w', '2021-04-27 18:55:19', '2021-05-25 06:25:11'),
(296, 'ENTER_BRAND_NAME', 'Enter brand name', 'Enter brand name', 'Enter vehicle brand name', 't', 'w', '2021-04-28 14:53:38', '2021-05-25 06:25:11'),
(297, 'ENTER_MODEL_NAME', 'Enter model name', 'Enter model name', 'Enter vehicle model name', 't', 'w', '2021-04-28 14:54:03', '2021-05-25 06:25:11'),
(298, 'ENTER_YEAR', 'Enter year', 'Enter year', 'Enter vehicle year', 't', 'w', '2021-04-28 14:54:28', '2021-05-25 06:25:11'),
(299, 'ENTER_ENGINE_NO', 'Enter engine number', 'Enter engine number', 'Enter vehicle engine number', 't', 'w', '2021-04-28 14:55:02', '2021-05-25 06:25:11'),
(300, 'MSG_VEHI_BRAND_REQ', 'Please enter vehicle brand name.', 'Please enter vehicle brand name.', 'Please enter vehicle brand name.', 't', 'w', '2021-04-28 14:56:23', '2021-05-25 06:25:11'),
(301, 'MSG_VEHI_MODEL_REQ', 'Please enter vehicle model name.', 'Please enter vehicle model name.', 'Please enter vehicle model name.', 't', 'w', '2021-04-28 14:57:23', '2021-05-25 06:25:11'),
(302, 'MSG_VEHI_YEAR_REQ', 'Please enter vehicle year.', 'Please enter vehicle year.', 'Please enter vehicle year.', 't', 'w', '2021-04-28 14:58:04', '2021-05-25 06:25:11'),
(303, 'MSG_VEHI_ENG_REQ', 'Please enter vehicle engine number.', 'Please enter vehicle engine number.', 'Please enter vehicle engine number.', 't', 'w', '2021-04-28 15:01:49', '2021-05-25 06:25:11'),
(304, 'VEHI_BRAND', 'Vehicle Brand', 'Vehicle Brand', 'Vehicle Brand', 't', 'w', '2021-04-28 16:03:46', '2021-05-25 06:25:11'),
(305, 'VEHI_MODEL', 'Vehicle Model', 'Vehicle Model', 'Vehicle Model', 't', 'w', '2021-04-28 16:04:22', '2021-05-25 06:25:11'),
(306, 'VEHI_YEAR', 'Vehicle Year', 'Vehicle Year', 'Vehicle Year', 't', 'w', '2021-04-28 16:04:54', '2021-05-25 06:25:11'),
(307, 'VEHI_ENGINE', 'Vehicle Engine No.', 'Vehicle Engine No.', 'Vehicle Engine No.', 't', 'w', '2021-04-28 16:05:43', '2021-05-25 06:25:11'),
(308, 'NEXT', 'Next', 'Next', 'Next', 't', 'w', '2021-04-28 19:13:09', '2021-05-25 06:25:11'),
(309, 'SURE_MOVE_TO_TRASH', 'Are you sure you want to move this chat to trash?', 'Are you sure you want to move this chat to trash?', 'Are you sure you want to move this chat to trash?', 't', 'w', '2021-04-30 12:16:40', '2021-05-25 06:25:11'),
(310, 'STATUS', 'Status', 'Status', 'Status', 't', 'w', '2021-05-03 12:32:04', '2021-05-25 06:25:11'),
(311, 'BOOK', 'Book', 'Book', 'Book', 't', 'w', '2021-05-03 12:34:08', '2021-05-25 06:25:11'),
(312, 'SERVICE', 'Service', 'Service', 'Service', 't', 'w', '2021-05-03 15:29:38', '2021-05-25 06:25:11'),
(313, 'AUTO', 'Auto', 'Auto', 'Auto', 't', 'w', '2021-05-03 15:30:33', '2021-05-25 06:25:11'),
(314, 'MY_SERVICE_REQUEST', 'My Service Request', 'My Service Request', 'My Service Request', 't', 'w', '2021-05-04 15:08:02', '2021-05-25 06:25:11'),
(315, 'NO_REQUEST_SENT', 'No any service request sent.', 'No any service request sent.', 'No any service request sent.', 't', 'w', '2021-05-04 15:11:39', '2021-05-25 06:25:11'),
(316, 'PENDING', 'Pending', 'Pending', 'Pending', 't', 'w', '2021-05-04 15:13:34', '2021-05-25 06:25:11'),
(317, 'SERVICE_REQUEST', 'New Service Request', 'New Service Request', 'New Service Request', 't', 'w', '2021-05-06 12:05:51', '2021-05-25 06:25:11'),
(318, 'PROVIDER_AVAILABILITY', 'Provider Availability', 'Provider Availability', 'Provider Availability', 't', 'w', '2021-05-06 12:16:23', '2021-05-25 06:25:11'),
(319, 'SELECT_SERVICE_START_DATE', 'Select start date', 'Select start date', 'Select start date', 't', 'w', '2021-05-06 12:48:34', '2021-05-25 06:25:11'),
(320, 'SELECT_SERVICE_END_DATE', 'Select end date', 'Select end date', 'Select end date', 't', 'w', '2021-05-06 12:50:08', '2021-05-25 06:25:11'),
(321, 'TAXI_PROV_NOT_AVAILABLE', 'Provider is not available for selected dates.', 'Provider is not available for selected dates.', 'Provider is not available for selected dates.', 't', 'w', '2021-05-06 14:30:02', '2021-05-25 06:25:11'),
(322, 'ENTER_VALID_NUMBER', 'Please enter valid amount.', 'Please enter valid amount.', 'Please enter valid amount.', 't', 'w', '2021-05-10 16:06:09', '2021-05-25 06:25:11'),
(323, 'MSG_AMOUNT_ADDED_SUC', 'Booking amount saved successfully.', 'Booking amount saved successfully.', 'Booking amount saved successfully.', 't', 'w', '2021-05-10 16:16:08', '2021-05-25 06:25:11'),
(324, 'PROIVDER_ADDED_AMOUNT', 'Provided Added Amount', 'Provided Added Amount', 'Provider Added Amount', 't', 'w', '2021-05-10 16:44:15', '2021-05-25 06:25:11');
INSERT INTO `tbl_constant_copy` (`id`, `constantName`, `value`, `value_2`, `value_1`, `type`, `status`, `created_date`, `updated_date`) VALUES
(325, 'ONLINE', 'Online', 'Online', 'Online', 't', 'w', '2021-05-13 17:28:20', '2021-05-25 06:25:11'),
(326, 'OFFLINE', 'Offline', 'Offline', 'Offline', 't', 'w', '2021-05-13 17:28:43', '2021-05-25 06:25:11'),
(327, 'PLZ_SELECT_PAYMENT_METHOD', 'Please select payment method.', 'Please select payment method.', 'Please select payment method.', 't', 'w', '2021-05-13 17:33:40', '2021-05-25 06:25:11'),
(328, 'MSG_PAYMENT_METHOD_SUC', 'Payment method successfully set as offline payment.', 'Payment method successfully set as offline payment.', 'Payment method successfully set as selected by you.', 't', 'w', '2021-05-13 18:27:05', '2021-05-25 06:25:11'),
(329, 'PROV_HAS_NOT_ADDED_PAYPAL', 'Provider has not added Paypal ID yet.', 'Provider has not added Paypal ID yet.', 'Provider has not added Paypal ID yet.', 't', 'w', '2021-05-13 18:41:01', '2021-05-25 06:25:11'),
(330, 'SERVICE_BOOKING_PAYMENT_FAILED', 'Service booking payment failed. Please try again.', 'Service booking payment failed. Please try again.', 'Service booking payment failed. Please try again.', 't', 'w', '2021-05-14 13:01:48', '2021-05-25 06:25:11'),
(331, 'SERVICE_BOOKING_PAYMENT_suc', 'Thank you , Payment status for this transaction is pending. Your payment is confirmed once completed.', 'Thank you , Payment status for this transaction is pending. Your payment is confirmed once completed.', 'Thank you , Payment status for this transaction is pending. Your payment is confirmed once completed.', 't', 'w', '2021-05-14 13:04:38', '2021-05-25 06:25:11'),
(332, 'PAYMENT_HISTORY', 'Payment History', 'Payment History', 'Payment History', 't', 'w', '2021-05-15 12:25:56', '2021-05-25 06:25:11'),
(333, 'NO_HISTORY_FOUND', 'No any payment history record found.', 'No any payment history record found.', 'No any payment history record found.', 't', 'w', '2021-05-15 12:33:11', '2021-05-25 06:25:11'),
(334, 'TRANSACTION_ID', 'Transaction ID', 'Transaction ID', 'Transaction ID', 't', 'w', '2021-05-15 14:05:03', '2021-05-25 06:25:11'),
(335, 'TRANS_DATE', 'Transaction Date', 'Transaction Date', 'Transaction Date', 't', 'w', '2021-05-15 14:09:06', '2021-05-25 06:25:11'),
(336, 'USER_NAME', 'User Name', 'User Name', 'User Name', 't', 'w', '2021-05-15 14:11:01', '2021-05-25 06:25:11'),
(337, 'PAYMENT_METHOD', 'Payment Method', 'Payment Method', 'Payment Method', 't', 'w', '2021-05-15 14:11:44', '2021-05-25 06:25:11'),
(338, 'MIZUTECH_DETAILS', 'Mizutech Details', 'Mizutech Details', 'Mizutech Details', 't', 'w', '2021-05-17 14:44:59', '2021-05-25 06:25:11'),
(339, 'ENTER_MIZU_NAME', 'Enter mizutech name', 'Enter mizutech name', 'Enter mizutech name', 't', 'w', '2021-05-17 14:46:05', '2021-05-25 06:25:11'),
(340, 'ENTER_MIZU_PWD', 'Enter mizutech password', 'Enter mizutech password', 'Enter mizutech password', 't', 'w', '2021-05-17 14:46:31', '2021-05-25 06:25:11'),
(341, 'MSG_ENT_MIZU_NAME', 'Please enter mizutech name.', 'Please enter mizutech name.', 'Please enter mizutech name.', 't', 'w', '2021-05-17 14:58:18', '2021-05-25 06:25:11'),
(342, 'MSG_ENT_MIZU_PWD', 'Please enter mizutech password.', 'Please enter mizutech password.', 'Please enter mizutech password.', 't', 'w', '2021-05-17 14:58:46', '2021-05-25 06:25:11'),
(343, 'MIZU_DETAILS_SAVED_SUC', 'Mizutech details saved successfully.', 'Mizutech details saved successfully.', 'Mizutech details saved successfully.', 't', 'w', '2021-05-17 15:02:29', '2021-05-25 06:25:11'),
(344, 'LOCATION_DETAILS', 'Location Details', 'Location Details', 'Location Details', 't', 'w', '2021-05-17 15:33:25', '2021-05-25 06:25:11'),
(345, 'CANCEL_BY_YOU', 'Service request cancelled by you.', 'Service request cancelled by you.', 'Service request cancelled by you.', 't', 'w', '2021-05-17 16:30:57', '2021-05-25 06:25:11'),
(346, 'REQUEST_RECEIVED_NOTI_MSG', 'New service request received.', 'New service request received.', 'New service request received.', 't', 'w', '2021-05-17 16:38:29', '2021-05-25 06:25:11'),
(347, 'REQUEST_ACCEPTED_NOTI_MSG', 'Service request accepted by provider.', 'Service request accepted by provider.', 'Service request accepted by provider.', 't', 'w', '2021-05-17 16:57:14', '2021-05-25 06:25:11'),
(348, 'LOAD_PREVIOUS', 'Load Previous', 'Load Previous', 'Load Previous', 't', 'w', '2021-05-18 15:15:10', '2021-05-25 06:25:11'),
(349, 'SELECT_CUSTOMER', 'Select Customer', 'Select Customer', 'Select Customer', 't', 'w', '2021-05-19 14:48:05', '2021-05-25 06:25:11'),
(350, 'PLZ_SELECT_CUSTOMER', 'Please select customer.', 'Please select customer.', 'Please select customer.', 't', 'w', '2021-05-19 15:17:12', '2021-05-25 06:25:11'),
(351, 'ADD_AMOUNT', 'Add Amount', 'Add Amount', 'Add Amount', 't', 'w', '2021-05-20 11:45:49', '2021-05-25 06:25:11'),
(352, 'ADD_REVIEW', 'Add Review', 'Add Review', 'Add Review', 't', 'w', '2021-05-20 11:49:21', '2021-05-25 06:25:11'),
(353, 'ONE_LETTER_REQUIRED', 'Please enter at least one letter.', 'Please enter at least one letter.', 'Please enter at least one letter.', 't', 'w', '2021-05-20 14:44:19', '2021-05-25 06:25:11'),
(354, 'INVALID_RESET_LINK', 'Given reset password link is invalid.', 'Given reset password link is invalid.', 'Given reset password link is expired.', 't', 'w', '2021-05-20 15:43:59', '2021-05-25 06:25:11'),
(355, 'ADD_REQUEST', 'Add Request', 'Add Request', 'Add Request', 't', 'w', '2021-05-21 10:29:40', '2021-05-25 06:25:11'),
(356, 'RESEND_VERIFICATION_MAIL', 'Resend verification mail', 'Resend verification mail', 'Resend verification mail', 't', 'w', '2021-05-21 12:14:10', '2021-05-25 06:25:11'),
(357, 'invalidEmailId', 'Invalid EmaiId', 'Invalid EmaiId', 'Invalid EmaiId', 't', 'w', '2021-05-21 12:23:12', '2021-05-25 06:25:11'),
(358, 'HINT_FNAME', 'Enter first name*', 'Enter first name*', 'Enter first name*', 't', 'w', '2021-05-21 13:50:21', '2021-05-25 06:25:11'),
(359, 'DONT_ACCOUNT', 'Don\\\'t you have an account?', 'Don\\\'t you have an account?', 'Don\\\'t you have an account?', 't', 'w', '2021-05-21 13:52:40', '2021-05-25 06:25:11'),
(360, 'HINT_LNAME', 'Enter last name*', 'Enter last name*', 'Enter last name*', 't', 'w', '2021-05-21 13:54:51', '2021-05-25 06:25:11'),
(361, 'HINT_CONTACT_NO', 'Enter contact number*', 'Enter contact number*', 'Enter contact number*', 't', 'w', '2021-05-21 13:58:11', '2021-05-25 06:25:11'),
(362, 'HINT_EMAIL_ID', 'Enter email id*', 'Enter email id*', 'Enter email id*', 't', 'w', '2021-05-21 14:00:21', '2021-05-25 06:25:11'),
(363, 'HINT_PWD', 'Enter password*', 'Enter password*', 'Enter password*', 't', 'w', '2021-05-21 14:01:58', '2021-05-25 06:25:11'),
(364, 'HINT_PWD_CONFITM', 'Enter confirm password*', 'Enter confirm password*', 'Enter confirm password*', 't', 'w', '2021-05-21 14:03:15', '2021-05-25 06:25:11'),
(365, 'ERR_MSG_INVALID_CONTACT', 'Invalid contact number', 'Invalid contact number', 'Invalid contact number', 't', 'w', '2021-05-21 14:13:45', '2021-05-25 06:25:11'),
(366, 'SETTINGS', 'Settings', 'Settings', 'Settings', 't', 'w', '2021-05-21 14:26:56', '2021-05-25 06:25:11'),
(367, 'MSG_SURE_LOGOUT', 'Are you sure to logout?', 'Are you sure to logout?', 'Are you sure to logout?', 't', 'w', '2021-05-21 14:36:46', '2021-05-25 06:25:11'),
(368, 'EXIT', 'Exit', 'Exit', 'Exit', 't', 'w', '2021-05-21 14:39:19', '2021-05-25 06:25:11'),
(369, 'MSG_SURE_EXIT', 'Are you sure to exit?', 'Are you sure to exit?', 'Are you sure to exit?', 't', 'w', '2021-05-21 14:40:34', '2021-05-25 06:25:11'),
(370, 'MORE', 'More', 'More', 'More', 't', 'w', '2021-05-21 14:53:14', '2021-05-25 06:25:11'),
(371, 'LOC_NOT_FOUND', 'Location not found', 'Location not found', 'Location not found', 't', 'w', '2021-05-21 15:15:47', '2021-05-25 06:25:11'),
(372, 'FILTER_BY', 'Filter by', 'Filter by', 'Filter by', 't', 'w', '2021-05-21 15:46:00', '2021-05-25 06:25:11'),
(373, 'APPLY_FILTER', 'Apply Filter', 'Apply Filter', 'Apply Filter', 't', 'w', '2021-05-21 15:50:13', '2021-05-25 06:25:11'),
(374, 'ERR_MSG_RADIUS', 'Radius must be greater than zero', 'Radius must be greater than zero', 'Radius must be greater than zero', 't', 'w', '2021-05-21 15:55:27', '2021-05-25 06:25:11'),
(375, 'ERR_MSG_FILTER', 'No data found for filter', 'No data found for filter', 'No data found for filter', 't', 'w', '2021-05-21 15:58:01', '2021-05-25 06:25:11'),
(376, 'PROFILE_IMG', 'Upload Profile Picture', 'Upload Profile Picture', 'Upload Profile Picture', 't', 'w', '2021-05-21 16:19:51', '2021-05-25 06:25:11'),
(377, 'SEND_REQ', 'Send Request', 'Send Request', 'Send Request', 't', 'w', '2021-05-21 16:54:18', '2021-05-25 06:25:11'),
(378, 'DELETE', 'Delete', 'Delete', 'Delete', 't', 'w', '2021-05-21 17:25:19', '2021-05-25 06:25:11'),
(379, 'MSG_SURE_DELETE', 'Are you sure want to delete?', 'Are you sure want to delete?', 'Are you sure want to delete?', 't', 'w', '2021-05-21 17:27:05', '2021-05-25 06:25:11'),
(380, 'LANG_SELECTION', 'Language Selection', 'Language Selection', 'Language Selection', 't', 'w', '2021-05-24 09:17:09', '2021-05-25 06:25:11'),
(381, 'UPDATE_BTN', 'Update', 'Update', 'Update', 't', 'w', '2021-05-24 09:21:31', '2021-05-25 06:25:11'),
(382, 'VIN', 'VIN', 'VIN', 'VIN', 't', 'w', '2021-05-24 10:03:34', '2021-05-25 06:25:11'),
(383, 'ENGINE_POW_KW', 'Engine Power (kW)', 'Engine Power (kW)', 'Engine Power (kW)', 't', 'w', '2021-05-24 10:05:31', '2021-05-25 06:25:11'),
(384, 'ERR_MSG_SERVICE_AMT', 'Please enter service amount', 'Please enter service amount', 'Please enter service amount', 't', 'w', '2021-05-24 10:21:03', '2021-05-25 06:25:11'),
(385, 'ERR_MSG_SERVICE_AMT_GREATER_ZERO', 'Service amount must be greater than zero', 'Service amount must be greater than zero', 'Service amount must be greater than zero', 't', 'w', '2021-05-24 10:22:39', '2021-05-25 06:25:11'),
(386, 'ERR_MSG_SERVICE_DESC', 'Please enter service description', 'Please enter service description', 'Please enter service description', 't', 'w', '2021-05-24 10:24:10', '2021-05-25 06:25:11'),
(387, 'ENTER_SERVICE_NAME', 'Enter service name', 'Enter service name', 'Enter service name', 't', 'w', '2021-05-24 10:24:39', '2021-05-25 06:25:11'),
(388, 'VIN_NOT_FOUND', 'VIN number not found', 'VIN number not found', 'VIN number not found', 't', 'w', '2021-05-24 10:25:49', '2021-05-25 06:25:11'),
(389, 'PLZ_ENTER_SERVICE_NAME', 'Please enter service name.', 'Please enter service name.', 'Please enter service name.', 't', 'w', '2021-05-24 10:28:59', '2021-05-25 06:25:11'),
(390, 'PREVIOUS', 'Previous', 'Previous', 'Previous', 't', 'w', '2021-05-24 10:39:29', '2021-05-25 06:25:11'),
(391, 'SERVICE_LOC_MAP', 'Service Location Map', 'Service Location Map', 'Service Location Map', 't', 'w', '2021-05-24 10:39:51', '2021-05-25 06:25:11'),
(392, 'POST_REVIEW', 'Post Review', 'Post Review', 'Post Review', 't', 'w', '2021-05-24 10:42:13', '2021-05-25 06:25:11'),
(393, 'PAY_BTN', 'Pay', 'Pay', 'Pay', 't', 'w', '2021-05-24 10:47:07', '2021-05-25 06:25:11'),
(394, 'MSG_GIVE_RATING', 'Please give rating', 'Please give rating', 'Please give rating', 't', 'w', '2021-05-24 11:00:27', '2021-05-25 06:25:11'),
(395, 'YOU_HAVe_PAID', 'You have paid', 'You have paid', 'You have paid', 't', 'w', '2021-05-24 11:02:22', '2021-05-25 06:25:11'),
(396, 'LBL_TO', 'to', 'to', 'to', 't', 'w', '2021-05-24 11:04:06', '2021-05-25 06:25:11'),
(397, 'LBL_BY', 'by', 'by', 'by', 't', 'w', '2021-05-24 11:05:14', '2021-05-25 06:25:11'),
(398, 'PAYMENT_CANCELLED', 'Payment Cancelled', 'Payment Cancelled', 'Payment Cancelled', 't', 'w', '2021-05-24 11:07:53', '2021-05-25 06:25:11'),
(399, 'SERVICE_CATEGORY', 'Service Category', 'Service Category', 'Service Category', 't', 'w', '2021-05-24 11:19:48', '2021-05-25 06:25:11'),
(400, 'MAX_FIVE_IMG_ALLOW', 'Maximum five images allow', 'Maximum five images allow', 'Maximum five images allow', 't', 'w', '2021-05-24 14:10:51', '2021-05-25 06:25:11'),
(401, 'UPLOAD_PICTURE', 'Upload Picture', 'Upload Picture', 'Upload Picture', 't', 'w', '2021-05-24 14:22:59', '2021-05-25 06:25:11'),
(402, 'ALERT_LBL', 'Alert', 'Alert', 'Alert', 't', 'w', '2021-05-24 15:06:04', '2021-05-25 06:25:11'),
(403, 'ERR_MSG_CUS_MIZ_DETIAL_NOT_FOUND', 'You are not eligible to make a call or did not get live messages due to Mizutech account detail not found.', 'You are not eligible to make a call or did not get live messages due to Mizutech account detail not found.', 'You are not eligible to make a call or did not get live messages due to Mizutech account detail not found.', 't', 'w', '2021-05-24 15:08:16', '2021-05-25 06:25:11'),
(404, 'OK_BTN', 'Ok', 'Ok', 'Ok', 't', 'w', '2021-05-24 15:09:34', '2021-05-25 06:25:11'),
(405, 'PLZ_UPLAOD_PROFILE_PIC', 'Please upload profile picture.', 'Please upload profile picture.', 'Please upload profile picture.', 't', 'w', '2021-05-24 15:13:07', '2021-05-25 06:25:11'),
(406, 'VIEW_DETAIL', 'View Detail', 'View Detail', 'View Detail', 't', 'w', '2021-05-24 16:16:33', '2021-05-25 06:25:11'),
(407, 'LBL_FROM', 'from', 'from', 'from', 't', 'w', '2021-05-24 17:24:24', '2021-05-25 06:25:11'),
(408, 'YOU_HAVE_RECEIVED', 'You have received', 'You have received', 'You have received', 't', 'w', '2021-05-24 17:25:42', '2021-05-25 06:25:11'),
(409, 'PLZ_ENABLE_LOCATION', 'Please allow the access of your location from \r\n browser settings so that you can see proper result.', 'Please allow the access of your location from \r\n browser settings so that you can see proper result.', 'Please allow the access of your location from \r\n browser settings so that you can see proper result.', 't', 'w', '2021-05-24 17:43:38', '2021-05-25 06:25:11'),
(410, 'ERR_MSG_MIN_IMG', 'Please select  minimum one image', 'Please select minimum one image', 'Please select  minimum one image', 't', 'w', '2021-05-25 12:53:15', '2021-05-25 07:23:16'),
(411, 'POST_REG', 'Post Registration', 'Post Registration', 'Post Registration', 't', 'w', '2021-05-25 12:56:04', '2021-05-25 07:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `id` int(11) NOT NULL,
  `firstName` varchar(64) NOT NULL,
  `lastName` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `contactNo` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `replayMessage` varchar(255) NOT NULL,
  `createdDate` datetime NOT NULL,
  `ipAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_contact_us`
--

INSERT INTO `tbl_contact_us` (`id`, `firstName`, `lastName`, `email`, `contactNo`, `subject`, `message`, `replayMessage`, `createdDate`, `ipAddress`) VALUES
(5, 'pinal', 'dave', 'pinal.dave@ncrypted.com', '1234567890', 'test', 'test msg', 'test msg reply', '2020-12-28 19:00:50', '::1'),
(6, 'test', 'user', 'ashvin.dethariya@ncrypted.com', '1234567890', 'subject 1', 'test msg', '', '2021-03-09 14:42:10', '223.255.247.114'),
(7, 'Test', 'Provider', 'provider@mailinator.com', '1234567890', 'Test', 'here I shar comment....', '', '2021-03-15 17:42:08', '49.34.80.209'),
(8, 'Test', 'Provider', 'provider@mailinator.com', '1234567890', 'Demo', 'dummy text', '', '2021-03-15 18:06:20', '49.34.80.209'),
(9, '656', '6$#%%', 'parina.test2@gmail.com', '1234567890', 'teeeee', 'dgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjk dgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjkdgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjkdgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjkdgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjkdgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjkdgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjkdgtjlkij uykytlujhioyhjuyklujykhljmhgkljmnoiphjk', 'ok user we will keep it.. ok user we will keep it..ok user we will keep it..ok user we will keep it..ok user we will keep it..ok user we will keep it..ok user we will keep it..ok user we will keep it..ok user we will keep it..ok user we will keep it..ok u', '2021-05-28 20:03:59', '106.213.208.39'),
(10, 'Richard', 'Pompa', 'richardpompa@mail.com', '7550870383', 'Search', 'search don\\\'t work the way it should. \ni am not able to search for specific providers', '', '2021-05-31 12:01:28', '82.132.222.217'),
(11, 'hgyrtfy', 'ytry', 'parina.test@gmail.com', '6546576676546', 'frds', 'fer', '', '2021-06-02 17:25:41', '106.213.192.156'),
(12, 'tax', 'service', 'parina.test2@gmail.com', '1234567895', 'Xfxfg', 'gcg hvhvjvjv\nchvhchvhvhvugu to the king of the day of the day of the day', '', '2021-06-08 14:11:42', '106.213.235.175'),
(13, 'bgh', 'hgf', 'tret@hgh.jh', '7657887989', 'rte', 'tret', '', '2021-06-18 15:34:43', '223.184.204.160');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content`
--

CREATE TABLE `tbl_content` (
  `pId` int(8) UNSIGNED NOT NULL,
  `pageTitle` varchar(255) NOT NULL,
  `pageTitle_1` varchar(255) DEFAULT NULL,
  `metaKeyword` mediumtext NOT NULL,
  `metaKeyword_1` text,
  `metaDesc` mediumtext NOT NULL,
  `metaDesc_1` text,
  `pageDesc` mediumtext NOT NULL,
  `pageDesc_1` text,
  `page_slug` varchar(128) NOT NULL,
  `linkType` varchar(50) DEFAULT NULL,
  `delete_option` enum('y','n') NOT NULL DEFAULT 'y',
  `url` varchar(250) DEFAULT NULL,
  `isActive` enum('y','n','t') NOT NULL DEFAULT 'y' COMMENT '1=Active, 0=Deactive',
  `createdDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_content`
--

INSERT INTO `tbl_content` (`pId`, `pageTitle`, `pageTitle_1`, `metaKeyword`, `metaKeyword_1`, `metaDesc`, `metaDesc_1`, `pageDesc`, `pageDesc_1`, `page_slug`, `linkType`, `delete_option`, `url`, `isActive`, `createdDate`) VALUES
(1, 'About Us', 'About Us', 'About Us', 'About Us', 'About Us', 'About Us', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/about.png\" /></div>\r\n\r\n<div class=\"col-md-6 content-des\">\r\n<h2>About AutoService Global</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Lorem Ipsum is simply dummy text of the printing</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Lorem Ipsum is simply dummy text of the printing</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/about.png\" /></div>\r\n\r\n<div class=\"col-md-6 content-des\">\r\n<h2>About AutoService Global</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Lorem Ipsum is simply dummy text of the printing</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Lorem Ipsum is simply dummy text of the printing</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'about-us', 'page', 'n', '', 'y', '2017-12-02 11:16:44'),
(2, 'FAQs', 'FAQs', 'FAQs', 'FAQs', 'FAQs', 'FAQs', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-8 offset-md-2 content-des faq-main\">\r\n<div class=\"faq-main-content\" id=\"accordion\">\r\n<div class=\"faq-li\">\r\n<div id=\"headingOne\">\r\n<h2 class=\"mb-0\"><button aria-controls=\"collapseOne\" aria-expanded=\"true\" class=\"btn btn-link\" data-target=\"#collapseOne\" data-toggle=\"collapse\">Lorem Ipsum is simply dummy text?</button></h2>\r\n</div>\r\n\r\n<div aria-labelledby=\"headingOne\" class=\"collapse show\" data-parent=\"#accordion\" id=\"collapseOne\">\r\n<div class=\"content-des\">\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul class=\"content-links\">\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"faq-li\">\r\n<div id=\"headingTwo\">\r\n<h5 class=\"mb-0\"><button aria-controls=\"collapseTwo\" aria-expanded=\"false\" class=\"btn btn-link collapsed\" data-target=\"#collapseTwo\" data-toggle=\"collapse\">Collapsible Group Item #2</button></h5>\r\n</div>\r\n\r\n<div aria-labelledby=\"headingTwo\" class=\"collapse\" data-parent=\"#accordion\" id=\"collapseTwo\">\r\n<div class=\"card-body\">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&#39;t heard of them accusamus labore sustainable VHS.</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"faq-li\">\r\n<div id=\"headingThree\">\r\n<h5 class=\"mb-0\"><button aria-controls=\"collapseThree\" aria-expanded=\"false\" class=\"btn btn-link collapsed\" data-target=\"#collapseThree\" data-toggle=\"collapse\">Collapsible Group Item #3</button></h5>\r\n</div>\r\n\r\n<div aria-labelledby=\"headingThree\" class=\"collapse\" data-parent=\"#accordion\" id=\"collapseThree\">\r\n<div class=\"card-body\">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&#39;t heard of them accusamus labore sustainable VHS.</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-8 offset-md-2 content-des faq-main\">\r\n<div class=\"faq-main-content\" id=\"accordion\">\r\n<div class=\"faq-li\">\r\n<div id=\"headingOne\">\r\n<h2 class=\"mb-0\"><button aria-controls=\"collapseOne\" aria-expanded=\"true\" class=\"btn btn-link\" data-target=\"#collapseOne\" data-toggle=\"collapse\">Lorem Ipsum is simply dummy text?</button></h2>\r\n</div>\r\n\r\n<div aria-labelledby=\"headingOne\" class=\"collapse show\" data-parent=\"#accordion\" id=\"collapseOne\">\r\n<div class=\"content-des\">\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul class=\"content-links\">\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"faq-li\">\r\n<div id=\"headingTwo\">\r\n<h5 class=\"mb-0\"><button aria-controls=\"collapseTwo\" aria-expanded=\"false\" class=\"btn btn-link collapsed\" data-target=\"#collapseTwo\" data-toggle=\"collapse\">Collapsible Group Item #2</button></h5>\r\n</div>\r\n\r\n<div aria-labelledby=\"headingTwo\" class=\"collapse\" data-parent=\"#accordion\" id=\"collapseTwo\">\r\n<div class=\"card-body\">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&#39;t heard of them accusamus labore sustainable VHS.</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"faq-li\">\r\n<div id=\"headingThree\">\r\n<h5 class=\"mb-0\"><button aria-controls=\"collapseThree\" aria-expanded=\"false\" class=\"btn btn-link collapsed\" data-target=\"#collapseThree\" data-toggle=\"collapse\">Collapsible Group Item #3</button></h5>\r\n</div>\r\n\r\n<div aria-labelledby=\"headingThree\" class=\"collapse\" data-parent=\"#accordion\" id=\"collapseThree\">\r\n<div class=\"card-body\">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&#39;t heard of them accusamus labore sustainable VHS.</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'faqs', 'page', 'y', '', 'y', '2017-12-02 11:15:41'),
(3, 'How it works', 'How it works', 'How it works', 'How it works', 'How it works', 'How it works', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row center-item\">\r\n<div class=\"col-md-12 col-lg-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/hiw1.png\" /></div>\r\n\r\n<div class=\"col-md-12 col-lg-6 content-des\">\r\n<h2>Engine Overhaul</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"row center-item flex-lg-row flex-md-column-reverse\">\r\n<div class=\"col-md-12 col-lg-6 content-des\">\r\n<h2>Car Services</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 col-lg-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/hiw2.png\" /></div>\r\n</div>\r\n\r\n<div class=\"row center-item\">\r\n<div class=\"col-md-12 col-lg-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/hiw3.png\" /></div>\r\n\r\n<div class=\"col-md-12 col-lg-6 content-des\">\r\n<h2>Body Work</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row center-item\">\r\n<div class=\"col-md-12 col-lg-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/hiw1.png\" /></div>\r\n\r\n<div class=\"col-md-12 col-lg-6 content-des\">\r\n<h2>Engine Overhaul</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"row center-item flex-lg-row flex-md-column-reverse\">\r\n<div class=\"col-md-12 col-lg-6 content-des\">\r\n<h2>Car Services</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 col-lg-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/hiw2.png\" /></div>\r\n</div>\r\n\r\n<div class=\"row center-item\">\r\n<div class=\"col-md-12 col-lg-6\"><img class=\"content-img\" src=\"https://asg.ncryptedprojects.com/themes-nct/images-nct/hiw3.png\" /></div>\r\n\r\n<div class=\"col-md-12 col-lg-6 content-des\">\r\n<h2>Body Work</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'how-it-works', 'page', 'y', '', 'y', '2017-12-02 11:12:59'),
(4, 'Terms & Conditions', 'Terms & Conditions', 'Terms & Conditions ', 'Terms & Conditions ', 'Terms & Conditions', 'Terms & Conditions', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Lorem Ipsum is simply dummy</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>The standard Lorem Ipsum passage, used since the 1500s</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>01. The standard chunk of Lorem Ipsum used since the 1500s</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>02. There are many variations of passages of Lorem Ipsum available</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>03. If you are going to use a passage of Lorem Ipsum</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul>\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n</ul>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Lorem Ipsum is simply dummy</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>The standard Lorem Ipsum passage, used since the 1500s</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>01. The standard chunk of Lorem Ipsum used since the 1500s</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>02. There are many variations of passages of Lorem Ipsum available</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>03. If you are going to use a passage of Lorem Ipsum</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul>\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n	<li>When an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>It has survived not only five centuries, but also the leap into.</li>\r\n	<li>Electronic typesetting, remaining essentially unchanged.</li>\r\n</ul>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'terms-conditions', 'page', 'y', '', 'n', '2017-12-02 11:17:28'),
(5, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-12 content-des\">\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul>\r\n	<li><a href=\"#\">01. The standard chunk of Lorem Ipsum used since the 1500s </a></li>\r\n	<li><a href=\"#\">02. There are many variations of passages of Lorem Ipsum available </a></li>\r\n	<li><a href=\"#\">03. If you are going to use a passage of Lorem Ipsum </a></li>\r\n</ul>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>01. The standard chunk of Lorem Ipsum used since the 1500s</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul>\r\n	<li>01. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>02. It has survived not only five centuries, but also the leap into.</li>\r\n	<li>03. electronic typesetting, remaining essentially unchanged.</li>\r\n	<li>04. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>05. It has survived not only five centuries, but also the leap into.</li>\r\n	<li>06. electronic typesetting, remaining essentially unchanged.</li>\r\n</ul>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>02. There are many variations of passages of Lorem Ipsum available</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>03. If you are going to use a passage of Lorem Ipsum</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '<div class=\"main-content\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-12 content-des\">\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul>\r\n	<li><a href=\"#\">01. The standard chunk of Lorem Ipsum used since the 1500s </a></li>\r\n	<li><a href=\"#\">02. There are many variations of passages of Lorem Ipsum available </a></li>\r\n	<li><a href=\"#\">03. If you are going to use a passage of Lorem Ipsum </a></li>\r\n</ul>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>01. The standard chunk of Lorem Ipsum used since the 1500s</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<ul>\r\n	<li>01. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>02. It has survived not only five centuries, but also the leap into.</li>\r\n	<li>03. electronic typesetting, remaining essentially unchanged.</li>\r\n	<li>04. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</li>\r\n	<li>05. It has survived not only five centuries, but also the leap into.</li>\r\n	<li>06. electronic typesetting, remaining essentially unchanged.</li>\r\n</ul>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>02. There are many variations of passages of Lorem Ipsum available</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n\r\n<div class=\"col-md-12 content-des\">\r\n<h2>03. If you are going to use a passage of Lorem Ipsum</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'privacy-policy', 'page', 'y', '', 'y', '2021-03-09 10:24:04'),
(6, 'Are You Provider', 'Are You Provider', 'Are You Provider', 'Are You Provider', 'Are You Provider', 'Are You Provider', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n\r\n<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'are-you-provider', NULL, 'y', NULL, 'y', '2021-03-22 12:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_notification_setting`
--

CREATE TABLE `tbl_email_notification_setting` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED DEFAULT NULL,
  `request_received` enum('y','n') NOT NULL DEFAULT 'y',
  `service_completed` enum('y','n') NOT NULL DEFAULT 'y',
  `service_cancelled` enum('y','n') NOT NULL DEFAULT 'y',
  `assigned_customer` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_email_notification_setting`
--

INSERT INTO `tbl_email_notification_setting` (`id`, `userId`, `request_received`, `service_completed`, `service_cancelled`, `assigned_customer`) VALUES
(1, 5, 'y', 'y', 'y', 'y'),
(2, 6, 'y', 'y', 'y', 'y'),
(3, 7, 'y', 'y', 'y', 'y'),
(8, 10, 'n', 'n', 'n', 'y'),
(13, 15, 'y', 'n', 'n', 'y'),
(15, 4, 'y', 'y', 'y', 'y'),
(16, 16, 'y', 'y', 'y', 'y'),
(17, 17, 'y', 'y', 'y', 'y'),
(18, 18, 'y', 'y', 'y', 'y'),
(19, 19, 'y', 'y', 'y', 'y'),
(20, 20, 'y', 'y', 'y', 'y'),
(21, 21, 'y', 'y', 'y', 'y'),
(22, 22, 'y', 'y', 'y', 'y'),
(23, 23, 'y', 'y', 'y', 'y'),
(24, 1, 'n', 'y', 'y', 'y'),
(25, 26, 'y', 'y', 'y', 'y'),
(26, 27, 'y', 'y', 'y', 'y'),
(27, 28, 'y', 'y', 'y', 'y'),
(28, 29, 'y', 'y', 'y', 'y'),
(29, 30, 'y', 'y', 'y', 'y'),
(30, 31, 'y', 'y', 'y', 'y'),
(31, 32, 'y', 'y', 'y', 'y'),
(32, 33, 'y', 'y', 'y', 'y'),
(33, 34, 'y', 'y', 'y', 'y'),
(34, 35, 'y', 'y', 'y', 'y'),
(35, 36, 'y', 'y', 'y', 'y'),
(36, 37, 'y', 'y', 'y', 'y'),
(37, 38, 'y', 'y', 'y', 'y'),
(38, 39, 'y', 'y', 'y', 'y'),
(39, 40, 'y', 'y', 'y', 'y'),
(40, 41, 'y', 'y', 'y', 'y'),
(41, 42, 'y', 'y', 'y', 'y'),
(42, 43, 'y', 'y', 'y', 'y'),
(43, 44, 'y', 'y', 'y', 'y'),
(44, 45, 'y', 'y', 'y', 'y'),
(45, 46, 'y', 'y', 'y', 'y'),
(46, 46, 'y', 'y', 'y', 'y'),
(47, 47, 'y', 'y', 'y', 'y'),
(48, 48, 'y', 'y', 'y', 'y'),
(49, 49, 'y', 'y', 'y', 'y'),
(50, 50, 'y', 'y', 'y', 'y'),
(51, 51, 'y', 'y', 'y', 'y'),
(52, 52, 'y', 'y', 'y', 'y'),
(53, 53, 'y', 'y', 'y', 'y'),
(54, 54, 'y', 'y', 'y', 'y'),
(55, 55, 'y', 'y', 'y', 'y'),
(56, 56, 'y', 'y', 'y', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_templates`
--

CREATE TABLE `tbl_email_templates` (
  `id` int(8) UNSIGNED NOT NULL,
  `constant` varchar(255) NOT NULL,
  `types` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `templates` mediumtext,
  `isActive` enum('y','n','t') NOT NULL DEFAULT 'y',
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_email_templates`
--

INSERT INTO `tbl_email_templates` (`id`, `constant`, `types`, `subject`, `description`, `templates`, `isActive`, `updateDate`) VALUES
(1, 'user_register', 'User Register', 'Registered sucessfully on ###SITE_NM###', 'user registration', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n    <tbody>\r\n        <tr>\r\n            <td>\r\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td>\r\n                                <div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <div>&nbsp;</div>\r\n\r\n                <div style=\\\"color: #444444; font-size: 22px; padding-left: 10px;\\\"><strong>Thank you for registration!</strong></div>\r\n\r\n                <div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n                    <div>&nbsp;</div>\r\n\r\n                    <p>Hello ###greetings###,</p>\r\n\r\n                    <p>This message serves as confirmation that your account has been successfully created.</p>\r\n\r\n                    <p>###activationLink###</p>\r\n\r\n                    <div>&nbsp;</div>\r\n                </div>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td>\r\n                                <div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n                            </td>\r\n                        </tr>\r\n                    </tbody>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 'y', '2018-01-06 09:29:20'),
(4, 'contactus_reply', 'Contact Us reply by Admin', 'Reply Message from Admin for your query in ###SITE_NM###', 'Contact Us reply from admin', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"color: #444444; font-size: 22px; padding-left: 10px;\\\"><strong>Contact Us Reply!</strong></div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>&nbsp;</div>\r\n\r\n			<p>Hello ###greetings###,</p>\r\n\r\n			<p>You have received a messag reply from admin regarding your query.</p>\r\n\r\n			<p>Please find detail given below.</p>\r\n\r\n			<p>Message : ###message###</p>\r\n\r\n			<p>Reply Message : ###reply###</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2018-02-28 10:23:32'),
(6, 'user_forgot_password', 'User Forgot Password', 'Reset Password on ###SITE_NM###', 'user forgot password', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>&nbsp;</div>\r\n\r\n			<p>Hello ###greetings###,</p>\r\n\r\n			<p style=\\\"color: rgb(89, 89, 89); font-size: 15px;\\\">Click below link to change your Password.</p>\r\n\r\n			<p style=\\\"color: rgb(89, 89, 89); font-size: 15px;\\\">###passLink###</p>\r\n			&nbsp;\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-02-19 10:33:26'),
(7, 'resend_verification', 'Resend Verification', 'Activation Link on ###SITE_NM###', 'resend verification', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>&nbsp;</div>\r\n\r\n			<p>Hello ###greetings###,</p>\r\n\r\n			<p>Below is the activation link.</p>\r\n\r\n			<p>###activationLink###</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2018-03-05 04:52:38'),
(8, 'user_contactus', 'User Contact Us', 'User Contact Us for site ###SITE_NM###', 'User Contact Us', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"color: #444444; font-size: 22px; padding-left: 10px;\\\"><strong>User Contact Us!</strong></div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>&nbsp;</div>\r\n\r\n			<p>Hello Admin,</p>\r\n\r\n			<p>This message serves as a contact us has been submitted by an user.Please find detail&nbsp;given&nbsp;below.</p>\r\n\r\n			<p>User Name : ###username###</p>\r\n\r\n			<p>Email Id : ###email###</p>\r\n\r\n			<p>Message : ###message###</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-05-17 12:07:50'),
(9, 'request_received', 'Request Received', 'Request Received for site ###SITE_NM###', 'Request Received', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>You have received one new service request from ###customerName###. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-05-17 12:22:41'),
(10, 'request_accepted', 'Request Accepted', 'Request Accepted for site ###SITE_NM###', 'Request Accepted', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Your service request has been accepted by ###providerName###. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-05-17 12:21:05'),
(28, 'change_email_address', 'Change Email Address', 'Change Email Address', 'Change Email Address', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Please click on the link to change your account email address.</p>\r\n\r\n			<p>###old_email### to ###new_email###.</p>\r\n\r\n			<p>###verificationLink###</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-03-09 11:38:45'),
(29, 'service_cancelled_by_provider', 'Service cancelled by provider', 'Service cancelled by provider', 'Service cancelled by provider', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Proivder has cancelled your service request. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-04-06 07:39:02'),
(30, 'service_cancelled_by_customer', 'Service cancelled by customer', 'Service cancelled by customer', 'Service cancelled by customer', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Customer has cancelled your service request. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-04-06 07:40:03'),
(31, 'service_complete_by_provider', 'Service completed by provider', 'Service completed by provider', 'Service completed by provider', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Proivder has marked service as complete. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-04-07 02:33:40'),
(32, 'service_complete_by_customer', 'Service completed by customer', 'Service completed by customer', 'Service completed by customer', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Customer has marked service as complete. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-04-07 02:33:20'),
(33, 'service_cancelled_by_you', 'Service cancelled by you', 'Service cancelled by you', 'Service cancelled by you', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>You have&nbsp;cancelled service request. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-05-17 11:04:05'),
(34, 'admin_forgot_password', 'Admin forgot password', 'Forgot password', 'Forgot password', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Your password is reset and new password is&nbsp;###new_password###.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-06-02 11:57:59'),
(35, 'request_by_provider', 'Request Created By Provider', 'Request Created By Provider for site ###SITE_NM###', 'Request Created By Provider', '<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#FFFFFF; margin:0 auto 0; width:550px\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#444444; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div class=\\\"logo\\\" style=\\\"font-size:40px; color:#fff; float:left;\\\"><a class=\\\"navbar-brand\\\" href=\\\"###SITE_URL###\\\" title=\\\"###SITE_NM###\\\"><img alt=\\\"###SITE_NM###\\\" src=\\\"###SITE_LOGO_URL###\\\" style=\\\"width: 100px;\\\" /> </a></div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<div>&nbsp;</div>\r\n\r\n			<div style=\\\"font-size:15px; color:#595959;float:left; width:98%; line-height:20px; padding-left: 10px;\\\">\r\n			<div>Hello ###greetings###,</div>\r\n\r\n			<p>Provider&nbsp;<span style=\\\"color: rgb(89, 89, 89); font-size: 15px;\\\">###providerName###&nbsp;</span>has created service request on behalf of you. ###serviceLink### to view service details.</p>\r\n\r\n			<div>&nbsp;</div>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" style=\\\"background-color:#222222; padding:10px; width:100%\\\">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<div style=\\\"font-size:15px; color:#fff; float:left; padding:8px 15px;\\\">Copyright &copy; ###YEAR### ###SITE_NM###, All Rights Reserved.</div>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'y', '2021-06-21 11:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_googleadsense_code`
--

CREATE TABLE `tbl_googleadsense_code` (
  `id` int(11) NOT NULL,
  `adsense_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_googleadsense_code`
--

INSERT INTO `tbl_googleadsense_code` (`id`, `adsense_code`) VALUES
(1, '<script type=\"text/javascript\"></script>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `id` int(11) NOT NULL,
  `languageName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `langflag` varchar(255) DEFAULT NULL,
  `default_lan` enum('y','n') NOT NULL DEFAULT 'n',
  `status` enum('a','d','t') NOT NULL DEFAULT 'a' COMMENT 'a=Active, d=Deactive',
  `url_constant` varchar(255) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `languageName`, `langflag`, `default_lan`, `status`, `url_constant`, `created_date`, `updated_date`) VALUES
(1, 'English', NULL, 'y', 'a', 'English', '2020-10-01 03:22:24', '2020-10-02 09:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `senderId` bigint(20) UNSIGNED DEFAULT NULL,
  `receiverId` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `msgType` enum('f','t') NOT NULL DEFAULT 't',
  `readStatus` enum('y','n') NOT NULL DEFAULT 'n',
  `readDate` datetime DEFAULT NULL,
  `senderDelete` enum('y','n') NOT NULL DEFAULT 'n',
  `receiverDelete` enum('y','n') NOT NULL DEFAULT 'n',
  `isActive` enum('y','n') NOT NULL DEFAULT 'y',
  `createdDate` datetime DEFAULT NULL,
  `ipAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id`, `senderId`, `receiverId`, `message`, `msgType`, `readStatus`, `readDate`, `senderDelete`, `receiverDelete`, `isActive`, `createdDate`, `ipAddress`) VALUES
(1, 1, 16, 'message 1', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-09 00:00:00', ''),
(2, 16, 1, 'message 2', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-09 00:00:00', ''),
(3, 1, 16, '1683371984266969243.jpg', 'f', 'y', NULL, 'y', 'n', 'y', '2021-04-13 11:49:08', '49.34.28.28'),
(4, 1, 16, '15155277171657164220.jpg', 'f', 'y', NULL, 'y', 'n', 'y', '2021-04-13 11:49:34', '49.34.28.28'),
(5, 1, 16, 'message 3', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-13 13:21:54', '49.34.28.28'),
(6, 1, 16, 'test message 4', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-13 14:40:00', '49.34.30.86'),
(7, 1, 16, 'test message 4', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-13 14:41:59', '49.34.30.86'),
(8, 1, 16, 'test message 4', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-13 14:43:20', '49.34.30.86'),
(9, 1, 16, '1242943191954932820.jpg', 'f', 'y', NULL, 'y', 'n', 'y', '2021-04-13 14:44:50', '49.34.30.86'),
(10, 1, 16, 'This is  for testing', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-14 13:49:52', '49.34.120.229'),
(11, 16, 1, 'dummy\nmessage\ntrying', 't', 'y', NULL, 'n', 'y', 'y', '2021-04-14 18:24:54', '49.34.104.183'),
(12, 16, 1, 'hello friends welcome come to my new app autoservice global', 't', 'y', NULL, 'n', 'y', 'y', '2021-04-14 18:45:50', '49.34.104.183'),
(13, 16, 1, 'good work', 't', 'y', NULL, 'n', 'y', 'y', '2021-04-14 18:51:37', '49.34.104.183'),
(14, 16, 10, 'hi, I need your service', 't', 'y', NULL, 'n', 'n', 'y', '2021-04-16 14:09:27', '49.34.180.103'),
(15, 10, 16, 'sure I will', 't', 'y', NULL, 'n', 'n', 'y', '2021-04-16 14:16:00', '49.34.180.103'),
(16, 10, 16, 'send request to me with date and time, I will start your work as soon as possible', 't', 'y', NULL, 'n', 'n', 'y', '2021-04-16 14:20:09', '49.34.180.103'),
(17, 1, 16, 'hello', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-17 19:46:43', '49.34.86.49'),
(18, 1, 16, 'hey', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-19 13:25:21', '49.34.60.131'),
(19, 1, 16, '20178412711755172934.jpg', 'f', 'y', NULL, 'y', 'n', 'y', '2021-04-19 13:25:51', '49.34.60.131'),
(20, 4, 1, 'Hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-19 17:09:21', '49.34.42.38'),
(21, 1, 4, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 09:45:54', '49.34.58.52'),
(22, 1, 4, 'hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 11:12:06', '49.34.58.52'),
(23, 1, 4, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 11:12:30', '49.34.58.52'),
(24, 1, 4, 'hey', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 11:19:38', '49.34.58.52'),
(25, 1, 4, 'heyy', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 11:36:05', '49.34.58.52'),
(26, 1, 4, 'hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:28:29', '49.34.58.52'),
(27, 1, 4, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:29:05', '49.34.58.52'),
(28, 1, 4, 'hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:33:03', '49.34.58.52'),
(29, 1, 4, 'test message', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:34:28', '49.34.58.52'),
(30, 4, 1, 'test message 1', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:34:38', '49.34.58.52'),
(31, 4, 1, 'test message 2', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:35:07', '49.34.58.52'),
(32, 1, 4, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:35:26', '49.34.58.52'),
(33, 1, 4, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:35:53', '49.34.58.52'),
(34, 1, 4, 'hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-20 12:36:27', '49.34.58.52'),
(35, 1, 16, 'hiijjjj', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:01:43', '49.34.231.4'),
(36, 1, 16, 'hello', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:25:11', '49.34.245.188'),
(37, 1, 16, 'hi', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:25:23', '49.34.245.188'),
(38, 1, 16, 'aa', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:26:30', '49.34.245.188'),
(39, 1, 16, 'h', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:26:32', '49.34.231.4'),
(40, 1, 16, 'hhh', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:28:25', '49.34.231.4'),
(41, 1, 16, 'hey', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:28:35', '49.34.245.188'),
(42, 1, 16, 'asd', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-26 11:32:37', '49.34.245.188'),
(43, 1, 4, 'Hello grishma', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-26 14:36:25', '49.34.234.65'),
(44, 4, 1, 'Hii pinal', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-26 14:36:42', '49.34.234.65'),
(45, 1, 16, 'hii right', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-29 19:43:34', '157.32.71.176'),
(46, 1, 16, 'hii done', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-29 21:10:36', '157.32.71.176'),
(47, 1, 16, 'dfgf', 't', 'y', NULL, 'y', 'n', 'y', '2021-04-29 21:42:45', '157.32.71.176'),
(48, 1, 16, '21027096791418900538.png', 'f', 'y', NULL, 'y', 'n', 'y', '2021-04-29 21:45:22', '157.32.71.176'),
(49, 4, 1, 'Hey', 't', 'y', NULL, 'y', 'y', 'y', '2021-04-30 11:50:26', '49.34.229.252'),
(50, 4, 1, '3846722501061798.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-04-30 11:50:43', '49.34.229.252'),
(51, 10, 16, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-13 18:21:26', '49.34.85.24'),
(52, 16, 10, 'hello provider', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-14 15:26:58', '49.34.77.1'),
(53, 16, 10, 'testing of message', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-15 13:54:50', '49.34.81.2'),
(54, 16, 10, 'dummy', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-15 14:32:24', '49.34.81.2'),
(55, 16, 10, '727545005739556388.jpg', 'f', 'y', NULL, 'n', 'n', 'y', '2021-05-15 16:07:11', '49.34.81.2'),
(56, 16, 10, '11159925281530929010.jpg', 'f', 'y', NULL, 'n', 'n', 'y', '2021-05-15 16:12:12', '49.34.81.2'),
(57, 4, 1, 'hello friends', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 12:31:29', '49.34.71.230'),
(58, 1, 4, 'how r you?', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 12:33:01', '49.34.71.230'),
(59, 1, 4, 'test 1', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 13:16:39', '49.34.81.35'),
(60, 4, 1, 'receive test', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 13:16:56', '49.34.81.35'),
(61, 4, 1, 'dummy', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 14:01:59', '49.34.81.35'),
(62, 4, 1, 'demo', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 14:07:39', '49.34.81.35'),
(63, 1, 4, 'ok', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 14:08:13', '49.34.81.35'),
(64, 1, 4, 'This is viop msg testing', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 14:08:51', '49.34.81.35'),
(65, 4, 1, 'fine', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 14:10:57', '49.34.81.35'),
(66, 1, 4, 'test msg new', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-17 15:57:55', '49.34.81.35'),
(67, 1, 4, '1072937104620978966.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-17 16:01:45', '49.34.81.35'),
(68, 1, 16, 'test message 1', 't', 'y', NULL, 'y', 'n', 'y', '2021-05-17 18:02:56', '49.34.11.42'),
(69, 1, 16, 'test message 1', 't', 'y', NULL, 'y', 'n', 'y', '2021-05-17 18:18:39', '49.34.11.42'),
(70, 1, 16, 'test message 1', 't', 'y', NULL, 'y', 'n', 'y', '2021-05-17 18:20:38', '49.34.11.42'),
(71, 16, 10, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-17 18:26:02', '49.34.81.19'),
(72, 16, 10, 'dummy text small player message forward to hearing from you soon as possible and overdraft fees you', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-17 18:50:39', '49.34.81.19'),
(73, 16, 10, '646110135540473207.jpg', 'f', 'y', NULL, 'n', 'n', 'y', '2021-05-17 18:54:13', '49.34.81.19'),
(74, 4, 1, 'Hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:15:31', '157.32.29.173'),
(75, 1, 4, '13082279961119016648.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:15:50', '157.32.29.173'),
(76, 4, 1, '268264362173971012.jpeg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:16:31', '157.32.29.173'),
(77, 1, 4, '1756962255308278062.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:16:54', '157.32.29.173'),
(78, 1, 4, '13590220711886840241.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:20:21', '157.32.29.173'),
(79, 4, 1, '16423719201208580211.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:20:46', '157.32.29.173'),
(80, 1, 4, '12737936191944792455.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:21:12', '157.32.29.173'),
(81, 1, 4, 'message bundle testing', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:26:15', '49.34.218.49'),
(82, 1, 4, '1024827499673118769.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:28:03', '49.34.218.49'),
(83, 4, 1, '6345091051837145388.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:28:28', '157.32.29.173'),
(84, 1, 4, 'Hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:43:16', '157.32.29.173'),
(85, 4, 1, 'Hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:44:11', '157.32.29.173'),
(86, 1, 4, 'Hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:45:50', '157.32.29.173'),
(87, 4, 1, 'Hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:46:07', '157.32.29.173'),
(88, 1, 4, '16674442952022347445.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:46:27', '157.32.29.173'),
(89, 1, 4, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:53:36', '157.32.29.173'),
(90, 4, 1, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:53:55', '157.32.29.173'),
(91, 1, 4, '19551839681759126306.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:54:09', '157.32.29.173'),
(92, 4, 1, '1080055383393998167.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:54:47', '157.32.29.173'),
(93, 1, 4, 'msg testing', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 15:59:19', '49.34.179.216'),
(94, 1, 4, '11024480371289933983.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:00:20', '49.34.179.216'),
(95, 1, 4, '14551514981022988092.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:11:50', '49.34.179.216'),
(96, 1, 4, 'not working', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:12:36', '49.34.179.216'),
(97, 1, 4, 'again I test', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:13:39', '49.34.179.216'),
(98, 1, 4, 'dummy messssss', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:46:55', '49.34.176.249'),
(99, 1, 4, '1571472267231649752.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:48:09', '49.34.176.249'),
(100, 4, 1, 'ok', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:48:54', '49.34.176.249'),
(101, 1, 4, 'have you got msg', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:49:26', '49.34.176.249'),
(102, 1, 4, 'let check again', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:56:01', '49.34.176.249'),
(103, 1, 4, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:57:05', '49.34.176.249'),
(104, 1, 4, '17803602251049459812.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 16:57:26', '49.34.176.249'),
(105, 1, 4, '20296285701088591004.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:21:31', '49.34.176.249'),
(106, 1, 4, 'Hey', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:25:15', '157.32.29.173'),
(107, 4, 1, 'Heyy', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:25:51', '157.32.29.173'),
(108, 1, 4, 'hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:27:27', '157.32.29.173'),
(109, 4, 1, 'hii', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:27:38', '157.32.29.173'),
(110, 1, 4, '10004466941697564636.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:27:58', '157.32.29.173'),
(111, 4, 1, '166628652146482224.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-18 17:28:10', '157.32.29.173'),
(112, 4, 1, 'new day testing', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-19 10:29:48', '49.34.176.83'),
(113, 1, 4, 'I got the message', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-19 10:30:28', '49.34.176.83'),
(114, 1, 4, '20301128851545924026.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-19 10:31:56', '49.34.176.83'),
(115, 4, 1, '454847080287711893.jpg', 'f', 'y', NULL, 'y', 'y', 'y', '2021-05-19 10:32:57', '49.34.176.83'),
(116, 1, 4, 'testing done', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-19 10:34:57', '49.34.176.83'),
(117, 16, 1, 'message from today', 't', 'y', NULL, 'n', 'y', 'y', '2021-05-20 14:50:13', '49.34.177.9'),
(118, 16, 25, 'hi', 't', 'n', NULL, 'n', 'n', 'y', '2021-05-20 16:20:00', '49.34.177.9'),
(119, 16, 10, 'Looking for provider', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-25 14:50:49', '49.34.230.1'),
(120, 16, 10, 'how r u today?', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 11:24:52', '49.34.254.178'),
(121, 16, 10, 'go', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 11:32:34', '49.34.254.178'),
(122, 10, 16, 'testing msg', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 11:33:06', '49.34.254.178'),
(123, 16, 10, 'Hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 12:42:53', '49.34.160.250'),
(124, 10, 16, 'Hii', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 12:44:47', '49.34.160.250'),
(125, 10, 16, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 12:46:19', '49.34.160.250'),
(126, 16, 10, 'hii', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 12:47:10', '49.34.160.250'),
(127, 16, 10, 'hey', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 13:13:06', '49.34.160.250'),
(128, 4, 1, 'new day testing message', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-26 13:14:15', '49.34.253.158'),
(129, 16, 10, 'hy', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 13:18:34', '49.34.160.250'),
(130, 10, 16, 'hello', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 13:19:02', '49.34.160.250'),
(131, 1, 4, 'Hey', 't', 'y', NULL, 'y', 'y', 'y', '2021-05-26 13:20:09', '49.34.160.250'),
(132, 10, 16, 'test 1', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 14:07:08', '49.34.253.158'),
(133, 16, 10, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-26 14:07:36', '49.34.253.158'),
(134, 16, 10, 'today is Thursday', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 10:38:34', '49.34.240.153'),
(135, 16, 10, 'new day testing', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 10:43:14', '49.34.240.153'),
(136, 16, 10, 'hi friends', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 10:49:59', '49.34.240.153'),
(137, 10, 16, 'good', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 10:50:42', '49.34.240.153'),
(138, 10, 16, 'we are testing', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 11:28:25', '49.34.240.153'),
(139, 10, 16, 'can you please confirm?', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 11:28:58', '49.34.240.153'),
(140, 16, 10, 'sure', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 11:29:09', '49.34.240.153'),
(141, 10, 16, '561832682582820130.jpg', 'f', 'y', NULL, 'n', 'n', 'y', '2021-05-27 11:29:48', '49.34.240.153'),
(142, 34, 32, 'df', 't', 'y', NULL, 'n', 'n', 'y', '2021-05-27 20:45:30', '223.184.136.74'),
(143, 16, 1, 'hi', 't', 'y', NULL, 'n', 'y', 'y', '2021-05-31 12:41:03', '157.32.75.116'),
(144, 17, 41, 'kjdkjhskjd', 't', 'y', NULL, 'y', 'n', 'y', '2021-05-31 21:13:06', '90.194.151.215'),
(145, 17, 41, 'kjdkjhskjd', 't', 'y', NULL, 'y', 'n', 'y', '2021-05-31 21:13:06', '90.194.151.215'),
(146, 41, 17, 'hdg', 't', 'y', NULL, 'n', 'y', 'y', '2021-05-31 21:13:32', '90.194.151.215'),
(147, 34, 44, 'test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer. test msg is here. I am Cusomer.', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:08:58', '106.213.192.156'),
(148, 34, 44, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:13:01', '106.213.192.156'),
(149, 44, 34, 'no', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:13:33', '106.213.192.156'),
(150, 34, 44, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:15:58', '106.213.192.156'),
(151, 44, 34, 'ok', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:16:23', '106.213.192.156'),
(152, 34, 44, 'good', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:16:39', '106.213.192.156'),
(153, 34, 44, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-03 19:25:01', '106.213.192.156'),
(154, 44, 34, 'hi', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-03 19:25:57', '106.213.192.156'),
(155, 44, 34, '667990486566152599.jpg', 'f', 'y', NULL, 'n', 'y', 'y', '2021-06-03 19:27:20', '106.213.192.156'),
(156, 44, 34, '19575137151185692456.xlsx', 'f', 'y', NULL, 'n', 'y', 'y', '2021-06-03 19:27:32', '106.213.192.156'),
(157, 44, 34, '1498176872431610168.exe', 'f', 'y', NULL, 'n', 'y', 'y', '2021-06-03 19:28:04', '106.213.192.156'),
(158, 17, 41, 'Hello', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-05 00:53:22', '82.132.241.167'),
(159, 41, 17, 'hi how are you', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-05 00:53:58', '82.132.241.167'),
(160, 17, 41, 'Cagdf', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-05 00:54:35', '82.132.241.167'),
(161, 41, 17, 'hjbv', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-05 00:55:29', '82.132.241.167'),
(162, 17, 41, 'G du g', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-05 00:56:09', '82.132.241.167'),
(163, 41, 17, '17542586711053540466.jpg', 'f', 'y', NULL, 'n', 'y', 'y', '2021-06-05 00:57:00', '82.132.241.167'),
(164, 41, 17, 'ggg', 't', 'n', NULL, 'n', 'y', 'y', '2021-06-05 00:57:33', '82.132.241.167'),
(165, 41, 17, 'gff', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-05 00:58:09', '82.132.241.167'),
(166, 34, 48, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-05 14:45:02', '27.61.128.255'),
(167, 34, 48, 'hwy?', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-05 14:47:58', '27.61.128.255'),
(168, 34, 48, 'good', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-05 14:48:39', '27.61.128.255'),
(169, 34, 48, 'bad', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-05 14:48:47', '27.61.128.255'),
(170, 34, 48, 'cool', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-05 14:48:53', '27.61.128.255'),
(171, 34, 48, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-05 15:11:42', '27.61.128.255'),
(172, 48, 34, '6532098961022297914.jpg', 'f', 'y', NULL, 'n', 'y', 'y', '2021-06-05 15:22:35', '27.61.128.255'),
(173, 48, 34, 'hi', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-05 15:36:46', '27.61.128.255'),
(174, 48, 34, 'ok', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-05 15:37:03', '27.61.128.255'),
(175, 34, 48, 'no', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-05 15:37:23', '27.61.128.255'),
(176, 34, 48, 'jo', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-05 15:37:37', '27.61.128.255'),
(177, 34, 48, 'fine', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-05 15:37:49', '27.61.128.255'),
(178, 48, 34, '1683977061782600747.mp3', 'f', 'y', NULL, 'n', 'y', 'y', '2021-06-05 16:08:15', '27.61.128.255'),
(179, 34, 48, '2144683993934456807.wmv', 'f', 'y', NULL, 'y', 'n', 'y', '2021-06-05 16:13:16', '27.61.128.255'),
(180, 34, 48, 'gtur', 't', 'n', NULL, 'y', 'n', 'y', '2021-06-05 18:48:40', '27.61.128.255'),
(181, 17, 41, 'jgcv', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-05 22:42:24', '90.194.155.162'),
(182, 41, 17, 'Hhg', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-05 22:43:22', '90.194.155.162'),
(183, 17, 37, 'hey you said that you are coming today', 't', 'n', NULL, 'n', 'n', 'y', '2021-06-05 22:46:20', '90.194.155.162'),
(184, 41, 17, 'dhdg', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-06 18:53:50', '90.209.212.141'),
(185, 34, 49, 'test', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-07 18:11:53', '106.213.247.90'),
(186, 34, 49, '2', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-07 18:12:28', '106.213.247.90'),
(187, 17, 50, 'hello can I have a taxi please', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-08 00:49:03', '94.3.217.251'),
(188, 50, 17, 'are you there', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-08 01:05:33', '94.3.217.251'),
(189, 17, 50, 'Yes', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-08 01:06:19', '94.3.217.251'),
(190, 17, 50, 'Ihgf', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-08 01:08:38', '94.3.217.251'),
(191, 34, 49, 'hi', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-08 12:16:35', '106.213.235.175'),
(192, 34, 49, 'msg test', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-08 12:16:59', '106.213.235.175'),
(193, 34, 49, 'ok', 't', 'y', NULL, 'n', 'y', 'y', '2021-06-08 12:17:40', '106.213.235.175'),
(194, 49, 34, '1361232514163412506.jpg', 'f', 'y', NULL, 'y', 'n', 'y', '2021-06-08 14:14:38', '106.213.235.175'),
(195, 49, 34, 'edd to the king of the day of the day of the day of the day of the day of times but no one is a lot of data comming from gfffffhhbcdxfxfxgx\ndxgcitcchvjvjvj', 't', 'y', NULL, 'y', 'n', 'y', '2021-06-08 14:17:05', '106.213.235.175'),
(196, 34, 49, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-08 14:33:36', '106.213.235.175'),
(197, 34, 49, '1961239713880430479.jpg', 'f', 'y', NULL, 'n', 'n', 'y', '2021-06-08 14:33:49', '106.213.235.175'),
(198, 34, 49, 'tdt', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-08 14:40:18', '106.213.235.175'),
(199, 34, 25, 'tesr', 't', 'n', NULL, 'n', 'n', 'y', '2021-06-08 14:40:38', '106.213.235.175'),
(200, 34, 49, 'hi taxi service user...', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 11:31:06', '27.61.219.71'),
(201, 49, 34, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 11:41:36', '27.61.219.71'),
(202, 34, 49, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 11:44:20', '27.61.219.71'),
(203, 34, 49, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 15:35:41', '27.61.219.71'),
(204, 34, 49, 'hfff\nhchc', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 15:37:29', '27.61.219.71'),
(205, 34, 49, '45574290995313988.jpg', 'f', 'y', NULL, 'n', 'n', 'y', '2021-06-10 15:37:48', '27.61.219.71'),
(206, 34, 49, 'bub', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 15:39:04', '27.61.219.71'),
(207, 34, 49, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 17:11:05', '27.61.219.71'),
(208, 49, 34, 'byy', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 17:11:46', '106.222.90.1'),
(209, 34, 49, 'vg', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-10 17:12:07', '27.61.219.71'),
(210, 10, 16, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-11 14:22:53', '49.34.140.182'),
(211, 10, 16, 'this is new message', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-11 14:25:56', '49.34.140.182'),
(212, 10, 16, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-11 14:26:23', '49.34.140.182'),
(213, 16, 10, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-11 14:40:36', '49.34.140.182'),
(214, 10, 16, 'cool pic', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:37:39', '49.34.168.246'),
(215, 16, 10, 'Thank you...!', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:38:20', '49.34.168.246'),
(216, 16, 10, 'get mess', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:40:24', '49.34.168.246'),
(217, 16, 10, 'new', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:41:36', '49.34.168.246'),
(218, 16, 10, 'test hjhbjbjbjbj', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:42:44', '49.34.168.246'),
(219, 10, 16, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:43:03', '49.34.168.246'),
(220, 16, 10, 'make it more', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-14 18:43:23', '49.34.168.246'),
(221, 51, 52, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-16 16:45:21', '223.184.236.216'),
(222, 52, 51, 'hello', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-16 16:45:51', '106.205.247.94'),
(223, 51, 52, 'good', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-16 16:48:26', '223.184.236.216'),
(224, 52, 51, 'ok', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-16 16:48:45', '106.205.247.94'),
(225, 51, 52, 'hjh', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-16 19:18:55', '106.205.247.94'),
(226, 52, 51, 'ok', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-16 19:19:13', '106.205.247.94'),
(227, 16, 10, 'this is test message for new day', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-17 14:23:58', '49.34.161.209'),
(228, 16, 10, 'are you getting', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-17 15:04:54', '49.34.161.209'),
(229, 16, 10, 'my photo', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-17 15:05:07', '49.34.161.209'),
(230, 16, 10, 'good evening', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-18 18:00:44', '49.34.190.110'),
(231, 51, 52, 'yt', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-18 18:56:29', '223.184.204.160'),
(232, 10, 16, 'have a fun day', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:42:06', '49.34.173.95'),
(233, 16, 10, 'ya', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:42:28', '49.34.173.95'),
(234, 10, 16, 'smile', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:42:44', '49.34.173.95'),
(235, 16, 10, 'yes', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:48:30', '49.34.173.95'),
(236, 10, 16, 'testing', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:48:50', '49.34.173.95'),
(237, 10, 16, 'done', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:48:56', '49.34.173.95'),
(238, 10, 16, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 10:49:02', '49.34.173.95'),
(239, 10, 16, 'test1', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:02:26', '49.34.173.95'),
(240, 10, 16, 'test2', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:02:36', '49.34.173.95'),
(241, 10, 16, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:02:53', '49.34.173.95'),
(242, 16, 10, 'good morning', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:47:07', '49.34.173.95'),
(243, 10, 16, 'very gm', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:47:22', '49.34.173.95'),
(244, 16, 10, 'how r you today?', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:47:39', '49.34.173.95'),
(245, 10, 16, 'i am good and what about you?', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:47:56', '49.34.173.95'),
(246, 16, 10, 'I also fine', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:48:11', '49.34.173.95'),
(247, 10, 16, 'ok', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 11:48:21', '49.34.173.95'),
(248, 17, 41, 'Heloo', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-19 23:41:27', '151.230.60.225'),
(249, 52, 51, 'hey', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-21 10:26:51', '223.184.212.35'),
(250, 52, 51, 'cool', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-21 11:22:06', '223.184.212.35'),
(251, 51, 52, 'ghg', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-21 11:28:26', '223.184.212.35'),
(252, 51, 52, 'hi', 't', 'y', NULL, 'y', 'y', 'y', '2021-06-21 11:30:04', '223.184.212.35'),
(253, 51, 52, 'vhjg', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-21 19:41:57', '223.184.215.11'),
(254, 50, 17, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-22 01:24:38', '176.248.97.222'),
(255, 17, 50, 'kjhiuh', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-22 01:26:11', '176.248.97.222'),
(256, 4, 24, 'hi', 't', 'n', NULL, 'n', 'n', 'y', '2021-06-23 13:19:46', '49.36.93.223'),
(257, 4, 24, 'are you there?', 't', 'n', NULL, 'n', 'n', 'y', '2021-06-23 13:20:34', '49.36.93.223'),
(258, 1, 4, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-23 13:21:02', '49.36.93.223'),
(259, 1, 4, 'majama?', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-23 13:21:47', '49.36.93.223'),
(260, 4, 1, 'yes', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-23 13:22:00', '49.36.93.223'),
(261, 52, 51, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 09:55:14', '27.61.179.0'),
(262, 52, 51, 'good?', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 09:55:20', '27.61.179.0'),
(263, 52, 51, 'bnjmh', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 10:04:06', '27.61.179.0'),
(264, 52, 51, 'ok?', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 10:07:12', '27.61.179.0'),
(265, 52, 51, 'good', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 10:08:04', '27.61.179.0'),
(266, 10, 16, 'updated message', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:49:14', '49.34.158.169'),
(267, 10, 16, 'again', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:52:32', '49.34.158.169'),
(268, 10, 16, 'msg1', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:53:32', '49.34.158.169'),
(269, 10, 16, 'msg2', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:54:47', '49.34.158.169'),
(270, 16, 10, 'the', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:55:43', '49.34.158.169'),
(271, 16, 10, 'msg 3', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:57:31', '49.34.158.169'),
(272, 16, 10, 'msg 4', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 13:59:59', '49.34.158.169'),
(273, 10, 16, 'msg 5', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:00:41', '49.34.158.169'),
(274, 10, 16, 'msg 6', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:14:07', '49.34.158.169'),
(275, 10, 16, 'msg7', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:15:04', '49.34.158.169'),
(276, 10, 16, 'msg 8', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:16:50', '49.34.158.169'),
(277, 10, 16, 'msg 9', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:17:32', '49.34.158.169'),
(278, 10, 16, 'msg 10', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:18:41', '49.34.158.169'),
(279, 10, 16, 'msg 11', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:20:17', '49.34.158.169'),
(280, 10, 16, 'msg 12', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:20:52', '49.34.158.169'),
(281, 10, 16, 'msg 13', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:30:32', '49.34.158.169'),
(282, 10, 16, 'msg 14', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 14:31:17', '49.34.158.169'),
(283, 16, 10, 'msg 15', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:04:19', '49.34.158.169'),
(284, 10, 16, 'msg 16', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:05:05', '49.34.158.169'),
(285, 16, 10, 'msg 17', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:06:55', '49.34.158.169'),
(286, 16, 10, 'test 18', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:09:24', '49.34.158.169'),
(287, 16, 10, 'msg 19', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:20:14', '49.34.158.169'),
(288, 10, 16, 'msg 20', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:20:46', '49.34.158.169'),
(289, 16, 10, 'msg 21', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:22:14', '49.34.158.169'),
(290, 16, 10, 'msg 22', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:22:45', '49.34.158.169'),
(291, 10, 16, 'msg 23', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:23:06', '49.34.158.169'),
(292, 10, 16, 'msg 24', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:25:01', '49.34.158.169'),
(293, 16, 10, 'msg 25', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:26:01', '49.34.158.169'),
(294, 16, 10, 'msg 26', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:58:44', '49.34.158.169'),
(295, 16, 10, 'msg 27', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 15:59:15', '49.34.158.169'),
(296, 10, 16, 'msg 28', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-24 16:11:32', '49.34.158.169'),
(297, 16, 10, 'msg 29', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-25 18:54:38', '49.34.139.149'),
(298, 16, 10, 'msg 30', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-25 18:54:56', '49.34.139.149'),
(299, 16, 10, 'msg 31', 't', 'y', NULL, 'n', 'n', 'y', '2021-06-25 18:55:10', '49.34.139.149'),
(300, 51, 52, 'hi', 't', 'y', NULL, 'n', 'n', 'y', '2021-07-05 10:22:46', '106.213.150.230');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_history`
--

CREATE TABLE `tbl_payment_history` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `request_id` bigint(20) NOT NULL,
  `txn_type` enum('service_payment') NOT NULL,
  `transactionId` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_method` enum('online','offline') NOT NULL,
  `jsonDetails` text NOT NULL,
  `ipAddress` varchar(255) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payment_history`
--

INSERT INTO `tbl_payment_history` (`id`, `userId`, `request_id`, `txn_type`, `transactionId`, `amount`, `payment_method`, `jsonDetails`, `ipAddress`, `createdDate`) VALUES
(2, 16, 7, 'service_payment', '06R914783E3049201', '20', 'online', '{\"mc_gross\":\"20.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"HXTB2B748N3NW\",\"address_street\":\"1 Main St\",\"payment_date\":\"05:27:10 May 14, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Test\",\"mc_fee\":\"0.88\",\"address_country_code\":\"US\",\"address_name\":\"Test NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"16\",\"payer_status\":\"verified\",\"business\":\"test1@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AMIsJErLWFh1ByQ-Pn.oseCWp0SBALWbGJ8gQ71C188vknDaTXrdQMRC\",\"payer_email\":\"test@ncrypted.com\",\"txn_id\":\"06R914783E3049201\",\"payment_type\":\"instant\",\"payer_business_name\":\"Test NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test1@ncrypted.com\",\"payment_fee\":\"0.88\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"VR3XFZ3KD8SSS\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"7\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"20.00\",\"ipn_track_id\":\"1b170a50f78e8\"}', '173.0.80.117', '2021-05-14 12:33:00'),
(3, 4, 4, 'service_payment', '4M363436913192919', '500', 'online', '{\"mc_gross\":\"500.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"HXTB2B748N3NW\",\"address_street\":\"1 Main St\",\"payment_date\":\"22:28:55 May 14, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Test\",\"mc_fee\":\"14.80\",\"address_country_code\":\"US\",\"address_name\":\"Test NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"0\",\"payer_status\":\"verified\",\"business\":\"test2@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"Axi2JPs5nrysX.tzs9YStdwqc8q6A3T91vNzfromHqc23hmcjw4I8hju\",\"payer_email\":\"test@ncrypted.com\",\"txn_id\":\"4M363436913192919\",\"payment_type\":\"instant\",\"payer_business_name\":\"Test NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test2@ncrypted.com\",\"payment_fee\":\"14.80\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"8JBFD9MP68B7E\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"4\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"500.00\",\"ipn_track_id\":\"cf8499caeb17f\"}', '173.0.82.126', '2021-05-15 05:29:15'),
(4, 16, 8, 'service_payment', '99J06119LP8939926', '250', 'online', '{\"mc_gross\":\"250.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"HXTB2B748N3NW\",\"address_street\":\"1 Main St\",\"payment_date\":\"22:45:10 May 14, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Test\",\"mc_fee\":\"7.55\",\"address_country_code\":\"US\",\"address_name\":\"Test NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"16\",\"payer_status\":\"verified\",\"business\":\"test2@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A7lUjPOXSXNbeH8zCbLyn0zSRm0NADH9fxIP0OfJNNK1gvYf8-miNZr2\",\"payer_email\":\"test@ncrypted.com\",\"txn_id\":\"99J06119LP8939926\",\"payment_type\":\"instant\",\"payer_business_name\":\"Test NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test2@ncrypted.com\",\"payment_fee\":\"7.55\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"8JBFD9MP68B7E\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"8\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"250.00\",\"ipn_track_id\":\"cb74142e1a4f3\"}', '173.0.80.117', '2021-05-15 05:45:30'),
(14, 34, 35, 'service_payment', '60b252b1c80cd', '10', 'offline', '', '106.213.208.53', '2021-05-29 14:41:53'),
(15, 34, 33, 'service_payment', '9HT94498FT432512W', '50', 'online', '{\"mc_gross\":\"50.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"07:48:49 May 29, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"1.75\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A8vyPPy7mObxAPq5psJu6mY0fl34AOkLJ7V9N8iREbUGUIw2o7zhpSdo\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"9HT94498FT432512W\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"1.75\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"33\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"50.00\",\"ipn_track_id\":\"a4322a1f7aa6b\"}', '173.0.80.117', '2021-05-29 14:48:55'),
(16, 4, 18, 'service_payment', '9W859059TA093370R', '100', 'online', '{\"mc_gross\":\"100.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"HXTB2B748N3NW\",\"address_street\":\"1 Main St\",\"payment_date\":\"00:56:50 May 31, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Test\",\"mc_fee\":\"3.20\",\"address_country_code\":\"US\",\"address_name\":\"Test NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"4\",\"payer_status\":\"verified\",\"business\":\"test2@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AcZ5wmJ8prvam7H8XOW.2Q58BNY5A9mpZVdyLma7cTDGAFSeTjmoiPci\",\"payer_email\":\"test@ncrypted.com\",\"txn_id\":\"9W859059TA093370R\",\"payment_type\":\"instant\",\"payer_business_name\":\"Test NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test2@ncrypted.com\",\"payment_fee\":\"3.20\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"8JBFD9MP68B7E\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"18\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"100.00\",\"ipn_track_id\":\"dc93b308b2048\"}', '173.0.82.126', '2021-05-31 07:56:55'),
(17, 34, 31, 'service_payment', '60b4a2c404e7c', '-50', 'offline', '', '106.222.78.189', '2021-05-31 08:48:04'),
(18, 34, 36, 'service_payment', '8LS28846M9440803J', '20', 'online', '{\"mc_gross\":\"20.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"01:52:46 May 31, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.88\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A6BGBXYTw58gyuyhylDSecqzIfmPAeog3tQb-G2fLj8Y0BzOs6QTQuQU\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"8LS28846M9440803J\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.88\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"36\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"20.00\",\"ipn_track_id\":\"3f6fa38ecab13\"}', '173.0.80.116', '2021-05-31 08:52:52'),
(19, 34, 29, 'service_payment', '0LT318655Y745692K', '15', 'online', '{\"mc_gross\":\"15.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"01:57:42 May 31, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.74\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AJDB30V3VTNenXXahDueMMoUJgTeA2-xbKrHvJHk3SDbHLD1y2DVXDPR\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"0LT318655Y745692K\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.74\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"29\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"15.00\",\"ipn_track_id\":\"3d62fb5a364bf\"}', '173.0.80.116', '2021-05-31 08:57:48'),
(28, 34, 45, 'service_payment', '69P43452Y1011714E', '15', 'online', '{\"mc_gross\":\"15.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"05:28:30 Jun 03, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.74\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AD.3Rd-TKaOdG04OSs.2Xox2OoCpAnW670C65Z2xuSVbm57T71DmRxze\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"69P43452Y1011714E\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.74\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"Auto Service Global\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"45\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"15.00\",\"ipn_track_id\":\"6aa4c5b553f5d\"}', '173.0.80.116', '2021-06-03 12:28:39'),
(29, 17, 60, 'service_payment', '60ba82c337c15', '55', 'offline', '', '90.194.148.155', '2021-06-04 19:45:07'),
(30, 34, 61, 'service_payment', '6MX54801UV675842S', '16', 'online', '{\"mc_gross\":\"16.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"03:30:37 Jun 05, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.76\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A9wqb1wB2yeCO.jbe9.C9sMuvcu4A.MG9OOme0S8jJbwFZUpEPDlpAI3\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"6MX54801UV675842S\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.76\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"61\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"16.00\",\"ipn_track_id\":\"a3cf27754853\"}', '173.0.80.117', '2021-06-05 10:30:57'),
(33, 34, 77, 'service_payment', '9P427404PY714061R', '22', 'online', '{\"mc_gross\":\"22.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"23:51:18 Jun 09, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.94\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A5m67iUjKM-Po4rcsZlHa.adJCg6AXACo8H1w2sSHecUOPq.S9hsyuRH\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"9P427404PY714061R\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.94\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"77\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"22.00\",\"ipn_track_id\":\"58a5ec58f202a\"}', '173.0.80.117', '2021-06-10 06:51:41'),
(34, 34, 85, 'service_payment', '9X789885PB6222509', '5', 'online', '{\"mc_gross\":\"5.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"04:55:24 Jun 10, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.45\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"34\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"Ac2Pzvj5l6nkcvTKl56MxHpjTr2gACtiTGEGdOCe579Zf7BRlOW.tlIh\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"9X789885PB6222509\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.45\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"85\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"5.00\",\"ipn_track_id\":\"43b82c8cdae17\"}', '173.0.80.117', '2021-06-10 11:55:30'),
(35, 51, 87, 'service_payment', '60c321482dafc', '100', 'offline', '', '27.61.228.207', '2021-06-11 08:39:36'),
(36, 51, 95, 'service_payment', '4JM19385YT9769622', '5', 'online', '{\"mc_gross\":\"5.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"04:52:06 Jun 16, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.45\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"51\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AcbY8FVlqFl1Xfzi1DZoyKKs9UhoA-wBhKVgbqMm4PlL.qcPLI1t8YqJ\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"4JM19385YT9769622\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.45\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"95\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"5.00\",\"ipn_track_id\":\"9ecd1859b5f1b\"}', '173.0.80.117', '2021-06-16 11:52:12'),
(38, 51, 94, 'service_payment', '60c9e6e9dcf63', '14', 'offline', '', '223.184.236.216', '2021-06-16 11:56:25'),
(39, 16, 73, 'service_payment', '1RB16793CA2970831', '10', 'online', '{\"mc_gross\":\"10.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"8JBFD9MP68B7E\",\"address_street\":\"1 Main St\",\"payment_date\":\"05:00:33 Jun 17, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testtwo\",\"mc_fee\":\"0.59\",\"address_country_code\":\"US\",\"address_name\":\"NctFirm\",\"notify_version\":\"3.9\",\"custom\":\"16\",\"payer_status\":\"verified\",\"business\":\"test1@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AYKbYbGCvOInUYMA-XnVG0kukgglArW.X7iyS8pxKKv.kHupgTH6mktm\",\"payer_email\":\"test2@ncrypted.com\",\"txn_id\":\"1RB16793CA2970831\",\"payment_type\":\"instant\",\"payer_business_name\":\"NctFirm\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test1@ncrypted.com\",\"payment_fee\":\"0.59\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"VR3XFZ3KD8SSS\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"73\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"10.00\",\"ipn_track_id\":\"656392502092a\"}', '173.0.80.116', '2021-06-17 12:00:38'),
(40, 16, 98, 'service_payment', '0P336191GM275134B', '14', 'online', '{\"mc_gross\":\"14.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"N79HHRNWHMRN6\",\"address_street\":\"1 Main St\",\"payment_date\":\"04:13:09 Jun 19, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfive\",\"mc_fee\":\"0.71\",\"address_country_code\":\"US\",\"address_name\":\"Testfive NCrypted\",\"notify_version\":\"3.9\",\"custom\":\"16\",\"payer_status\":\"verified\",\"business\":\"chirag.malaviya@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AU2lsYKisafM.mgwMRvgMv3I7KxDAQMfZwZz1CXwH2gWRoW.vaees8.u\",\"payer_email\":\"test5@ncrypted.com\",\"txn_id\":\"0P336191GM275134B\",\"payment_type\":\"instant\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"chirag.malaviya@ncrypted.com\",\"payment_fee\":\"0.71\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"SRVZCUDF7AXWJ\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"98\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"14.00\",\"ipn_track_id\":\"8910b490bdfa\"}', '173.0.80.116', '2021-06-19 11:13:17'),
(42, 16, 100, 'service_payment', '19Y69530DH823373S', '22', 'online', '{\"mc_gross\":\"22.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"N79HHRNWHMRN6\",\"address_street\":\"1 Main St\",\"payment_date\":\"04:29:26 Jun 19, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfive\",\"mc_fee\":\"0.94\",\"address_country_code\":\"US\",\"address_name\":\"Testfive NCrypted\",\"notify_version\":\"3.9\",\"custom\":\"16\",\"payer_status\":\"verified\",\"business\":\"chirag.malaviya@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A5-lrSLjSj3Q-Vz-Kg48FHm0FfzHAjD0elO8eGXGmKw9JwQMqWWQDyd6\",\"payer_email\":\"test5@ncrypted.com\",\"txn_id\":\"19Y69530DH823373S\",\"payment_type\":\"instant\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"chirag.malaviya@ncrypted.com\",\"payment_fee\":\"0.94\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"SRVZCUDF7AXWJ\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"100\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"22.00\",\"ipn_track_id\":\"157121a8c01d\"}', '173.0.80.116', '2021-06-19 11:29:32'),
(43, 51, 105, 'service_payment', '79K16998GS136873T', '11', 'online', '{\"mc_gross\":\"11.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"07:21:41 Jun 21, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.62\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"51\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AXw.E0XiU0ZahxHR37zDEdqlAfiGAA8s1vIUPW68LrYdCHrYiVDZbtJJ\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"79K16998GS136873T\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.62\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"105\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"11.00\",\"ipn_track_id\":\"1076c3a5c68ba\"}', '173.0.80.116', '2021-06-21 14:22:02'),
(44, 51, 107, 'service_payment', '8YH068674D698791V', '501', 'online', '{\"mc_gross\":\"501.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"6YAK2B9XDGRVS\",\"address_street\":\"1 Main St\",\"payment_date\":\"21:30:49 Jun 23, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testthree\",\"mc_fee\":\"14.83\",\"address_country_code\":\"US\",\"address_name\":\"Testthree NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"51\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"A5n3Fg0SgQIMFf0B5FtWcj2bD8NTAesbas55-MJ.dsMJWCgHzOqadfSw\",\"payer_email\":\"test3@ncrypted.com\",\"txn_id\":\"8YH068674D698791V\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testthree NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"14.83\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"107\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"501.00\",\"ipn_track_id\":\"e7c5270837920\"}', '173.0.82.126', '2021-06-24 04:31:03'),
(45, 51, 109, 'service_payment', '60d9907db9c7d', '9', 'offline', '', '106.213.208.138', '2021-06-28 09:03:57'),
(46, 16, 21, 'service_payment', '60d997b6e2a54', '18', 'offline', '', '49.34.139.233', '2021-06-28 09:34:46'),
(47, 51, 111, 'service_payment', '77B75410F7363462F', '9', 'online', '{\"mc_gross\":\"9.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"payer_id\":\"GHRAQ523SZBMY\",\"address_street\":\"1 Main St\",\"payment_date\":\"22:09:38 Jul 04, 2021 PDT\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"Testfour\",\"mc_fee\":\"0.56\",\"address_country_code\":\"US\",\"address_name\":\"Testfour NCrypted\'s Test Store\",\"notify_version\":\"3.9\",\"custom\":\"51\",\"payer_status\":\"verified\",\"business\":\"test5@ncrypted.com\",\"address_country\":\"United States\",\"address_city\":\"San Jose\",\"quantity\":\"1\",\"verify_sign\":\"AasdeupAIJZXTBAyQFlFsS8ZbH5fALoipYZ0Q11A0yufXrHMwIVmeyBO\",\"payer_email\":\"test4@ncrypted.com\",\"txn_id\":\"77B75410F7363462F\",\"payment_type\":\"instant\",\"payer_business_name\":\"Testfour NCrypted\'s Test Store\",\"last_name\":\"NCrypted\",\"address_state\":\"CA\",\"receiver_email\":\"test5@ncrypted.com\",\"payment_fee\":\"0.56\",\"shipping_discount\":\"0.00\",\"insurance_amount\":\"0.00\",\"receiver_id\":\"N79HHRNWHMRN6\",\"txn_type\":\"web_accept\",\"item_name\":\"AutoService\",\"discount\":\"0.00\",\"mc_currency\":\"USD\",\"item_number\":\"111\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"shipping_method\":\"Default\",\"handling_amount\":\"0.00\",\"transaction_subject\":\"\",\"payment_gross\":\"9.00\",\"ipn_track_id\":\"d264266a92a30\"}', '173.0.80.116', '2021-07-05 05:09:44'),
(48, 4, 66, 'service_payment', '60e2ad105d083', '100', 'offline', '', '157.32.76.72', '2021-07-05 06:56:16'),
(49, 51, 114, 'service_payment', '60e6d9ec83e1f', '88', 'offline', '', '106.222.78.181', '2021-07-08 10:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_provider_availability`
--

CREATE TABLE `tbl_provider_availability` (
  `id` bigint(20) NOT NULL,
  `provider_id` bigint(20) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `slot` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_provider_availability`
--

INSERT INTO `tbl_provider_availability` (`id`, `provider_id`, `start_date`, `slot`, `createdDate`) VALUES
(2, 5, '2021-04-24', 10, '2021-04-23 09:56:34'),
(7, 5, '2021-05-11', 11, '2021-04-26 10:34:20'),
(8, 5, '2021-05-11', 12, '2021-04-26 10:34:20'),
(9, 5, '2021-05-11', 13, '2021-04-26 10:34:20'),
(10, 5, '2021-05-11', 14, '2021-04-26 10:34:20'),
(11, 5, '2021-05-10', 11, '2021-04-26 10:40:18'),
(12, 5, '2021-05-10', 12, '2021-04-26 10:40:18'),
(13, 5, '2021-05-10', 13, '2021-04-26 10:40:18'),
(14, 5, '2021-05-10', 14, '2021-04-26 10:40:18'),
(15, 5, '2021-05-03', 10, '2021-04-26 10:48:38'),
(16, 5, '2021-05-04', 10, '2021-04-26 10:48:38'),
(17, 5, '2021-05-05', 10, '2021-04-26 10:48:38'),
(60, 1, '2021-05-16', 0, '2021-04-29 06:12:02'),
(64, 10, '2021-05-07', 24, '2021-05-06 10:58:59'),
(66, 1, '2021-05-22', 0, '2021-05-10 05:21:31'),
(68, 10, '2021-05-13', 11, '2021-05-10 09:57:11'),
(71, 10, '2021-05-15', 1, '2021-05-10 10:04:04'),
(73, 10, '2021-05-12', 2, '2021-05-10 10:17:40'),
(74, 10, '2021-05-13', 5, '2021-05-10 10:22:08'),
(76, 32, '2021-05-22', 19, '2021-05-20 11:49:33'),
(78, 32, '2021-05-21', 22, '2021-05-20 11:50:17'),
(79, 32, '2021-05-20', 1, '2021-05-20 12:19:48'),
(80, 32, '2021-05-21', 1, '2021-05-20 12:19:48'),
(81, 32, '2021-05-22', 1, '2021-05-20 12:19:48'),
(82, 32, '2021-05-23', 1, '2021-05-20 12:19:48'),
(83, 32, '2021-05-24', 1, '2021-05-20 12:19:48'),
(84, 32, '2021-05-25', 1, '2021-05-20 12:19:48'),
(85, 32, '2021-05-26', 1, '2021-05-20 12:19:48'),
(86, 32, '2021-05-27', 1, '2021-05-20 12:19:48'),
(87, 32, '2021-05-28', 1, '2021-05-20 12:19:49'),
(88, 32, '2021-05-29', 1, '2021-05-20 12:19:49'),
(91, 32, '2021-05-22', 4, '2021-05-20 12:21:25'),
(92, 32, '2021-05-23', 4, '2021-05-20 12:21:25'),
(93, 32, '2021-05-24', 4, '2021-05-20 12:21:25'),
(94, 32, '2021-05-25', 4, '2021-05-20 12:21:25'),
(95, 32, '2021-05-20', 4, '2021-05-20 12:26:54'),
(96, 32, '2021-05-21', 4, '2021-05-20 12:26:54'),
(97, 32, '2021-05-20', 2, '2021-05-20 12:43:03'),
(98, 19, '2021-05-26', 2, '2021-05-28 15:47:33'),
(99, 32, '2021-05-29', 23, '2021-05-29 11:10:08'),
(101, 32, '2021-05-31', 1, '2021-05-29 11:18:17'),
(103, 32, '2021-05-30', 16, '2021-05-29 11:28:03'),
(104, 32, '2021-05-31', 4, '2021-05-29 11:34:04'),
(105, 32, '2021-05-30', 4, '2021-05-29 11:34:20'),
(106, 32, '2021-05-30', 1, '2021-05-29 11:34:56'),
(107, 32, '2021-05-29', 4, '2021-05-29 13:18:15'),
(108, 32, '2021-05-29', 18, '2021-05-29 13:47:02'),
(109, 32, '2021-05-30', 18, '2021-05-29 13:47:03'),
(110, 32, '2021-06-01', 4, '2021-06-01 12:24:19'),
(111, 44, '2021-06-03', 19, '2021-06-03 11:00:20'),
(113, 44, '2021-06-03', 18, '2021-06-03 11:01:14'),
(114, 44, '2021-06-04', 18, '2021-06-03 11:02:00'),
(115, 46, '2021-06-05', 8, '2021-06-04 12:51:11'),
(116, 46, '2021-06-06', 8, '2021-06-04 12:51:11'),
(117, 46, '2021-06-04', 5, '2021-06-04 12:51:56'),
(118, 46, '2021-06-05', 5, '2021-06-04 12:51:57'),
(121, 10, '2021-06-09', 6, '2021-06-05 11:52:58'),
(122, 1, '2021-06-09', 0, '2021-06-05 13:02:18'),
(133, 49, '2021-06-17', 0, '2021-06-05 13:52:32'),
(140, 41, '2021-06-05', 1, '2021-06-05 21:45:32'),
(141, 41, '2021-06-06', 1, '2021-06-05 21:45:33'),
(142, 41, '2021-06-07', 1, '2021-06-05 21:45:33'),
(143, 41, '2021-06-08', 1, '2021-06-05 21:45:33'),
(144, 41, '2021-06-09', 1, '2021-06-05 21:45:33'),
(145, 41, '2021-06-10', 1, '2021-06-05 21:45:33'),
(146, 41, '2021-06-11', 1, '2021-06-05 21:45:33'),
(147, 41, '2021-06-12', 1, '2021-06-05 21:45:33'),
(148, 41, '2021-06-13', 1, '2021-06-05 21:45:34'),
(149, 41, '2021-06-14', 1, '2021-06-05 21:45:34'),
(150, 41, '2021-06-15', 1, '2021-06-05 21:45:34'),
(151, 41, '2021-06-16', 1, '2021-06-05 21:45:34'),
(152, 41, '2021-06-17', 1, '2021-06-05 21:45:34'),
(153, 41, '2021-06-18', 1, '2021-06-05 21:45:34'),
(154, 41, '2021-06-19', 1, '2021-06-05 21:45:34'),
(155, 41, '2021-06-20', 1, '2021-06-05 21:45:34'),
(156, 41, '2021-06-21', 1, '2021-06-05 21:45:35'),
(157, 41, '2021-06-22', 1, '2021-06-05 21:45:35'),
(158, 41, '2021-06-23', 1, '2021-06-05 21:45:35'),
(159, 41, '2021-06-24', 1, '2021-06-05 21:45:35'),
(160, 41, '2021-06-25', 1, '2021-06-05 21:45:35'),
(161, 41, '2021-06-26', 1, '2021-06-05 21:45:35'),
(162, 41, '2021-06-27', 1, '2021-06-05 21:45:35'),
(163, 41, '2021-06-28', 1, '2021-06-05 21:45:35'),
(164, 41, '2021-06-29', 1, '2021-06-05 21:45:35'),
(165, 41, '2021-06-30', 1, '2021-06-05 21:45:35'),
(166, 41, '2021-07-01', 1, '2021-06-05 21:45:35'),
(167, 41, '2021-07-02', 1, '2021-06-05 21:45:36'),
(168, 41, '2021-07-03', 1, '2021-06-05 21:45:36'),
(169, 41, '2021-07-04', 1, '2021-06-05 21:45:36'),
(170, 41, '2021-07-05', 1, '2021-06-05 21:45:36'),
(171, 41, '2021-07-06', 1, '2021-06-05 21:45:36'),
(172, 41, '2021-07-07', 1, '2021-06-05 21:45:36'),
(173, 41, '2021-07-08', 1, '2021-06-05 21:45:36'),
(174, 41, '2021-07-09', 1, '2021-06-05 21:45:36'),
(175, 41, '2021-07-10', 1, '2021-06-05 21:45:36'),
(176, 41, '2021-07-11', 1, '2021-06-05 21:45:36'),
(177, 41, '2021-07-12', 1, '2021-06-05 21:45:36'),
(178, 41, '2021-07-13', 1, '2021-06-05 21:45:36'),
(179, 41, '2021-07-14', 1, '2021-06-05 21:45:37'),
(180, 41, '2021-07-15', 1, '2021-06-05 21:45:37'),
(181, 41, '2021-07-16', 1, '2021-06-05 21:45:37'),
(182, 41, '2021-07-17', 1, '2021-06-05 21:45:37'),
(183, 41, '2021-07-18', 1, '2021-06-05 21:45:37'),
(184, 41, '2021-07-19', 1, '2021-06-05 21:45:37'),
(185, 41, '2021-07-20', 1, '2021-06-05 21:45:37'),
(186, 41, '2021-07-21', 1, '2021-06-05 21:45:37'),
(187, 41, '2021-07-22', 1, '2021-06-05 21:45:37'),
(188, 41, '2021-07-23', 1, '2021-06-05 21:45:37'),
(189, 41, '2021-07-24', 1, '2021-06-05 21:45:37'),
(190, 41, '2021-07-25', 1, '2021-06-05 21:45:38'),
(191, 41, '2021-07-26', 1, '2021-06-05 21:45:38'),
(192, 41, '2021-07-27', 1, '2021-06-05 21:45:38'),
(193, 41, '2021-07-28', 1, '2021-06-05 21:45:38'),
(194, 41, '2021-07-29', 1, '2021-06-05 21:45:38'),
(195, 41, '2021-07-30', 1, '2021-06-05 21:45:38'),
(196, 41, '2021-07-31', 1, '2021-06-05 21:45:38'),
(197, 41, '2021-08-01', 1, '2021-06-05 21:45:39'),
(198, 41, '2021-08-02', 1, '2021-06-05 21:45:39'),
(199, 41, '2021-08-03', 1, '2021-06-05 21:45:39'),
(200, 41, '2021-08-04', 1, '2021-06-05 21:45:39'),
(201, 41, '2021-08-05', 1, '2021-06-05 21:45:39'),
(202, 41, '2021-08-06', 1, '2021-06-05 21:45:39'),
(203, 41, '2021-08-07', 1, '2021-06-05 21:45:39'),
(204, 41, '2021-08-08', 1, '2021-06-05 21:45:39'),
(205, 41, '2021-08-09', 1, '2021-06-05 21:45:39'),
(206, 41, '2021-08-10', 1, '2021-06-05 21:45:39'),
(207, 41, '2021-08-11', 1, '2021-06-05 21:45:39'),
(208, 41, '2021-08-12', 1, '2021-06-05 21:45:40'),
(209, 41, '2021-08-13', 1, '2021-06-05 21:45:40'),
(210, 41, '2021-08-14', 1, '2021-06-05 21:45:40'),
(211, 41, '2021-08-15', 1, '2021-06-05 21:45:40'),
(212, 41, '2021-08-16', 1, '2021-06-05 21:45:40'),
(213, 41, '2021-08-17', 1, '2021-06-05 21:45:40'),
(214, 41, '2021-08-18', 1, '2021-06-05 21:45:40'),
(215, 41, '2021-08-19', 1, '2021-06-05 21:45:40'),
(216, 41, '2021-08-20', 1, '2021-06-05 21:45:40'),
(217, 41, '2021-08-21', 1, '2021-06-05 21:45:40'),
(218, 41, '2021-08-22', 1, '2021-06-05 21:45:41'),
(219, 41, '2021-08-23', 1, '2021-06-05 21:45:41'),
(220, 41, '2021-08-24', 1, '2021-06-05 21:45:41'),
(221, 41, '2021-08-25', 1, '2021-06-05 21:45:41'),
(222, 41, '2021-08-26', 1, '2021-06-05 21:45:41'),
(223, 41, '2021-08-27', 1, '2021-06-05 21:45:41'),
(224, 41, '2021-08-28', 1, '2021-06-05 21:45:41'),
(225, 41, '2021-08-29', 1, '2021-06-05 21:45:41'),
(226, 41, '2021-08-30', 1, '2021-06-05 21:45:41'),
(227, 41, '2021-08-31', 1, '2021-06-05 21:45:42'),
(228, 41, '2021-09-01', 1, '2021-06-05 21:45:42'),
(229, 41, '2021-09-02', 1, '2021-06-05 21:45:42'),
(230, 41, '2021-09-03', 1, '2021-06-05 21:45:42'),
(231, 41, '2021-09-04', 1, '2021-06-05 21:45:42'),
(232, 41, '2021-09-05', 1, '2021-06-05 21:45:42'),
(233, 41, '2021-09-06', 1, '2021-06-05 21:45:42'),
(234, 41, '2021-09-07', 1, '2021-06-05 21:45:43'),
(235, 41, '2021-09-08', 1, '2021-06-05 21:45:43'),
(236, 41, '2021-09-09', 1, '2021-06-05 21:45:43'),
(237, 41, '2021-09-10', 1, '2021-06-05 21:45:43'),
(238, 41, '2021-09-11', 1, '2021-06-05 21:45:43'),
(239, 41, '2021-09-12', 1, '2021-06-05 21:45:43'),
(240, 41, '2021-09-13', 1, '2021-06-05 21:45:43'),
(241, 41, '2021-09-14', 1, '2021-06-05 21:45:43'),
(242, 41, '2021-09-15', 1, '2021-06-05 21:45:43'),
(243, 41, '2021-09-16', 1, '2021-06-05 21:45:44'),
(244, 41, '2021-09-17', 1, '2021-06-05 21:45:44'),
(245, 41, '2021-09-18', 1, '2021-06-05 21:45:44'),
(246, 41, '2021-09-19', 1, '2021-06-05 21:45:44'),
(247, 41, '2021-09-20', 1, '2021-06-05 21:45:44'),
(248, 41, '2021-09-21', 1, '2021-06-05 21:45:44'),
(249, 41, '2021-09-22', 1, '2021-06-05 21:45:45'),
(250, 41, '2021-09-23', 1, '2021-06-05 21:45:45'),
(251, 41, '2021-09-24', 1, '2021-06-05 21:45:45'),
(252, 41, '2021-09-25', 1, '2021-06-05 21:45:45'),
(253, 41, '2021-09-26', 1, '2021-06-05 21:45:45'),
(254, 41, '2021-09-27', 1, '2021-06-05 21:45:45'),
(255, 41, '2021-09-28', 1, '2021-06-05 21:45:45'),
(256, 41, '2021-09-29', 1, '2021-06-05 21:45:45'),
(257, 41, '2021-09-30', 1, '2021-06-05 21:45:46'),
(258, 41, '2021-10-01', 1, '2021-06-05 21:45:46'),
(259, 41, '2021-10-02', 1, '2021-06-05 21:45:47'),
(260, 41, '2021-10-03', 1, '2021-06-05 21:45:48'),
(261, 41, '2021-10-04', 1, '2021-06-05 21:45:48'),
(262, 41, '2021-10-05', 1, '2021-06-05 21:45:48'),
(263, 41, '2021-10-06', 1, '2021-06-05 21:45:49'),
(264, 41, '2021-10-07', 1, '2021-06-05 21:45:49'),
(265, 41, '2021-10-08', 1, '2021-06-05 21:45:49'),
(266, 41, '2021-10-09', 1, '2021-06-05 21:45:49'),
(267, 41, '2021-10-10', 1, '2021-06-05 21:45:49'),
(268, 41, '2021-10-11', 1, '2021-06-05 21:45:49'),
(269, 41, '2021-10-12', 1, '2021-06-05 21:45:49'),
(270, 41, '2021-10-13', 1, '2021-06-05 21:45:49'),
(271, 41, '2021-10-14', 1, '2021-06-05 21:45:50'),
(272, 41, '2021-10-15', 1, '2021-06-05 21:45:50'),
(273, 41, '2021-10-16', 1, '2021-06-05 21:45:50'),
(274, 41, '2021-10-17', 1, '2021-06-05 21:45:50'),
(275, 41, '2021-10-18', 1, '2021-06-05 21:45:50'),
(276, 41, '2021-10-19', 1, '2021-06-05 21:45:50'),
(277, 41, '2021-10-20', 1, '2021-06-05 21:45:50'),
(278, 41, '2021-10-21', 1, '2021-06-05 21:45:50'),
(279, 41, '2021-10-22', 1, '2021-06-05 21:45:50'),
(280, 41, '2021-10-23', 1, '2021-06-05 21:45:50'),
(281, 41, '2021-10-24', 1, '2021-06-05 21:45:51'),
(282, 41, '2021-10-25', 1, '2021-06-05 21:45:51'),
(283, 41, '2021-10-26', 1, '2021-06-05 21:45:51'),
(284, 41, '2021-10-27', 1, '2021-06-05 21:45:51'),
(285, 41, '2021-10-28', 1, '2021-06-05 21:45:51'),
(286, 41, '2021-10-29', 1, '2021-06-05 21:45:51'),
(287, 41, '2021-10-30', 1, '2021-06-05 21:45:51'),
(288, 41, '2021-10-31', 1, '2021-06-05 21:45:51'),
(289, 41, '2021-11-01', 1, '2021-06-05 21:45:51'),
(290, 41, '2021-11-02', 1, '2021-06-05 21:45:52'),
(291, 41, '2021-11-03', 1, '2021-06-05 21:45:52'),
(292, 41, '2021-11-04', 1, '2021-06-05 21:45:52'),
(293, 41, '2021-11-05', 1, '2021-06-05 21:45:52'),
(294, 41, '2021-11-06', 1, '2021-06-05 21:45:52'),
(295, 41, '2021-11-07', 1, '2021-06-05 21:45:52'),
(296, 41, '2021-11-08', 1, '2021-06-05 21:45:52'),
(297, 41, '2021-11-09', 1, '2021-06-05 21:45:52'),
(298, 41, '2021-11-10', 1, '2021-06-05 21:45:52'),
(299, 41, '2021-11-11', 1, '2021-06-05 21:45:52'),
(300, 41, '2021-11-12', 1, '2021-06-05 21:45:52'),
(301, 41, '2021-11-13', 1, '2021-06-05 21:45:52'),
(302, 41, '2021-11-14', 1, '2021-06-05 21:45:53'),
(303, 41, '2021-11-15', 1, '2021-06-05 21:45:53'),
(304, 41, '2021-11-16', 1, '2021-06-05 21:45:53'),
(305, 41, '2021-11-17', 1, '2021-06-05 21:45:53'),
(306, 41, '2021-11-18', 1, '2021-06-05 21:45:53'),
(307, 41, '2021-11-19', 1, '2021-06-05 21:45:53'),
(308, 41, '2021-11-20', 1, '2021-06-05 21:45:53'),
(309, 41, '2021-11-21', 1, '2021-06-05 21:45:53'),
(310, 41, '2021-11-22', 1, '2021-06-05 21:45:53'),
(311, 41, '2021-11-23', 1, '2021-06-05 21:45:53'),
(312, 41, '2021-11-24', 1, '2021-06-05 21:45:53'),
(313, 41, '2021-11-25', 1, '2021-06-05 21:45:54'),
(314, 41, '2021-11-26', 1, '2021-06-05 21:45:54'),
(315, 41, '2021-11-27', 1, '2021-06-05 21:45:54'),
(316, 41, '2021-11-28', 1, '2021-06-05 21:45:54'),
(317, 41, '2021-11-29', 1, '2021-06-05 21:45:54'),
(318, 41, '2021-11-30', 1, '2021-06-05 21:45:54'),
(319, 41, '2021-12-01', 1, '2021-06-05 21:45:54'),
(320, 41, '2021-12-02', 1, '2021-06-05 21:45:54'),
(321, 41, '2021-12-03', 1, '2021-06-05 21:45:54'),
(322, 41, '2021-12-04', 1, '2021-06-05 21:45:54'),
(323, 41, '2021-12-05', 1, '2021-06-05 21:45:55'),
(324, 41, '2021-12-06', 1, '2021-06-05 21:45:55'),
(325, 41, '2021-12-07', 1, '2021-06-05 21:45:55'),
(326, 41, '2021-12-08', 1, '2021-06-05 21:45:55'),
(327, 41, '2021-12-09', 1, '2021-06-05 21:45:55'),
(328, 41, '2021-12-10', 1, '2021-06-05 21:45:55'),
(329, 41, '2021-12-11', 1, '2021-06-05 21:45:55'),
(330, 41, '2021-12-12', 1, '2021-06-05 21:45:55'),
(331, 41, '2021-12-13', 1, '2021-06-05 21:45:55'),
(332, 41, '2021-12-14', 1, '2021-06-05 21:45:56'),
(333, 41, '2021-12-15', 1, '2021-06-05 21:45:56'),
(334, 41, '2021-12-16', 1, '2021-06-05 21:45:56'),
(335, 41, '2021-12-17', 1, '2021-06-05 21:45:56'),
(336, 41, '2021-12-18', 1, '2021-06-05 21:45:56'),
(337, 41, '2021-12-19', 1, '2021-06-05 21:45:56'),
(338, 41, '2021-12-20', 1, '2021-06-05 21:45:56'),
(339, 41, '2021-12-21', 1, '2021-06-05 21:45:57'),
(340, 41, '2021-12-22', 1, '2021-06-05 21:45:57'),
(341, 41, '2021-12-23', 1, '2021-06-05 21:45:57'),
(342, 41, '2021-12-24', 1, '2021-06-05 21:45:57'),
(343, 41, '2021-12-25', 1, '2021-06-05 21:45:57'),
(344, 41, '2021-12-26', 1, '2021-06-05 21:45:57'),
(345, 41, '2021-12-27', 1, '2021-06-05 21:45:57'),
(346, 41, '2021-12-28', 1, '2021-06-05 21:45:57'),
(347, 41, '2021-12-29', 1, '2021-06-05 21:45:57'),
(348, 41, '2021-12-30', 1, '2021-06-05 21:45:57'),
(349, 41, '2021-12-31', 1, '2021-06-05 21:45:57'),
(350, 41, '2022-01-01', 1, '2021-06-05 21:45:57'),
(351, 41, '2022-01-02', 1, '2021-06-05 21:45:57'),
(352, 41, '2022-01-03', 1, '2021-06-05 21:45:57'),
(353, 41, '2022-01-04', 1, '2021-06-05 21:45:57'),
(354, 41, '2022-01-05', 1, '2021-06-05 21:45:57'),
(355, 41, '2022-01-06', 1, '2021-06-05 21:45:58'),
(356, 41, '2022-01-07', 1, '2021-06-05 21:45:58'),
(357, 41, '2022-01-08', 1, '2021-06-05 21:45:58'),
(358, 41, '2022-01-09', 1, '2021-06-05 21:45:58'),
(359, 41, '2022-01-10', 1, '2021-06-05 21:45:58'),
(360, 41, '2022-01-11', 1, '2021-06-05 21:45:58'),
(361, 41, '2022-01-12', 1, '2021-06-05 21:45:58'),
(362, 41, '2022-01-13', 1, '2021-06-05 21:45:58'),
(363, 41, '2022-01-14', 1, '2021-06-05 21:45:58'),
(364, 41, '2022-01-15', 1, '2021-06-05 21:45:58'),
(365, 41, '2022-01-16', 1, '2021-06-05 21:45:58'),
(366, 41, '2022-01-17', 1, '2021-06-05 21:45:58'),
(367, 41, '2022-01-18', 1, '2021-06-05 21:45:58'),
(368, 41, '2022-01-19', 1, '2021-06-05 21:45:59'),
(369, 41, '2022-01-20', 1, '2021-06-05 21:45:59'),
(370, 41, '2022-01-21', 1, '2021-06-05 21:45:59'),
(371, 41, '2022-01-22', 1, '2021-06-05 21:45:59'),
(372, 41, '2022-01-23', 1, '2021-06-05 21:45:59'),
(373, 41, '2022-01-24', 1, '2021-06-05 21:45:59'),
(374, 41, '2022-01-25', 1, '2021-06-05 21:45:59'),
(375, 41, '2022-01-26', 1, '2021-06-05 21:45:59'),
(376, 41, '2022-01-27', 1, '2021-06-05 21:46:00'),
(377, 41, '2022-01-28', 1, '2021-06-05 21:46:00'),
(378, 41, '2022-01-29', 1, '2021-06-05 21:46:00'),
(379, 41, '2022-01-30', 1, '2021-06-05 21:46:00'),
(380, 41, '2022-01-31', 1, '2021-06-05 21:46:00'),
(381, 41, '2022-02-01', 1, '2021-06-05 21:46:00'),
(382, 41, '2022-02-02', 1, '2021-06-05 21:46:00'),
(383, 41, '2022-02-03', 1, '2021-06-05 21:46:00'),
(384, 41, '2022-02-04', 1, '2021-06-05 21:46:00'),
(385, 41, '2022-02-05', 1, '2021-06-05 21:46:00'),
(386, 41, '2022-02-06', 1, '2021-06-05 21:46:00'),
(387, 41, '2022-02-07', 1, '2021-06-05 21:46:01'),
(388, 41, '2022-02-08', 1, '2021-06-05 21:46:01'),
(389, 41, '2022-02-09', 1, '2021-06-05 21:46:01'),
(390, 41, '2022-02-10', 1, '2021-06-05 21:46:01'),
(391, 41, '2022-02-11', 1, '2021-06-05 21:46:01'),
(392, 41, '2022-02-12', 1, '2021-06-05 21:46:01'),
(393, 41, '2022-02-13', 1, '2021-06-05 21:46:02'),
(394, 41, '2022-02-14', 1, '2021-06-05 21:46:02'),
(395, 41, '2022-02-15', 1, '2021-06-05 21:46:02'),
(396, 41, '2022-02-16', 1, '2021-06-05 21:46:02'),
(397, 41, '2022-02-17', 1, '2021-06-05 21:46:03'),
(398, 41, '2022-02-18', 1, '2021-06-05 21:46:03'),
(399, 41, '2022-02-19', 1, '2021-06-05 21:46:03'),
(400, 41, '2022-02-20', 1, '2021-06-05 21:46:03'),
(401, 41, '2022-02-21', 1, '2021-06-05 21:46:03'),
(402, 41, '2022-02-22', 1, '2021-06-05 21:46:04'),
(403, 41, '2022-02-23', 1, '2021-06-05 21:46:04'),
(404, 41, '2022-02-24', 1, '2021-06-05 21:46:04'),
(405, 41, '2022-02-25', 1, '2021-06-05 21:46:04'),
(406, 41, '2022-02-26', 1, '2021-06-05 21:46:04'),
(407, 41, '2022-02-27', 1, '2021-06-05 21:46:04'),
(408, 41, '2022-02-28', 1, '2021-06-05 21:46:04'),
(409, 41, '2022-03-01', 1, '2021-06-05 21:46:04'),
(410, 41, '2022-03-02', 1, '2021-06-05 21:46:04'),
(411, 41, '2022-03-03', 1, '2021-06-05 21:46:04'),
(412, 41, '2022-03-04', 1, '2021-06-05 21:46:05'),
(413, 41, '2022-03-05', 1, '2021-06-05 21:46:05'),
(414, 41, '2022-03-06', 1, '2021-06-05 21:46:05'),
(415, 41, '2022-03-07', 1, '2021-06-05 21:46:05'),
(416, 41, '2022-03-08', 1, '2021-06-05 21:46:05'),
(417, 41, '2022-03-09', 1, '2021-06-05 21:46:05'),
(418, 41, '2022-03-10', 1, '2021-06-05 21:46:05'),
(419, 41, '2022-03-11', 1, '2021-06-05 21:46:05'),
(420, 41, '2022-03-12', 1, '2021-06-05 21:46:06'),
(421, 41, '2022-03-13', 1, '2021-06-05 21:46:06'),
(422, 41, '2022-03-14', 1, '2021-06-05 21:46:06'),
(423, 41, '2022-03-15', 1, '2021-06-05 21:46:06'),
(424, 41, '2022-03-16', 1, '2021-06-05 21:46:07'),
(425, 41, '2022-03-17', 1, '2021-06-05 21:46:07'),
(426, 41, '2022-03-18', 1, '2021-06-05 21:46:07'),
(427, 41, '2022-03-19', 1, '2021-06-05 21:46:07'),
(428, 41, '2022-03-20', 1, '2021-06-05 21:46:07'),
(429, 41, '2022-03-21', 1, '2021-06-05 21:46:08'),
(430, 41, '2022-03-22', 1, '2021-06-05 21:46:08'),
(431, 41, '2022-03-23', 1, '2021-06-05 21:46:08'),
(432, 41, '2022-03-24', 1, '2021-06-05 21:46:08'),
(433, 41, '2022-03-25', 1, '2021-06-05 21:46:08'),
(434, 41, '2022-03-26', 1, '2021-06-05 21:46:08'),
(435, 41, '2022-03-27', 1, '2021-06-05 21:46:08'),
(436, 41, '2022-03-28', 1, '2021-06-05 21:46:09'),
(437, 41, '2022-03-29', 1, '2021-06-05 21:46:09'),
(438, 41, '2022-03-30', 1, '2021-06-05 21:46:09'),
(439, 41, '2022-03-31', 1, '2021-06-05 21:46:09'),
(440, 41, '2022-04-01', 1, '2021-06-05 21:46:09'),
(441, 41, '2022-04-02', 1, '2021-06-05 21:46:09'),
(442, 41, '2022-04-03', 1, '2021-06-05 21:46:09'),
(443, 41, '2022-04-04', 1, '2021-06-05 21:46:10'),
(444, 41, '2022-04-05', 1, '2021-06-05 21:46:10'),
(445, 41, '2022-04-06', 1, '2021-06-05 21:46:10'),
(446, 41, '2022-04-07', 1, '2021-06-05 21:46:10'),
(447, 41, '2022-04-08', 1, '2021-06-05 21:46:10'),
(448, 41, '2022-04-09', 1, '2021-06-05 21:46:10'),
(449, 41, '2022-04-10', 1, '2021-06-05 21:46:10'),
(450, 41, '2022-04-11', 1, '2021-06-05 21:46:10'),
(451, 41, '2022-04-12', 1, '2021-06-05 21:46:10'),
(452, 41, '2022-04-13', 1, '2021-06-05 21:46:10'),
(453, 41, '2022-04-14', 1, '2021-06-05 21:46:10'),
(454, 41, '2022-04-15', 1, '2021-06-05 21:46:11'),
(455, 41, '2022-04-16', 1, '2021-06-05 21:46:11'),
(456, 41, '2022-04-17', 1, '2021-06-05 21:46:11'),
(457, 41, '2022-04-18', 1, '2021-06-05 21:46:11'),
(458, 41, '2022-04-19', 1, '2021-06-05 21:46:11'),
(459, 41, '2022-04-20', 1, '2021-06-05 21:46:11'),
(460, 41, '2022-04-21', 1, '2021-06-05 21:46:11'),
(461, 41, '2022-04-22', 1, '2021-06-05 21:46:11'),
(462, 41, '2022-04-23', 1, '2021-06-05 21:46:12'),
(463, 41, '2022-04-24', 1, '2021-06-05 21:46:12'),
(464, 41, '2022-04-25', 1, '2021-06-05 21:46:12'),
(465, 41, '2022-04-26', 1, '2021-06-05 21:46:12'),
(466, 41, '2022-04-27', 1, '2021-06-05 21:46:12'),
(467, 41, '2022-04-28', 1, '2021-06-05 21:46:12'),
(468, 41, '2022-04-29', 1, '2021-06-05 21:46:13'),
(469, 41, '2022-04-30', 1, '2021-06-05 21:46:13'),
(470, 41, '2022-05-01', 1, '2021-06-05 21:46:13'),
(471, 41, '2022-05-02', 1, '2021-06-05 21:46:13'),
(472, 41, '2022-05-03', 1, '2021-06-05 21:46:14'),
(473, 41, '2022-05-04', 1, '2021-06-05 21:46:14'),
(474, 41, '2022-05-05', 1, '2021-06-05 21:46:14'),
(475, 41, '2022-05-06', 1, '2021-06-05 21:46:15'),
(476, 41, '2022-05-07', 1, '2021-06-05 21:46:16'),
(477, 41, '2022-05-08', 1, '2021-06-05 21:46:16'),
(478, 41, '2022-05-09', 1, '2021-06-05 21:46:16'),
(479, 41, '2022-05-10', 1, '2021-06-05 21:46:16'),
(480, 41, '2022-05-11', 1, '2021-06-05 21:46:16'),
(481, 41, '2022-05-12', 1, '2021-06-05 21:46:16'),
(482, 41, '2022-05-13', 1, '2021-06-05 21:46:16'),
(483, 41, '2022-05-14', 1, '2021-06-05 21:46:16'),
(484, 41, '2022-05-15', 1, '2021-06-05 21:46:17'),
(485, 41, '2022-05-16', 1, '2021-06-05 21:46:17'),
(486, 41, '2022-05-17', 1, '2021-06-05 21:46:17'),
(487, 41, '2022-05-18', 1, '2021-06-05 21:46:17'),
(488, 41, '2022-05-19', 1, '2021-06-05 21:46:17'),
(489, 41, '2022-05-20', 1, '2021-06-05 21:46:17'),
(490, 41, '2022-05-21', 1, '2021-06-05 21:46:17'),
(491, 41, '2022-05-22', 1, '2021-06-05 21:46:17'),
(492, 41, '2022-05-23', 1, '2021-06-05 21:46:17'),
(493, 41, '2022-05-24', 1, '2021-06-05 21:46:17'),
(494, 41, '2022-05-25', 1, '2021-06-05 21:46:17'),
(495, 41, '2022-05-26', 1, '2021-06-05 21:46:17'),
(496, 41, '2022-05-27', 1, '2021-06-05 21:46:18'),
(497, 41, '2022-05-28', 1, '2021-06-05 21:46:18'),
(498, 41, '2022-05-29', 1, '2021-06-05 21:46:18'),
(499, 41, '2022-05-30', 1, '2021-06-05 21:46:18'),
(500, 41, '2022-05-31', 1, '2021-06-05 21:46:18'),
(501, 41, '2022-06-01', 1, '2021-06-05 21:46:18'),
(502, 41, '2022-06-02', 1, '2021-06-05 21:46:18'),
(503, 41, '2022-06-03', 1, '2021-06-05 21:46:18'),
(504, 41, '2022-06-04', 1, '2021-06-05 21:46:18'),
(505, 41, '2022-06-05', 1, '2021-06-05 21:46:19'),
(506, 41, '2022-06-06', 1, '2021-06-05 21:46:19'),
(507, 41, '2022-06-07', 1, '2021-06-05 21:46:19'),
(508, 41, '2022-06-08', 1, '2021-06-05 21:46:19'),
(509, 41, '2022-06-09', 1, '2021-06-05 21:46:19'),
(510, 41, '2022-06-10', 1, '2021-06-05 21:46:19'),
(511, 41, '2022-06-11', 1, '2021-06-05 21:46:19'),
(512, 41, '2022-06-12', 1, '2021-06-05 21:46:19'),
(513, 41, '2022-06-13', 1, '2021-06-05 21:46:19'),
(514, 41, '2022-06-14', 1, '2021-06-05 21:46:19'),
(515, 41, '2022-06-15', 1, '2021-06-05 21:46:19'),
(516, 41, '2022-06-16', 1, '2021-06-05 21:46:19'),
(517, 41, '2022-06-17', 1, '2021-06-05 21:46:19'),
(518, 41, '2022-06-18', 1, '2021-06-05 21:46:20'),
(519, 41, '2022-06-19', 1, '2021-06-05 21:46:20'),
(520, 41, '2022-06-20', 1, '2021-06-05 21:46:20'),
(521, 41, '2022-06-21', 1, '2021-06-05 21:46:20'),
(522, 41, '2022-06-22', 1, '2021-06-05 21:46:20'),
(523, 41, '2022-06-23', 1, '2021-06-05 21:46:20'),
(524, 41, '2022-06-24', 1, '2021-06-05 21:46:20'),
(525, 41, '2022-06-25', 1, '2021-06-05 21:46:20'),
(526, 41, '2022-06-26', 1, '2021-06-05 21:46:20'),
(527, 41, '2022-06-27', 1, '2021-06-05 21:46:20'),
(528, 41, '2022-06-28', 1, '2021-06-05 21:46:20'),
(529, 41, '2022-06-29', 1, '2021-06-05 21:46:20'),
(530, 41, '2022-06-30', 1, '2021-06-05 21:46:21'),
(531, 41, '2022-07-01', 1, '2021-06-05 21:46:21'),
(532, 41, '2022-07-02', 1, '2021-06-05 21:46:21'),
(533, 41, '2022-07-03', 1, '2021-06-05 21:46:21'),
(534, 41, '2021-05-30', 1, '2021-06-05 21:46:55'),
(535, 41, '2021-07-07', 2, '2021-06-05 21:47:22'),
(536, 41, '2021-05-30', 2, '2021-06-05 21:47:46'),
(537, 39, '2021-06-09', 1, '2021-06-05 21:48:10'),
(538, 39, '2021-06-10', 1, '2021-06-05 21:48:10'),
(539, 39, '2021-06-11', 1, '2021-06-05 21:48:11'),
(540, 39, '2021-06-12', 1, '2021-06-05 21:48:11'),
(541, 39, '2021-06-13', 1, '2021-06-05 21:48:11'),
(542, 39, '2021-06-14', 1, '2021-06-05 21:48:11'),
(543, 39, '2021-06-15', 1, '2021-06-05 21:48:11'),
(544, 39, '2021-06-16', 1, '2021-06-05 21:48:11'),
(545, 39, '2021-06-17', 1, '2021-06-05 21:48:11'),
(546, 39, '2021-06-18', 1, '2021-06-05 21:48:11'),
(547, 39, '2021-06-19', 1, '2021-06-05 21:48:11'),
(548, 39, '2021-06-20', 1, '2021-06-05 21:48:11'),
(549, 39, '2021-06-21', 1, '2021-06-05 21:48:11'),
(550, 39, '2021-06-22', 1, '2021-06-05 21:48:11'),
(551, 39, '2021-06-23', 1, '2021-06-05 21:48:11'),
(552, 39, '2021-06-24', 1, '2021-06-05 21:48:11'),
(553, 39, '2021-06-25', 1, '2021-06-05 21:48:11'),
(554, 39, '2021-06-26', 1, '2021-06-05 21:48:11'),
(555, 39, '2021-06-27', 1, '2021-06-05 21:48:11'),
(556, 39, '2021-06-28', 1, '2021-06-05 21:48:11'),
(557, 39, '2021-06-29', 1, '2021-06-05 21:48:12'),
(558, 39, '2021-06-30', 1, '2021-06-05 21:48:12'),
(559, 39, '2021-07-01', 1, '2021-06-05 21:48:12'),
(560, 39, '2021-07-02', 1, '2021-06-05 21:48:12'),
(561, 39, '2021-07-03', 1, '2021-06-05 21:48:12'),
(562, 39, '2021-07-04', 1, '2021-06-05 21:48:12'),
(563, 39, '2021-07-05', 1, '2021-06-05 21:48:12'),
(564, 39, '2021-07-06', 1, '2021-06-05 21:48:12'),
(565, 39, '2021-07-07', 1, '2021-06-05 21:48:12'),
(566, 39, '2021-07-08', 1, '2021-06-05 21:48:12'),
(567, 41, '2021-06-30', 2, '2021-06-05 21:48:13'),
(568, 41, '2021-07-08', 2, '2021-06-05 21:48:23'),
(569, 41, '2021-06-06', 2, '2021-06-06 11:05:16'),
(570, 41, '2021-06-07', 2, '2021-06-06 11:06:08'),
(571, 41, '2021-06-08', 2, '2021-06-06 11:06:39'),
(573, 41, '2021-06-10', 2, '2021-06-06 11:06:40'),
(574, 41, '2021-06-11', 2, '2021-06-06 11:06:40'),
(575, 41, '2021-06-12', 2, '2021-06-06 11:06:40'),
(576, 41, '2021-06-13', 2, '2021-06-06 11:06:40'),
(577, 41, '2021-06-14', 2, '2021-06-06 11:06:41'),
(578, 41, '2021-06-15', 2, '2021-06-06 11:06:41'),
(579, 41, '2021-06-16', 2, '2021-06-06 11:06:41'),
(580, 41, '2021-06-17', 2, '2021-06-06 11:06:41'),
(581, 41, '2021-06-18', 2, '2021-06-06 11:06:41'),
(582, 41, '2021-06-19', 2, '2021-06-06 11:06:41'),
(583, 41, '2021-06-20', 2, '2021-06-06 11:06:41'),
(584, 41, '2021-06-21', 2, '2021-06-06 11:06:41'),
(585, 41, '2021-06-22', 2, '2021-06-06 11:06:42'),
(586, 41, '2021-06-23', 2, '2021-06-06 11:06:42'),
(587, 41, '2021-06-24', 2, '2021-06-06 11:06:42'),
(588, 41, '2021-06-25', 2, '2021-06-06 11:06:42'),
(589, 41, '2021-06-26', 2, '2021-06-06 11:06:42'),
(590, 41, '2021-06-27', 2, '2021-06-06 11:06:42'),
(591, 41, '2021-06-28', 2, '2021-06-06 11:06:42'),
(592, 41, '2021-06-29', 2, '2021-06-06 11:06:43'),
(593, 50, '2021-06-30', 0, '2021-06-06 18:28:13'),
(601, 49, '2021-06-07', 0, '2021-06-07 08:26:28'),
(617, 49, '2021-06-08', 0, '2021-06-08 06:50:33'),
(618, 49, '2021-06-09', 0, '2021-06-08 06:50:33'),
(619, 49, '2021-06-10', 0, '2021-06-08 06:50:33'),
(620, 49, '2021-06-11', 0, '2021-06-10 07:41:32'),
(621, 49, '2021-06-22', 0, '2021-06-10 11:01:36'),
(622, 49, '2021-06-23', 0, '2021-06-10 11:01:37'),
(623, 52, '2021-06-21', 6, '2021-06-14 06:50:27'),
(624, 52, '2021-06-17', 4, '2021-06-16 13:34:41'),
(625, 52, '2021-06-18', 4, '2021-06-16 13:34:41'),
(626, 52, '2021-06-19', 4, '2021-06-16 13:34:41'),
(627, 52, '2021-06-20', 4, '2021-06-16 13:34:41'),
(628, 52, '2021-06-21', 4, '2021-06-16 13:34:41'),
(629, 52, '2021-06-22', 4, '2021-06-16 13:34:42'),
(630, 52, '2021-06-24', 3, '2021-06-21 04:51:01'),
(631, 52, '2021-06-25', 3, '2021-06-21 04:51:01'),
(632, 52, '2021-06-26', 3, '2021-06-21 04:51:02'),
(634, 52, '2021-06-28', 3, '2021-06-21 04:51:02'),
(635, 52, '2021-06-28', 4, '2021-06-21 04:51:25'),
(636, 52, '2021-06-30', 5, '2021-06-21 08:51:02'),
(637, 52, '2021-06-25', 7, '2021-06-24 04:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_redeem_requests`
--

CREATE TABLE `tbl_redeem_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `amount` float(15,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `redeemedAmount` float(15,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `paymentStatus` enum('pending','redeemed','initiated','rejected') NOT NULL DEFAULT 'pending',
  `createdDate` datetime NOT NULL,
  `updatedDate` datetime NOT NULL,
  `redeemedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_redeem_requests`
--

INSERT INTO `tbl_redeem_requests` (`id`, `userId`, `amount`, `redeemedAmount`, `paymentStatus`, `createdDate`, `updatedDate`, `redeemedDate`) VALUES
(1, 1, 100.00, 0.00, 'pending', '2020-10-12 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 1, 10.00, 0.00, 'pending', '2021-03-18 17:32:36', '2021-03-18 17:32:36', NULL),
(3, 1, 5.00, 0.00, 'pending', '2021-03-19 15:22:07', '2021-03-19 15:22:07', NULL),
(4, 1, 2.00, 2.00, 'redeemed', '2021-03-19 15:54:45', '2021-03-19 15:54:45', '2021-03-20 17:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `id` int(12) NOT NULL,
  `sender_id` int(12) NOT NULL,
  `receiver_id` int(12) NOT NULL,
  `parent_id` int(12) NOT NULL,
  `rating` double NOT NULL,
  `description` blob,
  `service_request_id` int(12) NOT NULL,
  `replySend` enum('y','n') COLLATE utf8mb4_bin NOT NULL DEFAULT 'n',
  `replyMsg` longtext COLLATE utf8mb4_bin NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('y','n') COLLATE utf8mb4_bin NOT NULL DEFAULT 'y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`id`, `sender_id`, `receiver_id`, `parent_id`, `rating`, `description`, `service_request_id`, `replySend`, `replyMsg`, `posted_date`, `status`) VALUES
(5, 1, 4, 0, 4, 0x676f6f642073657276696365, 1, 'n', '', '2021-04-07 11:55:28', 'y'),
(7, 16, 10, 0, 5, 0x49742077617320766572792068656c7066756c20796f7572207365727669636520666f72206d6520616e6420616761696e20492077696c6c2075736520796f7572207365727669636520746f20626f6f6b2e, 7, 'y', 'Thanks buddy', '2021-05-13 11:50:35', 'y'),
(8, 10, 16, 0, 5, 0x4920616d206665656c696e67206c75636b7920666f7220776f726b207769746820796f7520617320676f6f6420637573746f6d65722e, 7, 'n', '', '2021-05-13 11:45:46', 'y'),
(9, 4, 1, 0, 3, 0x68686868682068686868686820726576696577, 23, 'n', '', '2021-05-24 13:11:17', 'y'),
(10, 34, 32, 0, 3, 0x7465737420627920637573746f6d6572, 31, 'y', 'thanks customer for review.', '2021-05-28 14:03:53', 'y'),
(11, 32, 34, 0, 3, 0x4920616d2070726f766964657220746f206375732e, 35, 'n', '', '2021-05-29 14:25:58', 'y'),
(12, 34, 32, 0, 3.5, 0x4920616d20437573746f6d657220746f2070726f762e, 36, 'n', '', '2021-05-29 14:27:10', 'y'),
(13, 34, 32, 0, 4.7, 0x74657374, 35, 'n', '', '2021-05-29 14:46:10', 'y'),
(14, 32, 34, 0, 4.6, 0x68676a, 33, 'n', '', '2021-05-29 14:47:07', 'y'),
(15, 17, 19, 0, 3, 0x7665727920676f6f64206a6f62, 32, 'n', '', '2021-05-30 20:04:09', 'y'),
(16, 19, 17, 0, 3, 0x676f6f64206a6f62, 32, 'n', '', '2021-05-30 20:10:51', 'y'),
(17, 44, 34, 0, 3, 0x72657669657731, 45, 'n', '', '2021-06-03 12:32:23', 'y'),
(18, 34, 44, 0, 3, 0x7265766965772063, 45, 'y', 'Thanks', '2021-06-03 12:36:36', 'y'),
(19, 34, 44, 0, 3, 0x6f6b6b6b6b6b6b6b6b, 45, 'n', '', '2021-06-03 12:41:06', 'y'),
(20, 48, 34, 0, 3, 0x723170, 61, 'n', '', '2021-06-05 10:24:25', 'y'),
(21, 34, 48, 0, 3, 0x723163, 61, 'n', '', '2021-06-05 10:25:05', 'y'),
(22, 49, 34, 0, 3, 0x74657374, 77, 'n', '', '2021-06-10 06:33:27', 'y'),
(23, 34, 49, 0, 3, 0x7465737473747374, 77, 'y', 'gh', '2021-06-10 12:00:45', 'y'),
(24, 34, 49, 0, 5, 0x6f6b, 85, 'y', '????', '2021-06-10 12:00:36', 'y'),
(25, 51, 52, 0, 4, 0x63686767, 94, 'y', 'ujyu6i', '2021-06-16 13:41:48', 'y'),
(26, 51, 52, 0, 2.5, 0x6263636863, 95, 'y', 'chc', '2021-06-16 11:59:36', 'y'),
(27, 52, 51, 0, 3, 0x6267666467, 95, 'n', '', '2021-06-16 13:39:28', 'y'),
(33, 16, 1, 0, 5, 0x476f6f64207365727669636520f09f988af09f9880f09f9882, 100, 'n', '', '2021-06-25 11:57:50', 'y'),
(34, 51, 52, 0, 3, 0xf09f918d, 109, 'n', '', '2021-06-28 09:05:03', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `provider_id`, `service_name`, `createdDate`, `updatedDate`) VALUES
(1, 15, 'Vehicle Diagnostic Systems', '2021-03-25 00:00:00', '0000-00-00 00:00:00'),
(2, 15, 'batteries and charging systems', '2021-03-25 00:00:00', '0000-00-00 00:00:00'),
(3, 15, 'heating and ac repairs', '2021-03-25 00:00:00', '0000-00-00 00:00:00'),
(4, 15, 'Exhaust System Repairs	', '2021-03-25 00:00:00', '0000-00-00 00:00:00'),
(5, 15, 'brake service and repair', '2021-03-25 15:12:37', '0000-00-00 00:00:00'),
(6, 1, 'vehicle diagnostic', '2021-03-26 17:05:08', '0000-00-00 00:00:00'),
(7, 15, 'test', '2021-03-30 10:55:09', '0000-00-00 00:00:00'),
(8, 15, 'car engin repair', '2021-03-30 11:29:12', '0000-00-00 00:00:00'),
(9, 10, 'bike repair', '2021-03-30 12:14:52', '0000-00-00 00:00:00'),
(10, 10, 'engine oil change', '2021-03-30 12:28:10', '0000-00-00 00:00:00'),
(11, 10, 'Head Light Repair', '2021-03-30 12:30:56', '0000-00-00 00:00:00'),
(12, 19, 'Tyres', '2021-04-17 16:46:38', '0000-00-00 00:00:00'),
(13, 10, 'Break Repair', '2021-05-19 17:21:00', '0000-00-00 00:00:00'),
(14, 32, 'test1 service', '2021-05-21 18:02:52', '0000-00-00 00:00:00'),
(15, 32, 'test2 service', '2021-05-21 18:03:38', '0000-00-00 00:00:00'),
(16, 32, 'test3 service', '2021-05-21 18:03:46', '0000-00-00 00:00:00'),
(17, 32, 'test4 service', '2021-05-21 18:03:58', '0000-00-00 00:00:00'),
(18, 32, 'test5 service', '2021-05-21 18:04:10', '0000-00-00 00:00:00'),
(19, 32, 'test6 service', '2021-05-21 18:04:19', '0000-00-00 00:00:00'),
(20, 32, 'test7 service', '2021-05-21 18:04:32', '0000-00-00 00:00:00'),
(21, 32, 'test8 service', '2021-05-21 18:04:41', '0000-00-00 00:00:00'),
(22, 32, 'test9 service', '2021-05-21 18:04:50', '0000-00-00 00:00:00'),
(23, 35, 'engine', '2021-05-22 19:15:44', '0000-00-00 00:00:00'),
(24, 35, 'gearbox', '2021-05-22 19:16:00', '0000-00-00 00:00:00'),
(25, 35, 'clutch', '2021-05-22 19:16:12', '0000-00-00 00:00:00'),
(26, 1, '123', '2021-05-28 18:40:40', '0000-00-00 00:00:00'),
(27, 19, 'Breaks', '2021-05-29 23:59:48', '0000-00-00 00:00:00'),
(28, 19, 'Bodywork', '2021-05-30 00:00:11', '0000-00-00 00:00:00'),
(29, 37, 'Body repair', '2021-05-30 18:16:00', '0000-00-00 00:00:00'),
(30, 37, 'Spray paint', '2021-05-30 18:16:13', '0000-00-00 00:00:00'),
(31, 37, 'Tyre', '2021-05-30 18:16:54', '0000-00-00 00:00:00'),
(32, 5, 'Fhh', '2021-06-02 19:04:32', '0000-00-00 00:00:00'),
(33, 44, 'Test Service - 1', '2021-06-03 16:17:13', '0000-00-00 00:00:00'),
(34, 44, 'Test Service - 2', '2021-06-03 16:17:21', '0000-00-00 00:00:00'),
(35, 44, 'Test Service - 3', '2021-06-03 16:17:31', '0000-00-00 00:00:00'),
(36, 44, 'Test Service - 4', '2021-06-03 16:17:40', '0000-00-00 00:00:00'),
(37, 44, 'Test Service - 5', '2021-06-03 16:17:48', '0000-00-00 00:00:00'),
(38, 44, 'Test Service - 6', '2021-06-03 16:17:58', '0000-00-00 00:00:00'),
(39, 44, 'Test Service - 7', '2021-06-03 16:18:05', '0000-00-00 00:00:00'),
(40, 44, 'Test Service - 8', '2021-06-03 16:21:07', '0000-00-00 00:00:00'),
(41, 44, 'Test Service - 9', '2021-06-03 16:21:23', '0000-00-00 00:00:00'),
(42, 44, 'Test Service - 10', '2021-06-03 16:21:30', '0000-00-00 00:00:00'),
(43, 49, 'fsa', '2021-06-07 18:14:04', '0000-00-00 00:00:00'),
(44, 49, 'Yhbh', '2021-06-08 13:53:17', '0000-00-00 00:00:00'),
(45, 52, 'Ok', '2021-06-16 17:18:33', '0000-00-00 00:00:00'),
(46, 52, 'hbgfh', '2021-06-16 19:05:57', '0000-00-00 00:00:00'),
(47, 52, 'gff', '2021-06-21 10:22:58', '0000-00-00 00:00:00'),
(48, 52, 'Test Service - 1', '2021-06-21 19:20:11', '0000-00-00 00:00:00'),
(49, 52, 'test', '2021-06-21 19:20:19', '0000-00-00 00:00:00'),
(50, 52, 'Test Service -2', '2021-06-24 09:52:42', '0000-00-00 00:00:00'),
(51, 52, 'Test Service - 2', '2021-06-24 09:53:11', '0000-00-00 00:00:00'),
(52, 41, 'engine', '2021-07-03 21:38:12', '0000-00-00 00:00:00'),
(53, 41, 'gearbox', '2021-07-03 21:38:22', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_book_record`
--

CREATE TABLE `tbl_service_book_record` (
  `id` bigint(20) NOT NULL,
  `provider_id` bigint(20) NOT NULL,
  `vin_number` varchar(100) NOT NULL,
  `service_date` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `amount` double NOT NULL,
  `crated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_service_book_record`
--

INSERT INTO `tbl_service_book_record` (`id`, `provider_id`, `vin_number`, `service_date`, `description`, `amount`, `crated_date`) VALUES
(3, 1, 'XXXDEF1GH23456789', '2021-01-23', 'test', 100, '2021-04-01 08:15:46'),
(4, 10, 'XXXDEF1GH23456789', '2021-04-03', 'To teso service record here description will be provided, so don\\\'t take it seriously it is just for demo purpose.', 50, '2021-04-03 09:13:36'),
(5, 1, '3VWRA69M65M066177', '2021-03-31', 'test', 100, '2021-05-28 11:40:25'),
(6, 32, '3VWRA69M65M066177', '2021-05-28', 'test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test', -600, '2021-05-28 12:14:49'),
(7, 32, '3VWRA69M65M066177', '2021-05-28', 'fsdf', 50.5, '2021-05-28 12:17:10'),
(8, 32, '3VWRA69M65M066177', '2021-05-28', 'yhrt', 0.5, '2021-05-28 12:17:32'),
(9, 19, 'VF7LCRHRH74480880', '2021-05-28', 'new breaks fitted front', 55, '2021-05-28 16:03:09'),
(10, 1, '3VWRA69M65M066177', '2021-05-06', 'afcsg', 200, '2021-05-29 10:52:54'),
(11, 49, 'XXXDEF1GH23456789', '2021-06-08', 'cuvhvjvhvhlvuvhvhvhvh\nvjvvbjvj\nubhbubbu\nhibubibupb\n\n\nhbubu', 50, '2021-06-08 08:35:29'),
(12, 52, '3VWRA69M65M066177', '2021-06-04', 'vbbn', 555, '2021-06-21 05:40:37'),
(13, 52, '3VWRA69M65M066177', '2021-06-10', 'teest', 10, '2021-06-21 05:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_requests`
--

CREATE TABLE `tbl_service_requests` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `provider_id` bigint(20) NOT NULL,
  `unique_id` varchar(50) NOT NULL,
  `service_date` date NOT NULL,
  `service_time_slot` int(11) NOT NULL,
  `service_type` enum('mechanic','taxi') NOT NULL DEFAULT 'mechanic',
  `location_details` text,
  `start_date` date DEFAULT NULL,
  `end_date` time DEFAULT NULL,
  `address` varchar(500) NOT NULL,
  `addLat` varchar(100) NOT NULL,
  `addLong` varchar(100) NOT NULL,
  `request_status` enum('p','a','r') NOT NULL DEFAULT 'p',
  `service_status` enum('upcoming','cancel','complete','ongoing') NOT NULL DEFAULT 'upcoming',
  `cancelled_by` enum('provider','customer') DEFAULT NULL,
  `complete_provider` enum('y','n') NOT NULL DEFAULT 'n',
  `complete_customer` enum('y','n') NOT NULL DEFAULT 'n',
  `booking_amount` double DEFAULT NULL,
  `payment_method` enum('online','offline') DEFAULT NULL,
  `payment_status` enum('pending','paid','running') NOT NULL,
  `message` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processingStartTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_service_requests`
--

INSERT INTO `tbl_service_requests` (`id`, `customer_id`, `provider_id`, `unique_id`, `service_date`, `service_time_slot`, `service_type`, `location_details`, `start_date`, `end_date`, `address`, `addLat`, `addLong`, `request_status`, `service_status`, `cancelled_by`, `complete_provider`, `complete_customer`, `booking_amount`, `payment_method`, `payment_status`, `message`, `created_date`, `processingStartTime`) VALUES
(1, 1, 4, '606afb07caa47', '2021-04-08', 1, 'mechanic', NULL, NULL, NULL, 'Rajkot, Gujarat, India', '22.30889000', '70.78212000', 'a', 'complete', 'customer', 'y', 'y', 200, NULL, 'pending', NULL, '2021-04-05 11:56:55', NULL),
(2, 16, 10, '606ebb0948e2b', '2021-04-09', 2, 'mechanic', NULL, NULL, NULL, 'Rajkot, Gujarat', '22.29768', '70.78746', 'a', 'complete', NULL, 'y', 'y', NULL, NULL, 'pending', NULL, '2021-04-08 08:12:57', NULL),
(3, 16, 10, '606ebb8a549d3', '2021-04-08', 23, 'mechanic', NULL, NULL, NULL, '150 Feet Ring Road, Mahavir Park, Rajkot 360005, Gujarat', '22.28424', '70.77268', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-04-08 08:15:06', NULL),
(4, 4, 1, '6093ca276db9c', '0000-00-00', 0, 'taxi', NULL, '2021-05-12', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 500, 'online', 'paid', NULL, '2021-05-06 10:51:19', NULL),
(5, 16, 10, '609b99ce987b7', '2021-05-12', 17, 'mechanic', NULL, NULL, NULL, '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-12 09:03:10', NULL),
(6, 16, 10, '609cc0347dc3b', '2021-05-13', 16, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-13 05:59:16', NULL),
(7, 16, 10, '609cc93094f8f', '2021-05-14', 9, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 20, 'online', 'paid', NULL, '2021-05-13 06:37:36', NULL),
(8, 16, 1, '609e34483fae2', '0000-00-00', 0, 'taxi', NULL, '2021-05-17', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 250, 'online', 'paid', NULL, '2021-05-14 08:26:48', NULL),
(9, 4, 1, '60a257d407866', '0000-00-00', 0, 'taxi', 'Rajkot to ahmedabad', '2021-05-27', '00:00:00', '', '', '', 'p', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-17 11:47:32', NULL),
(10, 4, 1, '60a2588574f54', '0000-00-00', 0, 'taxi', 'ahmedabad to rajkot', '2021-05-27', '00:00:00', '', '', '', 'p', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-17 11:50:29', NULL),
(11, 4, 1, '60a25bebd0916', '0000-00-00', 0, 'taxi', 'rajkot to ahmedabad', '2021-06-01', '00:00:00', '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-17 12:04:59', NULL),
(12, 4, 1, '60a25c1155bdb', '0000-00-00', 0, 'taxi', 'rajkot to ahmedabad', '2021-06-01', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-17 12:05:37', NULL),
(13, 4, 1, '60a25c333b454', '0000-00-00', 0, 'taxi', 'rajkot to ahmedabad', '2021-06-01', '00:00:00', '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-17 12:06:11', NULL),
(14, 16, 10, '60a357d2ace22', '2021-05-19', 9, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', NULL, NULL, 'pending', NULL, '2021-05-18 05:59:46', NULL),
(15, 16, 10, '60a35b41de446', '2021-05-19', 11, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-18 06:14:25', NULL),
(16, 16, 10, '60a35f9c9a863', '2021-05-20', 4, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'ongoing', NULL, 'y', 'n', NULL, NULL, 'pending', NULL, '2021-05-18 06:33:00', NULL),
(17, 16, 10, '60a370bb75eaf', '2021-05-20', 6, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-18 07:46:03', NULL),
(19, 4, 1, '60a4e741639e0', '0000-00-00', 0, 'taxi', '', '2021-05-22', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-19 10:24:01', NULL),
(20, 4, 1, '60a507ed7133a', '0000-00-00', 0, 'taxi', 'h demo test', '2021-05-19', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 12, NULL, 'pending', NULL, '2021-05-19 12:43:25', NULL),
(21, 16, 10, '60a64ba61388a', '2021-05-20', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 18, 'offline', 'paid', NULL, '2021-05-20 11:44:38', NULL),
(22, 4, 1, '60a65fb2ae545', '0000-00-00', 0, 'taxi', 'aa', '2021-05-20', '00:00:00', '', '', '', 'a', 'cancel', 'customer', 'y', 'n', NULL, NULL, 'pending', NULL, '2021-05-20 13:10:10', NULL),
(23, 4, 1, '60aba4ce9b7f3', '0000-00-00', 0, 'taxi', 'hhhh hhhh hhhh hhhhh', '2021-05-24', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 12, NULL, 'pending', NULL, '2021-05-24 13:06:22', NULL),
(24, 34, 32, '60afc34c104f7', '2021-05-27', 23, 'mechanic', NULL, NULL, NULL, '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-27 16:05:32', NULL),
(25, 16, 32, '60b0c37aa81e3', '2021-05-28', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'ongoing', NULL, 'y', 'n', NULL, NULL, 'pending', NULL, '2021-05-28 10:18:34', NULL),
(26, 34, 32, '60b0c768ae7c3', '2021-05-28', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-28 10:35:20', NULL),
(27, 4, 32, '60b0e540daf40', '2021-05-28', 21, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-28 12:42:40', NULL),
(28, 16, 32, '60b0e58028928', '2021-05-28', 22, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-28 12:43:44', NULL),
(29, 34, 32, '60b0eadd3e9b7', '2021-05-28', 24, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', 'customer', 'y', 'y', 15, 'online', 'paid', NULL, '2021-05-28 13:06:37', NULL),
(30, 34, 32, '60b0eae1e4632', '2021-05-28', 24, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'y', 'n', NULL, NULL, 'pending', NULL, '2021-05-28 13:06:41', NULL),
(31, 34, 32, '60b0ede5a11b1', '2021-05-28', 20, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', -50, 'offline', 'paid', NULL, '2021-05-28 13:19:33', NULL),
(32, 17, 19, '60b1114d9f98e', '2021-05-31', 15, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 50, NULL, 'pending', NULL, '2021-05-28 15:50:37', NULL),
(33, 34, 32, '60b2244c08ee1', '2021-05-30', 16, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 50, 'online', 'paid', NULL, '2021-05-29 11:23:56', NULL),
(34, 34, 32, '60b224d5dec88', '2021-05-30', 16, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-29 11:26:13', NULL),
(35, 34, 32, '60b24a492fb7a', '2021-05-29', 24, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 10, 'offline', 'paid', NULL, '2021-05-29 14:06:01', NULL),
(36, 34, 32, '60b24a4f787dc', '2021-05-29', 24, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 20, NULL, 'paid', NULL, '2021-05-29 14:06:07', NULL),
(37, 17, 35, '60b282c6cc3b5', '2021-05-30', 17, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-29 18:07:02', NULL),
(38, 17, 39, '60b3f1ed3eb13', '2021-06-02', 12, 'mechanic', NULL, NULL, NULL, '', '', '', 'p', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-30 20:13:33', NULL),
(39, 17, 19, '60b3f2210ac92', '2021-05-31', 14, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-30 20:14:25', NULL),
(40, 17, 19, '60b3f25109dfa', '2021-05-31', 16, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-30 20:15:13', NULL),
(41, 17, 35, '60b3f4b9c752e', '2021-06-01', 8, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-30 20:25:29', NULL),
(42, 17, 37, '60b3f52141da1', '2021-06-19', 10, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-30 20:27:13', NULL),
(43, 17, 41, '60b503384a8d7', '2021-06-09', 11, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-31 15:39:36', NULL),
(44, 17, 41, '60b507dc2e645', '2021-06-17', 9, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'ongoing', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-05-31 15:59:24', NULL),
(45, 34, 44, '60b8b70165c01', '2021-06-03', 21, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 15, 'online', 'paid', NULL, '2021-06-03 11:03:29', NULL),
(46, 16, 44, '60b8b732676b7', '2021-06-05', 21, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:04:18', NULL),
(47, 34, 44, '60b8be5566ccc', '2021-06-03', 22, 'mechanic', NULL, NULL, NULL, '', '', '', 'p', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:34:45', NULL),
(48, 4, 1, '60b8bfe98ecb7', '0000-00-00', 0, 'taxi', 'Rajkot', '2021-06-24', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:41:29', NULL),
(49, 16, 1, '60b8c02318952', '0000-00-00', 0, 'taxi', 'Rajkot', '2021-06-03', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:42:27', NULL),
(50, 16, 44, '60b8c149309e5', '2021-06-04', 17, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:47:21', NULL),
(51, 16, 44, '60b8c27865653', '2021-06-07', 13, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:52:24', NULL),
(52, 34, 44, '60b8c2a2ee767', '2021-06-16', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 11:53:06', NULL),
(53, 34, 44, '60b8ca39b771a', '2021-06-25', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 12:25:29', NULL),
(54, 34, 44, '60b8cf4e90af1', '2021-06-04', 3, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 12:47:10', NULL),
(55, 34, 44, '60b8cf9660dcc', '2021-06-04', 7, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', NULL, NULL, 'pending', NULL, '2021-06-03 12:48:22', NULL),
(56, 34, 44, '60b8d0fe3cb4a', '2021-06-10', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', NULL, NULL, 'pending', NULL, '2021-06-03 12:54:22', NULL),
(57, 34, 44, '60b8d1541b7a8', '2021-06-30', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 12:55:48', NULL),
(58, 34, 44, '60b8d1ba07665', '2021-06-03', 23, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-03 12:57:30', NULL),
(59, 34, 25, '60b9fccc29796', '2021-06-04', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-04 10:13:32', NULL),
(60, 17, 41, '60ba7f47d8d02', '2021-06-30', 17, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 55, 'offline', 'paid', NULL, '2021-06-04 19:30:15', NULL),
(61, 34, 48, '60bb4db857f66', '2021-06-10', 20, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 16, 'offline', 'paid', NULL, '2021-06-05 10:11:04', NULL),
(62, 34, 48, '60bb4ed5901a4', '2021-06-24', 17, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-05 10:15:49', NULL),
(63, 34, 48, '60bb7a9a454a2', '2021-06-18', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-05 13:22:34', NULL),
(64, 17, 41, '60bbb18f59dc1', '2021-06-23', 14, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-05 17:17:03', NULL),
(65, 17, 41, '60bcce4b31ca4', '2021-06-09', 14, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-06 13:31:55', NULL),
(66, 4, 49, '60bdc62b916d8', '0000-00-00', 0, 'taxi', 'fhfd', '2021-06-24', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 100, 'offline', 'paid', NULL, '2021-06-07 07:09:31', '2021-07-05 06:21:00'),
(67, 34, 49, '60be125664bc3', '0000-00-00', 0, 'taxi', '', '2021-06-23', '00:00:00', '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-07 12:34:30', NULL),
(68, 34, 49, '60be138a06aeb', '0000-00-00', 0, 'taxi', '', '2021-06-08', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-07 12:39:38', NULL),
(69, 34, 49, '60be14414d670', '0000-00-00', 0, 'taxi', '', '2021-06-25', '00:00:00', '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-07 12:42:41', NULL),
(70, 34, 49, '60be14daac2e8', '0000-00-00', 0, 'taxi', '', '2021-06-17', '00:00:00', '', '', '', 'a', 'ongoing', NULL, 'y', 'n', NULL, NULL, 'pending', NULL, '2021-06-07 12:45:14', NULL),
(71, 17, 41, '60be8029d6119', '2021-06-09', 11, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 55, NULL, 'pending', NULL, '2021-06-07 20:23:05', NULL),
(72, 17, 41, '60be8916922c8', '2021-06-16', 6, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 22, '', 'pending', NULL, '2021-06-07 21:01:10', '2021-07-07 19:49:00'),
(73, 16, 10, '60bef92ea6793', '2021-06-09', 11, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 10, 'online', 'paid', NULL, '2021-06-08 04:59:26', NULL),
(74, 34, 49, '60bf296da3aea', '0000-00-00', 0, 'taxi', 'test location of texi service provider', '2021-06-08', '00:00:00', '', '', '', 'a', 'ongoing', NULL, 'y', 'n', NULL, NULL, 'pending', NULL, '2021-06-08 08:25:17', NULL),
(75, 34, 49, '60bf33b1751d9', '0000-00-00', 0, 'taxi', 'no', '2021-06-20', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', NULL, NULL, 'pending', NULL, '2021-06-08 09:09:05', NULL),
(76, 34, 25, '60bf3443db389', '2021-06-08', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'p', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-08 09:11:31', NULL),
(77, 34, 49, '60c1b0166c2e7', '0000-00-00', 0, 'taxi', 'gdrg', '2021-06-10', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 22, 'online', 'paid', NULL, '2021-06-10 06:24:22', NULL),
(78, 34, 49, '60c1f1a026e70', '0000-00-00', 0, 'taxi', 'jiu', '2021-06-22', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:04:00', NULL),
(79, 34, 49, '60c1f3110da10', '0000-00-00', 0, 'taxi', 'fef', '2021-06-22', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:10:09', NULL),
(80, 34, 49, '60c1f377a36ab', '0000-00-00', 0, 'taxi', 'gfr', '2021-06-20', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:11:51', NULL),
(81, 34, 49, '60c1f3ea897fc', '0000-00-00', 0, 'taxi', 'vjvj', '2021-06-18', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:13:46', NULL),
(82, 34, 49, '60c1f4329d258', '0000-00-00', 0, 'taxi', ',k', '2021-06-18', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:14:58', NULL),
(83, 34, 49, '60c1f72b8b738', '0000-00-00', 0, 'taxi', 'uvvh', '2021-06-21', '00:00:00', '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:27:39', NULL),
(84, 16, 49, '60c1f768d8a32', '0000-00-00', 0, 'taxi', 'ch', '2021-06-20', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-10 11:28:40', NULL),
(85, 34, 49, '60c1f7ae06b54', '0000-00-00', 0, 'taxi', 'vjj', '2021-06-18', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 5, 'online', 'paid', NULL, '2021-06-10 11:29:50', NULL),
(86, 34, 49, '60c3085773272', '0000-00-00', 0, 'taxi', 'nbhftrh', '2021-06-25', '00:00:00', '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-11 06:53:11', NULL),
(87, 51, 49, '60c320d8d68c6', '0000-00-00', 0, 'taxi', 'grfg', '2021-06-17', '00:00:00', '', '', '', 'a', 'complete', NULL, 'y', 'y', 100, 'offline', 'paid', NULL, '2021-06-11 08:37:44', NULL),
(88, 51, 46, '60c703feb7fdc', '2021-06-14', 6, 'mechanic', NULL, NULL, NULL, '', '', '', 'p', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-14 07:23:42', NULL),
(89, 51, 52, '60c990e1ae26e', '2021-06-22', 20, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 05:49:21', NULL),
(90, 51, 52, '60c9dee778989', '2021-06-17', 9, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 11:22:15', NULL),
(91, 51, 52, '60c9df370e32f', '2021-06-17', 12, 'mechanic', NULL, NULL, NULL, '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 11:23:35', NULL),
(92, 51, 52, '60c9e076d23fc', '2021-06-24', 7, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'provider', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 11:28:54', NULL),
(93, 51, 52, '60c9e0a8476cf', '2021-06-26', 10, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 11:29:44', NULL),
(94, 51, 52, '60c9e1af24e28', '2021-06-17', 9, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 14, 'offline', 'paid', NULL, '2021-06-16 11:34:07', NULL),
(95, 51, 52, '60c9e1c47612d', '2021-06-27', 7, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 5, 'online', 'paid', NULL, '2021-06-16 11:34:28', NULL),
(96, 0, 52, '60c9fe6665d43', '2021-06-24', 4, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'ongoing', NULL, 'y', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 13:36:38', NULL),
(97, 51, 52, '60ca018bb2f9f', '2021-06-23', 5, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'cancel', 'customer', 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-16 13:50:03', NULL),
(98, 16, 10, '60cc59cc73f15', '2021-06-18', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 14, 'online', 'paid', 'This is additional message of service request by customer.', '2021-06-18 08:31:08', NULL),
(99, 16, 1, '60cc742513e0e', '0000-00-00', 0, 'taxi', 'This is extra location details', '2021-06-20', '18:05:00', '', '', '', 'a', 'ongoing', NULL, 'y', 'n', NULL, NULL, 'pending', 'No extra message', '2021-06-18 10:23:33', NULL),
(100, 16, 10, '60cdd32982c4e', '2021-06-21', 20, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 22, 'online', 'paid', 'dummy message', '2021-06-19 11:21:13', NULL),
(101, 17, 41, '60ce2cd017f2f', '2021-06-23', 14, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 33, NULL, 'running', 'Gffffghhfffddssfhjhgfgbhffgggghjjjhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '2021-06-19 17:43:44', NULL),
(102, 51, 52, '60d01bb3be758', '2021-06-21', 20, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-21 04:55:15', NULL),
(103, 51, 52, '60d02b3b5cf59', '2021-06-24', 2, 'mechanic', NULL, NULL, NULL, '', '', '', 'r', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', 'vdf', '2021-06-21 06:01:31', NULL),
(104, 51, 52, '60d02b6954802', '2021-06-21', 15, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', 'hhty', '2021-06-21 06:02:17', NULL),
(105, 51, 52, '60d02b975c539', '2021-06-21', 17, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 11, 'online', 'paid', '', '2021-06-21 06:03:03', NULL),
(106, 51, 52, '60d09a2603b6b', '2021-06-25', 21, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', 'saq', '2021-06-21 13:54:46', NULL),
(107, 51, 52, '60d09f545289a', '2021-06-22', 5, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 501, 'online', 'paid', NULL, '2021-06-21 14:16:52', NULL),
(108, 51, 52, '60d40f9717734', '2021-06-24', 5, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-06-24 04:52:39', NULL),
(109, 51, 52, '60d40fbf871a5', '2021-06-24', 5, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 9, 'online', 'paid', NULL, '2021-06-24 04:53:19', NULL),
(110, 51, 52, '60d413e285848', '2021-06-25', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 14, NULL, 'running', '', '2021-06-24 05:10:58', NULL),
(111, 51, 52, '60e290cbcf5de', '2021-07-05', 22, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 9, 'online', 'paid', NULL, '2021-07-05 04:55:39', NULL),
(112, 16, 10, '60e29aa62be33', '2021-07-05', 14, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 10, '', 'pending', 'message for test', '2021-07-05 05:37:42', '2021-07-05 08:40:00'),
(113, 51, 52, '60e6d911b4559', '2021-07-22', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'upcoming', NULL, 'n', 'n', NULL, NULL, 'pending', NULL, '2021-07-08 10:53:05', NULL),
(114, 51, 52, '60e6d9195c436', '2021-07-22', 19, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 88, 'offline', 'paid', NULL, '2021-07-08 10:53:13', NULL),
(115, 51, 52, '60e6da561d0e5', '2021-07-26', 18, 'mechanic', NULL, NULL, NULL, '', '', '', 'a', 'complete', NULL, 'y', 'y', 55, '', 'pending', NULL, '2021-07-08 10:58:30', '2021-07-08 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_settings`
--

CREATE TABLE `tbl_site_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `constant` varchar(50) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `value` mediumtext NOT NULL,
  `hint` varchar(100) DEFAULT NULL,
  `updated_date` datetime NOT NULL,
  `section` enum('general','api','email','footer','payment','other','statistics','statistics_content') NOT NULL DEFAULT 'other',
  `isActive` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_site_settings`
--

INSERT INTO `tbl_site_settings` (`id`, `label`, `type`, `constant`, `class`, `required`, `value`, `hint`, `updated_date`, `section`, `isActive`) VALUES
(1, 'Site name', 'textBox', 'SITE_NM', 'logintextbox-bg', 1, 'AutoService', NULL, '2014-05-07 12:13:16', 'general', 'y'),
(2, 'Admin Email', 'textBox', 'ADMIN_EMAIL', 'logintextbox-bg', 1, 'pinal.dave@ncrypted.com', NULL, '2014-05-08 12:05:20', 'email', 'y'),
(3, 'Site Logo', 'fileBox', 'SITE_LOGO', 'logintextbox-bg', 0, '2222161871621606882.PNG', NULL, '2014-05-08 00:00:00', 'general', 'y'),
(10, 'Email From Name', 'textBox', 'FROM_NM', 'logintextbox-bg', 1, 'Auto Service Global', NULL, '0000-00-00 00:00:00', 'email', 'y'),
(11, 'From Email', 'textBox', 'FROM_EMAIL', 'logintextbox-bg', 1, 'no-reply@ncryptedprojects.com', NULL, '0000-00-00 00:00:00', 'email', 'y'),
(18, 'Site Favicon', 'fileBox', 'SITE_FAVICON', 'logintextbox-bg', 0, '3531069291617257044.PNG', NULL, '0000-00-00 00:00:00', 'general', 'y'),
(19, 'Facebook Link', 'textBox', 'FB_LINK', 'logintextbox-bg', 1, 'https://www.facebook.com', NULL, '2015-09-03 15:37:05', 'footer', 'y'),
(20, 'Twitter Link', 'textBox', 'TWIITER_LINK', 'logintextbox-bg', 1, 'https://twitter.com', NULL, '2015-09-03 15:37:58', 'footer', 'y'),
(22, 'Google Plus', 'textBox', 'GPLUS_LINK', 'logintextbox-bg', 1, 'https://plus.google.com/+NCryptedTechnologies', NULL, '2015-09-03 15:39:32', 'footer', 'n'),
(23, 'Linkedin', 'textBox', 'LINKEDIN_LINK', 'logintextbox-bg', 1, 'https://www.linkedin.com', NULL, '2015-09-03 15:39:32', 'footer', 'y'),
(28, 'SMTP Host', 'textBox', 'SMTP_HOST', 'logintextbox-bg', 1, 'mail.ncryptedprojects.com', NULL, '2016-07-08 04:00:00', 'email', 'y'),
(29, 'SMTP Port', 'textBox', 'SMTP_PORT', 'logintextbox-bg', 1, '587', NULL, '0000-00-00 00:00:00', 'email', 'y'),
(30, 'SMTP Username', 'textBox', 'SMTP_USERNAME', 'logintextbox-bg', 1, 'no-reply@ncryptedprojects.com', NULL, '0000-00-00 00:00:00', 'email', 'y'),
(31, 'SMTP Password', 'password', 'SMTP_PASSWORD', 'logintextbox-bg', 1, 'y5p5_Q+Y*72T', NULL, '0000-00-00 00:00:00', 'email', 'y'),
(38, ' Google Recaptcha API Site key ', 'textBox', 'GOOGLE_RECAPTCHA_KEY', 'logintextbox-bg', 1, '6LdFA6waAAAAALBQKw_eG0X1ibWyUki8qyqdsPs1', NULL, '0000-00-00 00:00:00', 'api', 'y'),
(39, 'Google Recaptcha Secret Key', 'textBox', 'GOOGLE_RECAPTCHA_SECRET_KEY', 'logintextbox-bg', 1, '6LdFA6waAAAAANX5VeCYFLmDVUh4vePL06lLpdVj', NULL, '0000-00-00 00:00:00', 'api', 'y'),
(40, 'Footer Text', 'textArea', 'FOOTER_COPYRIGHT', 'logintextbox-bg', 1, '< b>Copyright © 2021. All Rights Reserved.< /b>', NULL, '2015-09-03 15:39:32', 'footer', 'y'),
(42, 'Paypal Email', 'textBox', 'PAYPAL_EMAIL', 'logintextbox-bg', 1, 'test@ncrypted.com', NULL, '2015-09-03 15:39:32', 'payment', 'n'),
(43, 'Paypal Currency Code', 'textBox', 'PAYPAL_CURRENCY_CODE', 'logintextbox-bg', 1, 'USD', NULL, '2015-09-03 15:39:32', 'payment', 'y'),
(44, 'Currency Symbol', 'textBox', 'CURRENCY_SIGN', 'logintextbox-bg', 1, '$', NULL, '2015-09-03 15:39:32', 'payment', 'n'),
(45, 'Paypal URL', 'textBox', 'PAYPAL_URL', 'logintextbox-bg', 1, 'https://www.sandbox.paypal.com/cgi-bin/webscr', NULL, '2015-09-03 15:39:32', 'payment', 'y'),
(48, 'Scroll Limit', 'textBox', 'SCROLL_LIMIT', 'logintextbox-bg', 1, '8', NULL, '2015-09-03 15:39:32', 'other', 'y'),
(52, 'Tomtom API Key', 'textBox', 'TOMTOM_KEY', 'logintextbox-bg', 1, 'rYaUpWvwhl4rJLC22XOG4ArbbUb0TX6S', NULL, '0000-00-00 00:00:00', 'api', 'y'),
(62, 'Service Commission', 'textBox', 'SERVICE_COMM', 'logintextbox-bg', 1, '50', NULL, '2015-09-03 15:39:32', 'other', 'n'),
(63, 'Google Maps API Key', 'textBox', 'GOOGLE_MAP_KEY', 'logintextbox-bg', 1, 'AIzaSyCu0zRb1nyp7q2V2NT9zicWg7wrtnKmxPg', NULL, '0000-00-00 00:00:00', 'api', 'n'),
(64, 'Nearby Radius(In KM)', 'textBox', 'NEARBY_RADIUS', 'logintextbox-bg', 1, '250', NULL, '2015-09-03 15:39:32', 'other', 'y'),
(65, 'VINDecoder API Key', 'textBox', 'VIN_API_KEY', 'logintextbox-bg', 1, '5de0829f05e3', NULL, '0000-00-00 00:00:00', 'api', 'y'),
(66, 'VINDecoder Secret Key', 'textBox', 'VIN_SECRET_KEY', 'logintextbox-bg', 1, '5baece36b5', NULL, '0000-00-00 00:00:00', 'api', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subadmin_action`
--

CREATE TABLE `tbl_subadmin_action` (
  `id` int(11) NOT NULL,
  `constant` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_subadmin_action`
--

INSERT INTO `tbl_subadmin_action` (`id`, `constant`, `title`, `created_date`, `updated_date`) VALUES
(1, 'module', 'Module', '2015-05-13 00:00:00', '2015-05-13 09:50:34'),
(2, 'add', 'Add', '2015-04-29 00:00:00', '2015-05-13 09:50:31'),
(3, 'edit', 'Edit', '2015-04-29 00:00:00', '2015-05-13 09:50:29'),
(4, 'delete', 'Delete', '2015-04-29 00:00:00', '2015-05-13 09:50:25'),
(5, 'view', 'View', '2015-04-29 00:00:00', '2015-05-13 09:50:22'),
(6, 'status', 'Status', '2015-05-16 00:00:00', '2015-05-16 10:10:53'),
(7, 'import', 'Import', '2015-06-17 00:00:00', '2015-06-17 09:58:20'),
(8, 'export', 'Export', '2015-06-17 00:00:00', '2015-06-17 09:58:20'),
(9, 'reply', 'Reply', '2016-05-06 01:07:06', '2016-05-06 07:01:01'),
(10, 'viewComments', 'View Comments', '2016-05-07 00:00:00', '2016-05-07 06:40:02'),
(11, 'sendNL', 'Send Newsletter', '2016-05-12 00:00:00', '2018-02-05 09:04:25'),
(12, 'review_of_the_day', 'Set review as review of the day', '2016-06-03 00:00:00', '2016-06-03 05:26:37'),
(13, 'show_in_left_menu', 'Show in Left Menu', '2018-02-05 01:36:00', '2018-02-04 20:06:00'),
(14, 'manage_fields', 'Manage Fields', '2018-02-05 01:36:00', '2018-02-04 20:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` enum('provider','customer') NOT NULL DEFAULT 'customer',
  `service_type` enum('mechanic','taxi') NOT NULL DEFAULT 'mechanic',
  `vehicle_type` enum('car','bike','both') NOT NULL DEFAULT 'both',
  `firstName` varchar(250) NOT NULL,
  `lastName` varchar(250) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `profileImg` varchar(255) DEFAULT NULL,
  `contactNo` bigint(20) DEFAULT NULL,
  `business_name` varchar(200) NOT NULL,
  `paypalEmail` varchar(50) DEFAULT NULL,
  `address` text CHARACTER SET utf8,
  `addLat` double(11,8) DEFAULT NULL,
  `addLong` double(11,8) DEFAULT NULL,
  `walletAmount` double(12,6) UNSIGNED NOT NULL DEFAULT '0.000000',
  `isActive` enum('y','n','d','r') NOT NULL DEFAULT 'n' COMMENT 'y = yes; n =no;d=admin block;r=remove',
  `isEmailVerify` enum('y','n') NOT NULL DEFAULT 'n',
  `isAvailability` enum('y','n') NOT NULL DEFAULT 'y' COMMENT 'For Availability',
  `emailVerifyCode` varchar(255) CHARACTER SET utf8 NOT NULL,
  `new_email_id` varchar(50) NOT NULL,
  `new_email_status` enum('y','n') NOT NULL DEFAULT 'y',
  `hash` varchar(100) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ipAddress` varchar(32) DEFAULT NULL,
  `defLanguage` int(11) DEFAULT NULL,
  `second_step_complete` enum('y','n') NOT NULL DEFAULT 'n',
  `mizutech_name` varchar(100) DEFAULT NULL,
  `mizutech_pwd` varchar(100) DEFAULT NULL,
  `user_status` text,
  `vehi_brand` varchar(100) DEFAULT NULL,
  `vehi_model` varchar(100) DEFAULT NULL,
  `vehi_year` varchar(100) DEFAULT NULL,
  `vehi_engine` varchar(100) DEFAULT NULL,
  `vehi_mileage` varchar(100) DEFAULT NULL,
  `opening_hours` varchar(200) DEFAULT NULL,
  `business_details` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `service_type`, `vehicle_type`, `firstName`, `lastName`, `email`, `password`, `profileImg`, `contactNo`, `business_name`, `paypalEmail`, `address`, `addLat`, `addLong`, `walletAmount`, `isActive`, `isEmailVerify`, `isAvailability`, `emailVerifyCode`, `new_email_id`, `new_email_status`, `hash`, `createdDate`, `ipAddress`, `defLanguage`, `second_step_complete`, `mizutech_name`, `mizutech_pwd`, `user_status`, `vehi_brand`, `vehi_model`, `vehi_year`, `vehi_engine`, `vehi_mileage`, `opening_hours`, `business_details`) VALUES
(1, 'provider', 'taxi', '', 'test', 'user', 'pinal.dave@ncrypted.com', 'e10adc3949ba59abbe56e057f20f883e', '4774660071622888779.png', 9876543140, 'Demo', 'test4@ncrypted.com', 'Ahmedabad, Gujarat', 23.01451000, 72.59176000, 93.000000, 'y', 'y', 'n', '', '', 'y', '', '2020-10-07 07:30:51', NULL, NULL, 'y', 'pinal', 'mizutechpwd@12', 'test of status', '', '', '', '', '', 'asasd', 'lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h lorem ipsum demo h'),
(4, 'customer', 'mechanic', '', 'grishma', 'nandaniya', 'grishma.nandaniya@ncrypted.com', 'e10adc3949ba59abbe56e057f20f883e', '15580537011622723696.png', 9876543141, '', 'test1@ncrypted.com', '', 0.00000000, 0.00000000, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2020-10-07 07:30:51', NULL, NULL, 'y', 'grishma', 'mizutechpwd@12', NULL, 'Hyundai', 'Excent', '2014', '1234567899', NULL, NULL, NULL),
(5, 'provider', 'mechanic', 'both', 'p11', 'd11', 'p11@nc.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 1234567899, 'test', NULL, 'Amreli, Gujarat, India', 21.60150000, 71.22040000, 0.000000, 'y', 'y', 'n', '', '', 'y', 'MTYyMDYzMDI1MQ==', '2021-02-22 11:56:59', '::1', NULL, 'y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'provider', 'mechanic', 'both', 'p22', 'p22', 'p22@q.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 1234567889, '', NULL, NULL, NULL, NULL, 0.000000, 'y', 'y', 'y', '2d79114592ca10ec997a07786df21659', '', 'y', '', '2021-02-22 12:00:20', '::1', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'provider', 'mechanic', 'bike', 'p33', 'p33', 'qa@msdafsw.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 1221344356, '', NULL, NULL, NULL, NULL, 0.000000, 'n', 'n', 'y', '367df048f4553417224a53784132147f', '', 'y', '', '2021-02-22 12:01:09', '::1', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'provider', 'mechanic', 'car', 'Test 1', 'Provider', 'provider@mailinator.com', '93279e3308bdbbeed946fc965017f67a', '19766150901624431888.png', 7621887788, 'Import Export', 'test1@ncrypted.com', 'Kuvadva Road, Jaiprakash Nagar, Rajkot 360003, Gujarat', 22.31167000, 70.82887000, 0.000000, 'y', 'y', 'y', 'MTYxNTc4NzcxOQ==', '', 'n', '', '2021-03-08 09:45:48', '49.34.176.143', NULL, 'y', 'providertest', 'mizutechpwd@123', 'New Delhi India', '', '', '', '', '', '09:00 to 18:00', 'Dummy business detail'),
(16, 'customer', 'mechanic', '', 'Test', 'Customer', 'customer@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', '5745485821620739469.png', 6596857496, '', '', '', 0.00000000, 0.00000000, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2021-03-26 04:34:39', '157.32.115.3', NULL, 'y', 'customertest', 'mizutechpwd@123', NULL, 'Tata', 'Tata Motors', '2001', 'ER12345', '60', NULL, NULL),
(17, 'customer', 'mechanic', '', 'Richard', 'Pompa', 'richardpompa@mail.com', 'be3da3dda503076f903df0b21495bfc3', NULL, 7550870383, '', '', '', 0.00000000, 0.00000000, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2021-04-09 21:52:10', '90.197.234.186', NULL, 'y', NULL, NULL, NULL, 'renault', 'kangoo', '2003', '-', '', NULL, NULL),
(24, 'provider', 'mechanic', 'both', 'test1', 'user1', 'pinal1.dave1@ncrypted.com', 'e10adc3949ba59abbe56e057f20f883e', '', 9876543143, 'Demo', 'test1@ncrypted.com', 'Gandhinagar District, Gujarat', 23.23337000, 72.59283000, 93.000000, 'y', 'y', 'y', 'MTYxNTI5MDE4Mg==', 'pinal.dave@ncrypted.com', 'y', 'MTYxNTI2NjM1Mw==', '2020-10-07 07:30:51', NULL, NULL, 'y', 'pinal', 'mizutechpwd@12', 'tomorrow not available', '', '', '', '', NULL, NULL, NULL),
(25, 'provider', 'mechanic', 'both', 'test2', 'user2', 'pinal2.dave2@ncrypted.com', 'e10adc3949ba59abbe56e057f20f883e', '4488345281624431215.png', 9876543145, 'Demo2', 'test1@ncrypted.com', 'Gandhinagar District, Gujarat', 23.23337000, 72.59283000, 93.000000, 'y', 'y', 'n', 'MTYxNTI5MDE4Mg==', 'pinal.dave@ncrypted.com', 'y', 'MTYxNTI2NjM1Mw==', '2020-10-07 07:30:51', NULL, NULL, 'y', 'pinal', 'mizutechpwd@12', 'test of status', '', '', '', '', NULL, NULL, NULL),
(34, 'customer', '', '', 'test1', 'Customer1', 'parina.test3@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '7006712021622782993.png', 7896541230, '', '', '', 0.00000000, 0.00000000, 0.000000, 'r', 'y', 'y', 'MTYyMjg4ODQyOA==', '', 'n', '', '2021-05-20 07:49:48', '27.61.142.254', 1, 'y', 'test', 'test', NULL, 'Vbrand', 'VModel', '2000', '123456ve', '', NULL, NULL),
(36, 'customer', '', '', 'bhg', 'fhfgh', 'pinal.dave3@ncrypted.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 9797979797, '', NULL, NULL, NULL, NULL, 0.000000, 'n', 'n', 'y', 'facac1463b6fd5fb6efc2a9701243a5f', '', 'y', '', '2021-05-29 12:39:02', '219.91.225.229', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'provider', 'mechanic', 'car', 'Lincoln', 'Auto', 'Lincolnauto.x@gmail.com', 'd6e89b0403d825403082200fe0129942', '9007285711622377774.png', 7404177876, '', NULL, NULL, NULL, NULL, 0.000000, 'y', 'y', 'n', '', '', 'y', '', '2021-05-29 22:07:58', '86.146.190.190', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'customer', '', '', 'Kay', 'Cee', 'gr11nchh@gmail.com', 'b1e7367b4327d4642221d88e9a4e4bcf', NULL, 7719161727, '', NULL, NULL, NULL, NULL, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2021-05-30 16:18:07', '82.132.222.13', NULL, 'y', NULL, NULL, NULL, 'Audi', 'S5', '2017', '', NULL, NULL, NULL),
(39, 'provider', 'mechanic', 'both', 'Lincoln', 'Autos', 'Lincolnauto.br@gmail.com', 'd6e89b0403d825403082200fe0129942', '1539796651622393109.png', 1522394798, 'Lincoln Auto & Body repair', NULL, NULL, NULL, NULL, 0.000000, 'y', 'y', 'n', '', '', 'y', '', '2021-05-30 16:34:36', '82.132.222.13', NULL, 'y', NULL, NULL, NULL, '', '', '', '', NULL, NULL, NULL),
(40, 'provider', 'mechanic', 'both', 'Rich', 'Pompa', 'richardpompa@centrum.sk', 'be3da3dda503076f903df0b21495bfc3', NULL, 421908554527, '', NULL, NULL, NULL, NULL, 0.000000, 'y', 'n', 'y', 'dc79969dc1bdb2b27089e9b7ca9c57f2', '', 'y', '', '2021-05-31 15:17:34', '90.194.151.215', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'provider', 'mechanic', '', 'Richard', 'Pom', 'richardpompa9473@gmail.com', 'be3da3dda503076f903df0b21495bfc3', '6869932101622977686.png', 7550870384, 'AutoPom', 'richardpompa@mail.com', 'United Kingdom', 51.50015000, -0.12624000, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2021-05-31 15:25:10', '90.194.151.215', 4, 'y', NULL, NULL, 'welcome', '', '', '', '', '', NULL, NULL),
(44, 'provider', 'mechanic', 'both', 'mech', 'tech', 'parina.test2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '13125843501622717156.png', 1234567891, 'Test Business', 'test5@ncrypted.com', 'Ahmedabad, Gujarat', 23.01451000, 72.59176000, 0.000000, 'r', 'y', 'y', '', '', 'y', 'MTYyNTc0MTE4Mw==', '2021-06-02 14:02:29', '106.213.192.156', NULL, 'y', 'pinal', 'mizutechpwd@12', NULL, '', '', '', '', NULL, NULL, NULL),
(45, 'customer', 'mechanic', 'both', 'Demo', 'Customer', 'demo@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 69696986869, '', NULL, NULL, NULL, NULL, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2021-06-03 06:23:22', '157.32.69.24', NULL, 'y', NULL, NULL, NULL, 'Toyota', 'Test', '2000', 'dhjjjd', NULL, NULL, NULL),
(46, 'provider', 'mechanic', 'bike', 'mech', 'test', 'parina.raiyani@ncrypted.com', 'e10adc3949ba59abbe56e057f20f883e', '12139695071622813424.png', 1234567898, 'bn', 'test5@ncrypted.com', 'Ahmedabad, Gujarat', 23.01451000, 72.59176000, 0.000000, 'y', 'y', 'n', 'MTYyMjgxMzc1Mg==', '', 'n', '', '2021-06-04 11:33:48', '106.222.14.175', NULL, 'y', NULL, NULL, 'ok', '', '', '', '', '', NULL, NULL),
(47, 'customer', 'mechanic', 'both', 'Demo', 'Test', 'demo1@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 343434343434, '', NULL, NULL, NULL, NULL, 0.000000, 'r', 'y', 'y', 'MTYyMjg3MzQwMA==', '', 'n', '', '2021-06-05 05:42:40', '157.32.74.71', NULL, 'y', NULL, NULL, NULL, 'Toyota', 'Xyz', '1992', '12345', '', NULL, NULL),
(48, 'provider', 'mechanic', 'car', 'sdds', 'dsad', 'parina.test2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '7852069271622884478.png', 1234567891, 'bn', 'test5@ncrypted.com', 'Ahmedabad, Gujarat', 23.01451000, 72.59176000, 0.000000, 'r', 'y', 'y', '', '', 'y', 'MTYyNTc0MTE4Mw==', '2021-06-05 09:12:28', '27.61.128.255', NULL, 'y', 'pinal', 'mizutechpwd@12', 'test', '', '', '', '', '', NULL, NULL),
(49, 'provider', 'taxi', '', 'tax', 'service', 'patelparina646@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '6815049501622901038.png', 1234567895, 'taxi bn', 'test5@ncrypted.com', 'Ahmedabad, Gujarat', 23.01451000, 72.59176000, 0.000000, 'r', 'y', 'n', 'MTYyMzY0NjE2NA==', '', 'n', '', '2021-06-05 13:40:09', '27.61.128.255', NULL, 'y', 'pinal', 'mizutechpwd@12', 'status', '', '', '', '', '', NULL, NULL),
(50, 'provider', 'taxi', 'both', 'Adam', 'Pompa', 'richardpompa@yahoo.com', 'be3da3dda503076f903df0b21495bfc3', NULL, 7849827488, 'Rich Taxi', NULL, NULL, NULL, NULL, 0.000000, 'y', 'y', 'n', '', '', 'y', '', '2021-06-06 18:18:09', '82.132.222.38', NULL, 'y', NULL, NULL, 'we offer 10% discount for students', '', '', '', '', '', 'Monday 08-17 \nTuesday 08-17\nWednesday 08-17\nThursday 08-17', NULL),
(51, 'customer', '', '', 'tsert', 'cust', 'parina.test3@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '15098509701623399787.png', 12345678954, '', '', '', 0.00000000, 0.00000000, 0.000000, 'y', 'y', 'y', '', '', 'y', '', '2021-06-11 08:18:39', '27.61.228.207', NULL, 'y', 'grishma', 'mizutechpwd@12', NULL, 'Dgsti', 'Gxg', '8858', 'xfhx', 'vvh', NULL, ''),
(52, 'provider', 'mechanic', 'car', 'Testm', 'Userm', 'parina.test2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '14650670841625741512.png', 1234567895, 'Bb', 'test5@ncrypted.com', 'Rajkot, Gujarat', 22.29768000, 70.78746000, 0.000000, 'y', 'y', 'n', 'MTYyNTQ1OTE5NQ==', 'parina.raiyani38@gmail.com', 'n', '', '2021-06-14 05:13:10', '27.61.228.251', NULL, 'y', 'pinal', 'mizutechpwd@12', 'fsdfdsfdf', '', '', '', '', '', 'dsfsd', ''),
(53, 'provider', 'mechanic', 'car', 'Holo', 'Bar', 'xyz@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 64646464646464, '', NULL, 'Australia, Saltillo, Coahuila', 25.39504000, -101.02492000, 0.000000, 'r', 'n', 'y', 'e364783e1f5eb66838b420ef182c712c', '', 'y', '', '2021-06-14 11:58:36', '49.34.168.246', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'provider', 'mechanic', 'bike', 'dwe', 'ewerw', 'parina.test5@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 6546576676546, '', NULL, '', 0.00000000, 0.00000000, 0.000000, 'y', 'n', 'y', '477ec2e5983d760a5bae52a0994cad81', '', 'y', '', '2021-06-16 04:43:13', '27.61.228.209', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'provider', 'mechanic', 'bike', '6yu7t', 'yut', 'parina.test2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 5465676767, '', NULL, 'Ahmedabad, Gujarat', 23.01451000, 72.59176000, 0.000000, 'r', 'n', 'y', '63f2c85af9c5ea915322f1b09fdff992', '', 'y', 'MTYyNTc0MTE4Mw==', '2021-06-16 13:22:22', '106.205.247.94', NULL, 'n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'customer', 'mechanic', 'both', 'Demo_35', 'Customer_77', 'test@mailinator.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 64646464664, '', NULL, '', 0.00000000, 0.00000000, 0.000000, 'r', 'y', 'y', '', '', 'y', '', '2021-06-22 04:38:41', '49.34.152.227', NULL, 'y', 'customertest', 'mizutechpwd@123', NULL, 'Tata', 'Sksjs', '6464', 'hshdhhdjdjd', '73', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_tokens`
--

CREATE TABLE `tbl_users_tokens` (
  `id` int(11) NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `device_id` varchar(500) NOT NULL,
  `device_type` enum('a','i','w') NOT NULL DEFAULT 'a',
  `isLoggedIn` enum('y','n') NOT NULL DEFAULT 'y',
  `createdDate` datetime NOT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users_tokens`
--

INSERT INTO `tbl_users_tokens` (`id`, `userId`, `device_id`, `device_type`, `isLoggedIn`, `createdDate`, `updatedDate`) VALUES
(1, 1, '123', 'a', 'y', '2021-02-20 13:56:31', '2021-03-24 13:48:48'),
(2, 8, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-03-08 13:58:24', '2021-03-08 14:55:57'),
(3, 9, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-03-08 15:00:28', '2021-03-08 15:07:51'),
(4, 10, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-03-08 15:18:49', '2021-05-29 17:40:19'),
(5, 5, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-03-12 09:58:57', '2021-04-29 16:35:31'),
(6, 15, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-03-20 19:03:17', '2021-03-24 18:01:26'),
(7, 16, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-03-26 10:06:54', '2021-05-29 09:25:38'),
(8, 19, 'f_8LjOTdT9mX4Q0xOqJSnu:APA91bFwW_I_QHCSjqkRmDGePxILeIJerrlWKAV6rMu5AxbRPVyRVEVpjj1yEtyo-tuiZ6yhin38RCdB7spv-OV73kNaqnQPrPewQX0hLkMmoLRCTvON_-bsKLy2XXLMVIS66wO9CFNe', 'a', 'y', '2021-04-10 03:37:28', '2021-04-17 16:45:26'),
(9, 1, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-04-27 11:01:00', '2021-05-29 15:23:27'),
(10, 21, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-05-01 14:20:58', '2021-05-01 15:20:11'),
(11, 22, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-05-01 15:23:49', '2021-05-01 15:44:32'),
(12, 23, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-05-01 15:49:14', '2021-05-01 18:10:00'),
(13, 4, 'c6BSlrfhRCuUbG4DhU52lq:APA91bHTFAkkF4n2j5_lRR0605XHcKkuGrm1OI15E2--GXZCZIkDpCwTmQfav7CYrQzeqR9BF4dI6WrGaIWdOK7IpFNifel5uPy_qM6o2mE8rWORd99BMFoR9Vngs3fzMeXLoCVtTwZ8', 'a', 'n', '2021-05-17 12:15:10', '2021-05-26 13:15:36'),
(14, 17, 'cuExQwW_QI-YLf-EwC0vlj:APA91bFFf-ZbA9tyr59cjsQruPA2dRnTk2APzTpA-5l-w7v6k08x1SnOHgJoAjTcE6TbD2aEN2H_IDREFH-Y0ncpKXCXT3HK6kJhYch9WNvQWUmixFFCDtiuESCMtBVEcYtIdHoHs4Yn', 'a', 'n', '2021-05-28 17:09:58', '2021-06-16 01:52:28'),
(15, 19, 'cuExQwW_QI-YLf-EwC0vlj:APA91bFFf-ZbA9tyr59cjsQruPA2dRnTk2APzTpA-5l-w7v6k08x1SnOHgJoAjTcE6TbD2aEN2H_IDREFH-Y0ncpKXCXT3HK6kJhYch9WNvQWUmixFFCDtiuESCMtBVEcYtIdHoHs4Yn', 'a', 'n', '2021-05-28 21:09:08', '2021-05-31 20:44:54'),
(16, 16, 'cHNL0tMuTgeINzidQ7Hoyx:APA91bG3TWoxkDD-qao4i1n9cw8ym3gv-3eWpNBvjBvoSxsYnxup5TvBJcRCWDs8TTF6LPz3qBQXAK5Pn4gMipX2hBXb0Lb4VVk23ABW7j0sqJAKwzTKkWsK25y_sEIHZYbczQ33zkl_', 'a', 'n', '2021-05-29 18:20:42', '2021-06-04 11:52:45'),
(17, 32, 'fQ1QLhXkQzeYb-vi34oqaK:APA91bESc1eNeW_4c-LGuhkq4DlCVlAMXOJsL9L7bAl6inKI9-i8HqDGCinwmvBwcc1PXPiPxKlvD3XQ8QM02CCmFn4Av792vfh98AoEdAHXT9yM7Wr1SwLO1CARPOba_5lUaRsruQRy', 'a', 'y', '2021-05-31 18:19:41', '2021-05-31 18:53:58'),
(18, 41, 'cuExQwW_QI-YLf-EwC0vlj:APA91bFFf-ZbA9tyr59cjsQruPA2dRnTk2APzTpA-5l-w7v6k08x1SnOHgJoAjTcE6TbD2aEN2H_IDREFH-Y0ncpKXCXT3HK6kJhYch9WNvQWUmixFFCDtiuESCMtBVEcYtIdHoHs4Yn', 'a', 'y', '2021-05-31 20:56:43', '2021-06-18 01:51:59'),
(19, 5, 'coOjMXtPQ2ezs1R00pgoTK:APA91bF_UwCqxXWYnBRMaO-uc09AMThMUYa2iuesrZrMtW-vQAqPnY1rpLtdVdJWUylbcgD4qtp61YYYru_AIrPrygOBA7pDBtXE4V4gz7QmIDSmVok6dqTHMKl52V4XWOtgVokPZZ4D', 'a', 'n', '2021-06-02 19:01:39', '2021-06-02 19:05:56'),
(20, 44, 'coOjMXtPQ2ezs1R00pgoTK:APA91bF_UwCqxXWYnBRMaO-uc09AMThMUYa2iuesrZrMtW-vQAqPnY1rpLtdVdJWUylbcgD4qtp61YYYru_AIrPrygOBA7pDBtXE4V4gz7QmIDSmVok6dqTHMKl52V4XWOtgVokPZZ4D', 'a', 'y', '2021-06-02 19:34:11', '2021-06-04 11:24:53'),
(21, 45, 'cHNL0tMuTgeINzidQ7Hoyx:APA91bG3TWoxkDD-qao4i1n9cw8ym3gv-3eWpNBvjBvoSxsYnxup5TvBJcRCWDs8TTF6LPz3qBQXAK5Pn4gMipX2hBXb0Lb4VVk23ABW7j0sqJAKwzTKkWsK25y_sEIHZYbczQ33zkl_', 'a', 'y', '2021-06-03 12:07:04', '2021-06-03 12:13:46'),
(22, 16, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'y', '2021-06-04 15:19:41', '2021-07-05 14:04:48'),
(23, 44, 'ct7YXoNMRD-KUcwv-Gabzz:APA91bE73jLpaf3EvhB8fn21MNg8sgxVA5ye-57siLbteaKOzTT2b9iVqPpPaxt4TEFb0EhwIhWdFsMe5r6-BCf7f8g29-r_bVFpsxZFwxOl79XFYNScTuBi-5HWwoX0QED3cUzTt87N', 'a', 'y', '2021-06-04 15:28:43', '2021-06-04 15:34:10'),
(24, 46, 'ct7YXoNMRD-KUcwv-Gabzz:APA91bE73jLpaf3EvhB8fn21MNg8sgxVA5ye-57siLbteaKOzTT2b9iVqPpPaxt4TEFb0EhwIhWdFsMe5r6-BCf7f8g29-r_bVFpsxZFwxOl79XFYNScTuBi-5HWwoX0QED3cUzTt87N', 'a', 'y', '2021-06-04 18:11:41', '2021-06-04 19:01:28'),
(25, 10, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'n', '2021-06-04 18:36:22', '2021-06-25 18:55:37'),
(26, 47, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'n', '2021-06-05 11:13:16', '2021-06-05 13:57:54'),
(27, 1, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'n', '2021-06-05 18:20:01', '2021-06-09 19:02:43'),
(28, 50, 'cuExQwW_QI-YLf-EwC0vlj:APA91bFFf-ZbA9tyr59cjsQruPA2dRnTk2APzTpA-5l-w7v6k08x1SnOHgJoAjTcE6TbD2aEN2H_IDREFH-Y0ncpKXCXT3HK6kJhYch9WNvQWUmixFFCDtiuESCMtBVEcYtIdHoHs4Yn', 'a', 'n', '2021-06-06 23:52:06', '2021-06-08 01:54:37'),
(29, 49, 'ct7YXoNMRD-KUcwv-Gabzz:APA91bE73jLpaf3EvhB8fn21MNg8sgxVA5ye-57siLbteaKOzTT2b9iVqPpPaxt4TEFb0EhwIhWdFsMe5r6-BCf7f8g29-r_bVFpsxZFwxOl79XFYNScTuBi-5HWwoX0QED3cUzTt87N', 'a', 'y', '2021-06-07 13:51:19', '2021-06-09 15:46:27'),
(30, 1, 'fiMUuebAT-q2-Ljx79gJKL:APA91bE3RPI1-mE4BCtWWJVtsSh-2nd2GO8IiKBMqXYik2h9VRndEpUmhbZ-Y5D7jhqxsfiCY8nRUxVSOpDHXTuL2sIbTD7xfZdPNIoUhDNP9BivV3d4dgQi1QiRkRlBqmkCV-xRcYoh', 'a', 'y', '2021-06-07 16:43:12', '2021-06-18 12:37:49'),
(31, 4, 'fiMUuebAT-q2-Ljx79gJKL:APA91bE3RPI1-mE4BCtWWJVtsSh-2nd2GO8IiKBMqXYik2h9VRndEpUmhbZ-Y5D7jhqxsfiCY8nRUxVSOpDHXTuL2sIbTD7xfZdPNIoUhDNP9BivV3d4dgQi1QiRkRlBqmkCV-xRcYoh', 'a', 'n', '2021-06-07 16:44:23', '2021-06-07 16:50:24'),
(32, 34, 'ct7YXoNMRD-KUcwv-Gabzz:APA91bE73jLpaf3EvhB8fn21MNg8sgxVA5ye-57siLbteaKOzTT2b9iVqPpPaxt4TEFb0EhwIhWdFsMe5r6-BCf7f8g29-r_bVFpsxZFwxOl79XFYNScTuBi-5HWwoX0QED3cUzTt87N', 'a', 'n', '2021-06-08 14:19:04', '2021-06-09 12:57:55'),
(33, 45, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'n', '2021-06-08 17:23:02', '2021-06-08 17:28:40'),
(34, 34, 'cNXCxojjRkaMHhaCgBD5vL:APA91bH_dT42m4RxHsMlHK9z6pWN92vSyfd-ftQgarto-iGPyI0XU0jG1gVqDvvM8gBWKBxCMBT5eqBaJhpacZ9B4gexpA9-bFZOnfkOSiNNHYeQFMV7rg_pTwTYaUsxV8l61mjM-K6x', 'a', 'y', '2021-06-09 15:48:22', '2021-06-10 10:21:58'),
(35, 34, 'fjkoBRAjQpSB5bA4FktAMg:APA91bFB1FDdnuv9_WDZ_RC1l6NptfE70ugJ3v_RJccS0n4rIfkFQRurn_7ELFzLr4ewn7jkpXDo6yadyaAfNMFVfY5kP3RNPTC27rrrAXDM4YmJlK55uygKnN8gExWSArV8Q61LzfT7', 'a', 'n', '2021-06-10 11:19:09', '2021-06-11 12:25:25'),
(36, 49, 'fjkoBRAjQpSB5bA4FktAMg:APA91bFB1FDdnuv9_WDZ_RC1l6NptfE70ugJ3v_RJccS0n4rIfkFQRurn_7ELFzLr4ewn7jkpXDo6yadyaAfNMFVfY5kP3RNPTC27rrrAXDM4YmJlK55uygKnN8gExWSArV8Q61LzfT7', 'a', 'n', '2021-06-10 15:04:38', '2021-06-14 10:18:51'),
(37, 49, 'dJhCrAG9StKqm1evPvozhW:APA91bGis_hdRmmwyfep804rDnoAZWjOEpbtU-k3jXKfCPOTrYwzQpna38CVU16vdlRjLYr-sr8ISsqcX7OaJovCvbGknEVEnOz-5eGQ-nrtYzETaMeRXNvmNM-2fOerxxm4ueF44Qo4', 'a', 'y', '2021-06-10 15:41:31', '2021-06-10 15:41:31'),
(38, 52, 'cvizHqmCRMmnI7C62xfNmO:APA91bGL69ySjlsyy0zNLLIZ9oFBfs0IMG7Oh5BHkeCxuxHuxBgmvDWsRaXc-5o8lii-TvKYHL7lyug7kzv8cOcBAdnesJfqxs8bIo4TOd-DGef96JTzdbhNij5hwxMjUyDP5J4hamnQ', 'a', 'y', '2021-06-14 12:16:44', '2021-06-15 14:19:28'),
(39, 51, 'cvizHqmCRMmnI7C62xfNmO:APA91bGL69ySjlsyy0zNLLIZ9oFBfs0IMG7Oh5BHkeCxuxHuxBgmvDWsRaXc-5o8lii-TvKYHL7lyug7kzv8cOcBAdnesJfqxs8bIo4TOd-DGef96JTzdbhNij5hwxMjUyDP5J4hamnQ', 'a', 'n', '2021-06-14 12:27:04', '2021-06-15 14:13:56'),
(40, 52, 'cLbiopkxS7WYjYdSUXszd2:APA91bHURknU-5o-ci1YxLfthyb9zOQEr-tGv3VMjn9ByTvI_2p8zr2b6cIe_Rqj45QGRTN_bLiQ6_f-Lodql2WvMhPSiWJnH-VYSa1QJFAW1hFurPpcEiucwMMEh3woPT8uUGflyNKP', 'a', 'n', '2021-06-16 09:59:21', '2021-06-16 11:41:50'),
(41, 51, 'cLbiopkxS7WYjYdSUXszd2:APA91bHURknU-5o-ci1YxLfthyb9zOQEr-tGv3VMjn9ByTvI_2p8zr2b6cIe_Rqj45QGRTN_bLiQ6_f-Lodql2WvMhPSiWJnH-VYSa1QJFAW1hFurPpcEiucwMMEh3woPT8uUGflyNKP', 'a', 'y', '2021-06-16 10:02:25', '2021-06-16 11:42:06'),
(42, 52, 'dQ0kAgsYSj2DuT0mob7Upi:APA91bGPJtwoanMERdPzCP7r5ehLyXRBPFmNtcu32r57JBrc5_3qkFDvcmj0LUxdn9BzoSHTKBJ1HzU5sajeQu5nLETTX5_O0KXTQ3y0BzzYtE87l1es-kJyaZft0icSwu-7C7DasMlv', 'a', 'n', '2021-06-16 16:29:48', '2021-06-16 18:35:00'),
(43, 51, 'fqWlM4y5TACnftoSsa-G7B:APA91bEiNum-m8ElxKoryfoOE6NAwHK6ompShV06ceoI2ysCPcjL_3cqKLFcccl8cBfV17sFguooqurr82ATb3yXAqiLj7ByXuYSepKIhMY0JvOkN3PeaWZFM2cpynrHqp7Mkm4xrled', 'a', 'y', '2021-06-16 16:34:56', '2021-06-16 18:14:53'),
(44, 17, 'czHLWHtRT-G_iJcdsTaMcL:APA91bHOhV0DGZenuWrES3PyfgJfPb6Hvv_LtkJrhcj1k-fBVKXLyuWDD7ZG4Cvo6B6NLJ8FeLunUIik9ELGG2RpB6761NDqO4MjeEvos3holLNQuN6a5Xqu151AE2kUe9vhCO8GT_wj', 'a', 'n', '2021-06-20 19:28:16', '2021-06-25 01:25:37'),
(45, 41, 'czHLWHtRT-G_iJcdsTaMcL:APA91bHOhV0DGZenuWrES3PyfgJfPb6Hvv_LtkJrhcj1k-fBVKXLyuWDD7ZG4Cvo6B6NLJ8FeLunUIik9ELGG2RpB6761NDqO4MjeEvos3holLNQuN6a5Xqu151AE2kUe9vhCO8GT_wj', 'a', 'y', '2021-06-20 21:20:52', '2021-06-26 13:57:41'),
(46, 50, 'czHLWHtRT-G_iJcdsTaMcL:APA91bHOhV0DGZenuWrES3PyfgJfPb6Hvv_LtkJrhcj1k-fBVKXLyuWDD7ZG4Cvo6B6NLJ8FeLunUIik9ELGG2RpB6761NDqO4MjeEvos3holLNQuN6a5Xqu151AE2kUe9vhCO8GT_wj', 'a', 'n', '2021-06-20 23:19:54', '2021-06-22 01:32:49'),
(47, 52, 'ercMIIjBSdyPf99Hr5OeHk:APA91bFaZPaj-iKjWR0M-4L5_2J-HrI-O9LNdTCLeSPE6dVWO6QRow6F7SBzcq03_9rqLCDTWpEJnPyZ3ZDl_O9DC4MwVLalgwA5kjHz60k236k0Qp0TZhYqIwLA4qDEtA-kdkIN2qvv', 'a', 'n', '2021-06-21 11:56:19', '2021-06-21 19:48:47'),
(48, 51, 'ercMIIjBSdyPf99Hr5OeHk:APA91bFaZPaj-iKjWR0M-4L5_2J-HrI-O9LNdTCLeSPE6dVWO6QRow6F7SBzcq03_9rqLCDTWpEJnPyZ3ZDl_O9DC4MwVLalgwA5kjHz60k236k0Qp0TZhYqIwLA4qDEtA-kdkIN2qvv', 'a', 'y', '2021-06-21 14:40:01', '2021-06-21 19:49:15'),
(49, 56, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'n', '2021-06-22 10:09:11', '2021-06-22 10:14:20'),
(50, 51, 'dj0EIlwWQA6hA1ksqz1u6y:APA91bHiio6Ly5yP0zCV0ZhT01f5PUhs4ZxpBy_JkgFFGGMl2zEK255ZfBLlh2gl1vX_mwDHon8L_ZWfIuPXsbSRMKjfN0QiSDAwobHBfqsWAyZImla3YOO-vxpJeJwU3q469HiP92th', 'a', 'y', '2021-06-24 09:45:00', '2021-06-24 10:30:01'),
(51, 52, 'dj0EIlwWQA6hA1ksqz1u6y:APA91bHiio6Ly5yP0zCV0ZhT01f5PUhs4ZxpBy_JkgFFGGMl2zEK255ZfBLlh2gl1vX_mwDHon8L_ZWfIuPXsbSRMKjfN0QiSDAwobHBfqsWAyZImla3YOO-vxpJeJwU3q469HiP92th', 'a', 'n', '2021-06-24 09:51:05', '2021-06-24 10:29:43'),
(52, 4, 'cYEDlcl3SAW9BmI6qUm7vq:APA91bHJBG1OnnoLV6inION6F0HedmkI5_udgZJJD1Wvjc5e3X2czOu1Q1DRmeeufi4H-ltzFQMm_5aeGhwdqgqnEfPLg8ieYGg8NzVlNPvUMS_oqvWYPAefR8PWuXLzp0YGbPqAtkJS', 'a', 'n', '2021-06-25 18:35:13', '2021-06-25 18:50:20'),
(53, 51, 'ciQGk7_xT6qlZqHhHXra6u:APA91bEv74IWgspDBIX6Yo23o1MIluO26T-NZiU1ObvMi0G4wlnr247PSfvL3eWmo6i3AM3nzNYqBlIU_L0kdJU1ZY9cqGG1WHUFfXrs1CPt_KyCjvISWfCtAy24V2MSSlOMesvjbWr4', 'a', 'n', '2021-06-28 14:21:32', '2021-06-28 16:23:46'),
(54, 4, 'ciQGk7_xT6qlZqHhHXra6u:APA91bEv74IWgspDBIX6Yo23o1MIluO26T-NZiU1ObvMi0G4wlnr247PSfvL3eWmo6i3AM3nzNYqBlIU_L0kdJU1ZY9cqGG1WHUFfXrs1CPt_KyCjvISWfCtAy24V2MSSlOMesvjbWr4', 'a', 'y', '2021-06-28 16:24:15', '2021-06-28 16:24:15'),
(55, 52, 'e_pIJlXLStidZlWp-vsNis:APA91bFpB7THl0YAF-oQVt6bMqXzQhhyPxpw0_RdTXCl9tobHeLfx6rnXwBdCYHKAXx4YzzV_bqwZ2_HajAIuTmkiAU3OUxydFYUQQBCs-EqRYhfC4znGuMWHEcPdT0dWD1trPJs03rI', 'a', 'y', '2021-07-05 09:46:57', '2021-07-05 10:37:39'),
(56, 51, 'e_pIJlXLStidZlWp-vsNis:APA91bFpB7THl0YAF-oQVt6bMqXzQhhyPxpw0_RdTXCl9tobHeLfx6rnXwBdCYHKAXx4YzzV_bqwZ2_HajAIuTmkiAU3OUxydFYUQQBCs-EqRYhfC4znGuMWHEcPdT0dWD1trPJs03rI', 'a', 'n', '2021-07-05 09:59:18', '2021-07-05 10:37:27'),
(57, 51, 'cHR1Cae_SpyFQntWj_eYUK:APA91bGm14CxuLTEp-TfZq5aHvhbKwanXWOGHy561eiJqxGi9Lv7x-o62C2vzGOpZATPmLYHxdWRF0CCqXipzzin_LNizwbsrQtT0lDrWVFJ3CLxIR0y31-7kPxq8XWjYZxY5pc9CHls', 'a', 'y', '2021-07-08 16:25:38', '2021-07-08 16:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_images`
--

CREATE TABLE `tbl_user_images` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_images`
--

INSERT INTO `tbl_user_images` (`id`, `user_id`, `image_name`, `created_date`) VALUES
(6, 4, '9893461661619689230.png', '2021-04-29 09:40:42'),
(7, 4, '10325775931619689301.png', '2021-04-29 09:41:46'),
(8, 1, '4387943471619689883.png', '2021-04-29 09:51:40'),
(9, 1, '11265752901619689896.png', '2021-04-29 09:51:40'),
(10, 1, '12243650281619701099.png', '2021-04-29 12:58:26'),
(11, 1, '10901149661619852000.png', '2021-05-01 06:53:20'),
(12, 23, '7055137791619864425.png', '2021-05-01 10:20:25'),
(14, 23, '12891570891619872685.png', '2021-05-01 12:38:06'),
(15, 16, '18955141141620739469.png', '2021-05-11 13:24:29'),
(16, 10, '18131975981620741155.png', '2021-05-11 13:52:35'),
(17, 30, '20601053121621432573.png', '2021-05-19 14:01:18'),
(18, 30, '16363042891621432591.png', '2021-05-19 14:01:18'),
(19, 30, '2791552751621432601.png', '2021-05-19 14:01:18'),
(20, 30, '10777414501621432609.png', '2021-05-19 14:01:19'),
(21, 30, '4043799061621432623.png', '2021-05-19 14:01:19'),
(22, 30, '3104803871621432635.png', '2021-05-19 14:01:19'),
(23, 34, '4494884061621497270.png', '2021-05-20 07:54:55'),
(24, 34, '12338047721621497279.png', '2021-05-20 07:54:55'),
(25, 34, '231015211621497289.png', '2021-05-20 07:54:55'),
(31, 34, '8494669611621857663.png', '2021-05-24 12:01:08'),
(32, 38, '4185286411622391669.png', '2021-05-30 16:21:13'),
(33, 17, '18177986981622451376.png', '2021-05-31 08:56:17'),
(34, 41, '8365979271622474871.png', '2021-05-31 15:27:52'),
(35, 41, '470249371622474872.png', '2021-05-31 15:27:52'),
(36, 44, '67685581622642960.png', '2021-06-02 14:09:20'),
(37, 44, '2525998461622642960.png', '2021-06-02 14:09:20'),
(38, 44, '18501833651622642960.png', '2021-06-02 14:09:20'),
(39, 44, '2731996821622642961.png', '2021-06-02 14:09:21'),
(40, 44, '1446414871622642961.png', '2021-06-02 14:09:21'),
(41, 45, '2289999131622702610.png', '2021-06-03 06:43:30'),
(42, 46, '6438643581622713947.png', '2021-06-03 09:54:08'),
(43, 46, '13212326861622713963.png', '2021-06-03 09:54:08'),
(44, 46, '806203931622713972.png', '2021-06-03 09:54:08'),
(45, 46, '17979301311622713983.png', '2021-06-03 09:54:08'),
(46, 46, '15966492851622713998.png', '2021-06-03 09:54:08'),
(48, 47, '16601017351622872533.png', '2021-06-05 05:55:34'),
(49, 48, '4826353651622884398.png', '2021-06-05 09:13:32'),
(50, 48, '20484373471622884408.png', '2021-06-05 09:13:32'),
(51, 49, '18191317031622900476.png', '2021-06-05 13:42:06'),
(52, 49, '2599330511622900482.png', '2021-06-05 13:42:06'),
(53, 49, '4829965051622900487.png', '2021-06-05 13:42:06'),
(54, 49, '4410169141622900505.png', '2021-06-05 13:42:06'),
(55, 50, '7349293661623003799.png', '2021-06-06 18:23:19'),
(56, 34, '19242787341623142307.png', '2021-06-08 08:51:48'),
(58, 51, '20169000151623654006.png', '2021-06-14 07:00:06'),
(59, 56, '10418547161624336812.png', '2021-06-22 04:40:12'),
(60, 52, '11421956731625741481.png', '2021-07-08 10:51:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_adminrole`
--
ALTER TABLE `tbl_adminrole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sectionid` (`sectionid`),
  ADD KEY `sectionid_2` (`sectionid`);

--
-- Indexes for table `tbl_adminsection`
--
ALTER TABLE `tbl_adminsection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_type` (`activity_type`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `tbl_admin_permission`
--
ALTER TABLE `tbl_admin_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`,`page_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_constant`
--
ALTER TABLE `tbl_constant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_constant_copy`
--
ALTER TABLE `tbl_constant_copy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_content`
--
ALTER TABLE `tbl_content`
  ADD PRIMARY KEY (`pId`);

--
-- Indexes for table `tbl_email_notification_setting`
--
ALTER TABLE `tbl_email_notification_setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_email_templates`
--
ALTER TABLE `tbl_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `tbl_payment_history`
--
ALTER TABLE `tbl_payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_provider_availability`
--
ALTER TABLE `tbl_provider_availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_redeem_requests`
--
ALTER TABLE `tbl_redeem_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_service_book_record`
--
ALTER TABLE `tbl_service_book_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_service_requests`
--
ALTER TABLE `tbl_service_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_site_settings`
--
ALTER TABLE `tbl_site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subadmin_action`
--
ALTER TABLE `tbl_subadmin_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `tbl_users_tokens`
--
ALTER TABLE `tbl_users_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_user_images`
--
ALTER TABLE `tbl_user_images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_adminrole`
--
ALTER TABLE `tbl_adminrole`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `tbl_adminsection`
--
ALTER TABLE `tbl_adminsection`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin_permission`
--
ALTER TABLE `tbl_admin_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_constant`
--
ALTER TABLE `tbl_constant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `tbl_constant_copy`
--
ALTER TABLE `tbl_constant_copy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_content`
--
ALTER TABLE `tbl_content`
  MODIFY `pId` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_email_notification_setting`
--
ALTER TABLE `tbl_email_notification_setting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tbl_email_templates`
--
ALTER TABLE `tbl_email_templates`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `tbl_payment_history`
--
ALTER TABLE `tbl_payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tbl_provider_availability`
--
ALTER TABLE `tbl_provider_availability`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=638;

--
-- AUTO_INCREMENT for table `tbl_redeem_requests`
--
ALTER TABLE `tbl_redeem_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_service_book_record`
--
ALTER TABLE `tbl_service_book_record`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_service_requests`
--
ALTER TABLE `tbl_service_requests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_site_settings`
--
ALTER TABLE `tbl_site_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tbl_subadmin_action`
--
ALTER TABLE `tbl_subadmin_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tbl_users_tokens`
--
ALTER TABLE `tbl_users_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_user_images`
--
ALTER TABLE `tbl_user_images`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_adminrole`
--
ALTER TABLE `tbl_adminrole`
  ADD CONSTRAINT `tbl_adminrole_ibfk_1` FOREIGN KEY (`sectionid`) REFERENCES `tbl_adminsection` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_admin_permission`
--
ALTER TABLE `tbl_admin_permission`
  ADD CONSTRAINT `tbl_admin_permission_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
