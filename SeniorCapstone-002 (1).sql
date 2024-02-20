--	#############################################################################################
--	
--	Senior Capstone Project - NETWORKHUB.ME
--	
--	RFC 4122 UUIDv4 PHP Generator
--	https://uuid.ramsey.dev/en/stable/rfc4122/version4.html
--	
--	#############################################################################################



--	#############################################################################################
--	
--	SYSTEM VARIABLES
--	
--	#############################################################################################

CREATE TABLE `system_Variables` (
-- -------------------------------------------------------------------------------------------------
--	System Variables
--	Able to edit within WordPress Admin - NOT within the System UI
--	For handeling and processing miscellaneous variables.
-- -------------------------------------------------------------------------------------------------
	`system_Variable_Id_PK`						VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix system-variable-',
	`system_Variable_Name`						TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Variable Name',
	`system_Variable_Value`						TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Variable Value',
	`system_Variable_Meta`						TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Additional Variable Data',
	`system_Variable_Note`						TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Note about Variable',
	`system_Variable_DT_Added`					DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'DateTime when Added',
	PRIMARY KEY(`system_Variable_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='System Variables';



--	#############################################################################################
--	
--	DEFINED DATA
--	Predefined data.
--	
--	#############################################################################################

CREATE TABLE `define_Roles` (
-- -------------------------------------------------------------------------------------------------
--	Index of Roles
--	Examples. Business - Engineer - Sysop
-- -------------------------------------------------------------------------------------------------
	`define_Role_Id_PK`							VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UID set by Sysop.',
	`define_Role_Name`							TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Name of Role.',
	PRIMARY KEY(`define_Role_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Index of Roles';

CREATE TABLE `define_Ship_Methods` (
-- -------------------------------------------------------------------------------------------------
--	Index of Shipping Methods
--	Examples. USPS - UPS - FedEx
-- -------------------------------------------------------------------------------------------------
	`define_Ship_Method_Id_PK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UID set by Sysop.',
	`define_Ship_Method_Name`					TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Name of Role.',
	`define_Ship_Method_Tracking_URL`			TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'URL for Tracking',
	PRIMARY KEY(`define_Ship_Method_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Index of Shipping Methods';

CREATE TABLE `define_Job_Status` (
-- -------------------------------------------------------------------------------------------------
--	Index of Job Status options
--	Examples. Open - In Progress - Closed
-- -------------------------------------------------------------------------------------------------
	`define_Job_Status_Id_PK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UID set by Sysop.',
	`define_Job_Status_Name`					TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Name of Job Status.',
	PRIMARY KEY(`define_Job_Status_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Index of Roles';

CREATE TABLE `define_Tags` (
-- -------------------------------------------------------------------------------------------------
--	Index of Tags
--	Examples. Windows - Mac - Linux - Cisco
-- -------------------------------------------------------------------------------------------------
	`define_Tag_Id_PK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UID set by Sysop.',
	`define_Tag_Name`					TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Name of Tag.',
	PRIMARY KEY(`define_Tag_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Index of Tags';

CREATE TABLE `define_States` (
-- -------------------------------------------------------------------------------------------------
--	Index of States
-- -------------------------------------------------------------------------------------------------
	`define_State_Id_PK`						VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UID set by Sysop.',
	`define_State_Name`							TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Name of State',
	`define_State_2Character`					TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Two Letter abbreviation of State',
	`define_State_is_Enabled`					TINYINT(1)		COLLATE utf8mb4_general_ci	NOT NULL DEFAULT '1'	COMMENT 'True is 1. False 0.',
	PRIMARY KEY(`define_State_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Index of States';



--	#############################################################################################
--	
--	USER DATA
--	
--	#############################################################################################

CREATE TABLE `user_Data` (
-- -------------------------------------------------------------------------------------------------
--	User Account Data
--	Relationship is 1 to 1 between user_Account and WP User
--	Include in WordPress User Meta a key to user_Account.userAccount_Id_PK
-- -------------------------------------------------------------------------------------------------
	`userData_Id_PK`							VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix user-data-',
	`userData_WordPress_UserId_FK`				VARCHAR(96)		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'wp_system_users.user_login',
	`userData_Define_Role_Id_FK`				VARCHAR(96)		COLLATE utf8mb4_general_ci	NOT NULL				COMMENT 'FK define_Roles.define_Role_Id_PK',
	`userData_Timezone`							TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'User Selected Timezone',
	`userData_Primary_Email`					TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL				COMMENT 'Primary Email',
	`userData_Password`							TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL				COMMENT 'Account Password - MD5',
	`userData_Name_Preferred`					TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'User Preferred Name',
	`userData_Name_First`						TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'User First Name',
	`userData_Name_Last`						TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'User Last Name',
	`userData_Name_Business`					TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'User First Name',
	`userData_Profile_Description`				LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Profile Description. WYSIWYG field.',
	`userData_is_Enabled`						TINYINT(1)		COLLATE utf8mb4_general_ci	NOT NULL DEFAULT '1'	COMMENT 'True is 1. False 0.',
	`userData_DT_Added`							DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'DateTime when Added',
	`userData_Rating_Average_Calc`				DECIMAL(3,2)	COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Calculated Average of Rating from job_Reviews table.',
	`userData_Rating_Average_DT`				DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime the Average of Rating was Calculated.',
	`userData_Jobs_Complted_Calc`				SMALLINT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Calculated completed jobs from job_Reviews table.',
	`userData_Jobs_Complted_DT`					DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime the Completed Jobs was Calculated.',
	`userData_Notes`							LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Admin notes. Not visable to user. WYSIWYG field.',
	PRIMARY KEY(`userData_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='User Account Data';



--	#############################################################################################
--	
--	JOB DATA
--	
--	#############################################################################################

CREATE TABLE `job_Details` (
-- -------------------------------------------------------------------------------------------------
--	Job Details
-- -------------------------------------------------------------------------------------------------
	`jobDetail_Id_PK`							VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-detail-',
	`jobDetail_Business_UserId_FK`				VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'FK user_Data.userData_Id_PK',
	`jobDetail_Engineer_UserId_FK`				VARCHAR(96)		COLLATE	utf8mb4_general_ci	DEFAULT NULL			COMMENT 'FK user_Data.userData_Id_PK',
	`jobDetail_Defined_Job_Status_FK`			VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL				COMMENT 'FK define_Job_Status.define_Job_Status_Id_PK',
	`jobDetail_Posted_DT`						DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime job posted',
	`jobDetail_Title`							TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Title of Job',
	`jobDetail_Description_from_Business`		LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Job Description. WYSIWYG field.',
	`jobDetail_Description_from_Engineer`		LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Job Description. WYSIWYG field.',
	`jobDetail_Proposal_Target_Budget`			TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Target Budget posted by Business',
	`jobDetail_Proposal_Target_Date`			DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Target DateTime posted by Business',
	`jobDetail_Proposal_Agreed_Budget`			TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Agreed Budget Provided by Engineer',
	`jobDetail_Proposal_Agreed_Date`			DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Agreed DateTime Provided by Engineer',
	`jobDetail_Proposal_Final_Budget`			TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Final Budget at end of job from Engineer',
	`jobDetail_Proposal_Final_Date`				DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Final DateTime at end of job from Engineer',
	`jobDetail_is_Accepted_by_Business_Bool`	TINYINT(1)		COLLATE utf8mb4_general_ci	NOT NULL DEFAULT '0'	COMMENT 'True is 1. False 0.',
	`jobDetail_is_Accepted_by_Business_DT`		DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime',
	`jobDetail_is_Accepted_by_Engineer_Bool`	TINYINT(1)		COLLATE utf8mb4_general_ci	NOT NULL DEFAULT '0'	COMMENT 'True is 1. False 0.',
	`jobDetail_is_Accepted_by_Engineer_DT`		DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime',
	`jobDetail_is_Finished_by_Business_Bool`	TINYINT(1)		COLLATE utf8mb4_general_ci	NOT NULL DEFAULT '0'	COMMENT 'True is 1. False 0.',
	`jobDetail_is_Finished_by_Business_DT`		DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime',
	`jobDetail_is_Finished_by_Engineer_Bool`	TINYINT(1)		COLLATE utf8mb4_general_ci	NOT NULL DEFAULT '0'	COMMENT 'True is 1. False 0.',
	`jobDetail_is_Finished_by_Engineer_DT`		DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime',
	`jobDetail_Notes`							LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Admin notes. Not visable to user. WYSIWYG field.',
	PRIMARY KEY(`jobDetail_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Job Details';

CREATE TABLE `job_Tags` (
-- -------------------------------------------------------------------------------------------------
--	Job Tags
--	Table to hold an array of tags set by related to a job listing.
-- -------------------------------------------------------------------------------------------------
	`jobTag_Id_PK`								VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-tag-',
	`jobTag_jobDetail_Id_FK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL				COMMENT 'FK job_Details.jobDetail_Id_PK',
	`jobTag_Defined_Tag_FK`						VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL				COMMENT 'FK define_Tags.define_Tag_Id_PK',
	PRIMARY KEY(`jobTag_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Job Tags';

CREATE TABLE `job_Bids` (
-- -------------------------------------------------------------------------------------------------
--	Job Bids
--	Table to hold an array of bids from Engineers to Job listings.
-- -------------------------------------------------------------------------------------------------
	`jobBid_Id_PK`								VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-bid-',
	`jobBid_jobDetail_Id_FK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL				COMMENT 'FK job_Details.jobDetail_Id_PK',
	`jobBid_Engineer_UserId_FK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'FK user_Data.userData_Id_PK',
	`jobBid_Posted_DT`							DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime job posted',
	`jobBid_Proposal_from_Engineer`				LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Bid Proposal from Engineer. WYSIWYG field.',
	PRIMARY KEY(`jobBid_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Job Tags';

CREATE TABLE `job_Reviews` (
-- -------------------------------------------------------------------------------------------------
--	Reviews
--	Table to hold all reviews.
--	
--	Entry to this table is only made after job is marked as CLOSED by both Business and Engineer.
--	
--	_for_Business is input by Engineer
--	_for_Engineer is input by Business
--	Rating are 1 to 5
--	
--	Set a cronjob to calculate and store the User Rating Average to
--	 _Data.userData_Rating_Average_Calc and the datetime to user_Data.userData_Rating_Average_DT
--	
--	Set a cronjob to calculate and store the User completed jobs to
--	user_Data.userData_Jobs_Complted_Calc and the datetime to user_Data.userData_Jobs_Complted_DT
-- -------------------------------------------------------------------------------------------------
	`jobReview_Id_PK`							VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-review-',
	`jobReview_jobDetail_Id_FK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'FK job_Details.jobDetail_Id_PK',
	`jobReview_for_Business_UserId_FK`			VARCHAR(96)		COLLATE	utf8mb4_general_ci	DEFAULT NULL			COMMENT 'FK user_Data.userData_Id_PK',
	`jobReview_for_Business_Posted_DT`			DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime of review',
	`jobReview_for_Business_Rating`				TINYINT(1)		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Rating from Engineer for Business.',
	`jobReview_for_Business_Text`				LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Review from Engineer for Business. WYSIWYG field.',
	`jobReview_for_Engineer_UserId_FK`			VARCHAR(96)		COLLATE	utf8mb4_general_ci	DEFAULT NULL			COMMENT 'FK user_Data.userData_Id_PK',
	`jobReview_for_Engineer_Posted_DT`			DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime of review',
	`jobReview_for_Engineer_Rating`				TINYINT(1)		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Rating from Business for Engineer.',
	`jobReview_for_Engineer_Text`				LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Review from Business for Engineer. WYSIWYG field.',
	`jobReview_Notes`							LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Admin notes. Not visable to user. WYSIWYG field.',
	PRIMARY KEY(`jobReview_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reviews';

CREATE TABLE `job_Network_Diagrams` (
-- -------------------------------------------------------------------------------------------------
--	Network Diagrams
-- -------------------------------------------------------------------------------------------------
	`jobNetworkDiagram_Id_PK`					VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-network-diagram-',
	`jobNetworkDiagram_jobDetail_Id_FK`			VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'FK job_Details.jobDetail_Id_PK',
	`jobNetworkDiagram_Data`					LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Base64 Encoded Diagram File',
	`jobNetworkDiagram_Posted_DT`				DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime of Diagram',
	`jobNetworkDiagram_Engineer_Notes`			LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Notes from Engineer. WYSIWYG field.',
	PRIMARY KEY(`jobNetworkDiagram_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Network Diagrams';

CREATE TABLE `job_Messages` (
-- -------------------------------------------------------------------------------------------------
--	User Chat Messages related to Job
-- -------------------------------------------------------------------------------------------------
	`jobMessage_Id_PK`							VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-message-',
	`jobMessage_jobDetail_Id_FK`				VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'FK job_Details.jobDetail_Id_PK',
	`jobMessage_Sender_UserId_FK`				VARCHAR(96)		COLLATE	utf8mb4_general_ci	DEFAULT NULL			COMMENT 'FK user_Data.userData_Id_PK',
	`jobMessage_Sent_Datetime`					DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime of Diagram',
	`jobMessage_Text`							LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Text of message.',
	PRIMARY KEY(`jobMessage_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='User Chat Messages related to Job';

--	WORK IN PROGRESS
CREATE TABLE `job_Network_Data` (
--	WORK IN PROGRESS
-- -------------------------------------------------------------------------------------------------
--	WORK IN PROGRESS
--	Data collected about networks for jobs.
--	WORK IN PROGRESS
-- -------------------------------------------------------------------------------------------------
	`jobNetworkData_Id_PK`						VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix job-network-details-',
	`jobNetworkData_jobDetail_Id_FK`			VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'FK job_Details.jobDetail_Id_PK',
	PRIMARY KEY(`jobNetworkData_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data collected about networks for jobs.';

--	#############################################################################################
--	
--	DEVICE DATA
--	Devices deployed to Businesses by Sysop for Jobs.
--	
--	#############################################################################################

CREATE TABLE `device_Data` (
-- -------------------------------------------------------------------------------------------------
--	Device Data
-- -------------------------------------------------------------------------------------------------
	`deviceData_Id_PK`							VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'UUID prefix device-data-',
	`deviceData_jobDetail_Id_FK`				VARCHAR(96)		COLLATE	utf8mb4_general_ci	NOT NULL				COMMENT 'FK job_Details.jobDetail_Id_PK',
	`deviceData_Address_MAC`					TINYTEXT		COLLATE utf8mb4_general_ci	NOT NULL UNIQUE			COMMENT 'Mac Address of Device input by Sysop',
	`deviceData_Address_IP_LAN`					TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'IP LAN Address that is reported by device.',
	`deviceData_Address_IP_WAN`					TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'IP WAN Address that is reported by device.',
	`deviceData_Ship_Address_Street`			TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Shipping Address',
	`deviceData_Ship_Address_City`				TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Shipping Address',
	`deviceData_Ship_Address_State`				TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Shipping Address',
	`deviceData_Ship_Address_ZIP`				TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Shipping Address',
	`deviceData_Ship_Define_Ship_Method_Id_FK`	TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'FK define_Ship_Methods.define_Ship_Method_Id_PK',
	`deviceData_Ship_Tracking_Code`				TINYTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Tracking code assigned.',
	`deviceData_Ship_Datetime`					DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime shipped.',
	`deviceData_Delivered_Datetime`				DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime delivered.',
	`deviceData_Activated_Datetime`				DATETIME		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Datetime activated.',
	`deviceData_Notes`							LONGTEXT		COLLATE utf8mb4_general_ci	DEFAULT NULL			COMMENT 'Admin notes. Not visable to user. WYSIWYG field.',
	PRIMARY KEY(`deviceData_Id_PK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Device Data';




