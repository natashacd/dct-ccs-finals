<?php
$pagetitle = 'Edit Subject';
include '../partials/header.php';
include '../partials/side-bar.php';
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
            <div class="container-fluid border p-5 rounded"> 
                <div class="form-container">
                    <div class="mb-3">
                        <label for="subjectId" class="form-label">Subject ID</label>
                        <input type="text" class="form-control" id="subjectId" value="1001">
                    </div>
                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subjectName" value="English">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Subject</button>
                </div>
            </div>

        </div>
    </div>
</main>
