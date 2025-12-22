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
2. **Inicie os containers**

   ```bash
   docker compose up -d --build
   ```

3. **Configure o projeto**

   Execute o comando abaixo para configurar o projeto via Composer:

   ```bash
   docker compose exec app composer setup
   ```

## 🛠️ Comandos Úteis

- **Acessar o container da aplicação (bash):**
  ```bash
  docker compose exec app bash
  ```
  
- **Executar a análise estática do código (PHPStan):**
  ```bash
  docker compose exec app composer phpstan
  ```

- **Analisar e corrigir a sintaxe do código (PHP CS Fixer):**
  ```bash
  docker compose exec app composer lint
  ```

- **Rodar os testes:**
  ```bash
  docker compose exec app composer test
  ```

- **Limpar cache:**
  ```bash
  docker compose exec app php artisan optimize:clear
  ```

- **Monitorar logs:**
  ```bash
  docker compose logs -f app
  ```
