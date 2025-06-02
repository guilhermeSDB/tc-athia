# Documentação do Projeto

Este documento descreve como configurar e executar a aplicação, as tecnologias utilizadas e sua arquitetura.

## Requisitos

Para executar este projeto, os principais requisitos dependem se você está utilizando Docker ou executando os serviços individualmente:

**Para executar com Docker Compose:**

* Docker Engine
* Docker Compose

**Para executar sem Docker (serviços individuais):**

* PHP (versão 8.1 ou superior)
* Composer
* Node.js (versão 18 ou superior)
* npm ou yarn
* Banco de Dados PostgreSQL

## Tecnologias Utilizadas

### API (Backend)

* **Framework:** Slim Framework
* **ORM:** Illuminate Database (Eloquent)
* **Dependency Injection:** PHP-DI
* **Validação:** Symfony Validator
* **Migrations:** Phinx
* **Documentação API:** Swagger-PHP
* **Outros:** PHP dotenv, Faker

### Web (Frontend)

* **Framework:** Next.js
* **Bibliotecas UI:** Radix UI, shadcn/ui
* **Gerenciamento de Estado/Dados:** Tanstack Query, Tanstack Table
* **Requisições HTTP:** Axios
* **Estilização:** Tailwind CSS
* **Validação:** Zod
* **Outros:** Dnd-kit, TypeScript

### Banco de Dados

* PostgreSQL

## Arquitetura

A aplicação segue uma arquitetura dividida em duas partes principais:

1. **API (Backend):** Desenvolvida em PHP utilizando o Slim Framework e Eloquent ORM. Segue princípios de Clean Architecture, separando as camadas de Domínio, Aplicação, Infraestrutura e Interface. É responsável por expor os endpoints da API para o frontend e gerenciar a interação com o banco de dados.
2. **Web (Frontend):** Desenvolvida em Next.js com TypeScript. Consome a API para obter e enviar dados. Utiliza Tailwind CSS e componentes Radix UI/shadcn/ui para a interface.

O banco de dados PostgreSQL é utilizado para persistir os dados da aplicação.

## Documentação da API (Swagger)

A API possui documentação automática gerada utilizando Swagger-PHP. O script `api/entrypoint.sh` executa o comando `composer generate-swagger` ao iniciar o contêiner da API, que gera o arquivo `public/openapi.json`.

Para visualizar a documentação, você pode usar uma ferramenta como o Swagger UI, apontando para o arquivo `openapi.json` gerado. Se estiver rodando a API com Docker Compose, este arquivo estará disponível no contêiner da API no caminho `/var/www/html/public/openapi.json`. Se estiver rodando a API sem Docker, o arquivo estará em `api/public/openapi.json`.

## Como Executar

### Executando sem Docker

Certifique-se de ter todos os [Requisitos](#requisitos) instalados.

1. **Configurar o Banco de Dados:**
    * Crie um banco de dados PostgreSQL.
    * Copie o arquivo `.env.example` (se existir) para `.env` na raiz do diretório `api` e configure as credenciais do banco de dados.
    * Execute as migrações para criar as tabelas no banco de dados:

        ```bash
        cd api
        composer install
        php vendor/bin/phinx migrate
        # Opcional: seed the database
        # php vendor/bin/phinx seed:run
        ```

2. **Executar a API:**
    * Ainda no diretório `api`, inicie o servidor PHP embutido (para desenvolvimento):

        ```bash
        php -S localhost:8000 -t public
        ```

    * A API e o Swagger estará disponível em `http://localhost:8000`.

3. **Executar a Aplicação Web:**
    * No diretório `web`, instale as dependências e inicie o servidor de desenvolvimento:

        ```bash
        cd ../web
        npm install # ou yarn install
        npm run dev # ou yarn dev
        ```

    * A aplicação Web estará disponível em `http://localhost:3000`.

### Executando com Docker

Este projeto está configurado para ser executado integralmente usando Docker Compose. Certifique-se de ter o Docker e Docker Compose instalados.

1. **Construir e Iniciar os Contêineres:**
    * Na raiz do projeto, execute o seguinte comando para construir as imagens e iniciar todos os serviços em modo detached:

    ```bash
    docker-compose up -d --build
    ```

    * Este comando subirá os serviços de banco de dados (`postgres`), API (`api`), e Web (`web`).
    * O script `entrypoint.sh` da API (`api/entrypoint.sh`) irá automaticamente instalar as dependências PHP, executar as migrações do banco de dados e gerar a documentação Swagger ao iniciar o contêiner da API.
    * O serviço de banco de dados (`postgres`) estará disponível na porta `5432` do seu localhost.
    * O serviço da API (`api`) estará disponível em `http://localhost:8000`.
    * O serviço Web (`web`) estará disponível em `http://localhost:3000`.

2. **Parar os Contêineres:**
    * Para parar todos os serviços rodando via Docker Compose, execute na raiz do projeto:

    ```bash
    docker-compose down
    ```
