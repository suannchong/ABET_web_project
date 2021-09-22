-- Print the outcomeIds and outcomeDescriptions of all outcomes assessed 
-- for CS majors by sectionId 3. Order the output by outcomeIds. As with 
-- query 1, OutcomeResults is not an appropriate relation to use to satisfy 
-- this query.

SELECT o.outcomeId, o.outcomeDescription 
FROM Outcomes o
NATURAL JOIN CourseOutcomeMapping m 
NATURAL JOIN Sections s 
WHERE m.major = "CS" AND s.sectionId = 3
ORDER BY o.outcomeId;