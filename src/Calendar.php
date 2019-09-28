<?php
/**
 *    File: Calendar.php
 * Project: simple-calendar-bundle
 *     IDE: PhpStorm
 *  Author: Arleigh Hix
 *   Email: Arleigh@COWDD.com
 *    Date: 9/26/2019
 *    Time: 1:56 AM
 */

namespace COWDDSimpleCalendar;


use COWDDSimpleCalendar\Exception\UnexpectedValueException;
use COWDDSimpleCalendar\Renderer\HtmlTableRenderer;
use COWDDSimpleCalendar\Renderer\RendererInterface;

class Calendar
{
  const SUNDAY = 'Sunday';
  const MONDAY = 'Monday';
  const FIRST_DAY_OF_WEEK = [
    0        => self::SUNDAY,
    1        => self::MONDAY,
    'sunday' => self::SUNDAY,
    'monday' => self::MONDAY,
    'sun'    => self::SUNDAY,
    'mon'    => self::MONDAY,
  ];
  const DEFAULT_OPTIONS = [
    'renderer'          => HtmlTableRenderer::class,
    'first_day_of_week' => self::SUNDAY,
    'year'              => null,
    'month'             => null,
    'year_format'       => 'Y',
    'month_format'      => 'F',
    'day_format'        => 'D',
    'date_format'       => 'j',
  ];
  const SUPPORTED_FORMATS = [
    'year'  => ['Y', 'y'],
    'month' => ['F', 'm', 'M', 'n'],
    'date'  => ['d', 'j', 'z', 'jS'],
    'day'   => ['D', 'l', 'N', 'w'],
  ];

  /**
   * @var RendererInterface $renderer
   */
  private $renderer;
  private $first_day_of_week;
  private $year;
  private $month;
  private $year_format = 'Y';
  private $month_format;
  private $day_format;
  private $date_format;

  private $today;

  public function __construct(array $options = [])
  {
    $this->today = new \DateTimeImmutable('today');
    $options = array_merge(self::DEFAULT_OPTIONS, $options);

    if (null === $options['year']) {
      $options['year'] = $this->today->format('Y');
    }
    if (null === $options['month']) {
      $options['month'] = $this->today->format($options['month_format']);
    }

    $this
      ->setFirstDayOfWeek($options['first_day_of_week'])
      ->setYear($options['year'])
      ->setMonth($options['month'])
      ->setRenderer($options['renderer'])
    ;

    foreach (['year', 'month', 'day', 'date'] as $part) {
      $this->setFormat($part, $options[$part . '_format']);
    }

  }

  /**
   * @return \DateTimeImmutable
   */
  public function getToday()
  {
    return $this->today;
  }

  /**
   * @return \COWDDSimpleCalendar\Renderer\RendererInterface
   */
  public function getRenderer()
  {
    return $this->renderer;
  }

  /**
   * @param \COWDDSimpleCalendar\Renderer\RendererInterface $renderer
   *
   * @return Calendar
   */
  public function setRenderer($renderer)
  {
    if ($renderer instanceof RendererInterface) {
      $this->renderer = $renderer;

      return $this;
    }
    if (in_array(RendererInterface::class, class_implements($renderer))) {
      $this->renderer = new $renderer;

      return $this;
    }
    if (is_object($renderer)){
      $renderer = get_class($renderer);
    }
    throw new UnexpectedValueException('$options["renderer"] must be instanceof "'.RendererInterface::class. '" got:"'.$renderer.'"');

  }

  /**
   * @return string
   */
  public function getYearFormat()
  {
    return $this->year_format;
  }

  /**
   * @param string $year_format
   *
   * @return Calendar
   */
  public function setYearFormat($year_format)
  {
    $this->year_format = $year_format;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getFirstDayOfWeek()
  {
    return $this->first_day_of_week;
  }

  /**
   * @param string $day
   *
   * @return Calendar
   */
  public function setFirstDayOfWeek(string $day): self
  {
    $day = strtolower($day);
    if (!in_array($day, array_keys(self::FIRST_DAY_OF_WEEK))) {
      throw new UnexpectedValueException(UnexpectedValueException::message(array_keys(self::FIRST_DAY_OF_WEEK), $day));
    }
    $this->first_day_of_week = self::FIRST_DAY_OF_WEEK[$day];

    return $this;
  }

  public function getYear(): string
  {
    return $this->year;
  }

  /**
   * @param mixed $year
   *
   * @return Calendar
   */
  public function setYear($year): self
  {
    $this->year = $year;
    return $this;
  }

  public function getMonth(): string
  {
    return $this->month;
  }

  /**
   * @param mixed $month
   *
   * @return Calendar
   */
  public function setMonth($month): self
  {
    $this->month = $month;
    return $this;
  }


  public function getFormatParts(): array
  {
    return array_keys(self::SUPPORTED_FORMATS);
  }

  public function getFormat(string $part): string
  {
    $part = strtolower($part);
    if (!in_array($part, $this->getFormatParts())) {
      throw new UnexpectedValueException(UnexpectedValueException::message($this->getFormatParts(), $part));
    }

    return $this->{$part . '_format'};
  }

  public function setFormat(string $part, string $format): self
  {
    $part = strtolower($part);
    if (!in_array($part, $this->getFormatParts())) {
      throw new UnexpectedValueException(UnexpectedValueException::message($this->getFormatParts(), $part));
    }
    if (!in_array($format, self::SUPPORTED_FORMATS[$part])) {
      throw new UnexpectedValueException(UnexpectedValueException::message(self::SUPPORTED_FORMATS[$part], $format));
    }
    $this->{$part . '_format'} = $format;

    return $this;
  }


  public function getView(): string
  {
    return $this->renderer->render($this);
  }
}