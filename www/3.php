/*
Задание 3
Реализовать основные 4 арифметические операции в виде функций с двумя параметрами. 
Обязательно использовать оператор return.
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

    echo "Сложение: " . addmy(14, 3) ;
    echo "Вычитание: " . submy(14, 3);
    echo "Умножение: " . mulmy(14, 3);
    echo "Деление: " . divmy(14, 3);  

?>