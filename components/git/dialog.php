<?php

/*
*  Copyright (c) Codiad & Kent Safranski (codiad.com), distributed
*  as-is and without warranty under the MIT License. See 
*  [root]/license.txt for more. This information must remain intact.
*/

require_once('../../config.php');

//////////////////////////////////////////////////////////////////
// Verify Session or Key
//////////////////////////////////////////////////////////////////

checkSession();

?>
<form onsubmit="return false;">
<?php

switch($_GET['action']){

    case 'commit':
      
      $filePath = $_GET['path'];
      if(!file_exists(WORKSPACE . $filePath))
      {
        $filePath = '';
      }
      else
      {
        $filePath = str_replace($_SESSION['project'], '', $filePath);
        $filePath = trim($filePath, '/'.DIRECTORY_SEPARATOR);
      }
      
      ?>
        <div id="commit_form">
          <table class="commit">
            <tr>
              <td>
                <textarea name="comment"></textarea>
              </td>
            </tr>
            <tr>
              <td>
                <span style="display: block; overflow-y: scroll; max-height: 300px;word-wrap: break-word;width: 330px;">
                  <table id="commit_files" style="word-wrap: break-word;"></table>
                  <span id="commit_empty" style="display: none">
                    Hey Ioane nothing to commit !
                  </span>
                  <span id="commit_wait">
                    Please wait ...<br />
                  </span>
                </span>
              </td>
            </tr>
          </table>
        
          <button class="btn-right" onclick="codiad.modal.unload(); return false;"><?php i18n("Cancel"); ?></button>
          <button id="commit_button" class="btn-left" style="display: none" onclick="codiad.git.push($(this));return false;"><?php i18n("Commit"); ?></button>
        </div>
        <span id="commit_message" style="display: none">
          All changes has been commited...<br />
          
          <button class="btn-right" onclick="codiad.modal.unload(); return false;"><?php i18n("OK"); ?></button>
        </span>
      <script>
        codiad.git.status("<?php echo $filePath; ?>");
      </script>
      <?php
    break;
    
}

?>
</form>
