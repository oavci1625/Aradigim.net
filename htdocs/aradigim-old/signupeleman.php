<?php
    require "navigator.php"
?>

<body class="bg-dark">
    <main>
        <div class="container-fluid">
            <h3 class="text-center text-light p-3">Kaydol</h3>
            <div class = "row" style="padding:10px;">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <?php
                        if ( isset( $_GET['error'])) {
                            if( $_GET['error'] == "emptyfields"){
                                echo '<div class="alert alert-danger" role="alert"> Gerekli alanları doldurun!</div>';
                            }

                            else if( $_GET['error'] == "invalidmailuid"){
                                echo '<div class="alert alert-danger" role="alert"> Geçersiz e-mail ve kullanıcı adı. Lütfen tekrar deneyin!</div>';
                            }

                            else if( $_GET['error'] == "invaliduid"){
                                echo '<div class="alert alert-danger" role="alert"> Geçersiz kullanıcı adı. Lütfen tekrar deneyin!</div>';
                            }

                            else if( $_GET['error'] == "invalidmail"){
                                echo '<div class="alert alert-danger" role="alert"> Geçersiz e-mail. Lütfen tekrar deneyin!</div>';
                            }

                            else if( $_GET['error'] == "passwordcheck"){
                                echo '<div class="alert alert-danger" role="alert"> Bu şifreler eşleşmiyor. Lütfen tekrar deneyin!</div>';
                            }

                            else if( $_GET['error'] == "usertaken"){
                                echo '<div class="alert alert-danger" role="alert"> Bu kullanıcı adı başkası tarafından kullanılıyor. Lütfen başka bir kullancı adı deneyin!</div>';
                            }

                            else if( $_GET['error'] == "invalidfile"){
                                echo '<div class="alert alert-danger" role="alert"> Profil fotoğrafı .jpg, .jpeg, veya .png formatında olmalıdır!</div>';
                            }

                            else if( $_GET['error'] == "uploaderror"){
                                echo '<div class="alert alert-danger" role="alert"> Profil fotoğrafı yüklenirken bir hata oluştu. Lütfen tekrar deneyin!</div>';
                            }

                            else if( $_GET['error'] == "invalidimagesize"){
                                echo '<div class="alert alert-danger" role="alert"> Profil fotoğrafı 1MB veya altında olmalıdır!</div>';
                            }
                            
                        }
                        else if(  isset( $_GET['signup'])){
                            if( $_GET['signup'] == "success"){
                                echo '<div class="alert alert-success" role="alert"> Kaydolma işlemi başarılı!</div>';
                            }
                        }

                    ?>

                    <form action="includes/signupeleman.inc.php" method="post" enctype="multipart/form-data" class = "bg-secondary"style="padding:40px; border-radius:25px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="form-group row">
                            <label class="col-sm-7 col-form-label font-weight-bold" style="font-size:22px;">Profil resmi: (&lt1MB) (.jpg, .jpeg, .png)</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="file" name="file">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:22px;">İsim: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" placeholder="İsim">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:22px;">Soyisim: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="surname" placeholder="Soyisim">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:22px;">Kullanıcı adı: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="uid" placeholder="Kullanıcı adı">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:22px;">E-mail: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="mail" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:22px;">Şifre: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" name="pwd" placeholder="Şifre">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold" style="font-size:22px;">Şifre tekrarı: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" name="pwd-repeat" placeholder="Şifre tekrarı">
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <button type="submit" name = "signup-eleman-submit" class="btn btn-lg btn-success">Kaydol</button>
                        </div>
                        <p> Bir hesabın var mı? <a href="login.php" class="btn btn-sm btn-primary">Giriş Yap</a> </p>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </main>
</body>

<?php
    require "footer.php"
?>   