INSERT INTO Person (name, password) VALUES ('Anna', 'sohvi');
INSERT INTO Person (name, password) VALUES ('Mikael', 'miksu');

INSERT INTO Category (user_id, name, description) VALUES ((SELECT id FROM Person WHERE name='Anna'), 'Koulu', 'Kouluun liittyviä tehtäviä');
INSERT INTO Category (user_id, name, description) VALUES ((SELECT id FROM Person WHERE name='Anna'), 'Koti', 'Kotiin liittyviä tehtäviä');
INSERT INTO Category (user_id, name, description) VALUES ((SELECT id FROM Person WHERE name='Anna'), 'Kaverit', 'Kavereihin liittyviä tehtäviä');

INSERT INTO Task (user_id, priority, deadline, completed, name, description) VALUES ((SELECT id FROM Person WHERE name='Anna'), 1, NOW(), false, 'Juhlat', 'Järjetä juhlia, missä oletkin.');
INSERT INTO Task (user_id, priority, deadline, completed, name, description) VALUES ((SELECT id FROM Person WHERE name='Anna'), 0, NOW(), false, 'Luento peruttu', 'Luento on peruttu');
INSERT INTO Task (user_id, priority, deadline, completed, name, description) VALUES ((SELECT id FROM Person WHERE name='Anna'), 2, NOW(), true, 'Laskin', 'Osta uusi laskin');

INSERT INTO TaskCategory (task_id, category_id) VALUES ((SELECT id FROM Task WHERE name='Juhlat'), (SELECT id FROM Category WHERE name='Koulu'));
INSERT INTO TaskCategory (task_id, category_id) VALUES ((SELECT id FROM Task WHERE name='Juhlat'), (SELECT id FROM Category WHERE name='Koti'));
INSERT INTO TaskCategory (task_id, category_id) VALUES ((SELECT id FROM Task WHERE name='Juhlat'), (SELECT id FROM Category WHERE name='Kaverit'));
INSERT INTO TaskCategory (task_id, category_id) VALUES ((SELECT id FROM Task WHERE name='Luento peruttu'), (SELECT id FROM Category WHERE name='Koulu'));
