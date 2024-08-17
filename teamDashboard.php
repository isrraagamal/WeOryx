<?php
require("configuration.php");

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags($input));
}

if (isset($_GET['id'])) {
    $employee_id = sanitizeInput($_GET['id']);
    try {
        $stmt = $pdo->prepare("SELECT employee_id, employee_title, employee_name, employee_image, employee_position FROM team WHERE employee_id = :employee_id");
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee && file_exists($employee['employee_image'])) {
            echo json_encode($employee);
        } else {
            $employee['employee_image'] = 'path/to/default/image.jpg';
            echo json_encode($employee);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = isset($_POST['employee_id']) ? sanitizeInput($_POST['employee_id']) : null;

    if (isset($_POST['delete']) && $employee_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM team WHERE employee_id = :employee_id");
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $employee_title = sanitizeInput($_POST['employee_title']);
        $employee_name = sanitizeInput($_POST['employee_name']);
        $employee_position = sanitizeInput($_POST['employee_position']);

        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($_FILES["employee_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (isset($_FILES["employee_image"]) && $_FILES["employee_image"]["error"] == UPLOAD_ERR_OK) {
            $check = getimagesize($_FILES["employee_image"]["tmp_name"]);
            if ($check === false) {
                $uploadOk = 0;
            }

            if ($_FILES["employee_image"]["size"] > 500000) {
                $uploadOk = 0;
            }

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $uploadOk = 0;
            }

            if ($uploadOk && move_uploaded_file($_FILES["employee_image"]["tmp_name"], $target_file)) {
                $file_uploaded = true;
            } else {
                $file_uploaded = false;
                $target_file = './assets/images/team.png';
            }
        } else {
            $target_file = './assets/images/team.png'; 
        }

        try {
            if (isset($_POST['edit'])) {
                $stmt = $pdo->prepare("UPDATE team SET employee_title = :employee_title, employee_name = :employee_name, employee_image = :employee_image, employee_position = :employee_position WHERE employee_id = :employee_id");
                $stmt->bindParam(':employee_id', $employee_id);
            } else {
                $stmt = $pdo->prepare("INSERT INTO team (employee_title, employee_name, employee_image, employee_position) VALUES (:employee_title, :employee_name, :employee_image, :employee_position)");
            }

            $stmt->bindParam(':employee_title', $employee_title);
            $stmt->bindParam(':employee_name', $employee_name);
            $stmt->bindParam(':employee_image', $target_file);
            $stmt->bindParam(':employee_position', $employee_position);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<?php require("header.php") ?>
<main>
    <div class="row">
        <div class="container justify-content-center py-5">
            <h2 id="formTitle">Add Team Member</h2>
            <form id="teamForm" action="teamDashboard.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="employee_id" name="employee_id">
                <div>
                    <label for="employee_title">Title:</label><br>
                    <input type="text" id="employee_title" name="employee_title" class="form-control" required>
                    <p id="employee_title_error" class="error"></p>
                </div>
                <div>
                    <label for="employee_name">Name:</label><br>
                    <input type="text" id="employee_name" name="employee_name" class="form-control" required>
                    <p id="employee_name_error" class="error"></p>
                </div>
                <div>
                    <label for="employee_image">Upload Image:</label>
                    <input type="file" id="employee_image" name="employee_image" class="form-control-file" required>
                    <p id="employee_image_error" class="error"></p>
                </div>
                <div>
                    <label for="employee_position">Position:</label><br>
                    <input type="text" id="employee_position" name="employee_position" class="form-control" required>
                    <p id="employee_position_error" class="error"></p>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Add Team Member</button>
            </form>
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
                    $stmt = $pdo->query("SELECT employee_id, employee_title, employee_name, employee_image, employee_position FROM team");
                    
                    $count = 0;
                    $totalRows = $stmt->rowCount(); 
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="col-md-3 col-sm-6 text-center">';
                        echo '<img src="' . htmlspecialchars($row['employee_image']) . '" alt="" class="img-fluid" />';
                        echo '<div class="py-2">';
                        echo '<h3 class="font-weight-bold">' . htmlspecialchars($row['employee_title']) . '. ' . htmlspecialchars($row['employee_name']) . '</h3>';
                        echo '<h5 class="colored-text">' . htmlspecialchars($row['employee_position']) . '</h5>';
                        echo '<a href="teamDashboard.php?edit=' . htmlspecialchars($row['employee_id']) . '" class="teamBtn btn btn-warning btn-sm px-3">Edit</a>';
                        echo '<form method="POST" action="teamDashboard.php" style="display:inline;">';
                        echo '<input type="hidden" name="employee_id" value="' . htmlspecialchars($row['employee_id']) . '">';
                        echo '<button type="submit" name="delete" class="teamBtn btn btn-sm btn-danger mx-2">Delete</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';

                        $count++;

                        if ($count % 4 == 0 && $count <= $totalRows - 1 ) {
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const editId = urlParams.get('edit');
        
        if (editId) {
            document.getElementById('formTitle').innerText = 'Edit Team Member';
            document.getElementById('teamForm').setAttribute('action', 'teamDashboard.php');
            document.querySelector('button[type="submit"]').innerText = 'Update Team Member';

            fetch(`teamDashboard.php?id=${editId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('employee_id').value = data.employee_id;
                    document.getElementById('employee_title').value = data.employee_title;
                    document.getElementById('employee_name').value = data.employee_name;
                    document.getElementById('employee_position').value = data.employee_position;
                    document.getElementById('employee_image').removeAttribute('required');
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    });

    document.getElementById('teamForm').addEventListener('submit', function(event) {
        let valid = true;

        document.getElementById('employee_title_error').innerText = '';
        document.getElementById('employee_name_error').innerText = '';
        document.getElementById('employee_image_error').innerText = '';
        document.getElementById('employee_position_error').innerText = '';

        if (document.getElementById('employee_title').value.trim() === '') {
            document.getElementById('employee_title_error').innerText = 'Title is required.';
            valid = false;
        }

        if (document.getElementById('employee_name').value.trim() === '') {
            document.getElementById('employee_name_error').innerText = 'Name is required.';
            valid = false;
        }

        if (!document.getElementById('employee_image').files.length) {
            document.getElementById('employee_image_error').innerText = 'Image is required.';
            valid = false;
        }

        if (document.getElementById('employee_position').value.trim() === '') {
            document.getElementById('employee_position_error').innerText = 'Position is required.';
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>

<?php require("footer.php") ?>
