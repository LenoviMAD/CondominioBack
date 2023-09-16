<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Usuario Creado</title>
</head>
<body>
    {{-- <p>Hola! Se ha efectuado el pago del plan {{ $createAuth->idPlan }}.</p> --}}
    <p>Hola! Se ha efectuado el pago del plan X's.</p>
    <p>Estos son los datos de usuario:</p>
    <ul>
        <li>Correo / Usuario: {{ $email }}</li>
        <li>Clave: {{ $password }}</li>
    </ul>

</body>
</html>