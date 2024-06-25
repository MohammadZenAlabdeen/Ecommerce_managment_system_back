window.onload = function() {
    let menu = document.querySelector('.icon');
    let open = false;
    let body=document.querySelector('body')
    let sidebar = document.querySelector('.sidebar');
    let cross=document.querySelector('.cross');

    menu.addEventListener('click', () => {
        open = true;
        sidebar.classList.add('open')
        body.style.overflowY="hidden"
    });
    cross.addEventListener('click',()=>{
        sidebar.classList.remove('open');
        body.style.overflowY='auto'
    })
};