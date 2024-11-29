    <?php

    require "session.php";
    require "../koneksi.php";
    $id = $_GET['sandha'];
    $query=mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
    $data=mysqli_fetch_array($query);
   
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Kategori</title>
        <link rel="stylesheet" href="../bootsrap/css/bootstrap.min.css">
    </head>
    <body>
        <?php require"navbar.php"?>
          <div class="container mt-5">

        </div>
            <div class="col-12 col-md-6">
                <div>
          <form action=""method="post">
         <label for="kategori">kategori</label>
            <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']?>">
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary" name="edition">Edit</button>
                <button type="submit" class="btn btn-danger" name="deletion">Delete</button>
            </div>
        </form>
        <?php 
        if(isset($_POST['edition'])){
            $kategori = htmlspecialchars($_POST['kategori']);
            if($data['nama']==$kategori){
                ?>
                    <meta http-equiv="refresh" content="0; url=kategori.php">

                <?php
            }else{
                $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                $jumlahData = mysqli_num_rows($query);
                
                if($jumlahData > 0){
                    ?>
                     <div class="alert alert-primary mt-3" role="alert">
                     Data sudah ada
                       </div>
                      <?php
                } else{
                    $querysimpan =  mysqli_query($con,"UPDATE kategori SET nama ='$kategori' WHERE id='$id'");
                    if($querysimpan){
                        ?>
                        <div class="alert alert-secondary" role="alert">
                        Data sudah Di Update
                        </div>
                        <meta http-equiv="refresh" content="2; url=kategori.php">
    
                        <?php
                    }else{
                        echo mysqli_error($con);
                    }
                }
            }
        }
        if(isset($_POST['deletion'])){

                $queryCheck=mysqli_query($con,"SELECT * FROM produk WHERE kategori_id='$id'");
                $dataCount = mysqli_num_rows($queryCheck);

                if($dataCount>0){
                    ?>
         <div class="alert alert-warning" role="alert">
                        tidak bisa di hapus karena sudah di gunakan di produk 
                        </div>
                    <?php
                    die();
                }

            $queryDelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
            if ($queryDelete){
                ?>
                 <div class="alert alert-primary" role="alert">
                        Data sudah Di hapus
                        </div>
                        <meta http-equiv="refresh" content="2; url=kategori.php">
                <?php
            }else{
                echo mysqli_error($con);
            }
            }
        ?>
        </div>
        <script src="../bootsrap/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>