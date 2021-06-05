@extends('layouts.panel-master')

@section('content')
{{ csrf_field() }}
<div class="home panel" ng-controller="panelIndexController">
  <div class="row" >
    <div class="col s12">
      <ul class="tabs" tabs>
        <li class="tab col s3"><a class="active" href="#dashboard"><i class="small mdi-content-inbox"></i><span translate="summary"></span></a></li>

        <li class="tab col s3"><a class="" href="#pending"><i class="small mdi-content-inbox"></i><span translate="panel_tab_pending" translate-values="{pendings_lenght: '[[counters.pendientes]]'}"></span></a></li>

        <li class="tab col s3"><a href="#activos"> <i class="small mdi-action-done-all"></i><span translate="panel_tab_actives" translate-values="{actives_lenght: '[[counters.aprobados]]'}"></span></a></li>

        <li class="tab col s3"><a href="#rejected"> <i class="small mdi-action-delete  "></i><span translate="panel_tab_rejecteds" translate-values="{rejecteds_lenght: '[[counters.rechazados]]'}"></span></a></li>

        <li class="tab col s3"><a href="#imports"> <i class="small mdi-communication-import-export"></i><span translate="panel_tab_imports" translate-values="{imports_lenght: '[[counters.imports]]'}"></span></a></li>

        <li class="tab col s3"><a href="#eval"> <i class="small mdi-communication-comment"></i><span translate="evaluations" translate-values="{evaluations_length: '[[counters.evaluaciones]]'}"></span></a></li>
      </ul>
    </div>

    @include('panel/home/dashboard')
    @include('panel/home/aprobar')
    @include('panel/home/activos')
    @include('panel/home/desaprobados')
    @include('panel/home/importaciones')
    @include('panel/home/evaluaciones')

    <!-- Modal Structure -->
    <div id="demoModal" class="modal">
      <div class="modal-content">
        <h4 translate="panel_reject_place_modal_confirmation_1"></h4>
        <h3><strong>[[current.establecimiento]]</strong></h3>
        <h4><small>[[current.nombre_provincia]], [[current.nombre_localidad]]</small></h4>
        <hr/>
        <p translate="panel_reject_place_modal_confirmation_2"></p>
        <hr/>
      </div>
      <div class="modal-footer">
        <a href="" class=" modal-action modal-close
        waves-effect waves-green btn-flat" translate="no"></a>
        <a ng-click="removePlace()" href="" class=" modal-action waves-effect waves-green btn-flat" translate="yes"></a>
      </div>
    </div>

  </div>
</div>
@stop

@section('js')
{!!Html::script('bower_components/angucomplete-alt/dist/angucomplete-alt.min.js')!!}
{!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}

{!!Html::script('scripts/panel/app.js')!!}
{!!Html::script('scripts/panel/controllers/index/controller.js')!!}
{!!Html::script('scripts/panel/controllers/index/table-controller.js')!!}

{!!Html::script('scripts/services/places.js')!!}
{!!Html::script('scripts/services/copy.js')!!}
{!!Html::script('scripts/services/geolibs.js')!!}
{!!Html::script('scripts/services/stringOps.js')!!}
{!!Html::script('scripts/services/paginationTable.js')!!}
@stop
