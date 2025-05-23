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

/**
 * Token type values
 *
 * Currently, the following token types are available
 *
 * * PosInt
 * * Integer
 * * RealNumber
 * * Identifier
 * * OpenParenthesis
 * * CloseParenthesis
 * * UnaryMinus
 * * AdditionOperator
 * * SubtractionOperator
 * * MultiplicationOperator
 * * DivisionOperator
 * * ExponentiationOperator
 * * FunctionName
 * * Constant
 * * Terminator
 * * Whitespace
 * * Sentinel
 *
 */
final class TokenType
{
    /** Token representing a positive integer */
    const PosInt = 1;
    /** Token representing a (not necessarily positive) integer */
    const Integer = 2;
    /** Token representing a floating point number */
    const RealNumber = 3;

    const Boolean = 6;

    /** Token representing an identifier, i.e. a variable name. */
    const Identifier = 20;
    /** Token representing an opening parenthesis, i.e. '(' */
    const OpenParenthesis = 31;
    /** Token representing a closing parenthesis, i.e. ')' */
    const CloseParenthesis = 32;

    const LogicalGreaterThanEqual = 84;
    const LogicalGreaterThan = 85;
    const LogicalLowerThanEqual = 86;
    const LogicalLowerThan = 87;
    const LogicalEqualTo = 88;
    const LogicalNotEqualTo = 89;
    const LogicalOrOperator = 90;
    const LogicalAndOperator = 91;

    /** Token representing a unary minus. Not used. This is the responsibility of the Parser */
    const UnaryMinus = 99;
    /** Token representing '+' */
    const AdditionOperator = 100;
    /** Token representing '-' */
    const SubtractionOperator = 101;
    /** Token representing '*' */
    const MultiplicationOperator = 102;
    /** Token representing '/' */
    const DivisionOperator = 103;
    /** Token representing '^' */
    const ExponentiationOperator = 104;
    /** Token representing postfix factorial operator '!' */
    const FactorialOperator = 105;
    /** Token representing postfix subfactorial operator '!!' */
    const SemiFactorialOperator = 105;

    /** Token represented a function name, e.g. 'sin' */
    const FunctionName = 200;

    /** Token represented a function name, e.g. 'map' */
    const HighOrderFunctionName = 250;

    /** Token represented a known constant, e.g. 'pi' */
    const Constant = 300;

    const ArgumentDivider = 997;

    /** Token representing a terminator, e.g. ';'. Currently not used. */
    const Terminator = 998;
    /** Token representing white space, e.g. spaces and tabs. */
    const Whitespace = 999;

    /** Token representing a senitinel, for internal used in the Parser. Not used. */
    const Sentinel = 1000;
}
