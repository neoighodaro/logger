
import UIKit
import PushNotifications

@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate {
    var window: UIWindow?
    let pushNotifications = PushNotifications.shared
    
    func application(_ application: UIApplication, didFinishLaunchingWithOptions launchOptions: [UIApplication.LaunchOptionsKey: Any]?) -> Bool {
        pushNotifications.start(instanceId: "BEAMS_INSTANCE_ID")
        pushNotifications.registerForRemoteNotifications()
        try? self.pushNotifications.subscribe(interest: "log-interest")
        return true
    }
    
    func application(_ application: UIApplication, didRegisterForRemoteNotificationsWithDeviceToken deviceToken: Data) {
        pushNotifications.registerDeviceToken(deviceToken)
    }
}
