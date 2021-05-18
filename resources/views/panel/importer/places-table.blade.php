@isset($datos)
<div class="row">
	<table class="striped responsive-table">
		<thead>
			<tr>
				<td>Id</td>
				<td style="min-width: 15em;">Nombre establecimiento</td>
				<td style="min-width: 8em;">Tipo</td>
				<td>Calle</td>
				<td>Altura</td>
				<td>Barrio/Localidiad</td>
				<td>Ciudad</td>
				<td>Partido</td>
				<td>Provincia</td>
				<td>Pais</td>
				<td>Latitud</td>
				<td>Longitud</td>
				<td>Aprobado</td>
				<td style="min-width: 9em;">Servicios</td>
			</tr>
		</thead>
		<tbody>
			@if (count($datos) > 0 )
			@foreach ($datos as $p)
			<tr>
				<td>{{$p['placeId']}}</td>
				<td>
					@include('panel.importer.table-field', ['err' => $p['error_repetidos'], 'data' => $p['establecimiento'] ,'err_info' => 'Establecimiento ingresado repetido/unificable. Verifique'])
				</td>
				<td>{{$p['tipo']}}</td>
				<td>{{$p['calle']}}</td>
				<td>{{$p['altura']}}</td>
				<td>{{$p['barrio_localidad']}}</td>
				<td>{{$p['ciudad']}}</td>
				<td>{{$p['partido_comuna']}}</td>
				<td>{{$p['provincia_region']}}</td>
				<td>{{$p['pais']}}</td>
				<td>{{$p['latitude']}}</td>
				<td>{{$p['longitude']}}</td>
				<td class="text-center">{{$p['aprobado']}}</td>
				<td class="services2">
					<img ng-show="{{ $p['condones'] && !$p['friendly_condones'] }}" title="Este lugar distribuye preservativos" src="/images/condones.png">
					<img ng-show="{{ $p['friendly_condones'] }}" title="Este lugar distribuye preservativos" src="/images/condones_friendly.png">
					<img ng-show="{{ $p['prueba'] && !$p['friendly_prueba'] }}" title="Este lugar puede hacer prueba de HIV" src="/images/prueba.png">
					<img ng-show="{{ $p['friendly_prueba'] }}" title="Este lugar puede hacer prueba de HIV" src="/images/prueba_friendly.png">
					<img ng-show="{{ $p['vacunatorio'] && !$p['friendly_vacunatorio'] }}" title="Este lugar cuenta con centro vacunatorio" src="/images/vacunatorio.png">
					<img ng-show="{{ $p['friendly_vacunatorio'] }}" title="Este lugar cuenta con centro vacunatorio" src="/images/vacunatorio_friendly.png">
					<img ng-show="{{ $p['infectologia'] && !$p['friendly_infectologia'] }}" title="Este lugar cuenta con centro de infectologia" src="/images/infectologia.png">
					<img ng-show="{{ $p['friendly_infectologia'] }}" title="Este lugar cuenta con centro de infectologia" src="/images/infectologia_friendly.png">
					<img ng-show="{{ $p['ile'] && !$p['friendly_ile'] }}" title="Este lugar cuenta con test rapido" src="/images/ile.png">
					<img ng-show="{{ $p['friendly_ile'] }}" title="Este lugar cuenta con test rapido" src="/images/ile_friendly.png">
					<img ng-show="{{ $p['ssr'] && !$p['friendly_ssr'] }}" title="Este lugar cuenta con servicios de salud sexual y reproductiva" src="/images/ssr.png">
					<img ng-show="{{ $p['friendly_ssr'] }}" title="Este lugar cuenta con servicios de salud sexual y reproductiva" src="/images/ssr_friendly.png">
					<img ng-show="{{ $p['es_rapido'] }}" title="Este lugar distribuye D.I.U" src="/images/es_rapido.png">
					<img ng-show="{{ $p['es_anticonceptivos'] }}" title="Este lugar distribuye D.I.U" src="/images/es_anticonceptivos.png">
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td><em translate="importer_confirmfastid_notfoundlabel"></em></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>				
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>		
			@endif
		</tbody>
	</table>
</div>
@endisset