# Documentação técnica

## Visão geral

O Book Project é uma aplicação monolítica com páginas renderizadas no servidor.

O Symfony recebe as requisições, executa os controllers e utiliza os serviços e repositories necessários. As páginas são produzidas pelo Twig.

O acesso aos dados é realizado pelo Doctrine. O relatório utiliza uma consulta DBAL sobre uma view do MySQL.

## Organização

| Diretório | Responsabilidade |
|---|---|
| src/Controller | Rotas, recebimento das requisições e respostas |
| src/Entity | Entidades, mapeamento e regras de validação |
| src/Form | Definição dos formulários Symfony |
| src/Repository | Persistência e consultas |
| src/Service | Agrupamento dos dados do relatório |
| src/EventListener | Tratamento centralizado de falhas de conexão |
| templates | Páginas e componentes Twig |
| config | Configurações da aplicação |
| migrations | Histórico das alterações no banco |
| tests | Testes automatizados |
| .sass | Código-fonte dos estilos |
| public | Entrada pública e arquivos acessíveis pelo navegador |

## Fluxo de cadastro e edição

1. O controller cria o formulário associado à entidade.
2. handleRequest() processa os dados da requisição.
3. isSubmitted() identifica o envio.
4. isValid() verifica os dados utilizando as regras configuradas.
5. O repository solicita a persistência.
6. flush() executa as operações no banco.
7. Após o sucesso, o usuário recebe uma mensagem e é redirecionado.

O redirecionamento após a gravação evita que atualizar a página repita o envio anterior.

## Escolhas técnicas

### Symfony

Foi utilizado para atender à stack solicitada e organizar rotas, formulários, validação, serviços e tratamento de exceções.

### Twig

Foi utilizado para renderizar as páginas e compartilhar layouts e componentes.

A herança de templates organiza a estrutura das páginas. Os includes reutilizam partes menores, como cards, mensagens e ações de registros.

### Doctrine ORM e DBAL

O ORM realiza o mapeamento entre as entidades PHP e as tabelas, além de administrar as associações.

O DBAL é utilizado na consulta do relatório, que precisa buscar os dados de uma view.

PDO continua sendo o driver de acesso ao MySQL. Doctrine adiciona recursos de mapeamento, consultas e administração das entidades sobre essa comunicação.

### MySQL

Foi escolhido por oferecer os recursos relacionais necessários: chaves estrangeiras, tabelas associativas, índices, tipos decimais e views.

O ambiente de desenvolvimento utiliza uma instância remota. Por isso, os tempos de resposta também dependem da conectividade com o serviço.

### Bootstrap e Sass

Bootstrap oferece classes de layout, formulários, tabelas e botões. Sass permite personalizar variáveis, como a cor principal, e gerar o CSS utilizado pelo navegador.

O JavaScript do Bootstrap é disponibilizado localmente. A validação dos formulários utiliza os recursos HTML configurados e a validação do Symfony no servidor.

### Dompdf

Converte o HTML do relatório em PDF. O template do relatório possui estilos próprios para o documento.

### PHPUnit

Verifica regras das entidades e o agrupamento dos dados do relatório.

A presença de testes automatizados não significa, por si só, que o desenvolvimento tenha seguido TDD.

## Persistência e relacionamentos

Livro possui coleções de autores e assuntos.

As associações são muitos para muitos e são persistidas nas tabelas Livro_Autor e Livro_Assunto.

O método listarComRelacionamentos() carrega livros e suas associações na mesma consulta do ORM, evitando consultar cada coleção separadamente durante a listagem.

As migrations registram a evolução do banco. Alterações já aplicadas devem ser complementadas por novas migrations, preservando o histórico.

## Valores monetários

Valor é armazenado em DECIMAL(10,2) no MySQL e representado como string na entidade.

O formulário utiliza MoneyType, moeda BRL e entrada em string. A apresentação utiliza a formatação brasileira.

## Relatório

O relatório segue este fluxo:

1. RelatorioRepository consulta vw_relatorio_livros.
2. RelatorioLivrosService agrupa as linhas pelo identificador do autor.
3. Dentro de cada autor, os livros são identificados pelo código.
4. Os assuntos são organizados por identificador para evitar repetições.
5. Twig produz o HTML.
6. Dompdf gera um PDF A4 em orientação retrato.

Um livro com dois autores aparece no grupo de cada autor. As combinações produzidas pelos relacionamentos não devem gerar cópias do mesmo livro dentro de um grupo.

Autores com o mesmo nome permanecem separados porque o agrupamento utiliza o identificador.

## Tratamento de erros

| Situação | Comportamento |
|---|---|
| Dados inválidos | Formulário apresenta as mensagens de validação |
| Autor ou assunto vinculado a livro | Exclusão impedida com mensagem explicativa |
| Registro inexistente | Resposta 404 |
| Token CSRF inválido | Resposta 403 |
| Falha de conexão | Resposta 503 |
| Deadlock ou espera por bloqueio nas escritas de livros | Resposta 503 |
| Falha inesperada não tratada especificamente | Resposta 500 |

As exclusões de autores e assuntos tratam ForeignKeyConstraintViolationException.

LivroController trata DeadlockException e LockWaitTimeoutException nas operações de escrita.

DatabaseExceptionListener identifica ConnectionException, inclusive quando encapsulada por outra exceção, e converte a falha em ServiceUnavailableHttpException.

As páginas amigáveis são renderizadas pelo template de erro do Twig. Em desenvolvimento, o modo debug mantém os detalhes técnicos para diagnóstico.

## Segurança

- Validação no servidor antes da persistência.
- Proteção CSRF nos formulários.
- Exclusões disponíveis somente por POST.
- Escape padrão do Twig na apresentação dos dados.
- Credenciais mantidas fora do versionamento.
- Detalhes técnicos ocultados das páginas de produção.

A aplicação não possui autenticação ou controle de perfis de usuário.

## Testes e limites atuais

Na última execução verificada, a suíte apresentou 43 testes e 71 assertions.

São verificados:

- Campos obrigatórios e limites das entidades.
- Formatos de ano e valor.
- Inclusão e remoção de associações.
- Agrupamento do relatório e eliminação de repetições.

Esses testes não substituem a validação funcional completa das telas nem comprovam todos os cenários de integração com o banco.

A aplicação ainda não possui paginação, uma rotina automática de recuperação de conexões ou repetição automática de gravações após falha.