<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *	Default controller.
 * 	Responsible for management of templates that demo
 * 	location based matching system for POF Hackathon.
 *
 *	@author 	Aarin Smith
 *  @copyright 	2015, Aarin Smith
 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */
class Welcome extends CI_Controller
{
	// Displays initial site landing page. Simple bootstrap
	// table listing current users on site.
	public function index()
	{
		$data['logo'] = "/img/ilih.png";
		$data['users'] = $this->User->getAll();

		$this->parser->parse('home', $data);
	}

	// Retrieves single user and populates view template for
	// single user display with matches.
	public function user( $userId )
	{
		$id = $userId;

		$this->session->id = $id;

		$data['matches'] = $this->User->getUserMatchPercents($id);

		$userData = $this->User->getUser($id);

		$data['fName'] = $userData['fname'];
		$data['lName'] = $userData['lname'];
		$data['blurb'] = $userData['blurb'];
		$data['userid'] = $id;
		$data['profilePic'] = $userData['image'];

		$this->parser->parse('user', $data);
	}

	// Retrieves matches for user Id passed in based on current
	// user stored in session.
	public function displayMatches( $currentUser, $otherUser )
	{
		$matches = $this->User->getMatchesForUser( $currentUser, $otherUser );
		$apiKey = "AIzaSyBRd2V8NbgsMXTkHIqiYdLH3yjGEuh5aI0";

		$data = $this->User->getUser($currentUser);
		$temp = $this->User->getUser($otherUser);

		$data['ofname'] = $temp['fname'];
		$data['olname'] = $temp['lname'];
		$data['oblurb'] = $temp['blurb'];
		$data['oimage'] = $temp['image'];

		$data['matches'] = [];

		foreach( $matches as $placeId )
		{
			$url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=" .
				$placeId . "&key=" . $apiKey;

			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_HEADER, false);
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_SSLVERSION,3);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    $result = curl_exec($ch);
		    curl_close($ch);

			$data['matches'][] = [ 'match' => json_decode($result)->result->name ];
		}

		$data['back'] = $currentUser;

		$this->parser->parse('matches', $data);
	}
}
