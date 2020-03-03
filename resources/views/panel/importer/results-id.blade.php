@extends('layouts.panel-import-master')
{!!Html::style('styles/import.min.css')!!}

@section('content')

<a>Resultados</a>

<div class="container centrada">
	<h3>
		Todo listo! Estos son los centros que hemos importado
	</h3>
	<h4 class="left-align mt-3">
		<i class="mdi-navigation-arrow-drop-down"></i> <b>Actualizar ({{count($datosActualizar)}}) </b>
	</h4>

	<div class="row">
		<table class="striped responsive-table">
			<thead>
				<tr>
					<td> Id </td>
					<td> Establecimiento</td>
					<td> Tipo </td>
					<td> Calle </td>
					<td> Altura </td>
					<td> Partido_comuna </td>
					<td> Provincia_region </td>
					<td> Pais </td>
					<td> Latitud </td>
					<td> Longitud </td>
					<td> Aprobado </td>
				</tr>
			</thead>
			<tbody>
				@if (count($datosActualizar) > 0 )
				@foreach ($datosActualizar as $p)
				<tr>
					<td class="text-center"> {{$p['placeId']}} </td>
					<td class="text-center"> {{$p['establecimiento']}} </td>
					<td class="text-center"> {{$p['tipo']}} </td>
					<td class="text-center"> {{$p['calle']}} </td>
					<td class="text-center"> {{$p['altura']}} </td>
					@if ( $p['provincia_region'] == "Ciudad Autónoma de Buenos Aires")
					<td class="text-center"> {{$p['barrio_localidad']}} </td>
					@else
					<td class="text-center"> {{$p['partido_comuna']}} </td>
					@endif
					<td class="text-center"> {{$p['provincia_region']}} </td>
					<td class="text-center"> {{$p['pais']}} </td>
					<td class="text-center"> {{$p['latitude']}} </td>
					<td class="text-center"> {{$p['longitude']}} </td>
					<td class="text-center"> {{$p['aprobado']}} </td>
				</tr>
				@endforeach
				@else
				<tr>
					<td class="text-center"> <em>No se encontraron datos nuevos en su dataset.</em> </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
             {{-- ========================================================================= --}}
    <br>
    @if (count($datosActualizar) > 0 )
    <div class="row">
      <div class="col s3 offset-s10"><a href="{{ url('panel/importer/actualizar') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a></div>
    </div>
    @endif
           {{-- ========================================================================= --}}
           {{-- ========================================================================= --}}

   	<h3 class="mt-3">
		Estos son los centros que NO hemos importado
	</h3>
	<h4 class="left-align mt-3">
		<i class="mdi-navigation-arrow-drop-down"></i> <b>Id no existente, Malos datos de Geo, 'tipo' no identificado o 'aprobado' incorrecto  ({{count($datosIncompletos)}}) </b>
	</h4>

	<div class="row">
		<table class="striped responsive-table">
			<thead>
				<tr>
					<td> Id </td>
					<td> Establecimiento</td>
					<td> Tipo </td>
					<td> Calle </td>
					<td> Altura </td>
					<td> Partido_comuna </td>
					<td> Provincia_region </td>
					<td> Pais </td>
					<td> Latitud </td>
					<td> Longitud </td>
					<td> Aprobado </td>
				</tr>
			</thead>
			<tbody>
				@if (count($datosIncompletos) > 0 )
				@foreach ($datosIncompletos as $p)
				<tr>
					<td class="text-center"> {{$p['placeId']}} </td>
					<td class="text-center"> {{$p['establecimiento']}} </td>
					<td class="text-center"> {{$p['tipo']}} </td>
					<td class="text-center"> {{$p['calle']}} </td>
					<td class="text-center"> {{$p['altura']}} </td>
					@if ( $p['provincia_region'] == "Ciudad Autónoma de Buenos Aires")
					<td class="text-center"> {{$p['barrio_localidad']}} </td>
					@else
					<td class="text-center"> {{$p['partido_comuna']}} </td>
					@endif
					<td class="text-center"> {{$p['provincia_region']}} </td>
					<td class="text-center"> {{$p['pais']}} </td>
					<td class="text-center"> {{$p['latitude']}} </td>
					<td class="text-center"> {{$p['longitude']}} </td>
					<td class="text-center"> {{$p['aprobado']}} </td>
				</tr>
				@endforeach
				@else
				<tr>
					<td class="text-center"> <em>No se encontraron datos nuevos en su dataset.</em> </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
					<td class="text-center">  </td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
             {{-- ========================================================================= --}}
    <br>
    @if (count($datosIncompletos) > 0 )
    <div class="row">
      <div class="col s3 offset-s10"><a href="{{ url('panel/importer/sin-actualizar') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a></div>
    </div>
    @endif
           {{-- ========================================================================= --}}


	<br>
	<br>
	<br>


</div>



{{-- Buttons --}}
<div class="container ">
    <div class="col s12">
        <div class="row col s12 center">
            <a href="{{ url('panel/importer') }}" class="waves-effect waves-light btn">Volver al importador</a>
        </div>
        <br>
        <br>
        <br>
        <div class="row col s12 center">
            <a href="{{ url('panel') }}" class="waves-effect waves-light btn" style="margin-bottom: 5%;">Volver al panel </a>
        </div>
    </div>
</div>    
{{-- Buttons End --}}

@stop

@section('js')

@stop