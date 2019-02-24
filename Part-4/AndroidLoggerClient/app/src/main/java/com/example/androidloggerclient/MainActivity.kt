package com.example.androidloggerclient

import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.support.v7.widget.LinearLayoutManager
import com.pusher.client.Pusher
import com.pusher.client.PusherOptions
import com.pusher.pushnotifications.PushNotifications
import kotlinx.android.synthetic.main.activity_main.*
import org.json.JSONObject


class MainActivity : AppCompatActivity() {

    private val mAdapter = LoggerAdapter()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        setupRecyclerView()
        setupPusher()
        setupPusherBeams()
    }

    private fun setupRecyclerView() {
        with(recyclerView){
            layoutManager = LinearLayoutManager(this@MainActivity)
            adapter = mAdapter
        }

    }

    private fun setupPusher() {
        val options = PusherOptions()
        options.setCluster("eu")
        val pusher = Pusher("PUSHER_CHANNELS_API_KEY", options)

        val channel = pusher.subscribe("log-channel")

        channel.bind("log-event") { channelName, eventName, data ->
            println(data)
            val jsonObject = JSONObject(data)
            val model = LogModel(jsonObject.getString("message"), jsonObject.getString("loglevel"))
            runOnUiThread {
                mAdapter.addItem(model)
            }
        }

        pusher.connect()
    }

    private fun setupPusherBeams(){

        PushNotifications.start(applicationContext, "PUSHER_BEAMS_INSTANCE_ID")
        PushNotifications.subscribe("log-interest")
    }
}
