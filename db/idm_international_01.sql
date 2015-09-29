-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2015 at 01:58 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `idm_international`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Add_New_Company`(comp_reg varchar(200), name varchar(200)) RETURNS int(11)
BEGIN
declare compid INT default 0;

if (name is null ||  comp_reg is null) then 
return 0;
end if;

SELECT 
    MAX(company_id)
INTO compid FROM
    company_tab;

if(compid is null || compid = 0) then
 set compid := 1000;
 else
	set compid := compid + 1;
end if;

INSERT INTO company_tab VALUES
(compid, comp_reg, name);

return compid;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `branch_pkg`(type_ varchar(10),value_ varchar(200)) RETURNS varchar(5) CHARSET latin1
BEGIN
declare return_val varchar(5) default null;
declare branch_id_ varchar(3) default null;
declare name_ varchar(200) default null;
declare address_ varchar(250) default null;
declare contact_ varchar(100) default null;
declare start_date_ date default null;
declare bank_acc_no_ varchar(50) default null;
declare status_ tinyInt(1) default 1;


if(value_ is null) then
return 0;
end if;	


set branch_id_ := replace(substring(substring_index(value_, '||', 1), length(substring_index(value_, '||', 1 - 1)) + 1), '||', '');
set name_ := replace(substring(substring_index(value_, '||', 2), length(substring_index(value_, '||', 2 - 1)) + 1), '||', '');
set address_ := replace(substring(substring_index(value_, '||', 3), length(substring_index(value_, '||', 3 - 1)) + 1), '||', '');
set contact_ := replace(substring(substring_index(value_, '||', 4), length(substring_index(value_, '||', 4 - 1)) + 1), '||', '');
set start_date_ := replace(substring(substring_index(value_, '||', 5), length(substring_index(value_, '||', 5 - 1)) + 1), '||', '');
set bank_acc_no_ := replace(substring(substring_index(value_, '||', 6), length(substring_index(value_, '||', 6 - 1)) + 1), '||', '');
set status_ := replace(substring(substring_index(value_, '||', 7), length(substring_index(value_, '||', 7 - 1)) + 1), '||', '');



-- New
if(type_ = 'NEW') then
   
    

     if(branch_id_ is null || branch_id_ = "") then
		 return null;
     end if;
    
    
    INSERT INTO branch_tab VALUES
    (branch_id_, name_, address_, contact_, start_date_,  bank_acc_no_, status_);

	return branch_id_;

-- Modify
elseif(type_ = 'MODIFY') THEN

   -- validate before check in DB
 
		if(branch_id_ is null || branch_id_ = "")then
			return null;
		end if;
      
      
		SELECT 
			branch_id
		INTO branch_id_ FROM
			branch_tab
		WHERE
			branch_id = branch_id_;
			
		if(branch_id_ is null || branch_id_ ="")then
			return null;
		end if;

		UPDATE branch_tab 
		SET name = name_, 
       address = address_, 
       contact = contact_, 
       start_date = start_date_,  
       bank_acc_no = bank_acc_no_, 
       status = status_ 
		WHERE
			branch_id = branch_id_;

		return branch_id_;

elseif(type_ = 'DELETE') THEN

   -- validate before check in DB
   if(branch_id_ is null || branch_id_ = "")then
			return null;
		end if;

		SELECT 
			branch_id
		INTO branch_id_ FROM
			branch_tab
		WHERE
			branch_id = branch_id_;
    
		if(branch_id_ is null || branch_id_ = "")then
			return 0;
		end if;

		DELETE FROM branch_tab 
		WHERE
			branch_id = branch_id_;

		return branch_id_;

end if;

 RETURN return_val;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `company_backend`(type_ varchar(10), comp_id_ INTEGER, comp_reg_ varchar(200), name_ varchar(200) ) RETURNS int(11)
BEGIN
declare return_val integer default 0;
declare compid integer default 0;

-- New
if(type_ = 'NEW') then
   if (name_ is null ||  comp_reg_ is null) then 
       return 0;
    end if;

    SELECT 
       MAX(company_id)
    INTO compid FROM
        company_tab;

     if(compid is null || compid = 0) then
		 set compid := 1000;
     else
			set compid := compid + 1;
	 end if;

	INSERT INTO company_tab VALUES
	(compid, comp_reg_, name_);

	return compid;

-- Modify
elseif(type_ = 'MODIFY') then

		-- validate before check in DB
		if(comp_id_ is null || comp_id_ < 1000)then
			return 0;
		end if;

		SELECT 
			company_id
		INTO compid FROM
			company_tab
		WHERE
			company_id = comp_id_;
			
		if(compid is null || compid < 1000)then
			return 0;
		end if;

		UPDATE company_tab 
		SET 
			com_reg_no = comp_reg_,
			name = name_
		WHERE
			company_id = compid;

		return compid;

elseif(type_ = 'DELETE') then

		-- validate before check in DB
		if(comp_id_ is null || comp_id_ < 1000)then
			return 0;
		end if;

		SELECT 
			company_id
		INTO compid FROM
			company_tab
		WHERE
			company_id = comp_id_;
    
		if(compid is null || compid < 1000)then
			return 0;
		end if;

		DELETE FROM company_tab 
		WHERE
			company_id = comp_id_;

		return compid;

end if;

 RETURN return_val;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `company_pkg`(type_ varchar(10),value_ varchar(200)) RETURNS int(11)
BEGIN
declare return_val integer default 0;
declare company_id_ integer default 0;
declare com_reg_no_ varchar(100) default null;
declare name_ varchar(200) default null;
declare company_type_ varchar(50) default null;
declare mailing_address_ varchar(250) default null;
declare business_address_ varchar(250) default null;
declare bank_name_ varchar(250) default null;
declare bank_acc_no_ varchar(50) default null;

if(value_ is null) then
return 0;
end if;	


set company_id_ := CAST(replace(substring(substring_index(value_, '||', 1), length(substring_index(value_, '||', 1 - 1)) + 1), '||', '') as UNSIGNED);
set com_reg_no_ := replace(substring(substring_index(value_, '||', 2), length(substring_index(value_, '||', 2 - 1)) + 1), '||', '');
set name_ := replace(substring(substring_index(value_, '||', 3), length(substring_index(value_, '||', 3 - 1)) + 1), '||', '');
set company_type_ := replace(substring(substring_index(value_, '||', 4), length(substring_index(value_, '||', 4 - 1)) + 1), '||', '');
set mailing_address_ := replace(substring(substring_index(value_, '||', 5), length(substring_index(value_, '||', 5 - 1)) + 1), '||', '');
set business_address_ := replace(substring(substring_index(value_, '||', 6), length(substring_index(value_, '||', 6 - 1)) + 1), '||', '');
set bank_name_ := replace(substring(substring_index(value_, '||', 7), length(substring_index(value_, '||', 7 - 1)) + 1), '||', '');
set bank_acc_no_ := replace(substring(substring_index(value_, '||', 8), length(substring_index(value_, '||', 8 - 1)) + 1), '||', '');



-- New
if(type_ = 'NEW') then
   
    SELECT 
       MAX(company_id)
    INTO company_id_ FROM
        company_tab;

     if(company_id_ is null || company_id_ = 0) then
		 set company_id_ := 1000;
     else
			set company_id_ := company_id_ + 1;
	 end if;
    
    
    INSERT INTO company_tab VALUES
    (company_id_, com_reg_no_, name_, company_type_, mailing_address_,  business_address_, bank_name_, bank_acc_no_);

	return company_id_;

-- Modify
elseif(type_ = 'MODIFY') THEN

   -- validate before check in DB
 
		if(company_id_ is null || company_id_ < 1000)then
			return 0;
		end if;
      
      
		SELECT 
			company_id
		INTO company_id_ FROM
			company_tab
		WHERE
			company_id = company_id_;
			
		if(company_id_ is null || company_id_ < 1000)then
			return 0;
		end if;

		UPDATE company_tab 
		SET com_reg_no = com_reg_no_, 
       name = name_, 
       company_type = company_type_, 
       mailing_address = mailing_address_,  
       business_address = business_address_, 
       bank_name = bank_name_, 
       bank_acc_no = bank_acc_no_
		WHERE
			company_id = company_id_;

		return company_id_;

elseif(type_ = 'DELETE') THEN

   -- validate before check in DB
   if(company_id_ is null || company_id_ < 1000)then
			return 0;
		end if;

		SELECT 
			company_id
		INTO company_id_ FROM
			company_tab
		WHERE
			company_id = company_id_;
    
		if(company_id_ is null || company_id_ < 1000)then
			return 0;
		end if;

		DELETE FROM company_tab 
		WHERE
			company_id = company_id_;

		return company_id_;

end if;

 RETURN return_val;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `department_pkg`(type_ varchar(10),value_ varchar(200)) RETURNS varchar(10) CHARSET latin1
BEGIN
declare dep_code_ varchar(3) default null;
declare dep_desc_ varchar(250) default null;
declare dep_pincha_ varchar(250) default null;

if(value_ is null) then
return null;
end if;	

set dep_code_ := replace(substring(substring_index(value_, '||', 1), length(substring_index(value_, '||', 1 - 1)) + 1), '||', '');
set dep_desc_ := replace(substring(substring_index(value_, '||', 2), length(substring_index(value_, '||', 2 - 1)) + 1), '||', '');
set dep_pincha_ := replace(substring(substring_index(value_, '||', 3), length(substring_index(value_, '||', 3 - 1)) + 1), '||', '');



-- New
if(type_ = 'NEW') then
   
     
    INSERT INTO department_tab VALUES
    (dep_code_, dep_desc_, dep_pincha_);

	return dep_code_;

-- Modify
elseif(type_ = 'MODIFY') THEN

   -- validate before check in DB
 
		if(dep_code_ is null || dep_code_ < "")then
			return null;
		end if;
      
      
		SELECT 
			dep_code
		INTO dep_code_ FROM
			department_tab
		WHERE
			dep_code = dep_code_;
			
		if(dep_code_ is null || dep_code_ = "")then
			return null;
		end if;

		UPDATE department_tab 
		SET dep_desc = dep_desc_, 
       dep_pincha = dep_pincha_
		WHERE
			dep_code = dep_code_;

		return dep_code_;

elseif(type_ = 'DELETE') THEN

   -- validate before check in DB
   if(dep_code_ is null || dep_code_ = "")then
			return null;
		end if;

		SELECT 
			dep_code
		INTO dep_code_ FROM
			department_tab
		WHERE
			dep_code = dep_code_;
    
		if(dep_code_ is null || dep_code_ = "")then
			return null;
		end if;

		DELETE FROM department_tab 
		WHERE
			dep_code = dep_code_;

		return dep_code_;

end if;

 RETURN null;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `designation_pkg`(type_ varchar(10),value_ varchar(200)) RETURNS varchar(10) CHARSET latin1
BEGIN
declare desg_code_ varchar(3) default null;
declare desg_desc_ varchar(250) default null;

if(value_ is null) then
return null;
end if;	

set desg_code_ := replace(substring(substring_index(value_, '||', 1), length(substring_index(value_, '||', 1 - 1)) + 1), '||', '');
set desg_desc_ := replace(substring(substring_index(value_, '||', 2), length(substring_index(value_, '||', 2 - 1)) + 1), '||', '');


-- New
if(type_ = 'NEW') then
   
     
    INSERT INTO designation_tab VALUES
    (desg_code_, desg_desc_);

	return desg_code_;

-- Modify
elseif(type_ = 'MODIFY') THEN

   -- validate before check in DB
 
		if(desg_code_ is null || desg_code_ < "")then
			return null;
		end if;
      
      
		SELECT 
			desg_code
		INTO desg_code_ FROM
			designation_tab
		WHERE
			desg_code = desg_code_;
			
		if(desg_code_ is null || desg_code_ = "")then
			return null;
		end if;

		UPDATE designation_tab 
		SET desg_desc = desg_desc_
		WHERE
			desg_code = desg_code_;

		return desg_code_;

elseif(type_ = 'DELETE') THEN

   -- validate before check in DB
   if(desg_code_ is null || desg_code_ = "")then
			return null;
		end if;

		SELECT 
			desg_code
		INTO desg_code_ FROM
			designation_tab
		WHERE
			desg_code = desg_code_;
    
		if(desg_code_ is null || desg_code_ = "")then
			return null;
		end if;

		DELETE FROM designation_tab 
		WHERE
			desg_code = desg_code_;

		return desg_code_;

end if;

 RETURN null;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `employee_pkg`() RETURNS int(11)
BEGIN
declare emp_id_ varchar(11) default null;
declare company_id_ varchar(11) default null;
declare epf_ varchar(45) default null;
declare etf_ varchar(45) default null;
declare title_ varchar(45) default null;
declare full_name_ varchar(150) default null;
declare used_name_ varchar(150) default null;
declare gender_ varchar(45) default null;
declare dob_ date default null;
declare civil_status_ varchar(15) default null;
declare nic_ varchar(15) default null;
declare address_ varchar(150) default null;
declare tel_ varchar(45) default null;
declare mob_ varchar(45) default null;
declare email_ varchar(3) default null;
declare serv_type_ varchar(45) default null;
declare appoinment_date_ date default null;
declare confirmation_date_ date default null;
declare resignation_date_ date default null;
declare status_ varchar(10) default null;

if(value_ is null) then
return null;
end if;	

set emp_id_      		:= replace(substring(substring_index(value_, '||', 1), length(substring_index(value_, '||', 1 - 1)) + 1), '||', '');
set company_id_  		:= replace(substring(substring_index(value_, '||', 2), length(substring_index(value_, '||', 2 - 1)) + 1), '||', '');
set etf_         		:= replace(substring(substring_index(value_, '||', 3), length(substring_index(value_, '||', 3 - 1)) + 1), '||', '');
set epf_         		:= replace(substring(substring_index(value_, '||', 4), length(substring_index(value_, '||', 4 - 1)) + 1), '||', '');
set title_       		:= replace(substring(substring_index(value_, '||', 5), length(substring_index(value_, '||', 5 - 1)) + 1), '||', '');
set full_name_   		:= replace(substring(substring_index(value_, '||', 6), length(substring_index(value_, '||', 6 - 1)) + 1), '||', '');
set used_name_   		:= replace(substring(substring_index(value_, '||', 7), length(substring_index(value_, '||', 7 - 1)) + 1), '||', '');
set gender_      		:= replace(substring(substring_index(value_, '||', 8), length(substring_index(value_, '||', 8 - 1)) + 1), '||', '');
set dob_         		:= replace(substring(substring_index(value_, '||', 9), length(substring_index(value_, '||', 9 - 1)) + 1), '||', '');
set civil_status_		:= replace(substring(substring_index(value_, '||', 10), length(substring_index(value_, '||', 10 - 1)) + 1), '||', '');
set nic_         		:= replace(substring(substring_index(value_, '||', 11), length(substring_index(value_, '||', 11 - 1)) + 1), '||', '');
set address_     		:= replace(substring(substring_index(value_, '||', 12), length(substring_index(value_, '||', 12 - 1)) + 1), '||', '');
set tel_         		:= replace(substring(substring_index(value_, '||', 13), length(substring_index(value_, '||', 13 - 1)) + 1), '||', '');
set mob_         		:= replace(substring(substring_index(value_, '||', 14), length(substring_index(value_, '||', 14 - 1)) + 1), '||', '');
set email_       		:= replace(substring(substring_index(value_, '||', 15), length(substring_index(value_, '||', 15 - 1)) + 1), '||', '');
set serv_type_   		:= replace(substring(substring_index(value_, '||', 16), length(substring_index(value_, '||', 16 - 1)) + 1), '||', '');
set appoinment_date_    := replace(substring(substring_index(value_, '||', 17), length(substring_index(value_, '||', 17 - 1)) + 1), '||', '');
set confirmation_date_  := replace(substring(substring_index(value_, '||', 18), length(substring_index(value_, '||', 18 - 1)) + 1), '||', '');
set resignation_date_   := replace(substring(substring_index(value_, '||', 19), length(substring_index(value_, '||', 19 - 1)) + 1), '||', '');
set status_             := replace(substring(substring_index(value_, '||', 20), length(substring_index(value_, '||', 20 - 1)) + 1), '||', '');


-- New
if(type_ = 'NEW') then
   
     
    INSERT INTO employee_tab VALUES
    (company_id_, emp_id_, etf_, epf_, title_, full_name_,used_name_,gender_,dob_,civil_status_,nic_,address_,tel_,mob_,email_,serv_type_,appoinment_date_,confirmation_date_,resignation_date_,status_);

	
	return emp_id_;

-- Modify
elseif(type_ = 'MODIFY') THEN

   -- validate before check in DB
 
		if(emp_id_ is null || emp_id_ = 0)then
			return null;
		end if;
      
      
		SELECT 
			emp_id
		INTO emp_id_ FROM
			employee_tab
		WHERE
			emp_id = emp_id_;
			
		if(emp_id_ is null || emp_id_ = 0)then
			return null;
		end if;

		UPDATE employee_tab 
		SET etf = etf_, 
			epf = epf_, 
			title = title_,
			full_name = full_name_,
			used_name = used_name_,
			gender = gender_,
			birth_date = dob_,
			civil_status = civil_status_,
			nic_passport_no = nic_,
			address = address_,
			telephone = tel_,
			mobile = mob_,
			email = email_,
			service_type = serv_type_,
			appointment_date = appoinment_date_,
			confirmation_date = confirmation_date_,
			resignation_date = resignation_date_,
			status = status_
		WHERE
			emp_id = emp_id_;
            
        
		return emp_id_;

elseif(type_ = 'DELETE') THEN

   -- validate before check in DB
   if(emp_id_ is null || emp_id_ = 0)then
			return null;
		end if;

		SELECT 
			emp_id
		INTO emp_id_ FROM
			employee_tab
		WHERE
			emp_id = emp_id_;
    
		if(emp_id_ is null || emp_id_ = 0)then
			return null;
		end if;

		DELETE FROM employee_tab 
		WHERE
			emp_id = emp_id_;
            
	 
		return emp_id_;

end if;

 RETURN null;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `branch_tab`
--

CREATE TABLE IF NOT EXISTS `branch_tab` (
  `branch_id` varchar(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contact` varchar(500) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `bank_acc_no` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_tab`
--

CREATE TABLE IF NOT EXISTS `company_tab` (
  `company_id` int(11) NOT NULL DEFAULT '1000',
  `com_reg_no` varchar(100) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `company_type` varchar(50) NOT NULL,
  `mailing_address` varchar(250) NOT NULL,
  `business_address` varchar(250) NOT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `bank_acc_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_tab`
--

INSERT INTO `company_tab` (`company_id`, `com_reg_no`, `name`, `company_type`, `mailing_address`, `business_address`, `bank_name`, `bank_acc_no`) VALUES
(1001, '1235v', 'company 1', 'Single Owner', 'cdf', 'rtyy', NULL, NULL),
(1002, 'pv0001', 'Test Company4', 'Single Owner', 'wwww', 'Help', '', ''),
(1004, 'pv90876', 'my Test2', 'Single Owner', 'edd', 'yyyy', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_fees_tab`
--

CREATE TABLE IF NOT EXISTS `course_fees_tab` (
  `course_id` int(11) NOT NULL,
  `fee_type` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_level_lov`
--

CREATE TABLE IF NOT EXISTS `course_level_lov` (
  `id` int(11) NOT NULL,
  `level` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_module_tab`
--

CREATE TABLE IF NOT EXISTS `course_module_tab` (
  `course_id` int(11) NOT NULL,
  `module_id` varchar(45) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_tab`
--

CREATE TABLE IF NOT EXISTS `course_tab` (
  `id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `short_name` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department_tab`
--

CREATE TABLE IF NOT EXISTS `department_tab` (
  `DEP_CODE` varchar(3) NOT NULL,
  `DEP_DESC` varchar(100) DEFAULT NULL,
  `DEP_PINCHA` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department_tab`
--

INSERT INTO `department_tab` (`DEP_CODE`, `DEP_DESC`, `DEP_PINCHA`) VALUES
('001', 'Account', NULL),
('002', 'HR', NULL),
('003', 'Lecture', NULL),
('004', 'Counseling', NULL),
('005', 'SAD', NULL),
('006', 'Marketing', NULL),
('007', 'Software', NULL),
('008', 'Hardware', NULL),
('009', 'Multimedia', NULL),
('010', 'Postgraduate', NULL),
('011', 'Minor Staff', NULL),
('012', 'Publicity', NULL),
('013', 'Compluter Lab', NULL),
('014', 'Administration', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designation_tab`
--

CREATE TABLE IF NOT EXISTS `designation_tab` (
  `DESG_CODE` varchar(3) NOT NULL,
  `DESG_DESC` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designation_tab`
--

INSERT INTO `designation_tab` (`DESG_CODE`, `DESG_DESC`) VALUES
('001', 'Account clerk'),
('002', 'Accountant'),
('003', 'Acting Tutor'),
('004', 'Administration Officer'),
('005', 'Assistant lecture Grad III'),
('006', 'Assistant lecture Grad Iv'),
('007', 'Assistant Manager'),
('008', 'Branch Coordinator'),
('009', 'Driver'),
('010', 'General clerk'),
('011', 'Hardware Technician'),
('012', 'HR Officer'),
('013', 'Instructor'),
('014', 'Manager'),
('015', 'Network Administrator'),
('016', 'Office Aide'),
('017', 'Student Counselor'),
('018', 'System Administrator'),
('019', 'Trainee Account clerk'),
('020', 'Trainee General clerk'),
('021', 'Trainee Instructor'),
('022', 'Trainee Student Counselor'),
('023', 'Trainee Technician'),
('024', 'Trainee Tutor'),
('025', 'Tutor'),
('026', 'Business Development Coordinator'),
('027', 'Assistant Network Administrator'),
('028', 'Receptionist'),
('029', 'Academic Coordinator'),
('030', 'District Manager');

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `DIV_CODE` varchar(3) NOT NULL,
  `DIV_DESC` varchar(100) DEFAULT NULL,
  `DIV_LOCDES` varchar(100) DEFAULT NULL,
  `DIV_BNKCODE` varchar(2) DEFAULT NULL,
  `DIV_BNKACCNO` varchar(12) DEFAULT NULL,
  `br_code` char(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`DIV_CODE`, `DIV_DESC`, `DIV_LOCDES`, `DIV_BNKCODE`, `DIV_BNKACCNO`, `br_code`) VALUES
('004', 'IDM SOFTWARE INTERNATIONAL PVT', NULL, NULL, NULL, NULL),
('001', 'IDM COMPUTER STUDIES (PVT)', NULL, NULL, NULL, NULL),
('003', 'IDM TECHNOLOGY SOLUTIONS(PVT)L', NULL, NULL, NULL, NULL),
('005', 'IDM', NULL, NULL, NULL, NULL),
('002', 'IDM COMPUTER STUDIES Island Wide (pvt)', NULL, NULL, NULL, NULL),
('006', 'IDM Computer Studies Akuressa (PVT)', NULL, NULL, NULL, NULL),
('007', 'IDM Computer Studies Ambalanthota (PVT)', NULL, NULL, NULL, NULL),
('008', 'IDM Computer Studies Anuradapura (PVT)', NULL, NULL, NULL, NULL),
('009', 'IDM Computer Studies Badulla (PVT)', NULL, NULL, NULL, NULL),
('010', 'IDM Computer Studies Bandarawella (PVT)', NULL, NULL, NULL, NULL),
('011', 'IDM Computer Studies Batticloa (PVT)', NULL, NULL, NULL, NULL),
('012', 'IDM Computer Studies chawakachcheri (PVT)', NULL, NULL, NULL, NULL),
('013', 'IDM Computer Studies Chillaw (PVT)', NULL, NULL, NULL, NULL),
('018', 'IDM Computer Studies City Campus-#3 (PVT)', NULL, NULL, NULL, NULL),
('019', 'IDM Computer Studies Elpitiya (PVT)', NULL, NULL, NULL, NULL),
('020', 'IDM Computer Studies Embilipitiya (PVT)', NULL, NULL, NULL, NULL),
('021', 'IDM Computer Studies Galle (PVT)', NULL, NULL, NULL, NULL),
('022', 'IDM Computer Studies Gampaha (PVT)', NULL, NULL, NULL, NULL),
('023', 'IDM Computer Studies homagama (PVT)', NULL, NULL, NULL, NULL),
('024', 'IDM Computer Studies Horana (PVT)', NULL, NULL, NULL, NULL),
('025', 'IDM Computer Studies Ja-ela (PVT)', NULL, NULL, NULL, NULL),
('026', 'IDM Computer Studies Jaffna (PVT)', NULL, NULL, NULL, NULL),
('027', 'IDM Computer Studies Kadawatha (PVT)', NULL, NULL, NULL, NULL),
('028', 'IDM Computer Studies Kaduwela (PVT)', NULL, NULL, NULL, NULL),
('029', 'IDM Computer Studies Kalmunai (PVT)', NULL, NULL, NULL, NULL),
('030', 'IDM Computer Studies Kaluthara (PVT)', NULL, NULL, NULL, NULL),
('031', 'IDM Computer Studies Kandy (PVT)', NULL, NULL, NULL, NULL),
('032', 'IDM Computer Studies Kegalle (PVT)', NULL, NULL, NULL, NULL),
('033', 'IDM Computer Studies Kiribathgoda (PVT)', NULL, NULL, NULL, NULL),
('034', 'IDM Computer Studies Kochikade (PVT)', NULL, NULL, NULL, NULL),
('035', 'IDM Computer Studies Kotahena (PVT)', NULL, NULL, NULL, NULL),
('036', 'IDM Computer Studies Kuliyapitiya (PVT)', NULL, NULL, NULL, NULL),
('037', 'IDM Computer Studies Kurunegala (PVT)', NULL, NULL, NULL, NULL),
('038', 'IDM Computer Studies Maharagama (PVT)', NULL, NULL, NULL, NULL),
('039', 'IDM Computer Studies Makola (PVT)', NULL, NULL, NULL, NULL),
('040', 'IDM Computer Studies Mannar (PVT)', NULL, NULL, NULL, NULL),
('041', 'IDM Computer Studies Matale (PVT)', NULL, NULL, NULL, NULL),
('042', 'IDM Computer Studies Matara (PVT)', NULL, NULL, NULL, NULL),
('043', 'IDM Computer Studies Minuwangoda (PVT)', NULL, NULL, NULL, NULL),
('044', 'IDM Computer Studies Nawalapitiya (PVT)', NULL, NULL, NULL, NULL),
('045', 'IDM Computer Studies Negombo (PVT)', NULL, NULL, NULL, NULL),
('046', 'IDM Computer Studies Nittambuwa (PVT)', NULL, NULL, NULL, NULL),
('047', 'IDM Computer Studies Nugegoda (PVT)', NULL, NULL, NULL, NULL),
('048', 'IDM Computer Studies Nuwara Eliya (PVT)', NULL, NULL, NULL, NULL),
('049', 'IDM Computer Studies Panandura (PVT)', NULL, NULL, NULL, NULL),
('050', 'IDM Computer Studies Piliyandala (PVT)', NULL, NULL, NULL, NULL),
('051', 'IDM Computer Studies Puttalama (PVT)', NULL, NULL, NULL, NULL),
('052', 'IDM Computer Studies Ratnapura (PVT)', NULL, NULL, NULL, NULL),
('053', 'IDM Computer Studies Rikkillagaskada (PVT)', NULL, NULL, NULL, NULL),
('054', 'IDM Computer Studies Vavuniya (PVT)', NULL, NULL, NULL, NULL),
('055', 'IDM Computer Studies Wattala (PVT)', NULL, NULL, NULL, NULL),
('056', 'IDM Computer Studies Ratmalana (PVT)', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `division_department`
--

CREATE TABLE IF NOT EXISTS `division_department` (
  `DIV_CODE` char(3) NOT NULL,
  `DEP_CODE` char(3) NOT NULL,
  `DEP_DESC` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division_department`
--

INSERT INTO `division_department` (`DIV_CODE`, `DEP_CODE`, `DEP_DESC`) VALUES
('003', '009', 'Multimedia'),
('001', '007', 'Software'),
('004', '007', 'Software'),
('001', '009', 'Multimedia'),
('001', '002', 'HR'),
('001', '001', 'Account'),
('001', '004', 'Counseling'),
('001', '005', 'SAD'),
('001', '010', 'Postgraduate'),
('001', '003', 'Lecture'),
('003', '007', 'Software'),
('001', '008', 'Hardware'),
('001', '012', 'Publicity'),
('001', '011', 'Minor Staff'),
('013', '005', 'SAD'),
('013', '001', 'Account'),
('013', '002', 'HR'),
('013', '003', 'Lecture'),
('013', '004', 'Counseling'),
('013', '006', 'Marketing'),
('013', '013', 'Compluter Lab'),
('021', '001', 'Account'),
('021', '003', 'Lecture'),
('021', '005', 'SAD'),
('021', '006', 'Marketing'),
('021', '008', 'Hardware'),
('021', '011', 'Minor Staff'),
('049', '001', 'Account'),
('049', '003', 'Lecture'),
('049', '002', 'HR'),
('049', '005', 'SAD'),
('049', '008', 'Hardware'),
('049', '013', 'Compluter Lab'),
('049', '011', 'Minor Staff'),
('010', '003', 'Lecture'),
('010', '004', 'Counseling'),
('010', '008', 'Hardware'),
('021', '013', 'Compluter Lab'),
('021', '004', 'Counseling'),
('031', '002', 'HR'),
('031', '003', 'Lecture'),
('031', '005', 'SAD'),
('031', '001', 'Account'),
('031', '011', 'Minor Staff'),
('022', '001', 'Account'),
('022', '003', 'Lecture'),
('022', '005', 'SAD'),
('022', '004', 'Counseling'),
('022', '011', 'Minor Staff'),
('001', '013', 'Compluter Lab'),
('001', '006', 'Marketing'),
('056', '003', 'Lecture'),
('056', '005', 'SAD'),
('056', '001', 'Account'),
('056', '002', 'HR'),
('037', '011', 'Minor Staff'),
('037', '003', 'Lecture'),
('037', '005', 'SAD'),
('037', '001', 'Account'),
('037', '002', 'HR'),
('042', '001', 'Account'),
('042', '002', 'HR'),
('042', '003', 'Lecture'),
('042', '004', 'Counseling'),
('042', '005', 'SAD'),
('042', '008', 'Hardware'),
('042', '013', 'Compluter Lab'),
('013', '008', 'Hardware'),
('031', '013', 'Compluter Lab'),
('042', '011', 'Minor Staff'),
('050', '001', 'Account'),
('050', '005', 'SAD'),
('050', '014', 'Administration'),
('049', '004', 'Counseling'),
('009', '003', 'Lecture');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_menu`
--

CREATE TABLE IF NOT EXISTS `dynamic_menu` (
  `id` tinyint(3) unsigned NOT NULL,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `menu_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `level` tinyint(1) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dynamic_menu`
--

INSERT INTO `dynamic_menu` (`id`, `parent_id`, `title`, `url`, `menu_order`, `status`, `level`, `icon`, `description`) VALUES
(1, 0, 'Administrator', '#', 3, 1, 1, 'fa fa-shield', NULL),
(2, 1, 'User', '/form/fdatauser.php', 1, 1, 0, NULL, NULL),
(10, 0, 'Enterprise', '#', 1, 1, 2, 'fa fa-sitemap', NULL),
(11, 10, 'Companies', '/content/entrep/company.php', 1, 1, 2, NULL, NULL),
(12, 10, 'Branches', '/content/entrep/branch.php', 2, 1, 2, NULL, NULL),
(15, 10, 'Basic Data', '#', 3, 1, 2, NULL, NULL),
(16, 15, 'Departments', '/content/entrep/departments.php', 1, 1, 3, NULL, NULL),
(17, 15, 'Divisions', '/content/entrep/divisions.php', 2, 1, 3, NULL, NULL),
(20, 0, 'HR', '#', 2, 1, 2, 'fa fa-shield', NULL),
(21, 20, 'Employees', '/content/hr/employees.php', 1, 1, 2, NULL, NULL),
(22, 20, 'Branch Employees', '/content/hr/branchEmpolyee.php', 2, 1, 3, NULL, NULL),
(23, 20, 'Basic Data', '#', 3, 1, 2, NULL, NULL),
(24, 23, 'Designations', '/content/hr/designations.php', 1, 1, 3, NULL, NULL),
(25, 23, 'Leave Type', '/content/hr/leaveType.php', 2, 1, 3, NULL, NULL),
(26, 23, 'Holidays', '/content/hr/holiday.php', 3, 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_tab`
--

CREATE TABLE IF NOT EXISTS `employee_tab` (
  `company_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `etf` varchar(50) DEFAULT NULL,
  `epf` varchar(50) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `used_name` varchar(150) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birth_date` date DEFAULT NULL,
  `civil_status` enum('Single','Married') DEFAULT NULL,
  `nic_passport_no` varchar(10) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `service_type` varchar(20) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL,
  `resignation_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `image` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `employee_view`
--
CREATE TABLE IF NOT EXISTS `employee_view` (
`company_id` int(11)
,`emp_id` int(11)
,`epf` varchar(50)
,`etf` varchar(50)
,`full_name` varchar(150)
,`used_name` varchar(150)
,`gender` enum('Male','Female')
,`birth_date` date
,`civil_status` enum('Single','Married')
,`nic_passport_no` varchar(10)
,`address` varchar(150)
,`telephone` varchar(20)
,`mobile` varchar(20)
,`email` varchar(30)
,`service_type` varchar(20)
,`appointment_date` date
,`confirmation_date` date
,`resignation_date` date
,`designation` varchar(5)
,`department` varchar(5)
,`status` enum('Active','Inactive')
,`image` blob
);
-- --------------------------------------------------------

--
-- Table structure for table `emp_department_tab`
--

CREATE TABLE IF NOT EXISTS `emp_department_tab` (
  `emp_id` int(11) NOT NULL,
  `dept_code` varchar(5) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_designation_tab`
--

CREATE TABLE IF NOT EXISTS `emp_designation_tab` (
  `emp_id` varchar(10) NOT NULL,
  `deisgnation_code` varchar(5) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_type_lov`
--

CREATE TABLE IF NOT EXISTS `exam_type_lov` (
  `id` int(11) NOT NULL,
  `exam` varchar(45) NOT NULL,
  `maximum mark` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_dept_lov`
--

CREATE TABLE IF NOT EXISTS `faculty_dept_lov` (
  `faculty` int(11) NOT NULL,
  `dept_id` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_lov`
--

CREATE TABLE IF NOT EXISTS `faculty_lov` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fee_type_lov`
--

CREATE TABLE IF NOT EXISTS `fee_type_lov` (
  `id` int(11) NOT NULL,
  `fee_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holidaycalender`
--

CREATE TABLE IF NOT EXISTS `holidaycalender` (
  `month` varchar(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `day` int(11) NOT NULL DEFAULT '0',
  `holtno` varchar(2) NOT NULL,
  `desc1` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `holidaycalender`
--

INSERT INTO `holidaycalender` (`month`, `year`, `day`, `holtno`, `desc1`) VALUES
('9', '2010', 21, '08', ''),
('9', '2010', 27, '29', ''),
('1', '2010', 2, '13', 'dgbdfxg'),
('3', '2010', 9, '01', ''),
('11', '2010', 19, '29', ''),
('10', '2010', 22, '10', ''),
('11', '2010', 21, '11', ''),
('12', '2010', 20, '12', ''),
('12', '2010', 24, '29', ''),
('12', '2010', 25, '13', '');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE IF NOT EXISTS `leave_type` (
  `ltcode` varchar(3) NOT NULL,
  `type` varchar(15) DEFAULT NULL,
  `nodays` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`ltcode`, `type`, `nodays`) VALUES
('001', 'Casual', 7),
('002', 'Medical', 21),
('003', 'Annual', 14);

-- --------------------------------------------------------

--
-- Table structure for table `module_tab`
--

CREATE TABLE IF NOT EXISTS `module_tab` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `details` longtext,
  `document` blob,
  `active` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `marks` varchar(45) DEFAULT NULL,
  `credits` varchar(45) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_course_fees_tab`
--

CREATE TABLE IF NOT EXISTS `student_course_fees_tab` (
  `id` int(11) NOT NULL,
  `fee_type` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `due_date` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_marks_tab`
--

CREATE TABLE IF NOT EXISTS `student_marks_tab` (
  `student_id` int(11) NOT NULL,
  `module_id` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `marks` varchar(45) DEFAULT NULL,
  `grade` varchar(45) DEFAULT NULL,
  `exam_date` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_payments`
--

CREATE TABLE IF NOT EXISTS `student_payments` (
  `id` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `user` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_tab`
--

CREATE TABLE IF NOT EXISTS `student_tab` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `branch` varchar(3) NOT NULL,
  `used_name` varchar(100) NOT NULL,
  `certificate_name` varchar(80) NOT NULL,
  `name_approved` tinyint(1) NOT NULL DEFAULT '0',
  `nic` varchar(10) DEFAULT NULL,
  `guardian_nic` varchar(10) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  `date_of_birth` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `studentcol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `employee_view`
--
DROP TABLE IF EXISTS `employee_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employee_view` AS select `e`.`company_id` AS `company_id`,`e`.`emp_id` AS `emp_id`,`e`.`epf` AS `epf`,`e`.`etf` AS `etf`,`e`.`full_name` AS `full_name`,`e`.`used_name` AS `used_name`,`e`.`gender` AS `gender`,`e`.`birth_date` AS `birth_date`,`e`.`civil_status` AS `civil_status`,`e`.`nic_passport_no` AS `nic_passport_no`,`e`.`address` AS `address`,`e`.`telephone` AS `telephone`,`e`.`mobile` AS `mobile`,`e`.`email` AS `email`,`e`.`service_type` AS `service_type`,`e`.`appointment_date` AS `appointment_date`,`e`.`confirmation_date` AS `confirmation_date`,`e`.`resignation_date` AS `resignation_date`,(select `emp_designation_tab`.`deisgnation_code` from `emp_designation_tab` where ((`emp_designation_tab`.`emp_id` = `e`.`emp_id`) and (`emp_designation_tab`.`active` = 1))) AS `designation`,(select `emp_department_tab`.`dept_code` from `emp_department_tab` where ((`emp_department_tab`.`emp_id` = `e`.`emp_id`) and (`emp_department_tab`.`active` = 1))) AS `department`,`e`.`status` AS `status`,`e`.`image` AS `image` from `employee_tab` `e`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch_tab`
--
ALTER TABLE `branch_tab`
 ADD PRIMARY KEY (`branch_id`), ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `company_tab`
--
ALTER TABLE `company_tab`
 ADD PRIMARY KEY (`company_id`), ADD UNIQUE KEY `com_id_UNIQUE` (`company_id`), ADD UNIQUE KEY `com_reg_no_UNIQUE` (`com_reg_no`);

--
-- Indexes for table `course_fees_tab`
--
ALTER TABLE `course_fees_tab`
 ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_level_lov`
--
ALTER TABLE `course_level_lov`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_module_tab`
--
ALTER TABLE `course_module_tab`
 ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_tab`
--
ALTER TABLE `course_tab`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_tab`
--
ALTER TABLE `department_tab`
 ADD PRIMARY KEY (`DEP_CODE`);

--
-- Indexes for table `designation_tab`
--
ALTER TABLE `designation_tab`
 ADD PRIMARY KEY (`DESG_CODE`), ADD KEY `DESG_CODE` (`DESG_CODE`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
 ADD PRIMARY KEY (`DIV_CODE`), ADD KEY `DIV_BNKCODE` (`DIV_BNKCODE`), ADD KEY `DIV_BRNCHCODE` (`br_code`), ADD KEY `DIV_CODE` (`DIV_CODE`);

--
-- Indexes for table `division_department`
--
ALTER TABLE `division_department`
 ADD PRIMARY KEY (`DIV_CODE`,`DEP_CODE`);

--
-- Indexes for table `dynamic_menu`
--
ALTER TABLE `dynamic_menu`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_tab`
--
ALTER TABLE `employee_tab`
 ADD PRIMARY KEY (`emp_id`), ADD UNIQUE KEY `nic_passport_no_UNIQUE` (`nic_passport_no`), ADD KEY `fk_employee_company1_idx` (`company_id`);

--
-- Indexes for table `exam_type_lov`
--
ALTER TABLE `exam_type_lov`
 ADD PRIMARY KEY (`id`,`exam`);

--
-- Indexes for table `faculty_dept_lov`
--
ALTER TABLE `faculty_dept_lov`
 ADD PRIMARY KEY (`faculty`);

--
-- Indexes for table `faculty_lov`
--
ALTER TABLE `faculty_lov`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_type_lov`
--
ALTER TABLE `fee_type_lov`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidaycalender`
--
ALTER TABLE `holidaycalender`
 ADD PRIMARY KEY (`month`,`year`,`day`,`holtno`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
 ADD PRIMARY KEY (`ltcode`);

--
-- Indexes for table `module_tab`
--
ALTER TABLE `module_tab`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course_fees_tab`
--
ALTER TABLE `student_course_fees_tab`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_marks_tab`
--
ALTER TABLE `student_marks_tab`
 ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_payments`
--
ALTER TABLE `student_payments`
 ADD PRIMARY KEY (`id`,`payment_type`);

--
-- Indexes for table `student_tab`
--
ALTER TABLE `student_tab`
 ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_tab`
--
ALTER TABLE `employee_tab`
ADD CONSTRAINT `fk_employee_company1` FOREIGN KEY (`company_id`) REFERENCES `company_tab` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
