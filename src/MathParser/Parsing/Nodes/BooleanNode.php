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

/**
 * AST node representing a number (int or float)
 */
class BooleanNode extends Node
{
    /** int|float $value The value of the represented number. */
    private $value;

    /** Constructor. Create a NumberNode with given value. */
    function __construct($value)
    {
        $this->value = $value;

        if (!is_bool($value)) throw new \UnexpectedValueException();
    }

    /**
     * Returns the value
     * @retval int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getNumerator()
    {
        return $this->value;
    }

    public function getDenominator()
    {
        return 1;
    }

    /**
     * Implementing the Visitable interface.
     */
    public function accept(Visitor $visitor)
    {
        return $visitor->visitBooleanNode($this);
    }

    public function isTerminal()
    {
        return true;
    }

    /** Implementing the compareTo abstract method. */
    public function compareTo($other)
    {
        if ($other === null) {
            return false;
        }
        if (!$other instanceof BooleanNode) {
            return false;
        }

        return $this->getValue() == $other->getValue();
    }

}
