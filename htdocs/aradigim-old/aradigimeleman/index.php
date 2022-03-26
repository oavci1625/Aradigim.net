<?php
    require "navigator.php"
?>

<div class="jumbotron ">
  <div class="row text-center justify-content-center align-items-center">
    <div class="col-sm-4">
      <h1>Aradığım Eleman</h1>      
      <p>Aradığın eleman işte burada</p>
      <form class="form-inline justify-content-center" action="search.php?page=1" method="post">
        <select name="job" class="form-control">
          <option value="cs">Bilgisayar Mühendisi</option>
          <option value="cou">Kurye</option>
          <option value="cs">Aşçı</option>
          <option value="cou">Avukat</option>
          <option value="cs">Diş Hekimi</option>
          <option value="cou">E-sporcu</option>
          <option value="cs">Tenis Hocası</option>
          <option value="cou">Makine Mühendisi</option>
        </select>
        <input class="btn btn-primary" type="submit" name="search-submit" value="Ara">
      </form>
    </div>
    <div class="col-sm-3">
      <img src="img/pcmobileicon.png" class="img-fluid" style="height:auto" alt="Image">
    </div>
  </div>
</div>

<div class="container-fluid bg-3 text-center my-5">    
  <h3>En Çok Aranan Meslekler</h3><br>
  <div class="row justify-content-center mt-4">
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Bilgisayar Mühendisliği</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Diş Hekimi</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Aşçı</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Avukat</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Kurye</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">E-sporcu</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Tenis Hocası</button>
    <button type="button" class="btn btn-lg btn-outline-dark mx-1">Makine Mühendisi</button>
  </div>
</div><br>
  
<div class="container-fluid bg-3 text-center">    
  <h3>Ayın Elemanları</h3><br>
  <div class="row justify-content-center">
    <div class="col-sm-2">
      <p>Elber Kurt</p>
      <img src="img/employesOfTheMonth/elber.png" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-2"> 
      <p>Onuralp Avcı</p>
      <img src="img/employesOfTheMonth/oavci.png" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-2"> 
      <p>Elon Musk</p>
      <img src="img/employesOfTheMonth/elon.png" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-2">
      <p>Acun Ilıcalı</p>
      <img src="img/employesOfTheMonth/acun.png" class="img-responsive" style="width:100%" alt="Image">
    </div>
  </div>
</div><br>



<?php
    require "footer.php"
?>