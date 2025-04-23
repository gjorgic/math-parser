<?php

namespace MathParser\Parsing\Nodes\Factories;

use MathParser\Parsing\Nodes\BooleanNode;
use MathParser\Parsing\Nodes\Interfaces\ExpressionNodeFactory;

use MathParser\Parsing\Nodes\Node;
use MathParser\Parsing\Nodes\IntegerNode;

use MathParser\Parsing\Nodes\ExpressionNode;
use MathParser\Parsing\Nodes\Traits\Boolean\Sanitize;
use MathParser\Parsing\Nodes\Traits\Boolean\Boolean;

class LogicalEqualToFactory implements ExpressionNodeFactory
{
    use Sanitize;
    use Boolean;

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

        return new ExpressionNode($leftOperand, '=', $rightOperand);
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
        if ($this->isBoolean($leftOperand) && $this->isBoolean($rightOperand)) {
            $value = $leftOperand->getValue() == $rightOperand->getValue();
            return new BooleanNode($value);
        }

        return null;
    }
}
