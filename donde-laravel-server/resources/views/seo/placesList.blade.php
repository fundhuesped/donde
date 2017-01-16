@extends('layouts.clear')
@section('meta')

<title> Fundación Huésped -  ¿#Donde {{$resu['titleCopySeo']}} en {{$pais}}. {{$provincia}}, {{$partido}}? </title>
<meta name="description" content="Encuentra {{$resu['descriptionCopy']}} en {{$pais}}. {{$provincia}}, {{$partido}}">
<meta name="author" content="Fundación Huésped">
<link rel="canonical" href="https://www.huesped.org.ar/donde/"/>
<meta property='og:locale' content='es_LA'/>
<meta property='og:title' content='donde.huesped.org.ar | Fundación Huésped'/>
<meta property="og:description" content="Encuentra {{$resu['descriptionCopy']}} en {{$pais}}. {{$provincia}}, {{$partido}}" />

@stop

@section('content')

 <nav>
    <div class="nav-wrapper">
      <a href="{{ url('/#/') }}" class="brand-logo"><img class="logoTop" src="/images/HUESPED_logo_donde_RGB-07_cr.png"> </a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <ul class="right hide-on-med-and-down">
           <li><a class="modal-trigger" href="#modal1"><i class="mdi-action-info"></i></a></li>
           <li><a class="modal-trigger" href="/#/localizar/all/listado"><i class="mdi-maps-place left"></i></a></li>
           <li><a class="" href="/form"><i class="mdi-content-add-circle-outline"></i></a></li>
           <li><a class="" href="/listado-paises"><i class="mdi-action-language"></i></a></li>
      </ul>
      
      <ul ng-show="navigating"  class="left wow fadeIn">
           <li style="width: 120px;"><a href="" onclick="window.history.back();"> <i class="mdi-navigation-chevron-left left"></i><span>Volver</span></a></li>
      </ul>

      <ul class="side-nav" id="mobile-demo">
          <li><a href="#/acerca">
            <i class="mdi-action-info left"></i>Información
            </a>
          </li>
          <li><a href="#/localizar/all/listado">
            <i class="mdi-maps-place left"></i>Cercanos</a></li>
          <li><a href="form">
            <i class="mdi-content-add-circle-outline left"></i>
            Sugerir</a>
          </li>

      </ul>
    </div>
  </nav>







@if (count($places) > 0 )
  <div class="result-seo">
    <div class="Aligner">
    @if ( count($places) < 2 )
      <b>Hemos encontrado {{$cantidad}} {{$resu['titleCopySingle']}}</b>
    @else
      <b>Hemos encontrado {{$cantidad}} {{$resu['titleCopyMultiple']}}</b>
    @endif
    </div>


    <div class="Aligner">
      <div class="Aligner-item Aligner-item--top"><img width="50px" src="/images/{{$resu['icon']}}"></div>
      <div class="Aligner-item">
        <span class="text-seo"><b>En {{$partido}}</span>, <span class="text-seo">{{$provincia}}</span></b>
      </div>
    </div>

</div>

<div class="container">
	<table class="striped" >
		<thead>
			<th>Dirección</th>
			<th>Lugar</th>
			<th>Horario</th>
			<th>Responsable</th>
			<th>Teléfono</th>
		</thead>
		<tbody>     
			@foreach ($places as $p)
			<tr>
        @if (isset($p->altura) && ($p->altura != "" ) && ($p->altura != " " ) )  
            <td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->calle}}, {{$p->altura}}</a></td>
        @else
				  <td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->calle}}</a></td>
        @endif

				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->establecimiento}}</a></td>
				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->horario}}</a></td>
				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->responsable}}</a></td>
				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->telefono}}</a></td>
			</tr>	
			@endforeach
		</tbody>

	</table>
</div>

@else 
  <div class="result-seo">
    <div class="Aligner">
      <b>{{$resu['titleCopyNotFound']}}</b>
    </div>

    <div class="Aligner">
      <div class="Aligner-item Aligner-item--top"><img width="50px" src="/images/{{$resu['icon']}}"></div>
      <div class="Aligner-item">
        <span class="text-seo"><b>En {{$partido}}</span>, <span class="text-seo">{{$provincia}}</span></b>
      </div>
    </div>


</div>
{{--  --}}
<div class="container option-seo">
	<div class="centrada-seo">
		<a href="{{ url('listado-paises') }}" class="waves-effect waves-light btn btn-seo">
			<i class="mdi-navigation-chevron-right right"></i>
			<i class="mdi-action-search left"></i>Nueva búsqueda</a>
		</div>

		<div class="centrada-seo">
			<a href="{{ url('/form') }}" class="waves-effect waves-light btn btn-seo">
				<i class="mdi-navigation-chevron-right right"></i>
				<i class="mdi-content-add-circle left"></i>Sugerir lugar</a>
			</div>	
		</div>
@endif


@include('acerca')

@stop