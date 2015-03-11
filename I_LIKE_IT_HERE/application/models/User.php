<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
	// Default constructor must call parent constructor for CI_Model
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Gets and returns all users for demo purposes
	 * @return array of associative arrays
	 */
	function getAll()
	{
		return $this->db->get('users')->result();
	}

	/**
	 * Retrieves a single user from the database by userId
	 *
	 * @param  int $id The Users Id
	 * @return array   Associative array of user data
	 */
	function getUser( $id )
	{
		$user = $this->db->get_where('users', ['id' => $id])->result();

		$userData = get_object_vars($user[0]);

		return $userData;
	}

	/**
	 * Finds matches based on location.
	 *
	 * @param  int $userId user to retrieve matches for.
	 * @return array       Returns 2D array with user id that is matched as first
	 *                     index and personal and distant percent matches on second.
	 */
	function getUserMatchPercents( $userId )
	{
		// :D
		error_reporting(0);

		$allUsers = $this->db->get_where('location', ['userId !=' => $userId])->result();
		$ourUser = $this->db->get_where('location', ['userId' => $userId])->result();

		$result = [];

		foreach( $ourUser as $place )
		{
			foreach( $allUsers as $user )
			{
				$u = get_object_vars($user);
				$p = get_object_vars($place);

				if( $u['placeId'] == $p['placeId'] )
				{
					if ( isset($result[$u['userId']]['match']) )
					{
						$result[$u['userId']]['match']++;
					}
					else
					{
						$result[$u['userId']]['match'] = 1;
					}
				}
			}
		}

		$percent = new NumberFormatter('en_US', NumberFormatter::PERCENT);

		foreach( $result as $user => $index )
		{
			$foreignCount = count($this->db->get_where( 'location', ['userId' => $user])->result());
			$localCount = count($ourUser);

			$temp = $this->getUser($user);

			$final[$user]['fname'] = $temp['fname'];
			$final[$user]['lname'] = $temp['lname'];
			$final[$user]['id'] = $user;
			$final[$user]['us'] = $percent->format($index['match'] / $localCount);
			$final[$user]['them'] = $percent->format($index['match'] / $foreignCount);

			// ------------ POSSIBLE OTHER METRIC ------------
			// measures all matches multiplied by two over the total local plus the total foreign
			// foreign count being the matchee's total number of liked locations.
			// local being total number of matchers liked locations.
			// Provides a single percentage rather than two.
			//
			// $final[$user]['us'] = $percent->format( ($index['match']*2) / ($localCount + $foreignCount));
			//
			// ------------ ACTUAL AVERAGE ------------
			// $final[$user]['us'] = $percent->format( ($localCount + $foreignCount) / 2 / 10);
		}

		if( $final == null )
			return [ 0 => [ "fname" => "No Results", "lname" => "", "id" => "", "us" => "", "them" => "" ]];
		else
			return $final;
	}

	/**
	 * Returns array of matching place id's for two users
	 *
	 * @param  int $id  User Id 1
	 * @param  int $id2 User Id 2
	 * @return array      google placeId's
	 */
	function getMatchesForUser( $id, $id2 )
	{
		$otherUser = $this->db->get_where('location', ['userId' => $id2])->result();
		$ourUser = $this->db->get_where('location', ['userId' => $id])->result();

		$result = [];

		foreach( $ourUser as $place )
		{
			foreach( $otherUser as $user )
			{
				$u = get_object_vars($user);
				$p = get_object_vars($place);

				if( $u['placeId'] == $p['placeId'] )
				{
					$result[] = $u['placeId'];
				}
			}
		}

		return $result;
	}

	function getUserLocations($userId)
	{
		return $this->db->get_where('location', ['userId'=>$userId])->result();
	}

	/**
	 * DEMO PURPOSES ONLY / NOT SECURE
	 * Adds a location to a users profile
	 *
	 * @param int $userId  The id of user whos profile to add to
	 * @param String $placeId The placeId returned by search through the google
	 *                        location API.
	 */
	function addLocation( $userId, $placeId )
	{
		$data = [ 'userId' => $userId, 'placeId' => $placeId ];
		$this->db->insert( 'location', $data );
	}
}