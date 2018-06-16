<?php
$jFile = '*.json'
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $all = file_get_contents($jFile);
    $all = json_decode($all, true);
    $jsonfile = $all["LPU"];
    $jsonfile = $jsonfile[$id];

    if ($jsonfile) {
        unset($all["LPU"][$id]);
        $all["LPU"] = array_values($all["LPU"]);
        file_put_contents($jFile, json_encode($all, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
    header("Location: index.php");
}
?>