<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>KYRA — Admin Login</title>
<link rel="icon" href="/favicon.ico" sizes="any">
<style>
  :root {
    --cyan: #00c8ff;
    --cyan-dim: #00c8ff22;
    --bg: #050d12;
    --bg-panel: #0a1a24;
    --bg-card: #0d1f2d;
    --border: #1e3a4a;
    --text: #c8d8e0;
    --text-muted: #4a6a7a;
    --danger: #ff4466;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Rajdhani','Share Tech Mono',monospace;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  body::after {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,200,255,0.01) 2px, rgba(0,200,255,0.01) 4px);
    pointer-events: none;
    z-index: 9999;
  }
  .login-box {
    width: 100%;
    max-width: 380px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 40px 36px;
  }
  .login-logo {
    text-align: center;
    margin-bottom: 32px;
  }
  .login-logo .title {
    font-family: 'Orbitron', monospace;
    font-size: 28px;
    color: var(--cyan);
    letter-spacing: 8px;
    font-weight: 700;
  }
  .login-logo .sub {
    font-size: 10px;
    color: var(--text-muted);
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-top: 6px;
  }
  .form-group { margin-bottom: 18px; }
  .form-label {
    display: block;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    margin-bottom: 6px;
  }
  .form-control {
    width: 100%;
    background: var(--bg-panel);
    border: 1px solid var(--border);
    border-radius: 3px;
    padding: 10px 14px;
    color: var(--text);
    font-family: inherit;
    font-size: 14px;
    outline: none;
    transition: border-color 0.15s;
  }
  .form-control:focus { border-color: var(--cyan); box-shadow: 0 0 0 2px var(--cyan-dim); }
  .form-control.is-invalid { border-color: var(--danger); }
  .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }
  .btn-login {
    width: 100%;
    padding: 12px;
    background: transparent;
    border: 1px solid var(--cyan);
    color: var(--cyan);
    border-radius: 3px;
    font-family: 'Orbitron', monospace;
    font-size: 12px;
    letter-spacing: 3px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 8px;
  }
  .btn-login:hover { background: var(--cyan); color: var(--bg); }
  .remember-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
  }
  .remember-row input { accent-color: var(--cyan); width: 14px; height: 14px; cursor: pointer; }
  .remember-row label { font-size: 12px; color: var(--text-muted); cursor: pointer; }
</style>
</head>
<body>
<div class="login-box">
  <div class="login-logo">
    <div class="title">KYRA</div>
    <div class="sub">Control Panel</div>
  </div>

  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div class="form-group">
      <label class="form-label" for="email">Email</label>
      <input
        id="email"
        type="email"
        name="email"
        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
        value="{{ old('email') }}"
        autocomplete="email"
        autofocus
        required
      >
      @error('email')
        <div class="form-error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="password">Mot de passe</label>
      <input
        id="password"
        type="password"
        name="password"
        class="form-control"
        autocomplete="current-password"
        required
      >
    </div>

    <div class="remember-row">
      <input type="checkbox" id="remember" name="remember">
      <label for="remember">Se souvenir de moi</label>
    </div>

    <button type="submit" class="btn-login">Connexion</button>
  </form>
</div>
</body>
</html>
