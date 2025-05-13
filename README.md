# Projeto FluentPDO - Gerenciador de Tarefas

Este é um dos sistemas exigidos no teste de desenvolvedor FullStack PHP. 
Ele utiliza **PHP 8+, Jquery, MySQL, API REST** e a biblioteca **FluentPDO** para acesso ao banco de dados.

## 🔧 Tecnologias Utilizadas

- PHP 8.1 (**sem frameworks**)
- FluentPDO
- phpdotenv - Para registrar variáveis de ambiente via **.env**
- hashids - Para evitar a exposição de IDs e assim permitir ataques (**Insecure Direct Object Reference (IDOR)**)
- phpmailer - Envio de E-mails
- MySQL/MariaDB
- Docker + Docker Compose
- Nginx
- HTML5, CSS3 (Flexbox), JavaScript e jQuery
- Bootstrap CSS ( devido ao prazo e à necessidade de construir dois projetos )
- API REST com autenticação via token
- Certificado SSL autoassinado

## 🚀 Funcionalidades

- Autenticação de Usuários (login, registro, logout, recuperação de senha)
- CRUD completo de tarefas
- CRUD completo de categorias
- Filtro por categoria e status
- Ordenação nas funcionalidades pelos campos das tabelas
- Interface responsiva usando Bootstrap CSS (Baseada em Flexbox desde 2018)
- Proteção contra CSRF, XSS e SQL Injection

## 📁 Estrutura de Diretórios

```
projetofluentpdo/
│
├── app/                 # Classes específicas da aplicação
│   ├── Constants
│   ├── Controllers
│   └── Core
│
├── docker/              # Arquivos de configuração Docker
│   ├── nginx/
│   └── php/
│
├── docs/                # Documentação OpenAPI
│   └── config.php
│
├── docker-compose.yml
├── Dockerfile
└── README.md
```

## 🐳 Como executar com Docker

```bash
# Clone o repositório
git clone https://github.com/elciomgdf/projetofluentpdo.git
cd projetofluentpdo

# Inicie os containers
docker-compose up -d --build
```

O projeto estará acessível via HTTPS em:

```
https://projetofluentpdo.test
```

## 🛠️ Configuração de Domínio Local

Edite o arquivo `/etc/hosts` (ou `C:\Windows\System32\drivers\etc\hosts` no Windows) e adicione:

```
127.0.0.1 projetofluentpdo.test
```

## 🔐 SSL (Autoassinado)

Certificados autoassinados são gerados e usados automaticamente pelo Nginx no container.

Caso seu navegador exiba um aviso de segurança, você pode prosseguir manualmente ou adicionar o certificado como confiável no sistema operacional.

## 📦 Dependências PHP

Utilize o Composer (dentro do container):

```bash
docker exec -it fluentpdo-php composer install
```

## 🧪 Testando a API

Use ferramentas como **Postman** ou **Insomnia** para testar os endpoints REST da API. A documentação completa dos endpoints está em andamento neste repositório.

