<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Création de votre compte</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; color: #0f172a; }
        .container { max-w-lg mx-auto; background-color: #ffffff; margin: 40px auto; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        h1 { color: #0f172a; font-size: 24px; margin-bottom: 20px; text-align: center; }
        p { font-size: 16px; line-height: 1.6; margin-bottom: 20px; color: #475569; }
        .credentials { background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin-bottom: 30px; text-align: center; }
        .credentials p { margin: 10px 0; font-size: 18px; color: #0f172a; }
        .button { display: inline-block; padding: 12px 24px; background-color: #0f172a; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: bold; text-align: center; }
        .center { text-align: center; }
        .footer { margin-top: 40px; text-align: center; font-size: 14px; color: #94a3b8; }
    </style>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div class="container" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <h1>Bienvenue, {{ $adherent->prenom }} !</h1>
            
            <p>Votre compte sur la Bibliothèque Numérique BUD a été créé avec succès.</p>
            <p>Voici vos identifiants temporaires pour accéder à votre espace adhérent :</p>
            
            <div class="credentials" style="background: #f8fafc; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;">
                <p><strong>Email :</strong> {{ $adherent->email }}</p>
                <p><strong>Mot de passe :</strong> <code style="background: #e2e8f0; padding: 4px 8px; border-radius: 4px;">{{ $password }}</code></p>
            </div>

            <p style="text-align: center; color: #e11d48; font-weight: 500;">
                ⚠️ Par mesure de sécurité, il vous sera demandé de modifier ce mot de passe lors de votre première connexion.
            </p>

            <div class="center" style="text-align: center; margin-top: 30px;">
                <a href="{{ route('login') }}" class="button" style="background: #0f172a; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">
                    Me connecter à mon espace
                </a>
            </div>

            <div class="footer" style="margin-top: 40px; text-align: center; font-size: 14px; color: #64748b;">
                <p>Si vous n'avez pas demandé la création de ce compte, veuillez ignorer cet email.</p>
                <p>&copy; {{ date('Y') }} Bibliothèque Universitaire de Dakar.</p>
            </div>
        </div>
    </div>
</body>
</html>
