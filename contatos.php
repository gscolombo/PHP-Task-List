<?php session_start(); ?>
<html>
    <head>
        <title>Gerenciador de Contatos</title>
    </head>
    <body>
    <style>

        * {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 40%;
        }

        form legend {
            background-color: black;
            color: white;
            padding: 5px 10px;
            margin-bottom: 5px;
        }
        
        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset label {
            margin-top: 5px;
        }

        fieldset label input {
            min-width: 100%;
            margin-top: 2.5px;
            padding: 4px;
        }

        fieldset input[type='submit'] {
            align-self: flex-end;
            max-width: fit-content;
            padding: 5px;
            margin-top: 5px;
        }

        table th {
            text-align: left;
            max-width: fit-content;
            margin-left: -5px;
            padding: 5px;
            color: white;
            background-color: grey;
        }

        table tr:nth-child(1) th {
            background-color: lightgrey;
            border: 2px solid black;
            text-transform: uppercase;
            text-align: center;
        }

        table tr:nth-child(1n + 2) {
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 0 1px black;
            padding: 5px;
        }

        table td {
            padding: 10px 5px 0 5px;
            margin-left: 5px;
            border-bottom: 1px solid black;
            display: flex;
            align-items: center;
        }

        table td::before {
            content: '';
            display: block;
            width: 0;
            float: left;
            border-top: 5px solid white;
            border-left: 5px solid black;
            border-bottom: 5px solid white;
            margin-right: 5px;
        }
    </style>

        <h1>Gerenciador de Contatos</h1>
        <form>
            <fieldset>
                <legend>Novo contato</legend>
                <label>
                    Nome:
                    <input type="text" name="name" placeholder="Fulano de Tal">
                </label>
                <label>
                    E-mail:
                    <input type="email" name="email" placeholder='fulanimg0st0s0@gugol.com'>
                </label>
                <label>
                    Telefone:
                    <input type="text" name="phone" placeholder='(XX) XXXXX-XXXX'>
                </label>
                <input type="submit" value="Adicionar contato">
            </fieldset>
        </form>
        <?php
            foreach(array_keys($_GET) as $key) {
                if (array_key_exists($key, $_GET)) {
                    $_SESSION['contacts'][$key][] = $_GET[$key];
                };
            }; 


            $contacts = [];
            if (array_key_exists('contacts', $_SESSION)){
                $contacts = $_SESSION['contacts'];
            }       
            
        ?>

        <table>
            <tr>
                <th>Contatos</th>
            </tr>
                <?php for ($i = 0; $i < count($contacts['name']); $i++): ?>
                <tr>                
                    <th><?php echo 'Contato n°' . ($i + 1) ?></th>
                    <td><?php echo 'Nome: ' . $contacts['name'][$i]; ?></td>
                    <td><?php echo 'E-mail: ' . $contacts['email'][$i]; ?></td>
                    <td><?php echo 'Telefone: ' . $contacts['phone'][$i]; ?></td>
                </tr>                
                <?php endfor; ?>
        </table>

    </body>
</html>