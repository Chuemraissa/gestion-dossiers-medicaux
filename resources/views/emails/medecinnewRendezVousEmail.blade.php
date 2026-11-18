<!DOCTYPE html>
<html>
<head>
    <title>Rendez-vous pour {{ session('patient') }} !</title>
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
        <p>Votre rendez-vous avec le patient {{ session('patient') }} est {{ session('statut') }} pour le {{ session('date') }} à {{ session('heure') }}.</p>
    </div>
</body>
</html>