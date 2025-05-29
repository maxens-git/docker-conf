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
	OR nom LIKE '%".$search."%'
        OR lien LIKE '%".$search."%'
        OR user-agent LIKE '%".$search."%'
        ORDER BY id DESC";
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
                                                        <th>Nom</th>
                                                        <th>Taille</th>
                                                        <th>User-agent</th>
                                                </tr>';
        while($row = mysqli_fetch_array($result))
        {
                $output .= '
                        <tr>
                                <td>'.$row["date"].'</td>
                                <td><a href="http://ip-api.com/json/' . $row["ip"] . '">' . $row["ip"] . '</a></td>
                                <td><a href='.$row["lien"].'>'.$row["nom"].'</a></td>
                                <td>'.$row["taille"].'</td>
                                <td style="white-space: nowrap;">'.$row["user-agent"].'</td>
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
