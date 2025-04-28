<?php

namespace App\Services;

class UploadService
{
    public function upload($file): ?string
    {;
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileTmpName = $file['tmp_name'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION))


        $allowed = ['jpg', 'jpeg', "png", 'gif'];

        if (!in_array($fileExtension, $allowed)) {
            echo "File type not supported: " . $fileExtension;
            return null;
        }

        if ($fileError !== 0) {
            echo "Error uploading file.";
            return null;
        }

        if ($fileSize > 1000000) {
            echo "File too large.";
            return null;
        }

        $fileNameNew = uniqid('', true) . "." . $fileExtension;
        // echo "<pre>";
        // var_dump($fileNameNew);
        // die();
        $fileDestination = 'uploads/' . $fileNameNew; // Relative path in 'public/uploads/'
        // echo "<pre>";
        // var_dump($fileDestination);
        // die();
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            return $fileDestination; // Return relative path
        } else {
            echo "Failed to upload file.";
            return null;
        }
    }
    // public function upload($file)
    // {
    //     $fileName = $file['name'];
    //     // echo "<pre>";
    //     // var_dump($fileName);
    //     // die();
    //     $fileSize = $file['size'];
    //     $fileError = $file['error'];
    //     $fileExtension = explode('.', $fileName);
    //     // echo "<pre>";
    //     // var_dump($fileExtension);
    //     // die();
    //     $fileActualExtension = strtolower(end($fileExtension));
    //     // echo "<pre>";
    //     // var_dump($fileActualExtension);
    //     // die();
    //     $allowed = array('jpg', 'jpeg', 'png', 'gif');
    //     if (in_array($fileActualExtension, $allowed)) {
    //         if ($fileError === 0) {
    //             if ($fileSize < 1000000) {
    //                 $fileNameNew = uniqid('', true) . "." . $fileActualExtension;
    //                 $fileDestination = '../uploads/' . $fileNameNew;
    //                 move_uploaded_file($file['tmp_name'], $fileDestination);
    //                 // var_dump(move_uploaded_file($file['tmp_name'], $fileDestination));
    //                 // die();
    //                 return $fileNameNew;
    //             } else {
    //                 echo "file too large";
    //             }
    //         } else {
    //             echo "error uploading file";
    //         }
    //     } else {
    //         echo "file not supported: " . $fileActualExtension;
    //     }
    // }
}
