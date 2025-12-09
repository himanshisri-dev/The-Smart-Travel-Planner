<?php

function validatePassword($password) {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    return preg_match($pattern, $password);
}
$errors = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword']; 

    // Check if passwords match
    if ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match'); window.location.href='signup.html';</script>";
        exit();
    }

    // Validate password strength
    if (!validatePassword($password)) {
        echo "<script>alert('Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.'); window.location.href='signup.html';</script>";
        exit();
    }

    // Database connection
    $conn = mysqli_connect("localhost:3306", "root", "", "Signup");

    // Check connection
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if email already exists
    $check_email = "SELECT * FROM usersinfo WHERE email='$email'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already registered.";
    }

    // Check if there are errors before inserting into the database
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error'); window.location.href='signup.html';</script>";
        }
        exit();
    }

    // Insert into the database
    $sql = "INSERT INTO usersinfo (name, email, password, confirmpassword) 
            VALUES ('$name', '$email', '$password', '$confirmpassword')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Signup successful! Please login now.'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
