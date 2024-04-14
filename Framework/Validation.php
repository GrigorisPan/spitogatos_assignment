<?php

namespace Framework;

class Validation
{

  /**
   * Validate a string 
   * 
   * @param string $value
   * @param int $min
   * @param int $max
   * @return bool
   * 
   */

  public static function string($value, $min = 1, $max = INF)
  {
    if (is_string($value)) {
      $value = trim($value);
      $lengh = strlen($value);
      return $lengh >= $min && $lengh <= $max;
    }

    return false;
  }

  /**
   * Validate email address
   *
   * @param string $value
   * @return mixed
   */
  public static function email($value)
  {
    $value = trim($value);
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Match a value against another
   *
   * @param string $value1
   * @param string $value2
   * @return bool
   */
  public static function match($value1, $value2)
  {
    $value1 = trim($value1);
    $value2 = trim($value2);

    return $value1 === $value2;
  }

  /**
   * Validate price
   * 
   * @param  string $price
   * @param  string $min
   * @param  string $max
   * @return bool
   * 
   */
  public static function price($value, $min, $max,)
  {
    $value = trim($value);
    return filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max)));
  }

  /**
   * Validate location
   * 
   * @param  string $value
   * @return bool
   * 
   */
  public static function location($value)
  {
    $allowedFields = ['Αθήνα', 'Θεσσαλονίκη', 'Πάτρα', 'Ηράκλειο'];

    $value = strval($value);
    return in_array($value, $allowedFields);
  }

  /**
   * Validate availability
   * 
   * @param  string $value
   * @return bool
   * 
   */
  public static function availability($value)
  {
    $allowedFields = ['ενοικίαση', 'πώληση'];

    $value = strval($value);
    return in_array($value, $allowedFields);
  }

  /**
   * Validate area
   * 
   * @param  string $value
   * @param  string $min
   * @param  string $max
   * @return bool
   * 
   */
  public static function area($value, $min, $max,)
  {
    $value = trim($value);
    return filter_var($value, FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max)));
  }
}
