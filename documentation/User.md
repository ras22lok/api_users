# 📘 Documentação da API - UserController (CodeIgniter 3)

## 🔐 Autenticação
Todas as rotas exigem um token JWT válido no header da requisição:

Authorization: Bearer {token}

---

## 📄 Lista todos os usuários

**GET** `/index.php/usercontroller/index`

### Parâmetros de Query (opcionais):

| Parâmetro | Tipo  | Descrição                          |
|-----------|--------|--------------------------------------|
| `limit`   | int    | Quantidade por página (default: 10) |
| `pag`     | int    | Número da página (default: 1)       |
| `search`  | string | Termo de busca (nome/email)         |

### Exemplo de resposta:
```json
{
  "data": [
    {
      "id": 1,
      "name": "João",
      "email": "joao@email.com"
    }
  ],
  "quantidade_total_registros": 100,
  "quantidade_por_pagina": 10,
  "quantidade_paginas": 10
}
```

## 🔍 Visualiza um usuário
**GET** /index.php/usercontroller/show/{id}

Parâmetros:
{id}: ID do usuário a ser visualizado

Exemplo de resposta:

```json
{
  "id": 1,
  "name": "João",
  "email": "joao@email.com"
}
```

Erros:
401 Unauthorized: Token inválido

400 Bad Request: Usuário não encontrado

## ➕ Cria um novo usuário
**POST** /index.php/usercontroller/store

Body (JSON):

```json
{
  "name": "João Silva",
  "email": "joao@email.com",
  "password": "senhaSegura123"
}
```

Regras de Validação:
name: obrigatório, mínimo 3 caracteres

email: obrigatório, válido e único

password: obrigatório, mínimo 8 caracteres

Resposta de sucesso:
201 Created

```json
{ "message": "Usuário criado com sucesso!" }
```

Erros:
400 Bad Request: Campos ausentes ou inválidos

401 Unauthorized: Token inválido

500 Internal Server Error: Erro ao salvar no banco

## ✏️ Atualiza um usuário
**PUT** /index.php/usercontroller/update/{id}

Parâmetros:
{id}: ID do usuário a ser atualizado

Body (JSON):

```json
{
  "name": "Novo Nome",
  "email": "novo@email.com",
  "password": "novasenha123"
}
```

Regras de Validação:
name: se presente, mínimo 3 caracteres

email: se presente, válido e único (exceto para o mesmo ID)

password: se presente, mínimo 8 caracteres

Resposta de sucesso:
201 Created

{ "message": "Usuário atualizado com sucesso" }
Erros:
400 Bad Request: Campos inválidos

401 Unauthorized: Token inválido

500 Internal Server Error: Erro ao atualizar

## 🗑️ Remove um usuário
**DELETE** /index.php/usercontroller/delete/{id}

Parâmetros:
{id}: ID do usuário a ser removido

Resposta de sucesso:
204 No Content

```json
{ "message": "Usuário removido com sucesso!" }
```

Erros:
401 Unauthorized: Token inválido

500 Internal Server Error: Erro ao remover usuário

🧪 Validações
Todas as validações são feitas com a biblioteca form_validation do CodeIgniter. Em caso de erro, o retorno é assim:

```json
{
  "error": {
    "email": "O campo email deve conter um endereço de e-mail válido.",
    "password": "O campo password deve ter no mínimo 8 caracteres."
  }
}
```

🔒 Middleware JWT
Antes de executar qualquer método, o token é validado:

$this->message = (object) validate_token();
Erro de token:

{ "error": "Token inválido" }

---