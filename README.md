# Estoq+ | Sistema de Controle de Estoque

O **Estoq+** é um sistema web completo para gestão de estoque de pequenas e médias empresas, desenvolvido como projeto interdisciplinar. O sistema permite o gerenciamento de produtos, categorias, movimentações (entradas e saídas) e o perfil do usuário.

## Tecnologias Utilizadas
* **Back-end:** PHP 8+
* **Banco de Dados:** MySQL (via XAMPP/MariaDB)
* **Front-end:** HTML5, CSS3 (Design responsivo), JavaScript (Básico)
* **Ícones:** FontAwesome

## Funcionalidades Principais
- **Autenticação:** Login seguro com opção "Manter-me conectado" via Cookies e sistema de cadastro de novos usuários.
- **Gestão de Produtos:** Cadastro, listagem, edição e exclusão (CRUD completo) com controle de estoque.
- **Gestão de Categorias:** Organização dos produtos por categorias com proteção de integridade referencial.
- **Movimentações:** Registro de Entradas e Saídas com histórico detalhado.
- **Triggers no Banco de Dados:** Atualização automática de estoque (soma/subtração) e bloqueio de saídas maiores que a quantidade disponível.
- **Perfil do Usuário:** Edição de dados pessoais, alteração de senha e visualização de saldo (com botão de ocultar/mostrar).

## Como executar o projeto localmente
1. Instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html).
2. Inicie os serviços **Apache** e **MySQL** no painel do XAMPP.
3. Clone este repositório dentro da pasta `htdocs` do XAMPP (ex: `C:\xampp\htdocs\estoque_web`).
4. Abra o phpMyAdmin (`http://localhost/phpmyadmin`), crie um banco chamado `controle_estoque` e importe o arquivo `controle_estoque.sql` (disponível neste repositório).
5. Acesse no navegador: `http://localhost/estoque_web/login.php`

## Credenciais de Teste
* **E-mail:** ana.souza@estoque.com
* **Senha:** Ana@123

---
*Desenvolvido como projeto acadêmico interdisciplinar.*