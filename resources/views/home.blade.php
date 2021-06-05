@extends('layouts.master')
@section('meta')
<title>donde.huesped.org.ar | Fundación Huésped</title>
<meta name="google-site-verification" content="RQh3eES_sArPYfFybCM87HsV6mbwmttWlAIk-Upf1EQ" />

<meta name="author" content="Fundación Huésped">
<link rel="canonical" href="https://donde.huesped.org.ar/"/>
<link rel="shortcut icon" href="/favicon.png" type="image/png" />

<meta property='og:title' content="@lang('site.page_title')" />
<meta property="og:description" content="@lang('site.seo_meta_description_content')" />
<meta property='og:type' content="@lang('site.page_title')" />
<meta property='og:locale' content='es_LA'/>
<meta property='og:url' content='https://donde.huesped.org.ar/'/>
<meta property='og:site_name' content='DONDE'/>
<meta property='og:image' content='https://donde.huesped.org.ar/og.png'/>
<meta property='fb:app_id' content='1964173333831483' />
<meta name="twitter:card" content="summary">
<meta name='twitter:title' content="@lang('site.page_title')" />
<meta name="twitter:description" content="@lang('site.seo_meta_description_content')" />
<meta name='twitter:url' content='https://donde.huesped.org.ar/'/>
<meta name='twitter:image' content='https://donde.huesped.org.ar/og.png'/>
<meta name='twitter:site' content='@fundhuesped' />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
@stop

@section('content')
<div ng-app="dondev2App">
  @include('navbar')
  <!-- MAP -->
  <div class="row">
    <div class="view" ng-view autoscroll="true"></div>
    <div class="map" ng-controller="mapController">
      <div ng-cloak class="wow fadeIn fadeInRight">
        <ng-map id="mainMap" default-style="true">
        </ng-map>
      </div>
    </div>
  </div>
  @include('acerca')
</div>
@stop

@section('js')
{{-- Includes --}}
{!!Html::script('bower_components/materialize/dist/js/materialize.min.js')!!}
{!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}
{!!Html::script('bower_components/angularjs-socialshare/dist/angular-socialshare.min.js')!!}
{!!Html::script('bower_components/angular-recaptcha/release/angular-recaptcha.js')!!}
{!!Html::script('bower_components/ng-text-truncate/ng-text-truncate.js')!!}
{!!Html::script('bower_components/angular-translate/angular-translate.js')!!}
{{-- Translates --}}
{!!Html::script('scripts/translations/es.js')!!}
{!!Html::script('scripts/translations/br.js')!!}
{!!Html::script('scripts/translations/en.js')!!}
{{-- AngularJs --}}
{!!Html::script('scripts/home/app.js')!!}
{!!Html::script('scripts/home/controllers/home/controller.js')!!}
{!!Html::script('scripts/home/controllers/acerca/controller.js')!!}
{!!Html::script('scripts/home/controllers/city-list/controller.js')!!}
{!!Html::script('scripts/home/controllers/city-map/controller.js')!!}
{!!Html::script('scripts/home/controllers/city-map/controller2.js')!!}
{!!Html::script('scripts/home/controllers/locate-list/controller.js')!!}
{!!Html::script('scripts/home/controllers/locate-map/controller.js')!!}
{!!Html::script('scripts/home/controllers/map/controller.js')!!}
{!!Html::script('scripts/home/controllers/location/controller.js')!!}
{!!Html::script('scripts/home/controllers/suggest-location/controller.js')!!}
{!!Html::script('scripts/home/controllers/party-list/controller.js')!!}
{!!Html::script('scripts/home/controllers/evaluation/controller.js')!!}
{!!Html::script('scripts/home/controllers/name-list/controller.js')!!}
{!!Html::script('scripts/home/controllers/name-map/controller.js')!!}
{{-- Servicios --}}
{!!Html::script('scripts/services/places.js')!!}
{!!Html::script('scripts/services/copy.js')!!}
{!!Html::script('scripts/services/geolibs.js')!!}
{!!Html::script('scripts/services/stringOps.js')!!}
<script>
  $(document).ready(function() {
    $('select').material_select();
  });
</script>
@stop
