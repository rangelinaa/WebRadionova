/*  Задание 5
Напишите функцию, которая находит самую длинную строку общего префикса среди массива строк. 
Если общего префикса нет, то вернуть пустую строку “”.
Префикс - это сочетание из минимум 2-ух букв 
 */

function longestCommonSuffix(strs) {
    if (!strs || strs.length === 0) {
        return "";
    }

    let minLength = strs.reduce((min, s) => Math.min(min, s.length), Infinity);
    let commonSuffix = "";

    for (let j = 1; j <= minLength; j++) {
        const currentSuffix = strs[0].slice(strs[0].length - j);
        
        let isCommon = true;
        for (let i = 1; i < strs.length; i++) {
            if (!strs[i].endsWith(currentSuffix)) {
                isCommon = false;
                break;
            }
        }

        if (isCommon) {
            commonSuffix = currentSuffix;
        } else {
            break;
        }
    }

    if (commonSuffix.length >= 2) {
        return commonSuffix;
    } else {
        return "";
    }
}

const strs1 = ["цветок", "поток", "хлопок"];
const result1 = longestCommonSuffix(strs1);
console.log(result1); // "ок"

const strs2 = ["собака", "гоночная машина", "машина"];
const result2 = longestCommonSuffix(strs2);
console.log(result2); // ""

/*
Чтобы решить эту задачу, я использовала алгоритм, который начинается с самой короткой строки и проверяет, 
является ли суффикс этой строки общим для всех остальных. 
Для этого я использовала метод endsWith(), который проверяет, заканчивается ли строка на определённый суффикс. 
Если текущий суффикс не совпадает с концом какой-либо строки, его длина уменьшается, и мы продолжаем проверку. 
Когда найден общий суффикс, проверяю его длину, чтобы убедиться, что она больше или равна 2 символам, и возвращаю результат. 
Если суффикс меньше 2 символов, возвращаю пустую строку.
*/