<!DOCTYPE html>
<html>
<head>
    <title>Pesquisa de Nome Científico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-image: url('background.png');
            margin: 0;
            padding: 0;
        }
         
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .container img {
            max-width: inherit;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #3fb800;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3fb800;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Estilos responsivos para dispositivos móveis */
        @media (max-width: 600px) {
            .container {
                padding: 10px; /* Reduz o preenchimento para dispositivos móveis */
                max-width: 100%; /* Garante que o container se ajuste à largura da tela */
            }
        
            input[type="text"] {
                width: 100%; /* Garante que o campo de entrada se ajuste à largura da tela */
            }
        
            input[type="submit"] {
                width: 100%; /* Garante que o botão de envio se ajuste à largura da tela */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesquisa de Nome Científico</h1>
        <form method="get">
            <label for="nomePopular" >Nome Popular:</label>
            <input type="text" name="nomePopular" id="nomePopular">
            <input type="submit" value="Pesquisar">
        </form>

        <?php
        if (isset($_GET['nomePopular'])) {
            $nomePopular = $_GET['nomePopular'];
            $csvFile = 'bancodedados.csv'; // Substitua com o caminho para o seu arquivo CSV
            $threshold = 80; // Limite de similaridade (ajuste conforme necessário)

            // Abra o arquivo CSV para leitura
            $handle = fopen($csvFile, 'r');

            if ($handle !== false) {
                $found = false;

                // Inicialize uma tabela
                echo "<table>
                        <tr>
                            <th>Nome Científico</th>
                            <th>Nome Popular</th>
                        </tr>";

                // Percorra as linhas do arquivo CSV
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $nomeCientifico = $row[1];
                    $nomePopularCSV = $row[2];

                    // Calcule a similaridade entre o nome popular digitado e o nome popular no CSV
                    similar_text($nomePopular, $nomePopularCSV, $percent);

                    if ($percent >= $threshold) {
                        $found = true;
                        // Exiba a correspondência na tabela
                        echo "<tr>
                                <td>$nomeCientifico</td>
                                <td>$nomePopularCSV</td>
                              </tr>";
                    }
                }

                // Feche a tabela
                echo "</table>";

                fclose($handle);

                if (!$found) {
                    echo "Nenhum resultado encontrado.";
                }
            } else {
                echo "Erro ao abrir o arquivo CSV.";
            }
        }
        ?>
    </div>
</body>
</html>
