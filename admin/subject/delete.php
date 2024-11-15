<?php
$pagetitle = 'Delete Subject';
include '../partials/header.php';
include '../partials/side-bar.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
<div class="content col-md-10">
            <h2 class="mb-5">Delete Subject</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
                </ol>
            </nav>
            <div class="card p-5">
                <div class="card-body">
                <p style="font-size: 20px;">Are you sure you want to delete the following subject record?</p>
                    <ul>
                        <li><strong>Subject Code:</strong> 1001</li>
                        <li><strong>Subject Name:</strong> English</li>
                    </ul>
                    <button class="btn btn-secondary">Cancel</button>
                    <button class="btn btn-primary">Delete Subject Record</button>
                </div>
            </div>
        </div>
    </div>
</main>
