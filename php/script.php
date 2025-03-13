<?php
    include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATTORI</title>
    <!--* BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    
    <ul>
        <?php
            $user_choice = $_GET["number"];



            $num_db_actors;

            $sql_query_actor = "SELECT * FROM attori ORDER BY nome ASC";
            
            

            if(!$res_actor = $conn->query($sql_query_actor)) {
                echo "<p> Errore nella query 1 </p>";
                exit();
            }

            if($res_actor->num_rows == 0) {
                echo "<p> Nessun dato di attore trovato nel database </p>";
            } else {
                if($res_actor->num_rows < $user_choice) {
                    $limit = $res_actor->num_rows;
                    echo "<p> Il DB non contiene così tanti attori, verranno mostrati solo $limit attori </p>";
                } else {
                    $limit = $user_choice;
                }
                


                for($i = 0; $i < $limit; $i++) {
                    
                    $row_actor = $res_actor->fetch_assoc();
                    $sql_query_nfilm = "SELECT count(*) AS numFilm FROM attori att INNER JOIN recita rec ON att.codAttore = rec.codAttore INNER JOIN film ON rec.codFilm = film.codFilm WHERE att.codAttore = ".$row_actor["CodAttore"];
                    $sql_query_films = "SELECT F.* FROM attori att INNER JOIN recita rec ON att.codAttore = rec.codAttore INNER JOIN film F ON rec.codFilm = F.codFilm WHERE att.codAttore = ".$row_actor["CodAttore"];
                    //! DA FINIRE

                    if(!$res_nfilm = $conn->query($sql_query_nfilm)) {
                        echo "<p> Errore nella query 2 </p>";
                        exit();
                    }
                    $row_nfilm = $res_nfilm->fetch_assoc();                     // Il count(*) ritorna un solo valore
                    
                    if(!$res_film = $conn->query($sql_query_films)) {
                        echo "<p> Errore nella query 3 </p>";
                        exit();
                    }
                    

                    echo "<li><p> Attore: <b>" .$row_actor["Nome"] . "</b><br> Codice attore: <b>" . $row_actor["CodAttore"] . "</b> </p>";
                    echo "<p> Numero di film in cui ha recitato: <b>" .$row_nfilm["numFilm"]. "</b></p>";
                    echo "<ul>";
                    while($row_films = $res_film->fetch_assoc()) {
                        echo "<li> codice <b>".$row_films["CodFilm"]."</b>, titolo:<b>".$row_films["Titolo"]."</b> (".$row_films["AnnoProduzione"].") </li>";
                    }
                    echo "</ul> </li>";
                }
            }

            

        ?>
    </ul>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>


