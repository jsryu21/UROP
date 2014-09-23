<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

require_once( APPPATH . 'libraries/facebook/Facebook/GraphObject.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/GraphSessionInfo.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/Entities/AccessToken.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookSession.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookResponse.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookSDKException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRequestException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookAuthorizationException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/HttpClients/FacebookHttpable.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/HttpClients/FacebookStream.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/HttpClients/FacebookStreamHttpClient.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRequest.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRedirectLoginHelper.php' );

use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;

class Facebook {
    var $ci;
    var $helper;
    var $session;

    public function __construct() {
		$this->ci =& get_instance();
		FacebookSession::setDefaultApplication( $this->ci->config->item('facebook_api_id'), $this->ci->config->item('facebook_app_secret') );
		$this->helper = new FacebookRedirectLoginHelper( $this->ci->config->item('facebook_redirect_url') );
		if ( $this->ci->session->userdata('fb_token') ) {
		  $this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );
		  // Validate the access_token to make sure it's still valid
		  try {
			if ( ! $this->session->validate() ) {
			  $this->session = false;
			}
		  } catch ( Exception $e ) {
			// Catch any exceptions
			$this->session = false;
		  }
		} else {
		  try {
			$this->session = $this->helper->getSessionFromRedirect();
		  } catch(FacebookRequestException $ex) {
			// When Facebook returns an error
		  } catch(\Exception $ex) {
			// When validation fails or other local issues
		  }
		}
		if ( $this->session ) {
		  $this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );
		  $this->session = new FacebookSession( $this->session->getToken() );
		}
    }

    public function get_login_url() {
		return $this->helper->getLoginUrl( $this->ci->config->item('facebook_permissions') );
    }

    public function get_logout_url() {
		if ( $this->session ) {
		  return $this->helper->getLogoutUrl( $this->session, site_url( 'logout' ) );
		}
		return false;
	}

    public function get_user() {
		if ( $this->session ) {
		  try {
			$request = (new FacebookRequest( $this->session, 'GET', '/me?fields=id,gender,first_name,last_name,name,picture,email' ))->execute();
			$user = $request->getGraphObject()->asArray();
	 
			return $user;
		  } catch(FacebookRequestException $e) {
			return false;
	 
			/*echo "Exception occured, code: " . $e->getCode();
			echo " with message: " . $e->getMessage();*/
		  }
		}
    }

    public function get_facebook_id() {
		if ( $this->session ) {
			return $this->session->getSessionInfo()->getId();
		}
	}
	
	public function get_friends() {
		if ( $this->session ) {
		  try {
			/* make the API call */
			$request = new FacebookRequest(
			  $this->session,
			  'GET',
			  '/me/friends?fields=id,gender,first_name,last_name,name,picture'
			);
			$response = $request->execute();
			return $response->getGraphObject()->asArray()['data'];
		  } catch(FacebookRequestException $e) {
			return false;
	 
			/*echo "Exception occured, code: " . $e->getCode();
			echo " with message: " . $e->getMessage();*/
		  }
		}
	}
}

/* End of file Facebook.php */