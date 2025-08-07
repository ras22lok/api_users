
## 🔐 Login do Usuário

**POST** `/index.php/auth/login`

Autentica um usuário com email e senha, e retorna um **token JWT** em caso de sucesso.

---

### 📥 Body (JSON)

```json
{
  "email": "usuario@email.com",
  "password": "senha123"
}
```

---

### ✅ Regras de validação

- `email`: obrigatório
- `password`: obrigatório
- A senha será comparada com o hash MD5 armazenado no banco de dados.

---

### 📤 Resposta de Sucesso

**Status:** `200 OK`

```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1..."
}
```

Esse token pode ser usado nas próximas requisições autenticadas, enviado no header como:

```
Authorization: Bearer {token}
```

---

### ❌ Respostas de Erro

| Status | Descrição                          | Exemplo de Resposta                          |
|--------|------------------------------------|----------------------------------------------|
| 400    | E-mail ou senha não enviados       | `{ "error": "E-mail ou password inválida!" }` |
| 401    | E-mail ou senha inválidos          | `{ "error": "E-mail ou password inválida!" }` |

---

### 🔐 Sobre o Token JWT

- **Algoritmo:** HS256
- **Payload inclui:**
  - `id`: ID do usuário
  - `email`: e-mail do usuário
  - `iat`: timestamp de criação
  - `exp`: expiração (1 hora após criação)

---
