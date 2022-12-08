<?php


namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Lexing\Token;

class HigherOrderFunctionNode extends FunctionNode
{
    /** string $name Function name, e.g. 'sin' */
    private $name;
    /** Node $operand AST of function operand */
    private $operand;

    private $token;

    protected $skipExecution = false;

    protected $prevInstance;

    /** Constructor, create a FunctionNode with given name and operand */
    function __construct($name, $operand, ?Token $token)
    {
        $this->name = $name;
        $this->token = $token;
        if (is_int($operand)) $operand = new NumberNode($operand);
        $this->operand = $operand;
    }

    /**
     * Return the name of the function
     * @retval string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the operand
     * @retval Node
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * Set the operand
     * @retval void
     */
    public function setOperand($operand)
    {
        return $this->operand = $operand;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getOperator()
    {
        return $this->name;
    }

    /**
     * Implementing the Visitable interface.
     */
    public function accept(Visitor $visitor)
    {
        return $visitor->visitHighOrderFunctionNode($this);
    }

    public function compareTo($other)
    {
        if ($other === null) {
            return false;
        }
        if (!($other instanceof HigherOrderFunctionNode)) {
            return false;
        }

        $thisOperand = $this->getOperand();
        $otherOperand = $other->getOperand();

        return $this->getName() == $other->getName() && $thisOperand->compareTo($otherOperand);
    }
}
