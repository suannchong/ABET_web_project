-- Print the sectionId, instructor email, outcomeId, major, and sum of the 
-- weight fields (name it weightTotal) for any outcome whose assessments' 
-- weights for that outcome and major do not exactly equal 100. As one example, 
-- the sum of the assessment weights for EE majors for outcome 1 in section 7 is 
-- 70, so you would print the requested information for this section. Order the 
-- results by instructor email in ascending order, then by major in ascending 
-- order, and finally by outcome in ascending order.

SELECT a.sectionId, i.email, a.outcomeId, a.major, SUM(a.weight) AS weightTotal
FROM Assessments a 
NATURAL JOIN Sections s 
NATURAL JOIN Instructors i 
GROUP BY a.sectionId, a.outcomeId, a.major 
HAVING SUM(a.weight) <> 100
ORDER BY i.email, a.major, a.outcomeId;