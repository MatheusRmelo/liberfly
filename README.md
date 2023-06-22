# Instale as dependências
`composer install` (PHP/Laravel)<br />
# Configurando o .env
Copie o .env.example e renomeie para .env, depois rode o comando `php artisan key:generate`

Configure o .env

### Para uso no docker
```
DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=liberfly
DB_USERNAME=admin
DB_PASSWORD=admin@123456
L5_SWAGGER_CONST_HOST=http://localhost
JWT_SECRET_KEY=key_docker_teste
```
### Para uso local, adapte as conexões a sua instalação do MySQL ou Mariadb.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=liberfly
DB_USERNAME=root
DB_PASSWORD=
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
JWT_SECRET_KEY=key_teste
```
# Rodando com docker
Execute o comando <br />
`docker compose up -d` <br />
depois rode as migrations<br />
`docker exec app php artisan migrate --force` <br />
OBS: --force é para rodar mesmo se env tiver para produção

Depois acesse a url **http://localhost/docs** e pronto você já tem acesso a documentação da API

# Rodando local
Execute as migrations `php artisan migrate`<br />
Depois rode o serve em Laravel `php artisan serve` <br />

Depois acesse a url **http://127.0.0.1:8000/docs** e pronto você já tem acesso a documentação da API

OBS: Se o Swagger não funcionar gere novamente os arquivos usando `php artisan l5-swagger:generate`
# Executando os testes
Depois de configurar o laravel local rode o comando <br />
`php artisan test`

# Observações
Lembre-se de sempre colocar no header da requisição para consumir as RestAPI <br />
`Accept: application/json` <br />
`Content-Type: application/json`
