        </div>
    </main>

    <script>
    function toggleSenha(idInput, btn) {
        const input = document.getElementById(idInput);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
        }
    }
    </script>
    
</body>
</html>