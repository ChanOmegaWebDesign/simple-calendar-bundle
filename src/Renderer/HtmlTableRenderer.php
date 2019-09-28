<?php
/**
 *    File: HtmlTableRenderer.php
 * Project: simple-calendar-bundle
 *     IDE: PhpStorm
 *  Author: Arleigh Hix
 *   Email: Arleigh@COWDD.com
 *    Date: 9/27/2019
 *    Time: 12:10 AM
 */

namespace COWDDSimpleCalendar\Renderer;

use COWDDSimpleCalendar\Calendar;

class HtmlTableRenderer implements RendererInterface
{
  public function render(Calendar $calendar): string
  {
    $requested_month = $calendar->getMonth();
    $requested_year = $calendar->getYear();
    $today = $calendar->getToday();


    // var $date will be our iterator-date
    $date = new \DateTime("midnight first day of $requested_month $requested_year");

    // get the Saturday of the week of the last day of the Month
    $last_day = new \DateTime("last day of $requested_month $requested_year");
    $last_day->modify('saturday this week'); // last day of calendar

    // get the month string to label the calendar;
    $calendar_month = $date->format($calendar->getFormat('month') . ' ' . $calendar->getFormat('year'));
    // set day of week labels
    $days = [
      "Sun",
      "Mon",
      "Tue",
      "Wed",
      "Thu",
      "Fri",
      "Sat",
    ];
    // set the iterator-date to the Sunday of the first week of the month
    if ('Sunday' !== $date->format('l')) {
      // remember the week in PHP begins on Monday
      $date->modify('monday this week -1day');
    }

    ob_start();
    ?>
    <table class="calendar">
      <thead>
      <tr>
        <th scope="colgroup" class="text-center" colspan="7"><?php echo $calendar_month; ?></th>
      </tr>
      <tr>
        <?php
        foreach ($days as $day) {
          // avoid DST issues at noon
          $day = new \DateTime("noon $day");
          echo '<th scope="col" class="text-center">' . $day->format($calendar->getFormat('Day')) . "</th>\n";
        }
        ?>
      </tr>
      </thead>
      <tbody>
      <?php
      while ($date <= $last_day) {
        // start a row every Sunday
        if ('Sunday' === $date->format('l')) {
          echo "<tr>\n";
        }

        $class = ($date->format($calendar->getFormat('Month') . ' ' . $calendar->getFormat('Year')) === $calendar_month) ? 'is-current-month' : 'not-current-month';
        if ($today == $date) {
          $class .= ' calendar-date-today';
        }
        echo '<td class="' . $class . ' calendar-date"><span class="calendar-date-label">' . $date->format('j') . "</span></td>\n";

        // end the row every Saturday
        if ('Saturday' === $date->format('l')) {
          echo "</tr>\n";
        }
        // increment the iterator-date
        $date->modify('+1day');
      }
      ?>
      </tbody>
    </table>
    <?php

    return ob_get_clean();
  }
}