# Manual do usuário

## Apresentação

O Book Project permite organizar livros, autores e assuntos e gerar um relatório PDF com os livros agrupados por autor.

## Navegação

### Página inicial

Na página inicial você encontrará dois botões:

- **Documentações:** abre a página com os materiais de apoio do projeto.
- **Acessar o sistema:** abre a página com todo os recursos de gerenciamento.

### Documentações

Esta página apresenta uma tabela com os seguintes materiais:

- Checklist do projeto.
- Documentação técnica.
- Repositório no GitHub.
- Manual do usuário.

Clique em **Acessar**, na linha do documento desejado e o material será aberto em outra aba do navegador.

### Recursos do sistema

Ao clicar em **Acessar o sistema**, serão apresentados quatro atalhos:

| Atalho | Finalidade |
|---|---|
| Livros | Cadastrar, consultar, editar e excluir livros |
| Autores | Cadastrar, consultar, editar e excluir autores |
| Assuntos | Cadastrar, consultar, editar e excluir assuntos |
| Relatório por autor | Gerar o relatório PDF de livros agrupados por autor |

Clique no card correspondente para acessar o recurso.

### Retornar e alternar entre páginas

Nas páginas de navegação e nas telas de cadastro, clique na logo Book Project para retornar à página inicial.

Nas telas internas, o menu superior permite alternar diretamente entre Livros, Autores, Assuntos e Relatório PDF.

## Ordem sugerida de utilização

1. Na página inicial, clique em **Acessar o sistema**.
2. Acesse **Autores** e cadastre os autores.
3. Acesse **Assuntos** e cadastre os assuntos.
4. Acesse **Livros**, preencha os dados e selecione as associações.
5. Acesse **Relatório por autor** para visualizar o PDF.

## Autores

### Cadastrar

1. Acesse Autores.
2. Clique em Novo autor.
3. Informe o nome do autor, com até 40 caracteres.
4. Clique em Salvar.

### Editar

1. Localize o autor na listagem.
2. Clique em Editar.
3. Altere o nome.
4. Clique em Salvar.

### Excluir

Clique em Excluir na linha do autor.

Se o autor estiver associado a algum livro, a exclusão será impedida e uma mensagem explicará o motivo.

Para permitir a exclusão, edite os livros relacionados e remova a associação com esse autor.

## Assuntos

### Cadastrar

1. Acesse Assuntos.
2. Clique em Novo assunto.
3. Informe uma descrição de até 20 caracteres.
4. Clique em Salvar.

### Editar

Clique em Editar na linha do assunto, altere a descrição e salve.

### Excluir

Clique em Excluir na linha correspondente.

Assuntos associados a livros não podem ser excluídos. Remova os vínculos nos livros antes de tentar novamente.

## Livros

### Cadastrar

1. Acesse Livros.
2. Clique em Novo livro.
3. Preencha os campos.
4. Selecione os autores e assuntos desejados.
5. Clique em Salvar.

| Campo | Orientação |
|---|---|
| Título | Obrigatório, até 40 caracteres |
| Editora | Obrigatório, até 40 caracteres |
| Edição | Número inteiro positivo |
| Ano de publicação | Quatro dígitos |
| Valor | Valor em reais, por exemplo 49,90 |
| Autores | Permite selecionar vários autores |
| Assuntos | Permite selecionar vários assuntos |

Na versão atual, é possível cadastrar um livro sem selecionar autores ou assuntos.

### Editar

1. Clique em Editar na linha do livro.
2. Altere os campos ou as seleções.
3. Clique em Salvar.

Para remover uma associação, desmarque o autor ou assunto correspondente antes de salvar.

### Excluir

Clique em Excluir na linha do livro.

A exclusão remove o livro e suas associações. Os cadastros dos autores e assuntos são preservados.

## Relatório PDF

Na página inicial, clique em **Acessar o sistema** e depois em **Relatório por autor**.

O relatório também pode ser aberto pelo botão **Relatório PDF** do menu superior das telas internas.

O sistema gera um documento com os livros agrupados por autor. O relatório apresenta título, editora, edição, ano de publicação, valor e assuntos.

Um livro com vários autores aparece no grupo de cada autor.

Livros sem autor são apresentados no grupo Sem autor cadastrado.

O PDF pode ser visualizado, salvo ou impresso pelos recursos disponíveis no navegador.

## Mensagens e erros

Ao concluir uma operação, o sistema apresenta uma mensagem de sucesso.

Quando os dados não atendem às regras, os campos apresentam mensagens de validação.

A exclusão de autores e assuntos vinculados apresenta uma mensagem de impedimento.

As páginas de erro podem indicar:

| Código | Significado |
|---|---|
| 403 | A solicitação não foi permitida |
| 404 | Página ou registro não encontrado |
| 500 | Ocorreu uma falha inesperada |
| 503 | Um serviço necessário está temporariamente indisponível |

Nas páginas de erro, utilize Voltar ao início para retornar à navegação.

Em caso de interrupção durante uma gravação, confira a listagem antes de repetir a operação.

## Utilização em dispositivos menores

Em telas menores, os elementos são reorganizados para facilitar a navegação.

Quando uma tabela não couber na largura disponível, utilize a rolagem horizontal para acessar as demais colunas.