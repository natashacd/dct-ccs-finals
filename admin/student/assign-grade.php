<?php
$pagetitle = 'Assign Grade';
include '../partials/header.php';
include '../partials/side-bar.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">    
<div class="content col-md-10">
            <h2 class="mb-5">Assign Grade to Subject</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                <li class="breadcrumb-item"><a href="attach-subject.php">Attach Subject to Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assign Grade to Subject</li>
                </ol>
            </nav>
            <div class="card p-5">
                <div class="card-body">
                <p style="font-size: 20px;">Selected Student and Subject Information</p>
                    <ul>
                        <li><strong>Student ID:</strong> 1001</li>
                        <li><strong>Name:</strong> Renmark Salalila</li>
                        <li><strong>Subject Code:</strong> 1001</li>
                        <li><strong>Subject Name:</strong> English</li>
                    </ul>
                    <hr>
                    <form>
                    <div class="mb-3 form-floating">
                    <input type="number" class="form-control" id="grade" value="99.00" placeholder="Grade">
                     <label for="grade">Grade</label>
                    </div>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Grade to Subject</button>
                </form>
                 
                </div>
            </div>
        </div>
    </div>
</main>
