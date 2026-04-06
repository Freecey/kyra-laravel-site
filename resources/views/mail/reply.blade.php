<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; background: #f4f6f8; color: #1a202c; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 0 auto; padding: 32px 16px; }
  .header { border-bottom: 2px solid #00c8ff; padding-bottom: 16px; margin-bottom: 24px; }
  .header h1 { color: #00c8ff; font-size: 20px; margin: 0; letter-spacing: 1px; text-transform: uppercase; }
  .body-text { background: #ffffff; border: 1px solid #d1dce5; border-radius: 4px; padding: 20px; margin-bottom: 20px; font-size: 14px; line-height: 1.7; white-space: pre-wrap; }
  .context-box { background: #eef4f8; border-left: 3px solid #00c8ff; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #4a5568; }
  .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #d1dce5; font-size: 11px; color: #718096; text-align: center; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>&#x2022; KYRA — Réponse à votre message</h1>
  </div>

  <p style="font-size:14px; margin-bottom:20px;">Bonjour {{ $contact->name }},</p>

  <div class="body-text">{{ $reply->body }}</div>

  <div class="context-box">
    <strong>Votre message d'origine :</strong><br>
    <em>Sujet : {{ $contact->subject }}</em><br><br>
    {{ $contact->message }}
  </div>

  @if($reply->attachments->isNotEmpty())
  <p style="font-size:13px; color:#4a5568;">
    {{ $reply->attachments->count() }} pièce(s) jointe(s) incluse(s) dans cet email.
  </p>
  @endif

  <div class="footer">
    KYRA — <a href="{{ url('/contact') }}" style="color:#00c8ff;">imkyra.be</a>
  </div>
</div>
</body>
</html>
