# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Semantic Versioning](https://semver.org/lang/pt-BR/).

## [2.0.0] - 2025-11-14

### 🎉 Adicionado

#### Infraestrutura
- **`.htaccess` completo** para Apache com:
  - Rewrite rules limpas e seguras
  - Compressão GZIP para todos os assets
  - Cache agressivo de imagens, CSS, JS e fontes
  - Headers de segurança (X-Frame-Options, XSS-Protection, etc.)
  - Proteção de arquivos sensíveis (.env, .sql, .log)
  - Configurações PHP otimizadas
  - Bloqueio de listagem de diretórios

- **`.env.example`** - Template de variáveis de ambiente com:
  - Configurações de banco de dados
  - Variáveis de aplicação
  - Configurações de sessão
  - Limites de upload
  - Integração com Cloudflare (opcional)
  - Configurações SMTP (opcional)
  - Suporte para APIs externas

#### CSS
- **Comentários em português** em todo o arquivo `style.css`
- **Media queries responsivas** para:
  - Tablets (max-width: 1024px)
  - Mobile (max-width: 768px)
  - Mobile pequeno (max-width: 480px)
- **Melhorias de performance:**
  - Transições suaves em elementos interativos
  - Otimização de rendering de imagens
  - Scroll otimizado para mobile
- **Classes utilitárias:**
  - `.text-center`, `.text-left`, `.text-right`
  - `.hidden`, `.visible`
  - `.loading` para estados de carregamento
  - `.sr-only` para acessibilidade
- **Melhorias de acessibilidade:**
  - Outline visível em elementos focados
  - Estilos para leitores de tela

#### JavaScript
- **Comentários em português** em todo o arquivo `script.js`
- **Melhor tratamento de erros AJAX:**
  - Callbacks `.fail()` para erros de rede
  - Callbacks `.always()` para cleanup
  - Logging de erros no console
  - Mensagens amigáveis ao usuário
- **Loading states:**
  - Feedback visual durante operações AJAX
  - Estados de carregamento em formulários
- **Validações aprimoradas:**
  - Verificação de IDs válidos antes de requisições
  - Proteção contra requisições duplicadas

#### Documentação
- **README.md completo** em português com:
  - Badges de tecnologias
  - Índice navegável
  - Descrição detalhada do projeto
  - Lista completa de funcionalidades
  - Stack tecnológico documentado
  - Guia de instalação passo a passo
  - Instruções para Apache e Nginx
  - Configuração de banco de dados
  - Guia de deploy (Scalingo e Heroku)
  - Estrutura de arquivos comentada
  - Seção de contribuição
  - Roadmap de features futuras
  - Licença e créditos

- **CHANGELOG.md** - Documentação de todas as mudanças

### 🔧 Modificado

#### CSS
- Reorganização dos estilos com seções claramente demarcadas
- Adicionado `z-index` ao player para garantir sobreposição correta
- Melhorada responsividade da barra lateral em mobile
- Otimizados seletores para melhor performance

#### JavaScript
- Refatoração da função `openPage()` com melhor tratamento de erros
- Adicionado feedback de erro em requisições AJAX
- Melhorada validação de dados antes de envio
- Código organizado em seções com comentários

#### Configuração
- Arquivo `config.php` já suporta variáveis de ambiente
- Suporte para detecção automática de `SCALINGO_MYSQL_URL`
- Fallback para configuração local de desenvolvimento

### 🐛 Corrigido
- Potenciais erros AJAX agora são capturados e reportados
- Melhor handling de sessões expiradas
- Correção de problemas de layout em telas pequenas

### 🔒 Segurança
- Headers de segurança no `.htaccess`
- Proteção contra clickjacking (X-Frame-Options)
- Proteção XSS (X-XSS-Protection)
- Prevenção de MIME type sniffing
- Bloqueio de acesso a arquivos sensíveis
- Referrer Policy configurado

### ⚡ Performance
- Compressão GZIP ativada para todos os text assets
- Cache agressivo de imagens (1 ano)
- Cache otimizado de CSS/JS (1 mês)
- Remoção de ETag (usando Cache-Control)
- Otimização de rendering de imagens
- Transições CSS com `transform` para melhor performance

### 📱 Responsividade
- Barra lateral colapsável em mobile
- Player adaptado para telas pequenas
- Grid responsivo de álbuns/artistas
- Inputs de busca otimizados para mobile
- Layout fluído em todas as resoluções

### ♿ Acessibilidade
- Classes `.sr-only` para leitores de tela
- Focus visível em elementos interativos
- Estrutura semântica mantida
- ARIA attributes podem ser adicionados facilmente

## [1.0.0] - 2020-07-29

### Adicionado
- Versão inicial do projeto
- Sistema de autenticação completo
- Player de música HTML5
- Gerenciamento de playlists
- Sistema de busca
- Páginas de álbum e artista
- Configurações de usuário

---

## Tipos de Mudanças

- `Adicionado` para novas funcionalidades
- `Modificado` para mudanças em funcionalidades existentes
- `Depreciado` para funcionalidades que serão removidas
- `Removido` para funcionalidades removidas
- `Corrigido` para correções de bugs
- `Segurança` para vulnerabilidades corrigidas

## Versionamento

Este projeto usa [Semantic Versioning](https://semver.org/lang/pt-BR/):
- **MAJOR** version para mudanças incompatíveis na API
- **MINOR** version para funcionalidades adicionadas de forma retrocompatível
- **PATCH** version para correções de bugs retrocompatíveis
