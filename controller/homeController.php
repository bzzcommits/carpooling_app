<?php

class HomeController extends BaseController
{
		public function index()
		{
				if( isset( $_GET['niz'] ) && preg_match( '/^[a-z]{20}$/', $_GET['niz'] ) )
				{
						$as = new AuthenticationService();
						if( $as->registerUser( $_GET[ 'niz' ] ) === false )
								$this->registry->template->message = "This registration sentence doesn't belong to one and only one user!";
						else
								$this->registry->template->message = "You've just registered!";
				}

				$this->registry->template->show( 'home_index' );
		}

		public function login()
		{
				if( isset( $_POST[ 'login' ] ) )
				{
						if( isset( $_POST[ 'username' ] ) && isset( $_POST[ 'password' ] ) && $_POST[ 'username' ] != '' && $_POST[ 'password' ] != '' )
						{
								if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['username'] ) )
										$this->registry->template->message = "A username must have between 3 and 10 letters!";
								else
								{
										$as = new AuthenticationService();

										$user = $as->validateUser( $_POST["username"], $_POST["password"]);

										switch( $user )
										{
												case 0:
														$this->registry->template->message = "You haven't signed up yet!";
														break;
												case -1:
														$this->registry->template->message = "Wrong password!";
														break;
												case -2:
														$this->registry->template->message = "You haven't registered yet!";
														break;
												case 1:
														$_SESSION[ 'user_id' ] = $user->id;
														$_SESSION[ 'username' ] = $user->username;
														header( 'Location: ' . __SITE_URL . '/index.php?rt=home' );
														exit();
										}
								}

						}
						else
								$this->registry->template->message = "Enter both username and password!";
				}
				else
				{
						if( isset( $_SESSION[ 'username' ] ) )
						{
								header( 'Location: ' . __SITE_URL . '/index.php?rt=home' );
								exit();
						}
				}
				$this->registry->template->show( 'login_index' );
				exit();
		}

		public function signup()
		{
				if( isset( $_POST[ 'signup' ] ) )
				{
						if( isset( $_POST[ 'username' ] ) && isset( $_POST[ 'password' ] ) && isset( $_POST[ 'email' ] )
						&& $_POST[ 'username' ] != '' && $_POST[ 'password' ] != '' && $_POST[ 'email' ] != '' )
						{
								if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['username'] ) )
										$this->registry->template->message = "A username must have between 3 and 10 letters!";

								else if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
										$this->registry->template->message = "Enter valid e-mail address!";

								else
								{
										$as = new AuthenticationService();

										$user = $as->signupUser( $_POST[ 'username' ], $_POST[ 'password' ], $_POST[ 'email' ] );

										switch( $user )
										{
												case 0:
														$this->registry->template->message = "Entered username or e-mail address already exists!";
														break;
												case -1:
														$this->registry->template->message = "E-mail couldn't have been sent!";
														break;
												case 1:
														$this->registry->template->message = 'You\'ve just signed up!';
														break;
										}
								}

						}
						else
								$this->registry->template->message = "Enter username, password and e-mail address!";
				}
				else
				{
						if( isset( $_SESSION[ 'username' ] ) )
						{
								header( 'Location: ' . __SITE_URL . '/index.php?rt=home' );
								exit();
						}
				}
				$this->registry->template->show( 'signup_index' );
				exit();
		}

		function logout()
		{
				session_unset();
				session_destroy();

				header( 'Location: ' . __SITE_URL . '/index.php?rt=home' );
				exit();
		}
};

?>
