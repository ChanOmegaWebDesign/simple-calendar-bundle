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
    'first_day_of_week' => self::SUNDAY,
    'year'              => null,
    'month'             => null,
    'month_format'      => 'F',
    'day_format'        => 'D',
    'date_format'       => 'j',
  ];
  const SUPPORTED_FORMATS = [
    'month_format' => ['F', 'm', 'M', 'n'],
    'day_format'   => ['D', 'l', 'N', 'w'],
    'date_format'  => ['d', 'j', 'z', 'jS'],
  ];

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
      ->setMonthFormat($options['month_format'])
      ->setDayFormat($options['day_format'])
      ->setDateFormat($options['day_format'])
    ;

  }

  /**
   * @return mixed
   */
  public function getFirstDayOfWeek()
  {
    return $this->first_day_of_week;
  }

  /**
   * @param mixed $day
   *
   * @return Calendar
   */
  public function setFirstDayOfWeek($day)
  {
    $day = strtolower($day);
    if (!in_array($day, array_keys(self::FIRST_DAY_OF_WEEK))) {
      throw new UnexpectedValueException(UnexpectedValueException::message(array_keys(self::FIRST_DAY_OF_WEEK), $day));
    }
    $this->first_day_of_week = self::FIRST_DAY_OF_WEEK[$day];

    return $this;
  }

  /**
   * @return mixed
   */
  public function getYear()
  {
    return $this->year;
  }

  /**
   * @param mixed $year
   *
   * @return Calendar
   */
  public function setYear($year)
  {
    $this->year = $year;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getMonth()
  {
    return $this->month;
  }

  /**
   * @param mixed $month
   *
   * @return Calendar
   */
  public function setMonth($month)
  {
    $this->month = $month;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getMonthFormat()
  {
    return $this->month_format;
  }

  /**
   * @param string $month_format
   *
   * @return $this
   */
  public function setMonthFormat(string $month_format)
  {
    if (!in_array($month_format, self::SUPPORTED_FORMATS['month_format'])) {
      throw new UnexpectedValueException(UnexpectedValueException::message(self::SUPPORTED_FORMATS['month_format'], $month_format));
    }
    $this->month_format = $month_format;

    return $this;
  }


  /**
   * @param string $day_format
   *
   * @return $this
   */
  public function setDayFormat(string $day_format)
  {
    if (!in_array($day_format, self::SUPPORTED_FORMATS['day_format'])) {
      throw new UnexpectedValueException(UnexpectedValueException::message(self::SUPPORTED_FORMATS['day_format'], $day_format));
    }
    $this->day_format = $day_format;

    return $this;
  }


  /**
   * @param string $date_format
   *
   * @return $this
   */
  public function setDateFormat(string $date_format)
  {
    if (!in_array($date_format, self::SUPPORTED_FORMATS['date_format'])) {
      throw new UnexpectedValueException(UnexpectedValueException::message(self::SUPPORTED_FORMATS['date_format'], $date_format));
    }
    $this->date_format = $date_format;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getDayFormat()
  {
    return $this->day_format;
  }

  /**
   * @return mixed
   */
  public function getDateFormat()
  {
    return $this->date_format;
  }


}