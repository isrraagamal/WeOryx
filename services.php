<?php require("header.php"); ?>
    <main id="our-services">
      <div class="row py-4">
        <div class="container">
          <h2 class="colored-text">Our Services</h2>
        </div>
      </div>
      <?php

require_once 'configuration.php';

$query = "SELECT * FROM service";
$stmt = $pdo->query($query);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

function truncateText($text, $length = 150) {
    $text = strip_tags($text);
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . '...'; 
    }
    return $text;
}
?>

<div class="container">
    <?php
    $totalServices = count($services);
    $numServices = 3; 
    $rows = ceil($totalServices / $numServices);

    for ($row = 0; $row < $rows; $row++):
    ?>
    <div class="row w-100 mb-4"> 
        <?php
        $startIndex = $row * $numServices;

        for ($col = 0; $col < $numServices; $col++):
            $index = $startIndex + $col;
            if ($index < $totalServices): 
        ?>
        <div class="col-md-4 mb-4"> 
        <a href="./services-details.php?service_id=<?php echo urlencode($services[$index]['service_id']); ?>">
                <div class="card text-center p-3">
                    <div class="circle-bg mx-auto">
                        <img src="<?php echo htmlspecialchars($services[$index]['service_icon']); ?>" alt="<?php echo htmlspecialchars($services[$index]['service_name']); ?>" class="circle-img" />
                    </div>
                    <h3><?php echo htmlspecialchars($services[$index]['service_name']); ?></h3>
                    <p class="text-muted">
                        <?php echo htmlspecialchars(truncateText($services[$index]['service_description'])); ?>
                    </p>
                </div>
            </a>
        </div>
        <?php 
            endif;
        endfor; ?>
    </div>
    <?php endfor; ?>
</div>

    </main>
    <?php require("footer.php"); ?>
