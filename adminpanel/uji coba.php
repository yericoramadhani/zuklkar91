<?php

    require "session.php";
    require "../koneksi.php";
    $id = $_GET['sandha'];
    $query=mysqli_query($con, "SELECT a . * , b . nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data=mysqli_fetch_array($query);
    $querykategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <meta name="viewport" content="width=device-wiial-scale=1.0">
    <title>produk_detail</title>
    <link rel="stylesheet" href="../bootsrap/css/bootstrap.min.css">
</head>
<style>
      form div{margin-bottom: 10px;}
</style>
<body>
<?php require"navbar.php"?>
<div class="container mt-5">
</div>
    <div class="col-12 col-md-6 mb-5">
    <form action=""method="post" enctype="multipart/form-data"> 

    <div>
        <label for="nama">Nama</label>
    <input type="tedth, initxt" name="nama" id="nama" class="form-control" value="<?php echo $data['nama']?>" autocomplete="off"required>
    </div>
         

             <div>
             <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="<?php echo $data['kategori_id'] ?>"><?php echo $data['nama_kategori'] ?></option>
            <?php
            while($datakategori=mysqli_fetch_array($querykategori)){
                ?>
                <option value="<?php echo $datakategori['id']; ?>"> <?php echo $datakategori['nama']; ?></option>
                <?php
            }
            ?>
            </select>
        </div>
        <div>
            <label for="harga">Harga</label>
            <input type="number" class="form-control" value="<?php echo $data['harga']?>" name="harga" required>
        </div>
        <div>
            <label for="currentFoto">Foto Produk sekarang</label>
         <img src="../image/<?php echo htmlspecialchars($data['foto']);?>" alt="" >
        </div>
       <div>
        <label for="foto">foto</label>
        <input type="file"name="foto" id="foto" class="form-control">
        </div>
        <div>
        <label for="detail">Detail</label>
       <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
        <?php echo $data ['detail']; ?>
       </textarea>
        </div>
        <div>
            <label for="ketersediaan_stok">ketersedian stok</label>
            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
            <option value="<?php echo $data ['ketersediaan_stok'] ?>"><?php echo $data ['ketersediaan_stok'] ?></option>
            <?php
            if ($data['ketersediaan_stok']=='tersedia'){
                ?>
                <option value="habis">habis</option>
                <?php
            }else{
                ?>
                <option value="tersedia">tersedia</option>
                <?php
            }
            ?>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" name="simpan">update</button>
            <button type="submit" class="btn btn-danger" name="hapus">delete</button>
        </div>
    </form>
    
            
            <?php
            if(isset($_POST['simpan'])){
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
                }else{
                    $queryupdate = mysqli_query($con,"UPDATE produk SET kategori_id='$kategori', nama='$nama',harga='$harga', detail='$detail',ketersediaan_stok='$ketersediaan_stok' WHERE id=$id");

                    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
                        ?>
                        <div class="alert alert-secondary" role="alert">
                   File Wajib png jpg dan gif
                    </div>
                        <?php
                }else{
                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $random_name . $new_name);
                    $queryupdate=mysqli_query($con,"UPDATE produk SET foto='$new_name' WHERE id='$id'");
                    if ($queryupdate){

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

            }
        }
        if(isset($_POST ['hapus'])){
            $queryhapus = mysqli_query($con,"DELETE FROM produk WHERE id='$id'");
            if ($queryhapus){
                ?>
                 <div class="alert alert-primary" role="alert">
                        Data sudah Di hapus
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php">
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