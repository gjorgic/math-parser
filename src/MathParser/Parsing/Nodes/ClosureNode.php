<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;

/**
 * Ovaj node wrapa funkciju i delaya ju za izvršavanje u sljedećoj iteraciji;
 * Rezultat toga je umjesto da funkcija bude izvršena odmah i rezultat bude predan high order funkciji
 * mi u high order funkciji dobijemo funkciju i možemo ju izvršavati u nekoj iteraciji sa promijenjenim contextom
 *
 * Čini mi se da ovaj node dolazi do izražaja kada imamo sintaksu za expression bez zagrada npr XAVG10.2
 *
 * UPDATE:
 * Mislim da više nije potrebna
 */
class ClosureNode extends Node
{
    /**
     * @var FunctionNode
     */
    private $value;

    function __construct(FunctionNode $value)
    {
        throw new \Exception('Is ClosureNode required any more???');
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
