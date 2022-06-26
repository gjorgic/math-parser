<?php
/*
 * @package     Lexical analysis
 * @subpackage  Token handling
 * @author      Frank Wikström <frank@mossadal.se>
 * @copyright   2015 Frank Wikström
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 *
 */

namespace MathParser\Lexing;

use MathParser\Parsing\Nodes\Node;

/**
 * Token class
 *
 * Class to handle tokens, i.e. discrete pieces of the input string
 * that has specific meaning.
 *
 */
abstract class CustomExpressionToken extends Token
{
    abstract public function makeNode(): Node;

    abstract public function simplify($leftOperand, $rightOperand): Node;

    abstract public function evaluate($leftValue, $rightValue);
}
