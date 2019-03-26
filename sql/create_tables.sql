\W /* Show Warnings */

DROP TABLE IF EXISTS `SessionMat`;
DROP TABLE IF EXISTS `Material`;
DROP TABLE IF EXISTS `SessLearn`;
DROP TABLE IF EXISTS `SessTeach`;
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
VALUES (1, 'Billy', 'billy@billy.com', '617-994-5233', 'Billy', 'password', 'Parent');
INSERT INTO User
VALUES (2, 'Betty', 'betty@betty.com', '666-666-5666', 'Betty', 'password', 'Mentee');
INSERT INTO User
VALUES (3, 'Bobby', 'bobby@bobby.com', '777-777-5777', 'Bobby', 'password', 'Mentee');
INSERT INTO User
VALUES (4, 'Becky', 'becky@becky.com', '999-999-9999', 'Becky', 'password', 'Moderator');
INSERT INTO User
VALUES (5, 'Bart', 'bart@bart.com', '888-888-8888', 'Bart', 'password', 'Mentor');
INSERT INTO User
VALUES (6, 'Ben', 'ben@ben.com', '555-555-5555', 'Ben', 'password', 'Mentor');
INSERT INTO User
VALUES (7, 'Brett', 'brett@brett.com', '898-484-8448', 'Brett', 'password', 'Both');
INSERT INTO User
VALUES (8, 'Beatrice', 'beatrice@beatrice.com', '975-675-6555', 'Beatrice', 'password', 'Moderator');
INSERT INTO User
VALUES (9, 'Beau', 'beau@beau.com', '834-238-8328', 'Beau', 'password', 'Moderator');
INSERT INTO User
VALUES (10, 'Bella', 'bella@bella.com', '935-105-2025', 'Bella', 'password', 'Moderator');
INSERT INTO User
VALUES (11, 'Brock', 'brock@brock.com', '866-548-3328', 'Brock', 'password', 'Both');
INSERT INTO User
VALUES (12, 'Bartleby', 'bartleby@bartleby.com', '455-215-2152', 'bartleby', 'password', 'Both');
INSERT INTO User
VALUES (13, 'Blair', 'blair@blair.com', '821-218-3328', 'Blair witch', 'password', 'Moderator');
INSERT INTO User
VALUES (14, 'Beth', 'beth@beth.com', '455-345-2121', 'Beth', 'password', 'Both');
INSERT INTO User
VALUES (15, 'Barnaby', 'barnaby@barnaby.com', '843-221-3355', 'Barnaby', 'password', 'Moderator');
INSERT INTO User
VALUES (16, 'Bonnie', 'bonnie@bonnie.com', '215-125-2444', 'Bonnie', 'password', 'Both');
INSERT INTO User
VALUES (17, 'Brandon', 'brandon@brandon.com', '899-991-2955', 'Brandon', 'password', 'Moderator');
INSERT INTO User
VALUES (18, 'Brady', 'brady@brady.com', '265-545-1554', 'Brady', 'password', 'Both');
INSERT INTO User
VALUES (19, 'Brailey', 'bailey@bailey.com', '803-921-4565', 'Bailey', 'password', 'Moderator');
INSERT INTO User
VALUES (20, 'Brooke', 'brooke@brooke.com', '123-543-6969', 'Brooke', 'password', 'Both');
INSERT INTO User
VALUES (21, 'Benedict', 'benedict@benedict.com', '899-221-1865', 'Benedict', 'password', 'Moderator');
INSERT INTO User
VALUES (22, 'Benny', 'benny@benny.com', '165-543-6009', 'Benny', 'password', 'Both');
INSERT INTO User
VALUES (23, 'Bernard', 'bernard@bernard.com', '162-043-6239', 'Bernard', 'password', 'Moderator');



/* Student Table *****************************************************/
CREATE TABLE `Student` (
	`sID` INT,
	`grade` INT,

	PRIMARY KEY (`sID`),
	CONSTRAINT FOREIGN KEY (`sID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Student VALUES (2, 9);
INSERT INTO Student VALUES (3, 10);
INSERT INTO Student VALUES (5, 12);
INSERT INTO Student VALUES (6, 12);
INSERT INTO Student VALUES (7, 12);
INSERT INTO Student VALUES (11, 12);
INSERT INTO Student VALUES (12, 12);
INSERT INTO Student VALUES (14, 12);
INSERT INTO Student VALUES (16, 12);
INSERT INTO Student VALUES (18, 12);
INSERT INTO Student VALUES (20, 12);
INSERT INTO Student VALUES (22, 12);


/* Mentor Table ********************************************************/
CREATE TABLE `Mentor` (
	`orID` INT,

	PRIMARY KEY (`orID`),
	CONSTRAINT FOREIGN KEY (`orID`) REFERENCES Student(`sID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Mentor VALUES (5);
INSERT INTO Mentor VALUES (6);
INSERT INTO Mentor VALUES (7);
INSERT INTO Mentor VALUES (11);
INSERT INTO Mentor VALUES (12);
INSERT INTO Mentor VALUES (14);
INSERT INTO Mentor VALUES (16);
INSERT INTO Mentor VALUES (18);
INSERT INTO Mentor VALUES (20);
INSERT INTO Mentor VALUES (22);

/* Mentee Table ********************************************************/
CREATE TABLE `Mentee` (
	`eeID` INT,
	
	PRIMARY KEY (`eeID`),
	CONSTRAINT `b` FOREIGN KEY (`eeID`) REFERENCES Student(`sID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Mentee VALUES (2);
INSERT INTO Mentee VALUES (3);
INSERT INTO Mentee VALUES (7);
INSERT INTO Mentee VALUES (11);
INSERT INTO Mentee VALUES (12);
INSERT INTO Mentee VALUES (14);
INSERT INTO Mentee VALUES (16);
INSERT INTO Mentee VALUES (18);
INSERT INTO Mentee VALUES (20);
INSERT INTO Mentee VALUES (22);

/* Parent Table *********************************************************/
CREATE TABLE `Parent` (
	`pID` INT,

	PRIMARY KEY (`pID`),
	CONSTRAINT FOREIGN KEY (`pID`) REFERENCES User(`uID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Parent VALUES (1);
INSERT INTO Parent VALUES (4);
INSERT INTO Parent VALUES (8);
INSERT INTO Parent VALUES (9);
INSERT INTO Parent VALUES (10);
INSERT INTO Parent VALUES (13);
INSERT INTO Parent VALUES (15);
INSERT INTO Parent VALUES (17);
INSERT INTO Parent VALUES (19);
INSERT INTO Parent VALUES (21);
INSERT INTO Parent VALUES (23);

/* Moderator Table ***********************************************************/
CREATE TABLE `Moderator` (
	modID INT,
	
	PRIMARY KEY (modID),
	CONSTRAINT `assign_modID` FOREIGN KEY (modID) REFERENCES `User`(uID) ON DELETE CASCADE 
) DEFAULT CHARSET = utf8;
INSERT INTO Moderator VALUES (4);
INSERT INTO Moderator VALUES (8);
INSERT INTO Moderator VALUES (9);
INSERT INTO Moderator VALUES (10);
INSERT INTO Moderator VALUES (13);
INSERT INTO Moderator VALUES (15);
INSERT INTO Moderator VALUES (17);
INSERT INTO Moderator VALUES (19);
INSERT INTO Moderator VALUES (21);
INSERT INTO Moderator VALUES (23);

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
INSERT INTO Family VALUES (8, 7);
INSERT INTO Family VALUES (9, 11);
INSERT INTO Family VALUES (10, 12);
INSERT INTO Family VALUES (13, 14);
INSERT INTO Family VALUES (15, 16);
INSERT INTO Family VALUES (17, 18);
INSERT INTO Family VALUES (19, 20);
INSERT INTO Family VALUES (21, 22);
INSERT INTO Family VALUES (23, 22);

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
VALUES (1, 'Exploring the Solar System', 'Learn about the wonderful components that make up our solar systems', 11, 9);
INSERT INTO Course 
VALUES (2, 'Metaphysics', 'A study about our understanding of physics and the nature of reality', 11, 9);
INSERT INTO Course 
VALUES (3, 'Physics', 'Learn about the fundamental laws of physics.', 11, 10);
INSERT INTO Course 
VALUES (4, 'Advanced Rocketry', 'In this course We will be building a rocket and flying to the moon.', 12, 11);
INSERT INTO Course 
VALUES (5, 'Humility', 'In this course Seniors will learn valuable life lessons from their younger peers.', 9, 12);
INSERT INTO Course 
VALUES (6, 'Hungarian', 'Learn how to speak Hungarian.', 10, 9);
INSERT INTO Course 
VALUES (7, 'Spanish', 'Learn how to speak Spanish.', 10, 9);
INSERT INTO Course 
VALUES (8, 'Mandarin', 'Learn how to speak Mandarin.', 10, 9);
INSERT INTO Course 
VALUES (9, 'Japanese', 'Learn how to speak Japanese.', 10, 9);
INSERT INTO Course 
VALUES (10, 'English', 'Learn how to speak English.', 10, 9);
 
/* Section Table ************************************************************/
CREATE TABLE `Section` (
	`secID` INT,
	`cID` INT,
	`schedID` INT,
	`name` CHAR(50),
	`mentorCap` INT,
	`menteeCap` INT,
	`tuition` FLOAT,
	`salary` FLOAT,
	`startDate` DATE,
	`endDate` DATE,

	PRIMARY KEY (`secID`, `cID`),
	CONSTRAINT `e` FOREIGN KEY (`cID`) REFERENCES Course(`cID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Section 
VALUES (1, 1, 1, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 1, 2, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (3, 1, 3, "Section 3", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (4, 1, 4, "Section 4", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 2, 3, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 2, 4, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 3, 5, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 3, 6, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 4, 7, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 4, 8, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 5, 9, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 5, 10, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 6, 1, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 6, 2, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 7, 3, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 7, 4, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 8, 5, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 8, 6, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 9, 7, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 9, 8, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');
INSERT INTO Section 
VALUES (1, 10, 9, "Section 1", 3, 6, 7.00, 7.00, '2018-01-01', '2018-05-01');
INSERT INTO Section 
VALUES (2, 10, 10, "Section 2", 3, 6, 7.00, 7.00, '2019-01-01', '2019-05-01');


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
VALUES (1, 2, 1, "Exploring the Sun", '2019-03-28', "Bring binoculars!");
INSERT INTO `Session` 
VALUES (2, 2, 1, "Exploring the Moon", '2019-04-02', "Bring crackers!");
INSERT INTO `Session` 
VALUES (3, 2, 1, "Exploring Mars", '2019-04-04', "Bring Matt Damon!");
INSERT INTO `Session` 
VALUES (4, 2, 1, "Exploring Nibiru", '2019-04-11', "Bring tin foil!");
INSERT INTO `Session` 
VALUES (5, 1, 1, "Exploring the Sun", '2018-03-29', "Bring binoculars!");
INSERT INTO `Session` 
VALUES (6, 1, 1, "Exploring the Moon", '2018-04-05', "Bring crackers!");
INSERT INTO `Session` 
VALUES (7, 1, 1, "Exploring Mars", '2018-04-10', "Bring Matt Damon!");
INSERT INTO `Session` 
VALUES (8, 1, 1, "Exploring Nibiru", '2018-04-12', "Bring tin foil!");
INSERT INTO `Session` 
VALUES (1, 2, 2, "Contemplating Space", '2019-03-28', "Bring a ruler!");
INSERT INTO `Session` 
VALUES (2, 2, 2, "Contemplating Time", '2019-04-02', "Bring a watch!");
INSERT INTO `Session` 
VALUES (1, 2, 3, "Understanding Gravity", '2019-03-28', "Bring an apple!");
INSERT INTO `Session` 
VALUES (2, 2, 3, "Understanding Light", '2019-04-02', "Bring a lamp!");
INSERT INTO `Session` 
VALUES (1, 2, 4, "Basics of thrust", '2019-03-28', "Bring your rocket fuel!");
INSERT INTO `Session` 
VALUES (2, 2, 4, "Launch Day", '2019-04-02', "Bring your spacesuit!");
INSERT INTO `Session` 
VALUES (1, 2, 5, "Life Lessons", '2019-03-28', "Don't forget your humility!");
INSERT INTO `Session` 
VALUES (2, 2, 5, "Death Lessons", '2019-04-02', "Make sure your bucket is full!");
INSERT INTO `Session` 
VALUES (1, 2, 6, "Nouns", '2019-03-28', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (2, 2, 6, "Verbs", '2019-04-02', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (1, 2, 7, "Nouns", '2019-03-28', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (2, 2, 7, "Verbs", '2019-04-02', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (1, 2, 8, "Nouns", '2019-03-28', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (2, 2, 8, "Verbs", '2019-04-02', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (1, 2, 9, "Nouns", '2019-03-28', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (2, 2, 9, "Verbs", '2019-04-02', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (1, 2, 10, "Nouns", '2019-03-28', "Bring your textbook!");
INSERT INTO `Session` 
VALUES (2, 2, 10, "Verbs", '2019-04-02', "Bring your textbook!");

/* Schedule Table *********************************************************/
CREATE TABLE `Schedule` (
	`schedID` INT,
	`startTime` TIME,
	`endTime` TIME,
	`days` CHAR(20),

	PRIMARY KEY (`schedID`)
) DEFAULT CHARSET = utf8;
INSERT INTO Schedule 
VALUES (1, '15:00', '16:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (2, '16:00', '17:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (3, '17:00', '18:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (4, '18:00', '19:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (5, '19:00', '20:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (6, '20:00', '21:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (7, '21:00', '22:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (8, '1:00', '2:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (9, '3:00', '4:00', 'Tu, Th');
INSERT INTO Schedule 
VALUES (10, '4:00', '5:00', 'Tu, Th');

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
INSERT INTO Moderates 
VALUES (2, 1, 4);
INSERT INTO Moderates 
VALUES (1, 2, 13);
INSERT INTO Moderates 
VALUES (2, 2, 13);
INSERT INTO Moderates 
VALUES (1, 3, 15);
INSERT INTO Moderates 
VALUES (2, 3, 15);
INSERT INTO Moderates 
VALUES (1, 4, 17);
INSERT INTO Moderates 
VALUES (2, 4, 17);
INSERT INTO Moderates 
VALUES (1, 5, 19);
INSERT INTO Moderates 
VALUES (2, 5, 19);
INSERT INTO Moderates 
VALUES (1, 10, 4);
INSERT INTO Moderates 
VALUES (2, 10, 4);
INSERT INTO Moderates 
VALUES (1, 9, 13);
INSERT INTO Moderates 
VALUES (2, 9, 13);
INSERT INTO Moderates 
VALUES (1, 8, 15);
INSERT INTO Moderates 
VALUES (2, 8, 15);
INSERT INTO Moderates 
VALUES (1, 7, 17);
INSERT INTO Moderates 
VALUES (2, 7, 17);
INSERT INTO Moderates 
VALUES (1, 6, 19);
INSERT INTO Moderates 
VALUES (2, 6, 19);


 
CREATE TABLE `Learns` (
	`secID` INT,
	`cID` INT,
	`eeID` INT,
	
	PRIMARY KEY(`secID`, `cID`, `eeID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`eeID`) REFERENCES Mentee(`eeID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Learns 
VALUES (1, 1, 11);

INSERT INTO Learns 
VALUES (2, 1, 12);
INSERT INTO Learns 
VALUES (2, 1, 2);
INSERT INTO Learns 
VALUES (2, 1, 3);
INSERT INTO Learns 
VALUES (2, 1, 14);
INSERT INTO Learns 
VALUES (2, 1, 16);
INSERT INTO Learns 
VALUES (2, 1, 18);

INSERT INTO Learns
VALUES (1, 2, 14);
INSERT INTO Learns 
VALUES (2, 2, 14);
INSERT INTO Learns 
VALUES (1, 3, 18);
INSERT INTO Learns 
VALUES (2, 3, 20);
INSERT INTO Learns 
VALUES (1, 4, 12);
INSERT INTO Learns 
VALUES (2, 4, 14);
INSERT INTO Learns 
VALUES (1, 5, 18);
INSERT INTO Learns 
VALUES (2, 5, 20);
INSERT INTO Learns 
VALUES (1, 10, 12);
INSERT INTO Learns 
VALUES (2, 10, 14);
INSERT INTO Learns 
VALUES (1, 9, 18);
INSERT INTO Learns 
VALUES (2, 9, 20);
INSERT INTO Learns 
VALUES (1, 8, 11);
INSERT INTO Learns 
VALUES (2, 8, 12);
INSERT INTO Learns 
VALUES (1, 7, 14);
INSERT INTO Learns 
VALUES (2, 7, 18);
INSERT INTO Learns 
VALUES (1, 6, 20);
INSERT INTO Learns 
VALUES (2, 6, 22);

CREATE TABLE `Teaches` (
	`secID` INT,
    `cID` INT,
	`orID` INT,

	PRIMARY KEY(`secID`, `cID`, `orID`),
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES Section(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES Section(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`orID`) REFERENCES Mentor(`orID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO Teaches 
VALUES (1, 1, 5);
INSERT INTO Teaches 
VALUES (1, 1, 22);
INSERT INTO Teaches 
VALUES (1, 1, 20);
INSERT INTO Teaches 
VALUES (2, 1, 5);
INSERT INTO Teaches 
VALUES (2, 1, 22);
INSERT INTO Teaches 
VALUES (2, 1, 20);
INSERT INTO Teaches 
VALUES (1, 2, 5);
INSERT INTO Teaches 
VALUES (2, 2, 5);
INSERT INTO Teaches
VALUES (1, 2, 6);
INSERT INTO Teaches 
VALUES (2, 2, 6);
INSERT INTO Teaches 
VALUES (1, 3, 5);
INSERT INTO Teaches 
VALUES (2, 3, 5);
INSERT INTO Teaches 
VALUES (1, 4, 5);
INSERT INTO Teaches 
VALUES (2, 4, 5);
INSERT INTO Teaches 
VALUES (1, 5, 5);
INSERT INTO Teaches 
VALUES (2, 5, 5);
INSERT INTO Teaches 
VALUES (1, 10, 5);
INSERT INTO Teaches 
VALUES (2, 10, 6);
INSERT INTO Teaches 
VALUES (1, 9, 16);
INSERT INTO Teaches 
VALUES (2, 9, 16);
INSERT INTO Teaches 
VALUES (1, 8, 16);
INSERT INTO Teaches 
VALUES (2, 8, 16);
INSERT INTO Teaches 
VALUES (1, 7, 16);
INSERT INTO Teaches 
VALUES (2, 7, 16);
INSERT INTO Teaches 
VALUES (1, 6, 16);
INSERT INTO Teaches 
VALUES (2, 6, 16);

CREATE TABLE `SessTeach`(
	`sesID` INT,
	`secID` INT,
	`cID` INT,
	`orID` INT,

	PRIMARY KEY(`sesID`, `secID`, `cID`, `orID`),
	CONSTRAINT FOREIGN KEY (`sesID`) REFERENCES `Session`(`sesID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES `Session`(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES `Session`(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`orID`) REFERENCES `Mentor`(`orID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO `SessTeach` 
VALUES (1, 2, 1, 5);
INSERT INTO `SessTeach` 
VALUES (1, 2, 1, 22);
INSERT INTO `SessTeach` 
VALUES (1, 2, 1, 20);

INSERT INTO `SessTeach` 
VALUES (2, 2, 1, 5);
INSERT INTO `SessTeach` 
VALUES (3, 2, 1, 5);
INSERT INTO `SessTeach` 
VALUES (4, 2, 1, 5);

INSERT INTO `SessTeach` 
VALUES (5, 1, 1, 5);
INSERT INTO `SessTeach` 
VALUES (5, 1, 1, 20);
INSERT INTO `SessTeach` 
VALUES (5, 1, 1, 22);

INSERT INTO `SessTeach` 
VALUES (6, 1, 1, 5);
INSERT INTO `SessTeach` 
VALUES (6, 1, 1, 20);
INSERT INTO `SessTeach` 
VALUES (6, 1, 1, 22);

INSERT INTO `SessTeach` 
VALUES (7, 1, 1, 5);
INSERT INTO `SessTeach` 
VALUES (7, 1, 1, 20);
INSERT INTO `SessTeach` 
VALUES (7, 1, 1, 22);

INSERT INTO `SessTeach` 
VALUES (8, 1, 1, 5);
INSERT INTO `SessTeach` 
VALUES (8, 1, 1, 20);
INSERT INTO `SessTeach` 
VALUES (8, 1, 1, 22);

INSERT INTO `SessTeach` 
VALUES (1, 2, 2, 6);
INSERT INTO `SessTeach` 
VALUES (2, 2, 2, 6);

CREATE TABLE `SessLearn`(
	`sesID` INT,
	`secID` INT,
	`cID` INT,
	`eeID` INT,

	PRIMARY KEY(`sesID`, `secID`, `cID`, `eeID`),
	CONSTRAINT FOREIGN KEY (`sesID`) REFERENCES `Session`(`sesID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`secID`) REFERENCES `Session`(`secID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`cID`) REFERENCES `Session`(`cID`) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (`eeID`) REFERENCES Mentee(`eeID`) ON DELETE CASCADE
) DEFAULT CHARSET = utf8;
INSERT INTO `SessLearn` 
VALUES (1, 2, 1, 2);
INSERT INTO `SessLearn` 
VALUES (1, 2, 1, 3);
INSERT INTO `SessLearn` 
VALUES (1, 2, 1, 12);

INSERT INTO `SessLearn` 
VALUES (2, 2, 1, 2);
INSERT INTO `SessLearn` 
VALUES (3, 2, 1, 2);
INSERT INTO `SessLearn` 
VALUES (4, 2, 1, 2);

INSERT INTO `SessLearn` 
VALUES (5, 1, 1, 2);
INSERT INTO `SessLearn` 
VALUES (5, 1, 1, 3);
INSERT INTO `SessLearn` 
VALUES (5, 1, 1, 12);

INSERT INTO `SessLearn` 
VALUES (6, 1, 1, 2);
INSERT INTO `SessLearn` 
VALUES (6, 1, 1, 3);
INSERT INTO `SessLearn` 
VALUES (6, 1, 1, 12);

INSERT INTO `SessLearn` 
VALUES (7, 1, 1, 2);
INSERT INTO `SessLearn` 
VALUES (7, 1, 1, 3);
INSERT INTO `SessLearn` 
VALUES (7, 1, 1, 12);

INSERT INTO `SessLearn` 
VALUES (8, 1, 1, 2);
INSERT INTO `SessLearn` 
VALUES (8, 1, 1, 3);
INSERT INTO `SessLearn` 
VALUES (8, 1, 1, 12);

INSERT INTO `SessLearn` 
VALUES (1, 2, 2, 14);
INSERT INTO `SessLearn` 
VALUES (2, 2, 2, 14);

/* Material Table ********************************************/
CREATE TABLE `Material` (
	`matID` INT,
	`author` CHAR(50),
	`type` CHAR(50),
	`URL` CHAR(200),
	`title` CHAR(50),

PRIMARY KEY (`matID`)
) DEFAULT CHARSET = utf8;
INSERT INTO Material 
VALUES(1, "Joe Smith", "article", "www.thesun.com", "The Sun");
INSERT INTO Material 
VALUES(2, "Joe Smith", "article", "www.themoon.com", "The Moon");
INSERT INTO Material 
VALUES(3, "Joe Smith", "article", "www.mars.com", "Destination Mars");
INSERT INTO Material 
VALUES(4, "Joe Smith", "article", "www.nibiru.com", "Finding Nibiru");
INSERT INTO Material 
VALUES(5, "Adam Smith", "article", "www.thesun.com", "Sun Spot");
INSERT INTO Material 
VALUES(6, "Adam Smith", "article", "www.themoon.com", "The Lunar Landing");
INSERT INTO Material 
VALUES(7, "Adam Smith", "article", "www.mars.com", "Martians");
INSERT INTO Material 
VALUES(8, "Adam Smith", "article", "www.nibiru.com", "About Nibiru");
INSERT INTO Material 
VALUES(9, "John Smith", "article", "www.eg.com", "Euclidean Geometry");
INSERT INTO Material 
VALUES(10, "John Smith", "article", "www.space.com", "Space is quite large");

/* SessionMat Table ********************************************************/
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
INSERT INTO `SessionMat` 
VALUES (1, 2, 1, 1, '2019-03-23', '2019-03-28', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (2, 2, 1, 2, '2019-03-23', '2019-04-02', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (3, 2, 1, 3,'2019-03-23', '2019-04-4', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (4, 2, 1, 4, '2019-03-23', '2019-04-11', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (5, 1, 1, 5, '2018-03-23', '2018-03-29', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (6, 1, 1, 6, '2018-03-23', '2018-04-05', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (7, 1, 1, 7, '2018-03-23', '2018-04-10', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (8, 1, 1, 8, '2018-03-23', '2018-04-12', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (1, 2, 2, 9, '2019-03-23', '2019-03-28', "Please read before class.");
INSERT INTO `SessionMat` 
VALUES (2, 2, 2, 10,'2019-03-23', '2019-04-02', "Please read before class");