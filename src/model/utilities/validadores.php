<?php

function validateNine($nine) {
  if ($nine == "" || strlen($nine) != 9 || !is_numeric($nine)) {
    return true;
  }
  return false;
}

function validatePostalCodePT($postalCode) {
  if($postalCode == "" || strlen($postalCode) != 8){
    return true;
  }

  $parts = explode("-", $postalCode);
  if (count($parts) == 2 &&
     is_numeric($parts[0]) &&
     is_numeric($parts[1]) &&
     strlen($parts[0]) == 4 &&      
     strlen($parts[1]) == 3){
    return false;
  }

  return true;
}

?>