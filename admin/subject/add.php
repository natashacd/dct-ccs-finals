<?php
$pagetitle = 'Subject';
include '../partials/header.php';
include '../../functions.php';
guard();

$errorHtml = ['success' => true, 'errors' => []];
$subject_code = '';
$subject_name = '';

if (!isset($_SESSION['subjects'])) {
    $_SESSION['subjects'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_code = htmlspecialchars(trim($_POST["subject_code"] ?? ''));
    $subject_name = htmlspecialchars(trim($_POST["subject_name"] ?? ''));
    $errorHtml = addSubject($subject_code, $subject_name);

    if (!$errorHtml['success']) {

        $errors = $errorHtml['errors'];
    } else {

        $_SESSION['success'] = "Subject added successfully.";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }
}

include '../partials/side-bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5"> 
    <div class="d-flex">
        <div class="content flex-grow-1 p-10">
            <h2 class="mb-5">Add a New Subject</h2>
            
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
                </ol>
            </nav>                    
            <?php echo renderErrorMessage(implode('', $errorHtml['errors'] ?? [])); ?>  
            <div class="card p-5 mb-4">
                <form action="add.php" method="POST">
                    <div class="mb-3 form-floating">
                        <input type="text" id="subjectCode" name="subject_code" class="form-control " placeholder="Subject Code" value="<?= htmlspecialchars($subject_code); ?>">
                        <label for="subjectCode">Subject Code</label>
                    </div>

                    <div class="mb-3 form-floating">
                        <input type="text" id="subjectName" name="subject_name" class="form-control " placeholder="Subject Name" value="<?= htmlspecialchars($subject_name); ?>">
                        <label for="subjectName">Subject Name</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add Subject</button>
                </form>
            </div>
            <div class="card p-5">
                <h4>Subject List</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($_SESSION['subjects'])): ?>
                            <tr>
                                <td colspan="3" class="text-center">No subjects added yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($_SESSION['subjects'] as $subject): ?>
                                <tr>
                                    <td><?= htmlspecialchars($subject['subject_code']); ?></td>
                                    <td><?= htmlspecialchars($subject['subject_name']); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= urlencode($subject['subject_code']); ?>" class="btn btn-info btn-sm">Edit</a>
                                        <a href="delete.php?id=<?= urlencode($subject['subject_code']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php
include '../partials/footer.php';
?>