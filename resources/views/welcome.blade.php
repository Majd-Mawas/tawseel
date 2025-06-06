<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Tawseel - Food Delivery</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href="{{ asset('css/welcome.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Yesteryear&display=swap" rel="stylesheet">
    <script src="{{ asset('js/welcome.js') }}"></script>
</head>

<body>
    <div id="first_page" style="display: block;">
        <h2 class="logo">Tawseel</h2>
        <P class="para"> WELCOME TO OUR ONLINE ORDERING SHOP</P>
        <div class="loader">
            <div class="loading-bar-background">
                <div class="loading-bar">
                    <div class="white-bars-container">
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                        <div class="white-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="second_page" style="display: none;">
        <h2 class="logo">Tawseel</h2>
        <div class="buttons">
            <div class="first_button">
                <a href="{{ route('login') }}"><button class="c-button c-button--gooey">SIGN IN
                        <div class="c-button__blobs">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </button>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
                        <defs>
                            <filter id="goo">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                                <feColorMatrix in="blur" mode="matrix"
                                    values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo">
                                </feColorMatrix>
                                <feBlend in="SourceGraphic" in2="goo"></feBlend>
                            </filter>
                        </defs>
                    </svg>
                </a>
            </div>
            <br>
            <div class="second_button">
                <a href="{{ route('register') }}"> <button class="c-button--gooey">SIGN UP
                        <div class="c-button__blobs">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </button>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display: block; height: 0; width: 0;">
                        <defs>
                            <filter id="goo">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                                <feColorMatrix in="blur" mode="matrix"
                                    values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo">
                                </feColorMatrix>
                                <feBlend in="SourceGraphic" in2="goo"></feBlend>
                            </filter>
                        </defs>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
