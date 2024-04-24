<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Data</h2>
                    </div>
                    <p>Please fill this form and submit to update student record in the database.</p>
                    <form action="updateNilaiDo.php" method="post">
                        <div class="form-group">
                            <label>Nim</label>
                            <input type="text" name="nim" class="form-control" value="<?php echo $_GET['nim']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Kode MK</label>
                            <input type="text" name="kode_mk" class="form-control" value="<?php echo $_GET['kode_mk']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="text" name="nilai" class="form-control" value="">
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
