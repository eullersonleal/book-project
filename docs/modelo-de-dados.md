# Modelo de dados

O banco utiliza MySQL e possui três tabelas principais e duas tabelas associativas.

Os nomes e tamanhos foram preservados conforme o modelo do desafio. O campo Valor foi acrescentado em Livro para atender à solicitação adicional.

## Livro

| Coluna | Tipo | Característica |
|---|---|---|
| Codl | INT | Chave primária, AUTO_INCREMENT |
| Titulo | VARCHAR(40) | Obrigatório |
| Editora | VARCHAR(40) | Obrigatório |
| Edicao | INT | Obrigatório |
| AnoPublicacao | VARCHAR(4) | Obrigatório |
| Valor | DECIMAL(10,2) | Obrigatório |

Valor permite até oito dígitos na parte inteira e dois na parte decimal.

Na aplicação:

- Título e editora não podem ficar vazios.
- Edição deve ser positiva e respeitar o limite do inteiro utilizado.
- Ano de publicação deve conter quatro dígitos.
- Valor deve ser não negativo e respeitar o limite do campo.

## Autor

| Coluna | Tipo | Característica |
|---|---|---|
| CodAu | INT | Chave primária, AUTO_INCREMENT |
| Nome | VARCHAR(40) | Obrigatório |

O nome é validado como não vazio e limitado a 40 caracteres.

## Assunto

| Coluna | Tipo | Característica |
|---|---|---|
| codAs | INT | Chave primária, AUTO_INCREMENT |
| Descricao | VARCHAR(20) | Obrigatório |

A descrição é validada como não vazia e limitada a 20 caracteres.

## Livro_Autor

| Coluna | Referência |
|---|---|
| Livro_Codl | Livro.Codl |
| Autor_CodAu | Autor.CodAu |

A chave primária é composta pelas duas colunas e impede a repetição da mesma associação.

## Livro_Assunto

| Coluna | Referência |
|---|---|
| Livro_Codl | Livro.Codl |
| Assunto_codAs | Assunto.codAs |

A chave primária também é composta pelas duas colunas.

## Cardinalidades

- Um livro pode possuir vários autores.
- Um autor pode estar associado a vários livros.
- Um livro pode possuir vários assuntos.
- Um assunto pode estar associado a vários livros.

Na implementação atual, as seleções de autores e assuntos são opcionais no formulário do livro.

## Exclusões

As referências dos vínculos para Livro utilizam ON DELETE CASCADE.

Ao excluir um livro, seus vínculos são removidos. Os cadastros dos autores e dos assuntos permanecem.

As referências dos vínculos para Autor e Assunto utilizam ON DELETE RESTRICT.

Um autor ou assunto associado a livros não pode ser excluído enquanto os vínculos existirem.

O CASCADE definido aqui é uma regra de chave estrangeira do banco.

## View do relatório

A view vw_relatorio_livros reúne:

- Identificador e nome do autor.
- Identificador, título, editora, edição, ano e valor do livro.
- Identificador e descrição do assunto.

São utilizados LEFT JOINs para manter livros mesmo quando não possuem autores ou assuntos associados.

Uma linha representa uma combinação de livro, autor e assunto. O serviço do relatório organiza essas linhas para apresentar cada livro uma vez por autor e cada assunto uma vez por livro.

A view utiliza SQL SECURITY INVOKER. A consulta é executada com as permissões do usuário conectado.

## Evolução do schema

As migrations estão versionadas no repositório e incluem a criação das tabelas, o ajuste de nomes, os relacionamentos e a view.

Para aplicar alterações pendentes:

```bash
php bin/console doctrine:migrations:migrate
```

Para conferir o estado:

```bash
php bin/console doctrine:migrations:status
```

O histórico inclui inicialmente a criação de autor em minúsculas e uma migration posterior de renomeação para Autor. Em uma instalação nova, o histórico completo deve ser executado.