<?php
/**
 *    File: RendererInterface.php
 * Project: simple-calendar-bundle
 *     IDE: PhpStorm
 *  Author: Arleigh Hix
 *   Email: Arleigh@COWDD.com
 *    Date: 9/26/2019
 *    Time: 11:46 PM
 */

namespace COWDDSimpleCalendar\Renderer;

use COWDDSimpleCalendar\Calendar;

interface RendererInterface
{
  public function render(Calendar $calendar) : string;
}