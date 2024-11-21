<?php
$pagetitle = 'Dettach Subject';
include '../partials/header.php';
include '../../functions.php';
guard();

if (isset($_GET['id']) && isset($_GET['subject_code'])) {
    $student_id = $_GET['id']; 
    $subject_code = $_GET['subject_code']; 

    $student = getStudentById($student_id); 
    $subject = getSubjectByCode($subject_code);

    if (!$student || !$subject) {
        echo "<div class='alert alert-danger'>Invalid student or subject!</div>";
        exit;
    }


    $student_name = $student['first_name'] . ' ' . $student['last_name'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = detachSubjectFromStudent($student_id, $subject_code);

        if ($result) {
            $successMessage = "Subject detached successfully!";
            header("Location: attach-subject.php?id=" . urlencode($student_id) . "&success=1"); 
            exit;
        } else {
            $errorMessage = "Failed to detach subject.";
        }
    }
} else {
    echo "<div class='alert alert-danger'>Student ID or Subject Code is missing!</div>";
    exit;
}

include '../partials/side-bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <div class="content col-md-10">
        <h2 class="mb-5">Detach Subject from Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                <li class="breadcrumb-item"><a href="attach-subject.php?id=<?php echo urlencode($student_id); ?>">Attach Subject to Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detach Subject from Student</li>
            </ol>
        </nav>

        <div class="card p-5">
            <div class="card-body">
                <p style="font-size: 20px;">Are you sure you want to detach this subject from this student record?</p>
                <ul>
                    <li><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></li>
                    <li><strong>First Name:</strong> <?php echo htmlspecialchars($student['first_name']); ?></li>
                    <li><strong>Last Name:</strong> <?php echo htmlspecialchars($student['last_name']); ?></li>
                    <li><strong>Subject Code:</strong> <?php echo htmlspecialchars($subject['subject_code']); ?></li>
                    <li><strong>Subject Name:</strong> <?php echo htmlspecialchars($subject['subject_name']); ?></li>
                </ul>
                <form method="POST">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete Subject from Student</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include '../partials/footer.php';
?>