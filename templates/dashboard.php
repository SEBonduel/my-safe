<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon coffre-fort</title>
</head>

<body>

<nav class="navbar">
    <div class="brand">
        Mon coffre-fort
    </div>

    <div class="right">
        <div class="user">
            <?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>
        </div>

        <form method="POST" action="/logout" class="logout-form">
            <button type="submit" class="logout-button">
                Déconnexion
            </button>
        </form>
    </div>
</nav>

<div class="dashboard">
    <h1>Mon coffre-fort</h1>

    <div class="form-card">
        <h2>Ajouter un secret</h2>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="title" placeholder="Service (ex: Netflix)" required>
                <input type="text" name="login" placeholder="Identifiant" required>
                <input type="text" name="password" placeholder="Mot de passe" required>
            </div>

            <button type="submit">Ajouter au coffre</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Login</th>
                <th>Mot de passe</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($secrets)): ?>
                <tr>
                    <td colspan="3" class="empty">
                        Aucun secret enregistré
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($secrets as $secret): ?>
                <tr>
                    <td><?= htmlspecialchars($secret['title']) ?></td>
                    <td><?= htmlspecialchars($secret['login']) ?></td>
                    <td>
                        <?php
                        try {
                            echo htmlspecialchars(
                                \App\Utils\Crypto::decrypt(
                                    $secret['encrypted_password'],
                                    hex2bin(\APP_KEY)
                                )
                            );
                        } catch (RuntimeException $e) {
                            echo '<em>Donnée incompatible</em>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
            padding-top: 64px;
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

        .navbar .right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar .user {
            color: #7dd3fc;
            font-size: 14px;
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid #1e293b;
            background: transparent;
            color: #f87171;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
        }

        .logout-button:hover {
            background: rgba(248, 113, 113, 0.1);
            box-shadow: 0 0 0 1px rgba(248, 113, 113, 0.3);
        }

        .dashboard {
            width: 100%;
            max-width: 900px;
            background: #020617;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        }

        h1 {
            margin-top: 0;
            text-align: center;
            color: #38bdf8;
            letter-spacing: 1px;
        }

        .form-card {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .form-card h2 {
            margin-top: 0;
            font-size: 18px;
            color: #7dd3fc;
        }

        .form-group {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group input {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #1e293b;
            background: #020617;
            color: #e5e7eb;
        }

        .form-group input:focus {
            outline: none;
            border-color: #38bdf8;
        }

        button {
            width: 100%;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px;
            color: #7dd3fc;
            border-bottom: 1px solid #1e293b;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #1e293b;
        }

        tr:hover {
            background: rgba(56, 189, 248, 0.05);
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 20px;
        }

        @media (max-width: 700px) {
            .form-group {
                flex-direction: column;
            }
        }
    </style>