	<?php

class LoginController extends Controller
{
	public function __construct()
	{
		session_start();

	}
	public function display()
	{
		$data = array();
		$this->renderView( $data );
	}



	public function checkLogin()
	{
		$email = trim($this->request->getValue('email'));
		$password = sha1(trim($this->request->getValue('password')));

		// if(isset($_COOKIE['pass']) && $_COOKIE['pass'] == $password)

		if( $result = Db::getInstance()->select('SELECT * FROM `user` WHERE `password` = "'.$password.'" AND `email` = "'.$email.'" ;'))
		{
			$user = $result[0];

			$_SESSION['user'] = $user;
			$_SESSION['authenticated'] = true;
			setcookie('user', $user	, time() + 365*24*3600, null, null, false, true); 
			setcookie('pass', $password 	, time() + 365*24*3600, null, null, false, true); 


			header('location: http://176.31.245.123/stansmith/index.php?controller=admin');

		}
		else
			header('location: http://176.31.245.123/stansmith/index.php?controller=login');
	
	}
}
