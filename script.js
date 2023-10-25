function openModal(){
    const modal = document.getElementById('modal-window')
    modal.classList.add('open')

    modal.addEventListener('click', (e) => {
        if(e.target.id == 'close-modal'){
            modal.classList.remove('open')
        }
    })
}
