\W /* Show Warnings */

DROP TABLE IF EXISTS `SessionMat`;
DROP TABLE IF EXISTS `Material`;
DROP TABLE IF EXISTS `Learns`;
DROP TABLE IF EXISTS `Moderates`;
DROP TABLE IF EXISTS `Record`;
DROP TABLE IF EXISTS `Review`;
DROP TABLE IF EXISTS `Schedule`;
DROP TABLE IF EXISTS `Teaches`;
DROP TABLE IF EXISTS `Session`;
DROP TABLE IF EXISTS `Section`;
DROP TABLE IF EXISTS `Course`;
DROP TABLE IF EXISTS `Moderator`;
DROP TABLE IF EXISTS `Parent`;
DROP TABLE IF EXISTS `Family`;
DROP TABLE IF EXISTS `Mentee`;
DROP TABLE IF EXISTS `Mentor`;
DROP TABLE IF EXISTS `Student`;
DROP TABLE IF EXISTS `User`;

/* User Table***********************************************/
CREATE TABLE `User` (
	`uID` INT,
	`name` CHAR(50),
	`email` CHAR(50),
	`phone` CHAR(14),
	`username` CHAR(50),
	`password` CHAR(50),
	`role` CHAR(50),

	PRIMARY KEY (`uID`),
	UNIQUE (`email`)
) DEFAULT CHARSET = utf8;
INSERT INTO User
VALUES (1, 'Billy', 'billy@billy.com', '617-994-5233', 'bill', 'password', 'Parent');
INSERT INTO User
VALUES (2, 'Betty', 'betty@betty.com', '666-666-5666', 'bettyb', 'password', 'Mentee');
INSERT INTO User
VALUES (3, 'Bobby', 'bobby@bobby.com', '777-777-5777', 'boss', 'password', 'Mentee');
INSERT INTO User
VALUES (4, 'Becky', 'becky@becky.com', '999-999-9999', 'becky', 'password', 'Moderator');
INSERT INTO User
VALUES (5, 'Bart', 'bart@bart.com', '888-888-8888', 'bart', 'password', 'Mentor');
INSERT INTO User
VALUES (6, 'Ben', 'ben@ben.com', '555-555-5555', 'ben', 'password', 'Mentor');



/* Student Table *****************************************************/
CREATE TABLE `Student` (
	`sID` INT,
	`grade` INT,

	PRIMARY KEY (`sID`),
	CONSTRAINT FOREIGN KEY (`sID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Student VALUES (2, 9);
INSERT INTO Student VALUES (3, 10);
INSERT INTO Student VALUES (5, 11);
INSERT INTO Student VALUES (6, 12);


/* Mentor Table ********************************************************/
CREATE TABLE `Mentor` (
	`orID` INT,

	PRIMARY KEY (`orID`),
	CONSTRAINT FOREIGN KEY (`orID`) REFERENCES Student(`sID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Mentor VALUES (5);
INSERT INTO Mentor VALUES (6);

/* Mentee Table ********************************************************/
CREATE TABLE `Mentee` (
	`eeID` INT,
	
	PRIMARY KEY (`eeID`),
	CONSTRAINT `b` FOREIGN KEY (`eeID`) REFERENCES Student(`sID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Mentor VALUES (2);
INSERT INTO Mentor VALUES (3);

/* Parent Table *********************************************************/
CREATE TABLE `Parent` (
	`pID` INT,

	PRIMARY KEY (`pID`),
	CONSTRAINT FOREIGN KEY (`pID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Parent VALUES (1);
INSERT INTO Parent VALUES (4);

/* Moderator Table ***********************************************************/
CREATE TABLE `Moderator` (
	modID INT,
	
	PRIMARY KEY (modID),
	CONSTRAINT `assign_modID` FOREIGN KEY (modID) REFERENCES `User`(uID) ON DELETE CASCADE 
) DEFAULT CHARSET = utf8;
INSERT INTO Moderator VALUES (4);

/* Family Table ****************************************************************/
CREATE TABLE `Family` (
	`pID` INT,
	`sID` INT,

	PRIMARY KEY (`pID`, `sID`),
	CONSTRAINT `c` FOREIGN KEY (`pID`) REFERENCES User(`uID`) ON DELETE CASCADE,
	CONSTRAINT `d` FOREIGN KEY (`sID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Family VALUES (1, 2);
INSERT INTO Family VALUES (1, 3);
INSERT INTO Family VALUES (4, 5);
INSERT INTO Family VALUES (4, 6);

/* Course Table ******************************************************************/
CREATE TABLE `Course` (
	`cID` INT,
	`title` CHAR(50),
	`description` CHAR(255),
	`orReq` INT,
	`eeReq` INT,
	
	PRIMARY KEY (`cID`)
) DEFAULT CHARSET = utf8;
INSERT INTO Course 
VALUES (1, 'Exploring the Solar System', 'Learn About the wonderful components that make up our solar systems', 11, 9);
INSERT INTO Course 
VALUES (2, 'Metaphysics', 'A study about our understanding of physics and the nature of reality', 11, 9);
INSERT INTO Course 
VALUES (3, 'Physics', 'Learn about the fundamental laws of physics.', 11, 10);
INSERT INTO Course 
VALUES (4, 'Advanced Rocketry', 'In this course We will be building a rocket and flying to the moon.', 12, 11);
INSERT INTO Course 
VALUES (5, 'Humility', 'In this course Seniors will learn valuable life lessons from their younger peers.', 9, 12);
 
/* Section Table ************************************************************/
CREATE TABLE `Section` (
	`secID` INT,
	`cID` INT,
	`schedID` INT,
	`name` CHAR(50),
	`capacity` INT,
	`tuition` FLOAT,
	`salary` FLOAT,
	`startDate` DATE,
	`endDate` DATE,

	PRIMARY KEY (`secID`, `cID`),
	CONSTRAINT `e` FOREIGN KEY (`cID`) REFERENCES Course(`cID`) ON DELETE CASCADE,
	UNIQUE (`schedID`)
) DEFAULT CHARSET = utf8;
INSERT INTO Section 
VALUES (1, 1, 1, "Section 1", 7, 7.00, 7.00, '2018-09-01', '2018-12-01');
INSERT INTO Section 
VALUES (2, 1, 2, "Section 2", 7, 7.00, 7.00, '2019-09-01', '2019-12-01');
INSERT INTO Section 
VALUES (1, 2, 3, "Section 1", 7, 7.00, 7.00, '2018-09-01', '2018-12-01');
INSERT INTO Section 
VALUES (2, 2, 4, "Section 2", 7, 7.00, 7.00, '2019-09-01', '2019-12-01');
INSERT INTO Section 
VALUES (1, 3, 5, "Section 1", 7, 7.00, 7.00, '2018-09-01', '2018-12-01');
INSERT INTO Section 
VALUES (2, 3, 6, "Section 2", 7, 7.00, 7.00, '2019-09-01', '2019-12-01');
INSERT INTO Section 
VALUES (1, 4, 7, "Section 1", 7, 7.00, 7.00, '2018-09-01', '2018-12-01');
INSERT INTO Section 
VALUES (2, 4, 8, "Section 2", 7, 7.00, 7.00, '2019-09-01', '2019-12-01');
INSERT INTO Section 
VALUES (1, 5, 9, "Section 1", 7, 7.00, 7.00, '2018-09-01', '2018-12-01');
INSERT INTO Section 
VALUES (2, 5, 10, "Section 2", 7, 7.00, 7.00, '2019-09-01', '2019-12-01');

 

CREATE TABLE `Record` (
	`uID` INT,
	`cID` INT,
	`secID` INT,
	`theDate` DATE,

	`role` CHAR(6),
	`cost` FLOAT,
	`paid` BOOLEAN,
	`avgRating` INT,
	`avgTag` CHAR(50),

	PRIMARY KEY (`uID`, `cID`, `secID`),
	CONSTRAINT `f` FOREIGN KEY (`uID`) REFERENCES User(`uID`) ON DELETE CASCADE,
	CONSTRAINT `g` FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE,
	CONSTRAINT `h` FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;

CREATE TABLE `Review` (
	`recID` INT,
	`writerID` INT,
	`secID` INT,
	`cID` INT,
	`rating` INT,
	`tags` CHAR(50),
    `comment` CHAR(255),

	PRIMARY KEY (`recID`, `writerID`, `secID`),
	CONSTRAINT `i` FOREIGN KEY (`recID`) REFERENCES User(`uID`) ON DELETE CASCADE,
	CONSTRAINT `j` FOREIGN KEY (`writerID`) REFERENCES User(`uID`) ON DELETE CASCADE,
	CONSTRAINT `k` FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT `l` FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;

/* Session Table ******************************************************************/
CREATE TABLE `Session` (
	`sesID` INT,
	`secID` INT,
	`cID` INT,
	`name` CHAR(50),
	`theDate` DATE,
	`announcement` CHAR(255),

	PRIMARY KEY (`sesID`, `secID`, `cID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO `Session` 
VALUES (1, 2, 1, "Exploring the Sun", '2019-09-03', "Bring binoculars!");
INSERT INTO `Session` 
VALUES (2, 2, 1, "Exploring the Moon", '2019-09-05', "Bring crackers!");
INSERT INTO `Session` 
VALUES (1, 2, 2, "Contemplating Space", '2019-09-03', "Bring a ruler!");
INSERT INTO `Session` 
VALUES (2, 2, 2, "Contemplating Time", '2019-09-05', "Bring a watch!");
INSERT INTO `Session` 
VALUES (1, 2, 3, "Understanding Gravity", '2019-09-03', "Bring an apple!");
INSERT INTO `Session` 
VALUES (2, 2, 3, "Understanding Light", '2019-09-05', "Bring a lamp!");
INSERT INTO `Session` 
VALUES (1, 2, 4, "Basics of thrust", '2019-09-03', "Bring your rocket fuel!");
INSERT INTO `Session` 
VALUES (2, 2, 4, "Launch Day", '2019-09-05', "Bring your spacesuit!");
INSERT INTO `Session` 
VALUES (1, 2, 5, "Life Lessons", '2019-09-03', "Don't forget your humility!");
INSERT INTO `Session` 
VALUES (2, 2, 5, "Death Lessons", '2019-09-05', "Make sure your bucket is full!");


/* Schedule Table *********************************************************/
CREATE TABLE `Schedule` (
	`schedID` INT,
	`secID` INT,
	`cID` INT,
	`startTime` TIME,
	`endTime` TIME,
	`days` CHAR(20),

	PRIMARY KEY (`schedID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`),
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`)
) DEFAULT CHARSET = utf8;
INSERT INTO Schedule 
VALUES (1, 1, 1, '16:00', '17:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (2, 2, 1, '16:00', '17:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (3, 1, 2, '16:00', '17:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (4, 2, 2, '16:00', '17:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (5, 1, 3, '17:00', '18:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (6, 2, 3, '17:00', '18:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (7, 1, 4, '17:00', '18:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (8, 2, 4, '17:00', '18:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (9, 1, 5, '18:00', '19:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (10, 2, 5, '18:00', '19:00', 'Tu, Th');

CREATE TABLE `Moderates` (
	`secID` INT,
	`cID` INT,
	`modID` INT,

	PRIMARY KEY(`secID`, `cID`, `modID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`modID`) REFERENCES Moderator(`modID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Moderates 
VALUES (1, 1, 4);

 
CREATE TABLE `Learns` (
	`secID` INT,
	`cID` INT,
	`eeID` INT,
	
	PRIMARY KEY(`secID`, `cID`, `eeID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`eeID`) REFERENCES Mentee(`eeID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;

CREATE TABLE `Teaches` (
	`secID` INT,
    `cID` INT,
	`orID` INT,

	PRIMARY KEY(`secID`, `cID`, `orID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`orID`) REFERENCES Mentor(`orID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;

CREATE TABLE `Material` (
	`matID` INT,
	`author` CHAR(50),
	`type` CHAR(50),
	`URL` CHAR(200),
	`title` CHAR(50),

PRIMARY KEY (`matID`)
) DEFAULT CHARSET = utf8;

CREATE TABLE `SessionMat` (
	`sesID` INT,
	`secID` INT,
	`cID` INT,
	`matID` INT,
	`assigned` DATETIME,
	`due` DATETIME,
    `notes` CHAR(255),

	PRIMARY KEY (`matID`, `sesID`, `secID`, `cID`),
	CONSTRAINT FOREIGN KEY (`sesID`) REFERENCES `Session`(`sesID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES `Session`(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES `Session`(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`matID`) REFERENCES Material(`matID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
