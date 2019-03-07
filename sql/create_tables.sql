DROP TABLE IF EXISTS `SessionMat`;
DROP TABLE IF EXISTS `Material`;
DROP TABLE IF EXISTS `Learns`;
DROP TABLE IF EXISTS `Record`;
DROP TABLE IF EXISTS `Review`;
DROP TABLE IF EXISTS `Schedule`;
DROP TABLE IF EXISTS `Teaches`;
DROP TABLE IF EXISTS `Session`;
DROP TABLE IF EXISTS `Section`;
DROP TABLE IF EXISTS `Course`;
DROP TABLE IF EXISTS `Moderator`;
DROP TABLE IF EXISTS `Family`;
DROP TABLE IF EXISTS `MENTEE`;
DROP TABLE IF EXISTS `Mentor`;
DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
	`uID` INT,
	`name` CHAR(50),
	`email` CHAR(50),
	`phone` CHAR(14),
	`username` CHAR(50),
	`password` CHAR(50),
	`type` CHAR(1),

	PRIMARY KEY (`uID`)
) DEFAULT CHARSET = utf8;
/*INSERT INTO User
VALUES (1, 'Billy Bob', 'bb@fake.com', '617-994-5233', 'bb', '123456', 'P');
INSERT INTO User
VALUES (2, 'Betty Bob', 'bettyb@fake.com', '666-666-5666', 'bettyb', '987654', 'S');
INSERT INTO User
VALUES (3, 'Bobby Bob', 'bobbyb@fake.com', '777-777-5777', 'bobbyb', '99999', 'S');
*/
CREATE TABLE `Mentor` (
	`orID` INT,
	`grade` INT,

	PRIMARY KEY (`orID`),
	CONSTRAINT `a` FOREIGN KEY (`orID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
/*INSERT INTO Mentor
VALUES (2, 10);*/

CREATE TABLE `Mentee` (
	`eeID` INT,
	`GRADE` INT,
	
	PRIMARY KEY (`eeID`),
	CONSTRAINT `b` FOREIGN KEY (`eeID`) REFERENCES User(`uID`)
) DEFAULT CHARSET = utf8;
/*INSERT INTO Mentee
VALUES (3, 7);*/

CREATE TABLE Moderator (
	modID INT,
	
	PRIMARY KEY (modID),
	CONSTRAINT `assign_modID` FOREIGN KEY (modID) REFERENCES `User`(uID) ON DELETE CASCADE 
) DEFAULT CHARSET = utf8;
/*INSERT INTO Moderator
VALUES (1);*/

CREATE TABLE `Family` (
	`pID` INT,
	`sID` INT,

	PRIMARY KEY (`pID`, `sID`),
	CONSTRAINT `c` FOREIGN KEY (`pID`) REFERENCES User(`uID`) ON DELETE CASCADE,
	CONSTRAINT `d` FOREIGN KEY (`sID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;

CREATE TABLE `Course` (
	`cID` INT,
	`title` CHAR(50),
	`description` CHAR(255),
	`orReq` INT,
	`eeReq` INT,
	
	PRIMARY KEY (`cID`)
) DEFAULT CHARSET = utf8;

CREATE TABLE `Section` (
	`secID` INT,
	`cID` INT,
	`schedID` INT,
	`name` CHAR(50),
	`capacity` INT,
	`tuition` FLOAT,
	`salary` FLOAT,

	PRIMARY KEY (`secID`, `cID`),
	CONSTRAINT `e` FOREIGN KEY (`cID`) REFERENCES Course(`cID`) ON DELETE CASCADE,
	UNIQUE (`schedID`)
) DEFAULT CHARSET = utf8;


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

CREATE TABLE `Session` (
	`sesID` INT,
	`secID` INT,
	`cID` INT,
	`name` CHAR(50),
	`theDate` DATE,
	`announcement` CHAR(255),

	PRIMARY KEY (`sesID`, `secID`, `cID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`),
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`)
) DEFAULT CHARSET = utf8;

CREATE TABLE `Schedule` (
	`schedID` INT,
	`secID` INT,
	`cID` INT,
	`startDate` DATE,
	`endDate` DATE,
	`startTime` TIME,
	`endTime` TIME,
	`days` CHAR(20),

	PRIMARY KEY (`schedID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`),
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`)
) DEFAULT CHARSET = utf8;

CREATE TABLE `Learns` (
	`secID` INT,
	`cID` INT,
	`eeID` INT,
	
	PRIMARY KEY(`secID`, `eeID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`),
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`),
	CONSTRAINT FOREIGN KEY (`eeID`) REFERENCES Mentee(`eeID`)
) DEFAULT CHARSET = utf8;


CREATE TABLE `Teaches` (
	`secID` INT,
    `cID` INT,
	`orID` INT,

	PRIMARY KEY(`secID`, `cID`, `orID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`),
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`),
	CONSTRAINT FOREIGN KEY (`orID`) REFERENCES Mentor(`orID`)
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
	CONSTRAINT FOREIGN KEY (`sesID`) REFERENCES `Session`(`sesID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES `Session`(`secID`),
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES `Session`(`cID`),
	CONSTRAINT FOREIGN KEY (`matID`) REFERENCES Material(`matID`)
) DEFAULT CHARSET = utf8;
