<?php
class Rating {
  public static function getRating($rating) {
    // unrated 0
    if($rating==0) return "Unrated";

    // bronze 1~5, silver 6~10, gold 11~15, platinum 16~20, diamond 21~25, ruby 26~30
    if($rating>=1 && $rating<=5) return "bronze";
    if($rating>=6 && $rating<=10) return "silver";
    if($rating>=11 && $rating<=15) return "gold";
    if($rating>=16 && $rating<=20) return "platinum";
    if($rating>=21 && $rating<=25) return "diamond";
    if($rating>=26 && $rating<=30) return "ruby";
  }

  public static function getLevel($rating) {
    $remainder=$rating%5;

    if($remainder==0) return "1";
    if($remainder==4) return "2";
    if($remainder==3) return "3";
    if($remainder==2) return "4";
    if($remainder==1) return "5";

    return $result;
  }
}

?>
