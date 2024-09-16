<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tarea de alta prioridad</title>
</head>
<body>
    <h1>Hola, {{ $userName }}</h1>
    <p>Tienes una tarea de alta prioridad.</p>
    <p><strong>Título:</strong> {{ $taskTitle }}</p>
    <p><strong>Descripción:</strong> {{ $taskDescription }}</p>
    <p><strong>Fecha de vencimiento:</strong> {{ $dueDate }}</p>
    <p>Por favor, revisa y completa esta tarea lo antes posible.</p>
</body>
</html>
