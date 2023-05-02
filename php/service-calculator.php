<!-- 
    To use the service calculator use these lines of code

        $sql = require __DIR__ . "/../php/service-calculator.php";
        $sql = $sql . sprintf("AND c_email = '%s'", $mysqli->real_escape_string($_SESSION["email"]));
        $client_result = $mysqli->query($sql);
    
    This will give you a table of services for the customer's email
    The format of this is outlined below:

        p_name      | p_email       | s_name        | s_description     | s_terms       | s_cost        | c_email       | c_name

    p_name: Provider's Name
    p_email: Provider's Email
    s_name: Name of the Service
    s_description: Description of the Service
    s_terms: Terms for the Service
    s_cost: Cost of the Service
    c_email: Customer's Email
    c_name: Customer's Name
 -->
<?php

$sql = "SELECT p_name, p_email, s_name, s_type, s_description, s_terms, s_cost, c_email, c_name
    FROM (
        (SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
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
        AND SUBSTRING_INDEX(s.terms, ' ', 1) > c.family_size
        AND SUBSTRING_INDEX(s.terms, ' ', 1) < (c.family_size + 5))

        UNION

        (SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
        FROM provider AS p, (
            SELECT name, type, provider, description, terms, penalty, MIN(cost) AS cost
            FROM service
            GROUP BY type, provider, terms
        ) AS s, (
            (SELECT c.name AS c_name, c.email AS c_email, c.family_size AS family_size, h.address AS address, h.num_floors AS num_floors
            FROM customer as c, home as h
            WHERE h.owner_email = c.email)
            EXCEPT
            ((SELECT c.name AS c_name, c.email AS c_email, c.family_size AS family_size, h.address AS address, h.num_floors AS num_floors
            FROM hasservice AS x, customer AS c, home as h, service AS s
            WHERE x.owner_email = c.email
            AND x.service_name = s.name
            AND x.provider_email = s.provider
            AND h.owner_email = c.email
            AND s.type = 'Internet')
            UNION
            (SELECT c.name AS c_name, c.email AS c_email, c.family_size AS family_size, h.address AS address, h.num_floors AS num_floors
            FROM customservice AS x, customer AS c, home as h
            WHERE x.cemail = c.email
            AND h.owner_email = c.email
            AND x.type = 'Internet'))
        ) AS c
        WHERE s.provider = p.email
        AND s.type = 'Internet'
        AND SUBSTRING_INDEX(s.terms, ' ', 1) < (((family_size * 2) + num_floors) * 100))

        UNION

        (SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
        FROM provider AS p, (
            SELECT name, type, provider, description, terms, penalty, MIN(cost) AS cost
            FROM service
            GROUP BY type, provider, terms
        ) AS s, (
            (SELECT c.name AS c_name, c.email AS c_email, h.address AS address, (h.lot_size - h.floor_space) AS lawn_size
            FROM customer as c, home as h
            WHERE h.owner_email = c.email)
            EXCEPT
            ((SELECT c.name AS c_name, c.email AS c_email, h.address AS address, (h.lot_size - h.floor_space) AS lawn_size
            FROM hasservice AS x, customer AS c, home as h, service AS s
            WHERE x.owner_email = c.email
            AND x.service_name = s.name
            AND x.provider_email = s.provider
            AND h.owner_email = c.email
            AND s.type = 'Lawncare')
            UNION
            (SELECT c.name AS c_name, c.email AS c_email, h.address AS address, (h.lot_size - h.floor_space) AS lawn_size
            FROM customservice AS x, customer AS c, home as h
            WHERE x.cemail = c.email
            AND h.owner_email = c.email
            AND x.type = 'Lawncare'))
        ) AS c
        WHERE s.provider = p.email
        AND s.type = 'Lawncare'
        AND SUBSTRING_INDEX(s.terms, ' ', 1) > c.lawn_size)

        UNION

        (SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
        FROM provider AS p, (
            SELECT name, type, provider, description, terms, penalty, MIN(cost) AS cost
            FROM service
            GROUP BY type, provider, terms
        ) AS s, (
            (SELECT c.name AS c_name, c.email AS c_email, c.family_income AS income, h.address AS address
            FROM customer as c, home as h
            WHERE h.owner_email = c.email)
            EXCEPT
            ((SELECT c.name AS c_name, c.email AS c_email, c.family_income AS income, h.address AS address
            FROM hasservice AS x, customer AS c, home as h, service AS s
            WHERE x.owner_email = c.email
            AND x.service_name = s.name
            AND x.provider_email = s.provider
            AND h.owner_email = c.email
            AND s.type = 'Mortgage')
            UNION
            (SELECT c.name AS c_name, c.email AS c_email, c.family_income AS income, h.address AS address
            FROM customservice AS x, customer AS c, home as h
            WHERE x.cemail = c.email
            AND h.owner_email = c.email
            AND x.type = 'Mortgage'))
        ) AS c
        WHERE s.provider = p.email
        AND s.type = 'Mortgage'
        AND SUBSTRING_INDEX(s.terms, ' ', 1) < ((c.income + 30000) / 60000))

        UNION

        (SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
        FROM provider AS p, (
            SELECT name, type, provider, description, terms, penalty, MIN(cost) AS cost
            FROM service
            GROUP BY type, provider, terms
        ) AS s, (
            (SELECT c.name AS c_name, c.email AS c_email, h.address AS address, h.lot_size AS family_size,
                CASE
                    WHEN (h.lot_size > 2000 AND h.lot_size <= 4000) THEN 'Basic'
                    WHEN (h.lot_size > 4000 AND h.lot_size <= 6000) THEN 'Standard'
                    WHEN (h.lot_size > 6000 AND h.lot_size <= 10000) THEN 'Premium'
                    WHEN h.lot_size > 10000 THEN 'Platinum'
                    ELSE 'Economy'
                END as tier
            FROM customer as c, home as h
            WHERE h.owner_email = c.email)
            EXCEPT
            ((SELECT c.name AS c_name, c.email AS c_email, h.address AS address, h.lot_size AS family_size,
                CASE
                    WHEN (h.lot_size > 2000 AND h.lot_size <= 4000) THEN 'Basic'
                    WHEN (h.lot_size > 4000 AND h.lot_size <= 6000) THEN 'Standard'
                    WHEN (h.lot_size > 6000 AND h.lot_size <= 10000) THEN 'Premium'
                    WHEN h.lot_size > 10000 THEN 'Platinum'
                    ELSE 'Economy'
                END as tier
            FROM hasservice AS x, customer AS c, home as h, service AS s
            WHERE x.owner_email = c.email
            AND x.service_name = s.name
            AND x.provider_email = s.provider
            AND h.owner_email = c.email
            AND s.type = 'Home Insurance')
            UNION
            (SELECT c.name AS c_name, c.email AS c_email, h.address AS address, h.lot_size AS family_size,
                CASE
                    WHEN (h.lot_size > 2000 AND h.lot_size <= 4000) THEN 'Basic'
                    WHEN (h.lot_size > 4000 AND h.lot_size <= 6000) THEN 'Standard'
                    WHEN (h.lot_size > 6000 AND h.lot_size <= 10000) THEN 'Premium'
                    WHEN h.lot_size > 10000 THEN 'Platinum'
                    ELSE 'Economy'
                END as tier
            FROM customservice AS x, customer AS c, home as h
            WHERE x.cemail = c.email
            AND h.owner_email = c.email
            AND x.type = 'Home Insurance'))
        ) AS c
        WHERE s.provider = p.email
        AND s.type = 'Home Insurance'
        AND SUBSTRING_INDEX(s.terms, ' ', 1) = c.tier)

        UNION

        (SELECT p.name as p_name, s.provider as p_email, s.name as s_name, s.type as s_type, s.description as s_description, s.terms as s_terms, s.cost as s_cost, c.c_email as c_email, c.c_name as c_name
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
            OR SUBSTRING_INDEX(s.terms, ' ', 1) = c.num_cars + 1))
    ) as service_calculator
    WHERE 1 ";

return $sql;



// OLD SERVICE CALCULATOR
//
// $sql = "SELECT p.name as p_name, s.provider as p_email, s.name as s_name, d.type as s_type, d.description as s_description, d.terms as s_terms, d.cost as s_cost, c.email as c_email, o.name as c_name
//         FROM provider as p, service as d, customer as o, (
//             SELECT s.name, s.provider, s.type
//             FROM service as s,(	
//                 SELECT provider, type, MIN(cost) as cost
//                 FROM service
//                 GROUP BY provider, type
//             ) as m
//             WHERE s.provider = m.provider
//             AND s.type = m.type
//             AND s.cost = m.cost
//         ) as s, (
//             (	
//                 (	
//                     SELECT o.email, s.type
//                     FROM customer as o, service as s
//                 )
//                 UNION
//                 (	
//                     SELECT o.email, s.type
//                     FROM customer as o, customservice as s
//                 )
//             )
//             EXCEPT
//             (	
//                 (	
//                     SELECT o.email, s.type
//                     FROM customer as o, hasservice as h, service as s
//                     WHERE s.name = h.service_name
//                     AND o.email = h.owner_email
//                 )
//                 UNION
//                 (	
//                     SELECT customer_email as email, type
//                     FROM outsideservice
//                 )
//                 UNION
//                 (	
//                     SELECT cemail as email, type
//                     FROM customservice
//                 )
//             )
//         ) as c
//         WHERE c.type = s.type
//         AND s.provider = d.provider
//         AND p.email = s.provider
//         AND s.name = d.name
//         AND c.email = o.email ";