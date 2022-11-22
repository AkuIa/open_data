<?php
    $code = $argv[1];
    $dep = $argv[2];
    $tab_foret = $tab_indice = [];

    $emplacement_forets = fopen("/Users/alexandre/Desktop/M1/Donnee sur le Web/Projet/emplacement-des-forets-publiques.csv","r");
    if($dep != 0) {
        while ((($data_emplacement_foret = fgetcsv($emplacement_forets, null, ";")) !== FALSE) ) {
            if($data_emplacement_foret[5] == $dep) {
                array_push($tab_foret, $data_emplacement_foret[9]);
            }
        }
    }elseif($code != 0) {
        while ((($data_emplacement_foret = fgetcsv($emplacement_forets, null, ";")) !== FALSE) ) {
            if($data_emplacement_foret[9] == $code) {
                array_push($tab_foret, $data_emplacement_foret[9]);
            }
        }
    }
    fclose($emplacement_forets);

    $mauvais = $tres_mauvais = $moyen = $bon = 0;
    $indice_atmo = fopen("/Users/alexandre/Desktop/M1/Donnee sur le Web/Projet/ind_atmo_2021.csv","r");
    while ((($data_indice_atmo = fgetcsv($indice_atmo, null, ",")) !== FALSE) ) {
        if(in_array($data_indice_atmo[9], $tab_foret)) {
            if($data_indice_atmo[14] == "Très mauvais") {
                $tres_mauvais++;
            }else if($data_indice_atmo[14] == "Mauvais") {
                $mauvais++;
            }else if($data_indice_atmo[14] == "Moyen") {
                $moyen++;
            }else if($data_indice_atmo[14] == "Bon") {
                $bon++;
            }
            array_push($tab_indice, $data_indice_atmo[14]);
        }
    }

    $indice = $bon;
    $txt = "Bon";
    if($indice < $moyen) {
        $indice = $moyen;
        $txt = "Moyen";
    }

    if($indice < $mauvais) {
        $indice = $mauvais;
        $txt = "Mauvais";
    }

    if($indice < $tres_mauvais) {
        $indice = $tres_mauvais;
        $txt = "Très mauvais";
    }

    if($dep != 0) {
        echo 'Département : ' . $dep . "\r\n";
    }elseif($code != 0) {
        echo 'Commune : ' . $code . "\r\n";
    }

    echo count($tab_foret) . ' forêts';
    echo "\r\n";
    echo count($tab_indice) . " indices trouvés" . "\r\n";
    echo "Qualité de l'air : " . $txt."\r\n";

    echo "\r\n Bon " . $bon;
    echo "\r\n Moyen " . $moyen;
    echo "\r\n Mauvais " . $mauvais;
    echo "\r\n Très mauvais " . $tres_mauvais;
?>
