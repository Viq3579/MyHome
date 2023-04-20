<!-- 
    To use the service calculator use these lines of code

        $sql = require __DIR__ . "/../php/service-calculator.php";
        $sql = $sql . sprintf("AND c.email = '%s'", $mysqli->real_escape_string($_SESSION["email"]));
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
$sql = "SELECT p.name as p_name, s.provider as p_email, s.name as s_name, d.type as s_type, d.description as s_description, d.terms as s_terms, d.cost as s_cost, c.email as c_email, o.name as c_name
        FROM provider as p, service as d, customer as o, (
            SELECT s.name, s.provider, s.type
            FROM service as s,(	
                SELECT provider, type, MIN(cost) as cost
                FROM service
                GROUP BY provider, type
            ) as m
            WHERE s.provider = m.provider
            AND s.type = m.type
            AND s.cost = m.cost
        ) as s, (
            (	
                (	
                    SELECT o.email, s.type
                    FROM customer as o, service as s
                )
                UNION
                (	
                    SELECT o.email, s.type
                    FROM customer as o, customservice as s
                )
            )
            EXCEPT
            (	
                (	
                    SELECT o.email, s.type
                    FROM customer as o, hasservice as h, service as s
                    WHERE s.name = h.service_name
                    AND o.email = h.owner_email
                )
                UNION
                (	
                    SELECT customer_email as email, type
                    FROM outsideservice
                )
                UNION
                (	
                    SELECT cemail as email, type
                    FROM customservice
                )
            )
        ) as c
        WHERE c.type = s.type
        AND s.provider = d.provider
        AND p.email = s.provider
        AND s.name = d.name
        AND c.email = o.email ";

return $sql;