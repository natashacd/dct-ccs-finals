<?php
include '../../functions.php';
guard();
$pagetitle = 'Edit Subject';
$errors = [];

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
            $subject_name = $_POST['subject_name'];

            $result = editSubject($subject_code, $subject_name);

            if ($result['success']) {
                header("Location: add.php");
                exit;
            } else {
                $errors = $result['errors'];
            }
        }

        include '../partials/header.php';
        include '../partials/side-bar.php';
    } else {
        echo "Subject not found.";
    }
} else {
    echo "No subject selected for editing.";
}
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <div class="container-fluid position-relative">
        <div class="content flex-grow-1 p-10">
            <h2 class="mb-5">Edit Subject</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
                </ol>
            </nav>
            <?php echo renderErrorMessage(implode('', $errors)); ?>
            <form method="post" action="">
                <div class="mb-3 form-floating">
                    <input type="text" name="subject_code" class="form-control" id="subjectCode"
                           value="<?= htmlspecialchars($subject['subject_code']) ?>"
                           placeholder="Subject Code" readonly>
                    <label for="subjectCode">Subject Code</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="text" name="subject_name" class="form-control" id="subjectName"
                           value="<?= htmlspecialchars($subject['subject_name']) ?>"
                           placeholder="Subject Name"  autofocus>
                    <label for="subjectName">Subject Name</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Subject</button>
            </form>
        </div>
    </div>
</main>

<?php include '../partials/footer.php'; ?>
