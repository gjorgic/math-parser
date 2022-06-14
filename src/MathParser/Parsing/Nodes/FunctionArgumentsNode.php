<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;

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
            $inner[] = $node->accept($visitor);
        }

        return $inner;
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
