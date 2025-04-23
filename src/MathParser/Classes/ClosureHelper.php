<?php

namespace MathParser\Classes;

use MathParser\Interpreting\Visitors\Visitor;
use MathParser\Parsing\Nodes\Interfaces\AcceptContextContract;
use MathParser\Parsing\Nodes\Interfaces\FirstOrderFunctionInterface;

/**
 * Ova klasa je neka vrsta evaluator wrappera za function node, dakle, umjesto da nekoj high order funkciji
 * prosljedimo FunctionNode pa da se ona mora brinuti za evaluator, mi sve to wrapamo sa ovom klasom
 * i onda smo u HighOrderFunkciji (za sada samo abstract function) posvećeni isključivo poslovnoj logici te funkcije
 *
 * Primjena ovoga može biti i u HighOrderFunkcijama ali za sada nejasno kako
 *
 * UPDATE:
 * napravljeno je da po novome prihvaća bilo koji node, pošto HOF može imati funkciju, expression...
 * Odustalo se od kreiranja nove instance noda jer ionako ne postižemo ništa kada imamo expression pošto on može
 * biti nepoznato nestan; a mislim da referenciranje neće prouzročiti grešku u evaluaciji,
 * na to se mora paziti kod implementacije
 */
class ClosureHelper implements FirstOrderFunctionInterface
{
    protected $node;

    protected $visitor;

    protected $context;

    public function __construct($node, Visitor $visitor)
    {
        // @todo mislim da se ovi komentari mogu maknuti
        // Mislim da ovo više nije ni potrebno jer HOF logika ne izvršava neki node dok ne vidi tko ga je tražio
        // Ipak je ovo potrebno jer sam za `XAVG(C, 10)` ovdje primio function node
        // te je rezultat toga bio `Close` funkcija
        // ako nema ovog flag-a onda je rezultat evaluacije numerička vrijednost

        // Znači ipak nešto još fali u koracima
        // $node->setSkipExecution(true);

        $this->node = $node;
        $this->visitor = $visitor;
    }

    public function __invoke()
    {
        if (func_num_args()) {
            throw new \Exception('You must invoke ClosureHelper without any argument');
        }

        return $inner = $this->node->accept($this->visitor);

        if ($inner instanceof AcceptContextContract) {
            $inner->acceptContext($this->context);
        }

        return call_user_func_array($inner, func_get_args());
    }

    public function acceptContext($context)
    {
        $this->context = $context;

        return $this;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->node, $name], $arguments);
    }

    public function resetHistory()
    {
        $this->visitor->clearRememberedFunctions();
    }
}
