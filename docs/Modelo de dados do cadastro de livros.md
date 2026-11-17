# Modelo de dados do cadastro de livros

O sistema utiliza MySQL e organiza os dados em três tabelas principais e duas tabelas associativas.

O modelo segue o diagrama fornecido no desafio, com a inclusão do campo Valor em Livro.

## Livro

Armazena as informações de cada livro.

| Campo | Tipo e tamanho | Chave | Descrição |
|---|---|---|---|
| Codl | INTEGER | PK | Identificador do livro |
| Titulo | VARCHAR(40) | — | Título do livro |
| Editora | VARCHAR(40) | — | Editora responsável pela publicação |
| Edicao | INTEGER | — | Número da edição |
| AnoPublicacao | VARCHAR(4) | — | Ano de publicação |
| Valor | DECIMAL(10,2) | — | Valor do livro em reais |

O campo Valor foi acrescentado para atender ao requisito expresso no desafio.

A proposta DECIMAL(10,2) permite oito dígitos na parte inteira e dois na parte decimal, representando valores até 99.999.999,99.

A formatação monetária será aplicada na apresentação dos dados. Por exemplo, o valor 1234.56 será apresentado como R$ 1.234,56.

## Autor

Armazena os autores que podem ser associados aos livros.

| Campo | Tipo e tamanho | Chave | Descrição |
|---|---|---|---|
| CodAu | INTEGER | PK | Identificador do autor |
| Nome | VARCHAR(40) | — | Nome do autor |

## Assunto

Armazena os assuntos que podem ser associados aos livros.

| Campo | Tipo e tamanho | Chave | Descrição |
|---|---|---|---|
| codAs | INTEGER | PK | Identificador do assunto |
| Descricao | VARCHAR(20) | — | Descrição do assunto |

## Livro_Autor

Registra as associações entre livros e autores.

| Campo | Tipo | Chave | Referência |
|---|---|---|---|
| Livro_Codl | INTEGER | FK | Livro.Codl |
| Autor_CodAu | INTEGER | FK | Autor.CodAu |

Cada registro representa a associação de um livro a um autor.

A proposta de chave primária é composta pelos campos Livro_Codl e Autor_CodAu. Essa combinação impede que o mesmo autor seja associado duas vezes ao mesmo livro.

O diagrama também prevê índices para os campos Livro_Codl e Autor_CodAu. Na implementação, os índices serão conferidos considerando aqueles já atendidos pela chave composta.

## Livro_Assunto

Registra as associações entre livros e assuntos.

| Campo | Tipo | Chave | Referência |
|---|---|---|---|
| Livro_Codl | INTEGER | FK | Livro.Codl |
| Assunto_codAs | INTEGER | FK | Assunto.codAs |

Cada registro representa a associação de um livro a um assunto.

A proposta de chave primária é composta pelos campos Livro_Codl e Assunto_codAs. Essa combinação impede que o mesmo assunto seja associado duas vezes ao mesmo livro.

O diagrama também prevê índices para os campos Livro_Codl e Assunto_codAs. Na implementação, os índices serão conferidos considerando aqueles já atendidos pela chave composta.

## Relacionamentos

### Livro e Autor

O relacionamento é muitos para muitos.

- Um livro pode possuir vários autores.
- Um autor pode participar de vários livros.
- A tabela Livro_Autor registra essas associações.

### Livro e Assunto

O relacionamento é muitos para muitos.

- Um livro pode possuir vários assuntos.
- Um assunto pode ser associado a vários livros.
- A tabela Livro_Assunto registra essas associações.

## Exemplo de associação entre livro e autores

Considere um livro de código 1 e dois autores de códigos 10 e 20.

A tabela Livro terá um registro para esse livro. A tabela Autor terá os registros dos dois autores.

A tabela Livro_Autor terá estas associações.

| Livro_Codl | Autor_CodAu |
|---|---|
| 1 | 10 |
| 1 | 20 |

Se o autor 10 participar também do livro 2, será acrescentada esta associação.

| Livro_Codl | Autor_CodAu |
|---|---|
| 2 | 10 |

## View para o relatório

O desafio exige uma view no banco como origem da consulta do relatório.

Essa view deverá disponibilizar informações de Livro, Autor e Assunto, utilizando as tabelas associativas para estabelecer os vínculos.

O relatório deverá agrupar os dados por autor e considerar livros com múltiplos autores.

A consulta e a apresentação deverão ser verificadas com um livro que tenha múltiplos autores e assuntos, evitando repetições artificiais na exibição dos dados.

## Decisões propostas nesta modelagem

- Utilizar DECIMAL(10,2) para o valor monetário.
- Utilizar chave primária composta em Livro_Autor.
- Utilizar chave primária composta em Livro_Assunto.
- Preservar os nomes, tipos e tamanhos dos campos fornecidos no diagrama.

## Decisões pendentes

- Definir a geração automática dos identificadores.
- Definir a obrigatoriedade dos campos de negócio.
- Definir se o cadastro exige pelo menos um autor e um assunto.
- Definir o comportamento da exclusão de registros vinculados.
- Definir a validação de edição, ano de publicação e valor.