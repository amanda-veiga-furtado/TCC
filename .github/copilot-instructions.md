# copilot-instructions.md

## 📌 Visão Geral do Projeto

Este projeto consiste em um **Sistema Web de Compartilhamento de Receitas**, permitindo que usuários publiquem, pesquisem e interajam com receitas culinárias.

O sistema possui dois perfis principais:

- **Usuário**
- **Administrador**

A aplicação deve seguir arquitetura em **três camadas** (cliente, servidor web e servidor de aplicação/banco de dados) e utilizar:

- HTML
- CSS
- PHP
- JavaScript
- MySQL

Todo o sistema deve ser apresentado **exclusivamente em língua portuguesa**.

---

# 🧩 Requisitos Funcionais

## RF001 – Registrar e Manter Perfil de Acesso

**Prioridade:** Essencial

### Descrição

- Permitir auto cadastro com:
  - Nome de usuário
  - E-mail
  - Senha
- Permitir:
  - Upload de foto de perfil
  - Alteração de nome de usuário
  - Alteração de foto de perfil

### Regras

- E-mail e nome de usuário devem ser únicos.
- E-mail deve ter formato válido.
- Senha deve ser criptografada com `password_hash()` do PHP.

---

## RF002 – Login

**Prioridade:** Essencial

### Descrição

- Permitir login via:
  - E-mail
  - Senha

### Regras

- Validar formato do e-mail.
- Validar credenciais.
- Redirecionar para perfil após login.
- Exibir mensagem "Login inválido" em caso de erro.

---

## RF003 – Recuperar Conta

**Prioridade:** Importante

### Descrição

- Permitir redefinição de senha via e-mail.
- Enviar link de recuperação.
- Permitir criação de nova senha.
- Link deve expirar.

---

## RF004 – Consultar Receitas

**Prioridade:** Essencial

### Deve permitir busca por:

1. Nome da receita
2. Categoria
3. Ingredientes selecionados

### Regras

- Exibir mensagem quando não houver resultados.
- Pesquisa por ingrediente só é válida se pelo menos um for selecionado.
- Ingredientes pré-selecionados:
  - Água
  - Sal
  - Açúcar
  - Óleo
  - Vinagre
  - Orégano
  - Azeite
  - Ketchup
  - Mostarda
  - Maionese
  - Manteiga

---

## RF005 – Interagir com Receita

**Prioridade:** Desejável

### Permitir:

- Favoritar receita
- Denunciar receita
- Comentar receita

### Regra

- Apenas usuários logados podem interagir.

---

## RF006 – Postar Receita

**Prioridade:** Essencial

### Campos obrigatórios:

- Nome da receita
- Tempo de preparo
- Quantidade de porções
- Lista de ingredientes
- Quantidade de cada ingrediente
- Modo de preparo

### Campos opcionais:

- Categoria
- Imagem (PNG ou formato válido)

### Regra

- Apenas usuários logados podem postar.

---

## RF007 – Deletar Receita (Administrador)

**Prioridade:** Importante

- Administrador pode excluir qualquer receita.

---

## RF008 – Banir Usuário

**Prioridade:** Importante

- Administrador pode suspender contas.
- Usuário banido não pode acessar o sistema.

---

## RF009 – Sugerir Ingrediente ou Categoria

**Prioridade:** Desejável

- Usuário logado pode enviar sugestões.
- Sistema deve exibir confirmação.

---

## RF010 – Editar e Deletar Receitas (Autor)

**Prioridade:** Essencial

- Usuário pode editar suas próprias receitas.
- Usuário pode excluir suas próprias receitas.
- Sistema deve validar campos obrigatórios.
- Validar formato da imagem.

---

## RF011 – Ver Categorias

**Prioridade:** Desejável

- Permitir visualizar receitas por categoria.
- Exemplo:
  - Culinária Portuguesa
  - Sem Lactose

---

## RF012 – Calcular Porção

**Prioridade:** Desejável

- Permitir inserir nova quantidade de porções.
- Sistema deve recalcular automaticamente os ingredientes.
- Exibir erro caso valor inválido seja inserido.

---

# 🔐 Requisitos Não Funcionais

## RNF001 – Senha Criptografada

- Utilizar `password_hash()` do PHP.
- Não permitir recuperação da senha original.

## RNF002 – Usabilidade

- Interface simples.
- Navegação intuitiva.

## RNF003 – Segurança Básica

- Prevenir códigos maliciosos.
- Campos (exceto e-mail e senha) não aceitar:

, /, @, <, >, #, $, %, &, \*, {, }, [, ]

## RNF004 – Idioma

- Todo o sistema deve estar em português.

## RNF005 – Arquitetura

- Arquitetura de 3 camadas:
  - Cliente
  - Servidor Web
  - Servidor de Aplicação + Banco

## RNF006 – Tecnologias

- HTML
- CSS
- PHP
- JavaScript

## RNF007 – Banco de Dados

- MySQL

---

# 📏 Regras de Negócio

## RN001

- E-mail e nome de usuário devem ser únicos.

## RN002

- Pesquisa de receita pode ser feita logado ou não.

## RN003

- Apenas usuários logados podem:
  - Favoritar
  - Comentar
  - Denunciar
  - Postar
  - Editar
  - Deletar
  - Sugerir ingredientes/categorias

## RN004

- Validar formato de e-mail antes do cadastro.

## RN005

- Recuperação de senha deve ocorrer via e-mail.

## RN006

- Pesquisa por ingrediente exige pelo menos um selecionado.

## RN007

- Ingredientes básicos devem estar pré-selecionados.

---

# 👥 Atores

## Usuário

Pessoa que utiliza o site para:

- Pesquisar receitas
- Publicar receitas
- Interagir com receitas

## Administrador

Responsável por:

- Gerenciar receitas
- Banir usuários
- Moderar conteúdo

---

# 🚧 Funcionalidades Ainda Não Implementadas

- Recuperação de conta
- Favoritar receitas
- Denunciar receitas
- Comentários
- Visualização por categoria
- Cálculo automático de porções
- Expansão de ingredientes/categorias no banco

---

# 🚀 Próximos Passos

- Integração com redes sociais
- Campo select com busca dinâmica para ingredientes
- Página inicial dinâmica com cards e atalhos
- Melhorias na experiência do usuário
- Expansão da base de dados

---

# 🎯 Diretrizes para o GitHub Copilot

Ao gerar código para este projeto, o Copilot deve:

1. Seguir arquitetura MVC (ou separação clara de camadas).
2. Validar todos os inputs no backend.
3. Usar prepared statements no MySQL.
4. Aplicar password_hash() para senhas.
5. Garantir mensagens de erro claras e em português.
6. Garantir que regras de negócio sejam respeitadas.
7. Manter código organizado e comentado.
8. Priorizar segurança contra SQL Injection e XSS.
9. Garantir responsividade básica da interface.
10. Evitar hardcoding de dados sensíveis.

---

# 📌 Objetivo Final

Criar uma plataforma segura, intuitiva e interativa para compartilhamento de receitas culinárias, promovendo colaboração entre usuários e mantendo controle administrativo eficiente.
