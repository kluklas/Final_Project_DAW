<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada Disponible</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .header img {
            max-width: 180px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .content a {
            display: inline-block;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            padding: 20px;
            background-color: #f1f1f1;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="header">
        <img src="{{asset('assets/media/jarvis/jarvis-descriptor-verde.svg')}}" alt="Logo de la aplicación">
        <h1>Entrada Disponible</h1>
    </div>

    <div class="content">
        <p>¡Hola!</p>
        <p>Una nueva entrada está disponible para que la revises.</p>
        <p>
            Haz clic en el siguiente botón para ver la entrada:
        </p>
        <p style="text-align: center;">
            <a href="{{ route('rpa.public.edit.entry', $line->code) }}">Ver entrada</a>
        </p>
        <p>Gracias por usar nuestra aplicación.</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Jarvis. Todos los derechos reservados.</p>
    </div>
</div>

</body>
</html>
