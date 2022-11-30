<?php

class DefiniteIntegral
{
    private const EPS1 = 1E-4;
    private const EPS2 = 1E-5;
    private float $a = 1.2;
    private float $b = 2.471;
    private float $aCubature = -1;
    private float $cCubature = -1;
    private float $bCubature = 1;
    private float $dCubature = 1;

    public function __construct()
    {
    }

    private function f1(float $x): float
    {
        return (1 + 2 * ($x ** 3)) ** (0.5);
    }

    private function f2(float $x, float $y): float
    {
        return 4 - $x ** 2 - $y ** 2;
    }

    private function trapezoidMethod($n): float
    {
        $h = ($this->b - $this->a) / $n;
        $integralSum = $this->f1($this->a) + $this->f1($this->b);
        for ($i = 1; $i <= $n - 1; ++$i) {
            $integralSum += 2 * $this->f1($this->a + $i * $h);
        }
        $integralSum *= $h / 2;
        return $integralSum;
    }

    private function simpsonMethod($n): float
    {
        $h = ($this->b - $this->a) / $n;
        $integralSum = $this->f1($this->a) + $this->f1($this->b);
        for ($i = 1; $i <= $n - 1; ++$i) {
            $k = 2 + 2 * ($i % 2);
            $integralSum += $k * $this->f1($this->a + $i * $h);
        }
        $integralSum *= $h / 3;
        return $integralSum;
    }

    private function simpsonCubatureMethod(): float
    {
        $m = 2;
        $n = 2 * $m;
        $hx = ($this->bCubature - $this->aCubature) / (2 * $n);
        $hy = ($this->dCubature - $this->cCubature) / (2 * $m);
        $integralSum = 0;
	    $xi = [];
	    $xi[0] = $this->aCubature;
	    for ($i = 1; $i <= 2 * $n; ++$i){
            $xi[$i] = $xi[$i - 1] + $hx;
        }
        $yi = [];
        $yi[0] = $this->cCubature;
        for ($i = 1; $i <= 2 * $m; ++$i){
            $yi[$i] = $yi[$i - 1] + $hy;
        }

	    for ($i = 0; $i < $n; ++$i) {
            for ($j = 0; $j < $m; ++$j) {
                $integralSum += $this->f2($xi[2 * $i], $yi[2 * $j]);
			    $integralSum += 4 * $this->f2($xi[2 * $i + 1], $yi[2 * $j]);
			    $integralSum += $this->f2($xi[2 * $i + 2], $yi[2 * $j]);
			    $integralSum += 4 * $this->f2($xi[2 * $i], $yi[2 * $j + 1]);
			    $integralSum += 16 * $this->f2($xi[2 * $i + 1], $yi[2 * $j + 1]);
			    $integralSum += 4 * $this->f2($xi[2 * $i + 2], $yi[2 * $j + 1]);
			    $integralSum += $this->f2($xi[2 * $i], $yi[2 * $j + 2]);
			    $integralSum += 4 * $this->f2($xi[2 * $i + 1], $yi[2 * $j + 2]);
			    $integralSum += $this->f2($xi[2 * $i + 2], $yi[2 * $j + 2]);
		    }
	    }
	    $integralSum *= ($hx * $hy / 9);
        return $integralSum;
    }

    public function solveTask(): void
    {
        print "trapezoid and sympson:\n";
        $k = 1;
        $i = 0;
        do {
            ++$i;
            $difference = $this->trapezoidMethod($k * $i) - $this->trapezoidMethod($k * ($i + 1));
        } while ($difference > self::EPS2 * 3);
        print "k = " . ($k * ($i + 1)) . " trapezoid method:  " . $this->trapezoidMethod($k * ($i + 1)) . "\n";
        $i = 0;
        do {
            ++$i;
            $difference = $this->simpsonMethod($k * $i) - $this->simpsonMethod($k * ($i + 1));
        } while ($difference > self::EPS1 * 15);
        print "k = " . ($k * ($i + 1)) . " Simpson method:  " . $this->simpsonMethod($k * ($i + 1)) . "\n";
        print "Simpson cybature method:\n";
        print $this->simpsonCubatureMethod();
    }
}

$d = new DefiniteIntegral();
$d->solveTask();