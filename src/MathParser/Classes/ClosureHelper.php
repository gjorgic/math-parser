<?php

namespace MathParser\Classes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Parsing\Nodes\FunctionNode;
use MathParser\Parsing\Nodes\Interfaces\InvokableInterface;
use MathParser\Parsing\Nodes\Node;

class ClosureHelper implements InvokableInterface
{
    protected $node;

    public function __construct(FunctionNode $node, Visitor $visitor)
    {
        $newNode = new FunctionNode(
            $node->getName(),
            $node->getOperand(),
            $node->getToken()
        );

        $newNode->setSkipExecution(true);

        $this->node = $newNode->accept($visitor);
    }

    public function __invoke()
    {
        return call_user_func_array($this->node, func_get_args());
    }

    public function acceptContext($context)
    {
        $this->node->acceptContext($context);

        return $this;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->node, $name], $arguments);
    }
}
