<!-- View for welcome -->
<?php require_once("../framework/utility/access.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenPHP - A Modern PHP Framework</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
        }
        .hero {
            background: url('https://via.placeholder.com/1920x600') no-repeat center center; 
            background-size: cover;
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero h1 {
            font-size: 3rem;
        }
        .hero p {
            font-size: 1.25rem;
        }
        .feature-icon {
            font-size: 60px;
            color: #007bff;
        }
        .feature-card {
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        footer {
            background-color: #343a40;
            color: white;
        }
        img{
            animation:r;
            animation-timing-function:ease-in;
            animation-duration:2s;
            animation-iteration-count:infinite;
            
        }

        @keyframes r{
            from{transform:rotateZ(0deg);}
            to{transform:rotateZ(360deg);}
        }
    </style>
</head>
<body>

    <header class="hero h-100vh" style="height:100vh;background-image:linear-gradient(to right,purple,blue);color:white!important;">
        <div class="container position-relative">
            <h1 class="display-4">Welcome to OpenPHP</h1>
            <p class="lead">A modern, lightweight PHP framework for rapid application development.</p>
            <a href="#features" class="btn btn-primary btn-lg">Get Started</a>
        </div>
        <br>
        <img src=@asset("setting.png") height="100px"alt="" style="background-blend-mode:'mulitply'">
    </header>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
