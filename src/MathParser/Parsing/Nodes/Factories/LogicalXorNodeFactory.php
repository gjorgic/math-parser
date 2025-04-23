<?php
/*
* @package     Parsing
* @author      Frank Wikström <frank@mossadal.se>
* @copyright   2015 Frank Wikström
* @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
*
*/

namespace MathParser\Parsing\Nodes\Factories;

use MathParser\Parsing\Nodes\BooleanNode;
use MathParser\Parsing\Nodes\Interfaces\ExpressionNodeFactory;
use MathParser\Parsing\Nodes\Node;
use MathParser\Parsing\Nodes\ExpressionNode;
use MathParser\Parsing\Nodes\Traits\Boolean\Sanitize;
use MathParser\Parsing\Nodes\Traits\Boolean\Boolean;

/**
* Factory for creating an ExpressionNode representing '+'.
*
* Some basic simplification is applied to the resulting Node.
*
*/
class LogicalXorNodeFactory implements ExpressionNodeFactory
{
    use Sanitize;
    use Boolean;

    /**
     * Create a Node representing 'leftOperand OR rightOperand'
     *
     * @param Node|int $leftOperand First term
     * @param Node|int $rightOperand Second term
     *
     * @return Node
     **/
    public function makeNode($leftOperand, $rightOperand)
    {
        $leftOperand = $this->sanitize($leftOperand);
        $rightOperand = $this->sanitize($rightOperand);

        $node = $this->numericTerms($leftOperand, $rightOperand);
        if ($node) return $node;

        return new ExpressionNode($leftOperand, 'XOR', $rightOperand);
    }

    /** Simplify addition node when operands are numeric
     *
     * @param Node $leftOperand
     * @param Node $rightOperand
     *
     * @return Node|null
     */
    protected function numericTerms($leftOperand, $rightOperand)
    {
        if ($this->isBoolean($leftOperand) && $this->isBoolean($rightOperand)) {
            $value = $leftOperand->getValue() != $rightOperand->getValue();
            return new BooleanNode($value);
        }

        return null;
    }
}
