# Tecnologias usadas
- PHP 8.1
- Laravel 9
- VUE JS 3
- Node 16
- MySql

# Criar banco de dados, com o nome recipe_manager

```sql
CREATE DATABASE IF NOT EXISTS recipe_manager;
```

# Renomear o arquivo .env.example para .env e fazer os ajustes nas variaveis de banco de dados
```
DB_USERNAME=NOME_DO_SEU_USUARIO_DE_BANCO_DE_DADOS
DB_PASSWORD=SENHA_DO_SEU_USUARIO_DE_BANCO_DE_DADOS
```

# Rodar os comandos dentro das pasta /api
```sh
composer install
npm install
npm run dev
php artisan key:generate
php artisan migrate 
php artisan db:seed
php artisan serve 
# configurado para rodar em http://localhost:8000/
```

# Rodar os comandos dentro das pasta /app-client
```sh
npm install
npm run dev
# configurado para rodar me http://localhost:5173/
```

 Na aplicação logar com as credenciais
- *Email:* admin@stw.com.br
- *Senha:* s3nh4#

