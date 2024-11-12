// Simular a exclusão de um anúncio
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Tem certeza que deseja excluir este anúncio?')) {
            alert('Anúncio excluído com sucesso!');
        }
    });
});

window.onload = async function () {
    const response = await fetch('../../back-end/restrito/meus-anuncios.php');
    
    if (!response.ok)
        throw new Error("Falha inesperada: " + response.statusText);

    const data = await response.json();

    if (data.redirect && !data.success) {
        window.location.assign(data.redirect);
        return;
    }

    document.querySelector(".card")
    data.data.forEach(anuncio => createCard(anuncio))
}

function createCard(anuncio) {
    const card = document.createElement('div');
    card.classList.add('card');

    const img = document.createElement('img');
    img.src = `../img/${anuncio.NOME_FOTO}`;
    img.alt = `${anuncio.MARCA} ${anuncio.MODELO}`;
    img.classList.add('card-img');
    card.appendChild(img);

    const cardInfo = document.createElement('div');
    cardInfo.classList.add('card-info');

    const h3 = document.createElement('h3');
    h3.textContent = `${anuncio.MARCA} ${anuncio.MODELO}`;
    cardInfo.appendChild(h3);

    const pAno = document.createElement('p');
    pAno.textContent = `Ano: ${anuncio.ANO}`;
    cardInfo.appendChild(pAno);

    const pCidade = document.createElement('p');
    pCidade.textContent = `Cidade: ${anuncio.CIDADE}`;
    cardInfo.appendChild(pCidade);

    const pValor = document.createElement('p');
    pValor.textContent = `Valor: R$ ${anuncio.VALOR}`;
    cardInfo.appendChild(pValor);

    const cardActions = document.createElement('div');
    cardActions.classList.add('card-actions');

    const detalhesLink = document.createElement('a');
    detalhesLink.href = './detalhes-anuncio.html';
    detalhesLink.classList.add('btn');
    detalhesLink.textContent = 'Ver Detalhes';
    cardActions.appendChild(detalhesLink);

    const interessesLink = document.createElement('a');
    interessesLink.href = './interesses-anuncio.html';
    interessesLink.classList.add('btn');
    interessesLink.textContent = 'Ver Interesses';
    cardActions.appendChild(interessesLink);

    const deleteButton = document.createElement('button');
    deleteButton.classList.add('btn', 'btn-delete');
    deleteButton.textContent = 'Excluir Anúncio';
    deleteButton.addEventListener('click', function () {
        if (confirm('Tem certeza que deseja excluir este anúncio?')) {
            alert('Anúncio excluído com sucesso!');
        }
    });
    cardActions.appendChild(deleteButton);

    cardInfo.appendChild(cardActions);
    card.appendChild(cardInfo);
    document.querySelector(".cards-section").appendChild(card);
}
