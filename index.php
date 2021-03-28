<?php



/**
 * Carrega classe motor do aplicativo.
 * Cria uma instância.
 * Executa o aplicativo.
 */
require_once 'c/Core.php';
$core = new Core;
$core->start();
















/**
 * TESTES
 */
// class Foo
// {
//     public function print($string)
//     {
//         echo '<br>Foo: ' . $string . PHP_EOL;
//     }

//     public function printPHP()
//     {
//         echo '<br>Foo: ' . PHP_EOL;
//     }
// }

// class Bar extends Foo
// {
//     public function print($string)
//     {
//         echo '<br>Bar: ' . $string . PHP_EOL;
//     }
// }


// $foo = new Foo();
// //$bar = new Bar();

// $myClass = "bar";
// $refl = new ReflectionClass($myClass);
// $bar = $refl->newInstanceArgs();

// echo '<hr> foo:';
// $foo->print('baz'); // Output: 'Foo: baz'
// $foo->printPHP();       // Output: 'PHP is great'

// echo '<hr> BAR:';
// $bar->print('baz'); // Output: 'Bar: baz'
// $bar->printPHP();       // Output: 'PHP is great'