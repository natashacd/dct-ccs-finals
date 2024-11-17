<?php
$pagetitle = 'Edit Student';
include '../partials/header.php';
include '../../functions.php';
guard();

$errors = [];
$successMessage = '';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $student = getStudentById($student_id); 

    if (!$student) {
        echo "Student not found!";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];


        $result = updateStudent($student_id, $first_name, $last_name); 

        if ($result['success']) {
            $successMessage = "Student updated successfully!";
            header("Location: register.php"); 
            exit;
        } else {
            $errors = $result['errors']; 
        }
    }
} else {
    echo "No student selected for editing.";
    exit;
}

include '../partials/side-bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <div class="container-fluid position-relative"> 
        <div class="content flex-grow-1 p-10">
            <h2 class="mb-5">Edit Student</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                </ol>
            </nav>
            <div class="container-fluid border p-5 rounded"> 
                <div class="form-container">

                <?php echo renderErrorMessage(implode('', $errors)); ?> 

                    <form action="edit.php?id=<?= $student['student_id']; ?>" method="POST">
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="studentId" name="student_id" value="<?= htmlspecialchars($student['student_id']); ?>" placeholder="Student ID" readonly>
                                <label for="studentId">Student ID</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="studentfName" name="first_name" value="<?= htmlspecialchars($student['first_name']); ?>" placeholder="First Name">
                                <label for="studentfName">First Name</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="studentlName" name="last_name" value="<?= htmlspecialchars($student['last_name']); ?>" placeholder="Last Name">
                                <label for="studentlName">Last Name</label>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <button type="submit" class="btn btn-primary w-100">Update Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include '../partials/footer.php';
?>
