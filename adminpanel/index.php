    <?php

    require "session.php";
    require "../koneksi.php";

    $querykategori =mysqli_query($con, "SELECT * FROM kategori");
    $jumlakategori = mysqli_num_rows($querykategori);

    $queryproduk =mysqli_query($con, "SELECT * FROM produk");
    $jumlaproduk = mysqli_num_rows($queryproduk);
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="../bootsrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    </head>

    <style>
        .kotak{
            border:solid;
        }
        .summary-kategori{
            background-color: #1e81b0 ;
            border-radius: 10px;
            box-shadow: 5px 10px;
        }
        .summary-produk{
            background-color: #F84D0F ;
            border-radius: 10px;
            box-shadow: 5px 10px;
        }
        .no-decoration{
            text-decoration: none;
        }
    </style>

    <body>
        <?php require "navbar.php" ?>
        <div class="container mt-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">     
        <i class=" fas  fa-home"></i> Home
        </li>
        </ol>
    </nav>
            <h2>Halo <?php echo $_SESSION['username']; ?></h2>
            <div class="container mt-5">
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="summary-kategori p-4">
                        <div class="row"> 
                            <div class="col-6">
                            <i class="fas fa-align-justify fa-7x"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori </h3>
                                <p class="fs-4"><?php echo $jumlakategori ?> kategori </p>
                                <p><a href="kategori.php" class="text-white no-decoration">Detail</a></p>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-4">
                        <div class="row"> 
                            <div class="col-6">
                            <i class="fas fa-box fa-7x"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk </h3>
                                <p class="fs-4"><?php echo $jumlaproduk ?> produk</p>
                                <p><a href="produk.php" class="text-white no-decoration">Detail</a></p>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <script src="../bootsrap/js/bootstrap.bundle.min.js"></script>
        <script src="../fontawesome/js/all.min.js"></script>
    </body>

    </html>