<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ToolController extends Controller
{
    public function phpinfo()
    {
        return phpinfo();
    }

//    public function rawSQL()
//    {
//        // Your raw SQL query
//        $sql = "
//            SELECT
//                temp.bnb_id,
//                b.name AS bnb_name,
//                temp.may_amount
//            FROM
//                (
//                    SELECT
//                        o.bnb_id,
//                        SUM(o.amount) AS may_amount
//                    FROM
//                        orders o
//                    WHERE
//                        o.currency = 'TWD'
//                        AND o.created_at >= '2023-05-01'
//                        AND o.created_at < '2023-06-01'
//                    GROUP BY
//                        o.bnb_id
//                    ORDER BY
//                        may_amount DESC
//                    LIMIT 10
//                ) AS temp
//            JOIN
//                bnbs b ON temp.bnb_id = b.id;
//        ";
//
//        // Execute the query
//        $results = DB::select($sql);
//
//        // Process the results as needed
//        echo "<table border='1'>";
//        echo "<tr><th>Bnb ID</th><th>Bnb Name</th><th>May Amount</th></tr>";
//        foreach ($results as $row) {
//            echo "<tr>";
//            echo "<td>{$row->bnb_id}</td>";
//            echo "<td>{$row->bnb_name}</td>";
//            echo "<td>{$row->may_amount}</td>";
//            echo "</tr>";
//        }
//        echo "</table>";
//    }
}
