<?php

/*
CS315 - HW1
Onuralp AVCI
21902364
*/

// Variables
$trueBool = true;
$falseBool = false;

/*
Part 1 - Boolean Operands
The list of operands in php:
    1 - or , ||
    2 - and , &&
    3 - xor
    4 - !

Part 2 - Data types for operands
Booleans are used as operands of those operations.
A bool can be either true or false.
Sample outputs are shown in the examples below
*/

printf( " ---- Part 2 Or ----\n");
printf( "True or True is: %d\n", trueBool || trueBool );
printf( "True or False is: %d\n", trueBool || falseBool );
printf( "False or False is: %d\n", falseBool || falseBool );
printf( "\n");

printf( " ---- Part 2 And ----\n");
printf( "True and True is: %d\n", trueBool && trueBool );
printf( "True and False is: %d\n", trueBool && falseBool );
printf( "False and False is: %d\n", falseBool && falseBool );
printf( "\n");

printf( " ---- Part 2 Not ----\n");
printf( "Not True is: %d\n", !trueBool );
printf( "Not False is: %d\n", !falseBool );
printf( "\n");


?>