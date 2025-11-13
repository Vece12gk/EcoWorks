# 🌱 EcoTarefas

O *EcoTarefas* é um site que motiva pessoas a adotarem *hábitos sustentáveis* por meio de *missões diárias ecológicas*.  
A ideia é tornar o cuidado com o meio ambiente *algo simples, prático e divertido*, gamificando ações positivas no dia a dia.

---

## 🎯 Visão Geral

O usuário pode:

- Criar uma conta e fazer login.  
- Receber uma *missão verde por dia* (ex: “Recicle uma garrafa”).  
- Marcar se completou ou não.  
- Ganhar pontos e subir no ranking.  
- Acompanhar seu *impacto ambiental acumulado* (ex: “Você ajudou a economizar 20L de água!”).  

O projeto combina tecnologia e consciência ecológica para gerar *mudanças reais no comportamento sustentável*.

---

## 🧭 Estrutura do Projeto

O sistema é dividido em módulos principais:

### 🏠 index.php — Página Inicial
- Apresenta o propósito do site.  
- Mostra exemplos de missões sustentáveis.  
- Possui botões para *Login* e *Cadastro*.  

### 📝 register.php — Registro de Usuário
- Formulário com nome, e-mail e senha.  
- Envia dados ao backend (PHP) e salva no banco MySQL.  

### 🔐 login.php — Autenticação
- Verifica as credenciais do usuário.  
- Redireciona para o painel principal em caso de sucesso.  

### 🧩 dashboard.php — Painel do Usuário
- Exibe a missão diária (puxada do banco de dados).  
- Botão *“Concluir missão”*.  
- Mostra pontuação, ranking e impacto ambiental.  

### 🏆 ranking.php — Ranking Global
- Lista os usuários ordenados por pontuação.  
- Inclui medalhas (ouro, prata, bronze).  

### 👤 profile.php — Perfil do Usuário
- Estatísticas pessoais:  
  - Missões concluídas.  
  - Nível atual.  
  - Selos conquistados (ex: “Reciclador Iniciante”).  

---

## 💻 Tecnologias Utilizadas

| Tecnologia | Função no Projeto |
|-------------|------------------|
| *HTML* | Estrutura das páginas e formulários. |
| *CSS* | Estilo e identidade visual ecológica (tons de verde, ícones naturais, transições suaves). |
| *JavaScript (AJAX)* | Interatividade: atualiza dados sem recarregar a página e cria animações. |
| *PHP* | Lógica do servidor e conexão com o banco de dados. Controla login, ranking e missões. |
| *MySQL* | Armazena usuários, missões, pontos e histórico de ações. |

---

## 🔄 Fluxo de Funcionamento

1. *Cadastro e Login:*  
   O usuário cria uma conta e faz login.  
   → Dados são registrados no banco (PHP + MySQL).

2. *Recebimento da Missão:*  
   O sistema escolhe uma missão aleatória do banco (ex: “Evite usar copos descartáveis”).  
   → Mostra pontuação e descrição.

3. *Conclusão da Missão:*  
   Ao clicar em *“Concluir missão”*, o JavaScript envia uma requisição ao PHP.  
   → O banco atualiza a pontuação do usuário.  
   → A interface exibe animação e mensagem de sucesso.

4. *Ranking e Impacto:*  
   O ranking é atualizado automaticamente com base na pontuação.  
   O painel mostra o *impacto ambiental acumulado*.

---

## 🏅 Gamificação

O EcoTarefas usa *mecânicas de jogo* para incentivar a participação:

- *Pontos:* Cada missão vale entre 5 e 20 pontos.  
- *Níveis:* A cada 100 pontos, o usuário sobe de nível (ex: “Verde Iniciante”, “Herói da Terra”).  
- *Selos:* Conquistas visuais por categorias de missão (Reciclagem, Água, Energia, Mobilidade).  
- *Ranking Semanal:* Zera a cada semana, garantindo chances iguais a todos.

---

## 🌍 Exemplos de Missões Sustentáveis

*Reciclagem*
- “Separe o lixo hoje.”  
- “Leve o óleo usado a um ponto de coleta.”

*Consumo Consciente*
- “Compre apenas o que for realmente necessário.”  

*Energia*
- “Desligue aparelhos da tomada antes de dormir.”

*Água*
- “Tome banhos de no máximo 5 minutos.”  

*Transporte*
- “Vá a pé ou de bicicleta para algum compromisso.”

---



## 🧠 Conclusão

O *EcoTarefas* é mais do que um site — é um *movimento digital sustentável*.  
Através da tecnologia e da gamificação, o projeto busca *educar e engajar pessoas* a cuidarem do planeta de forma leve, diária e recompensadora. 🌎💚  

---

### 👨‍💻 Desenvolvido por
*Paulo Henrique Moraes Oliveira e Natan Vece dos Santos*   
Projeto acadêmico e social com foco em sustentabilidade e tecnologia.
