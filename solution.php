<?php

class Solution {

    /**
     * Calculates the result of a mathematical expression given in string form.
     * @param String $s
     * @return Integer
     */
    function calculate($s) {
        $operators = array();
        $operands = array();

        $priority = array(
            '+' => 1,
            '-' => 1,
            '*' => 2,
            '/' => 2,
        );

        $s = str_replace(' ', '', $s); // Remove spaces
        
        $i = 0;
        while ($i < strlen($s)) {
            if ($s[$i] == '(') {
                array_push($operators, $s[$i]);
                $i++;
            } elseif ($s[$i] == ')') {
                while (end($operators) != '(') {
                    $this->performOperation($operators, $operands);
                }
                array_pop($operators); // '(' Remove Symbol
                $i++;
            } elseif (is_numeric($s[$i])) {
                $num = 0;
                while ($i < strlen($s) && is_numeric($s[$i])) {
                    $num = $num * 10 + intval($s[$i]);
                    $i++;
                }
                array_push($operands, $num);
            } elseif (isset($priority[$s[$i]])) {
                while (!empty($operators) && end($operators) != '(' && $priority[$s[$i]] <= $priority[end($operators)]) {
                    $this->performOperation($operators, $operands);
                }
                array_push($operators, $s[$i]);
                $i++;
            } else {
                $i++; // Ingoring other symbols
            }
        }

        while (!empty($operators)) {
            $this->performOperation($operators, $operands);
        }

        return end($operands); // Return result
    }
    
    /**
    * Performs the specified mathematical operation using the given operator and operands.
    *
    * @param array $operators Stack of operators
    * @param array $operands  Stack of operands
    */
    private function performOperation(&$operators, &$operands) {
        $operator = array_pop($operators);
        $operand2 = array_pop($operands);
        $operand1 = array_pop($operands);

        switch ($operator) {
            case '+':
                array_push($operands, $operand1 + $operand2);
                break;
            case '-':
                array_push($operands, $operand1 - $operand2);
                break;
            case '*':
                array_push($operands, $operand1 * $operand2);
                break;
            case '/':
                array_push($operands, $operand1 / $operand2);
                break;
        }
    }
    
}

include 'test_cases.php';

$solution = new Solution();

foreach ($testCases as $testCase) {
    $expression = $testCase['expression'];

    $result = $solution->calculate($expression);

    echo "Expression: $expression\n";
    echo "Calculated Result: $result\n";
    echo "\n";
}
?>
