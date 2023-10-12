# DESAFIO VolkLMS

🤝 ## Descrição de Projeto

Desafio construído para atender ao teste prático da VolkLMS. No desafio será simular um serviço do sistema, onde foi necessário desenvolver um ambiente com o objetivo de exibir para os clientes um feedback e também como está o progresso de ações em lote geradas dentro da plataforma. com interface de gerenciamento, cadastro e integração com volkLMS.

💻 ## Requisitos

    PHP (8.1.20 ou superior)
    Composer
    MySQL (8.0.30 ou superior)

☕ ## Dificuldades

    1 - Foi encontrando dificuldade até o momento da integração com a API do VolkLMS devido a chamada no recurso de newQueue, mesmo repassando os dados que foi informado em documentação a API informa que os dados estão incorretos com relação ao ID de ação da fila. parametro: informado acao_fila: [1,2,3,4,5,6,7], retorno:{ "error": "1", "message": "ID ação não reconhecido"}
 
📫 ## Instalação
    
1. clone o repositorio em uma pasta do sistema, rodando o comando:

`git clone https://github.com/emersongin/poc-volk-lms.git`
    
2. acesse a pasta do projeto e baixe as dependencias do Composer, rodando o comando:

    `composer install`

3. no mysql, crie um banco de dados local chamado: volklms_poc_db

4. altere o arquivo que esta na pasta src/Config/dbConfig.php informe os dados de conexão com o banco de dados para pode fazer as consultas:
exemplo:
    'dbname'   => 'volklms_poc_db',
    'user'     => 'root',
    'password' => 'root',
    'host'     => 'localhost',
    'port'     => 3306,
    'driver'   => 'pdo_mysql',

5. faça o mesmo com o arquivo migrations-db.php, para pode rodar as migrations:
exemplo:
    'dbname' 	 => 'volklms_poc_db',
    'user' 		 => 'root',
    'password' => 'root',
    'host' 		 => 'localhost',
    'port'     => 3306,
    'driver' 	 => 'pdo_mysql',

6. em seguida rode o comando para as migrations(informa yes ou y):

    `php ./vendor/bin/doctrine-migrations migrate`

7. pronto, rode o seguinte comando e acesse:

    `php -S localhost:80 -t public`

## Autor
EMERSON ANDREY
