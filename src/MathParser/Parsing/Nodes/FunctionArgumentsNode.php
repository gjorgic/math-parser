<?php

namespace MathParser\Parsing\Nodes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Classes\ClosureHelper;
use MathParser\Classes\ExpressionWrapper;

/**
 * Ova klasa služi za grupiranje parametara neke funkcije
 * kada se radi evaluacija, ova klasa radi wrapanje svih nodova tipa AbstractFunction sa evaluator
 * helper wrapperom `ClosureHelper` koji se onda prosljeđuje HighOrderFunkciji na procesiranje
 *
 * Pošto prije nije postojao pojam HighOrderFunction, taj dio se riješavao na nivou implementacije funkcije u metodi ::resolveArguments
 * tako da se odgovarajući argument wrapao sa ClosureNode klasom koja ima ulogu delajanja evaluacije
 *
 * Problem je taj, što se metoda ::resolveArguments poziva samo ako je expression funkcije u
 * short obliku (bez zagrada) tipa XAVGC10,15
 *
 * Ako se koristi zapis funkcije sa zagradama onda su argumenti prethodno evaluirani, i upravo tu
 * trebamo napraviti promijenu uvođenjem HighOrderFunkcije da možemo preventat izvršavanje funkcija bez znanja o kojoj se HighOrderFunkciji radi
 *
 * Možda bi dobrar pristup bio da ako je potpis funkcije HighOrderFunction da sve argumente ne izvršavamo već da ih wrapamo???
 *
 */
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
                throw new \Exception('Unexpected using of ClosureHelper function; see why this happen!');
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
