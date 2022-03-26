<?php
    require "navigator.php";
    require "includes/profile.inc.php";
?>

<body class="bg-dark">
    <main>
        <div class="container-fluid">
            <h3 class="text-center text-light p-3">Profil - <?php echo $jobName;?></h3>
            <div class = "row" style="padding:10px;">
                <div class="col-md-3"></div>
                <div class="col-md-6 bg-secondary" style="padding:40px; border-radius:25px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class = "row align-items-center justify-content-center">
                <img style="border-radius:5%;" src="../<?php echo $image;?>" height = 200rem >
                </div>
                <div class = "row justify-content-center">
                    <p class="lead font-weight-bold"><?php echo ''. $name. ' ' .$surname; ?></p>
                </div>
                <?php
                    for( $i = 0; $i < count($values); $i++){
                        echo '<div class = "row">';
                        echo '<p class="font-weight-bold" style="font-size:24px;">'. $profileQuestions[$i] .'&nbsp</p>';
                        echo '<p style="font-size:20px;">' . $values[$i] . '</p>';
                        echo '</div>';
                        echo '<hr style="border-color:white;">';
                    }
                ?>
                </div>
                <div class="col-md-3"></div>

            </div>
        </div>
    </main>
</body>
</html>


<?php
    require "footer.php"
?>