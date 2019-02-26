
import Foundation
import UIKit

class TableCell: UITableViewCell {
    
    @IBOutlet weak var labelLogMessage: UILabel!
    @IBOutlet weak var imageLogLevel: UIImageView!
    
    
    func setValues(item:LogModel) {

        labelLogMessage.text = item.logMessage
        
        imageLogLevel.image = UIImage(named:"LogLevel")!.withRenderingMode(.alwaysTemplate)
        
        if(item.logLevel=="warning"){
            imageLogLevel.tintColor = UIColor.yellow
            
        } else if(item.logLevel=="info"){
            imageLogLevel?.tintColor = UIColor.blue

        } else if (item.logLevel=="error"){
            imageLogLevel.tintColor = UIColor.red
        }
        
    }
    
}
