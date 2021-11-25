<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FibonacciController extends Controller
{
    public function getFibonacci($n = 5)
    {
        $last=0;
        $new=1;

        for ($i=0; $i<$n-1; $i++)
        {
        
        $output = $new + $last;

        $last = $new;
        $new = $output;
        }
        return $output;
    }
    public function sumFibonacci($n1, $n2)
    {
        $f1 = FibonacciController::getFibonacci($n1);
        $f2 = FibonacciController::getFibonacci($n2); 
        return $f1+$f2;
    }
}
