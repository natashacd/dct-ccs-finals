<?php
$pagetitle = 'Delete Student';
include '../partials/header.php';

include '../../functions.php'; 

$successMessage = '';
$errorMessage = '';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $student = getStudentById($student_id); 

    if ($student) {

        $student_name = $student['first_name'] . ' ' . $student['last_name'];
    } else {
        $errorMessage = "Student not found.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = deleteStudent($student_id);

        if ($result) {
            $successMessage = "Student deleted successfully!";
            header("Location: register.php"); 
            exit;
        } else {
            $errorMessage = "Failed to delete student.";
        }
    }

} else {
    $errorMessage = "No student ID provided.";
}

include '../partials/side-bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <div class="content col-md-10">
        <h2 class="mb-5">Delete a Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
            </ol>
        </nav>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= $successMessage ?></div>
        <?php endif; ?>

        <div class="card p-5">
            <div class="card-body">
                <p style="font-size: 20px;">Are you sure you want to delete the following student record?</p>
                <ul>
                    <li><strong>Student ID:</strong> <?= htmlspecialchars($student_id) ?></li>
                    <li><strong>Full Name:</strong> <?= htmlspecialchars($student_name) ?></li>
                </ul>
                <form action="delete.php?id=<?= $student_id ?>" method="POST">
                    <a href="register.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Delete Student Record</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include '../partials/footer.php';
?>
