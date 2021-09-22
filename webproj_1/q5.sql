-- Print the narrative summary for CS majors for outcome 2 that were assessed 
-- by sectionId 3. Print the strengths, weaknesses, and actions.

SELECT n.strengths, n.weaknesses, n.actions 
FROM Narratives n 
WHERE n.major = "CS" AND n.outcomeId = 3 AND n.sectionId = 4;