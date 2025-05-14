
# Teste de Desenvolvimento

## ✅ Projetos

- `https://projetofluentpdo.test` → **Usando FluentPDO**
- `https://projetomedoo.test` → **Usando Medoo**

Os dois projetos foram desenvolvidos separadamente mas a única diferença é o uso da biblioteca de acesso à base de dados de cada um.

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

## 🔐 Geração e Instalação dos Certificados SSL

### 📥 Geração (Linux ou WSL no Windows)

1. Dê permissão de execução ao script:

    ```bash
    chmod +x ./gerar_certificados_ssl.sh
    ```

2. Execute o script:

    ```bash
    ./gerar_certificados_ssl.sh
    ```

   > Isso criará os arquivos `cert.pem` e `key.pem` dentro de `./docker/ssl`, com um certificado autoassinado válido para `projetofluentpdo.test`.

### 🐧 Instalação no Linux

1. Acesse `https://projetofluentpdo.test` no navegador (pode aparecer como inseguro).
2. Clique no ícone de cadeado (ou “Não seguro”) → **Visualizar certificado** → **Exportar**.
3. Vá até **Configurações do sistema** → **Certificados** → **Autoridades**.
4. Importe o `cert.pem` e marque como **confiável para identificar sites**.
5. Reabra o navegador.

### 🪟 Instalação no Windows (incluindo WSL/Docker Desktop)

1. Clique duas vezes em `cert.pem`.
2. Escolha **Instalar certificado**.
3. Selecione **Máquina Local**.
4. Escolha: **Colocar todos os certificados no repositório a seguir**.
5. Selecione: `Autoridades de Certificação Raiz Confiáveis`.
6. Conclua a instalação e aceite os avisos.
7. Reabra o navegador e acesse `https://projetofluentpdo.test`.

### ✏️ Observações

- Para adicionar outro domínio (como `projetomedoo.test`), edite o script e adicione mais entradas em `[alt_names]`:

    ```ini
    [alt_names]
    DNS.1 = projetofluentpdo.test
    DNS.2 = projetomedoo.test
    ```

- Se estiver usando múltiplos domínios, o mesmo certificado pode ser compartilhado entre os dois projetos no Nginx.

---

## 🚀 Instalação do Projeto

### 1. 📥 Clonar o repositório

```bash
git clone https://github.com/elciomgdf/projetofluentpdo.git
cd projetofluentpdo
```

### 2. 🐳 Instalar o Docker (com suporte a WSL no Windows)

- Windows: [Docker Desktop](https://www.docker.com/products/docker-desktop) + WSL 2
- Linux/Mac: terminal ou gerenciador de pacotes

### 3. 🔐 Gerar Certificados SSL (veja a seção acima)

### 4. 🧠 Configurar o arquivo de hosts

```plaintext
127.0.0.1 projetofluentpdo.test
```

### 5. ⚙️ Subir os containers com Docker Compose

```bash
docker-compose up -d --build
```

### 6. 📦 Instalar dependências PHP com Composer

```bash
docker exec -it nome_do_container_php bash
composer install
```

### 7. 🗃️ Criar o banco de dados

```bash
php database/create_database.php
```

### ✅ Pronto!

Acesse em: [https://projetofluentpdo.test](https://projetofluentpdo.test)

---

## ✅ Estrutura do Sistema

### 📂 Tabelas Criadas (com SQL manual)
- `users`
- `tasks`
- `task_categories`
- `user_sessions`
- `user_tokens`

> Scripts: `database/tables.sql`

---

## ✅ Funcionalidades Implementadas

### 🔐 Autenticação
- Login, registro, recuperação de senha, logout, proteção de rotas (sessão e rate limit)

### 📋 Funcionalidades
- CRUD de Tarefas e Categorias
- Edição de Perfil
- Documentação via Swagger
- Mailhog para simulação de e-mails

---

## ✅ API REST

### 🔐 Autenticação
- POST /api/sign-up
- POST /api/auth/login
- POST /api/recover-password
- POST /api/auth/logout

### 👤 Usuários
- GET /api/user/{id}
- PUT /api/user/{id}/update
- GET /api/user/search

### 🗂️ Categorias
- GET /api/categories
- GET /api/category/{id}
- GET /api/category/search
- POST /api/category/create
- PUT /api/category/{id}/update
- DELETE /api/category/{id}/delete

### ✅ Tarefas
- GET /api/task/{id}
- GET /api/task/search
- POST /api/task/create
- PUT /api/task/{id}/update
- DELETE /api/task/{id}/delete

> Documentação: `docs/openapi.yaml`
> URL: http://localhost:8082/

---

## ✅ Segurança Implementada

| Item                      | Implementado                                                                                         |
|---------------------------|------------------------------------------------------------------------------------------------------|
| password_hash             | ✅                                                                                                   |
| CSRF Tokens               | ✅ Proteção para POST, PUT e DELETE                                                              |
| SQL Injection Prevention  | ✅ bindParam                                                                                         |
| XSS Protection            | ✅ htmlspecialchars no HTML                                                                         |
| Validações no Front       | ✅ HTML5 com campos obrigatórios                                                               |
| Validações no Back        | ✅ Sanitização com strip_tags, verificação de tipos                                         |
| HTTPS forçado             | ✅ via Nginx                                                                                         |
| Cabeçalhos de Segurança   | ✅ HSTS, CSP via Nginx                                                                             |
| Rate Limiting             | ✅ 60 req/IP                                                                                        |
| Sessão                    | ✅ Middleware de sessão com base de dados                                                        |
| Tokens                    | ✅ JWT com revogação por banco                                                                   |

---

## ✅ Docker e Domínios

### 🔧 Configuração Docker
- `Dockerfile`, `docker-compose.yml`, `.env`
- Serviços: PHP 8.1-FPM, Nginx, Mailhog, Mariadb, Swagger UI

### 🌐 Domínios Locais
- `127.0.0.1 projetofluentpdo.test`
- `127.0.0.1 projetomedoo.test`

---

## ✅ Estrutura dos Diretórios

```
/projetofluentpdo
├── app
│   ├── Constants
│   ├── Controllers
│   │   ├── Api
│   │   └── Web
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
│   ├── nginx
│   └── ssl
├── docs
├── public
│   └── assets
├── routes
├── vendor
└── views
```

### 📁 Explicações dos Diretórios

- **app/**: Contém toda a lógica de negócio, controllers, models, middlewares e serviços.
- **database/**: Scripts SQL para criação das tabelas e manipulação do banco.
- **docker/**: Configurações específicas do ambiente Docker, incluindo o Nginx e SSL.
- **docs/**: Documentação da API (OpenAPI / Swagger).
- **public/**: Arquivos públicos acessíveis via navegador (HTML, CSS, JS, imagens).
- **routes/**: Arquivo que define as rotas da aplicação (WEB e API).
- **vendor/**: Bibliotecas externas instaladas via Composer.
- **views/**: Arquivos HTML organizados por seção (tarefas, categorias, login, etc).

---

## ✅ Decisões de Arquitetura

- Estrutura MVC leve e organizada
- Reescrita de URL protegendo arquivos sensíveis
- Uso extensivo de classes e boas práticas de programação
- Reutilização de componentes CSS e JS
- Uso do Bootstrap com Flexbox
