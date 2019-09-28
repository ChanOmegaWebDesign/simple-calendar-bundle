<?php
/**
 *    File: index.php
 * Project: simple-calendar-bundle
 *     IDE: PhpStorm
 *  Author: Arleigh Hix
 *   Email: Arleigh@COWDD.com
 *    Date: 9/26/2019
 *    Time: 4:27 PM
 */
require_once('../vendor/autoload.php');

use COWDDSimpleCalendar\Calendar;
use COWDDSimpleCalendar\Renderer\HtmlTableRenderer;
use COWDDSimpleCalendar\Renderer\HtmlListRenderer;

$default_calendar = new Calendar();

$options = [
  'renderer'          => HtmlListRenderer::class,
//  'first_day_of_week' => 'SUNDAY',
  'year'              => '1978',
  'month'             => 'september',
  //  'year_format'       => 'y',
  //  'month_format'      => 'M',
  'day_format'        => 'l',
  'date_format'       => 'jS',
];
$options_calendar = new Calendar($options);
$Calendars = [
  'default' => new Calendar(),
  'custom'  => new Calendar($options),
];

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
  <title>simple-calendar-bundle</title>
  <style>
    #default-calendar {
      padding: 1em;
      margin: .5em 1em;
      width: fit-content;
      background: cornflowerblue;
    }
    #default-calendar th{
      color: aliceblue;
    }
    #default-calendar table {
      border: 1px solid aliceblue;
    }
    .calendar {
      font-family: Consolas, monospace;
      font-size: 15px;
    }

    td.calendar-date {
      text-align: center;
      background: white;
      padding: .5em;
    }

    .calendar-date.is-current-month {
      color: #1A1A1A;
    }

    .calendar-date.not-current-month {
      color: #CDCDCD;
    }

    .calendar-date-today {
      background: Aqua;
    }

    .calendar-date-label {
      font-size: 0.8em;
    }

    ul.calendar, .calendar-year ul, .calendar-month ul {
      list-style: none;
    }

    li.calendar-day span.calendar-date {
      display: inline-block;
      width: 2.5em;
    }
  </style>

</head>
<body>
<?php
$calendar = $Calendars['default'];
?>
<section>
  <h1>Using Default Options</h1>
  <p>
    Simple Calendar rendered below with the default options, and just a bit of added styles for font, font-size, colors,
    and
    padding, inside a custom container.
  </p>

  <div class="calendar-container" id="default-calendar">
    <?php
    // This is all you need to render the calendar in your template
    echo $calendar->getView();
    /*
     * In a twig template that has var calendar set to the result of $calendar->getView() use the following
     * {{ calendar|raw }}
     */
    ?>
  </div>
  <section>
    <h1>Default Options</h1>
    <pre>
      <code>
<?php var_export(Calendar::DEFAULT_OPTIONS) ?>
      </code>
    </pre>
  </section>


<?php
$calendar = $Calendars['custom'];
?>
<section>
  <h1>Using Custom Options</h1>
  <p>
    You can set options for the rendered format of <code>'year'</code>, <code>'month'</code>, <code>'date'</code> (day
    of month), and <code>'day'</code> (day of week) strings. You can also use a different RendererInterface to get a
    different style of markup; the HtmlListRenderer is used below. Of course you can also create a calendar for a given month and year; below is the calendar for September, 1978.
  </p>
  <div class="calendar-container" id="custom-calendar">
    <?= $calendar->getView() ?>
  </div>
  <section>
    <h1>Overridden Options</h1>
    <pre>
      <code>
<?php var_export($options) ?>
      </code>
    </pre>
  </section>
</section>
  <section>
    <h1>Supported Formats</h1>
    <p>
      Php format strings used by <code>date</code> and <code>\DateTime::format</code>.<br>
      Refer to: <a href="https://www.php.net/manual/en/function.date.php">https://www.php.net/manual/en/function.date.php</a>
    </p>
    <pre>
      <code>
<?php print_r(Calendar::SUPPORTED_FORMATS) ?>
      </code>
    </pre>
  </section>
</section>
</body>
</html>
