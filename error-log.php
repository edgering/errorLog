<?php
/**
 *  ERROR HANDLER 
 *
 *  $old_error_handler is being set
 *  
 *  configuring:
 *
 *    define("ERR_LOG_FILE","error.log");          // configuring file to catch errors     
 *    define("ERR_LINE_STYLE",'font-weight: bold') // CSS inline style for error display
 *
 *  to disable:
 *  
 *    define("ERR_LOG_FILE",false);
 *  
 */
 
function _errorHandlerSave($errno,$errstr,$errline,$errfile)
{  
  $common = array(512 => "WARNING", 1024 => "NOTICE");
  $type   = (isset($common[$errno])) ? $common[$errno] : 'ERROR[' . $errno . ']'; 
    
  $err_file       = (defined("ERR_LOG_FILE"))   ? ERR_LOG_FILE   : 'php_errors.log';
  $err_line_style = (defined("ERR_LINE_STYLE")) ? ERR_LINE_STYLE : 'font-family: Consolas; display: block; font-size: .9em; margin-bottom: 1px; background: #f5f5f5; padding: 3px;'; 
  
  echo '<span style="' . $err_line_style . '"><b>' . $type . "</b> " . $errstr;
  echo " ... Line ($errline) " . $errfile . "</span>";

  if ($err_file && $err_file != '')
  {            
    $handle = fopen($err_file,"a+");
    fwrite($handle,date("Y-m-d H:i:s") . " " . $type . " " . $errstr . " ... Line ($errline) " . $errfile . "\n");
    fclose($handle);
  }  
}

function _errorHandler($errno, $errstr, $errfile, $errline)
{        
  if (!(error_reporting() & $errno)) 
  {
    // This error code is not included in error_reporting, so let it fall
    // through to the standard PHP error handler
    
    return false;
  }
  
  _errorHandlerSave($errno,$errstr,$errline,$errfile);
  
  if ($errno == E_USER_ERROR) exit(1); 
      
  return true;
}
 
$old_error_handler = set_error_handler("_errorHandler");
