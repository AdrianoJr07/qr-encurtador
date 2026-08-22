# 🔗 Encurtador de Links com QR Code

Projeto desenvolvido para criar links encurtados e gerar automaticamente um QR Code para cada URL cadastrada.

A aplicação está hospedada em uma máquina virtual no Google Cloud e pode ser acessada através de um domínio configurado com DuckDNS.

## 🚀 Funcionalidades

- Encurtamento de URLs
- Geração de códigos aleatórios para os links
- URLs amigáveis
- Redirecionamento para a URL original
- Geração automática de QR Code
- Armazenamento dos links em JSON
- Acesso através de HTTPS

## 🛠️ Tecnologias utilizadas

- PHP
- HTML
- CSS
- JSON
- Apache
- Google Cloud Compute Engine
- DuckDNS
- Let's Encrypt
- Certbot

## 🔗 Exemplo de funcionamento

Uma URL original como:

https://www.google.com

pode ser transformada em um endereço semelhante a:

https://qr-encurtador.duckdns.org/Ab12C

Ao acessar o endereço encurtado, o usuário é automaticamente redirecionado para a URL original.

## 📱 QR Code

Ao criar um link encurtado, a aplicação também gera automaticamente um QR Code.

Ao escanear o QR Code pelo celular, o usuário acessa o link encurtado e é redirecionado para o endereço original.

## ☁️ Hospedagem

A aplicação está hospedada em uma máquina virtual utilizando o Google Cloud Compute Engine.

O servidor utiliza:

- Ubuntu Server
- Apache
- PHP
- IP público estático

## 🌐 DNS

O domínio utilizado pela aplicação é:

https://qr-encurtador.duckdns.org

O DuckDNS é utilizado para associar o domínio ao endereço IP público da máquina virtual.

## 🔒 HTTPS

A aplicação utiliza HTTPS através de um certificado SSL/TLS fornecido pelo Let's Encrypt.

A configuração e renovação do certificado são realizadas utilizando o Certbot.

## 🔄 URLs amigáveis

O Apache `mod_rewrite` é utilizado para transformar URLs como:

https://qr-encurtador.duckdns.org/Ab12C

internamente em:

redirecionar.php?codigo=Ab12C

Isso permite que os links gerados sejam menores e mais fáceis de compartilhar.

## 📂 Estrutura do projeto

```text
qr-encurtador/
├── index.php
├── encurtar.php
├── redirecionar.php
├── style.css
├── links.json
├── .htaccess
├── .gitignore
├── README.md
└── apache-config/
