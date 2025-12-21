# Payments API

Esta aplicação simula uma plataforma de pagamentos simplificada. Nela é possível depositar e realizar transferências de dinheiro entre usuários.

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

## 📋 Pré-requisitos para executar o projeto

Para rodar este projeto, você precisará ter instalado em sua máquina:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

## 🚀 Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento:

1. **Clone o repositório**

   ```bash
   git clone https://github.com/edilsoncichon/payments-api.git
   cd payments-api
   ```

2. **Configure as variáveis de ambiente**

   Copie o arquivo de exemplo para criar o seu `.env`:

   ```bash
   cp .env.example .env
   ```

   Certifique-se de configurar as credenciais do banco de dados no `.env` para corresponderem ao `docker-compose.yml`:

   ```ini
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=payments_api
   DB_USERNAME=userdb
   DB_PASSWORD=userdb
   ```

3. **Inicie os containers**

   ```bash
   docker-compose up -d --build
   ```

4. **Instale as dependências**

   Execute o comando abaixo para instalar as dependências do PHP via Composer (dentro do container):

   ```bash
   docker-compose exec app composer install
   ```

5. **Gere a chave da aplicação**

   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Execute as migrações**

   Crie as tabelas no banco de dados:

   ```bash
   docker-compose exec app php artisan migrate
   ```

## 🛠️ Comandos Úteis

- **Acessar o container da aplicação (bash):**
  ```bash
  docker-compose exec app bash
  ```
  
- **Executar a análise estática do código:**
  ```bash
  docker-compose exec app vendor/bin/phpstan
  ```

- **Rodar os testes:**
  ```bash
  docker-compose exec app php artisan test
  ```

- **Limpar cache:**
  ```bash
  docker-compose exec app php artisan optimize:clear
  ```

- **Monitorar logs:**
  ```bash
  docker-compose logs -f app
  ```
