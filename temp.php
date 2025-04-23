<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}?>

<?php

$name = $email = $phone = $message = "";
$nameErr = $emailErr = $phoneErr = $messageErr = "";
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $valid = true;

  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $valid = false;
  } else {
    $name = htmlspecialchars($_POST["name"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $valid = false;
  } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
    $valid = false;
  } else {
    $email = htmlspecialchars($_POST["email"]);
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "Phone number is required";
    $valid = false;
  } else {
    $phone = htmlspecialchars($_POST["phone"]);
  }

  if (empty($_POST["message"])) {
    $messageErr = "Message is required";
    $valid = false;
  } else {
    $message = htmlspecialchars($_POST["message"]);
  }

  // If valid, mark as submitted
  if ($valid) {
    $submitted = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Feedback Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #43cea2, #185a9d);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .feedback-box {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
      max-width: 500px;
      width: 100%;
    }
    .feedback-box h2 {
      text-align: center;
      color: #333;
    }
    .feedback-box input,
    .feedback-box textarea {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
    .feedback-box .error {
      color: red;
      font-size: 13px;
    }
    .feedback-box button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 15px;
    }
    .feedback-box button:hover {
      background-color: #0056b3;
    }
    .thank-you {
      text-align: center;
      font-size: 18px;
      color: green;
    }
  </style>
</head>
<body>
  <div class="feedback-box">
  <?php include 'navbar2.php';?>
    <?php if ($submitted): ?>
      <p class="thank-you">✅ Thank you! Submitting to Gmail...</p>
      <form id="hiddenForm" action="https://formspree.io/f/mpwdajlv" method="POST">
        <input type="hidden" name="name" value="<?= $name ?>">
        <input type="hidden" name="email" value="<?= $email ?>">
        <input type="hidden" name="phone" value="<?= $phone ?>">
        <input type="hidden" name="message" value="<?= $message ?>">
      </form>
      <script>
        document.getElementById("hiddenForm").submit();
      </script>
    <?php else: ?>
      <h2>Feedback Form</h2>
      <form method="POST" action="">
        <input type="text" name="name" placeholder="Your Name" value="<?= $name ?>">
        <div class="error"><?= $nameErr ?></div>

        <input type="email" name="email" placeholder="Your Email" value="<?= $email ?>">
        <div class="error"><?= $emailErr ?></div>

        <input type="text" name="phone" placeholder="Your Phone Number" value="<?= $phone ?>">
        <div class="error"><?= $phoneErr ?></div>

        <textarea name="message" placeholder="Your Feedback"><?= $message ?></textarea>
        <div class="error"><?= $messageErr ?></div>

        <button type="submit">Submit Feedback</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>