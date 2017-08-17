<?php
    session_start();
    $temp_arr = $_SESSION["temp_search"];
    $q = $_REQUEST["q"];
    $hint = "";

    if ($q !== "") {
        $q = strtolower($q);
        $len=strlen($q);
        foreach($temp_arr as $name) {
            if (stristr($q, substr($name, 0, $len))) {
                if ($hint === "") {
                    $hint = $name;
                } else {
                    $hint .= " <button>$name</button>";
                }
            }
        }
    }

    echo $hint === "" ? "no sugesstion" : $hint;
?>