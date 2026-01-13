document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');

    if (!passwordInput) {
        return;
    }

    passwordInput.addEventListener('input', function () {
        const value = passwordInput.value;
        let score = 0;

        if (value.length >= 8) score++;
        if (/[a-z]/.test(value)) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;

        if (value.length === 0) {
            bar.style.width = '0%';
            text.textContent = '';
            return;
        }

        if (score <= 2) {
            bar.style.width = '33%';
            bar.style.background = '#ef4444';
            text.textContent = 'Mot de passe faible';
        } else if (score <= 4) {
            bar.style.width = '66%';
            bar.style.background = '#f59e0b';
            text.textContent = 'Mot de passe moyen';
        } else {
            bar.style.width = '100%';
            bar.style.background = '#22c55e';
            text.textContent = 'Mot de passe fort';
        }
    });
});
