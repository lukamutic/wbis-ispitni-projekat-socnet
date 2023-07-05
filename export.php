<?php
// include "functions/functions.php";
// include "functions/db.php";

include "./components/header.inc.php";


// ima funkcija export_all_posts(), ali sam se odlučio da napišem ovde 
$query = "SELECT posts.id,user_id, created_time, likes, content, category_name  FROM posts INNER JOIN categories ON posts.category_id = categories.id ORDER BY created_time DESC";
$result = query($query);
$posts = $result->fetch_all(MYSQLI_ASSOC);
?>


<section class="all-posts-table pt-5">
    <div class="container">
        <table id="posts-table">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>User ID</th>
                    <th>Created Time</th>
                    <th>Likes</th>
                    <th>Content</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>

                        <td>
                            <?php echo $post['user_id']; ?>
                        </td>
                        <td>
                            <?php echo $post['created_time']; ?>
                        </td>
                        <td>
                            <?php echo $post['likes']; ?>
                        </td>
                        <td>
                            <?php echo $post['content']; ?>
                        </td>
                        <td>
                            <?php echo $post['category_name']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button id="download-button" class="mt-5 primary-button" style="max-width: 240px;">
            Preuzmi Tabelu
        </button>
    </div>

</section>




<script>
    // Funkcija za generisanje i preuzimanje tabele kao CSV fajl
    function downloadTable() {
        // Dobijanje reference na tabelu
        var table = document.getElementById("posts-table");

        // Kreiranje praznog CSV stringa
        var csv = "";

        // Iteracija kroz redove tabele
        for (var i = 0; i < table.rows.length; i++) {
            // Dobijanje reference na trenutni red
            var row = table.rows[i];

            // Iteracija kroz ćelije reda
            for (var j = 0; j < row.cells.length; j++) {
                // Dodavanje vrednosti ćelije u CSV string
                csv += row.cells[j].innerText;

                // Dodavanje zareza između ćelija (osim za poslednju ćeliju u redu)
                if (j !== row.cells.length - 1) {
                    csv += ",";
                }
            }

            // Dodavanje novog reda u CSV string
            csv += "\n";
        }

        // Kreiranje objekta Blob sa CSV podacima
        var blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });

        // Kreiranje URL-a za preuzimanje
        var url = URL.createObjectURL(blob);

        // Kreiranje linka za preuzimanje
        var link = document.createElement("a");
        link.href = url;
        link.download = "tabela.csv";
        link.click();
    }

    // Dodavanje funkcionalnosti na klik dugmeta
    var downloadButton = document.getElementById("download-button");
    downloadButton.addEventListener("click", function () {
        downloadTable();
    });
</script>