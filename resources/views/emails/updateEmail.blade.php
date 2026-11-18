<!DOCTYPE html>
<html>
<head>
    <title>Information de connexion modifié pour: {{ session('nomupdate') }} !</title>
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
        <p>Vos informations on été modifiés, voici vos nouvelles informations de connexion:</p>
        <p><b>Email: </b> {{ session('emailupdate') }} </p>
        <p><b>Password: </b> {{ session('passwordupdate') }} </p>
    </div>
</body>
</html>