<?php
 $pagetitle = 'Subject';
 include '../partials/header.php';
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

        <div class="card p-5 mb-4">
            <form action="add.php" method="POST">
                <div class="mb-3 form-floating">
                    <input type="text" id="subjectCode" name="subject_code" class="form-control p-3" placeholder="Subject Code">
                    <label for="subjectCode">Subject Code</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="text" id="subjectName" name="subject_name" class="form-control p-3" placeholder="Subject Name">
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
                    <tr>
                        <td>1001</td>
                        <td>English</td>
                        <td>
                        <a href="edit.php?id=1001" class="btn btn-info btn-sm">Edit</a>
                        <a href="delete.php?id=1001" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>