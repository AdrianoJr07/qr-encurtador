<?php

$codigo = $_GET['codigo'] ?? '';

if ($codigo === '') {
    die('Código do link não informado.');
}

$arquivo = 'links.json';

if (!file_exists($arquivo)) {
    die('Arquivo de links não encontrado.');
}

$conteudo = file_get_contents($arquivo);

$links = json_decode($conteudo, true);

if (!is_array($links)) {
    die('Erro ao ler os links.');
}

if (!isset($links[$codigo])) {
    die('Link não encontrado.');
}

$urlOriginal = $links[$codigo];

header('Location: ' . $urlOriginal);

exit;