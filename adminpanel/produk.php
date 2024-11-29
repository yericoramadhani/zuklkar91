        <?php

                require "session.php";
                require "../koneksi.php";  
                $queryproduk = mysqli_query($con , "SELECT a . * , b . nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
                $jumlahproduk = mysqli_num_rows($queryproduk);    
               
                $querykategori = mysqli_query($con, "SELECT * FROM kategori ");

                function generateRandomString($length = 10) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[random_int(0, $charactersLength - 1)];
                    }
                
                    return $randomString;
                }
               
                ?>



        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>produk</title>
            <link rel="stylesheet" href="../bootsrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
        </head>
        <style>
            .no-decoration {text-decoration: none;}
            form div{margin-bottom: 10px;}
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
              <li class="breadcrumb-item"><i class=" fas  fa-align-justify"></i> Produk
              </li>
        </ol>
    </nav>

    <div class="my-5 col-12 col-md-6">
        <form action=""method="post" enctype="multipart/form-data">
        <div>
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
        </div>

        <div>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="">Pilih satu</option>
            <?php
            while($data=mysqli_fetch_array($querykategori)){
                ?>
                <option value="<?php echo $data['id']; ?>"> <?php echo $data['nama']; ?></option>
                <?php
            }
            ?>
            </select>
        </div>
        <div>
            <label for="harga">Harga</label>
            <input type="number" class="form-control" name="harga" required>
        </div>
        <div>
             <label for="formFile" class="form-label">upload</label>
             <input class="form-control" type="file" id="foto" name="foto">
        </div>
        <div>
        <label for="detail">Detail</label>
       <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div>
            <label for="ketersediaan_stok">ketersedian stok</label>
            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
            <option value="tersedia">tersedia</option>
            <option value="habis">habis</option>
            </select>
            

        </div>
        <div>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
        </div>
        </form>
        <?php
        if(isset ($_POST['simpan'])){
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
               

                $target_dir = "../rahasia/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"] ["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name  . "." . $imageFileType;


                if($nama==''|| $kategori=='' || $harga== ''){
                    ?>
                    <div class="alert alert-secondary" role="alert">
                    Data Wajib isi
                    </div>
                    <?php
                }
                else{
                    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                        ?>
                        <div class="alert alert-secondary" role="alert">
                   File Wajib png jpg dan gif
                    </div>
                        <?php
                    }else{
                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $random_name . $new_name);
                    }
                }
                //insert
                $querytambah =mysqli_query($con,"INSERT INTO produk(kategori_id, nama, harga, foto, detail, ketersediaan_stok)VALUES('$kategori','$nama ','$harga','$new_name','$detail', '$ketersediaan_stok')");



                if ($querytambah){

                    ?>
                    <div class="alert alert-primary" role="alert">
                        produk berasil disimpan
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php">
                    <?php
                }else{
                    echo mysqli_error($con);
                }
        }
        ?>
    </div>


    <div class="my-5 col-12 col-md-6"></div>

    <div class="mt-3 mb-5">
        <div class="table-responsive mt-5">
        <table class="table">
            <thead class="table-light">
            <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>ketersedian stok</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  if ($jumlahproduk==0){
                ?>
                <tr>
                        <td colspan=5 class="text-center">Tidak Ada Data</td>
                    </tr>
                    <?php
            }else{
                $jumlah=1;
                while ($data =mysqli_fetch_array ($queryproduk)){
                 ?>
                 <tr>
                     <td><?php echo $jumlah ?></td>
                     <td><?php echo $data ['nama']; ?></td>
                     <td><?php echo $data ['nama_kategori']; ?></td>
                     <td><?php echo $data ['harga']; ?></td>
                     <td><?php echo $data ['ketersediaan_stok']; ?></td>
                     <td>
                                <a href="produk-detail.php?sandha=<?php echo $data['id'] ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
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