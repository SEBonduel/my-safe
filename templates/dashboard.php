
<?php foreach ($secrets as $secret): ?>
    <div>
        <strong><?= htmlspecialchars($secret['title']) ?></strong><br>
        Identifiant : <?= htmlspecialchars($secret['login']) ?><br>
        Mot de passe : <?= htmlspecialchars($secret['password']) ?><br>
        <form method="post" action="/delete-secret">
            <input type="hidden" name="id" value="<?= htmlspecialchars($secret['id']) ?>">
            <button type="submit">Supprimer</button>
        </form>
    </div>
<?php endforeach; ?>

<form method="post" action="/add-secret">
    <a href="/logout.php">Déconnexion</a>
    <input type="text" name="title" required placeholder="Titre">
    <input type="text" name="login" required placeholder="Identifiant">
    <input type="password" name="password" required placeholder="Mot de passe">
    <button type="submit">Ajouter</button>
</form>