<?php

    require_once('../../config.php');
    require_once('class.git.php');

    $git = new Git();

    //////////////////////////////////////////////////////////////////
    // Verify Session or Key
    //////////////////////////////////////////////////////////////////

    checkSession();

    if($_GET['action']=='status'){
      
        $filePath = $_GET['path'];
        if(!file_exists(WORKSPACE . DIRECTORY_SEPARATOR. $_SESSION['project'] . 
                DIRECTORY_SEPARATOR . $filePath))
        {
          $filePath = '';
        }
        else
        {
          $filePath = trim($filePath, '/'.DIRECTORY_SEPARATOR);
        }

        $files = $git->Status($filePath);
        echo formatJSEND("success",$files);
    }
    
    if($_GET['action']=='push'){
      
        $comment = $_POST['comment'];
        $files   = $_POST['files'];

        $out = $git->Push($comment, $files);
        echo formatJSEND("success", $out);
    }