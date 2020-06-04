<?php 
session_start();
error_reporting(0);
?>
<!--- Hire Me Please --->
<!DOCTYPE HTML>
<html>
<head>
	<title>Facebook Profile Guard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">#FacebookShield</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://github.com/0xearl" target="_blank">Github</a>
      </li>
    </ul>
  </div>
</nav>
<?php

echo $_SESSION['msg']; unset($_SESSION['msg']);

?>
<div class='container'>
<br>
<center><h1>Profile Guard Enabler</h1></center>
<div class="info p-2 m-auto text-center">
  <p class="font-weight-bold text-muted">First try may not work. if it wont work please check your facebook account if it's temporarily locked, and confirm the unknown device that it was you. And Try again.
</p>
</div>
<form method="POST" action="activate.php">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>
<div class="form-group">
      <label for="select">Action</label>
      <select id="select" class="form-control" name="active">
        <option value="true">Enable</option>
        <option value="false">Disable</option>
      </select>
    </div>
<Br>
<button class="btn btn-primary btn-block" name="submit">Submit</button>
</form>
</div>
<style>
.info {
  width: 50%;
  height: 100px;
  background-color: #f4f7f2;
}

</style>
</body>
</html>