<?php

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Recebe a URL enviada pelo formulário
$url = trim($_POST['url'] ?? '');

// Verifica se a URL é válida
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    die('URL inválida.');
}

// Arquivo onde vamos armazenar os links
$arquivo = 'links.json';

// Lê os links existentes
$conteudo = file_get_contents($arquivo);

$links = json_decode($conteudo, true);

if (!is_array($links)) {
    $links = [];
}

// Gera um código aleatório de 5 caracteres
$codigo = substr(
    str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),
    0,
    5
);

// Garante que o código não exista
while (isset($links[$codigo])) {
    $codigo = substr(
        str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),
        0,
        5
    );
}

// Salva a relação entre código e URL original
$links[$codigo] = $url;

// Converte novamente para JSON
$json = json_encode(
    $links,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
);

// Salva no arquivo
file_put_contents($arquivo, $json);

// Monta o link curto
$linkCurto = 'https://' . $_SERVER['HTTP_HOST']
   
    . '/'
    . $codigo;

// Prepara o link curto para gerar o QR Code
$urlCodificada = urlencode($linkCurto);

// API responsável por gerar o QR Code
$qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='
    . $urlCodificada;

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Link Encurtado</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h1>Link Encurtado!</h1>

        <p>
            Seu link foi gerado com sucesso.
        </p>

        <label for="link">
            Link curto:
        </label>

        <input
            type="text"
            id="link"
            value="<?= htmlspecialchars($linkCurto) ?>"
            readonly
        >

        <button onclick="copiarLink()">
            Copiar Link
        </button>

        <br><br>

        <h2>QR Code</h2>

        <p>
            Escaneie o QR Code para acessar o link.
        </p>

        <div class="qr-container">

            <img
                src="<?= htmlspecialchars($qrCode) ?>"
                alt="QR Code do link encurtado"
                width="300"
                height="300"
            >

        </div>

        <p class="link-qr">
            <?= htmlspecialchars($linkCurto) ?>
        </p>

        <a href="index.php">
            Criar outro link
        </a>

    </div>

    <script>

        function copiarLink() {

            const campo = document.getElementById('link');

            navigator.clipboard.writeText(campo.value);

            alert('Link copiado!');

        }

    </script>

</body>

</html>
