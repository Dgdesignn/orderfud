function openModal(text) {
    document.getElementById("categoryModal").style.display = "flex";
    const modal = document.getElementById("categoryModal")
    modal.querySelector('h2').textContent = text
}

function openModal(data) {
    
    document.getElementById("categoryModal").style.display = "flex";
    const modal = document.getElementById("categoryModal")
    modal.querySelector('h2').textContent = data
    if((data.categoria!== undefined)){
        const formulario = document.querySelector('#form-categoria')
        const input = formulario.querySelectorAll('input')
        const btnEditar = formulario.querySelector('button')

        btnEditar.setAttribute('name','editarCategoria')
        btnEditar.textContent = 'Editar'
        input[1].value=data.categoria
        input[2].value=data.idCategoria

        
         
       
    }
    
}


function closeModal() {
    document.getElementById("categoryModal").style.display = "none";
}

window.onclick = function(event) {
    var modal = document.getElementById("categoryModal");
    if (event.target == modal) {
        closeModal();
    }
};