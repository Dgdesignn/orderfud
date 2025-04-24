function openModal(text) {
    document.getElementById("productModal").style.display = "block";
    const modal = document.getElementById("productModal")
    modal.querySelector('h2').textContent = text
}

function openModal(data){
    document.getElementById("productModal").style.display = "flex";
    const modal = document.getElementById("productModal")
    modal.querySelector('h2').textContent = data
    if((data.produto!== undefined)){
        const formulario = document.querySelector('#form-produto')
        const input = formulario.querySelectorAll('input')
        const btnEditar = formulario.querySelector('button')

        btnEditar.setAttribute('name','editarProduto')
        btnEditar.textContent = 'Editar'
        input[0].value=data.nome
        input[1].value=data.idProduto
        input[2].value=data.preco
       
    }
    
}

function closeModal() {
    document.getElementById("productModal").style.display = "none";
}

window.onclick = function(event) {
    var modal = document.getElementById("productModal");
    if (event.target == modal) {
        closeModal();
    }
};