<?php
    require "navigator.php"
?>

<link rel="stylesheet" href="headerStyle.css">
<body>
    <main>
        <div class="container-fluid" style="height: 70vh;">
            <div class="row align-items-center page-header">
                <div class="col-3"></div>
                <div class="col-6">
                    <h1 class="display-2 text-light font-weight-bold" style="font-size:5vw; margin-top:70px; border-radius:30px; background-color:  #1877ab">Aradığım Eleman</h1>
                    <h3 class="display-4 text-light" style="font-size:2vw; background-color: #1877ab; border-radius:30px;">Aradığın Çalışan - Stajyer Burada</h3>
                    <hr class="border-light">
                    <form class="form-inline justify-content-center" action="search.php?page=1" method="post">
                        <select name="job" class="form-control">
                            <option value="cs">Bilgisayar Mühendisi</option>
                            <option value="cou">Kurye</option>
                        </select>
                        <input class="btn btn-primary" type="submit" name="search-submit" value="Ara">
                    </form>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </main>
</body>


<?php
    require "footer.php"
?>   