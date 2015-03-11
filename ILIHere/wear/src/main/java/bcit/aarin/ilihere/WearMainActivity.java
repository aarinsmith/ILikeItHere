package bcit.aarin.ilihere;

import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.support.wearable.view.WatchViewStub;
import android.view.View;

import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.wearable.Node;
import com.google.android.gms.wearable.NodeApi;
import com.google.android.gms.wearable.Wearable;

import java.util.List;
import java.util.concurrent.TimeUnit;

public class WearMainActivity extends Activity
{
    private final int CONN_TIMEOUT = 10000;
    private final String PLACE_ID = "This must be the place";

    private GoogleApiClient client;
    private String nodeId;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_wear_main);

        startAPI();

        final WatchViewStub stub = (WatchViewStub) findViewById(R.id.watch_view_stub);

        stub.setOnLayoutInflatedListener(new WatchViewStub.OnLayoutInflatedListener()
        {
            @Override
            public void onLayoutInflated(WatchViewStub stub) {
                setButtonListener();
            }
        });
    }

    private GoogleApiClient getGoogleApiClient(Context context)
    {
        return new GoogleApiClient.Builder(context)
                .addApi(Wearable.API)
                .build();
    }

    private void startAPI()
    {
        client = getGoogleApiClient(this);
        getDevice();
    }


    private void getDevice()
    {

        new Thread(new Runnable() {
            @Override
            public void run() {
                client.blockingConnect(CONN_TIMEOUT, TimeUnit.MILLISECONDS);
                NodeApi.GetConnectedNodesResult result =
                        Wearable.NodeApi.getConnectedNodes(client).await();
                List<Node> nodes = result.getNodes();
                if (nodes.size() > 0) {
                    nodeId = nodes.get(0).getId();
                }
                client.disconnect();
            }
        }).start();
    }

    private void setButtonListener()
    {
        findViewById(R.id.ilihButton).setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v)
            {
                sendMessage();
            }
        });
    }

    private void sendMessage()
    {
        if( nodeId != null )
        {
            new Thread(new Runnable()
            {
                @Override
                public void run()
                {
                    client.blockingConnect(CONN_TIMEOUT, TimeUnit.MILLISECONDS);
                    Wearable.MessageApi.sendMessage(client, nodeId, PLACE_ID, null);
                    client.disconnect();
                }
            }).start();
        }
        else
        {
            System.out.println("No Connection");
        }
    }
}
