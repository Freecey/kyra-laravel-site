<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; background: #050d12; color: #e2e8f0; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 0 auto; padding: 32px 16px; }
  .header { border-bottom: 2px solid #00c8ff; padding-bottom: 16px; margin-bottom: 24px; }
  .header h1 { color: #00c8ff; font-size: 22px; margin: 0; letter-spacing: 2px; text-transform: uppercase; }
  .field-label { color: #00c8ff; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
  .field-value { background: #0d1f2d; border: 1px solid #1e3a4a; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; font-size: 14px; color: #e2e8f0; }
  .cta { text-align: center; margin: 32px 0; }
  .cta a { background: #00c8ff; color: #050d12; font-weight: bold; padding: 12px 32px; border-radius: 4px; text-decoration: none; font-size: 15px; letter-spacing: 1px; text-transform: uppercase; }
  .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #1e3a4a; font-size: 11px; color: #4a6a7a; text-align: center; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>&#x2022; KYRA — Activation du compte</h1>
  </div>

  <p style="margin-bottom:24px;">Bonjour <strong>{{ $user->name }}</strong>,</p>
  <p>Merci de votre inscription. Pour activer votre compte, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous :</p>

  <div class="cta">
    <a href="{{ $verifyUrl }}">Vérifier mon adresse email</a>
  </div>

  <p style="font-size:13px; color:#4a6a7a;">Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :</p>
  <div class="field-value" style="font-size:12px; word-break:break-all;">
    <a href="{{ $verifyUrl }}" style="color:#00c8ff;">{{ $verifyUrl }}</a>
  </div>

  <div class="footer">
    Ce lien est valable indéfiniment. Si vous n'avez pas créé ce compte, ignorez cet email.
  </div>
</div>
</body>
</html>
