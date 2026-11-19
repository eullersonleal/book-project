# Checklist do desafio

Este documento distingue os recursos implementados das verificações necessárias para concluir a entrega.

## Requisitos implementados

| Requisito | Implementação |
|---|---|
| Aplicação web em PHP, Symfony e Twig | Controllers, formulários e templates |
| CRUD de livros | LivroController, LivroType e templates de livros |
| CRUD de autores | AutorController, AutorType e templates de autores |
| CRUD de assuntos | AssuntoController, AssuntoType e templates de assuntos |
| Página inicial com navegação | Home e cards de acesso |
| Modelo relacional do desafio | Entidades e migrations |
| Múltiplos autores por livro | Livro_Autor e coleção de autores |
| Associação entre livros e assuntos | Livro_Assunto e coleção de assuntos |
| Campo de valor em reais | Valor, MoneyType e formatação na apresentação |
| CSS para cores e tamanhos | Bootstrap e personalização Sass |
| Relatório utilizando componente | Dompdf |
| Consulta proveniente de view | vw_relatorio_livros |
| Dados das três tabelas principais no relatório | Consulta da view e template PDF |
| Agrupamento por autor | RelatorioLivrosService |
| Tratamentos específicos de erros | Controllers e DatabaseExceptionListener |
| Scripts de criação e evolução do banco | Doctrine Migrations |
| Testes automatizados | PHPUnit |

TDD é um diferencial do desafio. Não é declarado como metodologia seguida apenas pela existência dos testes.

## Verificações já executadas

- [x] Execução da suíte: 43 testes e 71 assertions.
- [x] Verificação de sintaxe dos templates Twig.
- [x] Verificação dos arquivos YAML.
- [x] Verificação do mapeamento das entidades.
- [x] Conferência do registro do listener de exceções.

Esses itens registram verificações realizadas durante o desenvolvimento. Devem ser repetidos quando alterações posteriores puderem afetá-los.

## Validação funcional final

Validação funcional confirmada pelo responsável pelo projeto em 18/11/2026.

- [x] Cadastrar, editar e excluir um autor sem vínculos.
- [x] Cadastrar, editar e excluir um assunto sem vínculos.
- [x] Cadastrar e editar um livro com todos os campos.
- [x] Associar dois autores e dois assuntos ao mesmo livro.
- [x] Remover uma associação durante a edição.
- [x] Conferir a formatação de valor na tela e no PDF.
- [x] Verificar mensagens de validação dos campos.
- [x] Confirmar o impedimento de excluir autor e assunto vinculados.
- [x] Excluir um livro e conferir a preservação dos autores e assuntos.
- [x] Conferir o relatório com múltiplos autores e assuntos.
- [x] Conferir o relatório com a base sem livros.
- [x] Conferir as páginas em largura de celular.
- [x] Conferir página inexistente com debug desativado.
- [x] Conferir os cenários de indisponibilidade sem expor detalhes técnicos.

## Preparação da entrega

- [x] Salvar e revisar README e demais documentos.
- [ ] Reproduzir a instalação em uma base vazia.
- [x] Confirmar que as migrations também criam a view.
- [x] Criar o repositório no GitHub.
- [x] Enviar os commits.
- [x] Confirmar que o repositório está publicamente acessível.
- [x] Substituir os links provisórios da Home.
- [x] Confirmar que credenciais e arquivos locais não foram publicados.
- [x] Preparar o ambiente para demonstração desde o início da entrevista.
- [ ] Enviar o endereço do repositório conforme as orientações recebidas.