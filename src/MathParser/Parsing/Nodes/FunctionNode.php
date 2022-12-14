<?php
/*
 * @package     Parsing
 * @author      Frank Wikström <frank@mossadal.se>
 * @copyright   2015 Frank Wikström
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 *
 */

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Lexing\Token;

/**
 * AST node representing a function applications (e.g. sin(...))
 */
class FunctionNode extends Node
{
    /** string $name Function name, e.g. 'sin' */
    private $name;
    /** Node $operand AST of function operand */
    private $operand;

    private $token;

    protected $skipExecution = false;

    protected $prevInstance;

    /**
     * This is function unique id
     * It is used by visitor (Evaliuator) to cache instance if HistoryAware
     * It MUST be accessed via method `getHash`
     *
     * @var string
     */
    protected $hash;

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
        return $visitor->visitFunctionNode($this);
    }

    public function setSkipExecution($skip)
    {
        $this->skipExecution = $skip;
    }

    public function getSkipExecution()
    {
        return $this->skipExecution;
    }

    /** Implementing the compareTo abstract method. */
    public function compareTo($other)
    {
        if ($other === null) {
            return false;
        }
        if (!($other instanceof FunctionNode)) {
            return false;
        }

        $thisOperand = $this->getOperand();
        $otherOperand = $other->getOperand();

        return $this->getName() == $other->getName() && $thisOperand->compareTo($otherOperand);
    }

    public function hasPrevInstance()
    {
        return $this->prevInstance != null;
    }

    public function getPrevInstance()
    {
        return $this->prevInstance;
    }

    public function setPrevInstance($prevInstance)
    {
        $this->prevInstance = $prevInstance;
    }

    public function getHash()
    {
        if (!$this->hash) {
            $this->hash = uniqid('', true);
        }

        return $this->hash;
    }

}
