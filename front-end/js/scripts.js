document.addEventListener('DOMContentLoaded', function () {
    const logoffLink = document.querySelector('.nav-login a[href=""]');

    logoffLink.addEventListener('click', async function(event) {
        event.preventDefault();
        
        const response = await fetch('../../back-end/acesso/logout.php');

        if (!response.ok)
            throw new Error("Falha inesperada: " + response.statusText);

        const data = await response.json();

        if (data.redirect && data.success) {
            alert("Deslogado com sucesso!")
            window.location.assign(data.redirect);
            return;
        }
    });
});
