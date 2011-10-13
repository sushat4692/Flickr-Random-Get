<?php
/*
Plugin Name: Flickr Random Get
Plugin URI: http://sus-happy.net
Description: Flickr Get Random Photos
Author: SUSH
Version: 0.1
Author URI: http://sus-happy.net
*/

if( !class_exists( 'FlikcrRandPhoto' ) ){

	class FlikcrRandPhoto {

		var $FLICKR_API_KEY;
		var $FLICKR_API_SECRET;
		var $FLICKR_USER_ID;

		var $FLICKR_API_REST = "http://api.flickr.com/services/rest/";

		var $error_message;

		function FlikcrRandPhoto() {
			add_action( "admin_menu", array($this, "setMenu") );
		}

		/* #####################################
			Set Admin Menu
		##################################### */
		function setMenu() {
			add_options_page('Flickr Random Get', 'Flickr Random Get', 'manage_options', 'flicr-random-get-options', array( $this, 'setParamaterView') );
		}

		/* #####################################
			Get Options Page Template
		##################################### */
		function setParamaterView() {
			require_once( dirname(__FILE__)."/template/options.php" );
		}

		/* #####################################
			Set Paramater
		##################################### */
		function setParamater() {
			$this->FLICKR_API_KEY		= get_option('flickrRandomPhotoAPIKey');
			$this->FLICKR_API_SECRET	= get_option('flickrRandomPhotoAPISecret');
			$this->FLICKR_USER_ID		= get_option('flickrRandomPhotoUserID');
			if(
				empty( $this->FLICKR_API_KEY ) &&
				empty( $this->FLICKR_API_SECRET ) &&
				empty( $this->FLICKR_USER_ID )
			) {
				$error_message[] = "Get Paramater Error";
				return FALSE;
			}

			return $this->getUserInfo();
		}

		/* #####################################
			Get User Information
		##################################### */
		function getUserInfo() {
			$param = array(
				"api_key"	=> $this->FLICKR_API_KEY,
				"method"	=> "flickr.people.getInfo",
				"user_id"	=> $this->FLICKR_USER_ID,
				"format"	=> "php_serial",
			);
			$url = $this->FLICKR_API_REST . "?" . http_build_query($param);
			
			$res = unserialize( $this->sendParam( $url ) );

			if( $res["stat"] != "ok" ) {
				$error_message[] = "Get User Information Error";
				return FALSE;
			}

			$this->cnt = $res["person"]["photos"]["count"]["_content"];
			return $this->getSearch();
		}

		/* #####################################
			Search Photo
		##################################### */
		function getSearch() {
			$param = array(
				"api_key"	=> $this->FLICKR_API_KEY,
				"method"	=> "flickr.photos.search",
				"user_id"	=> $this->FLICKR_USER_ID,
				"privacy_filter"=> 1,
				"content_type "	=> 1,
				"format"	=> "php_serial",
				"per_page"	=> 1,
				"page"		=> mt_rand(1, $this->cnt)
			);
			$url = $this->FLICKR_API_REST . "?" . http_build_query($param);
			
			$res = unserialize( $this->sendParam( $url ) );

			if( $res["stat"] != "ok" ) {
				$error_message[] = "Search Photo Error";
				return FALSE;
			}

			$this->photos = $res["photos"]["photo"];
			return TRUE;
		}

		/* #####################################
			Sending Paramater
		##################################### */
		function sendParam( $url ) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			return curl_exec($ch);
		}

		/* #####################################
			Get Error
		##################################### */
		function getErrorMessage() {
			echo join( $this->error_message, "<br />" );
		}

		/* #####################################
			Make <img>
		##################################### */
		function makeImage() {
			if( $this->setParamater() ) {
				if( $this->photos ) { foreach( $this->photos as $ph ) {
					echo "<img src=\"http://farm".$ph["farm"].".static.flickr.com/".$ph["server"]."/".$ph["id"]."_".$ph["secret"]."_z.jpg\" alt=\"".$ph["title"]."\" />";
				} } else $this->error_message[] = "Empty Photos";
			}
			if( !empty($this->error_message) ) $this->getErrorMessage();
		}
	}

} // END Class FlikcrRandPhoto

if( class_exists( 'FlikcrRandPhoto' ) ){
	global $flickr;
	$flickr = new FlikcrRandPhoto();
}