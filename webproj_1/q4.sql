-- Print all assessment plans for CS majors for outcome 2 that were assessed 
-- by sectionId 3. Print the assessment description and weight. Order the 
-- results by weight in descending order and secondarily by assessment 
-- description in ascending order.

SELECT a.assessmentDescription, a.weight
FROM Assessments a 
WHERE a.major = "EE" AND a.outcomeId = 1 AND a.sectionId = 7
ORDER BY a.weight DESC, a.assessmentDescription ASC;
