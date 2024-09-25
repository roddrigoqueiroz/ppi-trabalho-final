// Simular a exclusão de um anúncio
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Tem certeza que deseja excluir este anúncio?')) {
            alert('Anúncio excluído com sucesso!');
            // Aqui você pode adicionar lógica de exclusão real quando estiver conectado ao backend
        }
    });
});
