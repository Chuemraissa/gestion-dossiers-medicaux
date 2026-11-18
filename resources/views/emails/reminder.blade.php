<!DOCTYPE html>
<html>
<head>
    <title>Rappel de rendez-vous</title>
</head>
<body>
    <h1>Bonjour {{ $patientName }}</h1>
    <p>Ceci est un rappel pour votre rendez-vous prévu le {{ $appointmentDate }} à {{ $appointmentTime }} avec le médecin {{ $medecinName }}.</p>
    <p>Merci,</p>
    <p>L'équipe de la clinique.</p>
</body>
</html>
