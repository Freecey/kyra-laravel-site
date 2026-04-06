<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; background: #050d12; color: #e2e8f0; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 0 auto; padding: 32px 16px; }
  .header { border-bottom: 2px solid #00c8ff; padding-bottom: 16px; margin-bottom: 24px; }
  .header h1 { color: #00c8ff; font-size: 22px; margin: 0; letter-spacing: 2px; text-transform: uppercase; }
  .success-box { background: #0d1f2d; border: 1px solid #00c8ff33; border-left: 4px solid #00c8ff; border-radius: 4px; padding: 16px; margin: 24px 0; font-size: 14px; line-height: 1.6; }
  .cta { text-align: center; margin: 32px 0; }
  .cta a { background: #00c8ff; color: #050d12; font-weight: bold; padding: 12px 32px; border-radius: 4px; text-decoration: none; font-size: 15px; letter-spacing: 1px; text-transform: uppercase; }
  .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #1e3a4a; font-size: 11px; color: #4a6a7a; text-align: center; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>&#x2022; KYRA — Compte approuvé</h1>
  </div>

  <p style="margin-bottom:16px;">Bonjour <strong>{{ $user->name }}</strong>,</p>

  <div class="success-box">
    Votre compte a été approuvé par l'équipe KYRA. Vous pouvez maintenant vous connecter.
  </div>

  <div class="cta">
    <a href="{{ url('/member/login') }}">Se connecter</a>
  </div>

  <div class="footer">
    Si vous avez des questions, répondez à cet email.
  </div>
</div>
</body>
</html>
