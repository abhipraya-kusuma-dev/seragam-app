<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class QueryBuilderMacroProvider extends ServiceProvider
{
  protected static $methods = ['insertTs', 'insertGetIdTs', 'updateTs'];

  protected static function timestampValues($funcName, array $colNames)
  {
    Builder::macro($funcName, function (array $values, $withBy = false) use ($colNames) {
      $userId = $withBy ? auth()->user()->id : null;
      $now = Carbon::now();

      if (array_key_exists(0, $values) && is_array($values[0])) {
        foreach ($values as $value) {
          $value[$colNames[1]] = $now;

          if ($withBy) {
            $value[$colNames[2]] = $userId;
          }
        }
      } else {
        $valus[$colNames[1]] = $now;

        if ($withBy) {
          $values[$colNames[2]] = $userId;
        }
      }

      return Builder::{$colNames[0]}($values);
    });
  }

  protected static function insertTs()
  {
    return self::timestampValues(__FUNCTION__, ['insert', 'created_at', 'created_by']);
  }

  protected static function insertGetIdTs()
  {
    return self::timestampValues(__FUNCTION__, ['insertGetId', 'created_at', 'created_by']);
  }

  protected static function updateTs()
  {
    return self::timestampValues(__FUNCTION__, ['update', 'updated_at', 'created_by']);
  }

  /**
   * Register services.
   */
  public function register(): void
  {
    foreach (self::$methods as $method) {
      self::{$method}();
    }
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}
