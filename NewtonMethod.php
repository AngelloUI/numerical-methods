<?php

namespace newton;

use gauss\GaussMethod;

include 'GaussMethod.php';

final class NewtonMethod
{
    private const EPS = 1E-9;
    private float $x1;
    private float $x2;
    private array $SLAE;

    public function __construct($x1, $x2)
    {
        $this->x1 = $x1;
        $this->x2 = $x2;
    }

    private function derF1X1($x1): float
    {
        return 2 * $x1;
    }

    private function derF1X2($x2): float
    {
        return (-1) * 2 * $x2;
    }

    private function derF2X1($x2): float
    {
        return $x2 * $x2 * $x2;
    }

    private function derF2X2($x1, $x2): float
    {
        return 3 * $x2 * $x2 * $x1 - 1;
    }

    private function f1($x1, $x2): float
    {
        return $x1 * $x1 - $x2 * $x2 - 1;
    }

    private function f2($x1, $x2): float
    {
        return $x1 * $x2 * $x2 * $x2 - $x2 - 3;
    }

    public function doNewton(): void
    {
        print "k x1 deltaX1  x2 deltaX2\n";
        print 0 . " " . $this->x1 . " " . 0 . " " . $this->x2 . " " . 0 . "\n";
        $i = 0;
        do {
            $this->SLAE[0][0] = $this->derF1X1($this->x1);
            $this->SLAE[0][1] = $this->derF1X2($this->x2);
            $this->SLAE[0][2] = $this->f1($this->x1, $this->x2);
            $this->SLAE[1][0] = $this->derF2X1($this->x2);
            $this->SLAE[1][1] = $this->derF2X2($this->x1, $this->x2);
            $this->SLAE[1][2] = $this->f2($this->x1, $this->x2);
            $g = new GaussMethod(2, $this->SLAE);
            $g->doGaussMethod();
            $delta = $g->getSolutionVector();
            $dx1 = $delta[0];
            $dx2 = $delta[1];
            $this->x1 -= $dx1;
            $this->x2 -= $dx2;
            ++$i;
            print $i . " " . $this->x1 . " " . $dx1 . " " . $this->x2 . " " . $dx2 . "\n";
        } while ((abs($dx1) > NewtonMethod::EPS || abs($dx2) > NewtonMethod::EPS) and ($i < 10));
    }
}

$n = new NewtonMethod(1, 1);
$n->doNewton();
