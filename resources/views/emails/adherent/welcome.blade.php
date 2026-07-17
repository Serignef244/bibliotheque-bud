<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenue sur BiblioSmart</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; color: #0f172a; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
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
            <h1>Bienvenue, {{ $adherent->prenom }} ! 🎉</h1>
            
            <p>Votre compte sur BiblioSmart a été créé avec succès. Nous sommes ravis de vous compter parmi nos adhérents.</p>
            <p>Voici vos informations de connexion pour accéder à votre espace adhérent :</p>
            
            <div class="credentials" style="background: #f8fafc; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;">
                <p><strong>Email :</strong> {{ $adherent->email }}</p>
                <p><strong>Mot de passe :</strong> <em>Celui que vous avez choisi lors de l'inscription</em></p>
            </div>

            <p style="text-align: center;">
                Votre numéro de carte d'adhérent est le <strong>{{ $adherent->num_carte }}</strong>.
                Vous pourrez retrouver votre carte au format numérique dans votre espace personnel.
            </p>

            <div class="center" style="text-align: center; margin-top: 30px;">
                <a href="{{ route('login') }}" class="button" style="background: #0f172a; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">
                    Me connecter à mon espace
                </a>
            </div>

            <div class="footer" style="margin-top: 40px; text-align: center; font-size: 14px; color: #64748b;">
                <p>Si vous n'êtes pas à l'origine de cette inscription, veuillez ignorer cet email.</p>
                <p>&copy; {{ date('Y') }} BiblioSmart. Le savoir mérite le meilleur outil.</p>
            </div>
        </div>
    </div>
</body>
</html>
