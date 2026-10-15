<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>No se ha podido enviar la historia</title>
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; background: #f1f5f9; color: #0f172a; font-family: system-ui, sans-serif; }
        main { max-width: 36rem; margin: 1.5rem; padding: 2rem; border-radius: 1.25rem; background: white; box-shadow: 0 20px 50px #0f172a12; }
        h1 { font-size: 1.75rem; line-height: 1.2; }
        p { color: #475569; line-height: 1.7; }
        a { display: inline-block; padding: .85rem 1.25rem; border-radius: .75rem; background: #1e40af; color: white; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <main>
        <p>Error 413 · Archivos demasiado grandes</p>
        <h1>No se ha podido enviar tu historia</h1>
        <p>{{ $message }}</p>
        <p>La sección admite hasta 10 archivos: 10 MB por foto y 50 MB por vídeo. El servidor debe estar configurado para aceptar esos tamaños.</p>
        <a href="{{ route('webclubs.stories.create') }}">Volver a compartir mi historia</a>
    </main>
</body>
</html>
