-- Print the instructorId, sectionId, courseId, major, semester, and year 
-- of all sections taught by an instructor with an email address of 
-- "coyote@utk.edu" and password of "password" (the password string 
-- in the sample data you have been given is the hash string for "password" 
-- that is created by MySQL's PASSWORD function). Note that the same 
-- sectionId could appear twice in the results because that section 
-- might be used to assess both EE and CpE majors or both CS and CpE majors. 
-- The results should be ordered by year in descending order and 
-- secondarily by semester in ascending order. You cannot use OutcomeResults 
-- to satisfy this query because you will be using this query to locate the 
-- sections that an instructor needs to enter outcome results for. If the 
-- instructor has not yet entered any results for this section, then there 
-- will not be any tuples in OutcomeResults for the section and your query 
-- will fail to return the appropriate set of sections. If you are tempted to 
-- use OutcomeResults for this query, then you need to take a longer look at 
-- some of the other relations in the database.

SELECT DISTINCT s.instructorId, s.sectionId, s.courseId, m.major, s.semester, s.year
FROM Instructors i
NATURAL JOIN Sections s
NATURAL JOIN CourseOutcomeMapping m
WHERE i.email = 'coyote@utk.edu' AND i.password = PASSWORD("password")
ORDER BY s.year DESC, s.semester ASC;