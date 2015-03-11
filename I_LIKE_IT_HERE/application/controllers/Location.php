<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++
 * 	Locations Controller.
 * 	Handles routes for posting and retrieving location
 * 	data to and from a users profile.
 *
 *	@author 	Aarin Smith
 *  @copyright 	2015, Aarin Smith
 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */
class Location extends CI_Controller
{
	// Very loose RESTful call to add a placeId to a user.
	public function addPlace()
	{
		$place = $this->input->post('placeId');
		$userId = $this->input->post('userId');

		$this->User->addLocation( $userId, $place );

		return "Sucessfully added to DB";
	}

	// Returns all locations for specific user.
	public function userLocations( $userId )
	{
		$userData = $this->User->getUser($userId);
		$userLocations = $this->User->getUserLocations($userId);
		$apiKey = "AIzaSyBRd2V8NbgsMXTkHIqiYdLH3yjGEuh5aI0";

		$data['fName'] = $userData['fname'];
		$data['lName'] = $userData['lname'];
		$data['blurb'] = $userData['blurb'];
		$data['profilePic'] = $userData['image'];
		$data['back'] = $userId;
		$data['locations'] = [];

		foreach( $userLocations as $location )
		{
			$url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=" .
				$location->placeId . "&key=" . $apiKey;

			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_HEADER, false);
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_SSLVERSION,3);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    $result = curl_exec($ch);
		    curl_close($ch);

			$data['locations'][] = [ 'location' => json_decode($result)->result->name ];
		}

		$this->parser->parse('locations', $data);
	}
}