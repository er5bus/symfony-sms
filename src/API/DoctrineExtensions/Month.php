<?php

namespace API\DoctrineExtensions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Rami Sfari <rami2sfari@gmail.com>
 * @copyright Copyright (c) 2017, SMS
 */
class Month extends FunctionNode
{
    public $date;
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "MONTH(" . $sqlWalker->walkArithmeticPrimary($this->date) . ")";
    }
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
