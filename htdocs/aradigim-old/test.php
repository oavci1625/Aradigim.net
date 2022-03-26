<script>

    var i = 0;

    
    console.log( " ----Part 1 Iteration Statements----");


    console.log( " ----While loop----  ");
    while ( i < 3) {
        console.log(i);
        i++;
    }

    console.log( " ----Do-while loop----  ");
    do {
        console.log(i);
        i++;
    }while ( i < 6);

    console.log( " ----For loop----  ");
    for ( ; i < 9; i++) {
        console.log(i);
    }

    console.log( " ----Foreach loop----  ");
    const ints = [0, 1, 2];
    for (let i in ints) {
        console.log(i);
    }

    console.log( " ----Part 2 Data Structure Examples---- ");

    const arrayExample = [0, 1, 2];
    var mapExample = arrayExample.map(Math.sqrt)

    for (let i in arrayExample) {
        console.log(i);
    }
    console.log( "end of array example ");

    for (let i in mapExample) {
        console.log(i);
    }
    console.log( "end of map example ");

</script>