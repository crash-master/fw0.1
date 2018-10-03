<?php
namespace Kernel;

class ErrorHandler{

	/**
	 * [$errs container with all errs for display in html]
	 *
	 * @var [array]
	 */
	private $errs;

	/**
	 * [$errs_src container with all errs in source view]
	 *
	 * @var [array]
	 */
	private $errs_src;

	/**
	 * [$err_disp flag show errs or not]
	 *
	 * @var [bool]
	 */
	public $err_disp;
	
	/**
	 * [$errs_types_disp what errors need to be displayed]
	 *
	 * @var [array]
	 */
	private $errs_types_disp;

	/**
	 * [__construct of ErrorHandler]
	 */
	public function __construct(){
		$err_disp = Config::get() -> system -> debug;
		$this -> err_disp = $err_disp;
		$this -> errs_types_disp = Config::get() -> system -> ErrorHandler;
		if($err_disp){
			error_reporting(-1);
		}else{
			error_reporting(0);
		}
		$this -> setErrHandler();
	}

	/**
	 * [setErrHandler set custom error handler]
	 */
	public function setErrHandler(){
		set_error_handler([$this, 'handler'], E_ALL);

		register_shutdown_function([$this, 'fatalErrorHandler']);

		ob_start();
	}

	/**
	 * [fatalErrorHandler set custom FATAL error handler]
	 *
	 * @return [null] [nothing]
	 */
	public function fatalErrorHandler(){
		$error = error_get_last();
		if ($error){
			if($error['type'] == E_ERROR || $error['type'] == E_PARSE || $error['type'] == E_COMPILE_ERROR || $error['type'] == E_CORE_ERROR){
				ob_end_clean();
				$this -> viewFatalError($error['type'], $error['message'], $error['file'], $error['line']);
				$err_type = $this -> getErrType($error['type']);
				$this -> errs_src[] = ['errno' => $error['type'], 'err_type' => $err_type, 'errstr' => $error['message'], 'errfile' => $error['file'], 'errline' => $error['line']];
			}
		}
		ob_end_flush();
	}

	/**
	 * [viewFatalError show styles and html code for fatal error]
	 *
	 * @param  [int] $errno [number of error code]
	 * @param  [string] $errstr [error message]
	 * @param  [string] $errfile [file with error]
	 * @param  [int] $errline [number line with error]
	 *
	 * @return [type] [description]
	 */
	public function viewFatalError($errno, $errstr, $errfile, $errline){
		if(!$this -> err_disp) return false;
		$err_type = $this -> getErrType($errno);
		$code = $this -> getProgCode($errfile, $errline);
		?>
		<style>
			*{padding:0;margin:0}body{background:#444}.fw-err-block{width:100%;height:auto;padding:20px;background-color:#444;color:#eee;font-family:Courier!important;font-size:15px}.fw-err-block .line{display:block;padding:10px;background:#eee;font-weight:700}.fw-err-block .line.error{background-color:#ccc;color:#B71C1C}.fw-err-block code{padding:10px;color:#00695C}.fw-err-block code .line b{padding-right:10px;border-right:2px solid #ccc;display:inline-block;margin-right:10px;font-weight:400}
		</style>
		<div class="fw-err-block">
			<div class="fw-err-block-head">
				<h1><?= $err_type ?> <small>code(<?= $errno ?>)</small></h1><br>
				<p><strong>Error text:</strong> <?= $errstr ?></p>
			</div>
			<div class="fw-err-block-body">
				<p><strong>In file:</strong> <?= $errfile ?> <strong>on line</strong> <?= $errline ?></p>
				<code>
					<?php foreach ($code as $inx => $line): ?>
						<?php if ($inx == $errline): ?>
							<span class="line error"><b><?= $inx ?></b> <?= $line ?></span>
						<?php else: ?>
							<span class="line"><b><?= $inx ?></b> <?= $line ?></span>
						<?php endif; ?>
					<?php endforeach ?>
				</code>
			</div>
		</div>
		<?php
	}

	/**
	 * [getErrType get type of error]
	 *
	 * @param  [int] $errno [error code]
	 *
	 * @return [string] [name of error]
	 */
	private function getErrType($errno){
		switch ($errno) {
			case E_USER_ERROR: $errtype = 'E_USER_ERROR'; break;
			case E_USER_WARNING: $errtype = 'E_USER_WARNING'; break;
			case E_USER_NOTICE: $errtype = 'E_USER_NOTICE'; break;
			case E_PARSE : $errtype = 'E_PARSE '; break;
			case E_CORE_ERROR: $errtype = 'E_CORE_ERROR'; break;
			case E_ERROR: $errtype = 'E_ERROR'; break;
			case E_WARNING: $errtype = 'E_WARNING'; break;
			case E_NOTICE : $errtype = 'E_NOTICE'; break;
			default: $errtype = 'UNDEFINED'; break;
		}

		return $errtype;
	}

	/**
	 * [handle of error]
	 *
	 * @param  [int] $errno [number of error code]
	 * @param  [string] $errstr [error message]
	 * @param  [string] $errfile [file with error]
	 * @param  [int] $errline [number line with error]
	 *
	 * @return [bool] [true]
	 */
	public function handler($errno, $errstr, $errfile, $errline){
		$err_type = $this -> getErrType($errno);
		if(!array_search($err_type, $this -> errs_types_disp)){
			$this -> errs_src[] = compact('errno', 'err_type', 'errstr', 'errfile', 'errline', 'code');
			return true;
		}
		$code = $this -> getProgCode($errfile, $errline);
		$page = view('default/error-layout/error-page-dev', compact('errno', 'err_type', 'errstr', 'errfile', 'errline', 'code'));
		$this -> errs[] = $page;
		return true;
	}

	/**
	 * [view all errors (after another code of site)]
	 *
	 * @return [void] [nothing]
	 */
	public function viewErrs(){
		if(!is_array($this -> errs) or !count($this -> errs))
			return false;
		show(view('default/errors', ['errs' => $this -> errs]));
	}

	/**
	 * [get lines with errors from file]
	 *
	 * @param  [string] $errfile [file with error]
	 * @param  [int] $errline [number line with error]
	 *
	 * @return [type] [description]
	 */
	public function getProgCode($errfile, $errline){
		$file = file($errfile);
		$code = [];
		for($i=$errline - 4; $i<$errline+4; $i++){
			if(trim($file[$i]) == '') continue;
			$code[$i+1] = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', htmlspecialchars($file[$i]));
		}
		return $code;
	}

	/**
	 * [Log errs to log system]
	 *
	 * @return [bool] [false]
	 */
	public function log(){
		$section = 'SYSTEM_ERRS';
		if(!is_array($this -> errs_src) or !count($this -> errs_src)){
			return false;
		}
		foreach($this -> errs_src as $err){
			Log::add($section, $err['errno'].' | '.$err['errstr']. ' | IN FILE '. $err['errfile']. ' | IN LINE #'. $err['errline']);
			Log::add($section.'_JSON', json_encode($err));
		}

		return false;
	}
}