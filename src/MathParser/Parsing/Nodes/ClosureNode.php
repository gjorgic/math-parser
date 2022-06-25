<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;

class ClosureNode extends Node
{
    /**
     * @var FunctionNode
     */
    private $value;

    function __construct(FunctionNode $value)
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
        return $this->value->getOperator();
    }

    /**
     * Implementing the Visitable interface.
     */
    public function accept(Visitor $visitor)
    {
        return $this->value;
    }

    /** Implementing the compareTo abstract method. */
    public function compareTo($other)
    {
        if ($other === null) {
            return false;
        }
        if (!($other instanceof ClosureNode)) {
            return false;
        }

        // @todo additional check
        return $this->value->compareTo($other->getValue());
    }
}
