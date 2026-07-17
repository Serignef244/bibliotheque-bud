<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; padding: 20px; color: #1f2937; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        .content { line-height: 1.6; }
        .credentials { background-color: #f8fafc; padding: 15px; border-radius: 6px; margin: 20px 0; border: 1px solid #e2e8f0; }
        .credentials p { margin: 5px 0; }
        .button { display: inline-block; padding: 12px 24px; background-color: #1e3a8a; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $biblioNom }}</div>
        </div>
        
        <div class="content">
            <h2>Bonjour {{ $user->name }},</h2>
            
            <p>Un compte d'administration a été créé pour vous sur le système de gestion de la {{ $biblioNom }}.</p>
            
            <p>Voici vos identifiants de connexion :</p>
            
            <div class="credentials">
                <p><strong>Email :</strong> {{ $user->email }}</p>
                <p><strong>Mot de passe :</strong> {{ $password }}</p>
            </div>
            
            @if($user->must_change_password)
            <p><em>Note : Pour des raisons de sécurité, il vous sera demandé de modifier ce mot de passe lors de votre première connexion.</em></p>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Accéder à l'application</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
