<?php
$pagetitle = 'Assign Grade';
include '../partials/header.php';
include '../../functions.php';
guard();

if (isset($_GET['id']) && isset($_GET['subject_code'])) {
    $student_id = $_GET['id'];
    $subject_code = $_GET['subject_code'];

    $student = getStudentById($student_id);
    $subject = getSubjectByCode($subject_code); 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $grade = isset($_POST['grade']) ? $_POST['grade'] : null;
    
        if ($grade === null || !is_numeric($grade) || $grade < 65 || $grade > 100) {

            $result['errors'][] = "Grade should be between 65 to 100.";
        } else {
            $result = assignGradeToSubject($student_id, $subject_code, $grade);

            if ($result['success']) {
                header("Location: attach-subject.php?id=" . urlencode($student_id));
                exit;
            }
        }
    }
    
} else {
    echo "<div class='alert alert-danger'>Student or Subject information is missing.</div>";
}
include '../partials/side-bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
<div class="content col-md-10">
            <h2 class="mb-5">Assign Grade to Subject</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                <li class="breadcrumb-item"><a href="attach-subject.php?id=<?php echo urlencode($student_id); ?>">Attach Subject to Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assign Grade to Subject</li>
                </ol>
            </nav>
            <?php
                if (!empty($result['errors'])) {
                    echo renderErrorMessage(implode('<br>', $result['errors'])); 
                }
                ?>
            <div class="card p-5">
                <div class="card-body">
                <p style="font-size: 20px;">Selected Student and Subject Information</p>
                    <ul>
                        <li><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></li>
                        <li><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']); ?></li>
                        <li><strong>Subject Code:</strong> <?php echo htmlspecialchars($subject['subject_code']); ?></li>
                        <li><strong>Subject Name:</strong> <?php echo htmlspecialchars($subject['subject_name']); ?></li>
                    </ul>
                    <hr>
                    <form method="POST">
                    <div class="mb-3 form-floating">
                    <input type="number" class="form-control" id="grade" name="grade" placeholder="Grade" >
                     <label for="grade">Grade</label>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Grade to Subject</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include '../partials/footer.php';
?>
