document.addEventListener('DOMContentLoaded', function () {
    const senhaInput = document.getElementById('senha');
    const toggleSenha = document.getElementById('toggleSenha');
    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const emailInput = document.getElementById('email');

    toggleSenha.addEventListener('click', function () {
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            toggleSenha.textContent = 'Ocultar';
        } else {
            senhaInput.type = 'password';
            toggleSenha.textContent = 'Mostrar';
        }
    });

    cpfInput.addEventListener('input', function () {
        let value = cpfInput.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        cpfInput.value = value;

        if (!validarCPF(cpfInput.value)) {
            mostrarErro(cpfInput, 'CPF inválido.');
        } else {
            removerErro(cpfInput);
        }
    });

    telefoneInput.addEventListener('input', function () {
        let value = telefoneInput.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        telefoneInput.value = value;
    });

    emailInput.addEventListener('input', function () {
        const email = this.value;
        if (!validarEmail(email)) {
            mostrarErro(this, 'Email inválido.');
        } else {
            removerErro(this);
        }
    });

    senhaInput.addEventListener('input', function () {
        const senha = this.value;
        if (!validarSenha(senha)) {
            mostrarErroSenha(this, 'A senha deve ter pelo menos 8 caracteres.');
        } else {
            removeErroSenha(this);
        }
    });
});

// Funções de validação
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf))
        return false;
    
    let soma = 0, resto;
    for (let i = 1; i <= 9; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
    resto = (soma * 10) % 11;

    if (resto === 10 || resto === 11)
        resto = 0;
    
    if (resto !== parseInt(cpf.substring(9, 10)))
        return false;

    soma = 0;
    for (let i = 1; i <= 10; i++) 
        soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
    resto = (soma * 10) % 11;
    
    if (resto === 10 || resto === 11)
        resto = 0;
    
    if (resto !== parseInt(cpf.substring(10, 11))) 
        return false;
    return true;
}

function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validarSenha(senha) {
    return senha.length >= 8;
}

function mostrarErro(input, mensagem) {
    let erro = input.nextElementSibling;
    if (!erro || !erro.classList.contains('erro')) {
        erro = document.createElement('div');
        erro.classList.add('erro');
        input.parentNode.insertBefore(erro, input.nextSibling);
    }
    erro.textContent = mensagem;
}

function mostrarErroSenha(input, mensagem) {
    let erro = input.parentNode.nextElementSibling;
    erro.textContent = mensagem;
}

function removeErroSenha(input) {
    let erro = input.parentNode.nextElementSibling;
    if (erro && erro.classList.contains('erro')) {
        erro.remove();
    } 
}

function removerErro(input) {
    let erro = input.nextElementSibling;
    if (erro && erro.classList.contains('erro')) {
        erro.remove();
    }
}