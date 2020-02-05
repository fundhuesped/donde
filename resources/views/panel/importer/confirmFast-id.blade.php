@extends('layouts.panel-import-master')
{!!Html::style('styles/import.min.css')!!}

@section('content')



<div class="container centrada">
<a> Todo listo! </a> 
<h3>Estos son los centros que intentarán ser importados</h3>
	
<!-- Actualizar ({{$cantidadActualizar}})  -->
	<h4 class="left-align mt-3"> <i class="mdi-navigation-arrow-drop-down"></i> <b translate="importer_confirmfastid_title_2" translate-values="{count: '{{$cantidadActualizar}}'}"></b></h4>

	<div class="row">
		<table class="striped responsive-table">
			<thead>
				<tr>
					<td> Id</td>
					<td translate="establishment"></td>
					<td translate="type"></td>
					<td translate="street_address"></td>
					<td translate="form_establishment_street_height"></td>
					<td translate="panel_places_columntable_5"></td>				
					<td translate="district"></td>
					<td translate="state"></td>
					<td translate="country"></td>
					<td> Latitud </td>
					<td> Longitud </td>
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
					<td class="text-center">{{$p['ciudad']}}</td>
					@if ( $p['provincia_region'] == "Ciudad Autónoma de Buenos Aires")
					<td class="text-center"> {{$p['barrio_localidad']}} </td>
					@else
					<td class="text-center"> {{$p['partido_comuna']}} </td>
					@endif
					<td class="text-center"> {{$p['provincia_region']}} </td>
					<td class="text-center"> {{$p['pais']}} </td>
					<td class="text-center"> {{$p['latitude']}} </td>
					<td class="text-center"> {{$p['longitude']}} </td>
				</tr>
				@endforeach
				@else
				<tr>
					<td class="text-center"> <em translate="importer_confirmfastid_notfoundlabel"></em> </td>
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


	<br>
	<br>
	<br>

</div>



<div class="row">
	<div class="col s6">
		<a href="{{ url('panel/importer') }}" class="waves-effect waves-light btn" style="margin-bottom: 5%;" translate="cancel"></a>
	</div>

	<div class="col s6">
		<a href="{{ url('panel/importer/results-id') }}" class="waves-effect waves-light btn green" translate="confirm"></a>
	</div>
</div>


@stop

@section('js')

@stop
