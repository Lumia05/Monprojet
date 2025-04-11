<!DOCTYPE html>
<html>
    <head>
        <title>Employee Badge</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; }
            .badge { border: 2px solid #f97316; padding: 20px; max-width: 300px; margin: 0 auto; border-radius: 10px; }
            .badge img.profile { width: 100px; height: 100px; border-radius: 50%; }
            .badge img.qr-code { width: 200px; height: 200px; }
            .badge h2 { color: #f97316; margin: 10px 0; }
            .badge p { margin: 5px 0; color: #333; }
        </style>
    </head>
    <body>
        <div class="badge">
            @if ($user->profil)
                <img src="http://localhost:8000/{{ $user->profil}}" alt="Profile Photo" class="profile">
            @else
                <img src="https://via.placeholder.com/100" alt="Placeholder" class="profile">
            @endif
            <h2>{{ $user->name }} {{ $user->prenom }}</h2>
            <p>{{ $user->poste }}</p>
            {{-- <p>Code: {{ $user->employee_code }}</p> --}}
            <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" alt="QR Code" class="qr-code">
        </div>
    </body>
</html>