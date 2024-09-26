document.addEventListener('DOMContentLoaded', function () {
    const telefoneInput = document.getElementById('telefone');
    
    telefoneInput.addEventListener('input', function () {
        let value = telefoneInput.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        telefoneInput.value = value;
    });
});