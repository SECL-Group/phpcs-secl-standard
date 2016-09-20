<?php
function validFunctionCyclomaticComplexityOfFive()
{
    if (true && false) {
        echo '';
    }

    while (false) {
        echo '';
    }

    try {
        echo '';
    } catch (Exception $e) {
        echo $e;
    }

    return;
}

function invalidFunctionCyclomaticComplexityOfSix()
{
    $a = true || false ? false : true;

    foreach ([$a] as $b) {
        echo $b;
    }

    switch (2) {
        case 1:
            echo '';
            break;
        case 2:
            echo '';
            break;
        default:
            echo '';
    }

    return;
}
