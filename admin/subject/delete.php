<?php
$pagetitle = 'Delete Subject';
include '../partials/header.php';

include '../../functions.php'; 
guard();

$errors = [];
$successMessage = '';


if (isset($_GET['id'])) {
    $subject_code = $_GET['id']; 


    $subject = null;
    foreach ($_SESSION['subjects'] as $sub) {
        if ($sub['subject_code'] == $subject_code) {
            $subject = $sub;
            break;
        }
    }


    if ($subject) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
            $result = deleteSubject($subject_code);

            if ($result['success']) {
                $successMessage = "Subject deleted successfully!";
                header("Location: add.php");
                exit;
            } else {
                $errors = $result['errors'];
            }
        }
        include '../partials/side-bar.php';
        ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
            <div class="content col-md-10">
                <h2 class="mb-5">Delete Subject</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
                    </ol>
                </nav>
                <div class="card p-5">
                    <div class="card-body">
                        <p style="font-size: 20px;">Are you sure you want to delete the following subject record?</p>
                        <ul>
                            <li><strong>Subject Code:</strong> <?= htmlspecialchars($subject['subject_code']) ?></li>
                            <li><strong>Subject Name:</strong> <?= htmlspecialchars($subject['subject_name']) ?></li>
                        </ul>
                        <form method="POST" action="">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='add.php'">Cancel</button>
                            <button type="submit" class="btn btn-primary">Delete Subject Record</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php
    } else {
        echo "Subject not found.";
    }
} else {
    echo "No subject selected for deletion.";
}

include '../partials/footer.php';
?>
