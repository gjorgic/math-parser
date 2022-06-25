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
            $item = $node->accept($visitor);
            if ($item instanceof FunctionNode) {
                $item = $this->quote($item, $visitor);
            }
            $inner[] = $item;
        }

        return $inner;
    }

    protected function quote(FunctionNode $node, Visitor $visitor)
    {
        return function ($offset) use ($node, $visitor) {
            $newNode = new FunctionNode(
                $node->getName(),
                $node->getOperand(),
                $node->getToken()
            );

            $newNode->setSkipExecution(true);

            $item = $newNode->accept($visitor);

            return call_user_func_array($item, func_get_args());
        };
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
