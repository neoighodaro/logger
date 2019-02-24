package com.example.androidloggerclient

import android.support.v4.content.ContextCompat
import android.support.v7.widget.RecyclerView
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView

class LoggerAdapter : RecyclerView.Adapter<LoggerAdapter.ViewHolder>() {

    private var logList = ArrayList<LogModel>()

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        return ViewHolder(LayoutInflater.from(parent.context)
                .inflate(R.layout.log_list_row, parent, false))
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) =
            holder.bind(logList[position])

    override fun getItemCount(): Int = logList.size

    fun addItem(model: LogModel) {
        this.logList.add(model)
        notifyDataSetChanged()
    }

    inner class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {

        private val logMessage = itemView.findViewById<TextView>(R.id.logMessage)!!
        private val logLevel = itemView.findViewById<TextView>(R.id.logLevel)!!

        fun bind(item: LogModel) = with(itemView) {

            logMessage.text = item.logMessage
            logLevel.text = item.logLevel

            when {
                item.logLevel.toLowerCase() == "warning" -> {
                    logLevel.setTextColor(ContextCompat.getColor(context, R.color.yellow))
                }
                item.logLevel.toLowerCase() == "error" -> {
                    logLevel.setTextColor(ContextCompat.getColor(context, android.R.color.holo_red_dark))
                }
                item.logLevel.toLowerCase() == "info" -> {
                    logLevel.setTextColor(ContextCompat.getColor(context, android.R.color.holo_blue_light))

                }
            }


        }

    }


}

