<?php
/*
* @package     Parsing
* @author      Frank Wikström <frank@mossadal.se>
* @copyright   2015 Frank Wikström
* @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
*
*/

namespace MathParser\Parsing\Nodes\Factories;

use MathParser\Parsing\Nodes\Interfaces\ExpressionNodeFactory;

use MathParser\Parsing\Nodes\Node;
use MathParser\Parsing\Nodes\NumberNode;
use MathParser\Parsing\Nodes\IntegerNode;
use MathParser\Parsing\Nodes\RationalNode;

use MathParser\Parsing\Nodes\ExpressionNode;
use MathParser\Parsing\Nodes\Traits\Sanitize;
use MathParser\Parsing\Nodes\Traits\Numeric;

/**
* Factory for creating an ExpressionNode representing '*'.
*
* Some basic simplification is applied to the resulting Node.
*
*/
class LogicalAndNodeFactory implements ExpressionNodeFactory
{
    use Sanitize;
    use Numeric;

    /**
    * Create a Node representing 'leftOperand * rightOperand'
    *
    * Using some simplification rules, create a NumberNode or ExpressionNode
    * giving an AST correctly representing 'leftOperand * rightOperand'.
    *
    * ### Simplification rules:
    *
    * - To simplify the use of the function, convert integer params to NumberNodes
    * - If $leftOperand and $rightOperand are both NumberNodes, return a single NumberNode containing their product
    * - If $leftOperand or $rightOperand is a NumberNode representing 0, return '0'
    * - If $leftOperand or $rightOperand is a NumberNode representing 1, return the other factor
    *
    * @param Node|int $leftOperand First factor
    * @param Node|int $rightOperand Second factor
    * @retval Node
    */
    public function makeNode($leftOperand, $rightOperand)
    {
        $leftOperand = $this->sanitize($leftOperand);
        $rightOperand = $this->sanitize($rightOperand);

        $node = $this->numericFactors($leftOperand, $rightOperand);
        if ($node) return $node;

        return new ExpressionNode($leftOperand, 'AND', $rightOperand);
    }

    /**
    * Simplify a*b when a or b are certain numeric values
    *
    * @param Node $leftOperand
    * @param Node $rightOperand
    * @retval Node|null
    **/
    private function numericFactors($leftOperand, $rightOperand)
    {
        if ($this->isNumeric($leftOperand) && $this->isNumeric($rightOperand)) {
            $true = !!$leftOperand->getValue() && !!$rightOperand->getValue();
            return new IntegerNode($true ? 1 : 0);
        }

        return null;
    }
}
