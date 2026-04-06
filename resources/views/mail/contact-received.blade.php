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
  .message-body { background: #0d1f2d; border: 1px solid #00c8ff33; border-radius: 4px; padding: 16px; white-space: pre-wrap; font-size: 14px; line-height: 1.6; }
  .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #1e3a4a; font-size: 11px; color: #4a6a7a; text-align: center; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>&#x2022; KYRA — Nouveau message de contact</h1>
  </div>

  <div class="field-label">Nom</div>
  <div class="field-value">{{ $contactMessage->name }}</div>

  <div class="field-label">Email</div>
  <div class="field-value"><a href="mailto:{{ $contactMessage->email }}" style="color:#00c8ff;">{{ $contactMessage->email }}</a></div>

  <div class="field-label">Sujet</div>
  <div class="field-value">{{ $contactMessage->subject }}</div>

  <div class="field-label">Message</div>
  <div class="message-body">{{ $contactMessage->message }}</div>

  <div class="footer">
    Reçu le {{ $contactMessage->created_at->format('d/m/Y à H:i') }} — IP : {{ $contactMessage->ip_address ?? 'inconnue' }}<br>
    <a href="{{ url('/admin/messages/' . $contactMessage->id) }}" style="color:#00c8ff;">Voir dans l'admin</a>
  </div>
</div>
</body>
</html>
