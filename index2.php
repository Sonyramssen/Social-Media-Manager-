<style>
  body {
    background-color: #fde4e4; /* Light red background */
    font-family: Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
  }
  h2 {
    color: #ff9494; /* Light red heading */
    text-align: center;
    margin-top: 30px; /* Add some space above the heading */
    text-shadow: 2px 2px #fff; /* Add a subtle text shadow */
  }
  form {
    background-color: #fff8dc; /* Light yellow form */
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 0 auto;
    max-width: 400px;
    padding: 20px;
    margin-top: 30px; /* Add some space below the heading */
  }
  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #ffb6b6; /* Light red label text */
  }
  input[type="text"],
  input[type="password"] {
    border: 2px solid #ffb6b6; /* Light red border */
    border-radius: 3px;
    font-size: 16px;
    margin-bottom: 10px;
    padding: 10px;
    width: 100%;
  }
  input[type="submit"] {
    background-color: #ff9494; /* Light red button */
    border: none;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
    padding: 10px;
    width: 100%;
    transition: background-color 0.2s ease; /* Add a smooth hover effect */
  }
  input[type="submit"]:hover {
    background-color: #ffc4c4; /* Lighter red on hover */
  }
  a {
    color: #ffb6b6; /* Light red link */
    display: block;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
  }
  a:hover {
    color: #ffc4c4; /* Lighter red on hover */
  }
</style>
  </head>
  <body>
    <h2>Login Page</h2>
    <a href="index.php">Click here to go back</a>
    <form action="index3.php" method="POST">
      <label for="username">Enter Username:</label>
      <input type="text" name="username" id="username" required="required" />
      <label for="password">Enter password:</label>
      <input type="password" name="password" id="password" required="required" />
      <input type="submit" value="Login" />
    </form>
  </body>
</html>