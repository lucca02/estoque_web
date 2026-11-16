        </div> <!-- Fecha a div page-content -->
    </main> <!-- Fecha a main-content -->

    <script>
    function toggleSenha(idInput, btn) {
        const input = document.getElementById(idInput);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>'; // Olho cortado
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>'; // Olho aberto
        }
    }
    </script>
    
</body>
</html>