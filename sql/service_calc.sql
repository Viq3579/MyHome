

-- CELLULAR SERVICE CALCULATOR
SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
FROM provider AS p, (
    SELECT name, type, provider, description, terms, penalty, MIN(cost) AS cost
    FROM service
    GROUP BY type, provider, terms
) AS s, (
    (SELECT name AS c_name, email AS c_email, family_size
     FROM customer)
    EXCEPT
    ((SELECT c.name AS c_name, c.email AS c_email, family_size
      FROM hasservice AS h, customer AS c, service AS s
      WHERE h.owner_email = c.email
      AND h.service_name = s.name
      AND h.provider_email = s.provider
      AND s.type = 'Cellular')
     UNION
     (SELECT c.name AS c_name, c.email AS c_email, family_size
      FROM customservice AS h, customer AS c
      WHERE h.cemail = c.email
      AND h.type = 'Cellular'))
) AS c
WHERE s.provider = p.email
AND s.type = 'Cellular'
AND SUBSTRING_INDEX(s.terms, ' ', 1) = c.family_size;


(SELECT c.name AS c_name, c.email AS c_email, h.address AS address
 FROM customer as c, home as h
 WHERE h.owner_email = c.email)
EXCEPT
((SELECT c.name AS c_name, c.email AS c_email, h.address AS address
  FROM hasservice AS x, customer AS c, home as h, service AS s
  WHERE x.owner_email = c.email
  AND x.service_name = s.name
  AND x.provider_email = s.provider
  AND h.owner_email = c.email
  AND s.type = 'Car Insurance')
 UNION
 (SELECT c.name AS c_name, c.email AS c_email, h.address AS address
  FROM customservice AS x, customer AS c, home as h
  WHERE x.cemail = c.email
  AND h.owner_email = c.email
  AND x.type = 'Car Insurance'));

SELECT c.name AS c_name, c.email AS c_email, h.address AS address
FROM hasservice AS x, customer AS c, home as h, service AS s
WHERE x.owner_email = c.email
AND x.service_name = s.name
AND x.provider_email = s.provider
AND h.owner_email = c.email;



-- CAR INSURANCE SERVICE CALCULATOR
SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
FROM provider AS p, (
    SELECT name, type, provider, description, terms, penalty, MIN(cost) AS cost
    FROM service
    GROUP BY type, provider, terms
) AS s, (
    (SELECT name AS c_name, email AS c_email, num_cars
     FROM customer)
    EXCEPT
    ((SELECT c.name AS c_name, c.email AS c_email, num_cars
      FROM hasservice AS h, customer AS c, service AS s
      WHERE h.owner_email = c.email
      AND h.service_name = s.name
      AND h.provider_email = s.provider
      AND s.type = 'Car Insurance')
     UNION
     (SELECT c.name AS c_name, c.email AS c_email, num_cars
      FROM customservice AS h, customer AS c
      WHERE h.cemail = c.email
      AND h.type = 'Car Insurance'))
) AS c
WHERE s.provider = p.email
AND s.type = 'Car Insurance'
AND (SUBSTRING_INDEX(s.terms, ' ', 1) = c.num_cars
     OR SUBSTRING_INDEX(s.terms, ' ', 1) = c.num_cars + 1);