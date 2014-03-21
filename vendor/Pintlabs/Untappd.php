 <?php
/**
 * Provides a service into the Untappd public API.
 *
 * @see    http://untappd.com/api/dashboard
 * @author PintLabs - http://www.pintlabs.com
 *
 */
class Pintlabs_Service_Untappd
{
    /**
     * Base URI for the Untappd service
     *
     * @var string
     */
    const URI_BASE = 'http://api.untappd.com/v4';

    /**
     * Client ID
     *
     * @var string
     */
    protected $_clientId = '';

    /**
     * Client Secret
     *
     * @var string
     */
    protected $_clientSecret = '';

    /**
     * Access token
     *
     * @var string
     */
    protected $_accessToken = '';

    /**
     * URI to redirect a user back to
     *
     * @var string
     */
    protected $_redirectUri = '';

    /**
     * Stores the last parsed response from the server
     *
     * @var stdClass
     */
    protected $_lastParsedResponse = null;

    /**
     * Stores the last raw response from the server
     *
     * @var string
     */
    protected $_lastRawResponse = null;

    /**
     * Stores the last requested URI
     *
     * @var string
     */
    protected $_lastRequestUri = null;

    /**
     * Constructor
     *
     * @throws Pintlabs_Service_Untappd_Exception
     *
     * @param array $connectArgs Connection arguments for OAuth. Options are
     *        - clientId:  Client ID for your app
     *        - clientSecret:  Client secret for your app
     *        - accessToken:  Access token for the user
     *        - redirectUri:  Redirect URI for untappd to return the user to
     */
    public function __construct(array $connectArgs = array())
    {
        if (!isset($connectArgs['clientId']) || empty($connectArgs['clientId'])) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('clientId not set and is required');
        }

        if (!isset($connectArgs['clientSecret']) || empty($connectArgs['clientSecret'])) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('clientSecret not set and is required');
        }

        $this->_clientId = $connectArgs['clientId'];
        $this->_clientSecret = $connectArgs['clientSecret'];
        $this->_accessToken = (isset($connectArgs['accessToken'])) ? $connectArgs['accessToken'] : '';
        $this->_redirectUri = (isset($connectArgs['redirectUri'])) ? $connectArgs['redirectUri'] : '';
    }

    /**
     * Convenience method to generate URI to redirect users to for OAuth2
     *
     * @return string URI
     */
    public function authenticateUri()
    {
        $args = array(
            'client_id'     => $this->_clientId,
            'client_secret' => $this->_clientSecret,
            'response_type' => 'code',
            'redirect_url'  => $this->_redirectUri,
        );

        return 'https://untappd.com/oauth/authenticate/?' . http_build_query($args);
    }

    /**
     * Exchanges a code, which is passed back from untappd, for an access token.
     *
     * @param string $code
     * @return string access token
     */
    public function getAccessToken($code)
    {
        $args = array(
            'response_type' => 'code',
            'redirect_url'  => $this->_redirectUri,
            'client_id'     => $this->_clientId,
            'client_secret' => $this->_clientSecret,
            'code'          => $code,
        );

        $uri = 'https://untappd.com/oauth/authorize/';

        $result = $this->_request($uri, $args, false);

        $this->_accessToken = $result->response->access_token;

        return $this->_accessToken;
    }


    /**
     * Returns the authenticated user's friend feed
     *
     * @param int *optional* $offset offset within the dataset to move to
     * @param int *optional* $limit The number of results to return, max of 50, default is 25
     */
    public function myFriendFeed($offset = '', $limit = '')
    {
        $args = array(
            'offset' => $offset,
            'limit'  => $limit,
        );

        return $this->_request('checkin/recent', $args, true);
    }

    /**
     * Adds a beer to the logged-in-user's wishlist
     *
     * @param int $beerId Untappd beer ID to add
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function addToMyWishlist($beerId)
    {
        if (empty($beerId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('beerId parameter must be set and not empty');
        }

        $args = array(
            'bid' => $beerId
        );

        return $this->_request('user/wishlist/add', $args, true);
    }

    /**
     * Removes a beer from the logged-in-user's wishlist
     *
     * @param int $beerId Untappd beer ID to remove
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function removeFromMyWishlist($beerId)
    {
        if (empty($beerId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('beerId parameter must be set and not empty');
        }

        $args = array(
            'bid' => $beerId
        );

        return $this->_request('user/wishlist/remove', $args, true);
    }

    /**
     * Lists any pending requests to become friends
     *
     */
    public function myPendingFriends()
    {
        $args = array();

        return $this->_request('user/pending', $args, true);
    }

    /**
     * Accepts a friend request from the user for the logged-in-user
     *
     * @param string $requestingUserId Untappd user ID
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function acceptMyFriendRequest($requestingUserId)
    {
        if (empty($requestingUserId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('requestingUserId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('friend/accept/' . $requestingUserId, $args, true);
    }

    /**
     * Rejects a friend request from the user for the logged-in-user
     *
     * @param string $requestingUserId Untappd user ID
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function rejectMyFriendRequest($requestingUserId)
    {
        if (empty($requestingUserId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('requestingUserId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('friend/reject/' . $requestingUserId, $args, true);
    }

    /**
     * Un-friends a user from the logged-in-user
     *
     * @param string $friendUserId Untappd user ID
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function removeMyFriend($friendUserId)
    {
        if (empty($friendUserId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('friendUserId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('friend/remove/' . $friendUserId, $args, true);
    }

    /**
     * Makes a friend requets from the logged-in-user to the user passed
     *
     * @param string $userId Untappd user ID
     */
    public function makeMyFriendRequest($userId)
    {
        if (empty($userId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('userId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('friend/request/' . $userId, $args, true);
    }

    /**
     * Gets a user's info
     *
     * @param string *optional* $username Untappd username
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function userInfo($username = '')
    {
        if ($username == '' && empty($this->_accessToken)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('username parameter or Untappd authentication parameters must be set.');
        }

        $args = array();

        return $this->_request('user/info/' . $username, $args);
    }

    /**
     * Gets a user's checkins
     *
     * @param string *optional* $username Untappd username
     * @param int *optional* $limit The number of results to return, max of 50, default is 25
     * @param int *optional* $offset offset within the dataset to move to
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function userFeed($username = '', $limit = '', $offset = '')
    {
        if ($username == '' && empty($this->_accessToken)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('username parameter or Untappd authentication parameters must be set.');
        }

        $args = array(
            'limit'  => $limit,
            'offset' => $offset
        );

        return $this->_request('user/checkins/' . $username, $args);
    }

    /**
     * Gets a user's distinct beer list
     *
     * @param string *optional* $username Untappd username
     * @param int *optional* $offset offset within the dataset to move to
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function userDistinctBeers($username = '', $offset = '', $sort = '')
    {
        if ($username == '' && empty($this->_accessToken)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('username parameter or Untappd authentication parameters must be set.');
        }

        $args = array(
            'offset' => $offset,
            'sort'   => $sort,
        );

        return $this->_request('user/beers/' . $username, $args);
    }

    /**
     * Gets a list of a user's friends
     *
     * @param string *optional* $username Untappd username
     * @param int *optional* $offset offset within the dataset to move to
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function userFriends($username = '', $offset = '', $limit = '')
    {
        if ($username == '' && empty($this->_accessToken)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('username parameter or Untappd authentication parameters must be set.');
        }

        $args = array(
            'offset' => $offset,
            'limit'  => $limit,
        );

        return $this->_request('user/friends/' . $username, $args);
    }

    /**
     * Gets a user's wish list
     *
     * @param string *optional* $username Untappd username
     * @param int *optional* $offset offset within the dataset to move to
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function userWishlist($username = '', $offset = '')
    {
        if ($username == '' && empty($this->_accessToken)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('username parameter or Untappd authentication parameters must be set.');
        }

        $args = array(
            'offset' => $offset
        );

        return $this->_request('user/wishlist/' . $username, $args);
    }


    /**
     * Gets a list of a user's badges they have won
     *
     * @param string *optional* $username Untappd username
     * @param string *optional* $offset The numeric offset that you what results to start
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function userBadge($username = '', $offset = '')
    {
        if ($username == '' && empty($this->_accessToken)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('username parameter or Untappd authentication parameters must be set.');
        }

        $args = array(
            'offset' => $offset,
        );

        return $this->_request('user/badges/' . $username, $args);
    }

    /**
     * Gets a beer's critical info
     *
     * @param int $beerId Untappd beer ID
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function beerInfo($beerId)
    {
        if (empty($beerId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('beerId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('beer/info/' . $beerId, $args);
    }

    /**
     * Searches Untappd's database to find beers matching the query string
     *
     * @param string $searchString query string to search
     * @param (name|count|*empty*) *optional* flag to sort the results
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function beerSearch($searchString, $sort = '')
    {
        if (empty($searchString)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('searchString parameter must be set and not empty');
        }

        if (!empty($sort) && ($sort != 'count' && $sort != 'name')) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('If set, sort can only be "count" or "name"');
        }

        $args = array(
            'q'      => $searchString,
            'sort'   => $sort
        );

        return $this->_request('search/beer', $args);
    }

    /**
     * Gets all checkins for a specified beer
     *
     * @param int $beerId Untappd ID of the beer to search for
     * @param int *optional* $since numeric ID of the latest checkin
     * @param int *optional* $offset offset within the dataset to move to
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function beerFeed($beerId, $since = '', $offset = '')
    {
        if (empty($beerId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('beerId parameter must be set and not empty');
        }

        $args = array(
            'since'  => $since,
            'offset' => $offset,
        );

        return $this->_request('beer/checkins/' . $beerId, $args);
    }

    /**
     * Gets information about a given venue
     *
     * @param int $venueId Untappd ID of the venue
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function venueInfo($venueId)
    {
        if (empty($venueId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('venueId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('venue/info/' . $venueId, $args);
    }

    /**
     * Gets all checkins at a given venue
     *
     * @param int $venueId Untappd ID of the venue
     * @param int *optional* $since numeric ID of the latest checkin
     * @param int *optional* $offset offset within the dataset to move to
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function venueFeed($venueId, $since = '', $offset = '', $limit = '')
    {
        if (empty($venueId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('venueId parameter must be set and not empty');
        }

        $args = array(
            'since'    => $since,
            'offset'   => $offset,
            'limit'    => $limit,
        );

        return $this->_request('venue/checkins/' . $venueId, $args);
    }

    /**
     * Gets all for beers of a certain brewery
     *
     * @param int $breweryId Untappd ID of the brewery
     * @param int *optional* $maxId The checkin ID that you want the results to start with
     * @param int *optional* $minId The numeric ID of the most recent check-in. New results will only be shown if there are checkins before this ID
     * @param int *optional* $limit The number of results to return, max of 50, default is 25
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function breweryFeed($breweryId, $maxId = '', $minId = '', $limit = '')
    {
        if (empty($breweryId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('breweryId parameter must be set and not empty');
        }

        $args = array(
            'max_id' => $maxId,
            'min_id' => $minId,
            'limit'  => $limit,
        );

        return $this->_request('brewery/checkins/' . $breweryId, $args);
    }

    /**
     * Gets the basic info for a brewery
     *
     * @param int $breweryId Untappd brewery ID
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function breweryInfo($breweryId)
    {
        if (empty($breweryId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('breweryId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('brewery/info/' . $breweryId, $args);
    }

    /**
     * Searches for all the breweries based on a query string
     *
     * @param string $searchString search term to search breweries
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function brewerySearch($searchString)
    {
        if (empty($searchString)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('searchString parameter must be set and not empty');
        }

        $args = array(
            'q' => $searchString
        );

        return $this->_request('search/brewery', $args);
    }

    /**
     * Gets the public feed of checkings, also known as "the pub"
     *
     *@ param int *optional* $since numeric ID of the latest checkin
     * @param int *optional* $offset offset within the dataset to move to
     * @param float *optional* $longitude longitude to filter public feed
     * @param float *optional* $latitude latitude to filter public feed
     * @param int *optional* $radius radius from the lat and long to filter feed
     * @param int *optional* $limit  The number of results to return, max of 50, default is 25
     */
    public function publicFeed($since = '', $offset = '', $longitude = '', $latitude = '', $radius = '', $limit = '')
    {
        $args = array(
            'since'  => $since,
            'offset' => $offset,
            'lng' => $longitude,
            'lat' => $latitude,
            'radius' => $radius,
            'limit'  => $limit,
        );

        if ($longitude != "" && $latitude != "") {
          return $this->_request('thepub/local', $args);
        }
        else {
         return $this->_request('thepub', $args);
        }

    }

    /**
     *
     * Gets the trending list of beers based on location
     *
     * @param (all|macro|micro|local) *optional* $type Type of beers to search for
     * @param float *optional* $latitude Numeric latitude to filter the feed
     * @param float *optional* $longitude Numeric longitude to filter the feed
     * @param int *optional* $radius Radius in miles from the long/lat points
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function publicTrending($type = 'all', $latitude = '', $longitude = '', $radius = '')
    {
        $validTypes = array('all', 'macro', 'micro', 'local');
        if (!in_array($type, $validTypes)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('Type parameter must be one of the following: ' . implode(', ', $validTypes));
        }

        $args = array(
            'type'   => $type,
            'lat'    => $latitude,
            'lng'    => $longitude,
            'radius' => $radius
        );

        return $this->_request('beer/trending', $args);
    }

    /**
     * Gets the details of a specific checkin
     *
     * @param int $checkinId Untappd checkin ID
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function checkinInfo($checkinId)
    {
        if (empty($checkinId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('checkinId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('checkin/view/' . $checkinId, $args);
    }

    /**
     * Perform a live checkin
     *
     * @param int $gmtOffset - Hours the user is away from GMT
     * @param int $beerId - Untappd beer ID
     * @param string *optional* $foursquareId - MD5 hash ID of the venue to check into
     * @param float *optional* $userLat - Latitude of the user.  Required if you add a location.
     * @param float *optional* $userLong - Longitude of the user.  Required if you add a location.
     * @param string *optional* $shout - Text to include as a comment
     * @param boolean *optional* $facebook - Whether or not to post to facebook
     * @param boolean *optional* $twitter - Whether or not to post to twitter
     * @param boolean *optional* $foursquare - Whether or not to checkin on foursquare
     * @param int *optional* $rating - Rating for the beer
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function checkin($gmtOffset, $timezone, $beerId, $foursquareId = '', $userLat = '', $userLong = '', $shout = '', $facebook = false, $twitter = false, $foursquare = false, $rating = '')
    {
        if (empty($gmtOffset)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('gmtOffset parameter must be set and not empty');
        }

        if (empty($timezone)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('timezone parameter must be set and not empty');
        }

        if (empty($beerId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('beerId parameter must be set and not empty');
        }

        // If $foursquareId is set, must past Lat and Long to the API
        if (!empty($foursquareId) && (empty($userLat) || empty($userLong))) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('userLat and userLong parameters required since foursquareId is set');
        }

        if (!empty($rating) && (!is_int($rating) || $rating < 1 || $rating > 5)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('If set, rating must be an integer between 1 and 5');
        }

        $args = array(
            'gmt_offset'    => $gmtOffset,
            'timezone'      => $timezone,
            'bid'           => $beerId,
            'foursquare_id' => $foursquareId,
            'user_lat'      => $userLat,
            'user_long'     => $userLong,
            'shout'         => $shout,
            'facebook'      => ($facebook) ? 'on' : 'off',
            'twitter'       => ($twitter) ? 'on' : 'off',
            'foursquare'    => ($foursquare) ? 'on' : 'off',
            'rating_value'  => $rating
        );

        return $this->_request('checkin/add', $args, true);
    }

    /**
     * Adds a comment to a specific checkin
     *
     * @param int $checkinId - Checkin to comment on
     * @param string $comment - Comment to add to the checkin
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function checkinComment($checkinId, $comment)
    {
        if (empty($checkinId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('checkinId parameter must be set and not empty');
        }

        if (empty($comment)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('comment parameter must be set and not empty');
        }

        $args = array(
            'comment' => $comment,
        );

        return $this->_request('checkin/addcomment/' . $checkinId, $args, true);
    }

    /**
     * Remove a comment from a checkin
     *
     * @param int $commentId
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function checkinRemoveComment($commentId)
    {
        if (empty($commentId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('commentId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('checkin/deletecomment/' . $commentId, $args, true);
    }

    /**
     * Toast a checkin
     *
     * @param int $checkinId
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function checkinToast($checkinId)
    {
        if (empty($checkinId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('checkinId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('checkin/toast/' . $checkinId, $args, true);
    }

    /**
     * Remove a toast from a checkin
     *
     * @param int $checkinId
     *
     * @throws Pintlabs_Service_Untappd_Exception
     */
    public function checkinRemoveToast($checkinId)
    {
        if (empty($checkinId)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('checkinId parameter must be set and not empty');
        }

        $args = array();

        return $this->_request('checkin/toast/' . $checkinId, $args, true);
    }

    /**
     * Sends a request using curl to the required URI
     *
     * @param string $method Untappd method to call
     * @param array $args key value array or arguments
     *
     * @throws Pintlabs_Service_Untappd_Exception
     *
     * @return stdClass object
     */
    protected function _request($method, $args, $requireAuth = false)
    {
        $this->_lastRequestUri = null;
        $this->_lastRawResponse = null;
        $this->_lastParsedResponse = null;

        if ($requireAuth) {
            if (empty($this->_accessToken)) {
                require_once __DIR__.'/Service/Untappd/Exception.php';
                throw new Pintlabs_Service_Untappd_Exception('This method requires an access token');
            }
        }

        if (!empty($this->_accessToken)) {            
            $args['access_token'] = $this->_accessToken;
        } else {
            // Append the API key to the args passed in the query string
            $args['client_id'] = $this->_clientId;
            $args['client_secret'] = $this->_clientSecret;
        }

        // remove any unnecessary args from the query string
        foreach ($args as $key => $a) {
            if ($a == '') {
                unset($args[$key]);
            }
        }

        if (preg_match('/^http/i', $method)) {
            $this->_lastRequestUri = $method;
        } else {
            $this->_lastRequestUri = self::URI_BASE . '/' . $method;
        }

        $this->_lastRequestUri .= '?' . http_build_query($args);

        // Set curl options and execute the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_lastRequestUri);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $this->_lastRawResponse = curl_exec($ch);

        if ($this->_lastRawResponse === false) {

            $this->_lastRawResponse = curl_error($ch);
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('CURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        // Response comes back as JSON, so we decode it into a stdClass object
        $this->_lastParsedResponse = json_decode($this->_lastRawResponse);

            
        // If the http_code var is not found, the response from the server was unparsable
        if (!isset($this->_lastParsedResponse->meta->code) && !isset($this->_lastParsedResponse->meta->http_code)) {
            require_once __DIR__.'/Service/Untappd/Exception.php';
            throw new Pintlabs_Service_Untappd_Exception('Error parsing response from server.');
        }

        $code = (isset($this->_lastParsedResponse->meta->http_code)) ? $this->_lastParsedResponse->meta->http_code : $this->_lastParsedResponse->meta->code;
                            
        // Server provides error messages in http_code and error vars.  If not 200, we have an error.
        if ($code != '200') {
            require_once __DIR__.'/Service/Untappd/Exception.php';
                        
            $errorMessage = (isset($this->_lastParsedResponse->meta->error_detail)) ? $this->_lastParsedResponse->meta->error_detail : $this->_lastParsedResponse->meta->error;            
        
            throw new Pintlabs_Service_Untappd_Exception('Untappd Service Error ' .
                $code . ': ' .  $errorMessage);
        }

        return $this->getLastParsedResponse();
    }

    /**
     * Gets the last parsed response from the service
     *
     * @return null|stdClass object
     */
    public function getLastParsedResponse()
    {
        return $this->_lastParsedResponse;
    }

    /**
     * Gets the last raw response from the service
     *
     * @return null|json string
     */
    public function getLastRawResponse()
    {
        return $this->_lastRawResponse;
    }

    /**
     * Gets the last request URI sent to the service
     *
     * @return null|string
     */
    public function getLastRequestUri()
    {
        return $this->_lastRequestUri;
    }
}
?>
