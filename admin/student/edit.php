<?php
$pagetitle = 'Edit Student';
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
                    <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                </ol>
            </nav>
            <div class="container-fluid border p-5 rounded"> 
                <div class="form-container">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="studentId" value="1001" placeholder="Student ID">
                            <label for="subjectId">Student ID</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="studentfName" value="Renmark" placeholder="First Name">
                            <label for="subjectName">First Name</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="studentlName" value="Salalila" placeholder="Last Name">
                            <label for="subjectDescription">Last Name</label>
                        </div>
                    </div>

                    <!-- Update Button -->
                    <button type="submit" class="btn btn-primary w-100">Update Subject</button>
                </div>
            </div>
        </div>
    </div>
</main>
