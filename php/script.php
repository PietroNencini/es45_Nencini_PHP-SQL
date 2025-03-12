<?php
    include "connessione.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATTORI</title>
</head>
<body>
    
    <ul>
        <?php
            $user_choice = $_GET["number"];



            $num_db_actors;

            $sql_query_actor = "SELECT * FROM attori ORDER BY nome ASC";
            $sql_query_nfilm = "SELECT count(*) FROM attori att INNER JOIN recita rec ON att.codAttore = rec.codAttore INNER JOIN film ON rec.codFilm = film.codFilm ";
            $sql_query_films = "SELECT F.* FROM attori att INNER JOIN recita rec ON att.codAttore = rec.codAttore INNER JOIN film ON rec.codFilm = film.codFilm ";

            if(!$res_actor = $conn->query($sql_query_actor)) {
                echo "<p> Errore nella query </p>";
                exit();
            }

            if($res_actor->num_rows == 0) {
                echo "<p> Nessun dato di attore trovato nel database </p>";
            } else {
                if($res_actor->num_rows < $user_choice)
                    $limit = $res_actor->num_rows;
                else
                    $limit = $user_choice;

                for($i = 0; $i < $limit; $i++) {
                    echo "<li> <p>";
                    $row_actor = $res_actor->fetch_assoc();
                    //! DA FINIRE
                    echo $row_actor["nome"] . " " . $row_actor["cognome"] . " (" . $row_actor["codAttore"] . ")";
                    echo "</p> </li>";
                }
            }

            

        ?>
    </ul>
</body>
</html>


