/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 100121
Source Host           : localhost:3306
Source Database       : appsshop_zend_job

Target Server Type    : MYSQL
Target Server Version : 100121
File Encoding         : 65001

Date: 2017-08-24 15:41:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cv_search
-- ----------------------------
DROP TABLE IF EXISTS `cv_search`;
CREATE TABLE `cv_search` (
  `Package_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Package/Days` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  PRIMARY KEY (`Package_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cv_search
-- ----------------------------
INSERT INTO `cv_search` VALUES ('1', '1-5', '110');
INSERT INTO `cv_search` VALUES ('2', '6-10', '100');
INSERT INTO `cv_search` VALUES ('3', '11-20', '91');
INSERT INTO `cv_search` VALUES ('4', '21-30', '82');
INSERT INTO `cv_search` VALUES ('5', '31-40', '73');
INSERT INTO `cv_search` VALUES ('6', '41- Unlimited', '64');

-- ----------------------------
-- Table structure for job_plan_combo
-- ----------------------------
DROP TABLE IF EXISTS `job_plan_combo`;
CREATE TABLE `job_plan_combo` (
  `Combo_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Plan_Name` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Job_Posting` int(11) NOT NULL,
  `Days_CV_Search` int(11) NOT NULL,
  `Featured_Job_Posting` int(11) NOT NULL,
  PRIMARY KEY (`Combo_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of job_plan_combo
-- ----------------------------
INSERT INTO `job_plan_combo` VALUES ('1', 'Small', '50', '10', '20', '4');
INSERT INTO `job_plan_combo` VALUES ('2', 'Medium', '79', '20', '20', '11');
INSERT INTO `job_plan_combo` VALUES ('3', 'Large', '90', '30', '20', '4');

-- ----------------------------
-- Table structure for job_posting_plan
-- ----------------------------
DROP TABLE IF EXISTS `job_posting_plan`;
CREATE TABLE `job_posting_plan` (
  `Package_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Package/Days` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  PRIMARY KEY (`Package_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of job_posting_plan
-- ----------------------------
INSERT INTO `job_posting_plan` VALUES ('1', '1-5', '110');
INSERT INTO `job_posting_plan` VALUES ('2', '6-10', '100');
INSERT INTO `job_posting_plan` VALUES ('3', '11-20', '91');
INSERT INTO `job_posting_plan` VALUES ('4', '21-30', '82');
INSERT INTO `job_posting_plan` VALUES ('5', '31-40', '73');
INSERT INTO `job_posting_plan` VALUES ('6', '31-40', '64');

-- ----------------------------
-- Table structure for job_staus
-- ----------------------------
DROP TABLE IF EXISTS `job_staus`;
CREATE TABLE `job_staus` (
  `job_status_id` int(11) NOT NULL DEFAULT '0',
  `job_status_name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`job_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of job_staus
-- ----------------------------
INSERT INTO `job_staus` VALUES ('1', 'Applied');
INSERT INTO `job_staus` VALUES ('2', 'Under Review');
INSERT INTO `job_staus` VALUES ('3', 'Rejected');
INSERT INTO `job_staus` VALUES ('4', 'Hired');

-- ----------------------------
-- Table structure for jok_user
-- ----------------------------
DROP TABLE IF EXISTS `jok_user`;
CREATE TABLE `jok_user` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `usrRole` enum('A','SA','B','AG','E','C') NOT NULL COMMENT 'A=admin,SA=sub admin,B=Branch,AG=Agent,E=employee,C=customer',
  `profileId` varchar(500) NOT NULL,
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `emailaddress` varchar(80) NOT NULL,
  `dob` date DEFAULT NULL,
  `phoneno` varchar(20) NOT NULL,
  `mobno` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` int(10) NOT NULL,
  `city` int(10) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `emailvarificationKey` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `lastudpate_on` datetime NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`gender`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jok_user
-- ----------------------------
INSERT INTO `jok_user` VALUES ('1', 'A', 'ADM007', '', 'Akash', 'Nair', 'admin', 'admin', 'say2me84@gmail.com', null, '2780563', '8955534851', '', '0', '0', null, '', '2013-06-13 14:46:13', '2013-06-13 14:46:09', '1', '1', '1');
INSERT INTO `jok_user` VALUES ('2', 'C', 'USR000002', 'Female', 'asdfa', 'adsf', 'test', 'test', 'adsf@asdfa.com', '2013-06-03', '231231', '123123', 'asdfa', '24', '25', '3588.jpg', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '1', '0');
INSERT INTO `jok_user` VALUES ('3', 'C', 'USR000003', 'Male', 'mahesh', 'mahesh', 'akash', 'nair', 'mahesh@gmail.com', '2013-06-19', '231231', '123123', 'RRRRRRRRRRRRRRR', '24', '17', '3588.jpg', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '1', '1');

-- ----------------------------
-- Table structure for tbl_admin
-- ----------------------------
DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_fname` varchar(255) NOT NULL,
  `admin_lname` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_is_sub_admin` int(1) NOT NULL,
  `admin_permissions` varchar(255) NOT NULL,
  `admin_created_on` date NOT NULL,
  `admin_last_logged_in` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_admin
-- ----------------------------
INSERT INTO `tbl_admin` VALUES ('1', 'John', 'Doe', 'john.doe@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500', '0', '', '2013-07-24', '2013-07-24');

-- ----------------------------
-- Table structure for tbl_admin_messages
-- ----------------------------
DROP TABLE IF EXISTS `tbl_admin_messages`;
CREATE TABLE `tbl_admin_messages` (
  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `avator` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` int(1) NOT NULL,
  `left_on` date NOT NULL,
  PRIMARY KEY (`testimonial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_admin_messages
-- ----------------------------
INSERT INTO `tbl_admin_messages` VALUES ('1', 'Travis Arnold', '1.jpg', 'Harbinger Lab', 'President', 'admin@asd.com', '1231231231', 'Good Site', 'It helps me keep things organized, in one tool. It also gives me insight into what my prospects and customers are up to and what they\'re interested in.', '1', '2013-09-03');
INSERT INTO `tbl_admin_messages` VALUES ('2', 'Michael Johnson', '2.jpg', 'Web-Guru Softwares', 'Director & CEO', 'admin@webguru.com', '1231231231', 'Good Site', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas sit amet neque at convallis. Pellentesque tincidunt lectus a velit aliquam venenatis. Proin ut blandit ante. Nullam pellentesque ultrices metus, eget bibendum nulla malesuada ac. Maecenas aliquet, tortor a cursus faucibus, lacus arcu lobortis diam, non elementum nulla enim eu ipsum. Pellentesque sed rutrum lacus, quis mollis eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere, massa vel condimentum pretium, diam mi rutrum orci, in auctor diam quam quis purus. Fusce sagittis dolor ac eleifend fermentum.', '1', '2013-09-03');
INSERT INTO `tbl_admin_messages` VALUES ('4', 'Akash', '3.png', 'Web-Guru Softwares', 'Employee', 'akash@gmail.com', '8888888888', 'sss', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas sit amet neque at convallis. Pellentesque tincidunt lectus a velit aliquam venenatis. Proin ut blandit ante. Nullam pellentesque ultrices metus, eget bibendum nulla malesuada ac. Maecenas aliquet, tortor a cursus faucibus, lacus arcu lobortis diam, non elementum nulla enim eu ipsum. Pellentesque sed rutrum lacus, quis mollis eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere, massa vel condimentum pretium, diam mi rutrum orci, in auctor diam quam quis purus. Fusce sagittis dolor ac eleifend fermentum.', '0', '2013-11-22');
INSERT INTO `tbl_admin_messages` VALUES ('5', 'Test', '4.png', 'Harbinger Lab', 'Director & CEO', 'admin@webguru.com', '1231231231', 'Good Site', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas sit amet neque at convallis. Pellentesque tincidunt lectus a velit aliquam venenatis. Proin ut blandit ante. Nullam pellentesque ultrices metus, eget bibendum nulla malesuada ac. Maecenas aliquet, tortor a cursus faucibus, lacus arcu lobortis diam, non elementum nulla enim eu ipsum. Pellentesque sed rutrum lacus, quis mollis eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere, massa vel condimentum pretium, diam mi rutrum orci, in auctor diam quam quis purus. Fusce sagittis dolor ac eleifend fermentum.', '0', '2013-11-22');
INSERT INTO `tbl_admin_messages` VALUES ('6', 'Admin', '5.jpg', 'Web-Guru Softwares', 'President', 'admin@asd.com', '1231231231', 'Good Site', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas sit amet neque at convallis. Pellentesque tincidunt lectus a velit aliquam venenatis. Proin ut blandit ante. Nullam pellentesque ultrices metus, eget bibendum nulla malesuada ac. Maecenas aliquet, tortor a cursus faucibus, lacus arcu lobortis diam, non elementum nulla enim eu ipsum. Pellentesque sed rutrum lacus, quis mollis eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere, massa vel condimentum pretium, diam mi rutrum orci, in auctor diam quam quis purus. Fusce sagittis dolor ac eleifend fermentum.', '0', '2013-11-22');
INSERT INTO `tbl_admin_messages` VALUES ('7', 'RRRR', '6.jpg', 'Harbinger Lab', 'Director & CEO', '', '8888888888', 'Good Site', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas sit amet neque at convallis. Pellentesque tincidunt lectus a velit aliquam venenatis. Proin ut blandit ante. Nullam pellentesque ultrices metus, eget bibendum nulla malesuada ac. Maecenas aliquet, tortor a cursus faucibus, lacus arcu lobortis diam, non elementum nulla enim eu ipsum. Pellentesque sed rutrum lacus, quis mollis eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere, massa vel condimentum pretium, diam mi rutrum orci, in auctor diam quam quis purus. Fusce sagittis dolor ac eleifend fermentum.', '0', '2013-11-22');

-- ----------------------------
-- Table structure for tbl_applied_jobs
-- ----------------------------
DROP TABLE IF EXISTS `tbl_applied_jobs`;
CREATE TABLE `tbl_applied_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_posted_by` int(11) NOT NULL,
  `applied_on` date NOT NULL,
  `application_status` enum('Applied','Under Review','Rejected','Hired') NOT NULL,
  `application_is_read` int(1) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_applied_jobs
-- ----------------------------
INSERT INTO `tbl_applied_jobs` VALUES ('1', '1', '1', '0', '2013-11-01', 'Hired', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('2', '7', '1', '0', '2013-11-01', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('3', '3', '1', '0', '2013-11-01', 'Rejected', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('4', '4', '1', '0', '2013-11-03', 'Under Review', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('5', '5', '2', '0', '2013-11-03', 'Hired', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('6', '6', '2', '0', '2013-11-03', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('7', '1', '1', '0', '2013-11-03', 'Hired', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('25', '1', '2', '0', '2014-01-11', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('26', '29', '5', '0', '2014-01-21', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('27', '29', '5', '0', '2014-01-21', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('28', '29', '5', '0', '2014-01-21', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('29', '29', '5', '0', '2014-01-21', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('30', '29', '5', '0', '2014-01-21', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('31', '29', '5', '0', '2014-01-21', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('32', '43', '11', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('33', '44', '2', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('34', '46', '11', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('35', '46', '13', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('36', '47', '11', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('37', '52', '13', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('38', '52', '11', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('39', '51', '11', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('40', '51', '1', '0', '2014-01-23', 'Applied', '0', '');
INSERT INTO `tbl_applied_jobs` VALUES ('41', '51', '6', '0', '2014-01-23', 'Applied', '0', '');

-- ----------------------------
-- Table structure for tbl_banners
-- ----------------------------
DROP TABLE IF EXISTS `tbl_banners`;
CREATE TABLE `tbl_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_image` varchar(255) NOT NULL,
  `banner_alt` varchar(255) NOT NULL,
  `banner_link` varchar(255) NOT NULL,
  `banner_window_open` enum('_self','_blank') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_banners
-- ----------------------------
INSERT INTO `tbl_banners` VALUES ('1', '1344.jpg', 'RR', 'https://www.yahoo.com', '_blank');
INSERT INTO `tbl_banners` VALUES ('2', '2426.jpg', 'QQQ', 'https://www.google.co.in', '_self');
INSERT INTO `tbl_banners` VALUES ('3', '1344.jpg', 'RTTEEE', 'https://www.yahoo.com', '_self');

-- ----------------------------
-- Table structure for tbl_career_levels
-- ----------------------------
DROP TABLE IF EXISTS `tbl_career_levels`;
CREATE TABLE `tbl_career_levels` (
  `career_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `career_level_title` varchar(255) NOT NULL,
  PRIMARY KEY (`career_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_career_levels
-- ----------------------------
INSERT INTO `tbl_career_levels` VALUES ('1', 'Entry Level');
INSERT INTO `tbl_career_levels` VALUES ('2', 'Mid-Career');
INSERT INTO `tbl_career_levels` VALUES ('3', 'Mid Management');
INSERT INTO `tbl_career_levels` VALUES ('4', 'Senior Management');
INSERT INTO `tbl_career_levels` VALUES ('5', 'Executive/Director');
INSERT INTO `tbl_career_levels` VALUES ('6', 'Senior Executive (President, CEO)');

-- ----------------------------
-- Table structure for tbl_countries
-- ----------------------------
DROP TABLE IF EXISTS `tbl_countries`;
CREATE TABLE `tbl_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_countries
-- ----------------------------
INSERT INTO `tbl_countries` VALUES ('1', 'Afghanistan');
INSERT INTO `tbl_countries` VALUES ('2', 'Albania');
INSERT INTO `tbl_countries` VALUES ('3', 'Algeria');
INSERT INTO `tbl_countries` VALUES ('4', 'Andorra');
INSERT INTO `tbl_countries` VALUES ('5', 'Angola');
INSERT INTO `tbl_countries` VALUES ('6', 'Antigua & Deps');
INSERT INTO `tbl_countries` VALUES ('7', 'Argentina');
INSERT INTO `tbl_countries` VALUES ('8', 'Armenia');
INSERT INTO `tbl_countries` VALUES ('9', 'Australia');
INSERT INTO `tbl_countries` VALUES ('10', 'Austria');
INSERT INTO `tbl_countries` VALUES ('11', 'Azerbaijan');
INSERT INTO `tbl_countries` VALUES ('12', 'Bahamas');
INSERT INTO `tbl_countries` VALUES ('13', 'Bahrain');
INSERT INTO `tbl_countries` VALUES ('14', 'Bangladesh');
INSERT INTO `tbl_countries` VALUES ('15', 'Barbados');
INSERT INTO `tbl_countries` VALUES ('16', 'Belarus');
INSERT INTO `tbl_countries` VALUES ('17', 'Belgium');
INSERT INTO `tbl_countries` VALUES ('18', 'Belize');
INSERT INTO `tbl_countries` VALUES ('19', 'Benin');
INSERT INTO `tbl_countries` VALUES ('20', 'Bhutan');
INSERT INTO `tbl_countries` VALUES ('21', 'Bolivia');
INSERT INTO `tbl_countries` VALUES ('22', 'Bosnia Herzegovina');
INSERT INTO `tbl_countries` VALUES ('23', 'Botswana');
INSERT INTO `tbl_countries` VALUES ('24', 'Brazil');
INSERT INTO `tbl_countries` VALUES ('25', 'Brunei');
INSERT INTO `tbl_countries` VALUES ('26', 'Bulgaria');
INSERT INTO `tbl_countries` VALUES ('27', 'Burkina');
INSERT INTO `tbl_countries` VALUES ('28', 'Burundi');
INSERT INTO `tbl_countries` VALUES ('29', 'Cambodia');
INSERT INTO `tbl_countries` VALUES ('30', 'Cameroon');
INSERT INTO `tbl_countries` VALUES ('31', 'Canada');
INSERT INTO `tbl_countries` VALUES ('32', 'Cape Verde');
INSERT INTO `tbl_countries` VALUES ('33', 'Central African Rep');
INSERT INTO `tbl_countries` VALUES ('34', 'Chad');
INSERT INTO `tbl_countries` VALUES ('35', 'Chile');
INSERT INTO `tbl_countries` VALUES ('36', 'China');
INSERT INTO `tbl_countries` VALUES ('37', 'Colombia');
INSERT INTO `tbl_countries` VALUES ('38', 'Comoros');
INSERT INTO `tbl_countries` VALUES ('39', 'Congo');
INSERT INTO `tbl_countries` VALUES ('40', 'Congo (Democratic Rep)');
INSERT INTO `tbl_countries` VALUES ('41', 'Costa Rica');
INSERT INTO `tbl_countries` VALUES ('42', 'Croatia');
INSERT INTO `tbl_countries` VALUES ('43', 'Cuba');
INSERT INTO `tbl_countries` VALUES ('44', 'Cyprus');
INSERT INTO `tbl_countries` VALUES ('45', 'Czech Republic');
INSERT INTO `tbl_countries` VALUES ('46', 'Denmark');
INSERT INTO `tbl_countries` VALUES ('47', 'Djibouti');
INSERT INTO `tbl_countries` VALUES ('48', 'Dominica');
INSERT INTO `tbl_countries` VALUES ('49', 'Dominican Republic');
INSERT INTO `tbl_countries` VALUES ('50', 'East Timor');
INSERT INTO `tbl_countries` VALUES ('51', 'Ecuador');
INSERT INTO `tbl_countries` VALUES ('52', 'Egypt');
INSERT INTO `tbl_countries` VALUES ('53', 'El Salvador');
INSERT INTO `tbl_countries` VALUES ('54', 'Equatorial Guinea');
INSERT INTO `tbl_countries` VALUES ('55', 'Eritrea');
INSERT INTO `tbl_countries` VALUES ('56', 'Estonia');
INSERT INTO `tbl_countries` VALUES ('57', 'Ethiopia');
INSERT INTO `tbl_countries` VALUES ('58', 'Fiji');
INSERT INTO `tbl_countries` VALUES ('59', 'Finland');
INSERT INTO `tbl_countries` VALUES ('60', 'France');
INSERT INTO `tbl_countries` VALUES ('61', 'Gabon');
INSERT INTO `tbl_countries` VALUES ('62', 'Gambia');
INSERT INTO `tbl_countries` VALUES ('63', 'Georgia');
INSERT INTO `tbl_countries` VALUES ('64', 'Germany');
INSERT INTO `tbl_countries` VALUES ('65', 'Ghana');
INSERT INTO `tbl_countries` VALUES ('66', 'Greece');
INSERT INTO `tbl_countries` VALUES ('67', 'Grenada');
INSERT INTO `tbl_countries` VALUES ('68', 'Guatemala');
INSERT INTO `tbl_countries` VALUES ('69', 'Guinea');
INSERT INTO `tbl_countries` VALUES ('70', 'Guinea-Bissau');
INSERT INTO `tbl_countries` VALUES ('71', 'Guyana');
INSERT INTO `tbl_countries` VALUES ('72', 'Haiti');
INSERT INTO `tbl_countries` VALUES ('73', 'Honduras');
INSERT INTO `tbl_countries` VALUES ('74', 'Hungary');
INSERT INTO `tbl_countries` VALUES ('75', 'Iceland');
INSERT INTO `tbl_countries` VALUES ('76', 'India');
INSERT INTO `tbl_countries` VALUES ('77', 'Indonesia');
INSERT INTO `tbl_countries` VALUES ('78', 'Iran');
INSERT INTO `tbl_countries` VALUES ('79', 'Iraq');
INSERT INTO `tbl_countries` VALUES ('80', 'Ireland {Republic}');
INSERT INTO `tbl_countries` VALUES ('81', 'Israel');
INSERT INTO `tbl_countries` VALUES ('82', 'Italy');
INSERT INTO `tbl_countries` VALUES ('83', 'Ivory Coast');
INSERT INTO `tbl_countries` VALUES ('84', 'Jamaica');
INSERT INTO `tbl_countries` VALUES ('85', 'Japan');
INSERT INTO `tbl_countries` VALUES ('86', 'Jordan');
INSERT INTO `tbl_countries` VALUES ('87', 'Kazakhstan');
INSERT INTO `tbl_countries` VALUES ('88', 'Kenya');
INSERT INTO `tbl_countries` VALUES ('89', 'Kiribati');
INSERT INTO `tbl_countries` VALUES ('90', 'Korea North');
INSERT INTO `tbl_countries` VALUES ('91', 'Korea South');
INSERT INTO `tbl_countries` VALUES ('92', 'Kosovo');
INSERT INTO `tbl_countries` VALUES ('93', 'Kuwait');
INSERT INTO `tbl_countries` VALUES ('94', 'Kyrgyzstan');
INSERT INTO `tbl_countries` VALUES ('95', 'Laos');
INSERT INTO `tbl_countries` VALUES ('96', 'Latvia');
INSERT INTO `tbl_countries` VALUES ('97', 'Lebanon');
INSERT INTO `tbl_countries` VALUES ('98', 'Lesotho');
INSERT INTO `tbl_countries` VALUES ('99', 'Liberia');
INSERT INTO `tbl_countries` VALUES ('100', 'Libya');
INSERT INTO `tbl_countries` VALUES ('101', 'Liechtenstein');
INSERT INTO `tbl_countries` VALUES ('102', 'Lithuania');
INSERT INTO `tbl_countries` VALUES ('103', 'Luxembourg');
INSERT INTO `tbl_countries` VALUES ('104', 'Macedonia');
INSERT INTO `tbl_countries` VALUES ('105', 'Madagascar');
INSERT INTO `tbl_countries` VALUES ('106', 'Malawi');
INSERT INTO `tbl_countries` VALUES ('107', 'Malaysia');
INSERT INTO `tbl_countries` VALUES ('108', 'Maldives');
INSERT INTO `tbl_countries` VALUES ('109', 'Mali');
INSERT INTO `tbl_countries` VALUES ('110', 'Malta');
INSERT INTO `tbl_countries` VALUES ('111', 'Montenegro');
INSERT INTO `tbl_countries` VALUES ('112', 'Marshall Islands');
INSERT INTO `tbl_countries` VALUES ('113', 'Mauritania');
INSERT INTO `tbl_countries` VALUES ('114', 'Mauritius');
INSERT INTO `tbl_countries` VALUES ('115', 'Mexico');
INSERT INTO `tbl_countries` VALUES ('116', 'Micronesia');
INSERT INTO `tbl_countries` VALUES ('117', 'Moldova');
INSERT INTO `tbl_countries` VALUES ('118', 'Monaco');
INSERT INTO `tbl_countries` VALUES ('119', 'Mongolia');
INSERT INTO `tbl_countries` VALUES ('120', 'Morocco');
INSERT INTO `tbl_countries` VALUES ('121', 'Mozambique');
INSERT INTO `tbl_countries` VALUES ('122', 'Myanmar, {Burma}');
INSERT INTO `tbl_countries` VALUES ('123', 'Namibia');
INSERT INTO `tbl_countries` VALUES ('124', 'Nauru');
INSERT INTO `tbl_countries` VALUES ('125', 'Nepal');
INSERT INTO `tbl_countries` VALUES ('126', 'Netherlands');
INSERT INTO `tbl_countries` VALUES ('127', 'New Zealand');
INSERT INTO `tbl_countries` VALUES ('128', 'Nicaragua');
INSERT INTO `tbl_countries` VALUES ('129', 'Niger');
INSERT INTO `tbl_countries` VALUES ('130', 'Nigeria');
INSERT INTO `tbl_countries` VALUES ('131', 'Norway');
INSERT INTO `tbl_countries` VALUES ('132', 'Oman');
INSERT INTO `tbl_countries` VALUES ('133', 'Pakistan');
INSERT INTO `tbl_countries` VALUES ('134', 'Palau');
INSERT INTO `tbl_countries` VALUES ('135', 'Panama');
INSERT INTO `tbl_countries` VALUES ('136', 'Papua New Guinea');
INSERT INTO `tbl_countries` VALUES ('137', 'Paraguay');
INSERT INTO `tbl_countries` VALUES ('138', 'Peru');
INSERT INTO `tbl_countries` VALUES ('139', 'Philippines');
INSERT INTO `tbl_countries` VALUES ('140', 'Poland');
INSERT INTO `tbl_countries` VALUES ('141', 'Portugal');
INSERT INTO `tbl_countries` VALUES ('142', 'Qatar');
INSERT INTO `tbl_countries` VALUES ('143', 'Romania');
INSERT INTO `tbl_countries` VALUES ('144', 'Russian Federation');
INSERT INTO `tbl_countries` VALUES ('145', 'Rwanda');
INSERT INTO `tbl_countries` VALUES ('146', 'St Kitts & Nevis');
INSERT INTO `tbl_countries` VALUES ('147', 'St Lucia');
INSERT INTO `tbl_countries` VALUES ('148', 'Saint Vincent & the Grenadines');
INSERT INTO `tbl_countries` VALUES ('149', 'Samoa');
INSERT INTO `tbl_countries` VALUES ('150', 'San Marino');
INSERT INTO `tbl_countries` VALUES ('151', 'Sao Tome & Principe');
INSERT INTO `tbl_countries` VALUES ('152', 'Saudi Arabia');
INSERT INTO `tbl_countries` VALUES ('153', 'Senegal');
INSERT INTO `tbl_countries` VALUES ('154', 'Serbia');
INSERT INTO `tbl_countries` VALUES ('155', 'Seychelles');
INSERT INTO `tbl_countries` VALUES ('156', 'Sierra Leone');
INSERT INTO `tbl_countries` VALUES ('157', 'Singapore');
INSERT INTO `tbl_countries` VALUES ('158', 'Slovakia');
INSERT INTO `tbl_countries` VALUES ('159', 'Slovenia');
INSERT INTO `tbl_countries` VALUES ('160', 'Solomon Islands');
INSERT INTO `tbl_countries` VALUES ('161', 'Somalia');
INSERT INTO `tbl_countries` VALUES ('162', 'South Africa');
INSERT INTO `tbl_countries` VALUES ('163', 'Spain');
INSERT INTO `tbl_countries` VALUES ('164', 'Sri Lanka');
INSERT INTO `tbl_countries` VALUES ('165', 'Sudan');
INSERT INTO `tbl_countries` VALUES ('166', 'Suriname');
INSERT INTO `tbl_countries` VALUES ('167', 'Swaziland');
INSERT INTO `tbl_countries` VALUES ('168', 'Sweden');
INSERT INTO `tbl_countries` VALUES ('169', 'Switzerland');
INSERT INTO `tbl_countries` VALUES ('170', 'Syria');
INSERT INTO `tbl_countries` VALUES ('171', 'Taiwan');
INSERT INTO `tbl_countries` VALUES ('172', 'Tajikistan');
INSERT INTO `tbl_countries` VALUES ('173', 'Tanzania');
INSERT INTO `tbl_countries` VALUES ('174', 'Thailand');
INSERT INTO `tbl_countries` VALUES ('175', 'Togo');
INSERT INTO `tbl_countries` VALUES ('176', 'Tonga');
INSERT INTO `tbl_countries` VALUES ('177', 'Trinidad & Tobago');
INSERT INTO `tbl_countries` VALUES ('178', 'Tunisia');
INSERT INTO `tbl_countries` VALUES ('179', 'Turkey');
INSERT INTO `tbl_countries` VALUES ('180', 'Turkmenistan');
INSERT INTO `tbl_countries` VALUES ('181', 'Tuvalu');
INSERT INTO `tbl_countries` VALUES ('182', 'Uganda');
INSERT INTO `tbl_countries` VALUES ('183', 'Ukraine');
INSERT INTO `tbl_countries` VALUES ('184', 'United Arab Emirates');
INSERT INTO `tbl_countries` VALUES ('185', 'United Kingdom');
INSERT INTO `tbl_countries` VALUES ('186', 'United States');
INSERT INTO `tbl_countries` VALUES ('187', 'Uruguay');
INSERT INTO `tbl_countries` VALUES ('188', 'Uzbekistan');
INSERT INTO `tbl_countries` VALUES ('189', 'Vanuatu');
INSERT INTO `tbl_countries` VALUES ('190', 'Vatican City');
INSERT INTO `tbl_countries` VALUES ('191', 'Venezuea');
INSERT INTO `tbl_countries` VALUES ('192', 'Vietnam');
INSERT INTO `tbl_countries` VALUES ('193', 'Yemen');
INSERT INTO `tbl_countries` VALUES ('194', 'Zambia');
INSERT INTO `tbl_countries` VALUES ('195', 'Zimbabwe');

-- ----------------------------
-- Table structure for tbl_employment_type
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employment_type`;
CREATE TABLE `tbl_employment_type` (
  `employment_id` int(11) NOT NULL AUTO_INCREMENT,
  `employment_title` varchar(255) NOT NULL,
  PRIMARY KEY (`employment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employment_type
-- ----------------------------
INSERT INTO `tbl_employment_type` VALUES ('1', 'Employee');
INSERT INTO `tbl_employment_type` VALUES ('2', 'Internship');
INSERT INTO `tbl_employment_type` VALUES ('3', 'Contractor');
INSERT INTO `tbl_employment_type` VALUES ('4', 'Temporary Employee');

-- ----------------------------
-- Table structure for tbl_featured_clients
-- ----------------------------
DROP TABLE IF EXISTS `tbl_featured_clients`;
CREATE TABLE `tbl_featured_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `link_type` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_on` date NOT NULL,
  `expires_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_featured_clients
-- ----------------------------
INSERT INTO `tbl_featured_clients` VALUES ('1', 'lexus-img.png', '1', '2', 'Lexus', '', '2013-09-03', '2013-09-20');
INSERT INTO `tbl_featured_clients` VALUES ('2', 'qatar-img.png', '0', '0', 'Quatar Airways', 'http://www.google.co.in', '2013-09-03', '2013-09-30');
INSERT INTO `tbl_featured_clients` VALUES ('3', 'dc-img.png', '0', '0', 'Decoit Company', 'http://www.facebook.com', '2013-09-03', '2013-11-19');
INSERT INTO `tbl_featured_clients` VALUES ('4', 'dnata-img.png', '0', '0', 'Data Nata', 'http://www.freshersworld.com', '2013-09-03', '2013-09-28');
INSERT INTO `tbl_featured_clients` VALUES ('5', 'qnb-img.png', '0', '0', 'QNB Imports', 'http://www.qnb.com', '2013-09-03', '2014-03-03');
INSERT INTO `tbl_featured_clients` VALUES ('6', 'qatar-img.png', '0', '0', 'Quatar Oils', 'http://www.quatar.com', '2013-09-03', '2013-09-20');

-- ----------------------------
-- Table structure for tbl_featured_job_copy
-- ----------------------------
DROP TABLE IF EXISTS `tbl_featured_job_copy`;
CREATE TABLE `tbl_featured_job_copy` (
  `Featured_Job_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Featured_Job_Taken_dt` date DEFAULT NULL,
  `Featured_Job_Expire_dt` date DEFAULT NULL,
  `Featured_Job_Qty` varchar(100) DEFAULT NULL,
  `Invoice` varchar(250) DEFAULT NULL,
  `Status` enum('Active','Expired','Pending') DEFAULT NULL,
  `Job_Qty` int(50) DEFAULT NULL,
  `QryRemain` int(50) DEFAULT NULL,
  `Job_Amt` int(50) DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Featured_Job_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_featured_job_copy
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_jobs
-- ----------------------------
DROP TABLE IF EXISTS `tbl_jobs`;
CREATE TABLE `tbl_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_reference_no` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_keywords` varchar(255) NOT NULL,
  `job_url` varchar(255) NOT NULL,
  `job_category` int(11) NOT NULL,
  `job_sub_category` int(11) NOT NULL,
  `job_description` text NOT NULL,
  `job_responsibilities` text NOT NULL,
  `job_skills_required` text NOT NULL,
  `job_country` int(11) NOT NULL,
  `job_city` varchar(255) NOT NULL,
  `job_employment_type` int(11) NOT NULL,
  `job_type` int(11) NOT NULL,
  `job_education` int(11) NOT NULL,
  `job_career_level` int(11) NOT NULL,
  `job_experience` int(11) NOT NULL,
  `job_role` int(11) NOT NULL,
  `job_travel_required` enum('Yes','No') NOT NULL,
  `job_relocation` enum('Yes','No') NOT NULL,
  `job_sallary` varchar(255) NOT NULL,
  `job_other_pay` varchar(255) NOT NULL,
  `job_email` varchar(255) NOT NULL,
  `job_phone_number` varchar(255) NOT NULL,
  `job_contact_name` varchar(255) NOT NULL,
  `job_fax` varchar(255) NOT NULL,
  `job_posted_on` date NOT NULL,
  `job_expired_on` date NOT NULL,
  `job_status` int(1) NOT NULL,
  `job_is_new` int(1) NOT NULL,
  `job_is_featured` int(1) NOT NULL,
  `job_bg_color` varchar(255) NOT NULL,
  `job_logo_bg_color` varchar(255) NOT NULL,
  `job_menu_color` varchar(255) NOT NULL,
  `job_foreground_color` varchar(255) NOT NULL,
  `job_menu_foreground_color` varchar(255) NOT NULL,
  `Company_Logo` varchar(255) NOT NULL,
  `Header_Banner` varchar(255) NOT NULL,
  `Content_Banner` varchar(255) NOT NULL,
  `job_total_hits` int(11) NOT NULL,
  `job_viewed_by` varchar(255) NOT NULL,
  `job_is_saved` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_jobs
-- ----------------------------
INSERT INTO `tbl_jobs` VALUES ('1', 'Ref5000', 'PHP-Web Developer', 'PHP, MySQL', '', '28', '17', 'Are you a PHP developer looking for a new role? A leading International dot-com company based in Dubai is looking to expand its IT development team with a hard working, enthusiastic and energetic junior/mid-level PHP-Web Developer.\r\n\r\nWorking directly with on-site project manager you will be responsible for creating and modifying code that supports a number of business processes on our popular public web sites. You will be coding mainly in PHP/MySQL', 'Extensive PHP/MySQL coding for new projects or modifications in existing code.\r\n\r\nCode development, system integration, testing, documentation and code maintenance.', '• 1 to 3 years experience in web application development out of which, ideally, at least 1 to 2 years PHP development.\r\n• Strong knowledge of PHP, SQL, HTML and JavaScript.\r\n• Experience and familiarity with Dreamweaver, Linux, Sendmail, MySQL and CSS desirable\r\n• Bachelor\'s degree or higher (or equivalent degree level)\r\n• Excellent oral and written communication skills\r\n• Ideal age range 20-28', '76', 'Jaipur', '1', '2', '1', '2', '2', '3', 'No', 'No', '15000', '', 'say2me84@gmail.com', '2780563', '8442059348', '', '2013-10-31', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '6', '0');
INSERT INTO `tbl_jobs` VALUES ('2', 'Ref5000', 'Web Developer', 'PHP, MySQL, HTML, Java Screept', '', '28', '17', 'Design, Develop & Implement Web Application, Database Design & Content Management system, with experience in developing and maintaining web portals.\r\nDevelop new Web applications as identified by supervisor and management through packaged and customized applications\r\n5+ years experience in PHP/MYSQL/Ajax/JQuery/Javascript\r\nExcellent Experience in PHP .\r\nMaintain and enhance existing Web applications and all internal systems are integrated.\r\nPerform complete testing of Web applications unit and system, engaging users as necessary.\r\nDesign and Implement Good database schema for given case\r\nDevelop database-driven Web interfaces for rapid, real-time information sharing.\r\nProficient in Internet related applications such as E-Mail clients, FTP clients and Web Browser\r\nWork with PHP and MySQL to design, develop and debug Web applications\r\nDevelop and deploy PHP implementation of core algorithms with a solid understanding of coding best-practices\r\nIntegrate back-end services with PHP/Javascript/Ajax / JQuery based front end needs Create other network scripts and tools to assist in product development.\r\nCreate and maintaining technical documentation.\r\nThe Senior role will eventually lead a team of developers in future projects\r\nDetermining any functionality that the site must support and developing PHP content\r\nIdentifying the content type the site will host and ensuring compatibility with the PHP programming requirements\r\nExpert with CSS, XML and Content management systems Template design such as Joomla, Moodle, word press, Drupal ….', '• Bachelor’s degree in Computer Science or Information Technology<br>\r\n• At least 2 years of hands-on experience with PHP, MySQL,Ajax , JQuery DHTML, HTML, CSS.<br>\r\n\r\n• Positive attitude and strong work ethics, ability to multi task is a must .<br>\r\n• Ability to program to specification<br>\r\n• Excellent verbal and written communication skills<br>\r\n• A sharp mind with the ability to grasp concepts quickly and work out complex logic problems<br>\r\n• A demonstrated ability to learn by doing and taking initiative to \"figure things out\"<br>\r\n• Creativity and imagination<br>\r\n• Must be able to stay on top of advancing internet and computer technology and its effects to the business <br>', '• Knowledge of international web standards and protocols\r\n• Self motivated, detail-oriented and organized.\r\n• Experience with hardware and software issues.\r\n• Excellent organization and communication skills.\r\n• Problem-solving skills.\r\n• Excellent Knowledge of Web site structure and functionality. based on practical approved layout\r\n• Ability to meet with deadlines.', '152', 'Riyadh', '3', '5', '2', '1', '3', '3', 'Yes', 'Yes', '35000', '', 'say2me84@gmail.com', '2780563', 'Test', '3333', '2013-10-31', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '6', '0');
INSERT INTO `tbl_jobs` VALUES ('3', 'HTML 000003', 'HTML Developer', 'Html, Xhtml', '', '28', '17', 'Html Developer', 'Html , css, ', 'HTML, JavaScript, Css', '76', 'Jaipur', '1', '2', '1', '1', '5', '3', 'No', 'No', '5000', '', 'say2me84@mail.com', '8442059348', 'Akash', '', '2014-01-06', '0000-00-00', '0', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '1', '0');
INSERT INTO `tbl_jobs` VALUES ('4', 'Core 000004', 'Core php', 'Php, wordpress, html', '', '28', '17', 'Php, wordpress, html', 'Php, wordpress, html', 'Php, wordpress, html', '76', 'Jaipur', '2', '1', '2', '1', '5', '3', 'Yes', 'Yes', '5000', '', 'say2me84@mail.com', '8442059348', 'Akash', '', '2014-01-06', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '2', '0');
INSERT INTO `tbl_jobs` VALUES ('5', 'Andor000005', 'Andorid Developer', 'Java, Android', '', '28', '18', ' Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Android Application Develpement, Client handling, code review', 'Java, html 5, css 3', '76', 'Jaipur', '1', '2', '2', '2', '5', '3', 'No', 'Yes', '350000', '', 'rahul@sybite.com', '1234567890', 'Rahul', '', '2014-01-06', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '2', '0');
INSERT INTO `tbl_jobs` VALUES ('6', 'Core 000006', 'Core php', 'Php, wordpress, html', '', '28', '17', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', 'Jaipur', '1', '1', '1', '1', '2', '3', 'Yes', 'Yes', '5000', '', 'say2me84@mail.com', '8442059348', 'Akash', '123', '2014-01-07', '0000-00-00', '1', '0', '1', '#3bdbc0', '#ed390c', '#d63bdb', '#9bdb3b', '#030303', 'Company_Logo325.jpg', 'Company_Header_Banner408.jpg', 'Company_Content_Banner246.jpg', '0', '', '0', '2', '0');
INSERT INTO `tbl_jobs` VALUES ('7', 'Core 000007', 'Core php', 'Php, wordpress, html', '', '1', '7', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3', 'asdfa', '2', '1', '2', '1', '2', '3', 'Yes', 'Yes', '5000', '', 'say2me84@mail.com', '8442059348', 'Akash', '123', '2014-01-07', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '2', '0');
INSERT INTO `tbl_jobs` VALUES ('8', 'asdfa000008', 'asdfa', 'Php, wordpress, html', '', '1', '7', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3', 'Jaipur', '2', '1', '1', '2', '2', '3', 'Yes', 'Yes', '5000', '', 'say2me84@mail.com', '8442059348', 'Akash', '123', '2014-01-07', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '2', '0');
INSERT INTO `tbl_jobs` VALUES ('9', 'Core 000009', 'Core php', 'Php, wordpress, html', '', '1', '7', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', 'Jaipur', '1', '1', '2', '2', '2', '3', 'Yes', 'Yes', '5000', '', 'say2me84@mail.com', '8442059348', 'Akash', '123', '2014-01-07', '0000-00-00', '1', '0', '1', '#4d4944', '#3b6bdb', '#3bdbc8', '#dbd33b', '#8e3bdb', 'Company_Logo671.png', 'Company_Header_Banner780.png', 'Company_Content_Banner110.png', '0', '', '0', '2', '0');
INSERT INTO `tbl_jobs` VALUES ('10', 'Marke000010', 'Marketing EXE', 'Business Marketing ', '', '3', '11', 'Marketing executive required Marketing executive required Marketing executive required Marketing executive required Marketing executive required ', 'Marketing executive required Marketing executive required Marketing executive required ', 'Marketing Marketing Marketing Marketing ', '5', 'jaipur', '2', '1', '2', '1', '2', '0', 'Yes', 'Yes', '$1500', '', 'emp1@mailinator.com', '12121212', '12122', '11212121', '2014-01-21', '0000-00-00', '0', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '30', '0');
INSERT INTO `tbl_jobs` VALUES ('11', 'Techn000011', 'Technical Analyst', 'Analyst, IT, Business', '', '28', '17', 'Need skilled developer for php', 'Design develop test ', 'php, test, business', '191', 'Newyour', '1', '2', '2', '2', '6', '0', 'No', 'Yes', '$1500', '', 'Symantec@mailinator.com', '97854878445', 'Symantec', '1245845', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');
INSERT INTO `tbl_jobs` VALUES ('12', 'Php d000012', 'Php developer ', 'php', '', '28', '17', 'Need skilled developer for php', 'Design develop test  ', 'php web developer ', '12', 'jaipur', '1', '2', '2', '2', '5', '0', 'Yes', 'Yes', '$1000', '', 'Symantec@mailinator.com', '022121221212', '21211', '112121', '2014-01-23', '0000-00-00', '0', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');
INSERT INTO `tbl_jobs` VALUES ('13', 'php d000013', 'php developer', 'php ', '', '2', '9', 'Need skilled developer for php', 'Design develop test  ', 'php java testing ', '2', 'Interpro ', '3', '1', '2', '2', '2', '0', 'Yes', 'No', '$300', '', 'VMware@mailinator.com', '0227845874589', 'vmarw', '022145222', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '32', '0');
INSERT INTO `tbl_jobs` VALUES ('14', 'java 000014', 'java developer', 'java', '', '2', '9', 'Need skilled developer for php', 'Design develop test  ', 'java php', '2', 'Huntsville', '2', '1', '2', '4', '5', '0', 'No', 'Yes', '$1000', '', 'Fiserv@mailinator.com', '0221415242', 'firser', '02545', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '33', '0');
INSERT INTO `tbl_jobs` VALUES ('15', 'HR ma000015', 'HR manager ', 'HR human ', '', '4', '12', 'Hr manager ', 'HR, Job recruitment ', 'HR MBA', '1', 'Dehli', '2', '2', '2', '2', '2', '0', 'Yes', 'No', '$500', '', 'Intuit@mailinator.com', '21445444', '02112445', '', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '34', '0');
INSERT INTO `tbl_jobs` VALUES ('16', 'Busin000016', 'Business manager', 'Marketing business', '', '6', '3', 'Need skilled developer for php', 'Design develop test  ', 'Design develop test  ', '2', 'Huntsville', '2', '2', '2', '4', '5', '0', 'No', 'No', '$3000', '', 'Amadeus@mailinator.com', '022', '12121212', '1212112', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '36', '0');
INSERT INTO `tbl_jobs` VALUES ('17', 'Hr ex000017', 'Hr executive', 'HR MBA', '', '6', '3', 'Need skilled developer for php Need skilled developer for php Need skilled developer for php', 'Design develop test  ', 'MBA ', '3', 'dehli', '2', '3', '1', '2', '5', '0', 'No', 'No', '$1500', '', '314354444', '444444', '454544', '4445', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '37', '0');
INSERT INTO `tbl_jobs` VALUES ('18', 'Java 000018', 'Java developer ', 'java php', '', '22', '0', 'Need skilled developer for php Need skilled developer for php Need skilled developer for php', 'development design test', 'java ', '4', 'Madison', '4', '3', '3', '6', '6', '0', 'No', 'No', '$1000', '', 'AstraZeneca@mailinator.com', '011', '321545454', '5454545', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '39', '0');
INSERT INTO `tbl_jobs` VALUES ('19', 'php d000019', 'php developer', 'PHP design developer ', '', '5', '14', 'Need skilled developer for php Need skilled developer for php Need skilled developer for php', 'Need skilled developer for php Need skilled developer for php Need skilled developer for php', 'Design develop test  ', '2', 'Huntsville', '2', '2', '2', '2', '5', '0', 'No', 'No', '$1000', '', 'Barclays@mailinator.com', '0114558545', 'Barclays', '22443435', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '40', '0');
INSERT INTO `tbl_jobs` VALUES ('20', 'java 000020', 'java hr', 'java ', '', '7', '6', 'Need skilled developer for php Need skilled developer for php Need skilled developer for php', 'Need skilled developer for php Need skilled developer for php Need skilled developer for php', 'Design develop test ', '3', 'Huntsville', '3', '2', '1', '1', '5', '0', 'No', 'No', '$400', '', 'BAE1@mailinator.com', '04545405464', '304535', '056465', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '42', '0');
INSERT INTO `tbl_jobs` VALUES ('21', 'Local000021', 'Local marketer ', 'Business ', '', '4', '12', 'Need business developer', 'Business development ', 'marketing business', '3', 'jaipur', '1', '2', '2', '2', '5', '0', 'Yes', 'Yes', '$450', '', 'abcd@gmail.com', '01124501145215', 'HR', '21430143', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');
INSERT INTO `tbl_jobs` VALUES ('22', 'New p000022', 'New php job', 'php developer', '', '3', '10', 'New pjp job', 'php developer', 'php java html', '2', 'jaipur', '2', '2', '1', '2', '5', '0', 'No', 'No', '$100', '', 'sdfsh@gmail.com', '7854878545', 'amit', '', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');
INSERT INTO `tbl_jobs` VALUES ('23', 'java000023', 'java', 'java', '', '3', '10', 'java develepr', 'java develepr', 'java develepr', '2', 'jaipur', '2', '2', '2', '2', '5', '0', 'No', 'No', '1000', '', 'jsfjk@gmail.com', '3142121321', 'amit', '2445', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');
INSERT INTO `tbl_jobs` VALUES ('24', 'html 000024', 'html designer ', 'html', '', '3', '10', 'HTML codeer ', 'designing ', 'HMTL css', '3', 'Mumbai', '2', '2', '2', '2', '5', '0', 'No', 'No', '1222', '', 'afslk@gmail.com', '16546343', 'RAO', '321321', '2014-01-23', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');
INSERT INTO `tbl_jobs` VALUES ('25', 'UI/UX000025', 'UI/UX expert', 'HTML5, CSS3, Bootstrap', '', '28', '18', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sh', 'Designing, Team Coordination, Project management  ', 'HTML5, CSS3, PHP, MySQL', '184', 'Dubai', '1', '2', '4', '7', '6', '0', 'No', 'Yes', '10000', '', 'Symantec@mailinator.com', '919799556102', 'Aslam', '1234567899', '2014-01-24', '0000-00-00', '1', '0', '0', '', '', '', '', '', '', '', '', '0', '', '0', '31', '0');

-- ----------------------------
-- Table structure for tbl_job_categories
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_categories`;
CREATE TABLE `tbl_job_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL,
  `category_banner` varchar(255) NOT NULL,
  `show_on_home_page` int(1) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_categories
-- ----------------------------
INSERT INTO `tbl_job_categories` VALUES ('1', 'Accounting / Auditing', 'mangmentimg.jpg', '1');
INSERT INTO `tbl_job_categories` VALUES ('2', 'Administration', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('3', 'Advertising', 'mangmentimg.jpg', '1');
INSERT INTO `tbl_job_categories` VALUES ('4', 'Aerospace and Defense', 'mangmentimg.jpg', '1');
INSERT INTO `tbl_job_categories` VALUES ('5', 'Agriculture / Forestry / Fishing', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('6', 'Airlines / Aviation', 'mangmentimg.jpg', '1');
INSERT INTO `tbl_job_categories` VALUES ('7', 'Architecture', 'mangmentimg.jpg', '1');
INSERT INTO `tbl_job_categories` VALUES ('8', 'Arts / Entertainment / and Media', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('9', 'Automotive', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('10', 'Aviation / Marine Refueling', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('12', 'Human Resources / Personnel', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('22', 'Management', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('23', 'Logistics', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('25', 'Marketing / PR', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('26', 'Accounting / Banking / Finance', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('27', 'Healthcare / Medical', 'mangmentimg.jpg', '0');
INSERT INTO `tbl_job_categories` VALUES ('28', 'Internet/E-commerce ', 'mangmentimg.jpg', '1');
INSERT INTO `tbl_job_categories` VALUES ('34', 'BBB', '', '1');
INSERT INTO `tbl_job_categories` VALUES ('37', 'SSSSS', '', '0');
INSERT INTO `tbl_job_categories` VALUES ('38', 'EEEEEEEEEEE', '38852.jpg', '0');

-- ----------------------------
-- Table structure for tbl_job_educations
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_educations`;
CREATE TABLE `tbl_job_educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `education_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_educations
-- ----------------------------
INSERT INTO `tbl_job_educations` VALUES ('1', 'Any Graduate / Diploma');
INSERT INTO `tbl_job_educations` VALUES ('2', 'B.Tech / B.E');
INSERT INTO `tbl_job_educations` VALUES ('4', 'Masters Degree');
INSERT INTO `tbl_job_educations` VALUES ('6', 'BCA');
INSERT INTO `tbl_job_educations` VALUES ('7', 'MCA');
INSERT INTO `tbl_job_educations` VALUES ('8', 'DCA');

-- ----------------------------
-- Table structure for tbl_job_experiences
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_experiences`;
CREATE TABLE `tbl_job_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `experience_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_experiences
-- ----------------------------
INSERT INTO `tbl_job_experiences` VALUES ('2', '0 - 1 Year');
INSERT INTO `tbl_job_experiences` VALUES ('5', '0 - 3 Year(s)');
INSERT INTO `tbl_job_experiences` VALUES ('6', '1 Year - 3.5 Year(s)');

-- ----------------------------
-- Table structure for tbl_job_key_word
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_key_word`;
CREATE TABLE `tbl_job_key_word` (
  `key_word_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_key_word` varchar(255) NOT NULL,
  PRIMARY KEY (`key_word_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_key_word
-- ----------------------------
INSERT INTO `tbl_job_key_word` VALUES ('1', 'Php');
INSERT INTO `tbl_job_key_word` VALUES ('2', 'MySql');
INSERT INTO `tbl_job_key_word` VALUES ('3', 'Wordpress');
INSERT INTO `tbl_job_key_word` VALUES ('4', 'Magento');
INSERT INTO `tbl_job_key_word` VALUES ('5', 'Joomla');

-- ----------------------------
-- Table structure for tbl_job_roles
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_roles`;
CREATE TABLE `tbl_job_roles` (
  `job_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_role_title` varchar(255) NOT NULL,
  PRIMARY KEY (`job_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_roles
-- ----------------------------
INSERT INTO `tbl_job_roles` VALUES ('1', 'Administrators');
INSERT INTO `tbl_job_roles` VALUES ('2', 'Team Leader');
INSERT INTO `tbl_job_roles` VALUES ('3', 'Developer');

-- ----------------------------
-- Table structure for tbl_job_sub_categories
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_sub_categories`;
CREATE TABLE `tbl_job_sub_categories` (
  `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`sub_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_sub_categories
-- ----------------------------
INSERT INTO `tbl_job_sub_categories` VALUES ('2', 'IT-Software', '5');
INSERT INTO `tbl_job_sub_categories` VALUES ('3', 'IT-Hardware', '6');
INSERT INTO `tbl_job_sub_categories` VALUES ('4', 'Defence', '10');
INSERT INTO `tbl_job_sub_categories` VALUES ('5', 'Bank Back Office Operator', '7');
INSERT INTO `tbl_job_sub_categories` VALUES ('6', 'Data Entry Operator', '7');
INSERT INTO `tbl_job_sub_categories` VALUES ('7', 'Civil Eng.', '1');
INSERT INTO `tbl_job_sub_categories` VALUES ('8', 'Electronics Eng.', '1');
INSERT INTO `tbl_job_sub_categories` VALUES ('9', 'Labour', '2');
INSERT INTO `tbl_job_sub_categories` VALUES ('10', 'Researcher & Doctor', '3');
INSERT INTO `tbl_job_sub_categories` VALUES ('11', 'Pharmacist', '3');
INSERT INTO `tbl_job_sub_categories` VALUES ('12', 'Business Development Manager', '4');
INSERT INTO `tbl_job_sub_categories` VALUES ('13', 'Sr. Manager', '4');
INSERT INTO `tbl_job_sub_categories` VALUES ('14', 'Chattered Accountant ', '5');
INSERT INTO `tbl_job_sub_categories` VALUES ('15', 'Accounts Officer', '5');
INSERT INTO `tbl_job_sub_categories` VALUES ('17', 'PHP Developer', '28');
INSERT INTO `tbl_job_sub_categories` VALUES ('18', 'Java Devoloper', '28');

-- ----------------------------
-- Table structure for tbl_job_types
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_types`;
CREATE TABLE `tbl_job_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_type_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_types
-- ----------------------------
INSERT INTO `tbl_job_types` VALUES ('1', 'Part Time');
INSERT INTO `tbl_job_types` VALUES ('2', 'Full TIme');
INSERT INTO `tbl_job_types` VALUES ('3', 'Temporary');
INSERT INTO `tbl_job_types` VALUES ('5', 'Freelancer');
INSERT INTO `tbl_job_types` VALUES ('6', 'Test');

-- ----------------------------
-- Table structure for tbl_job_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_user`;
CREATE TABLE `tbl_job_user` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `usrRole` enum('A','SA','B','AG','E','C') NOT NULL COMMENT 'A=admin,SA=sub admin,B=Branch,AG=Agent,E=employee,C=customer',
  `profileId` varchar(500) NOT NULL,
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `emailaddress` varchar(80) NOT NULL,
  `dob` date DEFAULT NULL,
  `phoneno` varchar(20) NOT NULL,
  `mobno` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` int(10) NOT NULL,
  `city` int(10) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `emailvarificationKey` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `lastudpate_on` datetime NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`gender`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_job_user
-- ----------------------------
INSERT INTO `tbl_job_user` VALUES ('1', 'A', 'ADM007', '', 'Akash', 'Nair', 'admin', 'admin', 'say2me84@gmail.com', null, '2780563', '8955534851', '', '0', '0', null, '', '2013-06-13 14:46:13', '2013-06-13 14:46:09', '1', '1', '1');
INSERT INTO `tbl_job_user` VALUES ('2', 'C', 'USR000002', 'Female', 'asdfa', 'adsf', 'asdf', 'adsf', 'adsf@asdfa.com', '2013-06-03', '231231', '123123', 'asdfa', '24', '25', '3588.jpg', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0');
INSERT INTO `tbl_job_user` VALUES ('3', 'C', 'USR000003', 'Male', 'mahesh', 'mahesh', 'akash', 'nair', 'mahesh@gmail.com', '2013-06-19', '231231', '123123', 'RRRRRRRRRRRRRRR', '24', '17', '3588.jpg', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0', '1');

-- ----------------------------
-- Table structure for tbl_membership
-- ----------------------------
DROP TABLE IF EXISTS `tbl_membership`;
CREATE TABLE `tbl_membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_title` varchar(255) NOT NULL,
  `job_postings` int(11) NOT NULL,
  `cv_search` int(11) NOT NULL,
  `featured_job` int(11) NOT NULL,
  `customized_job_ad` int(11) NOT NULL,
  `membership_type` enum('Job','Resume','Both') NOT NULL,
  `membership_price` varchar(255) NOT NULL,
  `total_membership_expired_on` int(11) NOT NULL,
  `job_posting_expired_on` int(11) NOT NULL,
  `resume_membership_expired_on` int(11) NOT NULL,
  `featured_job_posting_expired_on` int(11) NOT NULL,
  `membership_created_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_membership
-- ----------------------------
INSERT INTO `tbl_membership` VALUES ('1', 'Small', '10', '1', '4', '0', 'Both', '50', '30', '15', '20', '11', '2013-09-22');
INSERT INTO `tbl_membership` VALUES ('2', 'Medium', '20', '1', '11', '0', 'Both', '79', '60', '15', '20', '11', '2013-09-22');
INSERT INTO `tbl_membership` VALUES ('3', 'Large', '30', '1', '4', '0', 'Both', '90', '90', '15', '20', '11', '2013-09-23');
INSERT INTO `tbl_membership` VALUES ('4', 'Small', '10', '0', '0', '0', 'Job', '894', '0', '15', '0', '0', '2013-09-22');
INSERT INTO `tbl_membership` VALUES ('5', 'Medium', '30', '0', '0', '0', 'Job', '1890', '0', '40', '0', '0', '2013-09-22');

-- ----------------------------
-- Table structure for tbl_nationalities
-- ----------------------------
DROP TABLE IF EXISTS `tbl_nationalities`;
CREATE TABLE `tbl_nationalities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nation_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_nationalities
-- ----------------------------
INSERT INTO `tbl_nationalities` VALUES ('1', 'Indian');
INSERT INTO `tbl_nationalities` VALUES ('2', 'American');
INSERT INTO `tbl_nationalities` VALUES ('3', 'British');
INSERT INTO `tbl_nationalities` VALUES ('4', 'Chinese');
INSERT INTO `tbl_nationalities` VALUES ('12', 'Arab');

-- ----------------------------
-- Table structure for tbl_normal_job
-- ----------------------------
DROP TABLE IF EXISTS `tbl_normal_job`;
CREATE TABLE `tbl_normal_job` (
  `Normal_Job_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Normal_Job_Taken_dt` date DEFAULT NULL,
  `Normal_Job_Expire_dt` date DEFAULT NULL,
  `Normal_Job_Qty` varchar(100) DEFAULT NULL,
  `Invoice` varchar(250) DEFAULT NULL,
  `Status` enum('Active','Expired','Pending') DEFAULT NULL,
  `Job_Qty` int(50) DEFAULT NULL,
  `NormalQryRemain` int(50) DEFAULT NULL,
  `Job_Amt` int(50) DEFAULT NULL,
  `User_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Normal_Job_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_normal_job
-- ----------------------------
INSERT INTO `tbl_normal_job` VALUES ('1', '2013-11-23', '2013-12-22', '20', null, 'Active', '20', '18', '50', '2');

-- ----------------------------
-- Table structure for tbl_notifications
-- ----------------------------
DROP TABLE IF EXISTS `tbl_notifications`;
CREATE TABLE `tbl_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_on` date NOT NULL,
  `is_read` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_notifications
-- ----------------------------
INSERT INTO `tbl_notifications` VALUES ('1', '1', '6', 'Test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '1');
INSERT INTO `tbl_notifications` VALUES ('2', '1', '3', 'God may bless you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('3', '1', '4', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('4', '1', '5', 'New Msg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '1');
INSERT INTO `tbl_notifications` VALUES ('5', '3', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('6', '3', '7', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('7', '3', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('8', '3', '8', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('9', '3', '7', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('10', '2', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('11', '2', '2', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('12', '2', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('13', '2', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('14', '2', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('15', '2', '6', 'How are you', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ullamcorper vestibulum lectus, id sollicitudin dui consequat quis. Sed id nisi congue', '2013-09-18', '0');
INSERT INTO `tbl_notifications` VALUES ('19', '6', '1', 'Test', 'RRRRRR', '2014-01-09', '1');
INSERT INTO `tbl_notifications` VALUES ('20', '4', '1', 'How are you', 'EEEEE', '2014-01-09', '1');
INSERT INTO `tbl_notifications` VALUES ('21', '5', '1', 'New Msg', 'Helllo New Msg', '2014-01-09', '1');
INSERT INTO `tbl_notifications` VALUES ('22', '5', '1', 'New Msg', 'RRRR', '2014-01-09', '1');
INSERT INTO `tbl_notifications` VALUES ('23', '6', '1', 'Test', 'RRR', '2014-01-10', '1');

-- ----------------------------
-- Table structure for tbl_payments
-- ----------------------------
DROP TABLE IF EXISTS `tbl_payments`;
CREATE TABLE `tbl_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_purpose` enum('Both','Job Posting','CV Search') NOT NULL,
  `payment_amount` int(255) NOT NULL,
  `payment_subscription_started_on` date NOT NULL,
  `payment_subscription_ends_on` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_is_read` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_payments
-- ----------------------------
INSERT INTO `tbl_payments` VALUES ('1', '121321567', '2013-08-29', 'CV Search', '1000', '2013-08-29', '2013-09-12', '0', '4', '1');
INSERT INTO `tbl_payments` VALUES ('2', '121908190', '2013-08-21', 'Job Posting', '4500', '2013-08-21', '2013-09-30', '0', '4', '1');
INSERT INTO `tbl_payments` VALUES ('3', '011328854', '2013-09-22', 'Both', '79', '2013-09-22', '2013-11-21', '0', '4', '1');

-- ----------------------------
-- Table structure for tbl_profile_view
-- ----------------------------
DROP TABLE IF EXISTS `tbl_profile_view`;
CREATE TABLE `tbl_profile_view` (
  `profile_view_id` int(11) NOT NULL AUTO_INCREMENT,
  `to` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `view_date` date NOT NULL,
  PRIMARY KEY (`profile_view_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_profile_view
-- ----------------------------
INSERT INTO `tbl_profile_view` VALUES ('1', '1', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('2', '1', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('3', '7', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('4', '1', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('5', '4', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('6', '1', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('7', '1', '6', '2013-11-15');
INSERT INTO `tbl_profile_view` VALUES ('8', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('9', '7', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('10', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('11', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('12', '7', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('13', '7', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('14', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('15', '7', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('16', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('17', '6', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('18', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('19', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('20', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('21', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('22', '1', '6', '2013-11-16');
INSERT INTO `tbl_profile_view` VALUES ('23', '7', '6', '2013-11-16');

-- ----------------------------
-- Table structure for tbl_saved_jobs
-- ----------------------------
DROP TABLE IF EXISTS `tbl_saved_jobs`;
CREATE TABLE `tbl_saved_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_saved_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_saved_jobs
-- ----------------------------
INSERT INTO `tbl_saved_jobs` VALUES ('1', '2', '1', '2013-11-01');
INSERT INTO `tbl_saved_jobs` VALUES ('2', '1', '1', '2013-11-01');
INSERT INTO `tbl_saved_jobs` VALUES ('3', '1', '1', '2013-11-01');
INSERT INTO `tbl_saved_jobs` VALUES ('4', '1', '1', '2013-11-01');
INSERT INTO `tbl_saved_jobs` VALUES ('5', '1', '1', '2013-11-01');
INSERT INTO `tbl_saved_jobs` VALUES ('6', '1', '1', '2013-11-03');
INSERT INTO `tbl_saved_jobs` VALUES ('7', '1', '1', '2013-11-03');
INSERT INTO `tbl_saved_jobs` VALUES ('8', '2', '1', '2013-11-03');
INSERT INTO `tbl_saved_jobs` VALUES ('9', '2', '1', '2013-11-03');
INSERT INTO `tbl_saved_jobs` VALUES ('10', '2', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('11', '1', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('12', '1', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('13', '1', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('14', '1', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('15', '2', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('16', '2', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('17', '1', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('18', '1', '1', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('19', '1', '2', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('20', '1', '2', '2013-11-05');
INSERT INTO `tbl_saved_jobs` VALUES ('21', '1', '1', '2013-11-13');
INSERT INTO `tbl_saved_jobs` VALUES ('22', '1', '1', '2013-11-22');
INSERT INTO `tbl_saved_jobs` VALUES ('23', '1', '1', '2013-11-22');
INSERT INTO `tbl_saved_jobs` VALUES ('24', '13', '43', '2014-01-24');
INSERT INTO `tbl_saved_jobs` VALUES ('25', '25', '31', '2014-01-24');
INSERT INTO `tbl_saved_jobs` VALUES ('26', '6', '43', '2014-01-25');
INSERT INTO `tbl_saved_jobs` VALUES ('27', '6', '43', '2014-01-25');

-- ----------------------------
-- Table structure for tbl_saved_resumes
-- ----------------------------
DROP TABLE IF EXISTS `tbl_saved_resumes`;
CREATE TABLE `tbl_saved_resumes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `resume_saved_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_saved_resumes
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_settings
-- ----------------------------
DROP TABLE IF EXISTS `tbl_settings`;
CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `is_direct_input` enum('yes','no') NOT NULL,
  `input_type` enum('text','textarea','combo') NOT NULL,
  `options` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_settings
-- ----------------------------
INSERT INTO `tbl_settings` VALUES ('1', 'Website URL', 'siteurl', 'http://localhost/sybite/jobportal_cake/', 'yes', 'text', '');
INSERT INTO `tbl_settings` VALUES ('2', 'Website Name', 'sitename', 'Job Portal', 'yes', 'text', '');
INSERT INTO `tbl_settings` VALUES ('3', 'Admin From Email', 'adminfromemail', 'webglobesolutions@gmail.com', 'yes', 'text', '');
INSERT INTO `tbl_settings` VALUES ('4', 'Records per Page', 'recsperpage', '20', 'yes', 'text', '');
INSERT INTO `tbl_settings` VALUES ('5', 'Date Format', 'dateformat', 'jS F, Y', 'yes', 'text', '');
INSERT INTO `tbl_settings` VALUES ('6', 'Admin Theme', 'admin-css', 'bootstrap-united', 'no', '', '');
INSERT INTO `tbl_settings` VALUES ('7', 'PayPal ID', 'paypalid', 'accounts@freelanceswitch.com', 'yes', 'text', '');

-- ----------------------------
-- Table structure for tbl_static_page
-- ----------------------------
DROP TABLE IF EXISTS `tbl_static_page`;
CREATE TABLE `tbl_static_page` (
  `static_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `Page_Category` text,
  PRIMARY KEY (`static_page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_static_page
-- ----------------------------
INSERT INTO `tbl_static_page` VALUES ('1', 'Company');
INSERT INTO `tbl_static_page` VALUES ('2', 'Customer Services');
INSERT INTO `tbl_static_page` VALUES ('3', 'Policies');

-- ----------------------------
-- Table structure for tbl_static_page_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_static_page_detail`;
CREATE TABLE `tbl_static_page_detail` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_cat_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `created_on` date DEFAULT NULL,
  `last_updated_on` date DEFAULT NULL,
  `is_front` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_static_page_detail
-- ----------------------------
INSERT INTO `tbl_static_page_detail` VALUES ('3', '1', 'About Company', '<p>About pages are important because they are the place where the user goes to discover more about who/what is behind the site they are visiting. From design studios to apps and online shops, users like to browse a page to find the good old who, where, what, how information about you. And of course there&rsquo;s many different approaches that can be taken when designing an about page. From the very formal to the fun and creative, it&rsquo;s important to go the direction that&rsquo;s fits the personality of you or your company. Today we gathered a some inspiring examples of about pages to show you how different websites are allowing visitor to learn more about them.</p>\r\n', '2013-11-21', '2013-11-21', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('4', '1', 'Advertise With Us', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing...</p>\r\n', '2013-11-21', '2013-11-21', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('5', '1', 'Company Blog', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-21', '2013-11-21', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('6', '2', 'Contact Us', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-22', '2013-11-22', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('7', '2', 'Testimonials', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-22', '2013-11-22', '1', '0');
INSERT INTO `tbl_static_page_detail` VALUES ('8', '2', 'Help', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-22', '2013-11-22', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('9', '3', 'Privacy Policy', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-22', '2013-11-22', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('10', '3', 'Terms Of Use', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-22', '2013-11-22', '1', '1');
INSERT INTO `tbl_static_page_detail` VALUES ('11', '3', 'Cookie Policy', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2013-11-22', '2013-11-22', '1', '1');

-- ----------------------------
-- Table structure for tbl_static_page_detail_copy
-- ----------------------------
DROP TABLE IF EXISTS `tbl_static_page_detail_copy`;
CREATE TABLE `tbl_static_page_detail_copy` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_cat_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `content` text NOT NULL,
  `created_on` date NOT NULL,
  `last_updated_on` date NOT NULL,
  `is_front` int(1) NOT NULL,
  `is_system_genereted` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_static_page_detail_copy
-- ----------------------------
INSERT INTO `tbl_static_page_detail_copy` VALUES ('1', '0', 'Welcome', '', '', '<p>asfdafsdfsdf</p>\r\n', '2013-08-15', '2013-08-15', '1', '0', '1');
INSERT INTO `tbl_static_page_detail_copy` VALUES ('2', '0', 'Job Seeker register', 'lorem ipsum dolor sit amet', 'lorem ipsum dolor sit amet', '<p><span style=\"color:rgb(0, 0, 0); font-family:arial,helvetica,sans; font-size:11px\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget egestas metus. Proin ligula ipsum, tincidunt non hendrerit vitae, tempor quis dolor. Nam felis massa, sagittis sit amet urna a, venenatis volutpat lacus. Proin non cursus eros. Vestibulum pellentesque non felis sit amet sagittis. Curabitur ut pretium sapien. Nullam egestas facilisis turpis, eget dapibus justo vulputate eget. Etiam rutrum malesuada hendrerit. Nam scelerisque sollicitudin tellus, et scelerisque diam. Donec ac risus at libero elementum facilisis in id sapien. Aliquam erat volutpat. In molestie velit justo, sit amet consectetur nisl vehicula nec. Phasellus a mi magna.</span></p>\r\n', '2013-08-18', '2013-08-18', '0', '1', '1');
INSERT INTO `tbl_static_page_detail_copy` VALUES ('3', '0', 'Log into your A/c', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', '<p><span style=\"color:rgb(0, 0, 0); font-family:arial,helvetica,sans; font-size:11px\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.</span></p>\r\n', '2013-08-18', '2013-08-18', '0', '1', '1');
INSERT INTO `tbl_static_page_detail_copy` VALUES ('4', '0', 'Employer Register', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', '<p><span style=\"color:rgb(0, 0, 0); font-family:arial,helvetica,sans; font-size:11px\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.</span></p>\r\n', '2013-08-18', '2013-08-18', '0', '1', '1');
INSERT INTO `tbl_static_page_detail_copy` VALUES ('5', '0', 'Job Seeker Dashboard', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris leo justo, porttitor ut dignissim vel, aliquet sed neque. Ut dignissim dictum nibh, quis rhoncus nulla tincidunt ac. Proin quis condimentum lorem. Aenean gravida sem eget cursus euismod. Vestibulum bibendum elementum laoreet. In mollis risus ut bibendum convallis. Suspendisse eu vestibulum diam, a interdum sem. Vestibulum eu tempor urna. Sed at ullamcorper dui. Praesent auctor pulvinar ante sed ornare. Vivamus tellus enim, iaculis faucibus orci vitae, commodo volutpat quam. Nullam ac ornare lacus. Sed enim sapien, aliquam at tortor vel, tempus tincidunt urna. In luctus viverra odio, vel dignissim nisi sodales vel. Nullam metus eros, faucibus in consectetur eget, interdum ac est.', '2013-08-18', '2013-08-18', '0', '1', '1');
INSERT INTO `tbl_static_page_detail_copy` VALUES ('6', '0', 'Advanced Job Search', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae mauris pulvinar, egestas odio volutpat, fermentum lorem. Maecenas in gravida erat. Sed consectetur dui vel tempus congue. Praesent fermentum odio a luctus mattis. Sed lorem purus, mattis eu iaculis nec, consequat nec odio.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae mauris pulvinar, egestas odio volutpat, fermentum lorem. Maecenas in gravida erat. Sed consectetur dui vel tempus congue. Praesent fermentum odio a luctus mattis. Sed lorem purus, mattis eu iaculis nec, consequat nec odio.', '', '2013-09-12', '2013-09-12', '0', '1', '1');

-- ----------------------------
-- Table structure for tbl_sub_admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sub_admin_permissions`;
CREATE TABLE `tbl_sub_admin_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_sub_admin_permissions
-- ----------------------------
INSERT INTO `tbl_sub_admin_permissions` VALUES ('1', 'Manage Sub-Admins');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('2', 'Add Sub-Admin');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('3', 'Edit Sub-Admin');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('4', 'Delete Sub-Admin');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('5', 'Manage Employers');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('6', 'Add Employer');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('7', 'Edit Employer');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('8', 'Delete Employer');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('9', 'Manage Job Seeker');
INSERT INTO `tbl_sub_admin_permissions` VALUES ('10', 'Add Job Seeker');

-- ----------------------------
-- Table structure for tbl_userchild
-- ----------------------------
DROP TABLE IF EXISTS `tbl_userchild`;
CREATE TABLE `tbl_userchild` (
  `user_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_name` text NOT NULL,
  PRIMARY KEY (`user_child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_userchild
-- ----------------------------
INSERT INTO `tbl_userchild` VALUES ('1', '1', 'Data Infosis');
INSERT INTO `tbl_userchild` VALUES ('2', '1', 'The Web & Soft');
INSERT INTO `tbl_userchild` VALUES ('3', '1', 'T Media');
INSERT INTO `tbl_userchild` VALUES ('4', '1', 'Sybite Technologies');
INSERT INTO `tbl_userchild` VALUES ('5', '1', 'India solutions');

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` enum('Job Seeker','Employer') NOT NULL DEFAULT 'Job Seeker',
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone_country_code` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_phone_extn_code` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `user_number_of_dependants` varchar(255) NOT NULL,
  `user_nationality` int(11) NOT NULL,
  `user_address_line_1` varchar(255) NOT NULL,
  `user_address_line_2` varchar(255) NOT NULL,
  `Residence_Location` varchar(255) DEFAULT NULL,
  `user_country` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_language_preference` varchar(255) NOT NULL,
  `user_dob` date NOT NULL,
  `user_marital_status` enum('Unmarried','Married','Divorced') NOT NULL,
  `user_education` int(11) NOT NULL,
  `user_experience` int(11) NOT NULL,
  `user_experience_year` int(11) NOT NULL,
  `user_career_level` varchar(255) NOT NULL,
  `user_skills_n_expertise` text NOT NULL,
  `user_profile_summary` text NOT NULL,
  `user_resume` varchar(255) NOT NULL,
  `user_company` varchar(255) NOT NULL,
  `user_employer_type` varchar(255) NOT NULL,
  `user_company_address_line_1` varchar(255) NOT NULL,
  `user_company_address_line_2` varchar(255) NOT NULL,
  `user_po_box` varchar(255) NOT NULL,
  `user_company_state` varchar(255) NOT NULL,
  `user_company_city` varchar(255) NOT NULL,
  `user_zip` varchar(255) NOT NULL,
  `user_company_country` int(11) NOT NULL,
  `user_company_web_url` varchar(255) NOT NULL,
  `user_company_personal_designation` varchar(255) NOT NULL,
  `user_company_phone_country_code` varchar(255) NOT NULL,
  `user_company_phone_number` varchar(255) NOT NULL,
  `user_company_phone_ext` varchar(255) NOT NULL,
  `user_company_fax_country_code` varchar(255) NOT NULL,
  `user_company_fax_number` varchar(255) NOT NULL,
  `user_company_fax_ext` varchar(255) NOT NULL,
  `user_company_evening_phone_country_code` varchar(255) NOT NULL,
  `user_company_evening_phone` varchar(255) NOT NULL,
  `user_company_evening_phone_extension_code` varchar(255) NOT NULL,
  `user_mobile_country_code` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_fax_country_code` varchar(255) NOT NULL,
  `user_fax_number` varchar(255) NOT NULL,
  `user_fax_ext` varchar(255) NOT NULL,
  `user_company_detail` text NOT NULL,
  `user_industry` int(11) NOT NULL,
  `user_annual_revenue` varchar(255) NOT NULL,
  `user_number_of_employees` varchar(255) NOT NULL,
  `user_job_posting_membership_taken_on` date NOT NULL,
  `user_jobs_available` int(11) NOT NULL,
  `user_jobs_expire_on` date NOT NULL,
  `user_featured_jobs_available` int(11) NOT NULL,
  `user_featured_jobs_expire_on` date NOT NULL,
  `user_resume_membership_taken_on` date NOT NULL,
  `user_resume_membership_expires_on` date NOT NULL,
  `user_resume_membership` varchar(255) NOT NULL,
  `user_payment_method` enum('PayPal','Google','Credit Card','Invoice') NOT NULL,
  `user_credit_card_type` varchar(255) NOT NULL,
  `user_credit_card_fname` varchar(255) NOT NULL,
  `user_credit_card_lname` varchar(255) NOT NULL,
  `user_credit_card_number` varchar(255) NOT NULL,
  `user_credit_card_cvn` varchar(255) NOT NULL,
  `user_credit_card_expiry_date_month` varchar(255) NOT NULL,
  `user_credit_card_expiry_date_year` int(4) NOT NULL,
  `user_created_on` date NOT NULL,
  `user_last_sign_in` date NOT NULL,
  `user_last_IP` varchar(255) NOT NULL,
  `user_param` varchar(255) NOT NULL,
  `user_verified` int(1) NOT NULL,
  `user_is_new` int(1) NOT NULL,
  `user_is_blocked` int(1) NOT NULL,
  `user_profile_views` int(11) NOT NULL,
  `map_code` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES ('1', 'Job Seeker', 'Akash', 'Nair', 'say2me84@gmail.com', '91', '8442059348', '', '1867.jpg', '0192023a7bbd73250516f069df18b500', 'Male', '', '1', '', '', null, '76', 'Jaipur', 'English', '1990-06-01', 'Unmarried', '7', '1', '0', '1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s. When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s. When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.', 'Job Seeker_Akash Nair_06-Jan-2014_411.png', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '28', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '076a0c97d09cf1a0ec3e19c7f2529f2b', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('2', 'Employer', 'Rahul', 'Verma', 'rahul@gmail.com', '+91', '8442059348', '8442059300', '1867_2.jpg', '0192023a7bbd73250516f069df18b500', 'Male', '', '1', 'Rajasthan', 'Jaipur222', '76', '1', 'Jaipur', 'English', '1995-01-01', 'Married', '6', '0', '0', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s. When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.', 'We live with your dream to Create, inspire and Transform your Digital Identities into an emerging BRAND. We’re an Independent digital design, development and branding agency who strives to provide a better solution to all your business needs.', '', 'Sybite', '', '100 Potrero Avenue', 'San Francisco, California 94103', '1111', 'Rajasthan', 'Jaipur', '1313', '76', 'http://www.sybite.com', ' HR Manager', '+22', '55555', '4444', '+88', '888', '0888', '+11', '0000', '111', '+11', '1111', '+91', '111', '3333', 'We live with your dream to Create, inspire and Transform your Digital Identities into an emerging BRAND. We’re an Independent digital design, development and branding agency who strives to provide a better solution to all your business needs.', '28', '10000', '50-99 employees', '2013-12-13', '420', '2014-01-23', '172', '0000-00-00', '2014-01-11', '2015-08-01', '0000-00-00', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '076a0c97d09cf1a0ec3e19c7f2529f2b', '1', '0', '1', '0', '<iframe width=\"410\" height=\"317\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=100+Potrero+Avenue,+San+Francisco,+California+94103,+United+States&amp;aq=0&amp;oq=100+Potrero+Avenue,+San+Francisco,+California+94103&amp;sll=26.885211,75.790558&amp;sspn=0.342346,0.676346&amp;ie=UTF8&amp;hq=&amp;hnear=100+Potrero+Ave,+San+Francisco,+California+94103,+United+States&amp;t=m&amp;ll=37.768069,-122.408295&amp;spn=0.021508,0.036049&amp;z=14&amp;output=embed\"></iframe>');
INSERT INTO `tbl_users` VALUES ('17', 'Employer', 'amit', 'amit', 'amit@gmail.com', '', '', '', '', 'd2b3f63948406cb893544cee035531d3', 'Male', '', '1', '', '', null, '76', 'Jaipur', 'English', '2014-01-02', 'Unmarried', '0', '0', '0', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s. When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s. When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '076a0c97d09cf1a0ec3e19c7f2529f2b', '0', '0', '1', '1', '');
INSERT INTO `tbl_users` VALUES ('19', 'Job Seeker', 'mahesh', 'jain', 'mahesh@mailinator.com', '', '', '', '', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '2', '', '', null, '186', 'Los Angeles', 'English', '1982-01-07', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '076a0c97d09cf1a0ec3e19c7f2529f2b', '1', '0', '1', '1', '');
INSERT INTO `tbl_users` VALUES ('20', 'Employer', 'Andre', 'Y', 'andre@mailinator.com', '+11', '222780', '210', '20436.png', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '2', '123 NY', 'ttyuy  uu ', '186', '186', 'Newyork', 'English', '2014-01-12', 'Unmarried', '0', '0', '0', '', '', 'EMASCO- First Select UAE is a premier recruitment Consultancy based in UAE since 1983. EMASCO-First Select UAE is the UAE entity of First Select International that has presence in several countries including Bahrain, Egypt, India, Pakistan, Philippines, Poland, Nepal and the UAE. Within the UAE we have three branches: Abu Dhabi, Dubai and Ajman. EMASCO- First Select UAE Provides Executive Search, Overseas Recruitment and Contract Staffing Services for contingencies as well as for turnkey projects. EMASCO- First Select UAE is a registered HR consultancy to some of the regions major National Oil Companies, Hospitals, Banks, Hotels, Security Service Providers, Multinational Corporations and other Government departments in the UAE and the Gulf region. EMASCO- First Select UAE incorporates a rapidly growing databank of top quality professionals and provides our clients with the very best talent. Our qualified and multi-cultural teams of professional consultants aim to provide our clients with an objective and qualitative recruitment process. This involves a through understanding of the clients needs followed by adoption of appropriate means of sourcing potential candidates, including database search, headhunting and advertisement in local, regional and international newspapers, campus selections. Visit our website www.firstselectuae.com for further information.', '', 'EMASCO - First Select UAE', '', '123 NY', 'ttyuy  uu ', 'NY', 'NY', 'Newyork', '10458', '186', 'www.firstselectuae.com', 'CEO', '+11', '222780', '210', '+11', '222783', '211', '+11', '2345678', '234', '+1', '12345678', '+11', '2345676', '234', 'EMASCO- First Select UAE is a premier recruitment Consultancy based in UAE since 1983. EMASCO-First Select UAE is the UAE entity of First Select International that has presence in several countries including Bahrain, Egypt, India, Pakistan, Philippines, Poland, Nepal and the UAE. Within the UAE we have three branches: Abu Dhabi, Dubai and Ajman. EMASCO- First Select UAE Provides Executive Search, Overseas Recruitment and Contract Staffing Services for contingencies as well as for turnkey projects. EMASCO- First Select UAE is a registered HR consultancy to some of the regions major National Oil Companies, Hospitals, Banks, Hotels, Security Service Providers, Multinational Corporations and other Government departments in the UAE and the Gulf region. EMASCO- First Select UAE incorporates a rapidly growing databank of top quality professionals and provides our clients with the very best talent. Our qualified and multi-cultural teams of professional consultants aim to provide our clients with an objective and qualitative recruitment process. This involves a through understanding of the clients needs followed by adoption of appropriate means of sourcing potential candidates, including database search, headhunting and advertisement in local, regional and international newspapers, campus selections. Visit our website www.firstselectuae.com for further information.', '12', '10000', '50-99 employees', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '2e65f2f2fdaf6c699b223c61b1b5ab89', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('21', 'Job Seeker', 'Chao', 'Chao', 'Chao@mailinator.com', '', '8825858150', '', '', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '4', '', '', null, '36', 'Beijing', 'English', '1985-01-08', 'Unmarried', '0', '0', '0', '1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'b3e3e393c77e35a4a3f3cbd1e429b5dc', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('22', 'Employer', 'John ', 'S', 'john@mailinator.com', '+1', '2227803', '298', '22374.png', '928b6497cee0f6d40abfc84461c4c511', 'Female', '', '2', '234 ca', 'as dff hhh', '186', '186', 'California', 'English', '0000-00-00', 'Unmarried', '0', '0', '0', '', '', 'UAE Exchange is the brain-child of visionaries H.E. Abdulla Humaid Ali Al Mazroei, Chairman and Dr. B. R. Shetty, MD and CEO. Established in 1980, UAE Exchange has today grown to become the leading global remittance and foreign exchange brand, spread across five continents with 555 direct offices in 29 countries.', '', 'UAE Exchange Centre', '', '123 ca', 'ttyuy  uu ', 'CA', 'CA', 'california', '104523', '186', 'www.uaeexchange.com', 'MD', '+1', '2227803', '123', '+1', '2227800', '121', '+1', '2227803', '234', '+1', '23478990', '+1', '234567678', '239', 'UAE Exchange is the brain-child of visionaries H.E. Abdulla Humaid Ali Al Mazroei, Chairman and Dr. B. R. Shetty, MD and CEO. Established in 1980, UAE Exchange has today grown to become the leading global remittance and foreign exchange brand, spread across five continents with 555 direct offices in 29 countries.', '28', '20000', '100-499 employees', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'c3c59e5f8b3e9753913f4d435b53c308', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('23', 'Employer', 'Yujine', 'R', 'Yujine@mailinator.com', '617', '349-6588', '123', '23596.png', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '3', '225 Windsor ', 'St Cambridge, MA, United States', '185', '185', 'London', 'English', '2014-01-12', 'Unmarried', '0', '0', '0', '', '', 'IMECO is an ISO - 9001-2000 company certified by BVQI for civil , Electro-Mechanical , Instrumentation , Landscaping/Irrigation contracting , General maintenance and Technical Manpower Supply.The company is also a proud member of the British Safety Council and has an exceptional track record for zero Lost Time Accidents in very sector\r\n\r\nIMECO also has a strong presence in the oil sector,havining maintained good relations and completed contracts for all the oil related companies based in the Abu Dhabi Region', '', 'IMECO', '', '225 Windsor ', 'St Cambridge', 'MA 02139', 'MA', 'London', 'MA 02139', '185', 'http://www.imeco.com/', 'CEO', '617', '349-6588', '123', '617', '349-65889', '000', '617', '349-6580', '678', '12', '3496580', '617', '349-6581', '123', 'IMECO is an ISO - 9001-2000 company certified by BVQI for civil , Electro-Mechanical , Instrumentation , Landscaping/Irrigation contracting , General maintenance and Technical Manpower Supply.The company is also a proud member of the British Safety Council and has an exceptional track record for zero Lost Time Accidents in very sector\r\n\r\nIMECO also has a strong presence in the oil sector,havining maintained good relations and completed contracts for all the oil related companies based in the Abu Dhabi Region', '28', '25000', '500 employees or more', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '8eefcfdf5990e441f0fb6f3fad709e21', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('24', 'Employer', 'Rick ', 'Marks', 'rick@mailinator.com', '617', '495-1000', '555', '24268.png', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '3', '45 Francis ', 'Ave Cambridge', '185', '185', 'Cambridge', 'English', '2014-01-21', 'Unmarried', '0', '0', '0', '', '', 'Greenland UAE is your short way to find the best suited job for your qualification and skills. We pamper our clients and candidates by finding them effective employees and professional career. Globally we supply HR talent to a complete cross section of Clients from the world’s largest companies to a small business across all HR specialism and consultation.', '', 'Greenland ', '', '459 Broadway', 'Francis Ave', 'MA 02138', 'MA', 'Cambridge', 'MA 02138', '185', 'http://www.greenlanduae.com/', 'MD', '617', '222780', '210', '617', '2227800', '000', '617', '495-1010', '333', '617', '495-1010', '617', '495-1010', '222', 'Greenland UAE is your short way to find the best suited job for your qualification and skills. We pamper our clients and candidates by finding them effective employees and professional career. Globally we supply HR talent to a complete cross section of Clients from the world’s largest companies to a small business across all HR specialism and consultation.', '26', '110000', '100-499 employees', '2014-01-23', '30', '2014-02-22', '0', '0000-00-00', '2014-01-23', '2014-02-22', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '36660e59856b4de58a219bcf4e27eba3', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('25', 'Employer', 'TOM', 'Sharma', 'tom@mailinator.com', '+97', '126562000', '', '25332.png', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '12', 'Abu Dhabi', 'ttyuy  uu ', '184', '184', 'Abu dhabi', 'English', '1986-01-30', 'Unmarried', '0', '0', '0', '', '', 'Set on the shore of alluring Yas Island, the Radisson Blu Abu Dhabi is awash in Gulf coast sunshine and close to all the attractions that draw travellers to this island paradise. Visitors can readily reach the Formula 1® racetrack, Ferrari World theme park and Yas Links golf course. Linger over dinner at your choice of on-site dining venues, or recharge with a game of tennis at the hotel\'s own courts. After a fun day of sightseeing, revitalise with a soothing aromatherapy session at the top-tier spa.', '', 'Radisson Blu', '', 'Golf Plaza Yas Island', 'Abu Dhabi', '4009', 'Abu Dhabi', 'Abu Dhabi', 'AB4009', '184', '', 'CEO', '+97', '222780', '', '+97', '126562022', '11', '+97', '126562001', '', '+97', '126562010', '', '', '', 'Set on the shore of alluring Yas Island, the Radisson Blu Abu Dhabi is awash in Gulf coast sunshine and close to all the attractions that draw travellers to this island paradise. Visitors can readily reach the Formula 1® racetrack, Ferrari World theme park and Yas Links golf course. Linger over dinner at your choice of on-site dining venues, or recharge with a game of tennis at the hotel\'s own courts. After a fun day of sightseeing, revitalise with a soothing aromatherapy session at the top-tier spa.', '26', '100000', '100-499 employees', '2014-01-23', '15', '2014-02-22', '0', '0000-00-00', '2014-01-23', '2014-02-22', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '8e6b42f1644ecb1327dc03ab345e618b', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('27', 'Employer', 'chris', 'A', 'chris@mailinator.com', '', '', '', '', '928b6497cee0f6d40abfc84461c4c511', 'Male', '', '12', '', '', null, '184', 'Dubai', 'Arabic', '1988-06-15', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '69adc1e107f7f7d035d7baf04342e1ca', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('28', 'Job Seeker', 'jobber', 'jobber', 'jobber@mailinator.com', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '1', '', '', null, '76', 'Jodhpur', 'English', '2014-01-25', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '4b0250793549726d5c1ea3906726ebfe', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('29', 'Job Seeker', 'amit', 'rao', 'amit.sybite@gmail.com', '1212', '1212', '1222122121', '', '0cb1eb413b8f7cee17701a37a1d74dc3', 'Male', '', '1', 'drdfdsdsds', 'fdsfdsf', '18', '76', 'jaipur', 'English', '1990-04-19', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '302010', '', '', '302010', '0', '2122asdsa2d2', '', '', '', '', '', '', '', '121', '1212', '12122', '1212', '212121212', '1212', '1222', '1222', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '555d6702c950ecb729a966504af0a635', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('30', 'Employer', 'amit', 'rao', 'emp1@mailinator.com', '12', '121212', '121212', '30152.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '12', 'jaipur', 'jaipur', '2', '15', 'jaipur', 'English', '2014-01-09', 'Unmarried', '0', '0', '0', '', '', 'Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing ', '', 'Bastion', '', 'jaipur1', 'jaiopur2', '302010', 'rajasthan', 'jaipur', '302010', '75', 'www.com', 'IT', '12', '1212121', '2121211', '21221', '12121', '21222', '1212', '12121212', '121121', '12', '121212', '12', '121212', '1212', 'Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing Internet marketing ', '28', '12002', '1-9 employees', '0000-00-00', '9', '0000-00-00', '4', '0000-00-00', '2014-01-21', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '4f4adcbf8c6f66dcfc8a3282ac2bf10a', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('31', 'Employer', 'Symantec', 'technology', 'Symantec@mailinator.com', '022', '2451254256', '1254', '31549.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', 'A 34 Behind temple ', 'New your ', '186', '186', 'Newyork', 'English', '2014-01-16', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'Symantec', '', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '19 Interpro Road Madison, AL 35758, USA', '302010', 'Huntsville', 'new york', '240000', '186', 'www.google.com', 'Ceo', '22', '124545', '1212', '1212', '1212121', '2121212', '124565', '1545', '154545', '22', '2545124512', '4511265698', '6598445', '35455646', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '28', '15000', '1-9 employees', '0000-00-00', '13', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'fa83a11a198d5a7f0bf77a1987bcd006', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('32', 'Employer', 'VMware', 'tech', 'VMware@mailinator.com', '91', '9878545878', '4548', '32898.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '19 Interpro Road Madison, AL 35758, USA', '14', '8', 'london', 'English', '2014-01-10', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'VMware pvt Ltd', '', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '19 Interpro Road Madison, AL 35758, USA', '214400', 'Huntsville', 'Huntsville', '240001', '15', '454522', 'HR', '022', '8578548856', '65', '022', '155445', '02122', '22', '454858555', '45485', '5455', '985785', '022', '12451245', '124526', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '34', '40000', '1-9 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'b056eb1587586b71e2da9acfe4fbd19e', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('33', 'Employer', 'Fiserv', 'LLC', 'Fiserv@mailinator.com', '022', '1214521452', '1512', '33789.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '3', '19 Interpro Road Madison, AL 35758, USA', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '16', '5', 'london', 'English', '2014-01-15', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'Fiserv LLC', '', ' 19 Interpro Road Madison, AL 35758, USA', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '20102', 'Huntsville', 'Huntsville', '201030', '14', 'www.vmare.com', 'HR', '022', '12451245', '125', '022', '15454121', '1551', '011', '0225222', '12151', '011', '15425401254', '022', '022112', '012121', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '8', '45000', '1-9 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '86b122d4358357d834a87ce618a55de0', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('34', 'Employer', 'ntuit', 'tech', 'Intuit@mailinator.com', '044', '25452114222', '1215', '34724.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '4', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '19 Interpro Road Madison, AL 35758, USA', '5', '5', 'Huntsville', 'English', '2014-01-08', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'ntuit pvt ltd', '', '19 Interpro Road Madison, AL 35758, USA', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '20120', 'Madison', 'Madison', '201002', '8', 'www.intute.com', 'CEo', '011', '0213244115', '01215221', '022', '15511132', '052313133', '011', '2154122121', '21212', '011', '1541212121', '02121', '021512111', '212', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '10', '45000', '1-9 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'c042f4db68f23406c6cecf84a7ebb0fe', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('35', 'Employer', 'Amadeus ', 'IT Group', 'Amadeus @mailinator.com', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', '', '', null, '7', 'Madison', 'English', '2014-01-21', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'a532400ed62e772b9dc0b86f46e583ff', '0', '1', '0', '0', '');
INSERT INTO `tbl_users` VALUES ('36', 'Employer', 'Amadeus IT Group', 'pvt', 'Amadeus@mailinator.com', '022', '0124413', '1111', '36207.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '1', ' P.O. Box 240000 Huntsville, AL 35813, USA ', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '4', '5', 'Huntsville', 'English', '2014-01-15', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'Amadeus IT Group', '', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '201200', 'Huntsville', 'Huntsville', '120200', '10', 'www.google.com', 'CEo', '022', '0121112', '12121212', '21212', '1211', '2121', '11141', '21212121', '31231211', '11121', '2151', '21215', '21211', '12212', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '2', '45220', '50-99 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'a5e00132373a7031000fd987a3c9f87b', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('37', 'Employer', 'KLM', 'technosoft', 'KLM@mailinator.com', '022', '12121212', '1212111', '37747.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '3', 'P.O. Box 240000 Huntsville, AL 35813, USA', 'P.O. Box 240000 Huntsville, AL 35813, USA', '2', '3', 'jaipur', 'English', '2014-01-16', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'KLM  Softwares', '', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '201010', 'Madison', 'Madison', '02020', '6', 'www.it.com', 'CEo', '211', '11', '11', '11', '111', '1', '21221', '211', '1', '11', '1121', '22', '12212', '111', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '10', '45222', '1-9 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'a4f23670e1833f3fdb077ca70bbd5d66', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('38', 'Employer', 'Vodafon', 'group', 'Vodafone@mailinator.com', '15454', '544544', '44445', '38810.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '12', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '3', '2', 'Mumbai', 'English', '2014-01-04', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'Vodafone Group', '', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '3211121', 'USA', 'New your', '212121', '3', 'www.company.com', 'HR recruitor', '1545', '21215211', '11122', '1211', '112', '2311212', '444', '444', '45', '44544', '55454', '4454545', '4545454', '5445', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '8', '52252', '1-9 employees', '0000-00-00', '20', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'c9892a989183de32e976c6f04e700201', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('39', 'Employer', 'AstraZeneca', 'Zeneca', 'AstraZeneca@mailinator.com', '022', '2125415652', '255', '39774.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '3', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '', '1', '8', 'Huntsville', 'English', '2014-01-20', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'AstraZeneca', '', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '', 'newyourk', 'newyourk', '21020', '10', 'www.shgs.com', 'CEO', '011', '021545121145', '121512', '014', '545212125', '154521', '022', '245215', '25552', '011', '1458452556', '011', '0254555', '45454', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '6', '54222', '1-9 employees', '0000-00-00', '29', '0000-00-00', '4', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '202cb962ac59075b964b07152d234b70', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('40', 'Employer', 'Barclays', 'tech ', 'Barclays@mailinator.com', '065', '02121210', '21022', '40822.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', ' P.O. Box 240000 Huntsville, AL 35813, USA ', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '2', '2', 'London', 'English', '2014-01-23', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '', 'Barclays plc', '', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '45604464', 'Huntsville', 'Huntsville', '465460', '7', 'www.dash.com', 'Director', '011', '0252152121', '1525121', '2120', '115121', '12110', '101', '021211', '02121', '012', '14545645', '045440', '5405', '4045', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries.', '34', '45652', '1-9 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '9be40cee5b0eee1462c82c6964087ff9', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('41', 'Employer', 'BAE ', 'System', 'BAE@mailinator.com', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', '', '', null, '8', 'london', 'English', '2014-01-08', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'b55ec28c52d5f6205684a473a2193564', '0', '1', '0', '0', '');
INSERT INTO `tbl_users` VALUES ('42', 'Employer', 'BAe ', 'system', 'BAE1@mailinator.com', '022', '32464', '21131', '42313.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', ' P.O. Box 240000 Huntsville, AL 35813, USA ', ' P.O. Box 240000 Huntsville, AL 35813, USA ', '2', '6', 'new york', 'English', '2014-01-23', 'Unmarried', '0', '0', '0', '', '', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries', '', 'BAE Systems', '', '19 Interpro Road Madison, AL 35758, USA', '19 Interpro Road Madison, AL 35758, USA', '156412', 'Huntsville', 'Huntsville', '114313', '4', 'www.skjdf.com', 'HR ', '0222', '5112121', '121121', '011', '152151', '01221', '3131321', '1212111', '2115212', '2112135', '25331', '2154131', '5215', '15213', 'Process, Power & Marine (PP&M) Intergraph® PP&M is the world\'s leading provider of enterprise engineering software dedicated to the Process, Power & Marine industries', '5', '48554', '1-9 employees', '0000-00-00', '19', '0000-00-00', '11', '0000-00-00', '2014-01-23', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '25b2822c2f5a3230abfadd476e8b04c9', '1', '0', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('43', 'Job Seeker', 'Jackson ', 'denis', 'Jackson@mailinator.com', '', '015845854585', '', '43222.png', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', '', '', null, '14', 'Huntsville', 'English', '2014-01-09', 'Unmarried', '0', '0', '0', '1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Job Seeker_Jackson _24-Jan-2014_532.docx', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '7d04bbbe5494ae9d2f5a76aa1c00fa2f', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('44', 'Job Seeker', 'Marle ', 'denis', 'Marle@mailinator.com', '', '064864604564', '', '44839.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', '', '', null, '13', 'Sheikh ', 'English', '2014-01-08', 'Unmarried', '0', '0', '0', '1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'db8e1af0cb3aca1ae2d0018624204529', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('45', 'Job Seeker', 'Jonna', 'sers', 'Jonna@mailinator.com', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '', '2', '', '', null, '7', 'fsdf', 'English', '2014-01-09', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '0fcbc61acd0479dc77e3cccc0f5ffca7', '0', '1', '0', '0', '');
INSERT INTO `tbl_users` VALUES ('46', 'Job Seeker', 'Jonna', 'fsdfr', 'Jonna1@mailinator.com', '', '334564404564', '', '46814.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '', '3', '', '', null, '2', 'sasd', 'English', '2014-01-17', 'Unmarried', '0', '0', '0', '3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'a8baa56554f96369ab93e4f3bb068c22', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('47', 'Job Seeker', 'Damues ', 'denis', 'Damues@mailinator.com', '', '5665456456', '', '47880.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', '', '', null, '7', 'dfhds', 'English', '2014-01-22', 'Unmarried', '0', '0', '0', '2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '22fb0cee7e1f3bde58293de743871417', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('48', 'Job Seeker', 'Andina ', 'dsfs', 'Andina@mailinator.com', '', '549846546', '', '48688.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '', '12', '', '', null, '3', 'Sheikh ', 'English', '2014-01-23', 'Unmarried', '0', '0', '0', '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. \r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '8d6dc35e506fc23349dd10ee68dabb64', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('49', 'Job Seeker', 'Eleena', 'hgyhr', 'Eleena@mailinator.com', '', '64164646', '', '49577.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '', '4', '', '', null, '13', 'asdf', 'English', '2014-01-08', 'Divorced', '0', '0', '0', '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nvc\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '86b122d4358357d834a87ce618a55de0', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('50', 'Job Seeker', 'Joya ', 'khan', 'joya@mailinator.com', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '', '12', '', '', null, '14', 'Prinsengracht ', 'English', '2014-01-03', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '069059b7ef840f0c74a814ec9237b6ec', '0', '1', '0', '0', '');
INSERT INTO `tbl_users` VALUES ('51', 'Job Seeker', 'Eleena', 'denis', 'Eleena1@mailinator.com', '', '156456435143', '', '51326.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '', '12', '', '', null, '1', 'sdfsdf', 'English', '2014-01-08', 'Unmarried', '0', '0', '0', '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', 'c0f168ce8900fa56e57789e2a2f2c9d0', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('52', 'Job Seeker', 'Clifton', 'ton', 'clif@mailinator.com', '', '65464646', '', '52171.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '4', '', '', null, '5', 'fsdfsdf', 'English', '2014-01-09', 'Married', '0', '0', '0', '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '40008b9a5380fcacce3976bf7c08af5b', '1', '1', '1', '0', '');
INSERT INTO `tbl_users` VALUES ('53', 'Job Seeker', 'Frinky', 'sdfsd', 'Frinky@mailinator.com', '', '', '', '', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '12', '', '', null, '16', 'sdfsdf', 'English', '2014-01-15', 'Unmarried', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '0e01938fc48a2cfb5f2217fbfb00722d', '0', '1', '0', '0', '');
INSERT INTO `tbl_users` VALUES ('54', 'Job Seeker', 'Frinky', 'sdfds', 'Frinky1@mailinator.com', '', '654530534', '', '54514.jpg', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '2', '', '', null, '12', 'Amsterdam', 'English', '2014-01-22', 'Divorced', '0', '0', '0', '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '0000-00-00', '0', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', 'PayPal', '', '', '', '', '', '', '0', '0000-00-00', '0000-00-00', '', '98b297950041a42470269d56260243a1', '1', '1', '1', '0', '');

-- ----------------------------
-- Table structure for tbl_user_education
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_education`;
CREATE TABLE `tbl_user_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `degree` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL,
  `starting_year` int(4) NOT NULL,
  `finishing_year` int(4) NOT NULL,
  `is_heighest` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_user_education
-- ----------------------------
INSERT INTO `tbl_user_education` VALUES ('1', '6', 'West Bengal University of Technology', '2005', '2009', '1', '1');
INSERT INTO `tbl_user_education` VALUES ('2', '4', 'West Bengal Higher Education Commission', '2002', '2004', '0', '1');
INSERT INTO `tbl_user_education` VALUES ('3', '4', 'West Bengal Secondary Education', '1997', '2002', '0', '1');
INSERT INTO `tbl_user_education` VALUES ('4', '6', 'West Bengal University of Technology', '2005', '2009', '0', '43');
INSERT INTO `tbl_user_education` VALUES ('5', '2', 'RGTU', '2002', '2009', '0', '43');

-- ----------------------------
-- Table structure for tbl_user_experience
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_experience`;
CREATE TABLE `tbl_user_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `responsibility` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `employment_period_from` varchar(255) NOT NULL,
  `employment_period_to` varchar(255) NOT NULL,
  `exp_year` int(11) NOT NULL,
  `exp_month` int(11) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `is_current` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_user_experience
-- ----------------------------
INSERT INTO `tbl_user_experience` VALUES ('1', 'Senior php developer', 'sybite', 'Jaipur', 'Web Development, Maintenence', '5185.jpg', 'Sep, 2013', 'December, 2007', '5', '0', '10,000', '1', '1');
INSERT INTO `tbl_user_experience` VALUES ('2', 'Senior Web Developer', 'Web Globe Solutions & Services Ltd.', 'Jaipur', 'Web Development, CMS, Maintenence', '', 'April, 2008', 'August, 2013', '0', '3', '12,000', '0', '1');
INSERT INTO `tbl_user_experience` VALUES ('3', 'Web Developer', 'Sybite', 'Jaipur', 'Web Development, CMS, Maintenence', '', 'April, 2008', 'August, 2013', '2', '3', '15,000', '1', '6');
INSERT INTO `tbl_user_experience` VALUES ('4', 'Senior php developer', 'Sybite', 'Jaipur', 'Web Development, Maintenence', '', 'Sep, 2013 ', 'December, 2014', '1', '1', '25000', '1', '43');

-- ----------------------------
-- Table structure for user_plan_details
-- ----------------------------
DROP TABLE IF EXISTS `user_plan_details`;
CREATE TABLE `user_plan_details` (
  `Plan_Sno` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `Invoice` varchar(255) NOT NULL,
  `membership_plan_name` varchar(255) NOT NULL,
  `job_posting_membership_start_dt` date NOT NULL,
  `job_posting_membership_expire` date NOT NULL,
  `user_normal_jobs_val` int(11) NOT NULL,
  `user_featured_jobs_start_dt` date NOT NULL,
  `user_featured_jobs_expire` date NOT NULL,
  `user_featured_jobs_val` int(11) NOT NULL,
  `user_resume_membership_start_dt` date NOT NULL,
  `user_resume_membership_expires` date NOT NULL,
  `user_resume_membership_val` int(11) NOT NULL,
  `Amt` int(11) NOT NULL,
  PRIMARY KEY (`Plan_Sno`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_plan_details
-- ----------------------------
INSERT INTO `user_plan_details` VALUES ('58', '2', '5000', 'Job Plan', '2014-01-10', '2014-02-09', '10', '2014-01-10', '2014-02-09', '4', '2014-01-10', '2014-01-30', '20', '50');
INSERT INTO `user_plan_details` VALUES ('59', '2', '5001', 'Job Plan', '2014-01-10', '2014-02-09', '20', '2014-01-10', '2014-02-09', '11', '2014-01-10', '2014-01-30', '20', '79');
INSERT INTO `user_plan_details` VALUES ('60', '2', '5002', 'Job Plan', '2014-01-10', '2014-02-09', '30', '2014-01-10', '2014-02-09', '4', '2014-01-10', '2014-01-30', '20', '90');
INSERT INTO `user_plan_details` VALUES ('61', '2', '5003', 'Job Plan', '2014-01-10', '2014-02-09', '30', '2014-01-10', '2014-02-09', '4', '2014-01-10', '2014-01-30', '20', '90');
INSERT INTO `user_plan_details` VALUES ('62', '2', '5004', 'Job Plan', '2014-01-11', '2014-01-16', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '0');
INSERT INTO `user_plan_details` VALUES ('63', '2', '5005', 'CV Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-11', '2014-01-16', '5', '0');
INSERT INTO `user_plan_details` VALUES ('64', '2', '5006', 'Job Plan', '2014-01-11', '2014-02-10', '10', '2014-01-11', '2014-02-10', '4', '2014-01-11', '2014-01-31', '20', '50');
INSERT INTO `user_plan_details` VALUES ('65', '2', '5007', 'Job Plan', '2014-01-11', '2014-02-10', '10', '2014-01-11', '2014-02-10', '4', '2014-01-11', '2014-01-31', '20', '50');
INSERT INTO `user_plan_details` VALUES ('66', '2', '5008', 'Job Plan', '2014-01-11', '2014-01-16', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '0');
INSERT INTO `user_plan_details` VALUES ('67', '30', '5009', 'Job Plan', '2014-01-21', '2014-03-02', '40', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '0');
INSERT INTO `user_plan_details` VALUES ('68', '30', '5010', 'Job Plan', '2014-01-21', '2014-03-02', '40', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '0');
INSERT INTO `user_plan_details` VALUES ('69', '30', '5011', 'Job Plan', '2014-01-21', '2014-02-20', '10', '2014-01-21', '2014-02-20', '4', '2014-01-21', '2014-02-10', '20', '50');
INSERT INTO `user_plan_details` VALUES ('70', '25', '5012', 'CV Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-21', '2014-01-21', '0', '0');
INSERT INTO `user_plan_details` VALUES ('71', '25', '5013', 'Job Plan', '2014-01-21', '2014-03-02', '40', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '0');
INSERT INTO `user_plan_details` VALUES ('72', '25', '5014', 'CV Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-22', '2014-02-21', '30', '0');
INSERT INTO `user_plan_details` VALUES ('73', '25', '5015', 'Job Plan', '2014-01-22', '2014-02-21', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('74', '25', '5016', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-22', '2014-02-21', '20', '91');
INSERT INTO `user_plan_details` VALUES ('75', '25', '5017', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-22', '2014-02-21', '20', '91');
INSERT INTO `user_plan_details` VALUES ('76', '31', '5018', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('77', '25', '5019', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('78', '32', '5020', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('79', '25', '5021', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('80', '25', '5022', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-23', '2014-02-22', '0', '64');
INSERT INTO `user_plan_details` VALUES ('81', '33', '5023', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('82', '25', '5024', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-23', '2014-02-22', '5', '110');
INSERT INTO `user_plan_details` VALUES ('83', '34', '5025', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('84', '36', '5026', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('85', '37', '5027', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('86', '38', '5028', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('87', '24', '5029', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('88', '24', '5030', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-23', '2014-02-22', '5', '110');
INSERT INTO `user_plan_details` VALUES ('89', '39', '5031', 'Job Plan', '2014-01-23', '2014-02-22', '30', '2014-01-23', '2014-02-22', '4', '2014-01-23', '2014-02-12', '20', '90');
INSERT INTO `user_plan_details` VALUES ('90', '24', '5032', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-23', '2014-02-22', '5', '110');
INSERT INTO `user_plan_details` VALUES ('91', '24', '5033', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('92', '40', '5034', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('93', '24', '5035', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('94', '24', '5036', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('95', '24', '5037', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('96', '42', '5038', 'Job Plan', '2014-01-23', '2014-02-22', '20', '2014-01-23', '2014-02-22', '11', '2014-01-23', '2014-02-12', '20', '79');
INSERT INTO `user_plan_details` VALUES ('97', '24', '5039', 'Job Plan', '2014-01-23', '2014-02-22', '5', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '110');
INSERT INTO `user_plan_details` VALUES ('98', '24', '5040', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-23', '2014-02-22', '5', '110');
INSERT INTO `user_plan_details` VALUES ('99', '24', '5041', 'Cv Plan', '0000-00-00', '0000-00-00', '0', '0000-00-00', '0000-00-00', '0', '2014-01-23', '2014-02-22', '5', '110');
SET FOREIGN_KEY_CHECKS=1;
