<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}





$connect = mysqli_connect("mysql", "root", "REDACTED_PASSWORD", "debrid");
$output = '';
if(isset($_POST["query"]))
{
        $search = mysqli_real_escape_string($connect, $_POST["query"]);
        $query = "
        SELECT * FROM liens
        WHERE date LIKE '%".$search."%'
        OR ip LIKE '%".$search."%'
        OR lien LIKE '%".$search."%'
        ";
}
else
{
        $query = "
        SELECT * FROM liens ORDER BY id DESC";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
        $output .= '<div class="table-responsive">
                                        <table class="table table bordered">
                                                <tr>
                                                        <th>Date</th>
                                                        <th>IP</th>
                                                        <th>Lien</th>
                                                </tr>';
        while($row = mysqli_fetch_array($result))
        {
                $output .= '
                        <tr>
                                <td>'.$row["date"].'</td>
                                <td><a href="http://ip-api.com/json/' . $row["ip"] . '">' . $row["ip"] . '</a></td>
                                <td><a href='.$row["lien"].'>'.$row["lien"].'</a></td>
                        </tr>
                ';
        }
        echo $output;
}
else
{
        echo 'Data Not Found';
}
?>
