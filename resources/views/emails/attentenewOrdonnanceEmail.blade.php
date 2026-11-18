<!DOCTYPE html>
<html>
<head>
    <title>Nos salutations {{ session('nom') }} !</title>
    <style>
        /* Styles CSS pour le mail */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        p {
            color: #555;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Vous n'avez pas encore de comprimé à prendre.</p>
        <p>Le traitement de vos examens sont encore en cours.</p>
    </div>
</body>
</html>