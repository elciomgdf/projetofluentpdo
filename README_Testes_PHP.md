# Teste de Desenvolvedor FullStack PHP

## ✅ Projetos

- `https://projetofluentpdo.test` → **Usando FluentPDO**
- `https://projetomedoo.test` → **Usando Medoo**

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

## 🚀 Instalação do Projeto

Abaixo estão os passos para instalar e rodar o projeto localmente utilizando Docker e WSL (para usuários Windows). Siga a ordem para evitar erros:

### 1. 📥 Clonar o repositório

Primeiro, baixe o projeto para sua máquina:

```bash
git clone https://github.com/elciomgdf/projetofluentpdo.git
cd projetofluentpdo
```

---

### 2. 🐳 Instalar o Docker (com suporte a WSL no Windows)

Se ainda não tiver o Docker instalado:

- No **Windows**, instale o [Docker Desktop](https://www.docker.com/products/docker-desktop) e certifique-se de ativar o suporte ao **WSL 2**.
- No **Linux/Mac**, instale normalmente via terminal ou gerenciador de pacotes.

---

### 3. 🔐 Gerar certificado SSL autoassinado

Para rodar o projeto em HTTPS, é necessário gerar um certificado local. Você pode utilizar um script pronto ou rodar comandos OpenSSL.

> **Importante:** certifique-se de apontar o `vhost` ou configuração do nginx para usar esse certificado.

---

### 4. 🧠 Configurar o arquivo de hosts

Edite seu arquivo de hosts para que o domínio local funcione corretamente:

- No **Windows**, edite o arquivo:
  ```
  C:\Windows\System32\drivers\etc\hosts
  ```

- No **Linux/Mac**, edite:
  ```
  /etc/hosts
  ```

Adicione a seguinte linha:

```
127.0.0.1 projetofluentpdo.test
```

---

### 5. ⚙️ Subir os containers com Docker Compose

Execute o seguinte comando para construir e iniciar os containers:

```bash
docker-compose up -d --build
```

Aguarde até que todos os serviços estejam rodando.

---

### 6. 📦 Instalar dependências PHP com Composer

Acesse o container da aplicação e rode o `composer install`:

```bash
docker exec -it nome_do_container_php bash
composer install
```

> Substitua `nome_do_container_php` pelo nome real do seu container PHP (ex: `app` ou `php`).

---

### 7. 🗃️ Criar o banco de dados

Ainda dentro do container, execute o script que cria as tabelas no banco:

```bash
php database/create_database.php
```

---

### ✅ Pronto!

O projeto estará acessível em: [https://projetofluentpdo.test](https://projetofluentpdo.test)

Caso algo não funcione, verifique se todos os containers estão ativos e se as configurações do `hosts` e certificado estão corretas.

---

## ✅ Estrutura do Sistema

### 📂 Tabelas Criadas (com SQL manual)
- `users`
- `tasks`
- `task_categories`
- `user_sessions`
- `user_tokens`

> Os scripts estão em: `database/tables.sql`
 
Para criar, dentro do container, rode:

    ```bash
    php database/create_database.php
    ````

---

## ✅ Funcionalidades Implementadas

### 🔐 Autenticação
- [x] Tela de login
- [x] Registro de Usuário
- [x] Recuperação de senha
- [x] Logout
- [x] Proteção de rotas por sessão e por rate limit

### 📋 Funcionalidades
- [x] Listagem completa de Tarefas onde é possível filtrar, ordenar, editar e excluir
- [x] Adicionar nova Tarefa
- [x] Editar Tarefa
- [x] Listagem completa de Categorias onde é possível filtrar, ordenar, editar e excluir
- [x] Adicionar Categoria
- [x] Editar Categoria
- [x] Alterar os dados do próprio Usuário
- [x] Acesso à documentação da API via menu principal
- [x] Acesso ao "servidor de e-mail" via menu do Usuário


---

## ✅ API REST

### 🔐 Autenticação

- [x] **POST /api/sign-up**  
  Cadastro de novo usuário com nome, e-mail e senha.

- [x] **POST /api/auth/login**  
  Login com e-mail e senha, retorna token JWT.

- [x] **POST /api/recover-password**  
  Envia e-mail de recuperação de senha.

- [x] **POST /api/auth/logout**  
  Logout do usuário autenticado.

---

### 👤 Usuários

- [x] **GET /api/user/{id}**  
  Visualizar dados de um usuário específico.

- [x] **PUT /api/user/{id}/update**  
  Alterar dados de um usuário (nome, e-mail, senha).

- [x] **GET /api/user/search**  
  Listagem completa de usuários com filtros, ordenação e paginação.

---

### 🗂️ Categorias

- [x] **GET /api/categories**  
  Listagem simples de categorias.

- [x] **GET /api/category/{id}**  
  Detalhes de uma categoria.

- [x] **GET /api/category/search**  
  Listagem completa de categorias com filtros, ordenação, paginação.

- [x] **POST /api/category/create**  
  Adicionar nova categoria.

- [x] **PUT /api/category/{id}/update**  
  Editar uma categoria.

- [x] **DELETE /api/category/{id}/delete**  
  Excluir uma categoria.

---

### ✅ Tarefas

- [x] **GET /api/task/{id}**  
  Visualizar detalhes de uma tarefa.

- [x] **GET /api/task/search**  
  Listagem completa de tarefas com filtros, ordenação, paginação.

- [x] **POST /api/task/create**  
  Adicionar nova tarefa.

- [x] **PUT /api/task/{id}/update**  
  Editar tarefa existente.

- [x] **DELETE /api/task/{id}/delete**  
  Excluir tarefa existente.

> Arquivo de documentação: `docs/openapi.yaml`
> 
> Ela pode ser acessada na url http://localhost:8082/

---

## ✅ Segurança Implementada

| Item                      | Implementado                                                                                                                                          |
|---------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|
| password_hash             | ✅                                                                                                                                                     |
| CSRF Tokens               | ✅ Proteção para POST, PUT e DELETE                                                                                                                    |
| SQL Injection Prevention  | ✅ Bbind Param corretamente nas bibliotecas de conexão                                                                                                 |
| XSS Protection            | ✅ htmlspecialchars na exibição dos dados no HTML                                                                                                      |
| Validações no Front       | ✅ WEB: HTML corretamente construído para obrigar dados sensíveis e seus formatos                                                                      |
| Validações no Back    | ✅ WEB/API: Métodos e funções que garantem que apenas dados esperados chegem às tabelas. Exclusão completa de código HTML com strip_tags quando string |
| HTTPS forçado             | ✅ via Nginx                                                                                                                                           |
| Cabeçalhos HSTS, CSP, etc | ✅ Nginx                                                                                                                                               |
| Rate Limiting             | ✅ limite de 60 requisições à qualquer url por IP                                                                                                      |
| Sessão                    | ✅ WEB: Sessão via base de dados verificadas via Middlewares antes de executar as Controllers                                                         |
| Tokens                    | ✅ API: Token JWT com possibilidade de logout via base de dados                                                                                        |

---

## ✅ Docker e Domínios

### 🔧 Configuração Docker
- Arquivos: `Dockerfile`, `docker-compose.yml`, `.env`
- Serviços: 
  - PHP: php:8.1-fpm
  - Nginx: nginx:latest
  - Mailhog: mailhog/mailhog
  - Mariadb: mariadb:10.5
  - SwaggerUi: swaggerapi/swagger-ui

### 🌐 Domínios Locais
- `127.0.0.1 projetofluentpdo.test`
- `127.0.0.1 projetomedoo.test`

> Editar:  
> - Windows: `C:\Windows\System32\drivers\etc\hosts`  
> - Linux/macOS: `/etc/hosts`

### 🔐 Certificados SSL
- Gerados com OpenSSL (autoassinado)
- Configurado no Nginx
- Importados no navegador como certificados confiáveis
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

---

### 🐧 Instalação no Linux

1. Acesse `https://projetofluentpdo.test` no navegador (pode aparecer como inseguro).
2. Clique no ícone de cadeado (ou “Não seguro”) → **Visualizar certificado** → **Exportar**.
3. Vá até **Configurações do sistema** → **Certificados** → **Autoridades**.
4. Importe o `cert.pem` e marque como **confiável para identificar sites**.
5. Reabra o navegador.

---

### 🪟 Instalação no Windows (incluindo WSL/Docker Desktop)

1. Clique duas vezes em `cert.pem`.
2. Escolha **Instalar certificado**.
3. Selecione **Máquina Local**.
4. Escolha: **Colocar todos os certificados no repositório a seguir**.
5. Selecione: `Autoridades de Certificação Raiz Confiáveis`.
6. Conclua a instalação e aceite os avisos.
7. Reabra o navegador e acesse `https://projetofluentpdo.test`.

---

### ✏️ Observações

- Para adicionar outro domínio (como `projetomedoo.test`), edite o script e adicione mais entradas em `[alt_names]`:

    ```ini
    [alt_names]
    DNS.1 = projetofluentpdo.test
    DNS.2 = projetomedoo.test
    ```

- Se estiver usando múltiplos domínios, o mesmo certificado pode ser compartilhado entre os dois projetos no Nginx.


---

## ✅ Estrutura dos Diretórios

```
/projetofluentpdo
├── app # Arquivos do Aplicativo, as classes ficam centralizadas aqui
│    ├── Constants # Constantes que ficariam ser lugar 
│    ├── Controllers # Controllers, classes que são executadas no acesso
│    │     ├── Api # Classes referentes à API, projegidas via JWT
│    │     └── Web # Classes referentes à WEB, protegidas via Sessão
│    ├── Core # Core do sistema, Router e Sessão
│    ├── Exceptions # Erros customizados
│    ├── Helpers # functions.php para funções globais
│    ├── Interfaces # ModelInterface, que obriga as Models a terem métodos importantes
│    ├── Middlewares # Classes que são executadas antes de uma rota ser chamada
│    ├── Models # Classes referentes ao banco de dados
│    ├── Services # Classes de negócio
│    ├── Traits # Classes com métodos que podem ser comuns à diferentes classes
│    └── Validators # Validadores que garantem que os dados corretos cheguem às tabelas
├── database # Script para criação das tabelas do banco
├── docker # Configurações a serem copiadas para o container nginx
│     ├── nginx
│     └── ssl
├── docs # Documentação openapi para a API
├── public # Acesso público do sistema
│     └── assets
│         ├── css
│         ├── images
│         └── js
├── routes # Arquivo de rotas com o que pode ser acessado no sistema/API
├── vendor # Bibliotecas instaladas via composer
└── views # Views HTML
    ├── category
    ├── includes
    ├── profile
    ├── sign-up
    └── task

```

---

## ✅ Decisões de Arquitetura

- Separação de responsabilidades em pastas organizadas observando a estrutura recomendada quando possível
- Estrutura MVC leve sem framework
- Reescrita de URL impedindo acesso direto a arquivos PHP evitando expor a tecnologia usada
- Utilização de Classes e Funções de modo que a manutenção seja mais leve
- Código reutilizável onde possível (frontend, JS, CSS)
- Uso do Bootstrap CSS para agilizar o desenvolvimento Frontend obedecendo o pré-requisito do uso do Flexbox

