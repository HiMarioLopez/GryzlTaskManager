CREATE TABLE Users (
	usr_ID VARCHAR(20), 
	usr_Email VARCHAR(50) NOT NULL, 
	usr_Password VARCHAR(20) NOT NULL,
	PRIMARY KEY (usr_ID)
);

CREATE TABLE Groups (
	gro_ID VARCHAR(20), 
	gro_ownerID  VARCHAR(20) NOT NULL,
	gro_Status CHAR(1) NOT NULL,
	PRIMARY KEY (gro_ID)
);

CREATE TABLE Privileges(
	pri_type CHAR(1),
	pri_usr_ID VARCHAR(20),
	PRIMARY KEY (pri_usr_ID)
);

CREATE TABLE Tasks (
	tas_ID VARCHAR(20),
	tas_Category CHAR(15) NOT NULL,
	tas_DueDate DATETIME,
	tas_Priority CHAR(1),
	tas_Progress CHAR(10),
	PRIMARY KEY (tas_ID),
	INDEX (tas_ID)
);

CREATE TABLE Task_Owners (
	tow_tas_ID VARCHAR(20),
	tow_usr_ID VARCHAR(20),
	INDEX (tow_tas_ID)
);

CREATE TABLE Task_Groups (
	tgr_tas_ID VARCHAR(20),
	tgr_gro_ID VARCHAR(20),
	INDEX (tgr_tas_ID)
);

CREATE TABLE Group_Members (
	grm_gro_ID VARCHAR(20),
	grm_usr_ID VARCHAR(20),
	INDEX (grm_gro_ID)
);