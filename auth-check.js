(async function() {
    const res = await fetch('api/user_auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'check' })
    });
    const data = await res.json();
    if (!data.success) {
        window.location.href = 'auth.php';
    } else {
        // Optional: Update UI with username
        const userDisplay = document.querySelector('.user-name');
        if (userDisplay) userDisplay.innerText = data.username;
    }
})();

window.logout = async function() {
    await fetch('api/user_auth.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'logout' })
    });
    window.location.href = 'auth.php';
};
