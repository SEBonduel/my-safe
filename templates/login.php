<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>

<body>
    <nav class="navbar">
        <div class="brand">
            Mon coffre-fort
        </div>

        <div class="links">
            <a href="/login">Connexion</a>
            <a href="/register">Inscription</a>
        </div>
    </nav>

    <div class="auth-card">
        <h1>Connexion</h1>

        <?php if (!empty($errors)): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </div>

</body>

</html>


<style>
    * {
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #0f172a, #020617);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #e5e7eb;
    }

    .auth-card {
        width: 100%;
        max-width: 420px;
        background: #020617;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        border: 1px solid #1e293b;
    }

    h1 {
        margin-top: 0;
        text-align: center;
        color: #38bdf8;
        letter-spacing: 1px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #7dd3fc;
        font-size: 14px;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #1e293b;
        background: #020617;
        color: #e5e7eb;
        font-size: 14px;
    }

    input:focus {
        outline: none;
        border-color: #38bdf8;
    }

    button {
        width: 100%;
        margin-top: 10px;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        color: #020617;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(56, 189, 248, 0.4);
    }

    .errors {
        margin-bottom: 16px;
        padding-left: 20px;
        color: #f87171;
    }

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 64px;
        background: #020617;
        border-bottom: 1px solid #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        z-index: 10;
    }

    .navbar .brand {
        color: #38bdf8;
        font-weight: bold;
        font-size: 16px;
        letter-spacing: 1px;
    }

    .navbar .links {
        display: flex;
        gap: 16px;
    }

    .navbar a {
        color: #e5e7eb;
        text-decoration: none;
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s, color 0.2s;
    }

    .navbar a:hover {
        background: rgba(56, 189, 248, 0.1);
        color: #7dd3fc;
    }

    .navbar a.active {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        color: #020617;
        font-weight: bold;
    }
</style>
