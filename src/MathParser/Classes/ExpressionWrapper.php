<?php

namespace MathParser\Classes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Parsing\Nodes\AnonymousFunction;
use MathParser\Parsing\Nodes\ExpressionNode;
use MathParser\Parsing\Nodes\FunctionArgumentsNode;

class ExpressionWrapper
{
    protected $node;

    public function __construct(ExpressionNode $node, Visitor $visitor)
    {
        $this->node = new AnonymousFunction($node, $visitor);

        $this->node->setSkipExecution(true);
    }

    public function __invoke()
    {
        return call_user_func_array($this->node, func_get_args());
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->node, $name], $arguments);
    }
}
