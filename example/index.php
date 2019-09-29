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
  'renderer'    => HtmlListRenderer::class,
  //  'first_day_of_week' => 'SUNDAY',
  'year'        => '1978',
  'month'       => 'september',
  //  'year_format'       => 'y',
  //  'month_format'      => 'M',
  'day_format'  => 'l',
  'date_format' => 'jS',
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
    html {
      margin: 0;
      padding: 0;
      background: cornflowerblue;
    }

    body {
      margin: 0;
      padding: 1em;
      background: #EEEEEE;
      min-width: 350px;
    }

    section {
      margin: 1em auto;
      padding: 1px 1.5em 1em;
      background: rgba(0, 0, 0, .05);
      border-radius: .5em;
      max-width: 800px;
      /*width: 90%;*/
    }
    section p {
      max-width: 550px;
      margin: auto;
      margin-bottom: 1.5em;
    }

    section:first-of-type {
      /*margin-top: 1em;*/
    }

    section section {
      width: auto;
      max-width: fit-content;
      /*overflow: auto;*/
    }


    #default-calendar {
      padding: 1em;
      margin: .5em auto 1.5em;
      width: fit-content;
      background: cornflowerblue;
    }

    #default-calendar th {
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

    .calendar-date.calendar-date-today {
      background: Aqua;
      font-weight: bold;
    }

    .calendar-date-label {
      font-size: 0.8em;
    }

    #custom-calendar {
      width: fit-content;
      margin: auto auto 1.5em;

    }

    #custom-calendar ul {
      padding-left: .8em;
      width: fit-content;
      list-style: none;
      background: rgba(99, 159, 255, .1);
    }
    #custom-calendar .calendar-month ul{
      max-height: 15em;
      overflow: auto;
      min-width: 20ch;
    }

    #custom-calendar li {
      width: fit-content;
      padding: 1em;
    }

    #custom-calendar li.calendar-day {
      padding: .2em 1em .2em .2em;
    }
    #custom-calendar li.calendar-day:first-child {
      padding-top: 1em;
    }


    li.calendar-day span.calendar-date {
      display: inline-block;
      width: 2.5em;
      text-align: right;
    }

    pre {
      padding: 1em;
      max-width: fit-content;
      overflow: auto;
      color: white;
      background: #1A1A1A;
    }

    pre code {

    }


    /*.row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-evenly;
    }*/

  </style>

</head>
<body>
<?php
$calendar = $Calendars['default'];
?>
<div class="row">
  <section>
    <h1>Using Default Options</h1>
    <p>
      Simple Calendar rendered below with the default options, and just a bit of added styles for font, font-size,
      colors,
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
      <pre><code><?php
          echo '$options = ' . var_export(Calendar::DEFAULT_OPTIONS, true) . ';';
          ?></code></pre>
    </section>


  </section>


  <?php
  $calendar = $Calendars['custom'];
  ?>
  <section>
    <h1>Using Custom Options</h1>
    <p>
      You can set options for the rendered format of <code>'year'</code>, <code>'month'</code>, <code>'date'</code> (day
      of month), and <code>'day'</code> (day of week) strings. You can also use a different RendererInterface to get a
      different style of markup; the HtmlListRenderer is used below. Of course you can also create a calendar for a
      given month and year; below is the calendar for September, 1978.
    </p>
    <div class="calendar-container" id="custom-calendar">
      <?= $calendar->getView() ?>
    </div>

    <section>
      <h1>Overridden Options</h1>
      <pre><code><?php
          echo '$options = ' . var_export($options, true) . ';';
          ?></code></pre>
    </section>
  </section>
</div>
<div class="row">
  <section>
    <h1>Supported Formats</h1>
    <p>
      Php format strings used by <code>date</code> and <code>\DateTime::format</code>.<br>
      Refer to: <a
        href="https://www.php.net/manual/en/function.date.php">https://www.php.net/manual/en/function.date.php</a>
    </p>
    <pre><code><?php
        //var_export(Calendar::SUPPORTED_FORMATS);
        echo "Calendar::SUPPORTED_FORMATS => [\n";
        foreach (Calendar::SUPPORTED_FORMATS as $PART => $FORMATS) {
          echo "  '$PART' => [\"" . implode('", "', $FORMATS) . "\"],\n";
        }
        echo "];"
        ?></code></pre>

  </section>
</div>
</body>
</html>
