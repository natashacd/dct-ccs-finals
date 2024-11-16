<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dct-ccs-finals';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error){
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
    $sql = "SELECT password FROM users WHERE email =?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error: " . $conn->error;
        return false;
    }
    $stmt ->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if($password == $row['password']) {
            $_SESSION['email'] = $email;
            header('Location: admin/dashboard.php');
            exit;
        } else {
           return [
                'success'   => false,
                'error'     => '<li>Invalid email or password.</li>'
           ];
        }
    } else {
        return [
            'success'   => false,
            'error'     => '<li>Invalid email.</li>'
       ];
    }

    $stmt->close();
}

    
function validateLoginCredentials($email, $password) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errorMessage = '';
    
        if (empty($email)) {
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

function logout() {
    session_destroy();
    header("Location: /index.php");
}
?>