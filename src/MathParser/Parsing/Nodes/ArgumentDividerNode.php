<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;

class ArgumentDividerNode extends Node
{
    private $value;

    function __construct($value)
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
        return ',';
    }

    /**
     * Implementing the Visitable interface.
     */
    public function accept(Visitor $visitor)
    {
        return null;
    }

    /** Implementing the compareTo abstract method. */
    public function compareTo($other)
    {
        if ($other === null) {
            return false;
        }
        if (!($other instanceof ArgumentDividerNode)) {
            return false;
        }

        return $this->getValue() == $other->getValue();
    }
}
