<?php

function main($entree) {
  $nbCol = 0;
  $parametres = explode("\n", $entree);
  $count = (int) $parametres[0];
  $columns = explode(" ", trim($parametres[1]));

  if (verify($count, $columns)) {
    return -1;
  }


  $max_height = 0;

  for ($i = 0; $i < $count; $i++) {
    if ($max_height > $columns[$i])
      $nbCol++;
    else
      $max_height = $columns[$i];
  }

  return $nbCol;
}


function verify($count, $columns) {
  if ($count != count($columns)) {
    return true;
  }

  for ($i = 0; $i < $count; $i++) {
    if ($columns[$i] < 0)
      return true;
  }

  return false;
}

class Run {

    var $nb_test;
    var $nb_success;

    public function __construct() {
        $this->nb_test = 0;
        $this->nb_success = 0;
    }

    function test($string, $expected, $desc = null) {
        $res = main($string);
        $memory_used = memory_get_usage() / 1024;
        $time_start = microtime(true);
        $duration = number_format(microtime(true) - $time_start, 4);

        $this->nb_test++;

        if ($res != $expected)
            echo "test failed: $desc, expected: $expected and got $res \n";

        else {
            echo "test $this->nb_test OK, duration: $duration sec, memory: $memory_used ko\n";
            $this->nb_success++;
        }
    }

    function test_file($file_path, $expected, $desc = null) {
        $string = file_get_contents($file_path);
        $this->test($string, $expected, $desc);
    }


    public function test_all() {


        //return errors
        $this->test("0\n", -1, "Empty");
        $this->test("10\n 1", -1, "Bad input size");
        $this->test("1\n 1 0 1 12 1", -1, "Bad input size");
        $this->test("-4\n 54793 73 43 48654 2", -1, "Negative count");
        $this->test("4\n 62354 123 1658 -5436", -1, "Bad input negative height mountain");

        //return ok
        $this->test("2\n 0 1", 0, "ok little test");
        $this->test("2\n 1 0", 1, "ok little test");
        $this->test("10\n 30 27 17 42 29 12 14 41 42 42", 6, "small land");
        $this->test("20\n 11 82 71 90 34 60 88 16 10 53 22 21 10 44 21 11 45 53 39 36", 18, "medium land");
        $this->test_file("testing/test_large", 99985, "max size");



        echo "test nb: $this->nb_test\n";
        echo "test ok: $this->nb_success\n";
    }
}

$test = new Run();
$test->test_all();
?>
