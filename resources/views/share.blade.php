@extends('layouts.master')
@section('meta')
    
    <?php 
        \App::setlocale($lang);
    ?>

    <title>donde.huesped.org.ar | Fundación Huésped</title>
    <meta name="description" content="{{$p->establecimiento}} en {{$p->nombre_ciudad}}, {{$p->calle}} {{$p->altura}}  ">
    <meta name="author" content="Fundación Huésped">
    <link rel="canonical" href="https://donde.huesped.org.ar"/>
    <meta property='og:locale' content='es_LA'/>
    <meta property='og:title' content='donde.huesped.org.ar | Fundación Huésped'/>
    <meta property="og:description" ccontent="{{$p->establecimiento}} en {{$p->nombre_ciudad}}, {{$p->calle}} {{$p->altura}}  ">
    <meta property='og:url' content='https://donde.huesped.org.ar'/>
    <meta property='og:site_name' content="Fundación Huésped"/>
    <meta property='og:type' content='website'/>
    <meta property='og:image' content='https://donde.huesped.org.ar/og.png'/>
    <meta property='fb:app_id' content='288554014895839' />
    <meta name="twitter:card" content="summary">
    <meta property="og:description" content="@lang('site.seo_meta_description_content')" />
    <meta name="twitter:description" content="{{$p->establecimiento}} en {{$p->nombre_ciudad}}, {{$p->calle}} {{$p->altura}}  ">
    <meta name='twitter:url' content='https://donde.huesped.org.ar/share/es/{{$p->placeId}} '/>
    <meta name='twitter:image' content='{!! $p->image !!}'/>
    <meta name='twitter:site' content='@fundhuesped' />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

@stop

@section('content')

@stop


@section('js')
    <script>
    var url = "../../#/detail/es/"+{{$p->placeId}};
        console.log("{{$p->establecimiento}}");
        console.log("{{$p->nombre_pais}}");
        console.log("{{$p->placeId}}");
      document.location.href=url;
    </script>
@stop
