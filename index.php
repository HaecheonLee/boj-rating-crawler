<?php

require_once "class\problem.php";
require_once "crawler.php";

$crawler=new Crawler();
$solved_problems=$crawler->fetch();

// check from solved
$ratings=array("unrated"=>array("1"=>0, "2"=>0, "3"=>0, "4"=>0, "5"=>0),
               "bronze"=>array("1"=>0, "2"=>0, "3"=>0, "4"=>0, "5"=>0),
               "silver"=>array("1"=>0, "2"=>0, "3"=>0, "4"=>0, "5"=>0),
               "gold"=>array("1"=>0, "2"=>0, "3"=>0, "4"=>0, "5"=>0),
               "platinum"=>array("1"=>0, "2"=>0, "3"=>0, "4"=>0, "5"=>0),
               "ruby"=>array("1"=>0, "2"=>0, "3"=>0, "4"=>0, "5"=>0));

foreach($solved_problems as $each) {
  $crawler->findRating($each);

  $type=$each->rating_type;
  $level=$each->rating_level;

  $ratings[$type][$level]++;
}

$ratings[$type][$level]++;
foreach($ratings as $type => $array) {
  $total=0;
  if($type=="unrated") {
    echo "Unrated: ".$array['1']."<br/><br/>";
  } else {
    foreach($array as $level=>$count) {
      echo "$type $level: $count</br>";
      $total+=$count;
    }
    echo "Total: $total<br/><br/>";
  }
}

echo "Total: ".count($solved_problems);
?>
