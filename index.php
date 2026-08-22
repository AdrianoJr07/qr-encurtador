<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Encurtador de Links</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>Encurtador de Links</h1>

        <p>
            Digite uma URL abaixo para gerar um link curto.
        </p>

        <form action="encurtar.php" method="POST">

            <label for="url">URL:</label>

            <input
                type="url"
                id="url"
                name="url"
                placeholder="https://exemplo.com"
                required
            >

            <button type="submit">
                Encurtar Link
            </button>

        </form>

    </div>

</body>
</html>