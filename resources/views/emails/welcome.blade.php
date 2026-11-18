<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur notre application {{ session('nom') }} !</title>
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
        <p>Pour pouvoir acceder à vos informations de dossier medical vous auriez besoins des informations suivantes pour vous connecter à ça:</p>
        <p><b>Email: </b> {{ session('email') }} </p>
        <p><b>Password: </b> {{ session('password') }} </p>
    </div>
</body>
</html>