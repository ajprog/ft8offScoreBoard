<?php
session_start();

$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // check if file has one of the following extensions
    $allowedfileExtensions = array('adi');

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      if( include("utils.php") )
      {
      	$adif = file_get_contents($fileTmpPath);
      	$parsed_adif = ADIFParser($adif);
      	//echo "<pre>".print_r ($parsed_adif,true)."</pre>";
      	$conn = DBOpen();
      	ADIFInsert($parsed_adif, $conn);
        //echo "ADIF INSERTED";
      	$message =  Count($parsed_adif)." Records Uploaded.";       //"<pre>" . print_r($parsed_adif, true) . "</pre>";
	  }
      else 
      {
        $message = 'There was some error loading the utilities, please contact the web admin.';
      }
      
    }
    else
    {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}

$html = file_get_contents("upload.html");
$html = str_replace('{$message}', $message, $html);

echo $html;
