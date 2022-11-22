<?php
    $code = $argv[1]; //paramètre de la commune
    $dep = $argv[2]; //paramètre du département
    $tab_foret = $tab_indice = []; //tableau de stockage des forêts correspondant à notre recherche et tableau de stockage des indices

    $emplacement_forets = fopen("/Users/alexandre/Desktop/M1/Donnee sur le Web/Projet/emplacement-des-forets-publiques.csv","r");
    
    
    if($dep != 0) { //si on fait une rechercher sur un département
        while ((($data_emplacement_foret = fgetcsv($emplacement_forets, null, ";")) !== FALSE) ) { //on boucle sur chaque ligne du fichier
            if($data_emplacement_foret[5] == $dep) { //on compare notre département en paramètre au département de la ligne actuelle
                array_push($tab_foret, $data_emplacement_foret[9]); //on stock dans le tableau le code de la commune
            }
        }
    }elseif($code != 0) { //si on fait une rechercher sur une commune
        while ((($data_emplacement_foret = fgetcsv($emplacement_forets, null, ";")) !== FALSE) ) {
            if($data_emplacement_foret[9] == $code) { //on compare le code de la commune en paramètre avec celui de la ligne actuelle
                array_push($tab_foret, $data_emplacement_foret[9]);
            }
        }
    }

    fclose($emplacement_forets);

    $mauvais = $tres_mauvais = $moyen = $bon = 0; //initialisation des variables pour compter le nombre d'apparition des différentes valeurs ATMO

    $indice_atmo = fopen("/Users/alexandre/Desktop/M1/Donnee sur le Web/Projet/ind_atmo_2021.csv","r");
    while ((($data_indice_atmo = fgetcsv($indice_atmo, null, ",")) !== FALSE) ) {
        if(in_array($data_indice_atmo[9], $tab_foret)) { //on regarde si l'indice de la ligne existe dans le tableau contenant le code des communes des forêts
            if($data_indice_atmo[14] == "Très mauvais") {
                $tres_mauvais++;
            }else if($data_indice_atmo[14] == "Mauvais") {
                $mauvais++;
            }else if($data_indice_atmo[14] == "Moyen") {
                $moyen++;
            }else if($data_indice_atmo[14] == "Bon") {
                $bon++;
            }
            array_push($tab_indice, $data_indice_atmo[14]); //on stock l'indice dans le tableau
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

    //on récupère l'indice avec le plus d'occurence dans le tableau des indices
    
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
