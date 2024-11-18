<?php
$pagetitle = 'Attach Subject';
include '../partials/header.php';
include '../../functions.php'; 
guard();

$result = ['success' => false, 'errors' => []];

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $student = getStudentById($student_id);  

    if (!$student) {
        echo "<div class='alert alert-danger'>Student not found!</div>";
        exit;
    }

 
    $student_subjects = getSubjectsByStudentId($student_id); 


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($student_id)) {
        $selected_subjects = isset($_POST['subjects']) ? $_POST['subjects'] : [];

        if (empty($selected_subjects)) {

            $result['errors'][] = "At least one subject should be selected.";
        } else {

            $result = attachSubjectsToStudent($student_id, $selected_subjects);
        }


        if ($result['success']) {
            $student_subjects = getSubjectsByStudentId($student_id); 
        }
    }
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">  
    <div class="content col-md-10">
        <h2 class="mb-5">Attach Subject to Student</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                <li class="breadcrumb-item active" aria-current="page">Attach Subject to Student</li>
            </ol>
        </nav>

        <?php
        if (!empty($result['errors'])) {
            echo renderErrorMessage(implode('<br>', $result['errors'])); 
        }
        ?>

        <div class="card p-4">
            <div class="card-body">
                <h4 class="mb-4">Selected Student Information</h4>
                <ul>
                    <?php if ($student): ?>
                        <li class="ml-4"><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></li>
                        <li><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']); ?></li>
                    <?php else: ?>
                        <li><strong>No student information available.</strong></li>
                    <?php endif; ?>
                </ul>
                <hr>

                <?php 
                if (empty($student_subjects)): ?>
                    <form action="attach-subject.php?id=<?php echo urlencode($student_id); ?>" method="POST">
                        <h5>Select Subjects to Attach:</h5>
                        <?php

                        $available_subjects = getAllSubjects();
                        if (!empty($available_subjects)) {
                            foreach ($available_subjects as $subject) {
                                echo "<div class='form-check'>
                                        <input class='form-check-input' type='checkbox' name='subjects[]' value='" . $subject['subject_code'] . "' id='subject" . $subject['subject_code'] . "'>
                                        <label class='form-check-label' for='subject" . $subject['subject_code'] . "'>" . htmlspecialchars($subject['subject_name']) . "</label>
                                      </div>";
                            }
                        }
                        ?>
                        <button type="submit" class="btn btn-primary mt-3">Attach Subjects</button>
                    </form>
                <?php else: ?>

                    <p>Subjects are already attached. You can detach them if needed.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                Subject List
            </div>
            <div class="card-body p-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Grade</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($student_subjects)) {
                            foreach ($student_subjects as $subject) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($subject['subject_code']) . "</td>";
                                echo "<td>" . htmlspecialchars($subject['subject_name']) . "</td>";
                                echo "<td></td>";
                                echo "<td>
                                        <a href='dettach-subject.php?id=" . htmlspecialchars($subject['subject_code']) . "' class='btn btn-danger btn-sm'>Detach Subject</a>
                                        <a href='assign-grade.php?id=" . htmlspecialchars($subject['subject_code']) . "' class='btn btn-success btn-sm'>Assign Grade</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No subjects attached to this student.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php

include '../partials/footer.php'; 
?>
