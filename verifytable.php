<?php include 'dbconnect.php';
echo "<h1>Last 10 ADIF records received</h1>";
    $sqladif="SELECT * FROM ft8adif ORDER BY adif_id DESC LIMIT 10";
    $resultadif=$conn->query($sqladif);
    echo ("<table>
    ");
    $head_row =true;
        while($row=$resultadif->fetch_assoc())
        {
            if($head_row)
            {
                $head_row=false;
                echo "<tr>";
                foreach($row as $key=>$field)
                {
                    echo "<th>". htmlspecialchars($key) ."</th>";
                }
                echo "</tr>
                ";
            }
            echo "<tr>";
            foreach($row as $key=>$field)
            {
            echo "<td>".htmlspecialchars($field)."</td>";
            }
            echo "</tr>
            ";
        }
    echo ("</table>
    ");
    echo "<h1>Last 10 records processed</h1>";
    $sqlft8log="SELECT * FROM ft8log ORDER BY qso_rec DESC LIMIT 10";
    $resultft8log=$conn->query($sqlft8log);
    echo ("<table>
    ");
    $head_row =true;
        while($row=$resultft8log->fetch_assoc())
        {
            if($head_row)
            {
                $head_row=false;
                echo "<tr>";
                foreach($row as $key=>$field)
                {
                    echo "<th>". htmlspecialchars($key) ."</th>";
                }
                echo "</tr>
                ";
            }
            echo "<tr>";
            foreach($row as $key=>$field)
            {
            echo "<td>".htmlspecialchars($field)."</td>";
            }
            echo "</tr>
            ";
        }
    echo ("</table>
    "); ?>
