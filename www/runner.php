<?php

require_once __DIR__ . "/../vendor/autoload.php";

function diff($a, $b) {
    $diff = [];
    
    foreach ($a as $item) {
        $found = array_search($item, $b);
        
        if ($found === false) {
            $diff[] = $item;
        }
    }
    
    foreach ($b as $item) {
        $found = array_search($item, $a);
        
        if ($found === false) {
            $diff[] = $item;
        }
    }
    
    return $diff;
}

$a = [1, 2, 3, 4, 5, 6];
$b = [4, 5, 6, 7];

print_r(array_diff($a, $b));
print_r(diff($a, $b));
