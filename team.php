<?php require("header.php"); ?>
<?php require("configuration.php"); ?>

<main id="team">
    <div class="row banner">
        <div class="container pt-5 pb-4 text-center justify-content-center">
            <img src="./assets/images/teambanner.png" alt="" class="teamBanner" />
            <h1 class="colored-text text-center">Our Team</h1>
        </div>
    </div>

    <div class="row pb-4">
        <div class="container px-5">
            <h2 class="colored-text">Our Team</h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="container d-flex flex-wrap justify-content-around">
            <?php
                try {
                    $stmt = $pdo->query("SELECT employee_title, employee_name, employee_image, employee_position FROM team");
                    
                    $count = 0;
                    $totalRows = $stmt->rowCount(); 
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="col-md-3 col-sm-6 text-center">';
                        echo '<img src="' . $row['employee_image'] . '" alt="" class="img-fluid" />';
                        echo '<div class="py-2">';
                        echo '<h3 class="font-weight-bold">' . $row['employee_title'] . '. ' . $row['employee_name'] . '</h3>';
                        echo '<h5 class="colored-text">' . $row['employee_position'] . '</h5>';
                        echo '<button class="teamBtn">Book Now</button>';
                        echo '</div>';
                        echo '</div>';

                        $count++;

                        if ($count % 4 == 0 && $count < $totalRows - 1) {
                            echo '<div class="container my-4"><hr class="black-hr"></div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            ?>
        </div>
    </div>
</main>

<?php require("footer.php"); ?>
