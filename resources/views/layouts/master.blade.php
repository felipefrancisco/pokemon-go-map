<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico?v=1" type="image/x-icon">
    <title>
        @section('title')
            Pokémon GO World Map
        @show
    </title>

    <!-- for Google -->
    <meta name="description" content="This is a colaborative map tool created to help players find their favorite Pokémon around the world while playing Pokémon GO." />
    <meta name="keywords" content="pokemon, pokemon go, map, maps, world map" />

    <meta name="author" content="Felipe Francisco" />
    <meta name="copyright" content="Luminary Software" />
    <meta name="application-name" content="felipefrancisco/pokemon-go-map" />

    <!-- for Facebook -->
    <meta property="og:title" content="Pokémon GO World Map" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://www.pokemon-map.com/" />
    <meta property="og:description" content="This is a colaborative Pokémon GO Map tool created to help players find their favorite Pokémon location around the world." />
    <meta property="og:image" content="https://s3-us-west-2.amazonaws.com/pgo-static/pokemon/39.png" />
    <meta name="fb:app_id" content="1046226322098947" />

    <!-- for Twitter -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="Pokémon GO World Map" />
    <meta name="twitter:description" content="This is a colaborative Pokémon GO Map tool created to help players find their favorite Pokémon location around the world." />

    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="960529190271-8n3efjq2ac0d089e1m2mp9urdfkphh9e.apps.googleusercontent.com">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='css/app.css?v={{ $version }}' rel='stylesheet' type='text/css'>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-80658905-1', 'auto');
        ga('send', 'pageview');

        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1046226322098947',
                xfbml      : true,
                version    : 'v2.7',
                oauth      : true
            });
        };

        window.smartlook||(function(d) {
            var o=smartlook=function(){ o.api.push(arguments)},s=d.getElementsByTagName('script')[0];
            var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
            c.charset='utf-8';c.src='//rec.getsmartlook.com/bundle.js';s.parentNode.insertBefore(c,s);
        })(document);

        smartlook('init', '13e11ba1846b8ed5fb638229fc133f88a3fd2b72');

    </script>

    <script src="js/priority/jquery-1.12.0.min.js"></script>
    <script src="js/priority/angular.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDqndoEzmHSTeoIiPSapHa3_4DEKlJ3Fk&libraries=places,geometry"></script>
    <script src="js/priority/bootstrap.min.js" async defer></script>
    <script src="js/priority/platform.js" async defer></script>

</head>
<body ng-app="app">

    @yield('content')

    @if(getenv('APP_ENV') == 'production')
    <script src="js/app.js?v={{ $version }}"></script>
    @else
    <script src="js/compiled.js?v={{ $version }}"></script>
    @endif

    <div id="fb-root"></div>
    <script>
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        window.twttr = (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                    t = window.twttr || {};
            if (d.getElementById(id)) return t;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);

            t._e = [];
            t.ready = function(f) {
                t._e.push(f);
            };

            return t;
        }(document, "script", "twitter-wjs"));
    </script>

</body>
</html>