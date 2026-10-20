# 🛠️ AssistênciaCi - Sistema de Gestão e Website Institucional

> **Projeto Integrador Final**  
> **Unidades Curriculares:** PBE (Fundamentos de Desenvolvimento Web com PHP), LIMA (Linguagem de Marcação - HTML5/CSS3) & BCD (Banco de Dados - Postgresql)
> 
---

## 1.0 Informações de Acesso e Recursos

### 1.1 Credenciais do Administrador
- **Usuário:** `administrador`
- **E-mail:** `adm@adm.com`
- **Senha:** `adm123`

### 1.2 Recursos e Histórico
- **Link do Prompt Gemini:** [Acessar Histórico do Prompt](https://gemini.google.com/share/d/1Q3Co3QRE4-btWaFgpMq0IkcRZLLiZM50?usp=sharing)
- **Repositório do Projeto:** [GitHub - Assist-nciaCI-](https://github.com/Gregorio14izi/Assist-nciaCI-)

---

## 2.0 Visão Geral e Apresentação do Projeto

### 2.1 Apresentação do Sistema
A **AssistênciaCi** é uma aplicação integradora desenvolvida para atender simultaneamente aos critérios das disciplinas PBE e LIMA. O sistema combina uma interface institucional pública acessível desenvolvida com HTML5 semântico e Bootstrap 5 com um painel administrativo completo de gestão de bancada construído em PHP estruturado e banco de dados PostgreSQL.

### 2.2 História e Contexto da Empresa
A **AssistênciaCi** nasceu de uma forma totalmente espontânea: a partir de uma brincadeira descontraída entre amigos apaixonados por abrir, entender e consertar aparelhos eletrónicos. Para eternizar esse capítulo marcante e celebrar a união do grupo, transformamos essa brincadeira em um marco oficial na história da empresa, unindo o companheirismo à excelência técnica no atendimento e manutenção.

---

## 3.0 Arquitetura e Funcionalidades do Sistema

### 3.1 Módulo LIMA (Website Institucional Público)
- **3.1.1 Página Inicial (`index.php`):** Apresentação do negócio, navegação central e painel de avisos.
- **3.1.2 Página Sobre (`sobre.php`):** História da fundação, missão, visão, valores e imagem institucional da bancada (`assets/img/oficina.svg`).
- **3.1.3 Página de Serviços (`servicos.php`):** Catálogo visual de serviços e **Tabela Comparativa Transparente de Preços** em HTML5.
- **3.1.4 Página de Contato (`contato.php`):** Formulário interativo com validações nativas (`required`, `placeholder`, `<label>`), informações de contato e horário de funcionamento.

### 3.2 Módulo PBE (Sistema de Gestão Back-end & CRUD PHP)
- **3.2.1 Gestão de Clientes:** Cadastro (`CREATE`), Listagem (`READ`), Edição (`UPDATE`) e Remoção (`DELETE`).
- **3.2.2 Gestão de Ordens de Serviço (O.S.):**
  - Vinculação de O.S. a novos clientes ou clientes já existentes.
  - Atualização dinâmica de status na bancada (`Em Análise`, `Aguardando Peça`, `Em Manutenção`, `Pronto para Retirada`, `Entregue`).
  - **Regra de Negócio de Validação de Datas:** Validação de prazo mínimo de retirada de pelo menos **1 dia de espera** (a partir do dia seguinte), aplicada via atributo HTML `min` no formulário e verificação de segurança no servidor PHP.
- **3.2.3 Inventário de Ferramentas (`app/ferramentas.php`):** Controle de estoque de ferramentas de bancada, quantidade com alteração rápida (`+`/`-`) e estado de conservação.
- **3.2.4 Mural de Avisos (`app/salvar_mural.php`):** Quadro de avisos, lembretes e entregas urgentes editável pelo administrador.
- **3.2.5 Autenticação e Segurança:** Controle de acesso com verificação de sessão em PHP (`session_start()`) e rotas protegidas em `login/`.

---

## 4.0 Diagramas Funcionais e Dinâmicos do Sistema

### 4.1 Diagrama de Arquitetura Funcional e Fluxo de Navegação Detalhado
O mapa abaixo ilustra detalhadamente as rotas públicas, os métodos HTTP utilizados, os pontos de controle de acesso via sessão PHP e as tabelas afetadas no PostgreSQL.

```mermaid
flowchart TD
    User([👤 Utilizador / Cliente]) --> PublicArea{Acesso à Aplicação}

    subgraph LIMA ["Módulo LIMA - Rotas Públicas (HTML5 / Bootstrap 5)"]
        PublicArea -->|GET /| Index[index.php<br/>Início & Mural de Avisos]
        PublicArea -->|GET /sobre.php| Sobre[sobre.php<br/>História & Valores]
        PublicArea -->|GET /servicos.php| Servicos[servicos.php<br/>Tabela de Preços]
        PublicArea -->|GET /contato.php| Contato[contato.php<br/>Formulário de Contato]
        
        Contato -->|POST submit| ContatoMock["Validação Nativa HTML5<br/>required / pattern"]
    end

    PublicArea -->|GET /login/login.php| LoginView[login/login.php<br/>Ecrã de Autenticação]
    LoginView -->|POST e-mail & senha| LoginProc[login/verifica_user.php<br/>Validador de Credenciais]

    subgraph AUTH ["Camada de Autenticação & Sessão"]
        LoginProc -->|Consulta Credenciais| DB_Users[(Tabela Usuarios / BD)]
        DB_Users -->|Credenciais Válidas| SessionSet["Inicia $_SESSION['usuario_id']"]
        DB_Users -->|Invalido| LoginError["Redireciona com erro_dados"] --> LoginView
    end

    SessionSet --> AdminGate{"Validação de Sessão<br/>session_start"}

    subgraph PBE ["Módulo PBE - Painel Administrativo & CRUD (Área Restrita)"]
        AdminGate -->|Sessão Ativa| AdminMain[app/select.php<br/>Painel Geral de Clientes]
        
        AdminMain -->|GET| CreateCliView[app/create.php<br/>Formulário de Cadastro]
        CreateCliView -->|POST INSERT| DB_Clientes[(Tabela clientes)]
        
        AdminMain -->|GET id| UpdateCliView[app/update.php<br/>Formulário de Edição]
        UpdateCliView -->|POST UPDATE| DB_Clientes
        
        AdminMain -->|GET id_delete| DeleteCliProc[app/delete.php<br/>Processa Remoção]
        DeleteCliProc -->|DELETE SQL| DB_Clientes

        AdminMain -->|GET/POST| OSModule[app/ordens_servico.php<br/>Gestão de Ordens de Serviço]
        OSModule -->|Validação Data >= Amanhã| DB_Clientes

        AdminMain -->|GET/POST| ToolModule[app/ferramentas.php<br/>Inventário de Ferramentas]
        ToolModule -->|UPDATE qty/estado| DB_Tools[(Tabela ferramentas)]

        AdminMain -->|POST| MuralModule[app/salvar_mural.php<br/>Gravação do Recado]
        MuralModule -->|INSERT/UPDATE| DB_Mural[(Tabela mural)]
        
        AdminMain -->|GET /login/logout.php| Logout[Destrói Sessão] --> Index
    end

    AdminGate -.->|Sem Sessão| LoginView
