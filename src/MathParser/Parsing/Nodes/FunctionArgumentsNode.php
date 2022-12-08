<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Classes\ClosureHelper;
use MathParser\Classes\ExpressionWrapper;

class FunctionArgumentsNode extends Node
{
    /**
     * List of arguments nodes
     *
     * @var Node[]
     */
    private $value;

    function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value
     *
     * @return int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getOperator()
    {
        return null;
    }

    /**
     * Implementing the Visitable interface.
     */
    public function accept(Visitor $visitor)
    {
        $inner = [];
        foreach ($this->value as $node) {
            if ($node instanceof ExpressionNode) {
                $this->skipExecutionForFunctions($node);
            }

            $item = $node->accept($visitor);
            if ($item instanceof FunctionNode) {
                $item = $this->quoteFunction($item, $visitor);
            }

            $inner[] = $item;
        }

        return $inner;
    }

    protected function quoteFunction(FunctionNode $node, Visitor $visitor)
    {
        return new ClosureHelper($node, $visitor);
    }

    protected function quoteExpression(ExpressionNode $node, Visitor $visitor)
    {
        return new ExpressionWrapper($node, $visitor);
    }

    protected function hasFunctionX(ExpressionNode $node)
    {
        if ($node->getLeft() instanceof FunctionNode) {
            return true;
        }

        if ($node->getRight() instanceof FunctionNode) {
            return true;
        }

        return false;
    }

    protected function skipExecutionForFunctions(ExpressionNode $node)
    {
        $left = $node->getLeft();
        $right = $node->getRight();

        if ($left instanceof FunctionNode) {
            $left->setSkipExecution(true);
        }

        if ($right instanceof FunctionNode) {
            $right->setSkipExecution(true);
        }
    }

    /** Implementing the compareTo abstract method. */
    public function compareTo($other)
    {
        if ($other === null) {
            return false;
        }
        if (!($other instanceof FunctionArgumentsNode)) {
            return false;
        }

        return $this->getValue() == $other->getValue();
    }
}
