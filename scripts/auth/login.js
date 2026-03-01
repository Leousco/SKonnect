// Toggle password visibility
document.getElementById('togglePw').addEventListener('click', function () {
    const pw = document.getElementById('password');
    pw.type = pw.type === 'password' ? 'text' : 'password';
});