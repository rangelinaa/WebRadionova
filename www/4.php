/*
Задание 4
Реализовать функцию с тремя параметрами: function mathOperation($arg1, $arg2, $operation), 
где $arg1, $arg2 – значения аргументов, 
$operation – строка с названием операции. 
В зависимости от переданного значения операции выполнить одну из арифметических операций 
(использовать функции из п.3)  и вернуть полученное значение (использовать switch).
*/

<?php
    function addmy($x, $y) {
        return $x + $y;
    }

    function submy($x, $y) {
        return $x - $y;
    }

    function mulmy($x, $y) {
        return $x * $y;
    }

    function divmy($x, $y) {
        if ($y == 0) {
            return "Деление на ноль невозможно";
        }
        return $x / $y;
    }

    function mathOperation($arg1, $arg2, $operation) {
        switch ($operation) {
            case 'addmy':
                return addmy($arg1, $arg2);
            case 'submy':
                return submy($arg1, $arg2);
            case 'mulmy':
                return mulmy($arg1, $arg2);
            case 'divmy':
                return divmy($arg1, $arg2);
            default:
                return "Введите существующую операцию";
        }
    }

    echo "mathOperation(8, 2, 'addmy') = " . mathOperation(8, 2, 'addmy');
    echo "mathOperation(8, 2, 'submy') = " . mathOperation(8, 2, 'submy');
    echo "mathOperation(8, 2, 'mulmy') = " . mathOperation(8, 2, 'mulmy');
    echo "mathOperation(8, 2, 'divmy') = " . mathOperation(8, 2, 'divmy');   

?>