<?php
 $pagetitle = 'Subject';
 include '../partials/header.php';
 include '../partials/side-bar.php';
 ?>
 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
<div class="d-flex">

    <div class="content flex-grow-1 p-10">
        <h2>Add a New Subject</h2>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
            </ol>
        </nav>

        <div class="card p-3 mb-4">
            <form action="add_subject.php" method="POST">
                <div class="mb-3">
                    <label for="subjectCode" class="form-label">Subject Code</label>
                    <input type="text" id="subjectCode" name="subject_code" class="form-control" placeholder="Subject Code" required>
                </div>
                <div class="mb-3">
                    <label for="subjectName" class="form-label">Subject Name</label>
                    <input type="text" id="subjectName" name="subject_name" class="form-control" placeholder="Subject Name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Subject</button>
            </form>
        </div>

        <div class="card p-3">
            <h4>Subject List</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1001</td>
                        <td>English</td>
                        <td>
                        <a href="edit.php?id=1001" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete.subject.php?id=1001" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>