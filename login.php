<?php
   $db = mysqli_connect('localhost','root','onelasalle','db');
   session_start();
   $error='';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
   
      // username and password sent from form
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
      $sql = "SELECT * FROM admin WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($db,$sql);      
      // $row = mysqli_num_rows($result);      
      $count = mysqli_num_rows($result);
      if($count == 1) {
         // session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("location: welcome.php");
      } else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <style>
      :root {
         /* --primary-color: #4285f4;
         --primary-hover: #2a75f3; */
         --primary-color:rgb(74, 165, 91);
         --primary-hover:rgb(103, 186, 104);
         --error-color: #d93025;
         --border-color: #dadce0;
         --text-color: #202124;
         --background-color:rgba(236, 236, 236, 0.47);
      }

      * {
         box-sizing: border-box;
         margin: 0;
         padding: 0;
      }

      body {
         font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
         background-color: var(--background-color);
         color: var(--text-color);
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         padding: 20px;
      }

      .login-container {
         background: white;
         border-radius: 8px;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         width: 100%;
         max-width: 400px;
         overflow: hidden;
      }

      .login-header {
         padding: 24px;
         text-align: center;
         border-bottom: 1px solid var(--border-color);
      }

      .login-header h1 {
         font-size: 24px;
         font-weight: 500;
         color: var(--text-color);
      }

      .login-form {
         padding: 24px;
      }

      .form-group {
         margin-bottom: 20px;
         position: relative;
      }

      .form-group label {
         display: block;
         margin-bottom: 8px;
         font-size: 14px;
         color: var(--text-color);
      }

      .input-group {
         position: relative;
      }

      .form-control {
         width: 100%;
         padding: 12px 14px;
         font-size: 16px;
         border: 1px solid var(--border-color);
         border-radius: 4px;
         transition: border 0.2s;
         outline: none;
      }

      .form-control:focus {
         border-color: var(--primary-color);
         box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
      }

      .toggle-password {
         position: absolute;
         right: 12px;
         top: 50%;
         transform: translateY(-50%);
         background: none;
         border: none;
         color: #666;
         cursor: pointer;
         font-size: 16px;
      }

      .btn {
         width: 100%;
         padding: 12px;
         background-color: var(--primary-color);
         color: white;
         border: none;
         border-radius: 4px;
         font-size: 16px;
         font-weight: 500;
         cursor: pointer;
         transition: background-color 0.2s;
      }

      .btn:hover {
         background-color: var(--primary-hover);
      }

      .error-message {
         color: var(--error-color);
         font-size: 14px;
         margin-top: 16px;
         display: flex;
         align-items: center;
      }

      .error-message i {
         margin-right: 8px;
      }

      .form-footer {
         text-align: center;
         margin-top: 24px;
         font-size: 14px;
         color: #666;
      }

      .form-footer a {
         color: var(--primary-color);
         text-decoration: none;
      }

      .form-footer a:hover {
         text-decoration: underline;
      }

      @media (max-width: 480px) {
         .login-container {
            box-shadow: none;
         }
      }
   </style>
</head>
<body>
   <div class="login-container">
      <div class="login-header">
         <h1><strong>LSGH Admin Login</strong></h1>
      </div>
      <div class="login-form">
         <form action="" method="post">
            <div class="form-group">
               <label for="username"><strong>Username</strong></label>
               <div class="input-group">
                  <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
               </div>
            </div>
            <div class="form-group">
               <label for="password"><strong>Password</strong></label>
               <div class="input-group">
                  <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                  <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                     <i class="far fa-eye" id="toggleIcon"></i>
                  </button>
               </div>
            </div>
            <button type="submit" class="btn">Sign In</button>
            
            <?php if($error): ?>
            <div class="error-message">
               <i class="fas fa-exclamation-circle"></i>
               <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <div class="form-footer">
               <p>Educational Technology Department</p>
            </div>
         </form>
      </div>
   </div>

   <script>
      // Password visibility toggle
      document.querySelector('.toggle-password').addEventListener('click', function() {
         const passwordInput = document.getElementById('password');
         const toggleIcon = document.getElementById('toggleIcon');
         
         if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
         } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
         }
      });
   </script>
</body>
</html>