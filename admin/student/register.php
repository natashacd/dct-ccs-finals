<?php
$pagetitle = 'Register';
include '../partials/header.php';
include '../../functions.php'; 
guard();

$errors = [];
$successMessage = '';
$student_id = '';
$first_name = '';
$last_name = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = htmlspecialchars($_POST['student_id']); 
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);

    $result = registerStudent($student_id, $first_name, $last_name); 

    if ($result['success']) {
        $successMessage = "Student registered successfully!";
        header("Location: register.php"); 
        exit;
    } else {
        $errors = $result['errors'];
    }
}

$students = getStudents(); 

include '../partials/side-bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
    <div class="d-flex">
        <div class="content flex-grow-1 p-10">
            <h2 class="mb-5">Register a New Student</h2>
            
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register Student</li>
                </ol>
            </nav>

            <?php echo renderErrorMessage(implode('', $errors)); ?>  

            <div class="card p-5 mb-4">
                <form action="register.php" method="POST">
                    <div class="mb-3 form-floating">
                        <input 
                            type="text" 
                            id="studentId" 
                            name="student_id" 
                            class="form-control" 
                            placeholder="Student ID" 
                            value="<?php echo $student_id; ?>" 
                        >
                        <label for="studentId">Student ID</label>
                    </div>
                    
                    <div class="mb-3 form-floating">
                        <input 
                            type="text" 
                            id="firstName" 
                            name="first_name" 
                            class="form-control" 
                            placeholder="First Name" 
                            value="<?php echo $first_name; ?>" 
                        >
                        <label for="firstName">First Name</label>
                    </div>
                    
                    <div class="mb-3 form-floating">
                        <input 
                            type="text" 
                            id="lastName" 
                            name="last_name" 
                            class="form-control" 
                            placeholder="Last Name" 
                            value="<?php echo $last_name; ?>" 
                        >
                        <label for="lastName">Last Name</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Register Student</button>
                </form>
            </div>

            <div class="card p-5">
                <h4>Student List</h4>
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student ID</th> 
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['student_id']); ?></td>
                                    <td><?= htmlspecialchars($student['first_name']); ?></td>
                                    <td><?= htmlspecialchars($student['last_name']); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= htmlspecialchars($student['student_id']); ?>" class="btn btn-info btn-sm">Edit</a>
                                        <a href="delete.php?id=<?= htmlspecialchars($student['student_id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                        <a href="attach-subject.php?id=<?= htmlspecialchars($student['student_id']); ?>" class="btn btn-warning btn-sm">Attach Subject</a>
                                        <!-- <a href="attach-subject.php?id=<?= htmlspecialchars($student['id']); ?>" class="btn btn-warning btn-sm">Attach Subject</a>
                                     -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include '../partials/footer.php';
?>