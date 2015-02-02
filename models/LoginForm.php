<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Login dauerhaft speichern',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * 
	 * errorCode ist defined in UserIdentity
	 * 
	 */
	public function authenticate($attribute,$params)
	{
		
		if(!$this->hasErrors()) {
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate()) {
				$this->addError('password',$this->getErrorMessage($this->_identity->errorCode));
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*365 : 0; // 365 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	
	private function getErrorMessage($errorCode=0) {
		switch($errorCode) {
			case 1:
				$errorMessage = 'Username ist ungültig.';
				break;
			case 2:
				$errorMessage = 'Name und Passwort sind ungültig.';
				break;
			case 3:
				$errorMessage = 'Dieser Account wurde noch nicht aktiviert.';
				break;
			case 4:
				$errorMessage = 'Dieser Account wurde vorübergehend gesperrt.';
				break;				
			case 100:
				$errorMessage = 'Unbekannter Fehler';
				break;
			default:
				$errorMessage = 'Unbekannter Fehler';
		}
		return $errorMessage;
	}
	
}
