<?php
$jFile = '*.json'
if (isset($_POST["add"])) {
    $file = file_get_contents($jFile);
    $data = json_decode($file, true);
    unset($_POST["add"]);
    if ( $_POST["hid"] === "" || $_POST["hid"] === "null" ) unset($_POST["hid"]);
    $data["LPU"] = array_values($data["LPU"]);
    array_unshift($data["LPU"], $_POST);
    file_put_contents($jFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));
    header("Location: index.php");
}
?>