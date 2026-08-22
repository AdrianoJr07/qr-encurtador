# 🔗 Encurtador de Links com QR Code

Aplicação web desenvolvida em **PHP** para encurtamento de URLs e geração automática de **QR Codes**.

O projeto foi implantado em uma máquina virtual no **Google Cloud Platform (GCP)**, utilizando **Apache**, domínio dinâmico com **DuckDNS**, endereço IP externo estático e certificado **HTTPS**.

## 🌐 Aplicação

A aplicação está disponível em:

**https://qr-encurtador.duckdns.org**

---

## 📌 Sobre o projeto

O objetivo do projeto é permitir que o usuário informe uma URL e receba automaticamente:

- Um link curto;
- Um código único para o redirecionamento;
- Um QR Code correspondente ao link;
- Redirecionamento para a URL original;
- Uma URL amigável, sem necessidade de exibir parâmetros PHP.

### Exemplo

URL original:

```text
https://www.google.com
```

Link gerado:

```text
https://qr-encurtador.duckdns.org/SnGQi
```

Ao acessar o link curto ou escanear o QR Code, o usuário é redirecionado para a URL original.

---

## ⚙️ Tecnologias utilizadas

- PHP
- HTML5
- CSS3
- JSON
- Apache2
- Apache mod_rewrite
- Ubuntu Server 22.04 LTS
- Google Cloud Platform
- Compute Engine
- DuckDNS
- Let's Encrypt
- Certbot
- Git
- GitHub
- API para geração de QR Code

---

## ☁️ Infraestrutura

A aplicação está hospedada em uma máquina virtual criada no **Google Cloud Compute Engine**.

A arquitetura utilizada pode ser representada da seguinte forma:

```text
                    Internet
                        │
                        ▼
        qr-encurtador.duckdns.org
                        │
                        ▼
                  DuckDNS / DNS
                        │
                        ▼
                IP externo estático
                        │
                        ▼
              Google Cloud Platform
                        │
                        ▼
                Compute Engine VM
                        │
                        ▼
                Ubuntu + Apache
                        │
                        ▼
                  Aplicação PHP
                   /          \
                  ▼            ▼
             links.json     QR Code
```

O domínio DuckDNS aponta para o endereço IP externo estático da máquina virtual.

---

## 🔒 HTTPS

A aplicação utiliza HTTPS através de um certificado SSL/TLS gratuito fornecido pelo **Let's Encrypt**.

A configuração foi realizada utilizando o **Certbot** integrado ao Apache.

Isso permite que a aplicação seja acessada através de:

```text
https://qr-encurtador.duckdns.org
```

O Certbot também configura a renovação automática do certificado.

---

## 🔗 URLs amigáveis

Inicialmente, os links eram gerados no formato:

```text
https://qr-encurtador.duckdns.org/redirecionar.php?codigo=Ab12C
```

Para tornar os links realmente curtos, foi utilizado o módulo `mod_rewrite` do Apache.

Assim, o endereço passou a ser:

```text
https://qr-encurtador.duckdns.org/Ab12C
```

A regra de redirecionamento é definida no arquivo `.htaccess`.

Exemplo:

```apache
RewriteEngine On

RewriteRule ^([a-zA-Z0-9]{5})/?$ redirecionar.php?codigo=$1 [L,QSA]
```

Dessa forma, o Apache recebe o código presente na URL e o encaminha internamente para o script responsável pelo redirecionamento.

---

## 🧠 Funcionamento

O fluxo principal da aplicação ocorre da seguinte maneira:

1. O usuário informa uma URL.
2. O PHP valida a URL recebida.
3. Um código aleatório de 5 caracteres é criado.
4. O sistema verifica se o código já existe.
5. O código é associado à URL original.
6. A informação é armazenada no arquivo `links.json`.
7. O sistema gera o link curto.
8. Um QR Code é criado com o endereço do link curto.
9. Ao acessar o link ou QR Code, o servidor localiza a URL original.
10. O usuário é redirecionado para o destino.

---

## 📂 Estrutura do projeto

```text
qr-encurtador/
│
├── index.php
├── encurtar.php
├── redirecionar.php
├── style.css
├── links.json
├── .htaccess
├── .gitignore
├── README.md
│
└── apache-config/
    ├── 000-default.conf
    └── 000-default-le-ssl.conf
```

### `index.php`

Página inicial da aplicação. Contém o formulário utilizado para informar a URL que será encurtada.

### `encurtar.php`

Responsável por:

- Receber a URL;
- Validar o endereço;
- Criar o código aleatório;
- Salvar a relação entre código e URL;
- Criar o link curto;
- Gerar o QR Code;
- Exibir o resultado ao usuário.

### `redirecionar.php`

Recebe o código presente no link curto, consulta o arquivo de dados e redireciona o usuário para a URL original.

### `links.json`

Arquivo utilizado para armazenar os códigos e suas respectivas URLs.

Exemplo:

```json
{
    "Ab12C": "https://www.google.com"
}
```

### `.htaccess`

Responsável pelas regras de reescrita utilizadas para transformar os links em URLs amigáveis.

---

## 🚀 Deploy no Google Cloud

O projeto foi implantado em uma VM Linux no Google Cloud.

Após acessar a máquina através de SSH, o Apache e o PHP podem ser instalados com:

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php -y
```

Para verificar o Apache:

```bash
sudo systemctl status apache2
```

Os arquivos da aplicação ficam localizados em:

```text
/var/www/html/
```

---

## 🔧 Configuração do Apache

Para habilitar URLs amigáveis:

```bash
sudo a2enmod rewrite
```

Depois, é necessário permitir o uso do `.htaccess` no VirtualHost:

```apache
<Directory /var/www/html>
    AllowOverride All
    Require all granted
</Directory>
```

Em seguida:

```bash
sudo apache2ctl configtest
sudo systemctl restart apache2
```

---

## 🔐 Certificado SSL

O HTTPS foi configurado utilizando Certbot.

Instalação:

```bash
sudo apt install certbot python3-certbot-apache -y
```

Emissão do certificado:

```bash
sudo certbot --apache -d qr-encurtador.duckdns.org
```

O Certbot configura o Apache para utilizar o certificado emitido pelo Let's Encrypt.

---

## 💾 Permissões do arquivo JSON

Como o Apache precisa escrever no arquivo que armazena os links, foram configuradas permissões específicas para o `links.json`.

Exemplo:

```bash
sudo chown www-data:www-data /var/www/html/links.json
sudo chmod 664 /var/www/html/links.json
```

Isso permite que o processo do Apache atualize os links armazenados.

---

## 🛡️ Segurança

Algumas medidas adotadas no projeto:

- HTTPS habilitado;
- Certificado SSL/TLS;
- Validação das URLs recebidas;
- IP externo estático;
- Arquivos sensíveis não armazenados diretamente no código;
- Controle de permissões no servidor;
- Uso de `.gitignore`;
- Comunicação criptografada através de HTTPS.

> Certificados privados, tokens, senhas e outras credenciais não devem ser adicionados ao repositório.

---

## 🧪 Testando o projeto

Para testar:

1. Acesse a página inicial.
2. Informe uma URL válida.
3. Clique em **Encurtar Link**.
4. O sistema apresentará um link curto.
5. Um QR Code será gerado automaticamente.
6. Abra o link curto em outra aba.
7. Verifique se o redirecionamento ocorre corretamente.
8. Escaneie o QR Code com um celular para testar o acesso.

---

## ⚠️ Limitações atuais

O projeto utiliza um arquivo JSON para persistência dos dados.

Essa abordagem funciona bem para fins acadêmicos e aplicações pequenas, porém não é indicada para aplicações com grande quantidade de usuários simultâneos.

Em uma evolução futura, o arquivo JSON poderá ser substituído por um banco de dados.

---

## 🔮 Melhorias futuras

Algumas funcionalidades que podem ser adicionadas:

- Banco de dados MySQL ou PostgreSQL;
- Painel administrativo;
- Histórico de links criados;
- Contador de acessos;
- Data de criação dos links;
- Expiração automática;
- Links personalizados;
- Estatísticas de acesso;
- Interface responsiva aprimorada;
- API REST para criação de links;
- Autenticação de usuários.

---

## 📚 Aprendizados

Durante o desenvolvimento foram trabalhados conceitos relacionados a:

- Desenvolvimento Web com PHP;
- Servidores Linux;
- Apache;
- Máquinas virtuais;
- Computação em nuvem;
- Google Cloud Platform;
- DNS;
- Endereços IP estáticos;
- HTTPS e certificados SSL/TLS;
- Permissões de arquivos no Linux;
- Reescrita de URLs;
- Git e GitHub;
- Deploy de aplicações Web.

---

## 👨‍💻 Autores

Adriano Ferreira, Amábile Silvério, Julia Barbosa e João Baradelli

Projeto desenvolvido para fins acadêmicos, envolvendo desenvolvimento Web, infraestrutura em nuvem e publicação de uma aplicação em ambiente real.
