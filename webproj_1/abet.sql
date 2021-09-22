DROP TABLE IF EXISTS Assessments;
DROP TABLE IF EXISTS OutcomeResults;
DROP TABLE IF EXISTS Narratives;
DROP TABLE IF EXISTS CourseOutcomeMapping;
DROP TABLE IF EXISTS PerformanceLevels;
DROP TABLE IF EXISTS Outcomes;
DROP TABLE IF EXISTS Sections;
DROP TABLE IF EXISTS Instructors;
DROP TABLE IF EXISTS Courses;

-- set default instructor id as BVZ?
CREATE TABLE Instructors(
	instructorId int(4) NOT NULL,
	firstname varchar(30) NOT NULL,
	lastname varchar(30) NOT NULL,
	email varchar(50) NOT NULL,
	password varchar(100) NOT NULL,

	PRIMARY KEY (instructorId)
);

CREATE TABLE Courses(
	courseId varchar(10) NOT NULL,
	courseTitle varchar(100) NOT NULL,

	PRIMARY KEY  (courseId)
);

CREATE TABLE Sections(
	sectionId int(4) NOT NULL UNIQUE,
	instructorId int(4) NOT NULL,
	courseId varchar(10) NOT NULL,
	semester ENUM('spring', 'fall', 'summer') NOT NULL,
	year int(4) NOT NULL,

	PRIMARY KEY (sectionId),

	FOREIGN KEY (courseId) REFERENCES Courses(courseId)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE,

	FOREIGN KEY (instructorId) REFERENCES Instructors(instructorId)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE
);

CREATE TABLE Outcomes(
	outcomeId int(2) NOT NULL,
	outcomeDescription varchar(500) NOT NULL,
	major ENUM('CS', 'CpE', 'EE') NOT NULL,

	PRIMARY KEY (outcomeId, major)
);

CREATE TABLE PerformanceLevels(
	performanceLevel int(1) NOT NULL AUTO_INCREMENT,
	description varchar(50) NOT NULL,

	PRIMARY KEY (performanceLevel)
);

-- primary key is all entries?
-- set null for outcomeId and major?
CREATE TABLE CourseOutcomeMapping(
	courseId varchar(10) NOT NULL, 
	outcomeId int(2) NOT NULL,
	major ENUM('CS', 'CpE', 'EE') NOT NULL,
	semester ENUM('spring', 'fall', 'summer') NOT NULL,
	year int(4) NOT NULL,

	PRIMARY KEY (courseId, outcomeId, major, semester, year),

	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes(outcomeId, major)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE,

	FOREIGN KEY (courseId) REFERENCES Courses(courseId)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE

);

-- set null/default for outcomeId and major?
CREATE TABLE Narratives(
	sectionId int(4) NOT NULL, 
	major ENUM('CS', 'CpE', 'EE') NOT NULL,
	outcomeId int(2) NOT NULL,
	strengths varchar(1000) NOT NULL,
	weaknesses varchar(1000) NOT NULL,
	actions varchar(1000),

	PRIMARY KEY(sectionId, major, outcomeId),

	FOREIGN KEY (sectionId) REFERENCES Sections(sectionId)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE,

	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes(outcomeId, major)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE
);

-- set null/default for outcomeId and major?
CREATE TABLE OutcomeResults(
	sectionId int(4) NOT NULL,
	outcomeId int(2) NOT NULL,
	major ENUM('CS', 'CpE', 'EE') NOT NULL,
	performanceLevel int(1) NOT NULL, 
	numberOfStudents int(5) NOT NULL,

	PRIMARY KEY (sectionId, outcomeId, major, performanceLevel),
 	 
 	FOREIGN KEY (sectionId) REFERENCES Sections(sectionId)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE,

	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes(outcomeId, major)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE,

	FOREIGN KEY (performanceLevel) REFERENCES PerformanceLevels(performanceLevel)
		ON DELETE RESTRICT
		ON UPDATE CASCADE

);

-- set null/default for outcomeId and major?
CREATE TABLE Assessments(
	assessmentId int(2) NOT NULL AUTO_INCREMENT,
	sectionId int(4) NOT NULL,
	assessmentDescription varchar(100) NOT NULL,
	weight int(3) NOT NULL,
	outcomeId int(2) NOT NULL,
	major ENUM('CS', 'CpE', 'EE') NOT NULL,

	PRIMARY KEY (assessmentId),

	FOREIGN KEY (sectionId) REFERENCES Sections(sectionId)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE,

	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes(outcomeId, major)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE
);