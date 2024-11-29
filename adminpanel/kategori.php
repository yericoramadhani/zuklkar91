    <?php

        require "session.php";
        require "../koneksi.php";
    $querykategori = mysqli_query($con , "SELECT * FROM kategori");
    $jumlahkategori = mysqli_num_rows($querykategori);
        
        ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Kategori</title>
                <link rel="stylesheet" href="../bootsrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
        </head>
        <style>
            .no-decoration {text-decoration: none;}
        </style>
        <body>
        <?php require "navbar.php" ?>
        <div class="container mt-5">
         <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
         <a href="../adminpanel" class="no-decoration text-mute"> 
            <li class="breadcrumb-item">
                <i class=" fas  fa-home"> </i> Home
            </a> 
              </li> 
              <li class="breadcrumb-item"><i class=" fas  fa-align-justify"></i> Kategori
              </li>
        </ol>
    </nav>

    <div class="my-5 col-12 col-md-6">
        <form action="" method="post">
            <div>
                <label for="kategori">kategori</label>
                <input type="text" id="kategori" name="kategori" placeholder="input nama kategori" class="form-control">
            </div>

            <div class="mt-3">
                <button class="btn btn-primary" type="submit" name="simpan_kategori">Simpan</button>
            </div>
        </form>  
        <?php
        if(isset($_POST['simpan_kategori'])){
            $kategori = htmlspecialchars($_POST['kategori']);
            $queryExist =mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
            $jumladatakategoribaru = mysqli_num_rows($queryExist);

            if($jumladatakategoribaru >0){
                    ?>
            <div class="alert alert-primary mt-3" role="alert">
            Data sudah ada
            </div>
              <?php
            }else{
                $querysimpan =  mysqli_query($con,"INSERT INTO kategori(nama)VALUES('$kategori')");
                if($querysimpan){
                    ?>
                    <div class="alert alert-secondary" role="alert">
                    Data sudah Masuk
                    </div>
                    <meta http-equiv="refresh" content="2; url=kategori.php">

                    <?php
                }else{
                    echo mysqli_error($con);
                }
            }
        }
        ?>
    </div>

    <div class="mt-3">
        <div class="table-responsive mt-5">
        <table class="table">
            <thead class="table-light">
            <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                    if ($jumlahkategori==0){
                        ?>
                    <tr>
                        <td colspan=3 class="text-center">Tidak Ada Data</td>
                    </tr>

                        <?php
                    
                    }
                    else{
                        $jumlah=1;
                       while ($data =mysqli_fetch_array ($querykategori)){
                        ?>
                        <tr>
                            <td><?php echo $jumlah ?></td>
                            <td><?php echo $data ['nama']; ?></td>
                            <td>
                                <a href="kategori-detail.php?sandha=<?php echo $data['id'] ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                            </td>
                        </tr>
                        <?php
                        $jumlah++;
                       }
                    }
                  
                
                ?>
            </tbody>
            </table>
        </div>

    </div>
        </div>

            <script src="../bootsrap/js/bootstrap.bundle.min.js"></script>
            <script src="../fontawesome/js/all.min.js"></script>
        </body>
        </html>