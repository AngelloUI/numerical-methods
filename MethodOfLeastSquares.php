<?php

namespace leastSquares;

use gauss\GaussMethod;

include 'GaussMethod.php';

class MethodOfLeastSquares
{
    private array $x;
    private array $y;
    private array $coefficientMatrix;
    private array $coefficients;
    private float $sumOfSquaredDeviations;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
    public function getSumOfSquaredDeviations(): float{
        return $this->sumOfSquaredDeviations;
    }
    public function doLeastSquares(): void
    {
        $this->initCoefficientMatrix();
        $g = new GaussMethod(2, $this->coefficientMatrix);
        $g->doGaussMethod();
        $this->coefficients = $g->getSolutionVector();
        $this->sumOfSquaredDeviations = $this->sigmaYSubFxOfSecondPower();
    }

    private function f($x): float
    {
        return $this->coefficients[0] * $x + $this->coefficients[1];
    }

    private function sigmaYSubFxOfSecondPower(): float
    {
        $sigma = 0;
        for ($i = 0; $i < count($this->y); ++$i) {
            $sigma += (($this->y[$i] - $this->f($this->x[$i]))**2);
        }
        return $sigma;
    }

    private function initCoefficientMatrix(): void
    {
        $this->coefficientMatrix[0][0] = $this->sigmaOfXSecondPowerValues();
        $this->coefficientMatrix[0][1] = $this->sigmaOfXValues();
        $this->coefficientMatrix[0][2] = $this->sigmaOfXYValues();
        $this->coefficientMatrix[1][0] = $this->sigmaOfXValues();
        $this->coefficientMatrix[1][1] = count($this->x);
        $this->coefficientMatrix[1][2] = $this->sigmaOfYValues();
    }

    private function sigmaOfXValues(): float
    {
        $sigma = 0;
        for ($i = 0; $i < count($this->x); ++$i) {
            $sigma += $this->x[$i];
        }
        return $sigma;
    }

    private function sigmaOfXSecondPowerValues(): float
    {
        $sigma = 0;
        for ($i = 0; $i < count($this->x); ++$i) {
            $sigma += ($this->x[$i] ** 2);
        }
        return $sigma;
    }

    private function sigmaOfYValues(): float
    {
        $sigma = 0;
        for ($i = 0; $i < count($this->y); ++$i) {
            $sigma += $this->y[$i];
        }
        return $sigma;
    }

    private function sigmaOfXYValues(): float
    {
        $sigma = 0;
        for ($i = 0; $i < count($this->x); ++$i) {
            $sigma += ($this->x[$i] * $this->y[$i]);
        }
        return $sigma;
    }
}

$x = [19.1, 25, 30.1, 36, 40, 45.1, 50];
$y = [76.3, 77.8, 79.75, 80.8, 82.35, 83.9, 85];
$mnk = new MethodOfLeastSquares($x, $y);
$mnk->doLeastSquares();
print $mnk->getSumOfSquaredDeviations();