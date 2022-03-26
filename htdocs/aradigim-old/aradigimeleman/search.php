<?php
require "navigator.php";
require "includes/search.inc.php";
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="searchStyle.css">
        <script src="searchScript.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eleman Arama</title>
    </head>
    <body class="bg-dark">
        <main>
            <div class="container-fluid">
                <h3 class="text-center text-light p-2 bg-secondary">Eleman Arama<?php if( isset($jobName))echo ' - '.$jobName;?></h3>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <div> 
                            <h5 class="text-light">Eleman Filtrele</h5>
                            <hr style="border-color:white;">
                            <form action="search.php" method="post">
                            <?php
                            //FILTERS START
                            $spStartIndex = 9;
                            for ($i=0; $i < sizeof($formInputs); $i++) {
                                //SELECT FILTERS START
                                if( $formInputs[$i]['type'] == "select"){
                            ?>
                            <div class="dropdown p-2" id="test" onClick="showOrHide(this.id)">
                                <button class="btn btn-secondary dropdown-toggle  btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $formInputs[$i]['profileQuestion']; ?>
                                </button>
                                <div class="dropdown-menu" id="hurray" aria-labelledby="dropdownMenuButton" style = "width:100%;">
                                    <label class="form-group row dropdown-item" style="margin-left:0px;">
                                        <div class="form-check">
                                            <select class="form-control" name="<?php echo $formInputs[$i]['dbName'] ?>">
                                                <?php
                                                $index = $spStartIndex;
                                                while( isset($formInputs[$i][ $keys[$index]]) ){
                                                    echo '<option value ="'. $formInputs[$i][ $keys[$index]].'">'. $formInputs[$i][ $keys[$index + 1]] .'</option>';
                                                    $index += 2;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <?php } //select filters end?>

                            <?php
                                //CHECKBOX FILTERS STARTS
                                if( $formInputs[$i]['type'] == "checkbox"){
                            ?>
                            <div class="dropdown p-2">
                                <button class="btn btn-secondary dropdown-toggle btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $formInputs[$i]['profileQuestion']; ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style = "width:100%">
                                    <?php
                                    $index = $spStartIndex;
                                    //START OF CHECKBOX ELEMENTS
                                    while( isset($formInputs[$i][ $keys[$index]]) ){
                                    ?>
                                    <label class="form-group row dropdown-item" style="margin-left:0px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="<?php echo $formInputs[$i]['dbName'] ?>[]" value ="<?php echo $formInputs[$i][ $keys[$index]] ?>">
                                            <?php echo $formInputs[$i][ $keys[$index]] ?>
                                        </div>
                                    </label>
                                    <?php
                                    $index += 1;
                                    }//end of checkbox elements
                                    ?>
                                </div>
                            </div>
                            <?php } //checkbox filters end?>

                            <?php
                                //RADIO FILTER STARTS
                                if( $formInputs[$i]['type'] == "radio"){
                            ?>
                            <div class="dropdown p-2" >
                                <button class="btn btn-secondary dropdown-toggle  btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $formInputs[$i]['profileQuestion']; ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style = "width:100%;">
                                    <?php
                                        //RADIO ELEMENTS START
                                        $index = $spStartIndex;
                                        while( isset($formInputs[$i][ $keys[$index]]) ){
                                    ?>
                                    <label class="form-group row dropdown-item" style="margin-left:0px;">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="<?php echo $formInputs[$i]['dbName'] ?>" value="<?php echo $formInputs[$i][ $keys[$index + 1]] ?>" >
                                            <?php echo $formInputs[$i][ $keys[$index]] ?>
                                        </div>
                                    </label>
                                    <?php
                                        //radio elements ends
                                            $index += 3;
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php } //radio filter ends ?>


                            <?php
                                //NUMBER FILTER STARTS
                                if( $formInputs[$i]['type'] == "number"){
                                $index = $spStartIndex;
                            ?>
                            <div class="dropdown p-2" >
                                <button class="btn btn-secondary dropdown-toggle  btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $formInputs[$i]['profileQuestion']; ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style = "width:100%">
                                    <label class="form-group row dropdown-item" style="margin-left:0px;">
                                        <div class="form-check">
                                            <input class="form-control" type="number" name="<?php echo $formInputs[$i]['dbName'].'-min' ?>" min="<?php echo $formInputs[$i][ $keys[$index]] ?>" max="<?php echo $formInputs[$i][ $keys[$index + 1]] ?>">
                                            Minimum
                                        </div>
                                    </label>
                                    <label class="form-group row dropdown-item" style="margin-left:0px;">
                                        <div class="form-check">
                                            <input class="form-control" type="number" name="<?php echo $formInputs[$i]['dbName'].'-max' ?>" min="<?php echo $formInputs[$i][ $keys[$index]] ?>" max="<?php echo $formInputs[$i][ $keys[$index + 1]] ?>">
                                            Maksimum
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <?php } //number filter ends ?>
                            
                            <?php } //filters end?>

                            <input type="hidden" name="job" value="<?php echo $jobCode;?>"/>
                            <div class="row justify-content-md-center">
                                <button type="submit" name = "filtered-search-submit" class="btn btn-lg btn-success">Filtrele</button>
                            </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-center text-light" id="textChange">Tüm Sonuçlar</h5>
                        <hr style="border-color:white;">
                        <div class="text-center">
                            <img src="img/loader.gif" id="loader" width="400" style="display:none;">
                        </div>
                        <div class="row" id="result">
                            <div class="mb2" style="width:100%;">
                                <?php 
                                $profileNumberPerRow = 3;
                                $count = 1; // Represents the profile
                                while($count <= $profileCount){
                                    if( $count % $profileNumberPerRow == 1) echo '<div class="card-deck p-2" >'; //new card deck opened
                                ?>
                                    <div class="card border-info" style="padding:10px;">
                                        <img src="../<?php echo $profiles[$count - 1]['imageUsers'];?>" class="card-img-top" height = 200rem style = "object-fit:contain;">
                                        <div class="card-body" style = "object-fit:contain">
                                            <h6 class="text-light text-center rounded p-1 bg-dark" ><?php echo $profiles[$count - 1]['nameUsers']; echo ' '.$profiles[$count - 1]['surnameUsers'];?></h6>
                                            <p class="text-dark">
                                                Meslek : <?php echo $jobName;?> <br>
                                                E-mail : <?php echo $profiles[$count - 1]['emailUsers'];?> <br>
                                                Kullanıcı Adı : <?php echo $profiles[$count - 1]['uidUsers'];?> <br>
                                            </p>
                                            <a href="profile.php?uid=<?php echo $profiles[$count - 1]['uidUsers'];?>&job=<?php echo $jobCode;?>" class="btn btn-primary btn-block">Profile Git</a>
                                        </div>
                                    </div>
                                <?php
                                    if( $count % $profileNumberPerRow == 0) echo '</div>'; //card deck closed
                                    $count++; //moveing to next profile
                                }//end of profiles, end of while loop
                                if( $profileCount % $profileNumberPerRow != 0){ //filling last empty spots of cards
                                    for($i = 0; $i < ($profileNumberPerRow - $profileCount % $profileNumberPerRow); $i++){
                                ?>
                                    <div class="card border-0" style="background-color: rgba(245, 245, 245, 0); padding:10px;">
                                    </div>
                                <?php
                                    }
                                    echo '</div>';
                                }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </main>
    </body>
</html>

<?php
    require "footer.php"
?>   