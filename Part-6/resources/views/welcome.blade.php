
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Push Logger</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="style         sheet" type="text/css">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        <style>
            html,
            body {
                overflow-x: hidden; /* Prevent scroll on narrow devices */
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title m-b-md">
                Push Logger
            </div>

<div id="logs" class="row justify-content-md-center">      
    <pusher-logger> </pusher-logger>
</div> 
            
        </div>
        <script src="js/app.js"></script>

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>
  var pusher = new Pusher('c20ac810e445d88d5d95', {
    cluster: 'eu',
    forceTLS: true
  });
  
  // subscribe to the channel the log is broadcasted on
  var channel = pusher.subscribe('log-channel');
  
  // Subscribe to pushlogger event 
  channel.bind('log-event', function(log) {
    logs.push(log);
  });
</script>
<script>
    var logs = [];
    Vue.component('pusher-logger', {
        data() {
            return {
                logs,
            }
        },
        methods: {
            // Methods go here

checkLevel(loglevel) {
    switch(loglevel) {
        case 'info':
            return 'alert-info'
            break;
        case 'warning':
            return 'alert-warning'
            break;
        case 'error':
            return 'alert-danger'
            break;
        default:
            return 'alert-default'
    }
  }
        }, 
        
template: `
    <div class="col-lg-8">
      <div v-for="log in logs" class="alert" v-bind:class= "checkLevel(log.loglevel)"
       role="alert">
          @{{ log.message }}
      </div>  
      <div v-show="logs.length == 0">
          No Logs Dispatched
      </div>                              
    </div>
 `
    });
    
    new Vue({
      el: "#logs"
    })
</script>
    </body>
</html>