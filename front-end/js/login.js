document.addEventListener('DOMContentLoaded', function () {
    const senhaInput = document.getElementById('senha');
    const toggleSenha = document.getElementById('toggleSenha');

    toggleSenha.addEventListener('click', function () {
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            toggleSenha.textContent = 'Ocultar';
        } else {
            senhaInput.type = 'password';
            toggleSenha.textContent = 'Mostrar';
        }
    });
});