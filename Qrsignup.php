<?php
include_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    
    $first_name = $last_name = $email = "";
    
    $first_name = trim($_POST['first_name']);
    if (empty($first_name)) {
        $errors['first_name'] = "First name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
        $errors['first_name'] = "First name should only contain letters and spaces.";
    }

    $last_name = trim($_POST['last_name']);
    if (empty($last_name)) {
        $errors['last_name'] = "Last name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
        $errors['last_name'] = "Last name should only contain letters and spaces.";
    }

    $email = trim($_POST['email']);
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    } else {
        // Check if email already exists in the database using a prepared statement
        $email_check = $conn->prepare("SELECT * FROM signup WHERE email = ?");
        $email_check->bind_param("s", $email);
        $email_check->execute();
        $result = $email_check->get_result();
        if ($result->num_rows > 0) {
            $errors['email'] = "Email is already registered.";
        }
        $email_check->close();
    }

    // Validate password (at least 8 characters long)
    $password = trim($_POST['password']);
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long.";
    }

    // If there are no validation errors, proceed to insert the user data
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database using a prepared statement
        $sql = $conn->prepare("INSERT INTO signup (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);
        
        if ($sql->execute()) {
            // Successfully registered, trigger the popup
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            document.getElementById('popup').style.display = 'block';
                            setTimeout(function() {
                                window.location.href = 'User Dashboard(Home).html';
                            }, 120000); // Redirect after 2 minutes
                        }, 500);
                    });
                  </script>";
        } else {
            echo "Error: " . $sql->error;
        }
        $sql->close();
    }

    // Close the database connection
    $conn->close();
}
?>
<style>
       /* Popup styling */
       #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color:#28C258;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
           color: #fff;
            z-index: 9999;
        align-items: center;
        justify-content: baseline;
        }

        #popup h2 {
            margin: 0;
        color: #fff;
        }

    </style>
</head>
<body>

    <div id="popup">
        <h2>Registration Successful! <i class="material-icons">check_circle</i> </h2>
       </div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="Qr_logo-removebg-preview.png" type="image/x-icon">
<title>QR Generator Card Layout</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600&display=swap");
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
   body {
            font-family: 'Syne', sans-serif;
            background-color: #f7f7f7; /* Optional background for better visibility */
        }
             header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1em 2em;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            position: relative; /* Ensure sidebar positions correctly */
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            gap: 1.5em;
        }

        nav ul li {
            list-style: none;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .btn {
            background-color: #28C258;
            color: white;
            padding: 0.5em 1em;
            border-radius: 5px;
        }

        .menu-icon {
            display: none; /* Initially hide the menu icon */
            cursor: pointer; /* Change cursor on hover */
        }

        /* Sidebar styling */
        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            width: 250px;
            height: 100%;
            background-color: #fff; /* Sidebar color */
            color: black;
            transition: left 0.3s; /* Transition for sliding effect */
            padding: 20px;
            z-index: 1000;
        }

        .sidebar.active {
            left: 0; /* Show sidebar */
        }

        .sidebar ul {
            list-style: none;
            margin-top: 50px;
        }

        .sidebar ul li {
            margin-bottom: 30px;
        }

        .sidebar ul li a {
            color: black;
            text-decoration: none;
            font-size: 1rem;
        }

        @media(max-width: 764px) {
            .menu-icon {
                display: block; /* Show the menu icon */
            }

            nav ul {
                display: none; /* Hide navigation links on small screens */
            }

            .sidebar {
                left: -250px; /* Initially hide sidebar */
            }
        }

        .active {
            color: #28C258;
        }

        .container {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            margin-top: 200px;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            max-width: 1150px;
            width: 100%;
        }

        .card-content {
            display: flex;
            flex-wrap: wrap;
        }

        .left-section, .right-section {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .left-section {
            background-color: #0abc5b;
            color: white;
            justify-content: flex-start;
        }

        .qr-box {
            text-align: center;
            margin-top: 100px;
        }

        .qr-box h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
        }

        .qr-box p {
            font-size: 16px;
            margin: 5px 0;
        }

        .qr-image {
            width: 450px;
            height: 750px;
            margin-top: 10px; /* Move the image to the bottom */
        }

        .right-section {
            background-color: white;
            justify-content: center;
        }

        .form-box {
            max-width: 500px;
            width: 100%;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-top: -150px;
        }

        h2 {
        margin-top: 50px;
            font-size: 24px;
            color: #333;
            
        }

        p {
            margin-top:50px;
   
            margin: 10px 0;
            font-size: 14px;
            color: #666;
        }

        .social-login-container {
    display: flex;
    justify-content: center; /* Center the .social-login container horizontally */
    width: 100%;
}

.social-login {
    display: flex;
   align-items: center;
   justify-content: center;

    gap: 10px; /* Space between buttons */
    width: 100%; /* Full width for each button */

margin: 0 auto;
}
.error {
    color: red;
    font-size: 0.9em;
}

@media(max-width:600px){
    .social-login {
        flex-wrap: wrap;
        margin: 0 auto;
    }
}
.social-login button {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between image and text */
    padding: 10px 18px;
    background-color: #fff;
    border: 1px solid #ccc;
    cursor: pointer;
    width: 100%; /* Full width for buttons */
text-align:center;
}
        .divider {
            margin-top: 30px;
   
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .divider::before, .divider::after {
            margin-top: 30px;
   
            content: '';
            flex: 1;
            border-bottom: 1px solid #ccc;
            margin: 0 10px;
        }

        .input-group {
   
            margin-bottom: 20px;
            text-align: left;
        }

        .flex-input-group {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .signup-btn {
            width: 100%;
            padding: 15px;
            background-color: #0abc5b;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .signup-btn:hover {
            background-color: #0a9c4f;
        }

        .login-text {
            margin-top: 15px;
        }

        .login-text a {
            color: #0abc5b;
            text-decoration: none;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .card{
                margin-top: 10px;
            }
            .card-content {
                flex-direction: column;
            
            }

   .form-box {
                padding: 15px;
            }

            .qr-image {
            display: none;
            }

            h2 {
                font-size: 20px;
            }

            input {
                font-size: 14px;
            }

            .signup-btn {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .social-login {
                flex-direction: column;
            }

            .google-btn, .apple-btn {
                margin-bottom: 10px;
            }

            .left-section {
                padding: 10px;
            }

            h1{
                font-size: 10px;
            }
           
            .qr-image {
         display: none;

            }
        }

        .logo-circle {
            background-color: #28C258;
            border-radius: 50%;
            width: 30%;
            height: 12%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            width: 50px;
            height: 50px;
        }
     input{
        transition: background-color 0.6s ease, border-color 0.5s ease, transform 0.3s ease; /* Smooth transition for background, border, and scaling */
        }

        @keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

input:focus {
    border: 1px solid #28C258; /* Green border on focus */
    outline: none; /* Remove default outline */
    animation: pulse 0.6s ease; /* Pulse animation on focus */
}


    </style>
</head>
<body>
    <!---HEADER SECTION-->
    <header>
        <div class="logo">Logo</div>
        <nav>
            <ul>
                <li><a href="#" class="active">QR Generator</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Log in</a></li>
                <li><a href="#" class="btn">Try It Free</a></li>
            </ul>
            <div class="menu-icon" onclick="toggleSidebar()">
                <i class="material-icons">menu</i>
            </div>
        </nav>
    </header>

    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="#">QR Generator</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Log in</a></li>
            <li><a href="#" class="btn">Try It Free</a></li>
        </ul>
    </div>
    <!--Header section END-->

    <div class="container">
        <div class="card">
            <div class="card-content">
                <div class="left-section">
                    <div class="qr-box">
                <h1 class="qrcodeheading">Create, Manage and Track Your QR Codes</h1>
                    </div>
                    <img src="Images/qr-cards-all-lang.webp" alt="QR Code Sample" class="qr-image">
                </div>
                <div class="right-section">
                <form action="" method="POST"  onsubmit="return validateForm()">
                    <div class="form-box">
                        <h2>Sign up</h2>
                        <p>Sign up to generate your QR code</p>
                        <div class="social-login">
                            <button class="google-btn">
                                <img src="data:image/jpeg;base64,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" alt="Google" width="30" height="30">                       </button>
                            <button class="apple-btn">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAhFBMVEXz8/PzUyWBvAYFpvD/ugjz9fb19Pbz+fr39fr69vPy9foAofD/tgDzRQB9ugAAo/Df6dCv0Xjz2dPzTBfzl4PznImz04CAx/H60oHS5vJ5xPH60Hn16dIAnvDz7u3z4t7n7dzzNADzkXurz3BwtQDzvrLM36zf6/Os2PL336z07d/7z3RN8WfWAAABg0lEQVR4nO3cyVLCYBCFURwCkXlygDBFUBTf//3cSGIVf5WrDi7O9wJdp3p/Wy1JkvSrLLzqVDu8FHAzjW57JrZ34+hSH5yWg9jK187PrXx/GMZ2GF9+MZsObmKbzSvhZHgb25CQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCwUWE5i21QC/fB86Xp/dLt/DG4t/MGbf7+FNxkl9jZzTrR1TvCeXjJIWFJkv7uIbzqVDe8LAE8Lp+D+zgTu5/FS2zFKUFcrEex9ZaV8Ksf3Sol7N3FNqqFRf8+NkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQkJCQsJmhetebOtr75dmi+iO1anTKrrNJbDRsvCuDJQk6Z/1DSzvYqEfRCNJAAAAAElFTkSuQmCC" alt="Microsoft" width="30" height="30"> 
                            </button>
                            <button class="google-btn">
                                <img src="data:image/png;base64,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" alt="LinkedIn" width="30" height="30"> 
                            </button>
                            <button class="apple-btn">
                                <img src="data:image/png;base64,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" alt="Twitter" width="30" height="30"> 
                            </button>
                            <button class="apple-btn">
                                <img src="data:image/png;base64,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" alt="Facebook" width="30" height="30"> 
                            </button>
                            <button class="apple-btn">
                                <img src="data:image/png;base64,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" alt="Discord" width="30" height="30">
                            </button>
                        </div>
                       
                        <div class="divider">OR</div>
    <div class="input-group flex-input-group">
        <div>
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($first_name); ?>">
            <?php if (isset($errors['first_name'])): ?>
                <p style="color: red;"><?php echo $errors['first_name']; ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($last_name); ?>">
            <?php if (isset($errors['last_name'])): ?>
                <p style="color: red;"><?php echo $errors['last_name']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="input-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
        <?php if (isset($errors['email'])): ?>
            <p style="color: red;"><?php echo $errors['email']; ?></p>
        <?php endif; ?>
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password">
        <?php if (isset($errors['password'])): ?>
            <p style="color: red;"><?php echo $errors['password']; ?></p>
        <?php endif; ?>
    </div>
    <button class="signup-btn">Sign Up</button>
</form>
                        <div class="login-text">
                            <p>Already have an account? <a href="#">Log in</a></p>
                        <P>By creating an account, you agree to our Terms & Conditions and the Privacy Policy.</P>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
    </script>
</body>
</html>
