<?php
$pagetitle = 'Dettach Subject';
include '../partials/header.php';
include '../partials/side-bar.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
<div class="content col-md-10">
            <h2 class="mb-5">Delete Student</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="delete.php">Register Student</a></li>
                <li class="breadcrumb-item"><a href="attach-subject.php">Attach Subject to Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dettach Subject to Student</li>
                </ol>
            </nav>
            <div class="card p-5">
                <div class="card-body">
                <p style="font-size: 20px;">Are you sure you want to dettach this subject from this student record?</p>
                    <ul>
                        <li><strong>Student ID:</strong> 1001</li>
                        <li><strong>First Name:</strong> Renmark</li>
                        <li><strong>Last Name:</strong> Salalila</li>
                        <li><strong>Subject Code:</strong> 1001</li>
                        <li><strong>Subject Name:</strong> English</li>
                    </ul>
                    <button class="btn btn-secondary">Cancel</button>
                    <button class="btn btn-primary">Delete Subject from Student</button>
                </div>
            </div>
        </div>
    </div>
</main>
