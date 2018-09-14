<?php

$x=array(1,8,7,2,4);
$y=array(1,8,7);

$z=  array_diff($y, $x);
print_r($z);
foreach($example2 as $key => $value) {
   foreach($example1 as $key1 => $value1) {
      if ($value1 == $value) {
         unset($example2[$key]);
      }
   }
}