<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

/* General Styles */
body {
  width: 100%;
  height: 100vh;
  background: #f9f9f9;
  font-family: 'Raleway', sans-serif;
  font-weight: 300;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

/* Container for the content */
#not-found {
  max-width: 500px;
  width: 100%;
  padding: 20px;
}

/* Illustration Image */
.illustration {
  width: 100%;
  max-width: 300px;
  height: auto;
  margin: 0 auto 20px;
}

/* Title */
#title {
  font-size: 28px;
  color: #333;
  margin-bottom: 10px;
  font-weight: 600;
}

/* Error Code */
.error-code {
  font-size: 80px;
  color: #333;
  margin: 0;
  line-height: 1;
  font-weight: 700;
}

/* Subtitle */
.subtitle {
  font-size: 18px;
  color: #666;
  margin-top: 10px;
  font-weight: 400;
}

/* Button Style */
.button {
  margin-top: 30px;
}

.button a {
  text-decoration: none;
  padding: 10px 20px;
  background: #333;
  color: #fff;
  border-radius: 5px;
  font-size: 14px;
  font-weight: 500;
  transition: background 0.3s ease;
}

.button a:hover {
  background: #555;
}

</style>
</head>
<body>
  <section id="not-found">
    <!-- Ilustrasi dari Undraw -->
    <img src="https://assets.website-files.com/5bff8886c3964a992e90d465/5c00621b7aefa4f9ee0f4303_web-dev.svg" alt="404 Illustration" class="illustration">
    <div id="title">Oops! Page Not Found</div>
    <div class="error-code">404</div>
    <div class="subtitle">The page you're looking for doesn't exist.</div>
    <div class="button">
      <a href="/">Go Back Home</a>
    </div>
  </section>
</body>
</html>