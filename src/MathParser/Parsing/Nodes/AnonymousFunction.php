<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Lexing\Token;
use MathParser\Parsing\Nodes\Interfaces\InvokableInterface;

class AnonymousFunction extends Node implements InvokableInterface
{
    protected $name;

    protected $context;

    public function __construct(
        protected ExpressionNode $node,
        protected \Closure $onInvoke
    ) {
        $this->name = 'F(x) => '.$node->getOperator();
    }

    public function compareTo($other)
    {
        throw new \Exception('NOT IMPLEMENTED');
    }

    public function __invoke()
    {
        return call_user_func_array($this->onInvoke, [$this->context]);
    }

    public function acceptContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Implementing the Visitable interface.
     */
    public function accept(Visitor $visitor)
    {
        $item = $this->node->accept($visitor);

        if ($item instanceof FunctionNode) {
            throw new \Exception('Rezultzat odgođenog expressiona je Funkcija');
            // $item = $this->quoteFunction($item, $visitor);
        }

        return $item;
    }

    /**
     * Return the name of the function
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the operand
     *
     * @return ExpressionNode
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * Set the operand
     *
     * @param ExpressionNode $operand
     *
     * @return void
     */
    public function setOperand(ExpressionNode $operand)
    {
        return $this->operand = $operand;
    }

    public function setSkipExecution($skip)
    {
        $this->skipExecution = $skip;
    }

    public function getSkipExecution()
    {
        return $this->skipExecution;
    }
}
