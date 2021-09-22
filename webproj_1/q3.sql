-- Print all outcome results for CS majors for outcome 2 that were assessed 
-- by sectionId 3. Print the performance description (e.g., Meets Expectations) 
-- and number of students that achieved that performance description. 
-- Order the results by performanceLevel. Note that you are printing the 
-- performance description, not the performanceLevel, but you are ordering 
-- the results by the performance Level.

SELECT p.description, r.numberOfStudents
FROM OutcomeResults r 
NATURAL JOIN PerformanceLevels p 
WHERE r.sectionId = 3 AND r.major = "CS" AND r.outcomeId = 2
ORDER BY r.performanceLevel;