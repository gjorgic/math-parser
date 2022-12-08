<?php

namespace MathParser\Parsing\Nodes\Interfaces;

interface InvokableInterface extends AcceptContextContract
{
    public function __invoke();

    public function acceptContext($context);
}