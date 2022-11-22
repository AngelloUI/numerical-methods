<?php

namespace gauss;

class GaussMethod
{
    private int $size;
    private int $rowsAmount;
    private int $columnsAmount;
    private array $originalMatrix;
    private array $matrix;
    private array $x;

    public function __construct($size, $matrix)
    {
        $this->size = $size;
        $this->columnsAmount = $size + 1;
        $this->rowsAmount = $size;
        for ($rowIndex = 0; $rowIndex < $this->rowsAmount; ++$rowIndex) {
            $this->x[$rowIndex] = 1;
            for ($columnIndex = 0; $columnIndex < $this->columnsAmount; ++$columnIndex) {
                $this->matrix[$rowIndex][$columnIndex] = $matrix[$rowIndex][$columnIndex];
                $this->originalMatrix[$rowIndex][$columnIndex] = $matrix[$rowIndex][$columnIndex];
            }
        }
    }

    private function maxCurrentColumn($columnIndex): int
    {
        $max = $this->matrix[$columnIndex][$columnIndex];
        $maxRowIndex = $columnIndex;
        for ($i = $columnIndex; $i < $this->rowsAmount; ++$i) {
            if ($max < $this->matrix[$i][$columnIndex]) {
                $max = $this->matrix[$i][$columnIndex];
                $maxRowIndex = $i;
            }
        }
        return $maxRowIndex;
    }

    private function swapRows($columnIndex, $maxRowIndex): void
    {
        for ($i = $columnIndex; $i < $this->columnsAmount; ++$i) {
            $temp = $this->matrix[$columnIndex][$i];
            $this->matrix[$columnIndex][$i] = $this->matrix[$maxRowIndex][$i];
            $this->matrix[$maxRowIndex][$i] = $temp;
        }
    }

    private function dividingOnColumnElement($columnIndex): void
    {
        for ($i = $columnIndex; $i < $this->rowsAmount; ++$i) {
            $delimiter = $this->matrix[$i][$columnIndex];
            for ($j = $columnIndex; $j < $this->columnsAmount; ++$j) {
                $this->matrix[$i][$j] /= $delimiter;
            }
        }
    }

    private function difCurrentRowAndMaxRow($columnIndex): void
    {
        for ($i = $columnIndex + 1; $i < $this->rowsAmount; ++$i) {
            for ($j = $columnIndex; $j < $this->columnsAmount; ++$j) {
                $this->matrix[$i][$j] -= $this->matrix[$columnIndex][$j];
            }
        }
    }

    private function reverseStep(): void
    {
        for ($i = $this->rowsAmount - 1; $i >= 0; --$i){
            $this->x[$i] = $this->matrix[$i][$this->columnsAmount-1];
            for ($j = 0; $j < $this->columnsAmount-1; ++$j){
                if ($i == $j){
                    continue;
                }
                $this->x[$i] -= $this->x[$j]*$this->matrix[$i][$j];
            }
            $this->x[$i] /= $this->matrix[$i][$i];
        }
    }
    public function doGaussMethod(): void{
        for ($i = 0; $i < $this->rowsAmount-1; ++$i){
            $maxRowIndex = $this->maxCurrentColumn($i);
            $this->swapRows($i,$maxRowIndex);
            $this->dividingOnColumnElement($i);
            $this->difCurrentRowAndMaxRow($i);
        }
        $this->reverseStep();
    }
    public function printX(): void{
        for ($i = 0; $i < $this->rowsAmount; ++$i){
            print $this->x[$i] . " ";
        }
        print "\n";
    }
    public function printMatrices(): void
    {
        for ($rowIndex = 0; $rowIndex < $this->rowsAmount; ++$rowIndex) {
            for ($columnIndex = 0; $columnIndex < $this->columnsAmount; ++$columnIndex) {
                print $this->matrix[$rowIndex][$columnIndex] . " ";
            }
            print "\n";
        }
        print "\n";
        for ($rowIndex = 0; $rowIndex < $this->rowsAmount; ++$rowIndex) {
            for ($columnIndex = 0; $columnIndex < $this->columnsAmount; ++$columnIndex) {
                print $this->originalMatrix[$rowIndex][$columnIndex] . " ";
            }
            print "\n";
        }
    }
}

$n = readline();
$matrix = [[2.6,-4.5,-2,19.07],[3,3,4.3,3.21],[-6,3.5,3,-18.25]];
//$matrix = array();
//for ($i = 0; $i < $n; ++$i) {
  //  for ($j = 0; $j < $n + 1; ++$j) {
    //    $matrix[$i][$j] = readline();
    //}
//}
$g = new GaussMethod($n, $matrix);
$g->doGaussMethod();
$g->printX();
$g->printMatrices();