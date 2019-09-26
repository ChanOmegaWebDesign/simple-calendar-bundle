<?php
/**
 *    File: Exception.php
 * Project: simple-calendar-bundle
 *     IDE: PhpStorm
 *  Author: Arleigh Hix
 *   Email: Arleigh@COWDD.com
 *    Date: 9/26/2019
 *    Time: 3:44 AM
 */

namespace COWDDSimpleCalendar\Exception;


class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
  public static function message(array $expected, $received)
  {
    return 'Expected value of "' . implode('"|"', $expected) . '", got "' . $received . '"';
  }
}