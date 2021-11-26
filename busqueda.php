<?php    
    include('./php/conexion.php');
    if(!isset($_GET['texto'])){
        header("Location ./index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tienda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
    <?php include("./layouts/header.php"); 
        
    ?> 

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <div class="row">
              <div class="col-md-12 mb-5">
                <div class="float-md-left mb-4"><h2 class="text-black h5">Buscando resultados para <?php echo $_GET['texto'];?></h2></div>
                <div class="d-flex">
                  <div class="dropdown mr-1 ml-md-auto">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      ultimo
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                      <a class="dropdown-item" href="#">Comida</a>
                      <a class="dropdown-item" href="#">Bebida</a>
                    </div>
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Referencia</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                      <a class="dropdown-item" href="#">Pertenecia</a>
                      <a class="dropdown-item" href="#">Nombre, A a la Z</a>
                      <a class="dropdown-item" href="#">Nombre, Z a la A</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Precio, bajo a alto</a>
                      <a class="dropdown-item" href="#">Precio, alto a bajo</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-5">
              <?php
                include('./php/conexion.php');
                $limite = 9; //productos por pagina
                $totalQuery = $conexion->query('select count(*) from productos')or die($conexion->error);
                $totalProductos = mysqli_fetch_row($totalQuery);
                $totalBotones = round($totalProductos[0]/$limite); 
                if(isset($_GET['limite'])){
                  $resultado = $conexion ->query("select * from productos where inventario>0 order by id DESC limit ".$_GET['limite'].",".$limite) or die($conexion -> error);
                }else{
                  $resultado = $conexion ->query("select * from productos where inventario>0 order by id DESC limit ".$limite ) or die($conexion -> error);
                }
                $resultado = $conexion ->query("select * from productos where 
                    nombre like '%".$_GET['texto']."%' 
                    order by id DESC limit 9") or die($conexion -> error);
                    if(mysqli_num_rows($resultado)>0){

                    
                while($fila = mysqli_fetch_array($resultado)){                
              ?>
                <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                  <div class="block-4 text-center border">
                    <figure class="block-4-image">
                      <a href="shop-single.php?id=<?php echo $fila['id'];?>">
                        <img src="images/<?php echo $fila['imagen'];?>" alt="<?php echo $fila['nombre'];?>" class="img-fluid"></a>
                    </figure>
                    <div class="block-4-text p-4">
                      <h3><a href="shop-single.php?id=<?php echo $fila['id'];?>"><?php echo $fila['nombre'];?></a></h3>
                      <p class="mb-0"><?php echo $fila['descripcion'];?></p>
                      <p class="text-primary font-weight-bold">S/<?php echo $fila['precio'];?></p>
                    </div>
                  </div>
                </div>
              <?php } }else{
                  echo '<h2>sin resultados</h2>';
              } ?>


            </div>
            <div class="row" data-aos="fade-up">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                  <?php
                      if(isset($_GET['limite'])){
                        if($_GET['limite']>0){
                          echo '<li><a href="index.php?limite='.($_GET['limite']-9).'">&lt;</a></li>';
                        }
                      }
                      for($k=0;$k<$totalBotones;$k++){
                        echo '<li><a href="index.php?limite='.($k*9).'">'.($k+1).'</a></li>';
                      }
                      if(isset($_GET['limite'])){
                        if($_GET['limite']+9<$totalBotones*9){
                          echo '<li><a href="index.php?limite='.($_GET['limite']+9).'">&gt;</a></li>';
                        }
                      }else{
                        echo '<li><a href="index.php?limite=9">&gt;</a></li>';
                      }
                    ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 order-1 mb-5 mb-md-0">
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categoria</h3>
              <ul class="list-unstyled mb-0">
                <li class="mb-1"><a href="#" class="d-flex"><span>Comida</span> <span class="text-black ml-auto">(2,220)</span></a></li>
                <li class="mb-1"><a href="#" class="d-flex"><span>Bebidas</span> <span class="text-black ml-auto">(2,550)</span></a></li>
              </ul>
            </div>

            <div class="border p-4 rounded mb-4">
              <!-- <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">FILTRAR POR PRECIO</h3>
                <div id="slider-range" class="border-primary"></div>
                <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />
              </div> -->

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>variedad</h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/comida.png" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">VARIEDAD</span>
                        <h3>BRASA</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/PARILLAV.jpeg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">VARIEDAD</span>
                        <h3>PARRILLAS</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/chicha.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">VARIEDAD</span>
                        <h3>BEBIDAS</h3>
                      </div>
                    </a>
                  </div>
                </div>
              
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <?php include("./layouts/footer.php"); ?> 

    
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>