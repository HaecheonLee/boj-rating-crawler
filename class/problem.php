<?php
class Problem {
    protected $problem_number;
    protected $rating_type;
    protected $rating_level;

    public function __construct($number) {
      $this->problem_number=$number;
      $this->problem_rating="";
      $this->rating_level="";
    }

    public function __get($property) {
      if(property_exists($this,$property)) return $this->$property;
    }

    public function __set($property, $value) {
      if(property_exists($this,$property)) $this->$property=$value;
    }
}

?>
