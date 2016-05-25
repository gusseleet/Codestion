<?php
namespace gel\logger;

    use Anax\Exception;

    /**
     * File logger
     *
     * Log notices, warnings, errors or fatal errors into a log file.
     *
     * @author gel
     */
	 
    class FileLogger {

        /**
         * Holds the file handle.
         *
         * @var resource
         */
        protected $fileHandle = NULL;

        /**
         * The time format to show in the log.
         *
         * @var string
         */
        protected $timeFormat = 'd.m.Y - H:i:s';

        /**
         * The file permissions.
         */
        const FILE_CHMOD = 756;
		
		/**
		* Will be true if error message should show on site.
		* @var bool
		*/
		
		private $devMode = NULL;

        /**
         * Opens the file handle and sets new error handler.
         *
         * @param string $logfile The path to the loggable file.
         */
        public function __construct($logfile) {
            if($this->fileHandle == NULL)
                $this->openLogFile($logfile);
            
            $this->devMode = false;
            set_error_handler([$this,"log"]);
            error_reporting(-1);
        }

        /**
         * Closes the file handle.
         */
        public function __destruct() {
            $this->closeLogFile();
        }


		/**
		* If devMode is true, error messages will be shown on site.
		* @params bool $bool 
		*/
        public function displayErrors($bool){
            $this->devMode = $bool;
        }

        public function changeErrorReporting($level){

            error_reporting($level);
        }

        /**
         * Logs the message into the log file.
         * @param int $errno Contains the level of the error raised.
         * @param string $errstr Contains the error message.
         * @param string $errfile Contains the filename that the error was raised in.
         * @param int $errline contains the line number the error was raised at.
         * @throws \Exception
         */
        public function log($errno, $errstr, $errfile, $errline) {
            if($this->fileHandle == NULl){
                throw new Exception('Logfile is not opened.');
            }

            if(!is_string($errstr)){
                throw new Exception('$message is not a string');
            }

            if($this->devMode)
               echo $this->printErrors($errno, $errstr, $errfile, $errline);

            $this->writeToLogFile($this->format($errno, $errstr, $errfile, $errline));
        }

        /**
         * Writes content to the log file.
         *
         * @param string $message
         */
        private function writeToLogFile($message) {
            flock($this->fileHandle, LOCK_EX);
            fwrite($this->fileHandle, $message.PHP_EOL);
            flock($this->fileHandle, LOCK_UN);
        }

        /**
         * Returns the current timestamp.
         *
         *
         * @return string with the current date
         */
        private function getTime() {
            return date($this->timeFormat);
        }


        /**
         * Closes the current log file.
         */
        protected function closeLogFile() {
            if($this->fileHandle != NULL) {
                fclose($this->fileHandle);
                $this->fileHandle = NULL;
            }
        }


        /**
         * Opens a file handle.
         * @param string $logFile Path to log file.
         * @throws Exception
         *
         */
        public function openLogFile($logFile) {
            $this->closeLogFile();

            if(!is_dir(dirname($logFile))){
                if(!mkdir(dirname($logFile), FileLogger::FILE_CHMOD, true)){
                    throw new Exception('Could not find or create directory for log file.');
                }
            }

            if(!$this->fileHandle = fopen($logFile, 'a+')){
                throw new Exception('Could not open file handle.');
            }
        }

        /**
         * Logs the message into the log file.
         * @param int $errno Contains the level of the error raised
         * @param string $errstr Contains the error message,
         * @param string $errfile Contains the filename that the error was raised in
         * @param int $errline contains the line number the error was raised at
         * @return string
         */
        public function format($errno, $errstr, $errfile, $errline){

            return "[TIME: ".$this->getTime()."]" . " - " . "[LEVEL: " . $this->friendly_error_type($errno) . "]" . " - ". "[MESSAGE: " . $errstr. "]" .  " - ".  "[IN: " . $errfile . "]" . " - " . "[ROW: " .  $errline . "]";
        }


        public function printErrors($errno, $errstr, $errfile, $errline){

            return "LEVEL: " . "<b>" . $this->friendly_error_type($errno) . "</b>" . " <br> ". "MESSAGE: " . "<b>". $errstr. "</b>" .  "<br>".  "IN: <b>" . $errfile . "</b>" . " at" . ":" . "<b>" . $errline . "</b>";
    }

        /**
		 * Translate an error message to a more friendly output. 
         * @param int $type User error
         * @return string User error
         */

       public function friendly_error_type($type) {
            static $levels=null;
            if ($levels===null) {
                $levels=[];
                foreach (get_defined_constants() as $key=>$value) {
                    if (strpos($key,'E_')!==0) {continue;}
                    $levels[$value]=substr($key,2);
                }
            }
            $out=[];
            foreach ($levels as $int=>$string) {
                if ($int&$type) {$out[]=$string;}
                $type&=~$int;
            }
            if ($type) {$out[]="Error Remainder [{$type}]";}
            return implode(' & ',$out);
        }


}


