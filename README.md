# Backend API - PHP e BD MySQL

Esse módulo destina-se ao consumo da aplicação Fronte-end.
Através dele é possível cadastrar, consultar e persistir os dados no Banco MySQL.


## Banco de dados - MySQL
No MySQL foi criado o Database vendas(Em simuladores como Xampp ou WampServer não se faz necessário rodar o comando use), e as tabelas vendas e vendedors conforme script abaixo:
```sql
  CREATE DATABASE vendas;

  USE vendas;
```
```sql
  CREATE TABLE vendas (
  	id INT NOT NULL  AUTO_INCREMENT,
  	nome VARCHAR(255),
  	email VARCHAR(255),
  	id_vendedor VARCHAR(255),
  	descricao_venda VARCHAR(255),
    comissao DECIMAL,
    valor_venda DECIMAL,
  	data_venda DATE,
  	PRIMARY KEY (id)
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_vendedor)
  );
```
```sql
  CREATE TABLE vendedor (
  	id_vendedor INT NOT NULL  AUTO_INCREMENT,
  	nome VARCHAR(255),
  	email VARCHAR(255),
  	PRIMARY KEY (id_vendedor)
  );
```

## Configurações de conexao DB
As credenciais do banco de dados estão no arquivo `./api/conexao.php` e devem ser alteradas de acordo com seu ambiente (HOST, NAME, USER e PASS).

