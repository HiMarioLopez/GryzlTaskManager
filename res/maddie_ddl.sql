/*
 * DDL For Gryzl
 */

/*
 * Table of User Values
 * 
 * - usr_ID is the primaryKey
 * - usr_Email is a unique value that cannot have duplicates
 * - password is stored as an encrypted value in the database
 */
 
 SET FOREIGN_KEY_CHECKS=0;
 
DROP TABLE IF EXISTS Users; 
CREATE TABLE Users (
  usr_ID VARCHAR(20) NOT NULL, 
  usr_Email VARCHAR(50) NOT NULL, 
  usr_Password VARCHAR(255) NOT NULL,
  PRIMARY KEY (usr_ID),
  UNIQUE(usr_Email)
);
/* INSERT INTO `Users` VALUES ('jordan','jordan_hurt@baylor.edu', 'hurt'),
('maddie', 'maddie_dlt@baylor.edu', 'dlt'),
('mario', 'mariolopez@baylor.edu', 'lopez'),
('spongebob', 'sbsp@bikinibottom.com', 'squarepants'),
('patrick', 'pstar@wumbo.com', 'star'),
('gary', 'garysnail@food.com', 'thesnail'),
('squidward', 'squidward@leavemebe.com', 'clarinet'); */

/*
 * Table of Group Values
 * 
 * - gro_ID is the primaryKey
 * - gro_Status can be 'a' for active, or 'd' for deleted 
 */
DROP TABLE IF EXISTS Groups; 
CREATE TABLE Groups (
  gro_ID VARCHAR(50) NOT NULL, 
  gro_ownerID VARCHAR(20) NOT NULL,
  gro_Status CHAR(2) NOT NULL,
  PRIMARY KEY (gro_ID, gro_ownerID)
);
/* INSERT INTO `Groups` VALUES ('dbproj','jordan', 'a'),
 ('bbottomneighbors','spongebob','a'); */
 
DROP TABLE IF EXISTS Privileges; 
CREATE TABLE Privileges(
  pri_type VARCHAR(3),
  pri_usr_ID VARCHAR(20),
  FOREIGN KEY (pri_usr_ID) REFERENCES Users(usr_ID) ON DELETE CASCADE ON UPDATE CASCADE
);
/* INSERT INTO `Privileges` VALUES ('ad','spongebob'),
('ad', 'jordan'),
('pb', 'squidward'),
('pb', 'patrick'),
('pb', 'gary'),
('pb', 'maddie'),
('ad', 'mario'); */

DROP TABLE IF EXISTS Tasks;
CREATE TABLE Tasks (
  tas_ID VARCHAR(100),
  tas_Category CHAR(15) NOT NULL,
  tas_DueDate DATETIME,
  tas_Priority CHAR(2),
  tas_Progress CHAR(10),
  tas_usr_ID VARCHAR(20),
  CONSTRAINT PK_Tasks PRIMARY KEY (tas_ID, tas_Category, tas_usr_ID),
  FOREIGN KEY (tas_usr_ID) REFERENCES Users(usr_ID) ON DELETE CASCADE ON UPDATE CASCADE
);
/* INSERT INTO `Tasks` VALUES ('addrestrictions','school', '123', 'h', 'half', 'maddie'); */

DROP TABLE IF EXISTS Task_Groups; 
CREATE TABLE Task_Groups (
  tgr_tas_ID VARCHAR(100),
  tgr_tas_Category CHAR(15),
  tas_usr_ID VARCHAR(20),
  tgr_gro_ID VARCHAR(50),
  FOREIGN KEY (tgr_tas_ID) REFERENCES Tasks(tas_ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (tgr_gro_ID) REFERENCES Groups(gro_ID) ON DELETE CASCADE ON UPDATE CASCADE
);
/* INSERT INTO `Task_Groups` VALUES ('addrestrictions','school', 'maddie', 'dbproj' ); */

DROP TABLE IF EXISTS Progress_Task; 
CREATE TABLE Progress_Task (
  prg_tas_ID VARCHAR(100),
  prg_usr_ID VARCHAR(20),
  prg_tas_cat VARCHAR(15),
  prg_upd8Time VARCHAR(20),
  FOREIGN KEY (prg_tas_ID) REFERENCES Tasks(tas_ID) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS Group_Members; 
CREATE TABLE Group_Members (
  grm_gro_ID VARCHAR(50),
  grm_usr_ID VARCHAR(20),
  CONSTRAINT MultipleUsers2Task UNIQUE (grm_gro_ID, grm_usr_ID),
  FOREIGN KEY (grm_gro_ID) REFERENCES Groups(gro_ID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (grm_usr_ID) REFERENCES Users(usr_ID) ON DELETE CASCADE ON UPDATE CASCADE
);

 SET FOREIGN_KEY_CHECKS=1;


/* INSERT INTO `Group_Members` VALUES ('dbproj', 'jordan'),
('dbproj', 'maddie'),
('dbproj', 'mario'),
('bbottomneighbors', 'spongebob'),
('bbottomneighbors', 'patrick'),
('bbottomneighbors', 'gary'),
('bbottomneighbors', 'squidward');
 */