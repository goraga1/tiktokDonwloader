<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
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

            button {
                margin-top: 25px;
                background-color: #1d68a7;
                border: none;
                color: #fff;
                padding: 10px 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                cursor: pointer;
            }

            button:hover {
                opacity: 0.5;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            input {
                width: 100%;
                padding: 8px;
                color: #757575;
                border-radius: 3px;
                border: 1px solid #ccc;
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Tiktok video concater
                </div>

                <form action="/" method="POST">
                    {{ csrf_field() }}

                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>
                    <div><input type="text" name="urls[]" value=""></div>

                    <button type="submit">Download</button>
                </form>
            </div>
        </div>
    </body>
</html>
