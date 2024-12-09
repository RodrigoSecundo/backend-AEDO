# Projeto Backend - Sistema de doação de órgãos

Este projeto é responsável pela lógica do servidor, incluindo a conexão com o banco de dados e a entrega das informações para o frontend. É desenvolvido em *PHP* e utiliza o *MySQL* para armazenar os dados dos hospitais.

## Tecnologias Utilizadas

- *PHP*: Lógica de backend, como manipulação de dados e interação com o banco.
- *MySQL*: Banco de dados para armazenar as informações dos hospitais.
- *Laragon*: Para rodar um servidor local com PHP e MySQL.
- *JavaScript*: Para interatividade no frontend (não essencial para o backend).

## Como Rodar o Backend

### 1. Instalação do Laragon

Para rodar o backend, você também precisará do Laragon, que inclui o PHP e o MySQL.

#### Passos para instalar o Laragon:

1. *Baixe o Laragon*: Acesse [Laragon](https://laragon.org/) e baixe a versão mais recente.
2. *Instale o Laragon*: Execute o instalador e siga as instruções de instalação.
3. *Inicie o Laragon*: Após a instalação, abra o Laragon e clique em "Start All" para iniciar o Apache e o MySQL.

### 2. Configurando o Banco de Dados MySQL

1. *Acesse o PHPMyAdmin*: Abra o navegador e acesse http://localhost/phpmyadmin.
2. *Crie o banco de dados*:
   - Crie um novo banco de dados chamado cadastro_usuario.
   - Dentro deste banco, crie uma tabela hospitais com os seguintes campos:

   ```sql
   CREATE TABLE hospitais (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(255) NOT NULL,
       localizacao VARCHAR(255),
       contato VARCHAR(255)
   );
