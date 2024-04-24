<?php
require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
   case 'GET':
         if (!empty($_GET["nim"])) {
            $nim = $_GET["nim"];
            get_nilai_by_nim($nim);
         } else {
            get_all_nilai();
         }
         break;
//    case 'POST':
//          $data = json_decode(file_get_contents('php://input'), true);
//          if(!empty($_GET["nim"]&&$_GET["kode_mk"])){
//             $nim = $_GET["nim"];
//             $kode_mk = $_GET["kode_mk"];
//             update_nilai($nim, $kode_mk);
//          }else{
//             insert_nilai($data);
//          }
//          break; 
   case 'DELETE':
         $nim = $_GET["nim"];
         $kode_mk = $_GET["kode_mk"];
         delete_nilai($nim, $kode_mk);
         break;
    case 'POST':
            if (!empty($_GET["nim"]) && !empty($_GET["kode_mk"])) 
            {
               $nim = $_GET["nim"];
               $kode_mk = $_GET["kode_mk"];
               update_nilai($nim, $kode_mk);
            }
            else
            {
               insert_nilai();
            }     
            break; 
   default:
      // Invalid Request Method
      header("HTTP/1.0 405 Method Not Allowed");
      break;
}

function get_all_nilai()
{
    global $mysqli;
    $query = "SELECT * FROM data_mahasiswa";
    $data = array();
    $result = $mysqli->query($query);
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Get All Nilai Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_nilai_by_nim($nim)
{
    global $mysqli;
      $query="SELECT * FROM data_mahasiswa";
      if($nim != "")
      {
         $query .= " WHERE nim = '$nim'";
      }
    $data = array();
    $result = $mysqli->query($query);
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Get Nilai by NIM Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_nilai()
   {
       global $mysqli;
   
       if (!empty($_POST["kode_mk"]) && !empty($_POST["nim"])) {
           $data = $_POST;
       } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
           parse_str(file_get_contents("php://input"), $data);
       } else {
           $data = array();
       }
   
       $arrcheckpost = array('nim' => '', 'kode_mk' => '', 'nilai' => '');
       $hitung = count(array_intersect_key($data, $arrcheckpost));
       if ($hitung == count($arrcheckpost)) {
           $nim = $data["nim"];
           $kode_mk = $data["kode_mk"];
           $nilai = $data["nilai"];
           
           $result = mysqli_query($mysqli, "INSERT INTO perkuliahan (nim, kode_mk, nilai) VALUES ('$nim', '$kode_mk', '$nilai')");
           if ($result) {
               $response = array(
                   'status' => 1,
                   'message' =>'Grade inserted successfully.'
               );
           } else {
               $response = array(
                   'status' => 0,
                   'message' =>'Failed to insert grade.'
               );
           }
       } else {
           $response = array(
               'status' => 0,
               'message' =>'Missing parameters for inserting nilai.'
           );
       }
       header('Content-Type: application/json');
       echo json_encode($response);
   }

function delete_nilai($nim, $kode_mk)
{
    global $mysqli;
    $query = "DELETE FROM perkuliahan WHERE nim='$nim' AND kode_mk='$kode_mk'";
    if ($mysqli->query($query) === TRUE) {
        $response = array(
            'status' => 1,
            'message' => 'Delete Nilai Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Delete Nilai Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_nilai($nim, $kode_mk) {
    global $mysqli;

    if(!empty($_POST["nilai"])) {
        $data = $_POST;
    } else {
        $data = json_decode(file_get_contents('php://input'), true);
    }

    if(!empty($data['nilai'])) {
        $nilai = intval($data['nilai']);
        $result = mysqli_query($mysqli, "UPDATE perkuliahan SET
            nilai = $nilai
            WHERE nim = '$nim' AND kode_mk = '$kode_mk'");

            if($result) {
                $response = array(
                    'status' => 1,
                    'message' => 'Nilai mahsiswa updated successfully.'
                );
            } else {
                $response = array(
                    'status' => 0,
                    'message' => 'Failed to update nilai mahasiswa.'
                );
            }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Invalid data.',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>