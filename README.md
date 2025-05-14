
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

## 🚀 Instalação do Projeto (Windows - modo fácil)

### 1. 🧰 Instale o [Git para Windows](https://gitforwindows.org/)

- Acesse: [https://gitforwindows.org/](https://gitforwindows.org/)
- Baixe e instale normalmente.
- Ele instalará o terminal **Git Bash**, necessário para rodar o script `.sh`.

### 2. 📥 Clonar o repositório

```bash
git clone https://github.com/elciomgdf/projetofluentpdo.git
cd projetofluentpdo
```

### 3. 🐳 Instale o [Docker Desktop](https://www.docker.com/products/docker-desktop)

- Acesse: [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)
- Baixe a versão para Windows e instale.
- Durante a instalação, ative o suporte a **WSL 2** (opcional, mas recomendado).
- Após instalar, reinicie o PC se for solicitado.

### 4. 📂 Abra o **Git Bash** na pasta do projeto

- Vá até a pasta `projetofluentpdo` no Explorador de Arquivos.
- Clique com o botão direito numa área vazia da pasta.
- Selecione: **Git Bash Here**

> Se não aparecer essa opção, reinicie o PC ou reinstale o Git for Windows.

### 5. 🔐 Gere os certificados:

Dentro do Git Bash, rode:

```bash
./gerar_certificados_ssl.sh
```

Isso criará os arquivos:

- `docker/ssl/cert.pem`
- `docker/ssl/key.pem`


### 6. 🧠 Configure o arquivo de hosts:

Abra como administrador o arquivo:

```
C:\Windows\System32\drivers\etc\hosts
```

Adicione ao final:

```
127.0.0.1 projetofluentpdo.test
```

### 7. ✅ Instale o certificado:

1. Dê dois cliques no arquivo `cert.pem`, se não funcionar, você pode usar Window + R e executar `certmgr.msc`
2. Clique em **Instalar Certificado**
3. Escolha **Máquina Local**
4. Avance até a opção:
   - **Colocar todos os certificados no repositório a seguir**
5. Selecione: `Autoridades de Certificação Raiz Confiáveis`
6. Conclua e aceite os avisos de segurança
7. Feche e reabra o navegador

### 8. ⚙️ Suba os containers:

No terminal (Git Bash, PowerShell ou CMD), rode:

```bash
docker-compose up -d --build
```

### 9. 📦 Instale dependências PHP e configure o banco

```bash
docker exec -it nome_do_container_php bash
composer install
cp .env.example .env
php database/create_database.php
```

---

## ✅ Acesso ao Projeto

Acesse no navegador: [https://projetofluentpdo.test](https://projetofluentpdo.test)

> Se aparecer como “inseguro”, feche e reabra o navegador após instalar o certificado corretamente.

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
