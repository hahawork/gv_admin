<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <ul>

            <?php
            for ($index = 1; $index <= 10; $index++) {
                ?>

            <li>
                <a href="<?= "Categoria.php?idCateg=$index";?>" >
                    <option> <?= "Categoria " . $index;?></option>
                </a>
            </li>
                <?php
            }
            ?>

        </ul>


    </body>
</html>
