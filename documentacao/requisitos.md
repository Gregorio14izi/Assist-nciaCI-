Levantamento de Requisitos
Requisitos Funcionais (RF)
RF01 - Cadastro e Gestão de Clientes: Permitir criar, visualizar, atualizar e remover dados cadastrais dos clientes (Nome, E-mail, Telefone, CPF).

RF02 - Abertura de Ordem de Serviço (OS): Permitir que o cliente ou atendente cadastre uma nova solicitação registrando o tipo de equipamento (Celular, Notebook, Bike), marca/modelo, número de série e descrição do defeito.

RF03 - Consulta Pública de Status: Disponibilizar uma busca rápida na Home via código único da OS (ex: OS-8492) para o cliente verificar o andamento sem precisar fazer login.

RF04 - Painel Administrativo / Técnico: Permitir que o técnico visualize todas as OS ativas filtradas por status (Em Análise, Aguardando Peça, Em Manutenção, Pronto para Retirada, Entregue e Cancelado).

RF05 - Atualização da OS: Permitir que o técnico adicione o diagnóstico técnico, orçamento (mão de obra + peças) e altere o status da OS.

RF06 - Cancelamento/Exclusão de OS: Permitir cancelar ou remover chamados que ainda não foram iniciados.

RF07 - Catálogo de Serviços e Peças: Gerenciar a lista de serviços oferecidos (ex: Troca de Tela, Revisão Geral, Formatação) com preços base.

Requisitos Não-Funcionais (RNF)
RNF01 - Responsividade: A interface deve adaptar-se perfeitamente a dispositivos móveis e desktops.

RNF02 - Segurança e Autenticação: Apenas usuários autenticados (técnicos/administradores) podem alterar status de OS e preços.

RNF03 - Identificador Único: Cada OS deve gerar automaticamente um código alfa-numérico único e curto para facilitar a consulta rápida pelo cliente.