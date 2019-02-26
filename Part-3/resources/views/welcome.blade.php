<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
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

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    </head>
    <body>

        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                  Logger
                </div>

                <div class="button">
                    <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Trigger Log Message
                    </button>
                </div>
            </div>
        </div>

        @includeIf('partials.modal')

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

        <script>
            function dispatchLog() {
                let level = document.getElementById('level').value;
                let message = document.getElementById('message').value;

                let errToastr = () => toastr.error("Oops! An error encountered");

                axios.post('{{ route('log-message') }}', { message, level })
                    .then(r => r.data.status ? toastr.success('Log dispatch successful') : errToastr())
                    .catch(errToastr);
            }
        </script>
    </body>
</html>
