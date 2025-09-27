# King Host IMDB - Catálogo de Filmes - Teste Técnico
Este é um projeto de catálogo de filmes desenvolvido para meu teste técnico que permite aos usuários pesquisar filmes,
visualizá-los e criar uma lista de favoritos pessoal. A aplicação é totalmente containerizada com Docker, utilizando
um backend em Laravel e um frontend em Vue.js.

## Funcionalidades

- **Busca de Filmes:** Pesquisa em tempo real na API do The Movie Database (TMDB).
- **Autenticação de Usuários:** Sistema de registro e login para gerenciamento de favoritos.
- **Lista de Favoritos:** Usuários autenticados podem adicionar e remover filmes de sua lista pessoal.
- **Tema Claro e Escuro:** Interface com modo claro e escuro para melhor experiência do usuário.
- **Design Responsivo:** Layout adaptado para desktops, tablets e dispositivos móveis.

## Demonstração em Vídeo

Assista a uma breve demonstração da aplicação em funcionamento:

[![Demonstração do King Host IMDB no YouTube](https://img.youtube.com/vi/glFqG6aqTt8/maxresdefault.jpg)](https://youtu.be/glFqG6aqTt8)

## Telas da Aplicação

<p align="center">
  <img src="./screenshots/desktop-light.png" alt="Tela Inicial" width="45%">
  &nbsp; &nbsp; &nbsp; &nbsp;
  <img src="./screenshots/desktop-dark.png" alt="Modo Escuro" width="45%">
</p>
<p align="center">
  <em>Website Desktop light e dark mode.</em>
</p>
<p align="center">
  <img src="./screenshots/mobile-light.png" alt="Tela Inicial" width="45%">
  &nbsp; &nbsp; &nbsp; &nbsp;
  <img src="./screenshots/mobile-dark.png" alt="Modo Escuro" width="45%">
</p>
<p align="center">
  <em>Website Mobile light e dark mode.</em>
</p>


## Arquitetura

- **Backend:** Laravel 12
- **Frontend:** Vue 3 (Vite)
- **Banco de Dados:** MySQL
- **Containers:** Docker & Docker Compose

---

## 🚀 Rodando o Projeto Localmente com Docker

Siga os passos abaixo para configurar e executar o projeto em sua máquina.

### 1. Pré-requisitos

Antes de começar, certifique-se de ter os seguintes softwares instalados:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

### 2. Configuração do Ambiente

#### a. Clone o Repositório

Se você ainda não o fez, clone este repositório para a sua máquina local.

```bash
git clone https://github.com/gilmarodp/king-host-imdb.git
```

```bash
cd king-host-imdb
```

#### b. Configuração do Backend (Laravel)

O Laravel precisa de um arquivo de ambiente `.env` para funcionar.

1.  **Navegue até a pasta do backend:**
    ```bash
    cd backend
    ```

2.  **Copie o arquivo de exemplo `.env.example`:**
    ```bash
    cp .env.example .env
    ```
    *Este comando cria um novo arquivo `.env` a partir do exemplo. Para este projeto, as configurações padrão já são suficientes para rodar com Docker e MySQL, então não são necessárias mais alterações neste arquivo.*
3. **Volte para a raiz do projeto:**
    ```bash
    cd ..
    ```


#### c. Configuração do Frontend (Vue.js)

O frontend precisa de uma chave de API do The Movie Database (TMDB) para buscar os filmes.

1.  **Navegue até a pasta do frontend:**
    ```bash
    cd frontend
    ```

2.  **Copie o arquivo de exemplo `.env.example`:**
    ```bash
    cp .env.example .env
    ```

3.  **Obtenha sua chave de API:**
    - Crie uma conta no [The Movie Database (TMDB)](https://www.themoviedb.org/signup).
    - Vá para as configurações da sua conta, na seção "API", e solicite uma chave de desenvolvedor. É um processo rápido e gratuito.

4.  **Insira a chave no arquivo:**
    - Abra o arquivo: `frontend/.env`
    - Encontre a seguinte linha (aproximadamente na linha 2):
      ```dotenv
      VITE_TMDB_API_KEY="COLE_AQUI_SUA_API_KEY_TMDB"
      ```
    - Substitua `"COLE_AQUI_SUA_API_KEY_TMDB"` pela sua chave de API real.

5. **Volte para a raiz do projeto:**
    ```bash
    cd ..
    ```


### 3. Iniciando a Aplicação

Com tudo configurado, agora vamos iniciar os contêineres Docker.

1.  **Volte para a raiz do projeto** (a pasta que contém o arquivo `docker-compose.yml`).

2.  **Inicie os contêineres em background:**
    ```bash
    docker-compose up -d --build
    ```
    *O comando `--build` garante que as imagens Docker sejam construídas do zero, aplicando todas as configurações.*

3.  **Gere a chave da aplicação Laravel:**
    *Após os contêineres estarem rodando, execute o seguinte comando para gerar a `APP_KEY` necessária para o Laravel.*
    ```bash
    docker-compose exec app php artisan key:generate
    ```

4.  **Execute as migrações do banco de dados:**
    *Este comando criará as tabelas no banco de dados MySQL.*
    ```bash
    docker-compose exec app php artisan migrate
    ```

### 4. Acessando a Aplicação

Pronto! A aplicação está 100% funcional.

-   **Frontend (onde você verá o site):**
    Acesse [http://localhost:8000](http://localhost:8000) no seu navegador.

-   **Backend (API):**
    A API estará rodando em [http://localhost:8000/api](http://localhost:8000/api).

---

### Comandos Úteis do Docker

-   **Parar a aplicação:**
    ```bash
    docker-compose down
    ```

-   **Verificar os logs (para depuração):**
    ```bash
    # Logs do backend (Laravel)
    docker-compose logs -f app

    # Logs do frontend (Vue/Vite)
    docker-compose logs -f frontend
    ```

-   **Acessar o terminal do contêiner:**
    ```bash
    # Acessar o contêiner do backend
    docker-compose exec app bash

    # Acessar o contêiner do frontend
    docker-compose exec frontend sh
    ```

