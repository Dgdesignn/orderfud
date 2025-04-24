const profile  = document.querySelector('.profile-photo')
const imgprofile  = document.querySelector('.imgprofile')
const preview  = document.querySelector('.imgpreview')

profile.addEventListener('click',()=>{
    imgprofile.click()
    imgprofile.addEventListener('change',function(event){
        const file = event.target.files[0]
        const reader = new FileReader()
        reader.onload = function(e){
            preview.src =e.target.result
        }
        reader.readAsDataURL(file)
    })
})


function openModal(data){
    document.getElementById("employeeModal").style.display = "flex";
    const modal = document.getElementById("employeeModal")
    modal.querySelector('h2').textContent = data
    if((data.nome!== undefined)){
        const formulario = document.querySelector('#employeeForm')
        const input = formulario.querySelectorAll('input')
        const btnEditar = formulario.querySelector('button')

        btnEditar.setAttribute('name','editarFuncionario')
        btnEditar.textContent = 'Editar'
        input[1].value=data.nome
        input[2].value=data.telefone
        input[4].value = data.idFuncionario
    }
    
}


function closeModal() {
    document.getElementById("employeeModal").style.display = "none";
}
window.onclick = function(event) {
    var modal = document.getElementById("employeeModal");
    if (event.target == modal) {
        closeModal();
    }
};