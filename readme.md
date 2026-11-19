# Desafio Spassu - Criação de um sistem de cadastro de livros

Esta é uma aplicação web para cadastro e gerenciamento de livros, autores e assuntos, desenvolvida como solução para um desafio técnico.

O sistema permite associar vários autores e assuntos a um livro e emitir um relatório PDF agrupado por autor. Os dados do relatório são consultados a partir de uma view no MySQL.

## Principais funcionalidades

- Cadastro, listagem, edição e exclusão de livros.
- Cadastro, listagem, edição e exclusão de autores.
- Cadastro, listagem, edição e exclusão de assuntos.
- Associação de múltiplos autores e assuntos aos livros.
- Cadastro e apresentação do valor do livro em reais.
- Relatório PDF com informações de livros, autores e assuntos.
- Validação dos formulários no servidor.
- Proteção CSRF nos formulários.
- Tratamento específico de falhas e páginas de erro.
- Interface responsiva com Bootstrap.

## Tecnologias utilizadas

| Tecnologia | Utilização |
|---|---|
| PHP e Symfony 7.4 | Aplicação e tratamento das requisições |
| Twig | Renderização das páginas e componentes |
| Doctrine ORM e DBAL | Persistência e consultas |
| Doctrine Migrations | Versionamento da estrutura do banco |
| MySQL 8.4 | Banco de dados relacional |
| Bootstrap 5.3 | Estilos, layout e componentes de interface |
| Sass | Personalização e compilação do CSS |
| Node.js e NPM | Dependências e comandos do front-end |
| Dompdf | Geração do relatório PDF |
| PHPUnit | Testes automatizados |

As versões exatas das dependências estão registradas nos arquivos composer.lock e package-lock.json.

## Ambiente de referência

O projeto foi desenvolvido com:

- PHP 8.5.4.
- Composer 2.
- MySQL 8.4.
- Node.js 22.
- NPM 10.

Embora o composer.json declare PHP 8.2 ou superior, as dependências exigem pelo menos PHP 8.4.1. Para reproduzir o ambiente de desenvolvimento, utilize PHP 8.5.

O PHP precisa das extensões exigidas pelo Composer e do driver pdo_mysql para acessar o banco. O ambiente de referência também possui intl para formatação localizada.

Verifique as dependências da plataforma com:

```bash
composer check-platform-reqs
```

## Como instalar

### 1. Obter o projeto

Substitua URL_DO_REPOSITORIO pelo endereço real:

```bash
git clone https://github.com/eullersonleal/book-project.git books
cd books
```

### 2. Configurar o ambiente

Crie o arquivo .env.local na raiz do projeto:

```dotenv
APP_ENV=dev
APP_DEBUG=1
APP_SECRET=SUBSTITUA_POR_UMA_CHAVE_ALEATORIA
DATABASE_URL="mysql://USUARIO:SENHA@127.0.0.1:3306/books?serverVersion=8.4.2&charset=utf8mb4"
```

Ajuste o usuário, senha, host, porta, banco e versão conforme o ambiente utilizado.

Os caracteres especiais nas credenciais precisam ser codificados para uso em uma URL.

Para gerar uma chave para APP_SECRET:

```bash
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

O arquivo .env.local contém configurações particulares e não deve ser versionado.

### 3. Como instalar as dependências

```bash
composer install
npm ci
```

### 4. Preparar o banco

É necessário um banco MySQL vazio e um usuário com permissões para criar tabelas, relacionamentos e views.

Se estiver utilizando MySQL local e o usuário tiver permissão para criar a base:

```bash
php bin/console doctrine:database:create --if-not-exists
```

Se a base já foi criada pelo provedor de hospedagem, essa etapa pode ser ignorada.

Execute as migrations:

```bash
php bin/console doctrine:migrations:migrate
```

As migrations criam as tabelas, os relacionamentos e a view utilizada no relatório.

Confira o estado das migrations:

```bash
php bin/console doctrine:migrations:status
```

### 5. Preparar os arquivos do front-end

```bash
npm run sass:compile

mkdir -p public/js
cp node_modules/bootstrap/dist/js/bootstrap.bundle.min.js public/js/
```

O CSS é gerado em public/css/style.min.css.

Durante o desenvolvimento, a recompilação automática pode ser iniciada em outro terminal:

```bash
npm run sass:watch
```

### 6. Iniciar a aplicação

```bash
php bin/console cache:clear
php -S 127.0.0.1:8000 -t public
```

Acesse:

http://127.0.0.1:8000

Para encerrar o servidor, pressione Ctrl+C.

## Testes e verificações

Execute os testes automatizados:

```bash
php bin/phpunit
```

Verifique os templates e as configurações:

```bash
php bin/console lint:twig templates
php bin/console lint:yaml config
```

Verifique o mapeamento das entidades:

```bash
php bin/console doctrine:schema:validate
```

A validação completa do schema exige conexão com o banco. Para conferir somente o mapeamento:

```bash
php bin/console doctrine:schema:validate --skip-sync
```

A suíte possui testes de validação das entidades, manipulação das associações e agrupamento dos dados do relatório.

## Principais endereços

| Página | Endereço |
|---|---|
| Início | / |
| Livros | /livros |
| Autores | /autores |
| Assuntos | /assuntos |
| Relatório PDF | /relatorios/livros |

## Apresentação e implantação

Na apresentação e em produção, utilize:

```dotenv
APP_ENV=prod
APP_DEBUG=0
```

O servidor web deve disponibilizar somente a pasta public e encaminhar as rotas da aplicação para public/index.php.

O servidor embutido do PHP é utilizado para desenvolvimento e demonstração local. A configuração definitiva de Apache, Nginx ou outro servidor depende da hospedagem escolhida.

No ambiente de implantação:

1. Configure as variáveis de ambiente e o acesso ao MySQL.
2. Instale as dependências de produção.
3. Disponibilize o CSS compilado e o JavaScript do Bootstrap.
4. Execute as migrations pendentes.
5. Limpe e aqueça o cache de produção.
6. Verifique as páginas, os formulários e o relatório.

Exemplo de comandos PHP para esse ambiente:

```bash
APP_ENV=prod APP_DEBUG=0 composer install --no-dev --optimize-autoloader
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```

Caso o front-end seja compilado durante a implantação, instale também as dependências de desenvolvimento do NPM:

```bash
npm ci --include=dev
npm run sass:compile
```

A aplicação ainda não possui uma hospedagem publicada documentada.

## Documentação

- [Documentação técnica](docs/documentacao_tecnica.md)
- [Modelo de dados](docs/modelo-de-dados.md)
- [Checklist do desafio](docs/checklist.md)
- [Manual do usuário](docs/manual-do-usuario.md)