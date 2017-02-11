# PHP error logging

Simple PHP error log function for setting set_error_handler()

Settings:

    define("ERR_LOG_FILE","error.log");          // configuring file to catch errors     
    define("ERR_LINE_STYLE",'font-weight: bold') // CSS inline style for error display

to disable logging to file:

    define("ERR_LOG_FILE",false);
