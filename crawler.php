<?php

require_once "vendor/autoload.php";
require_once "class/problem.php";
require_once "class/rating.php";

use Goutte\Client;

class Crawler {
  protected $client;
  protected $config;
  protected $problems;

  public function __construct() {
    $this->config=include('config.php');
    $this->client=new Client();
    $this->problems=array();
  }

  public function login() {
    try {
      //$crawler = $client->click($crawler->selectLink('Sign in')->link());
      $crawler = $this->client->request('GET', $this->config['login_page']);
      $form = $crawler->selectButton('로그인')->form();
      $crawler = $this->client->submit($form, array('login_user_id' => $this->config['username'], 'login_password' => $this->config['password']));
    } catch(Exception $e) {
      echo "<p>Something went wrong while trying to login...</p>";
      echo "<h4 style='margin-bottom:0px'>Error Message:</h4>";
      echo $e;
    }
  }

  // fetch all solved problem
  public function fetch() {
    try {
      $username=$this->config['username'];
      $user_page=$this->config['user_page'].$username;

      $crawler=$this->client->request('GET', $user_page);
      $crawler->filter('.panel-default')->first()->filter('.panel-body>.problem_number')->each(function ($node) {
        array_push($this->problems,new Problem($node->text()));
      });

      return $this->problems;
    } catch(Exception $e) {
      echo "<h5>Failed to fetch problems from BaekJoon</h5>";
      echo "$e";
      return $this->problems;
    }
  }

  public function findRating(&$problem) {
    try {
      $search_page=$this->config['search_page'].$problem->problem_number;
      $problem_page=$this->config['problem_page'].$problem->problem_number;

      $crawler=$this->client->request('GET', $search_page);
      $node=$crawler->filter('a[href="'.$problem_page.'"]>.level_badge')->first();

      // as of 2020 Apr.09, the file format of the badge is: //static.solved.ac/tier_small/1.svg
      $src=$node->attr('src');

      // extract number from svg file
      preg_match('/\/(\d+)\.svg/', $src, $matches);
      $problem->rating_type=Rating::getRating($matches[1]);
      $problem->rating_level=Rating::getLevel($matches[1]);
    } catch(Exception $e) {
      echo "<h5>Failed to find rating from Solved.ac</h5>";
      echo "$e";
    }
  }
}

?>
