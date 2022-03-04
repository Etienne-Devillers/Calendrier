<?php
$actualMonth = false;
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

//Déclaration du numéro du mois actuel
$monthNumber = date('m');


//Déclaration de la variable pour avoir notre échantillon d'année.
$year = date('Y');

if (!empty($_GET['month']) && !empty($_GET['year'])) {
    $monthChoice = $_GET['month'];
    $chosenYear = $_GET['year'];
} else {
    $monthChoice = $_POST['month'] ?? date('n');
    $chosenYear = $_POST['year'] ?? date('Y');
}

$chosenMonth = $monthsInYear[$monthChoice];
$lastMonth = ($monthChoice-1);
$nextMonth = ($monthChoice+1);

$displayChoice = new DateTime("$chosenYear-$monthChoice");
$countDay = new DateTime("$chosenYear-$monthChoice");




//Création de year-1 et year +1
$nextYear =  new DateTime("$chosenYear-$monthChoice"); 
$lastYear =  new DateTime("$chosenYear-$monthChoice"); 
$interval =  new DateInterval('P1M');
$nextYear->add(new DateInterval('P1M'));
$lastYear->sub(new DateInterval('P1M'));
$previousDisplayMonth = $lastYear->format('n');
$previousDisplayYear = $lastYear->format('Y');
$nextDisplayMonth = $nextYear->format('n');
$nextDisplayYear = $nextYear->format('Y');

//On trouve le premier jour du mois.
$firstDay = $displayChoice-> format('N');

//vérification si on est sur le mois en cours 
if ($monthChoice == date('n') && $chosenYear == date('Y')) {
    $actualMonth = true;
}

//Identification du jour actuel
$dayToday = date('j');
var_dump($dayToday);

//Combien de jour dans un mois.
$daysForSpecificMonth = cal_days_in_month(CAL_GREGORIAN, $monthChoice, $chosenYear);

//combien de semaine dans le mois.
function weeksInMonth($dayCount, $daysForSpecificMonth) {
    $weeksInMonth = 1;
    for ($i=1; $i < $daysForSpecificMonth; $i++) { 
        
        if ($dayCount == 7) {
            $dayCount = 0;
            $weeksInMonth++;
        } 
        $dayCount++;
        
    //var_dump('jour:'.$dayCount. ', ');
    //var_dump('nbr de semaine:'.$weeksInMonth.'<br>');
    }
    return $weeksInMonth;
    }

// .
    $weeksInMonth =weeksInMonth($firstDay, $daysForSpecificMonth);
$weeksDisplay = $weeksInMonth*7;

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
        <h1>Calendrier -
            <?= (($chosenYear) && ($monthChoice))? $chosenMonth.' '.$chosenYear : 'à définir' ;?></h1>
        <div class="displayChoices">

        <!-- Formulaire -->
            <form action="./index.php" method="post">

                <!-- Création du select pour les mois de l'année. -->
                <label class="label" for="month">Mois : </label>
                <select name="month">
                    <?php foreach ($monthsInYear as $key => $value) {
                        $isSelected = ( $key == $monthNumber) ? 'selected' : ''; ?>
                    <option value="<?=$key?>" <?=$isSelected?>><?=$value?></option>
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
        <div class="changeDisplayButton">
        <a href="./index.php?month=<?=$previousDisplayMonth?>&year=<?=$previousDisplayYear?>"><i class="arrow left"></i> <?=$monthsInYear[$lastMonth??''] ?? '< Année précédente' .'</a>'?></a>
        </div>
        <div class="changeDisplayButton">
        <a href="./index.php?month=<?=$nextDisplayMonth?>&year=<?=$nextDisplayYear?>"> <?=$monthsInYear[$nextMonth??''] ?? 'Année suivante >'?> <i class="arrow right"></i></a>
        </div>
    </div>


    <section class="tableau">
<table>


<tr>
    <th class=" weekDays"><span class="large">Lundi</span> <span class="short">Lun</span></th>
    <th class=" weekDays"><span class="large">Mardi</span> <span class="short">Mar</span></th>
    <th class="weekDays"><span class="large ">Mercredi</span> <span class="short ">Mer</span></th>
    <th class=" weekDays"><span class="large">Jeudi</span> <span class="short">Jeu</span></th>
    <th class=" weekDays"><span class="large">Vendredi</span> <span class="short">Ven</span></th>
    <th class="weekDays"><span class="large">Samedi</span> <span class="short">Sam</span></th>
    <th class=" weekDays"><span class="large">Dimanche</span> <span class="short">Dim</span></th>
</tr>
<tr>


<?php
$day = 1 ;
$stop=false;
while ($day <= $weeksDisplay) {
    while($day<$firstDay) {
        echo ' <td><span class="emptyBox">-</span></td>';
        $day++;
    }
    while((($day-$firstDay)+1) <= $daysForSpecificMonth) {
        if ($countDay->format('j') == $dayToday) {
            echo '<td><span class="actualDay">'.(($day-$firstDay)+1).'</span></td>';
        } else if  ($day%7 == 0) {
            if ($daysForSpecificMonth-$day<=1 && $weeksDisplay-$day<=1 ) {
                echo '<td><span class="weekend">'.(($day-$firstDay)+1).'</span></td>';
                $stop=true;
            } else {
                echo '<td><span class="weekend">'.(($day-$firstDay)+1).'</span></td> </tr><tr>';
            }            
        } else if (($day+1)%7 == 0) {
            echo '<td><span class="weekend">'.(($day-$firstDay)+1).'</span></td>';
        } else {
            echo '<td><span>'.(($day-$firstDay)+1).'</span></td>';
        }
        
        $countDay->add(new DateInterval('P1D'));
        $day++;
    }
    echo (!$stop) ? ' <td><span class="emptyBox">-</span></td>': '';
    $countDay->add(new DateInterval('P1D'));
    $day++;
    }
        

?>
</tr>
</table>


    </section>




</body>

</html>