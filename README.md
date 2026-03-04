# 🚀 Condo-Pro

> **Plataforma Inteligente de Gestão de Encomendas e Notificações Condominiais.**

O **Condo-Pro** é uma solução Full-Stack desenvolvida para modernizar a logística interna de condomínios residenciais e comerciais. O foco principal é eliminar protocolos manuais e falhas de comunicação, conectando a portaria diretamente ao morador através de notificações automatizadas via WhatsApp.

---

## 📌 Resumo do Projeto

Em condomínios de médio e grande porte, o fluxo de encomendas é um desafio logístico. O **Condo-Pro** simplifica esse processo: o porteiro registra a chegada da mercadoria em segundos e o sistema gera um alerta imediato para o morador. 

### 🎯 Finalidade
Prover agilidade na entrega interna, garantir a rastreabilidade das mercadorias e oferecer uma interface administrativa poderosa para síndicos e administradores master gerirem múltiplas unidades de forma isolada e segura.

---

## ✨ Vantagens e Diferenciais

* **Comunicação Ágil:** Notificações via WhatsApp com apenas um clique, reduzindo o tempo de permanência de pacotes na portaria.
* **Arquitetura Multi-Condomínio (Multi-tenant):** Isolamento total de dados. Um único banco de dados serve múltiplos condomínios, garantindo que porteiros e síndicos vejam apenas o que lhes pertence.
* **Importação Inteligente:** Cadastro em massa de moradores e unidades através de planilhas CSV geradas dinamicamente com base na planta do prédio.
* **Baixo Custo Operacional:** Sistema leve, rodando em ambiente Docker (Laravel Sail), otimizado para nuvem (Oracle Cloud).
* **Interface Clean & Funcional:** Desenvolvido com Tailwind CSS, focado na produtividade de quem opera o sistema diariamente.

---

## 🖥️ Telas e Fluxos Principais

### 1. Painel Administrativo (Master)
* Visão global de faturamento e uso por condomínio.
* Criação e gerenciamento de novos condomínios clientes.
* Alternância rápida de contexto entre condomínios.

### 2. Gestão de Encomendas
* Listagem em tempo real de pacotes pendentes.
* Botões de ação rápida com feedback visual (Cores indicando: `Aguardando`, `Notificado` e `Entregue`).
* Busca inteligente por morador ou unidade.

### 3. Configurações Físicas
* Definição de limites do condomínio: Total de blocos, andares e apartamentos por andar.
* Geração de modelo de planilha personalizado para o "onboarding" do condomínio.

### 4. Gestão de Unidades e Moradores
* Controle de quem reside em cada apartamento.
* Vínculo direto de números de WhatsApp para envios rápidos.



---

## 🛠️ Features Técnicas

- [x] **Global Scopes:** Segurança em nível de Query para isolamento de dados por `condominio_id`.
- [x] **Dynamic CSV Generator:** Criação de planilhas de exemplo "on-the-fly" baseadas nas configurações do banco.
- [x] **Fast Import:** Motor de importação que cria Unidades e Moradores simultaneamente, evitando duplicidade.
- [x] **UI Reativa:** Mensagens de sucesso e erro com auto-hide (JS) e botões de estado dinâmico.

---

## 🚀 Roadmap (Futuras Melhorias)

- [ ] **Sistema de Convites:** Envio de e-mail assinado para Síndicos e Porteiros definirem suas próprias senhas de acesso.
- [ ] **Dashboard Estatística:** Gráficos de volume de encomendas e tempo médio de retirada.
- [ ] **Assinatura Digital:** Registro da rubrica do morador no tablet/celular no momento da retirada.
- [ ] **Integração com API WhatsApp Business:** Para envios 100% automáticos e sem intervenção humana.

---

## ⚙️ Stack Tecnológica

* **Backend:** PHP 8.x + Laravel 11
* **Frontend:** Tailwind CSS + Alpine.js + Blade Components
* **Banco de Dados:** MySQL
* **Infraestrutura:** Docker (Laravel Sail)
* **Processamento de Dados:** Laravel Excel (Maatwebsite)

---

> 💡 *Nota: "Condo-Pro" é um nome de trabalho. O projeto está em fase final de ajustes de arquitetura de convites e dashboard de indicadores.*
