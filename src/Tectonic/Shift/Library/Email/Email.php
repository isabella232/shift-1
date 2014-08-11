<?php namespace Tectonic\Shift\Library\Email;

use Bundle;
use Config;
use Event;
use HTML;
use IoC;
use URL;
use View;
use Setting;

/**
 * Email wrapper class, to go around whatever email bundle we're using.
 *
 * @example
 * 	try {
 * 		Email::make( 'email@address.com' , 'subject' , 'path.to.emails.view' , array( 'name' => 'Bob' ) );
 * 	} catch( Shift\Exceptions\SendEmailException $e ) {
 * 		var_dump( $e->getMessage() );
 * 		exit;
 * 	}
 */

class Email
{
	public $mailer;

	public $recipient;
	public $subject;
	public $content;

	/**
	 * Creates an email instance with all settings retrieved from config.
	 *
	 * @param string $recipient
	 * @param string $subject
	 * @param string $content
	 */
	public function __construct( $recipient , $subject , $content )
	{
		$this->recipient = $recipient;
		$this->subject   = $subject;
		$this->content   = $content;
	}

	/**
	 * Creates an email instance with all settings retrieved from config, builds the email
	 * and sends it.
	 *
	 * @param string $recipient
	 * @param string $subject
	 * @param string $view
	 * @param array  $view_data
	 */
	public static function make( $recipient , $subject , $content )
	{
		$email = new static( $recipient , $subject , $content );

		return $email->build()->send();
	}

	/**
	 * Populates all the settings required for sending the email.
	 * Returns an object that is ready to be sent.
	 *
	 * @return Email
	 */
	public function build()
	{
		Bundle::start( 'phpmailer' );

		// Get an instance of PHPMailer.
		$this->mailer = IoC::resolve( 'phpmailer' );

		// SMTP Settings. Defaults to false.
		if ( Config::get( 'email.smtp' ) === true )
		{
			$this->mailer->isSMTP();
			$this->mailer->SMTPSecure = Config::get( 'email.smtp_secure', '' );
			$this->mailer->SMTPAuth   = Config::get( 'email.smtp_auth', false);
			$this->mailer->Port       = Config::get( 'email.smtp_port', 25);
			$this->mailer->Host       = Config::get( 'email.smtp_host', '' );
			$this->mailer->Username   = Config::get( 'email.smtp_user', '' );
			$this->mailer->Password   = Config::get( 'email.smtp_pass', '' );
		}

		// HTML email. Defaults to false.
		$this->mailer->IsHTML( Config::get( 'email.html', false) );

		// Character set.
		$this->mailer->CharSet  = Config::get( 'email.charset', 'utf-8' );

		// Sender.
		$this->mailer->From     = Config::get( 'email.from_email' );
		$this->mailer->FromName = Setting::get( 'app.site.name' );
		$this->mailer->Sender   = Config::get( 'email.from_email' );

		// Clear reply-to fields.
		$this->mailer->ClearReplyTos();
		$this->mailer->AddReplyTo( Config::get( 'email.from_email' ) , Config::get( 'email.from_name' ) );

		// Set email subject, body and recipient.
		$this->mailer->Subject = $this->subject;
		$this->mailer->AddAddress( $this->recipient );
		$this->mailer->Body = $this->content;

		// Pass back the mailer object all ready for sendage.
		return $this;
	}

	/**
	 * Wrapper around the send method of whatever bundle that is being used to send
	 * the email.
	 *
	 * @throws Shift\Exceptions\SendEmailException If Email is not sent successfully.
	 *
	 * @return Email
	 */
	public function send()
	{
		$sent = $this->mailer->Send();

		if ( !$sent )
		{
			throw new Shift\Exceptions\SendEmailException( $this->mailer->ErrorInfo );
		}

		Event::fire( 'email.sent' , [ $this ] );

		return $this;
	}

	/**
	 * Returns a rendered laravel view.
	 *
	 * @param  string $view      The location of the view file. E.g. emails.welcome
	 * @param  array  $view_data The data to pass to the view.
	 *
	 * @return string
	 */
	protected function body( $view, $view_data = [] )
	{
		return View::make( $view )->with( $view_data )->render();
	}

	protected function merge_data_with_defaults( $view_data = [] )
	{
		$defaults = [
			'site_name' => HTML::setting( 'app.site.name' ),
			'site_url' => URL::base()
		];

		return array_merge( $defaults , $view_data );
	}


}
