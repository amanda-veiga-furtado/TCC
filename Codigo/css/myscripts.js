function showLogin() {
    document.getElementById('loginForm').style.display = 'block'; // Mostra o formulário de login -->
    document.getElementById('signupForm').style.display = 'none'; // Esconde o formulário de cadastro 
    document.getElementById('toggleLine').style.transform = 'translateX(0)'; // Move a linha indicadora para a posição do login
}

function showSignup() {
    document.getElementById('loginForm').style.display = 'none'; // Esconde o formulário de login -->
    document.getElementById('signupForm').style.display = 'block'; // Mostra o formulário de cadastro 
    document.getElementById('toggleLine').style.transform = 'translateX(100%)'; // Move a linha indicadora para a posição do cadastro
    
}