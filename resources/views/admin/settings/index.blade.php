@extends('admin.layout')

@section('topbar-title', 'Paramètres')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}">
  @csrf @method('PUT')

  {{-- SERVEUR MAIL --}}
  <div class="card">
    <div class="card-header">
      <h2>&#x2699; Serveur mail</h2>
      <span style="font-size:11px; color:var(--text-muted);">ISPConfig local : smtp • 127.0.0.1 • port 25 • sans auth • sans chiffrement</span>
    </div>
    <div class="card-body">
      @php
        $mailMailer     = $settings['mail_mailer'] ?? null;
        $mailHost       = $settings['mail_host'] ?? null;
        $mailPort       = $settings['mail_port'] ?? null;
        $mailUsername   = $settings['mail_username'] ?? null;
        $mailEncryption = $settings['mail_encryption'] ?? null;
        $mailFromAddr   = $settings['mail_from_address'] ?? null;
        $mailFromName   = $settings['mail_from_name'] ?? null;
      @endphp

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
          <label class="form-label" for="mail_mailer">Protocole *</label>
          <select id="mail_mailer" name="settings[mail_mailer]" class="form-control">
            @foreach(['smtp' => 'SMTP', 'sendmail' => 'Sendmail (local)', 'log' => 'Log (test)'] as $val => $label)
              <option value="{{ $val }}" {{ old('settings.mail_mailer', $mailMailer?->value) === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
          <p class="form-hint">Pour ISPConfig : <code style="color:var(--cyan)">smtp</code></p>
        </div>
        <div class="form-group">
          <label class="form-label" for="mail_encryption">Chiffrement</label>
          <select id="mail_encryption" name="settings[mail_encryption]" class="form-control">
            @foreach(['' => 'Aucun (localhost port 25)', 'tls' => 'TLS (port 587)', 'ssl' => 'SSL (port 465)'] as $val => $label)
              <option value="{{ $val }}" {{ old('settings.mail_encryption', $mailEncryption?->value ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">
        <div class="form-group">
          <label class="form-label" for="mail_host">Hôte SMTP *</label>
          <input type="text" id="mail_host" name="settings[mail_host]"
                 class="form-control {{ $errors->has('settings.mail_host') ? 'is-invalid' : '' }}"
                 value="{{ old('settings.mail_host', $mailHost?->value) }}" required>
          @error('settings.mail_host')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="mail_port">Port *</label>
          <input type="number" id="mail_port" name="settings[mail_port]"
                 class="form-control" min="1" max="65535"
                 value="{{ old('settings.mail_port', $mailPort?->value) }}" required>
        </div>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
          <label class="form-label" for="mail_username">Utilisateur SMTP</label>
          <input type="text" id="mail_username" name="settings[mail_username]"
                 class="form-control" autocomplete="off"
                 value="{{ old('settings.mail_username', $mailUsername?->value) }}">
          <p class="form-hint">Vide si serveur local sans auth</p>
        </div>
        <div class="form-group">
          <label class="form-label" for="mail_password">Mot de passe SMTP</label>
          <input type="password" id="mail_password" name="settings[mail_password]"
                 class="form-control" autocomplete="new-password"
                 placeholder="{{ $settings['mail_password']?->value ? '•••••••• (défini)' : 'Vide si serveur local' }}">
          <p class="form-hint">Laisser vide pour conserver le mot de passe actuel</p>
        </div>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
          <label class="form-label" for="mail_from_address">Adresse expéditeur *</label>
          <input type="email" id="mail_from_address" name="settings[mail_from_address]"
                 class="form-control {{ $errors->has('settings.mail_from_address') ? 'is-invalid' : '' }}"
                 value="{{ old('settings.mail_from_address', $mailFromAddr?->value) }}" required>
          @error('settings.mail_from_address')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="mail_from_name">Nom expéditeur *</label>
          <input type="text" id="mail_from_name" name="settings[mail_from_name]"
                 class="form-control"
                 value="{{ old('settings.mail_from_name', $mailFromName?->value) }}" required>
        </div>
      </div>
    </div>
  </div>

  {{-- NOTIFICATIONS --}}
  <div class="card">
    <div class="card-header">
      <h2>&#x2699; Notifications</h2>
    </div>
    <div class="card-body">
      @php
        $mailTo  = $settings['mail_to'] ?? null;
        $mailCc  = $settings['mail_cc'] ?? null;
        $subject = $settings['notification_subject'] ?? null;
      @endphp

      <div class="form-group">
        <label class="form-label" for="mail_to">Adresse de réception des notifications *</label>
        <input type="email" id="mail_to" name="settings[mail_to]"
               class="form-control {{ $errors->has('settings.mail_to') ? 'is-invalid' : '' }}"
               value="{{ old('settings.mail_to', $mailTo?->value) }}" required>
        @error('settings.mail_to')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="mail_cc">CC (optionnel)</label>
        <input type="email" id="mail_cc" name="settings[mail_cc]"
               class="form-control {{ $errors->has('settings.mail_cc') ? 'is-invalid' : '' }}"
               value="{{ old('settings.mail_cc', $mailCc?->value) }}">
        @error('settings.mail_cc')<div class="form-error">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="notification_subject">Préfixe objet des emails</label>
        <input type="text" id="notification_subject" name="settings[notification_subject]"
               class="form-control"
               value="{{ old('settings.notification_subject', $subject?->value) }}" required>
        <p class="form-hint">Ex : [KYRA] → l’objet sera « [KYRA] : Votre sujet »</p>
      </div>
    </div>
  </div>

  {{-- FORMULAIRE --}}
  <div class="card">
    <div class="card-header">
      <h2>&#x2699; Formulaire de contact</h2>
    </div>
    <div class="card-body">
      @php
        $formEnabled = $settings['form_enabled'] ?? null;
        $successMsg  = $settings['form_success_message'] ?? null;
      @endphp

      <div class="form-group">
        <div class="form-check">
          <input type="checkbox" id="form_enabled" name="settings[form_enabled]" value="1"
                 {{ ($formEnabled?->value ?? '1') == '1' ? 'checked' : '' }}>
          <label for="form_enabled">Activer le formulaire de contact</label>
        </div>
        <p class="form-hint" style="margin-top: 8px;">Si désactivé, les visiteurs verront un message d’indisponibilité temporaire.</p>
      </div>

      <div class="form-group">
        <label class="form-label" for="form_success_message">Message de succès après envoi</label>
        <textarea id="form_success_message" name="settings[form_success_message]"
                  class="form-control" rows="3" required>{{ old('settings.form_success_message', $successMsg?->value) }}</textarea>
      </div>
    </div>
  </div>

  <div style="text-align: right;">
    <button type="submit" class="btn btn-primary">Sauvegarder les paramètres</button>
  </div>
</form>
@endsection
