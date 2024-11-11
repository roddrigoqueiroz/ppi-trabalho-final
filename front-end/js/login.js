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

// function enviaForm() {
//   let xhr = new XMLHttpRequest();
  
//   // O formulário será enviado como um objeto FormData
//   // A requisição deve utilizar o método POST
//   xhr.open("POST", "../../back-end/acesso/login.php");
//   xhr.onload = function () {
//     // verifica o código de status retornado pelo servidor
//     if (xhr.status != 200) {
//       console.error("Falha inesperada: " + xhr.responseText);
//       return;
//     }

//     // converte a string JSON para objeto JS
//     try {
//       var response = JSON.parse(xhr.responseText);
//     }
//     catch (e) {
//       console.error("String JSON inválida: " + xhr.responseText);
//       return;
//     }

//     // utiliza os dados da resposta
//     if (response.success)
//       window.location = response.detail;
//     else {
//       document.querySelector("#loginFailMsg").style.display = 'block';
//       form.senha.value = "";
//       form.senha.focus();
//     }
//   }

//   xhr.onerror = function () {
//     console.error("Erro de rede - requisição não finalizada");
//   };

//   // envia o formulário de login utilizando a interface FormData
//   const form = document.querySelector("form");
//   xhr.send(new FormData(form));
// }

async function login(event) {
  event.preventDefault();

  const formData = new FormData(event.target);
  let data = {};
  for (let [key, value] of formData.entries()) {
    data[key] = value;
    console.log(key, value);
  }

  try {
    const response = await fetch("../../back-end/acesso/login.php", {
      method: "POST",
      body: JSON.stringify(data)
    });

    if (!response.ok) {
      throw new Error("Falha inesperada: " + response.statusText);
    }

    const responseData = await response.json();

    if (responseData.success)
      window.location.assign(responseData.redirect);
    else {console.log("Errou a senha!")
      const div = document.querySelector('.erro');
      div.textContent = responseData.message;
    }
  } catch (error) {
    console.error("Erro: ", error);
  }
}

window.onload = () => {
  const form = document.getElementById('login-form');
  form.addEventListener('submit', event => login(event));
}