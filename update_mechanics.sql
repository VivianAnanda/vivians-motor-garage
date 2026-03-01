-- Update mechanics names to new names

UPDATE mechanics SET mechanic_name = 'Charles Leclerc', specialization = 'Engine Specialist' WHERE mechanic_id = 1;
UPDATE mechanics SET mechanic_name = 'Max Verstappen', specialization = 'Transmission Expert' WHERE mechanic_id = 2;
UPDATE mechanics SET mechanic_name = 'Carlos Sainz', specialization = 'Electrical Systems' WHERE mechanic_id = 3;
UPDATE mechanics SET mechanic_name = 'Lewis Hamilton', specialization = 'Body Work & Paint' WHERE mechanic_id = 4;
UPDATE mechanics SET mechanic_name = 'Fernando Alonso', specialization = 'General Maintenance' WHERE mechanic_id = 5;
