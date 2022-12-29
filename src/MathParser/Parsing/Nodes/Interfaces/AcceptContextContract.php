<?php

namespace MathParser\Parsing\Nodes\Interfaces;

interface AcceptContextContract
{
    public function acceptContext(ContextInterface $context);
}
