<?php
/**
 *  EDGERING HANDLER 
 *
 *  $old_error_handler is defined
 *  
 *  configuring log file:
 *
 *    define("ERR_LOG_FILE","error.log");
 *
 *  to disable:
 *  
 *    define("ERR_LOG_FILE",false);
 *  
 *  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *  todo:
 *  
 *  define("ERR_LOG_EDGERING"); API
 *  
 *  
 */
 
function EdgeringErrorHandlerSave($type,$errno,$errstr,$errline,$errfile)
{  
  $err_file = (defined("ERR_LOG_FILE")) ? ERR_LOG_FILE : 'php_errors.log';
  $err_line_style = (defined("ERR_LINE_STYLE")) ? ERR_LINE_STYLE : 'font-family: Consolas; display: block; font-size: .9em; margin-bottom: 1px; background: #f5f5f5; padding: 3px;'; 
  
  echo '<span style="' . $err_line_style . '"><b>' . $type . "</b> [$errno] " . $errstr;
  echo "| line $errline in file " . $errfile . "</span>";

  if ($err_file && $err_file != '')
  {            
    $handle = fopen($err_file,"a+");
    fwrite($handle,date("Y-m-d H:i:s") . " " . $type . "[$errno] $errstr | " . "Line $errline in file " . $errfile . "\n");
    fclose($handle);
  }  
}

function EdgeringErrorHandler($errno, $errstr, $errfile, $errline)
{        
  if (!(error_reporting() & $errno)) 
  {
    // This error code is not included in error_reporting, so let it fall
    // through to the standard PHP error handler
    
    return false;
  }
  
  switch ($errno) 
  {
    case E_USER_ERROR:   
                
      EdgeringErrorHandlerSave("ERROR",$errno,$errstr,$errline,$errfile); 
                     
      exit(1);
      break;

    case E_USER_WARNING:
      
      EdgeringErrorHandlerSave("WARNING",$errno,$errstr,$errline,$errfile);
      break;

    case E_USER_NOTICE:
    
      EdgeringErrorHandlerSave("NOTICE",$errno,$errstr,$errline,$errfile);        
      break;

    default:
    
      EdgeringErrorHandlerSave("ERROR",$errno,$errstr,$errline,$errfile);
      break;
    }

    /** Don't execute PHP internal error handler **/
    
    return true;
}
/**
 *  Disable loging to file:
 *
 *  define("ERR_LOG_FILE",false);
 *  
 */
 
$old_error_handler = set_error_handler("EdgeringErrorHandler");
