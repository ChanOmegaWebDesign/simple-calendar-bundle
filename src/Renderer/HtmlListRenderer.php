<?php
/**
 *    File: HtmlListRenderer.php
 * Project: simple-calendar-bundle
 *     IDE: PhpStorm
 *  Author: Arleigh Hix
 *   Email: Arleigh@COWDD.com
 *    Date: 9/27/2019
 *    Time: 11:51 AM
 */

namespace COWDDSimpleCalendar\Renderer;


use COWDDSimpleCalendar\Calendar;

class HtmlListRenderer implements RendererInterface
{
  public function render(Calendar $calendar): string
  {
    $Year = new \DateTimeImmutable($calendar->getYear());
    $year = $Year->format($calendar->getFormat('year'));
    $Month = new \DateTimeImmutable($calendar->getMonth());
    $month = $Month->format($calendar->getFormat('month'));

    $date_format = $calendar->getFormat('date');
    $day_format = $calendar->getFormat('day');

    $date = new \DateTime("midnight first day of $month $year");
    $end_date = new \DateTimeImmutable("23:59:59 last day of $month $year");

    $html = "
<ul class='calendar'>
  <li class='calendar-year'>{$year}
    <ul>
      <li class='calendar-month'>{$month}
        <ul>
";

    while ($date < $end_date) {
      $html .= "
        <li class='calendar-day' style='counter-increment: customlistcounter;'>
          <span class='calendar-date'>{$date->format($date_format)}</span>
          <span class='calender-day'>{$date->format($day_format)}</span>
        </li>
        ";
      $date->modify('tomorrow');
    }


    $html .= "
        </ul>
      </li>
    </ul>
  </li>
</ul>
";

    return $html;
  }

}