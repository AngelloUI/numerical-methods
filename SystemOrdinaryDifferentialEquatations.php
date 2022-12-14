<?php
const EPS = 0.001;
function f1($u1, $u2, $t): float
{
    if ($t < EPS) {
        return -$u1 * $u2 + 1;
    }
    return -$u1 * $u2 + sin($t) / $t;
}

function f2($u2, $t): float
{
    return -$u2 * $u2 + (3.5 * $t) / (1 + $t * $t);
}

function obviousEulerMethod(): void
{
    $amountOfIterations = 0;
    $tauMax = 0.01;
    $tk = 0;
    $yk = array(0.0, -0.412);
    echo "t                     u1                     u2                   iteration\n";
    do {
        $tmp = array(f1($yk[0], $yk[1], $tk), f2($yk[1], $tk));
        $tau = max(EPS / (abs($tmp[0]) + EPS / $tauMax), EPS / (abs($tmp[1]) + EPS / $tauMax));
        $yk[0] += $tau * $tmp[0];
        $yk[1] += $tau * $tmp[1];
        $tk += $tau;
        echo "$tk    $yk[0]    $yk[1]     $amountOfIterations\n";
        ++$amountOfIterations;
    } while ($tk < 1);
}

obviousEulerMethod();