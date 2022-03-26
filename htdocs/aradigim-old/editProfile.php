<?php
    require "navigator.php";
    require "includes/editProfile.inc.php";
?>
<link rel="stylesheet" href="css/editProfileStyle.css">

<body style="background-image: url(img/art.png); background-repeat: repeat space; background-position: center; height:900px;">
    <main>
        <div class="container-fluid justify-content-center" >
            <h3 class="text-center text-light p-3">Kişisel Profillerin</h3>
            <div class = "row" style="padding:10px;">
                <div class="col-md-3"></div>
                <div class="col-md-6 d-flex justify-content-center" style="background-color:#1877ab; padding:40px; border-radius:25px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <div class="card-deck p-2">
                        <?php
                        for ($i=0; $i < $jobNo; $i++) {
                        ?>
                        <div class="card border-info text-center" style="padding:10px;">
                            <img src="<?php echo $image;?>" class="card-img-top" height = 200rem style = "object-fit:contain;">
                            <div class="card-body" style = "object-fit:contain">
                                <h6 class="text-light text-center rounded p-1 bg-dark" >Başlık</h6>
                                <p class="text-dark">
                                    Meslek : <?php echo $jobArray[$i];?> <br>
                                </p>
                                <?php
                                if($userType == "eleman"){
                                    echo '<a href="aradigimeleman/profile.php?uid='.$userUid.'&job='.$jobArray[$i].'" class="btn btn-primary btn-block">Profile Git</a>';
                                    echo '<a href="aradigimeleman/addProfile.php?job='.$jobArray[$i].'" class="btn btn-primary btn-block">Düzenle</a>';
                                    echo '<button type="button" class="btn btn-danger btn-block" onclick="deleteProfile(\'' . $jobArray[$i] . '\')" >Sil</button>';
                                    echo '<form method="post" action="editProfile.php" id="'.$i.'">
                                            <label class="switch">
                                            <input type="hidden" name="jobActivation" value="'.$jobArray[$i].'">';
                                            
                                    if($activeArray[$i] == "true")
                                        echo'<input type="checkbox" name="active" onchange="document.getElementById(\''.$i.'\').submit()" checked>';
                                    else
                                        echo'<input type="checkbox" name="active" onchange="document.getElementById(\''.$i.'\').submit()">';

                                    echo'   <span class="slider round"></span>
                                            </label>
                                        </form>
                                        <p>Profil Aktifliği</p>';
                                }
                                ?>
                                
                                <script>
                                    function deleteProfile(job) {
                                        var answer = window.confirm("Profili silmek istediğinize emin misiniz?");
                                        if (answer) {
                                            window.location.href = "editProfile.php?delete=" + job;
                                        }
                                        else {
                                            //do nothing
                                        }
                                    }
                                </script>
                                
                            </div>
                        </div>

                        <?php
                        }
                        if($jobNo < 3) { 
                        ?>
                        <div class="card border-info" style="padding:10px;" >
                            <div class="card-body" style = "object-fit:contain">
                                <form action="aradigimeleman/addProfile.php" method="post" style="height:100%;">
                                    <select class="form-control" name="job">
                                        <option value="">Meslek Seçiniz</option>
                                        <option value="cs">Bilgisayar Mühendisi</option>
                                        <option value="cou">Kurye</option>
                                    </select>
                                    <button class="btn btn-success" style="height:80%; width:100%;" type="submit" name="add-profile-submit">Ekle</button>
                                </form>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </main>
</body>

<?php
    require "footer.php"
?>