<?php
 $pagetitle = 'Register';
 include '../partials/header.php';
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

        <div class="card p-5 mb-4">
    <form action="register.php" method="POST">
        <div class="mb-3 form-floating">
            <input type="text" id="subjectCode" name="student_id" class="form-control p-3" placeholder="Student ID">
            <label for="subjectCode">Student ID</label>
        </div>
        
        <div class="mb-3 form-floating">
            <input type="text" id="subjectName" name="first_name" class="form-control p-3" placeholder="First Name">
            <label for="subjectName">First Name</label>
        </div>
        
        <div class="mb-3 form-floating">
            <input type="text" id="lastName" name="lastname_name" class="form-control p-3" placeholder="Last Name">
            <label for="lastName">Last Name</label>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Register Subject</button>
    </form>
</div>

        <div class="card p-5">
    <h4>Subject List</h4>
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
                <tr>
                    <td>1001</td>
                    <td>Renmark</td>
                    <td>Salalila</td>
                    <td>
                        <a href="edit.php?id=1001" class="btn btn-info btn-sm">Edit</a>
                        <a href="delete.php?id=1001" class="btn btn-danger btn-sm">Delete</a>
                        <a href="attach-subject.php?id=1001" class="btn btn-warning btn-sm">Attach Subject</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>