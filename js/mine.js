
var btnAbrirPopupLogin = document.getElementById('btn-abrir-popup-login'),
    btnAbrirPopupRegistro = document.getElementById('btn-abrir-popup-resgistro'),
    overlayL = document.getElementById('overlayFormL'),
    overlayR = document.getElementById('overlayFormR'),
    btnCerrarPopupL = document.getElementById('btn-close-popupL');
    btnCerrarPopupR = document.getElementById('btn-close-popupR');
    popupL = document.getElementById('popupLogin');
    popupR = document.getElementById('popupRegistro');

btnAbrirPopupRegistro.addEventListener('click', function(){
    overlayR.classList.add('active')
    popupR.classList.add('active')
});

btnAbrirPopupLogin.addEventListener('click', function(){
    overlayL.classList.add('active')
    popupL.classList.add('active')
});

btnCerrarPopupL.addEventListener('click', function(){
    overlayL.classList.remove('active')
    
});

btnCerrarPopupR.addEventListener('click', function(){
    
    overlayR.classList.remove('active')
});
