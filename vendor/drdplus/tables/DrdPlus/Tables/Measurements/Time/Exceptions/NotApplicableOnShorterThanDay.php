<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Time\Exceptions;

class NotApplicableOnShorterThanDay extends \InvalidArgumentException implements Logic
{

}