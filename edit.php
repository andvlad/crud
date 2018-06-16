<?php
$jFile = '*.json'
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $getfile = file_get_contents($jFile);
    $jsonfile = json_decode($getfile, true);
    $jsonfile = $jsonfile["LPU"];
    $jsonfile = $jsonfile[$id];
}

if (isset($_POST["idi"])) {
    $id = (int) $_POST["idi"];
    $getfile = file_get_contents($jFile);
    $all = json_decode($getfile, true);
    $jsonfile = $all["LPU"];
    $jsonfile = $jsonfile[$id];

    if ( $_POST["hid"] === "" || $_POST["hid"] === "null" ) unset($_POST["hid"]);
        
    $all["LPU"][$id] = array("id" => $_POST["id"],
                             "hid" => $_POST["hid"],
                             "full_name" => $_POST["full_name"],
                             "address" => $_POST["address"],
                             "phone" => $_POST["phone"]);
        
    file_put_contents($jFile, json_encode($all, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));
    
    header("Location: index.php");
}

if (isset($_GET["id"])) { ?>
    <div id="forma">
    <form action="edit.php" method="POST">
        <input type="hidden" value="<?php echo $id ?>" name="idi"/>
        <p id="logo">Изменение данных</p>
        <p>ID</p>
        <input type="text" value="<?php echo $jsonfile['id'] ?>" name="id"/>
        <p>hid</p>
        <input type="text" value="<?php echo $jsonfile['hid'] ?>" name="hid"/>
        <p>Наименование</p>
        <input type="text" value="<?php echo $jsonfile['full_name'] ?>" name="full_name"/>
        <p>Адрес</p>
        <input type="text" value="<?php echo $jsonfile['address'] ?>" name="address"/>
        <p>Телефон</p>
        <input type="text" value="<?php echo $jsonfile['phone'] ?>" name="phone"/>
        <div>
            <button class="edit" type="submit"/>Изменить</button>
            <a href="index.php">Отмена</a>
        </div>
    </form>
    </div>
<?php } ?>

<style>
        body {
            font-family: 'Arial';
            font-size: 1em;
            text-align: center;
            background-color: #e6e6e6;
            padding-top: 1em;
        }
        #forma {
            width: 30em;
            height: 33em;
            background-color: white;
            position: relative;
            left: 50%;
            transform: translate(-50%, 30%);
        }
        a, button {
            text-decoration: none;
            float: left;
            color: white;
            display: block;
            width: 6em;
            box-sizing: border-box;
            cursor: pointer;
        }
        a {
            background-color: #ff6666;
            font-size: 1em;
            position: absolute;
            right: 25%;
            height: 2em;
            padding-top: 5px;
            margin: 1em 0 0 1em;
        }
        a:hover {
            color: #ff6666;
            box-shadow: inset 0 0 0 0.1em #ff6666;  
        }
        .edit {
            background-color: #6495ed;
        }
        a:hover, button:hover {
            background-color: white;
            transition: .2s;
        }
        a:not(:hover), button:not(:hover) {
            transition: .2s;
        }
        button {
            font-size: 1em;
            position: absolute;
            left: 25%;
            height: 2em;
            border: none;
            box-shadow: none;
            padding-bottom: 4px;
            margin: 1em 1em 0 0;
        }
        .edit:hover {
            color: #6495ed;
            box-shadow: inset 0 0 0 0.1em #6495ed;
        }
        input {
            width: 70%;
            font-family: 'Arial';
            font-size: 1em;
            box-sizing: border-box;
        }
        input:hover, textarea:hover {
            border: solid 1px #6495ed;
        }
        input {
            height: 2em;
        }
        input:focus {
            border: solid 1px black;
        }
        #logo {
            font-weight: bold;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding-top: 1em;
        }
</style>