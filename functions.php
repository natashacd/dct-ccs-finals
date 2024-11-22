<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dct-ccs-finals';

$conn = new mysqli($host, $user, $password, $database);

    
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dct-ccs-finals';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
return $conn;

if ($conn->connect_error) {
    die("Connection Failed: . $conn->connect_error");
}



function guard()
{
    if (empty($_SESSION['email'])) {
        header('Location: /index.php');
        exit;
    }
}

function returnPage()
{
    if (!empty($_SESSION['email'])) {
        header('Location: ' . $_SESSION['page']);
        exit;
    }
}

function logIn($email, $password)
{
    global $conn;
    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error: " . $conn->error;
        return false;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {

            $_SESSION['email'] = $email;

            $fetchSubjectsSQL = "SELECT subject_code, subject_name FROM subjects";
            $subjectResult = $conn->query($fetchSubjectsSQL);

            if ($subjectResult && $subjectResult->num_rows > 0) {
                $_SESSION['subjects'] = [];
                while ($subject = $subjectResult->fetch_assoc()) {
                    $_SESSION['subjects'][] = [
                        'subject_code' => $subject['subject_code'],
                        'subject_name' => $subject['subject_name']
                    ];
                }
            } else {
                $_SESSION['subjects'] = []; 
            }

            header('Location: admin/dashboard.php');
            exit;
        } else {
            return [
                'success' => false,
                'error' => '<li>Invalid email or password.</li>'
            ];
        }
    } else {
        return [
            'success' => false,
            'error' => '<li>Invalid email.</li>'
        ];
    }

    $stmt->close();
}

function validateLoginCredentials($email, $password)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errorMessage = '';

        if (empty($email) || empty($password)) {
            $errorMessage .= "<li>Email is required.<br></li><li>Password is required.</li>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage .= "<li>Invalid email.<br></li>";
        }

        if (empty($password)) {
            $errorMessage .= "<li>Password is required.</li>";
        }

        if (!empty($errorMessage)) {
            return $errorMessage;
        } else {
            $login = logIn($email, $password);
            if (!$login['success']) {
                return $login['error'];
            }
        }
        return true;
    }
}

function addSubject($subject_code, $subject_name)
{
    global $conn;

    if (!isset($_SESSION['subjects'])) {
        $_SESSION['subjects'] = [];
    }

    $errors = [];


    if (empty($subject_code)) {
        $errors[] = "<li>Subject Code is required.</li>";
    }
    if (empty($subject_name)) {
        $errors[] = "<li>Subject Name is required.</li>";
    }


    foreach ($_SESSION['subjects'] as $subject) {
        if ($subject['subject_name'] === $subject_name) {
            $errors[] = "Duplicate Subject Name.";
            break;
        }
    
        if ($subject['subject_code'] === $subject_code) {
            $errors[] = "Duplicate Subject Code.";
            break;
        }
    
        if ($subject['subject_name'] === $subject_code && $subject['subject_code'] === $subject_name) {
            $errors[] = "<li>Duplicate Subject Name.</li> <li>Duplicate Subject Code.</li>";
            break;
        }
    }
    

    if (empty($errors)) {

        $sql = "INSERT INTO subjects (subject_code, subject_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $subject_code, $subject_name);

        if ($stmt->execute()) {
           
            $inserted_id = $stmt->insert_id;
            $_SESSION['subjects'][] = [
                'id' => $inserted_id, 
                'subject_code' => $subject_code,
                'subject_name' => $subject_name
            ];
            $_SESSION['success'] = "Subject added successfully.";
            return [
                'success' => true,
                'errors' => []
            ];
        } else {
            $errors[] = "Failed to insert subject into the database.";
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        $stmt->close();
    }

    return [
        'success' => false,
        'errors' => $errors
    ];
}

function editSubject($subject_code, $subject_name)
{
    global $conn;
    

    if (empty($subject_code) || empty($subject_name)) {
        return [
            'success' => false,
            'errors' => ["<li>Subject Name is required.</li>"]
        ];
    }

    $sql = "SELECT COUNT(*) FROM subjects WHERE (subject_code = ? OR subject_name = ?) AND subject_code != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $subject_code, $subject_name, $subject_code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        return [
            'success' => false,
            'errors' => ["<li>Duplicate Subject Name.</li>"]
        ];
    }

    $sql = "UPDATE subjects SET subject_name = ? WHERE subject_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $subject_name, $subject_code);
    if ($stmt->execute()) {


        foreach ($_SESSION['subjects'] as &$sub) {
            if ($sub['subject_code'] == $subject_code) {
                $sub['subject_name'] = $subject_name;
                break;
            }
        }
        $stmt->close();
        return [
            'success' => true,
            'errors' => []
        ];
    } else {
        $stmt->close();
        return [
            'success' => false,
            'errors' => ["Failed to update subject in the database."]
        ];
    }
}

function deleteSubject($subject_code)
{
    global $conn;

    $deleteStudentsSubjectsQuery = "DELETE FROM students_subjects WHERE subject_id = (SELECT id FROM subjects WHERE subject_code = ?)";
    $stmt = $conn->prepare($deleteStudentsSubjectsQuery);
    $stmt->bind_param("s", $subject_code);

    if (!$stmt->execute()) {
        $stmt->close();
        return [
            'success' => false,
            'errors' => ["Failed to delete the subject from students_subjects table."]
        ];
    }

    $sql = "DELETE FROM subjects WHERE subject_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subject_code);

    if ($stmt->execute()) {

        foreach ($_SESSION['subjects'] as $key => $sub) {
            if ($sub['subject_code'] == $subject_code) {
                unset($_SESSION['subjects'][$key]);
                break;
            }
        }

        $stmt->close();
        return [
            'success' => true,
            'errors' => []
        ];
    } else {
        $stmt->close();
        return [
            'success' => false,
            'errors' => ["Failed to delete subject from the database."]
        ];
    }
}

function getSubjectdash($conn)
{
    $subjectCount = 0;
    $sql = "SELECT COUNT(*) AS subject_count FROM subjects";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $subjectCount = $row['subject_count'];
    }

    return $subjectCount;
}

function registerStudent($student_id, $first_name, $last_name)
{
    global $conn;

    // Validate input fields
    if (empty($student_id) || empty($first_name) || empty($last_name)) {
        return [
            'success' => false,
            'errors' => ["<li>Student ID is required.</li><li>First Name is required.</li><li>Last Name is required.</li>"]
        ];
    }

    $sql = "SELECT COUNT(*) FROM students WHERE student_id = ?";  
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        return [
            'success' => false,
            'errors' => ["<li>Duplicate Student ID.</li>"]
        ];
    }

    $sql = "INSERT INTO students (student_id, first_name, last_name) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $first_name, $last_name);  
    if ($stmt->execute()) {
        $stmt->close();
        return [
            'success' => true,
            'errors' => []
        ];
    } else {
        $stmt->close();
        return [
            'success' => false,
            'errors' => ["<li>Failed to register student. Please try again later.</li>"]
        ];
    }
}



function getStudents() {
    global $conn;


    $students = [];

    $sql = "SELECT id, student_id, first_name, last_name FROM students"; 


    $result = $conn->query($sql);


    if ($result && $result->num_rows > 0) {
        while ($student = $result->fetch_assoc()) {
            $students[] = $student; 
        }
    }

    return $students; 
}


function getStudentById($student_id) {
    global $conn;
    $sql = "SELECT student_id, first_name, last_name FROM students WHERE student_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); 
}


function getStudentById1($student_id) {
    global $conn;
    $sql = "SELECT student_id, first_name, last_name FROM students WHERE student_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); 
}

function ids($student_id) {
    global $conn;

    $sql = "SELECT student_id, first_name, last_name FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Database error: " . $conn->error);
    }
    $stmt->bind_param('i', $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    
    if (!$student) {
        echo "No student found with ID: " . $student_id;
    }

    return $student ?: null;
}

function updateStudent($student_id, $first_name, $last_name) {
    global $conn;

    if (empty($first_name) || empty($last_name)) {
        return [
            'success' => false, 
            'errors' => ['<li>First Name is required.</li><li>Last Name is required.</li>']
        ];
    }


    $sql = "UPDATE students SET first_name = ?, last_name = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return ['success' => false, 'errors' => ['Database error: ' . $conn->error]];
    }

    $stmt->bind_param('ssi', $first_name, $last_name, $student_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return ['success' => true];
    } else {
        return ['success' => false, 'errors' => ['No changes were made to the student record.']];
    }
}

function deleteStudent($student_id) {
    global $conn; 
    
    $conn->begin_transaction();

    try {
        $deleteSubjectsQuery = "DELETE FROM students_subjects WHERE student_id = ?";
        $stmt = $conn->prepare($deleteSubjectsQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement for students_subjects: " . $conn->error);
        }
        $stmt->bind_param("i", $student_id); 
        if (!$stmt->execute()) {
            throw new Exception("Error deleting from students_subjects: " . $stmt->error);
        }
        $stmt->close();

        $deleteStudentQuery = "DELETE FROM students WHERE student_id = ?";
        $stmt = $conn->prepare($deleteStudentQuery);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement for students: " . $conn->error);
        }
        $stmt->bind_param("i", $student_id);
        if (!$stmt->execute()) {
            throw new Exception("Error deleting from students: " . $stmt->error);
        }
        $stmt->close();

        $conn->commit();
        return true;

    } catch (Exception $e) {

        $conn->rollback();
        error_log($e->getMessage());
        return false;
    }
}



function attachSubjectsToStudent($student_id, $subjects) {
    global $conn;
    $success = true;
    $errors = [];

    if (empty($subjects)) {
        $errors[] = "At least one subject should be selected.";
    } else {
        foreach ($subjects as $subject_code) {

            $subject_query = "SELECT id FROM subjects WHERE subject_code = ?";
            $stmt = $conn->prepare($subject_query);
            $stmt->bind_param("s", $subject_code);
            $stmt->execute();
            $subject_result = $stmt->get_result();

            if ($subject_result->num_rows == 0) {

                $errors[] = "Subject with code $subject_code does not exist.";
                continue;
            }

            $subject = $subject_result->fetch_assoc();
            $subject_id = $subject['id'];

            $check_query = "SELECT * FROM students_subjects WHERE student_id = ? AND subject_id = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("ii", $student_id, $subject_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errors[] = "Subject with code $subject_code is already attached to this student.";
            } else {
                $insert_query = "INSERT INTO students_subjects (student_id, subject_id, grade) VALUES (?, ?, 0.00)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("ii", $student_id, $subject_id);
                if (!$stmt->execute()) {
                    $errors[] = "Failed to attach subject $subject_code.";
                    $success = false;
                }
            }
        }
    }

    return ['success' => $success, 'errors' => $errors];
}




function getSubjectsByStudentId($student_id) {
    global $conn;

    $subjects = [];

    $sql = "SELECT s.subject_code, s.subject_name
            FROM subjects s
            INNER JOIN students_subjects ss ON s.id = ss.subject_id
            WHERE ss.student_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    while ($subject = $result->fetch_assoc()) {
        $subjects[] = $subject;
    }

    return $subjects;
}

function getAllSubjects() {
    global $conn;

    $subjects = [];

    $sql = "SELECT id,subject_code, subject_name FROM subjects";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($subject = $result->fetch_assoc()) {
            $subjects[] = $subject;
        }
    }

    return $subjects;
}
function detachSubjectFromStudent($student_id, $subject_code) {
    global $conn;

    $query = "SELECT id FROM subjects WHERE subject_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $subject_code);
    $stmt->execute();

    if ($stmt->error) {
        return ['success' => false, 'errors' => ['Query error: ' . $stmt->error]];
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
        $subject_id = $subject['id'];
    } else {
        return ['success' => false, 'errors' => ['Subject not found!']];
    }

    $query = "DELETE FROM students_subjects WHERE student_id = ? AND subject_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $student_id, $subject_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return ['success' => true, 'message' => 'Subject successfully detached from student.'];
    } else {
        return ['success' => false, 'errors' => ['No rows were affected. Subject might not be assigned to this student.']];
    }
}


function getStudentDash($conn)
{
    $studentCount = 0; 
    $sql = "SELECT COUNT(*) AS student_count FROM students"; 
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $studentCount = $row['student_count']; 
    }

    return $studentCount; 
}
function assignGradeToSubject($student_id, $subject_code, $grade) {
    global $conn;
    if ($grade < 65 || $grade > 100) {
        return [
            'success' => false,
            'errors' => ["Grade must be between 65 and 100."]
        ];
    }

    $sql = "SELECT ss.id FROM students_subjects ss 
            JOIN subjects s ON ss.subject_id = s.id
            WHERE ss.student_id = ? AND s.subject_code = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $student_id, $subject_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $update_sql = "UPDATE students_subjects SET grade = ? WHERE student_id = ? AND subject_id = (SELECT id FROM subjects WHERE subject_code = ?)";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("dis", $grade, $student_id, $subject_code); 

        if ($stmt->execute()) {
            return [
                'success' => true,
                'errors' => []
            ];
        } else {
            return [
                'success' => false,
                'errors' => ["Failed to update grade."]
            ];
        }
    } else {
        return [
            'success' => false,
            'errors' => ["Subject not attached to this student."]
        ];
    }
}

function getSubjectByCode($subject_code) {
    global $conn;

    $sql = "SELECT * FROM subjects WHERE subject_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subject_code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($subject = $result->fetch_assoc()) {
        return $subject;
    } else {
        return null; 
    }
}

function getPassFailCount($conn) {
    $query = "
           SELECT 
            `student_id`,
            AVG(`grade`) AS `average_grade`,
            CASE 
                WHEN AVG(`grade`) >= 75 THEN 'Passed'
                ELSE 'Failed'
            END AS `status`
        FROM 
            `students_subjects`
        WHERE 
            `grade` >= 65 -- Only consider grades 65 and above
        GROUP BY 
            `student_id`;
    ";

    $result = $conn->query($query);


    $passedCount = 0;
    $failedCount = 0;

    if ($result->num_rows > 0) {
        $counts = [];
        while ($row = $result->fetch_assoc()) {

            $counts[] = [
                'student_id' => $row['student_id'],
                'average_grade' => $row['average_grade'],
                'status' => $row['status']
            ];

            if ($row['status'] == 'Passed') {
                $passedCount++;
            } else {
                $failedCount++;
            }
        }

        return [
            'students' => $counts,
            'passed' => $passedCount, 
            'failed' => $failedCount
        ];
    } else {
        return [
            'students' => [],
            'passed' => 0,
            'failed' => 0
        ];
    }
}


function renderErrorMessage($errorHtml)
{
    if (!empty($errorHtml)) {
        return '<div>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>System Errors:</strong>
                                <ul>' . $errorHtml . '</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
    } else {
        return '';
    }
}

function logout()
{
    session_destroy();
    header("Location: /index.php");
}