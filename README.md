# 🎵 Spotify Clone - Plataforma de Streaming de Música

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

Um clone completo e funcional do Spotify construído com tecnologias web nativas, sem frameworks pesados. Este projeto demonstra conceitos avançados de desenvolvimento web full-stack.

![Spotify Clone Banner](assets/images/bg.jpg)

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
- [Deploy](#deploy)
- [Uso](#uso)
- [Estrutura de Arquivos](#estrutura-de-arquivos)
- [Contribuindo](#contribuindo)
- [Licença](#licença)

## 🎯 Sobre o Projeto

Este é um clone educacional do Spotify desenvolvido para demonstrar habilidades em desenvolvimento web full-stack. O projeto implementa as principais funcionalidades de uma plataforma de streaming de música, incluindo:

- Sistema completo de autenticação de usuários
- Player de áudio HTML5 com controles avançados
- Gerenciamento de playlists
- Sistema de busca em tempo real
- Interface responsiva inspirada no Spotify
- Navegação SPA (Single Page Application)

## ✨ Funcionalidades

### 👤 Autenticação
- ✅ Registro de novos usuários
- ✅ Login/Logout seguro
- ✅ Validação de dados no frontend e backend
- ✅ Sessões PHP seguras

### 🎵 Player de Música
- ✅ Reprodução de áudio HTML5
- ✅ Controles: Play, Pause, Próxima, Anterior
- ✅ Barra de progresso interativa
- ✅ Controle de volume
- ✅ Modo aleatório (shuffle)
- ✅ Modo de repetição
- ✅ Informações da música atual

### 📚 Gerenciamento de Conteúdo
- ✅ Navegação por álbuns
- ✅ Navegação por artistas
- ✅ Visualização de músicas por álbum
- ✅ Criação de playlists personalizadas
- ✅ Adicionar/remover músicas das playlists
- ✅ Deletar playlists

### 🔍 Busca
- ✅ Busca em tempo real
- ✅ Filtros por música, artista ou álbum
- ✅ Resultados instantâneos

### ⚙️ Configurações
- ✅ Atualizar email
- ✅ Alterar senha
- ✅ Perfil de usuário

## 🛠️ Tecnologias Utilizadas

### Backend
- **PHP 7.4+** - Linguagem principal do servidor
- **MySQL/MariaDB** - Banco de dados relacional
- **MySQLi** - Driver nativo de conexão

### Frontend
- **HTML5** - Estrutura semântica
- **CSS3** - Estilização moderna
- **JavaScript (Vanilla)** - Lógica do player
- **jQuery 3.x** - Manipulação DOM e AJAX

### Infraestrutura
- **Apache** - Servidor web
- **mod_rewrite** - URL rewriting
- **GZIP** - Compressão de assets

## 📦 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

```bash
# Servidor Web
- Apache 2.4+ ou Nginx
- PHP 7.4 ou superior
- MySQL 5.7+ ou MariaDB 10.3+

# Extensões PHP necessárias
- mysqli
- session
- json
- mbstring
```

## 🚀 Instalação

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/spotify-clone.git
cd spotify-clone
```

### 2. Configure o Servidor Web

#### Apache (Recomendado)

O arquivo `.htaccess` já está configurado. Certifique-se de que o `mod_rewrite` está ativado:

```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2

# CentOS/RHEL
# mod_rewrite geralmente já vem habilitado
```

Configure o VirtualHost apontando para a pasta do projeto:

```apache
<VirtualHost *:80>
    ServerName spotify-clone.local
    DocumentRoot /caminho/para/spotify-clone

    <Directory /caminho/para/spotify-clone>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name spotify-clone.local;
    root /caminho/para/spotify-clone;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

### 3. Configure o Banco de Dados

#### Criar o Banco de Dados

```bash
mysql -u root -p
```

```sql
CREATE DATABASE spotify CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'spotify_user'@'localhost' IDENTIFIED BY 'sua_senha_segura';
GRANT ALL PRIVILEGES ON spotify.* TO 'spotify_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Importar a Estrutura

```bash
mysql -u spotify_user -p spotify < database.sql
```

### 4. Configure as Variáveis de Ambiente

```bash
# Copiar arquivo de exemplo
cp .env.example .env

# Editar configurações
nano .env
```

Edite o arquivo `.env`:

```ini
DB_HOST=localhost
DB_PORT=3306
DB_NAME=spotify
DB_USER=spotify_user
DB_PASS=sua_senha_segura

APP_ENV=development
APP_DEBUG=true
APP_URL=http://spotify-clone.local
```

### 5. Atualizar Configuração do PHP

Edite o arquivo `includes/config.php` se necessário (ou use variáveis de ambiente).

### 6. Ajustar Permissões

```bash
# Linux/Mac
chmod -R 755 .
chmod -R 777 assets/images/profile-pics
```

## ⚙️ Configuração

### Variáveis de Ambiente

O projeto suporta variáveis de ambiente para diferentes ambientes (desenvolvimento, staging, produção).

**Desenvolvimento Local:**
```php
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=spotify
```

**Produção (Scalingo/Heroku):**
O projeto detecta automaticamente `SCALINGO_MYSQL_URL` ou `DATABASE_URL`.

## 🗄️ Estrutura do Banco de Dados

### Principais Tabelas

#### `users`
```sql
- id (INT, PK, AUTO_INCREMENT)
- username (VARCHAR)
- firstName (VARCHAR)
- lastName (VARCHAR)
- email (VARCHAR)
- password (VARCHAR, hashed)
- signUpDate (DATETIME)
- profilePic (VARCHAR)
```

#### `songs`
```sql
- id (INT, PK, AUTO_INCREMENT)
- title (VARCHAR)
- artist (INT, FK)
- album (INT, FK)
- genre (INT, FK)
- duration (TIME)
- path (VARCHAR)
- albumOrder (INT)
- plays (INT)
```

#### `albums`
```sql
- id (INT, PK, AUTO_INCREMENT)
- title (VARCHAR)
- artist (INT, FK)
- genre (INT, FK)
- artworkPath (VARCHAR)
```

#### `playlists`
```sql
- id (INT, PK, AUTO_INCREMENT)
- name (VARCHAR)
- owner (VARCHAR, FK)
- dateCreated (DATETIME)
```

### Diagrama ER

```
Users ──┐
        │
        ├──< Playlists >──< PlaylistSongs >──< Songs
        │
        └──< Artists >──< Albums >──< Songs
```

## 🌐 Deploy

### Deploy no Scalingo

1. Crie uma conta no [Scalingo](https://scalingo.com)

2. Instale o CLI do Scalingo:
```bash
curl -O https://cli-dl.scalingo.com/install && bash install
```

3. Login:
```bash
scalingo login
```

4. Crie a aplicação:
```bash
scalingo create spotify-clone-app
```

5. Adicione MySQL:
```bash
scalingo -a spotify-clone-app addons-add mysql mysql-starter-512
```

6. Configure variáveis:
```bash
scalingo -a spotify-clone-app env-set APP_ENV=production
```

7. Deploy:
```bash
git push scalingo main
```

8. Importe o banco:
```bash
scalingo -a spotify-clone-app mysql-console < database.sql
```

### Deploy no Heroku

1. Crie o app:
```bash
heroku create spotify-clone-app
```

2. Adicione MySQL (ClearDB):
```bash
heroku addons:create cleardb:ignite
```

3. Configure variáveis:
```bash
heroku config:set APP_ENV=production
```

4. Deploy:
```bash
git push heroku main
```

## 💻 Uso

### Acessar a Aplicação

1. Abra o navegador: `http://localhost` ou `http://spotify-clone.local`
2. Crie uma conta na página de registro
3. Faça login com suas credenciais
4. Explore álbuns, artistas e músicas
5. Crie suas playlists personalizadas

### Credenciais de Teste

Se você importou dados de exemplo:

```
Email: user@example.com
Senha: password123
```

## 📁 Estrutura de Arquivos

```
spotify-clone/
├── assets/
│   ├── css/
│   │   ├── style.css          # Estilos principais
│   │   └── register.css       # Estilos de registro/login
│   ├── js/
│   │   ├── script.js          # Scripts principais
│   │   └── register.js        # Validação de registro
│   └── images/
│       ├── artwork/           # Capas de álbuns
│       ├── icons/            # Ícones do player
│       └── profile-pics/     # Fotos de perfil
├── includes/
│   ├── classes/
│   │   ├── Account.php       # Lógica de autenticação
│   │   ├── Album.php         # Modelo de álbum
│   │   ├── Artist.php        # Modelo de artista
│   │   ├── Playlist.php      # Modelo de playlist
│   │   ├── Song.php          # Modelo de música
│   │   ├── User.php          # Modelo de usuário
│   │   └── Constants.php     # Constantes da aplicação
│   ├── handlers/
│   │   ├── ajax/             # Handlers AJAX
│   │   ├── login-handler.php
│   │   └── register-handler.php
│   ├── header.php            # Header comum
│   ├── footer.php            # Footer comum
│   ├── includedFiles.php     # Arquivos incluídos
│   ├── navBarContainer.php   # Menu lateral
│   ├── nowPlayingBar.php     # Barra do player
│   └── config.php            # Configuração do banco
├── .htaccess                 # Configuração Apache
├── .env.example              # Exemplo de variáveis
├── database.sql              # Estrutura do banco
├── index.php                 # Página inicial
├── register.php              # Página de registro
├── browse.php                # Navegação
├── search.php                # Busca
├── album.php                 # Detalhes do álbum
├── artist.php                # Detalhes do artista
├── playlist.php              # Detalhes da playlist
├── yourMusic.php             # Suas músicas
├── settings.php              # Configurações
└── README.md                 # Este arquivo
```

## 🎨 Screenshots

### Página Inicial
![Home Page](screenshots/home.png)

### Player de Música
![Music Player](screenshots/player.png)

### Página de Álbum
![Album Page](screenshots/album.png)

### Busca
![Search](screenshots/search.png)

## 🤝 Contribuindo

Contribuições são bem-vindas! Siga os passos:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

### Diretrizes

- Escreva código limpo e comentado
- Siga os padrões de código do projeto
- Teste suas alterações antes de enviar
- Atualize a documentação se necessário

## 🐛 Problemas Conhecidos

- [ ] Player pode não funcionar em navegadores muito antigos
- [ ] Upload de músicas ainda não implementado
- [ ] Integração com API do Spotify não implementada

## 🔜 Roadmap

- [ ] Upload de músicas customizadas
- [ ] Integração com Spotify API
- [ ] Sistema de favoritos
- [ ] Histórico de reprodução
- [ ] Compartilhamento de playlists
- [ ] Modo escuro/claro
- [ ] PWA (Progressive Web App)
- [ ] API REST documentada
- [ ] Testes automatizados

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👨‍💻 Autor

**Seu Nome**
- GitHub: [@seu-usuario](https://github.com/seu-usuario)
- LinkedIn: [Seu Nome](https://linkedin.com/in/seu-perfil)
- Email: seu-email@exemplo.com

## 🙏 Agradecimentos

- Design inspirado no [Spotify](https://spotify.com)
- Músicas de demonstração: [Bensound](https://bensound.com)
- Ícones: Comunidade open-source
- Comunidade PHP e desenvolvimento web

---

⭐ Se este projeto te ajudou, considere dar uma estrela!

**Nota:** Este é um projeto educacional. Não tem afiliação com o Spotify AB.
