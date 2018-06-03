<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{  csrf_token()   }}">

        {{-- These are pwa stuff --}}
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('iphone.png') }}">

        <link href="{{ URL::asset('iphonesplash.png') }}" sizes="1125x2436" rel="apple-touch-startup-image" />


        <link href="{{ URL::asset('manifest.json') }}" rel="manifest">

        {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> --}}
      


        <script>window.Laravel = { csrfToken: '{{  csrf_token()   }}'}
        </script> 

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        
        <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">

        <title>Larticles App</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        


       

        <!-- Styles -->

    </head>
    <body>
        <div id="app">
            <navbar></navbar>
               <div class="container">
                  <articles></articles>
               </div>     
        </div>

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script>


      <script src="{{ asset('js/app.js') }}"></script>

    </body>
</html>