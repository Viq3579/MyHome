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