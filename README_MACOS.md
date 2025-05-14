# Teste de Desenvolvimento

## ✅ Projeto

- `https://projetofluentpdo.test` → **Usando FluentPDO**

---

## ✅ Tecnologias e Ferramentas

| Seção           | Tecnologias Usadas                                                     |
|----------------|------------------------------------------------------------------------|
| **Backend**    | PHP 8.1 (sem framework), MySQL/MariaDB, Composer                       |
| **Frontend**   | HTML5, CSS (Flexbox), JavaScript, jQuery                               |
| **API REST**   | JSON, HTTP Status Codes, Autenticação com Token                        |
| **DevOps**     | Docker, Docker Compose, Nginx, Certificados SSL                        |
| **Segurança**  | CSRF Token, HTTPS, Validações, Sanitização, password_hash e Rate Limit |

---

## 🚀 Instalação do Projeto (macOS)

### 1. 📥 Clonar o repositório

Abra o Terminal e rode:

```bash
git clone https://github.com/elciomgdf/projetofluentpdo.git
cd projetofluentpdo
```

### 2. 🐳 Instale o Docker Desktop para macOS

- Acesse: [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)
- Baixe a versão para Mac e siga a instalação padrão

### 3. 🔐 Gere os certificados SSL

Dê permissão e execute o script:

```bash
chmod +x ./gerar_certificados_ssl.sh
./gerar_certificados_ssl.sh
```

> Isso criará os arquivos `cert.pem` e `key.pem` em `./docker/ssl`.

### 4. 🧠 Configure o arquivo de hosts

Edite o arquivo `/etc/hosts`:

```bash
sudo nano /etc/hosts
```

Adicione ao final:

```
127.0.0.1 projetofluentpdo.test
```

### 5. ✅ Instale o certificado no macOS

1. Abra o app **Acesso às Chaves** (Keychain Access)
2. Vá em “Sistema” → clique com o botão direito em uma área vazia → **Importar**
3. Selecione o arquivo `cert.pem` e importe
4. Clique duas vezes no certificado → **Confiar sempre**
5. Feche e insira sua senha de administrador
6. Reinicie o navegador

### 6. ⚙️ Suba os containers

```bash
docker-compose up -d --build
```

### 7. 📦 Instale dependências PHP e configure o banco

```bash
docker exec -it nome_do_container_php bash
composer install
php database/create_database.php
```

---

## ✅ Acesso ao Projeto

Acesse no navegador: [https://projetofluentpdo.test](https://projetofluentpdo.test)

---

## ✅ Estrutura do Sistema

### Tabelas Criadas (SQL manual)

- `users`
- `tasks`
- `task_categories`
- `user_sessions`
- `user_tokens`

---

## ✅ Funcionalidades Implementadas

### Autenticação

- Login, registro, recuperação de senha, logout
- Proteção por sessão e JWT com rate limiting

### Funcionalidades Gerais

- CRUD completo de tarefas e categorias
- Edição de perfil
- Documentação via Swagger
- Mailhog para testes de e-mail

---

## ✅ API REST

### Autenticação

- `POST /api/sign-up`
- `POST /api/auth/login`
- `POST /api/recover-password`
- `POST /api/auth/logout`

### Usuários

- `GET /api/user/{id}`
- `PUT /api/user/{id}/update`
- `GET /api/user/search`

### Categorias

- `GET /api/categories`
- `GET /api/category/{id}`
- `GET /api/category/search`
- `POST /api/category/create`
- `PUT /api/category/{id}/update`
- `DELETE /api/category/{id}/delete`

### Tarefas

- `GET /api/task/{id}`
- `GET /api/task/search`
- `POST /api/task/create`
- `PUT /api/task/{id}/update`
- `DELETE /api/task/{id}/delete`

> Documentação: `docs/openapi.yaml`  
> URL: http://localhost:8082/

---

## ✅ Segurança Implementada

| Item                      | Implementado |
|---------------------------|--------------|
| password_hash             | ✅ |
| CSRF Tokens               | ✅ |
| SQL Injection Prevention  | ✅ |
| XSS Protection            | ✅ |
| Validações (Front + Back) | ✅ |
| HTTPS Forçado             | ✅ |
| Headers de Segurança      | ✅ |
| Rate Limiting             | ✅ |
| Sessão e Tokens JWT       | ✅ |

---

## ✅ Docker e Domínios

- Dockerfile + docker-compose.yml + .env
- Serviços: PHP, Nginx, MariaDB, Mailhog, SwaggerUI

Domínios locais:

```
127.0.0.1 projetofluentpdo.test
127.0.0.1 projetomedoo.test
```

---

## ✅ Estrutura dos Diretórios

```
/projetofluentpdo
├── app
│   ├── Constants
│   ├── Controllers
│   ├── Core
│   ├── Exceptions
│   ├── Helpers
│   ├── Interfaces
│   ├── Middlewares
│   ├── Models
│   ├── Services
│   ├── Traits
│   └── Validators
├── database
├── docker
├── docs
├── public
├── routes
├── vendor
└── views
```

### Explicações

- **app/**: código de negócio, MVC leve
- **docker/**: configs para nginx, ssl, banco, etc
- **docs/**: documentação OpenAPI
- **public/**: assets acessíveis publicamente
- **views/**: HTML do frontend

---

## ✅ Decisões de Arquitetura

- Estrutura clara e sem framework
- Separação de responsabilidades por pastas
- Proteção de rotas e URL rewriting
- Uso de boas práticas e código reutilizável
- Front com Bootstrap e Flexbox