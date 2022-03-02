<?php
//initialisaion du projet, définition des variables.

//variable qui contient les douzes mois de l'année.
$monthsInYear = [
                '1' => 'Janvier',
                '2' => 'Février',
                '3' => 'Mars',
                '4' => 'Avril',
                '5' => 'Mai',
                '6' => 'Juin',
                '7' => 'Juillet',
                '8' => 'Août',
                '9' => 'Septembre',
                '10' => 'Octobre',
                '11' => 'Novembre',
                '12' => 'Décembre'
];

//Déclaration du numéro du moi actuel
$monthNumber = date('m');


//Déclaration de la variable pour avoir notre échantillon d'année.
$year = date('Y');


if (isset($_POST['month'])) {
    $chosenMonth = $monthsInYear[$_POST['month']];
$lastMonth= ($_POST['month']-1);
$nextMonth= ($_POST['month']+1);
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>calendrier php</title>
</head>

<body>
    <header>
        <h1>Calendrier - <?=$chosenMonth ?? 'à définir'?></h1>
        <div class="displayChoices">
            <form action="" method="post">

            <!-- Création du select pour les mois de l'année. -->
                <label class="label" for="month">Mois : </label>
                <select name="month">
                    <?php foreach ($monthsInYear as $key => $value) {
                        $isSelected = ( $key == $monthNumber) ? 'selected' : ''; ?>
                        <option value="<?=$key?>"<?=$isSelected?>><?=$value?></option>
                    <?php
                    }?>
                </select>
                

                <!-- Création du select pour les années. -->
                <label class="label" for="year">Année : </label>
                <select name="year">
                    <?php for ($i = $year-10; $i  <= $year+10 ; $i ++) {
                        $isSelected = ($i==$year) ? 'selected' : ''; ?>
                        
                        <option value="<?=$i?>" <?=$isSelected?>><?=$i?></option>
                    <?php
                    }
                    ?>
                </select>
                <button type="submit">Modifier</button>

            </form>
        </div>
    </header>
    <div class="monthsMenu">
<div>
< <?=$monthsInYear[$lastMonth??''] ?? 'Mois précédent'?>
</div>

<div>
<?=$monthsInYear[$nextMonth??''] ?? 'Mois suivant'?> > 
</div>
    </div>




</body>

</html>