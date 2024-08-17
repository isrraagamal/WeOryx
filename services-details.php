<?php
require_once 'configuration.php';

try {
    $pdo->query("SELECT 1");
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
    exit;
}

$service_name = 'Service Not Found';
$service_banner = './assets/images/service-not-found.png';
$service_description = 'Sorry, we could not find the service you are looking for.';


$name = '';
$mobile = '';
$details = '';

$errors = [
    'name' => '',
    'mobile' => '',
    'details' => '',
];


if (isset($_GET['service_id'])) {
    $service_id = intval($_GET['service_id']); 
} else {
    echo json_encode(['error' => 'Service ID is missing.']);
    exit;
}

if ($service_id > 0) {
    try {
        $query = "SELECT * FROM service WHERE service_id = :service_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        $stmt->execute();

        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($service) {
            $service_name = htmlspecialchars($service['service_name']);
            $service_banner = htmlspecialchars($service['service_banner']);
            $service_description = htmlspecialchars($service['service_description']);
        } else {
            $service_description = 'The service you are looking for does not exist.';
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $mobile = isset($_POST['mobile']) ? htmlspecialchars(trim($_POST['mobile'])) : '';
    $details = isset($_POST['details']) ? htmlspecialchars(trim($_POST['details'])) : '';

    $has_error = false;
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
        $has_error = true;
    } elseif (!preg_match('/^[a-zA-Z\s]{3,}$/', $name)){
      $errors['name'] = 'Name must be at least 3 letters';
      $has_error = true;
  }
    if (empty($mobile)) {
        $errors['mobile'] = 'Mobile is required.';
        $has_error = true;
    } elseif (!preg_match('/^[0-9]{11}$/', $mobile)) {
        $errors['mobile'] = 'Mobile Must be 11 numbers';
        $has_error = true;
    }
    if (empty($details)) {
        $errors['details'] = 'Details are required.';
        $has_error = true;
    }elseif (!preg_match('/^[a-zA-Z\s]{5,}$/', $details)) {
      $errors['details'] = 'Details must be at least 5 letters';
      $has_error = true;
  }

    if (!$has_error) {
        try {
            $query = "INSERT INTO bookService (service_id, name, mobile, details) VALUES (:service_id, :name, :mobile, :details)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $stmt->bindParam(':details', $details, PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode(['success' => 'Service booked successfully!']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        exit;
    } else {
        echo json_encode(['errors' => $errors]);
        exit;
    }
}

?>

<?php require("header.php"); ?>

<main id="service-details">
    <div class="row">
        <div class="container">
            <h2 class="py-4 colored-text"><?php echo $service_name; ?></h2>
            <img src="<?php echo $service_banner; ?>" alt="<?php echo $service_name; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="container">
            <p class="paragraph-muted pt-4">
                <?php echo $service_description; ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="container pt-3">
            <form id="booking-form" method="post" class="col-12 justify-content-center pt-5 pb-4">
                <h4 class="pb-3">Book <?php echo htmlspecialchars($service_name); ?></h4>
                <div class="d-flex w-100 justify-content-between">
                    <div>
                        <label for="name" class="d-block">Name</label>
                        <input type="text" name="name" id="name" class="form-control" />
                        <div id="error-name" class="text-danger pt-2"></div>
                    </div>
                    <div class="mx-5">
                        <label for="mobile" class="d-block">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" />
                        <div id="error-mobile" class="text-danger pt-2"></div>
                    </div>
                </div>
                <div class="pt-3">
                    <label for="details" class="d-block">Details</label>
                    <textarea id="details" name="details" class="form-control w-100"></textarea>
                    <div id="error-details" class="text-danger pt-2"></div>
                </div>
                <div class="justify-content-center text-center pt-4">
                    <button class="px-3 py-2" type="submit">Book Now</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('booking-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        xhr.open('POST', window.location.href, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);

                document.getElementById('error-name').textContent = '';
                document.getElementById('error-mobile').textContent = '';
                document.getElementById('error-details').textContent = '';

                if (response.success) {
                    alert(response.success);

                    form.reset();
                } else if (response.errors) {
                    if (response.errors.name) {
                        document.getElementById('error-name').textContent = response.errors.name;
                    }
                    if (response.errors.mobile) {
                        document.getElementById('error-mobile').textContent = response.errors.mobile;
                    }
                    if (response.errors.details) {
                        document.getElementById('error-details').textContent = response.errors.details;
                    }
                } else if (response.error) {
                    alert(response.error);
                }
            }
        };

        xhr.send(formData);
    });
});
</script>

<?php require("footer.php"); ?>
