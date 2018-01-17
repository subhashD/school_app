<!Doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style media="screen">
    .fa-asterisk {
      font-size: 7px;
      position: relative;
      top: -5px;
    }
  </style>
  @yield('style-content')
</head>
  <body>  
  <div class="main-panel">
      <!-- top header -->
      <div class="header navbar">
        <div class="brand visible-xs">
          <!-- toggle offscreen menu -->
          <div class="toggle-offscreen">
            <a href="javascript:;" data-toggle="offscreen" data-move="ltr">
              <span></span>
              <span></span>
              <span></span>
            </a>
          </div>
          <!-- /toggle offscreen menu -->
          <!-- logo -->
          <a class="brand-logo">
            
          </a>
          <!-- /logo -->
        </div>
        <ul class="nav navbar-nav hidden-xs">
          <li>
            <a href="javascript:;" class="small-sidebar-toggle ripple" data-toggle="layout-small-menu">
              <i class=""></i>
            </a>
          </li>
        </ul>
        
        <ul class="nav navbar-nav hidden-xs">
          <li>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">

          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                   {{Auth::user()->name}}<span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">

                  <li>
                      <a href=""
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Logout
                      </a>

                      <form id="logout-form" action="/logout" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  </li>
              </ul>
          </li>
        </ul>
      </div>

      <!--main content-->

      <div class="main-content">
        @if(Session::has('success'))
          <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-saved" aria-hidden="true"> <strong>Success:</strong> </span>
            {{ Session::get('success') }}
          </div>
          @endif

        @if(Session::has('error'))
          <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-alert" aria-hidden="true"> <strong>Error:</strong> </span>
            {{ Session::get('error') }}
          </div>
          @endif


          @if(!$errors->isEmpty())
          <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-alert" aria-hidden="true"><strong> Error:</strong></span>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
