<?php
 $pagetitle = 'Attach Subject';
 include '../partials/header.php';
 include '../partials/side-bar.php';
 ?>
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">  
  <div class="content col-md-10">
            <h2 class="mb-5">Attach Subject to Student</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Register Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attach Subject to Student</li>
                </ol>
            </nav>
            <div class="card p-4">
                <div class="card-body">
                    <h4 class="mb-4">Selected Student Information</h4>
                    <ul>
                    <li class="ml-4"><strong>Student ID:</strong> 1001</li>
                    <li><strong>Name:</strong> Renmark</li>
                    </ul>
                   
                    <hr>
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="subject1">
                            <label class="form-check-label" for="subject1">
                                1001 - English
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="subject2">
                            <label class="form-check-label" for="subject2">
                                1002 - Mathematics
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="subject3">
                            <label class="form-check-label" for="subject3">
                                1003 - Science
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Attach Subjects</button>
                    </form>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header">
                    Subject List
                </div>
                <div class="card-body p-5">
                    <table class="table table-striped">
                    <thead>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th>Grade</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1001</td>
                                <td>English</td>
                                <td>99.00</td>
                                <td>
                                <a href="dettach-subject.php?id=1001" class="btn btn-danger btn-sm">Dettach Subject</a>
                                <a href="assign-grade.php?id=1001" class="btn btn-success btn-sm">Assign Grade</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>