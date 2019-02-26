
import UIKit
import PusherSwift

class ViewController: UITableViewController {
    
    var logMessageList = [LogModel]() {
        didSet {
            self.tableView.reloadData()
        }
    }
    var pusher:Pusher!
    

    override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return logMessageList.count
    }
    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let currentItem = logMessageList[indexPath.row]
        let logCell = tableView.dequeueReusableCell(withIdentifier: "logCell") as! TableCell
        logCell.setValues(item: currentItem)
        return logCell
    }
    
    override func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return 50
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setupPusher()
    }
    
    func setupPusher(){
        
        let options = PusherClientOptions(
            host: .cluster("eu")
        )
        
        pusher = Pusher(
            key: "c20ac810e445d88d5d95",
            options: options
        )
        
        let channel = pusher.subscribe("log-channel")
        
        let _ = channel.bind(eventName: "log-event", callback: { (data: Any?) -> Void in
            if let data = data as? [String : AnyObject] {
                let logModel = LogModel()
                logModel.logLevel = data["loglevel"] as? String
                logModel.logMessage = data["message"] as? String
                self.logMessageList.append(logModel)
            }
        })
        pusher.connect()
    }
    
    

}

