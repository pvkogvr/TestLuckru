<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>TestLuckru</title>
    </head>
</html>
<body>
    <?php
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME','dbluckru');

        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if($link == false){
            print("Ошибка: Невозможно подключиться к MySQL ".mysqli_connect_error());
        }
        else{
            print("Соединение установленно успешно");
        }
        mysqli_set_charset($link, "utf8");

        if(isset($_POST["fio"])){
            if(isset($_GET['red'])){
                $sql = mysqli_query($link, "UPDATE `phonedirectory` SET `fio`='{$_POST['fio']}',`phoneNumber`='{$_POST['phoneNumber']}',`who`='{$_POST['who']}' WHERE `id`={$_GET['red']}");
            }else{
                $sql = mysqli_query($link, "INSERT INTO `phonedirectory` (`fio`, `phoneNumber`, `who`) VALUES ('{$_POST['fio']}', '{$_POST['phoneNumber']}', '{$_POST['who']}')");
            }
        }
        if($sql){
            echo "<script>console.log('Успешно' );</script>";
        }else{
            echo '<script>console.log("Произошла ошибка: ' . mysqli_error($link) . ' ")</script>';
        }

        if (isset($_GET['del'])) {
            $sql = mysqli_query($link, "DELETE FROM `phonedirectory` WHERE `ID` = {$_GET['del']}");
            if ($sql) {
                echo "<script>console.log('Товар Удален' );</script>";
            } else {
                echo '<script>console.log("Произошла ошибка: ' . mysqli_error($link) . ' ")</script>';
            }
        }

        if(isset($_GET['red'])){
            $sql = mysqli_query($link, "SELECT `id`, `fio`, `phoneNumber`, `who` FROM `phonedirectory` WHERE 'id'={$_GET['red']}");
        }
    ?>
    <div class="form-popup" id="myForm">
        <form class="form-container" id="push" action="form1.php" method="post" role="dialog">
            <header class="form-header">
                <h1>Добавить</h1>
            </header>
            <main class="form-main">
                <table>
                    <tr>
                        <td>ФИО:</td>
                        <td><input type="text" name="fio" value="<?= isset($_GET['red']) ? $product['fio']: ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Телефон:</td>
                        <td><input type="text" name="phoneNumber" value="<?= isset($_GET['phoneNumber']) ? $product['fio']: ''; ?>"></td>
                    </tr>
                    <tr>
                        <td>Кем приходится:</td>
                        <td><input type="text" name="who" value="<?= isset($_GET['red']) ? $product['who']: ''; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input type="submit" value="OK" style="width:100%">
                        </td>
                    </tr>
                </table>        
            </main>
        </form>
    </div>
    <table>
        <caption>Телефонный справочник</caption>
        <tr>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Кем приходится</th>
            <th>Кнопки действий</th>
        </tr>
        <?php
            $sql = mysqli_query($link, 'SELECT `id`, `fio`, `phoneNumber`, `who` FROM `phonedirectory`');
            while($result = mysqli_fetch_array($sql)){
                echo "<tr>
                            <td>{$result['fio']}</td> 
                            <td>{$result['phoneNumber']}</td> 
                            <td>{$result['who']}</td> 
                            <td><a href='?del={$result['id']}'>Удалить</a>
                            <a href='?red={$result['id']}' onclick='openForm()'>Редактировать</a>
                            </td>
                        </tr>";
            }
        ?>
    </table>
    <p><a href="?add=new" class="open-button" onclick="openForm()">Добавить новый товар</a></p>
    <p><a href="#" onclick="closeForm()">Закрыть</a></p>
    <script src="jquery-3.6.4.min.js"></script>
    <script src="form.js"></script>
</body>
