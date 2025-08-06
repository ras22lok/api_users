# API RESTful com CodeIgniter 3

Esta API permite criar, listar, visualizar, atualizar e deletar usuários, retornando respostas em JSON.

## 🚀 Tecnologias

- PHP 7+
- CodeIgniter 3
- MySQL
- JWT

## 📦 Instalação

1. Clone o repositório:
   ```bash
   - git clone https://github.com/ras22lok/api_users.git

Importe o banco de dados MySQL com o arquivo schema.sql.
    - 

Configure /application/config/database.php com suas credenciais.

🔐 Endpoints
Método	Rota	Descrição
POST	  /api/v1/login	Gerar token
GET	    /api/v1/users	Listar todos os usuários
GET	    /api/v1/users/{id}	Detalhes de um usuário
POST	  /api/v1/users	Criar novo usuário
PUT	    /api/v1/users/{id}	Atualizar usuário existente
DELETE	/api/v1/users/{id}	Deletar usuário

Exemplo POST
json
Copiar
Editar
{
  "name": "João",
  "email": "joao@email.com",
  "password": "senha123"
}

🔒 Segurança
Senhas são criptografadas com password_hash.

Validação de entrada no controller.

Incluir JWT para autenticação.