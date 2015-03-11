package bcit.aarin.ilihere;

import android.location.Location;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.wearable.MessageEvent;
import com.google.android.gms.wearable.WearableListenerService;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by aarin on 10/03/15.
 */
public class MessageListener extends WearableListenerService implements
        GoogleApiClient.ConnectionCallbacks,
        GoogleApiClient.OnConnectionFailedListener,
        com.google.android.gms.location.LocationListener
{
    private final String TAG = "DEBUG: ";
    private HttpURLConnection conn;
    private String url;
    private GoogleApiClient mGoogleApiClient;
    private String lat;
    private String lng;
    private String latlong;
    private LocationRequest l;

    @Override
    public void onCreate()
    {
        super.onCreate();

        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this)
                .addApi(LocationServices.API)
                .build();

        mGoogleApiClient.connect();
        Log.d(TAG, "Created");
    }

    @Override
    public void onConnected(Bundle connectionHint)
    {
        Log.d( TAG, "Connecting");

        l = LocationRequest.create();
        l.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        l.setInterval(1000);

        LocationServices.FusedLocationApi.requestLocationUpdates(mGoogleApiClient, l, this);

        Log.d(TAG, "Connected");
    }

    @Override
    public void onConnectionSuspended( int i )
    {
    }

    @Override
    public void onConnectionFailed( ConnectionResult r )
    {
    }

    @Override
    public void onMessageReceived(MessageEvent messageEvent)
    {
        try
        {
            Thread.sleep(3000);
        }
        catch( InterruptedException e )
        {
            Log.d(TAG, "Could not sleep.");
        }

        if( latlong != null )
        {
            showToast(latlong);
        }
        else
        {
            showToast("Not Found");
        }

        getPlaceId();
    }

    public void onLocationChanged( Location location )
    {
        lat = String.valueOf(location.getLatitude());
        lng = String.valueOf(location.getLongitude());

        latlong = "Latitude: " + lat + " / Longitude: " + lng;
    }

    private void showToast(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }

    // Get the google place Id for a given lat/long pair
    private void getPlaceId()
    {
        String result;
        String placeId = "";
        JSONObject json;

        url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" + lat +
                "," + lng +"&radius=30&key=AIzaSyBRd2V8NbgsMXTkHIqiYdLH3yjGEuh5aI0";
        Log.d(TAG,url);

//        try {
//            URL requestUrl = new URL(url);
//        } catch( IOException e ) { Log.d(TAG, "Invalid URL"); }

        result = GET(url);

        try {
            json = new JSONObject(result);
            JSONArray j = json.getJSONArray("results");
            placeId = j.getJSONObject(0).getString("place_id");
        } catch(JSONException j) {
            Log.d( TAG, "JSON Didn't work");
        }

        Log.d( TAG, "POSTING " + placeId + " TO DB");

        postToDB("7", placeId);
    }

    // Post the placeId and userId to database to add new location.
    private void postToDB( String userId, String placeId)
    {
        HttpClient httpclient = new DefaultHttpClient();
        HttpPost httppost = new HttpPost("http://ilih.aarinsmith.com/addLocation");

        try {
            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
            nameValuePairs.add(new BasicNameValuePair("userId", userId));
            nameValuePairs.add(new BasicNameValuePair("placeId", placeId));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            httpclient.execute(httppost);
        } catch( Exception e ) {
            Log.d( TAG, "Encoding error");
        }
    }

    // USING DEPRECATED METHODS TO RETRIEVE JSON BECAUSE I CAN.
    public static String GET(String url){
        InputStream inputStream = null;
        String result = "";
        try {

            // create HttpClient
            HttpClient httpclient = new DefaultHttpClient();

            // make GET request to the given URL
            HttpResponse httpResponse = httpclient.execute(new HttpGet(url));

            // receive response as inputStream
            inputStream = httpResponse.getEntity().getContent();

            // convert inputstream to string
            if(inputStream != null)
                result = convertInputStreamToString(inputStream);
            else
                result = "Did not work!";

        } catch (Exception e) {
            Log.d("InputStream", e.getLocalizedMessage());
        }

        return result;
    }

    private static String convertInputStreamToString(InputStream inputStream) throws IOException{
        BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(inputStream));
        String line = "";
        String result = "";
        while((line = bufferedReader.readLine()) != null)
            result += line;

        inputStream.close();
        return result;

    }

}
