<?php

/* this class is to call api from solved.ac in order to get rating information of a problem */

class Bridge {
  public static function setRating(&$problem) {
    try {
      $api_url=(include('config.php'))['solved_api_url'].$problem->problem_number;

      $json=file_get_contents($api_url);
      $result=json_decode($json);

      if(property_exists($result, "level")) {
        $level=$result->level;

        $problem->rating_type=Rating::getRating($level);
        $problem->rating_level=Rating::getLevel($level);
      } else {
        $problem->rating_type="";
        $problem->rating_level="";
      }
    } catch (Exception $e) {
      $problem->rating_type="";
      $problem->rating_level="";
    }
  }
}

?>
