<?php

class Git{

  function __construct()
  {
    
  }
  
  public function &Status($filePath)
  {
    $output = array();
    $files = array();
    if(file_exists(WORKSPACE . DIRECTORY_SEPARATOR. $_SESSION['project']))
    {
      chdir(WORKSPACE . DIRECTORY_SEPARATOR. $_SESSION['project']);
      exec('git status', $output);

      foreach($output as $line)
      {
        if(preg_match('/modified:\s+([^\s]+)$/', $line, $result) 
                || preg_match('/#\s+([^\s]+)$/', $line, $result))
        {
          if(!empty($filePath))
          {
            if(strpos($result[1], $filePath . '/') !== false 
                    && !in_array($result[1], $files))
            {
              $files[] = $result[1];
            }
          }
          elseif(!in_array($result[1], $files))
          {
            $files[] = $result[1];
          }
        }
      }
    }
    
    return $files;
  }
  
  public function &Push($comment, $files)
  {
    chdir(WORKSPACE . DIRECTORY_SEPARATOR. $_SESSION['project']);
    
    $gitAdd = '';
    foreach ($files as $file)
    {
      if(file_exists(WORKSPACE . DIRECTORY_SEPARATOR . 
              $_SESSION['project'] . DIRECTORY_SEPARATOR . $file))
      {
        $gitAdd .= $file.' ';
      }
    }
    
    $gitAdd = trim($gitAdd);
    
    if(!empty($gitAdd))
    {
      //var_dump('git add ' . $gitAdd);
      exec('git add '.$gitAdd.' && echo "OK"', $output);

      $comment_list = explode("\n", $comment);
      $comment = implode('" -m "', array_map('trim', $comment_list));

      //var_dump('git commit -m "'.$comment.'"');
      exec('git commit -m "'.$comment.'" . && echo "OK"', $output);
    }
    
    return $output;
  }

}