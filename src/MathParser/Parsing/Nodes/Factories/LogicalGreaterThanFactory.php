<?php

namespace MathParser\Parsing\Nodes\Factories;

use MathParser\Parsing\Nodes\Interfaces\ExpressionNodeFactory;

use MathParser\Parsing\Nodes\Node;
use MathParser\Parsing\Nodes\IntegerNode;

use MathParser\Parsing\Nodes\ExpressionNode;
use MathParser\Parsing\Nodes\Traits\Sanitize;
use MathParser\Parsing\Nodes\Traits\Numeric;

class LogicalGreaterThanFactory implements ExpressionNodeFactory
{
    use Sanitize;
    use Numeric;

    /**
     * @param Node|int $leftOperand First factor
     * @param Node|int $rightOperand Second factor
     *
     * @return Node
     */
    public function makeNode($leftOperand, $rightOperand)
    {
        $leftOperand = $this->sanitize($leftOperand);
        $rightOperand = $this->sanitize($rightOperand);

        $node = $this->numericFactors($leftOperand, $rightOperand);
        if ($node) return $node;

        return new ExpressionNode($leftOperand, '>', $rightOperand);
    }

    /**
    * Simplify a*b when a or b are certain numeric values
    *
    * @param Node $leftOperand
    * @param Node $rightOperand
    *
    * @return Node|null
    **/
    private function numericFactors($leftOperand, $rightOperand)
    {
        if ($this->isNumeric($leftOperand) && $this->isNumeric($rightOperand)) {
            $true = $leftOperand->getValue() > $rightOperand->getValue();
            return new IntegerNode($true ? 1 : 0);
        }

        return null;
    }
}
