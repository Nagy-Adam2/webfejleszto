<?php

function xmlFunction()
{
    $xml = simplexml_load_file("model-teszta-alapanyagok.xml");
    $rms = [];

    foreach($xml->children() as $child)
    {
        $rms[] = Raw_material::FromXML($child);
    }

    return $rms;
}

  
function pieceEggFunction() : int
{
    $rms = xmlFunction();
    $pieceEggArray = $rms[0];
    $pieceEgg = $pieceEggArray->getPiece();
    return $pieceEgg;
}


function pieceFlourFunction() : int
{
    $rms = xmlFunction();
    $pieceFlourArray = $rms[1];
    $pieceFlour = $pieceFlourArray->getPiece();
    return $pieceFlour;
}


function pieceSugarFunction() : int
{
    $rms = xmlFunction();
    $pieceSugarArray = $rms[2];
    $pieceSugar = $pieceSugarArray->getPiece();
    return $pieceSugar;
}


if(isset($_POST['inputNumber']))
{
    $inputNumberPost = $_POST['inputNumber'];
}


function functionInputNumberPost(?int $inputNumberPost) : string
{ 
    $pieceEggResult = pieceEggFunction();
    $pieceFlourResult = pieceFlourFunction();
    $pieceSugarResult = pieceSugarFunction();
    
    function outputWeight($dkg)
    {
        $power = floor(log($dkg, 10));    
        switch($power) {
            case 6  :
            case 5  : $unit = 't'; 
                      $power = 5;
                      break;
            case 4  :
            case 3  :
            case 2  : $unit = 'kg'; 
                      $power = 2;
                      break;  
            case 1  :
            case 0  : $unit = 'dkg'; 
                      $power = 0;
                      break;
            default : return 0 . ' dkg';
        }
        return ($dkg / pow(10, $power)) . ' ' . $unit;
    }  
            
    return $inputNumberPost . ' adaghoz: ' . $inputNumberPost * $pieceEggResult . ' darab tojás és ' . outputWeight($inputNumberPost * $pieceFlourResult) . ' liszt, meg ' . outputWeight($inputNumberPost * $pieceSugarResult) . ' cukor kell hozzá.';
}

?>