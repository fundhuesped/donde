@extends('layouts.master')
@section('meta')
<title>Sugiere un Nuevo Centro - @lang('site.page_title')</title>
<meta name="google-site-verification" content="RQh3eES_sArPYfFybCM87HsV6mbwmttWlAIk-Upf1EQ" >
<meta name="description" content="@lang('site.seo_meta_description_content')">
<meta name="author" content="IPPF">
<link rel="canonical" href="https://donde.huesped.org.ar/">
<meta property='og:locale' content='es_LA'>
<meta property='og:title' content="@lang('site.page_title')" >
<meta property="og:description" content="@lang('site.seo_meta_description_content')" >
<meta property='og:url' content=''>
<link rel="shortcut icon" href="favicon.png" type="image/png" />
<meta property='og:site_name' content='DÓNDE'>
<meta property='og:type' content="@lang('site.page_title')" >
<meta property='og:image' content='https://donde.huesped.org.ar/og.png'>
<meta property='fb:app_id' content='1964173333831483' >
<meta name="twitter:card" content="summary">
<meta name='twitter:title' content="@lang('site.page_title')" >
<meta name="twitter:description" content="@lang('site.seo_meta_description_content')" >
<meta name='twitter:url' content='"https://donde.huesped.org.ar/'>
<meta name='twitter:image' content='https://donde.huesped.org.ar/og.png'>
<meta name='twitter:site' content='@fundhuesped' >
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

@stop

@section('content')
<div ng-app="dondev2App">
  @include('navbar')

  <!-- BACK -->
  <ul  class="left wow fadeIn nav-wrapper" style="visibility: visible; animation-name: fadeIn; position: absolute; top: 0; left:0;">
    <li><a style='color: white;' href="" onclick="window.history.back();"><i class="mdi-navigation-chevron-left right" style="font-size: 2rem;"></i></a></li>
  </ul>

  <!-- START FORM -->
  <div class="home new-home" ng-controller="formController">
    <!-- INPUT LIST -->
    <div class="section search search-form row">
      <h1 translate="suggest_place"></h1>
      <p translate="form_intro_text"></p>

      <form class="col s12 m6">
        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <input required pattern="\S+.*" id="establecimiento" type="text" name="establecimiento" class="validate" ng-model="place.establecimiento"
            ng-change="formChange()" required>
            <label for="establecimiento">[[ 'form_establishment_name' | translate ]]</label>
          </div>
        </div>

        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <select required id="tipo" class="form-type-select" name="tipo" class="validate" ng-model="place.tipo"
            ng-change="formChange()">
                <option value="" disabled selected>[[ 'form_establishment_type' | translate ]]*</option>
                <option value="[[ 'public_health_center' | translate ]]" translate="public_health_center"></option>
                <option value="[[ 'public_hospital' | translate ]]" translate="public_hospital"></option>
                <option value="[[ 'public_organism' | translate ]]" translate="public_organism"></option>
                <option value="[[ 'social_organization' | translate ]]" translate="social_organization"></option>
                <option value="[[ 'educational_establishment' | translate ]]" translate="educational_establishment"></option>
                <option value="[[ 'private' | translate ]]" translate="private"></option>
                <option value="[[ 'ffaa_sec_dependent' | translate ]]" translate="ffaa_sec_dependent"></option>
                <option value="[[ 'other' | translate ]]" translate="other"></option>
            </select>
          </div>
        </div>
        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
 <!-- LOCATION -->
        <angucomplete-alt id="ciudad"
        required
        match-class="highlight"
        field-required="true"
        placeholder="[[ 'city_autocomplete' | translate ]]*"
        
        selected-object="updateAddressComponents"
        input-changed="updatePlacePredictions"
        local-data="placesPredictions"
        title-field="description"
        search-fields="description"
        focus-out="locationOut()"
        required pattern="\S+.*"
        input-class="form-control form-control-small validate required"
        text-no-results="[[ 'autocomplete_no_result' | translate ]]"
        text-searching="[[ 'autocomplete_searching' | translate ]]"
        autocomplete="new-password"
        >
        </angucomplete-alt>  
         <label for="ciudad_value"  data-error="mmmm" data-success="">[[ 'city_autocomplete' | translate ]]<span ng-show="">*</span></label>
                


          </div>
          <div class="input-field col s12">
            <input id="calle" type="text"
            name="calle" class="validate" required pattern="\S+.*"
            ng-model="place.calle" ng-change="formChange()">
            <label for="calle">[[ 'form_establishment_street' | translate ]]*
            </label>
          </div>
        </div>
        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <input id="altura" type="text" name="altura" class="validate" ng-model="place.altura" ng-change="formChange()" required pattern="[0-9]{1,10}" >
            <label for="altura">[[ 'form_establishment_street_height' | translate ]]*</label>
          </div>
        </div>
        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <input id="cruce" type="text" name="cruce" class="validate" ng-model="place.cruce" ng-change="formChange()">
            <label for="cruce" translate="form_establishment_street_intersection"></label>
          </div>
        </div>
        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <input id="piso_dpto" type="text"
            name="piso_dpto" class="validate"
            ng-model="place.piso_dpto" ng-change="formChange()">
            <label for="piso_dpto" translate="form_establishment_floor"></label>
          </div>
        </div>

        

        <div class="col s12">
          <label>[[ 'select_establishment_services' | translate ]]*</label>
        </div>

        <!-- CONDOMS CARD -->
        <div class="form-checkbox-cards">
          <input  type="checkbox"
          name="place.condones"
          id="filled-in-box-condones"
          ng-checked="isChecked(place.condones)"
          ng-model="place.condones" ng-change="formChange()"/>
          <label for="filled-in-box-condones" translate="form_select_condones"></label>
        </div>

        <!-- VIH TEST CARD -->
        <div class="form-checkbox-cards">
          <input  type="checkbox"
          name="place.prueba"
          id="filled-in-box-prueba"
          ng-checked="isChecked(place.prueba)"
          ng-model="place.prueba" ng-change="formChange()"/>
          <label for="filled-in-box-prueba" translate="form_prueba_option"></label>
        </div>

        <!-- FAST VIH TEST CARD -->
        <div class="form-checkbox-cards">
          <input  type="checkbox"
          name="place.pruebaRapida"
          id="filled-in-box-pruebaRapida"
          ng-checked="isChecked(place.pruebaRapida)"
          ng-model="place.pruebaRapida" ng-change="formChange()"/>
          <label for="filled-in-box-pruebaRapida" translate="form_prueba_rapida_option"></label>
        </div>

        <!-- VACUNATORIO CARD -->
        <div class="form-checkbox-cards">
          <input  type="checkbox"
          name="place.vacunatorio"
          id="filled-in-box-vacunatorio"
          ng-checked="isChecked(place.vacunatorio)"
          ng-model="place.vacunatorio" ng-change="formChange()"/>
          <label for="filled-in-box-vacunatorio" translate="form_vac_option"></label>
        </div>

        <!-- INFECTOLOGIA DETECTION CARD -->
        <div class="form-checkbox-cards">
          <input type="checkbox"
          name="place.infectologia"
          id="filled-in-box-infectologia"
          ng-checked="isChecked(place.infectologia)"
          ng-model="place.infectologia"  ng-change="formChange()"/>
          <label for="filled-in-box-infectologia" translate="form_infectologia_option"></label>
        </div>

        <!-- SSR CARD -->
        <div class="form-checkbox-cards">
          <input  type="checkbox"
          name="place.ssr"
          id="filled-in-box-ssr"
          ng-checked="isChecked(place.ssr)"
          ng-model="place.ssr" ng-change="formChange()"/>
          <label for="filled-in-box-ssr" translate="form_ssr_option"></label>
        </div>

        <!-- ILE CARD -->
        <div class="form-checkbox-cards">
          <input  type="checkbox"
          name="place.ile"
          id="filled-in-box-ile"
          ng-checked="isChecked(place.ile)"
          ng-model="place.ile" ng-change="formChange()"/>
          <label for="filled-in-box-ile" translate="form_ile_option"></label>
        </div>

        <!-- PERSONAL INFORMATION -->
        <div class="row">
          <div class="col s12">
              <h4 class="form-section-title" translate="personal_info"></h4>
          </div>
        </div>
        <div class="col s12">
          <label>[[ 'form_enter_personal_data' | translate ]]*</label>
        </div>

        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <input id="name" type="text" required pattern="\S+.*"
            name="name" class="validate"
            ng-model="place.uploader_name" ng-change="formChange()">
            <label for="name">[[ 'name' | translate ]]*</label>
          </div>
        </div>

        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            
            <input id="email" required="" aria-required="true" type="email" name="email" class="validate" ng-model="place.uploader_email" ng-change="formChange()">
            <label for="email"  data-error="No te olvides de un mail!" data-success="">[[ 'email' | translate ]]<span ng-show="!place.uploader_tel">*</span></label>
          </div>
        </div>
        <!-- INPUT -->
        <div class="row">
          <div class="input-field col s12">
            <input id="uploader-tel" type="text" name="uploader-tel" class="validate" required pattern="\S+.*" ng-model="place.uploader_tel" ng-change="formChange()">
            <label for="uploader-tel">[[ 'tel' | translate ]]<span ng-show="!place.uploader_email">*</span></label>
          </div>
        </div>

        <!-- OBSERVATIONS -->
        <div class="row">
          <div class="input-field col s12">
            <textarea id="observacion" type="text"
            name="observacion"
            class="validate materialize-textarea" ng-model="place.observacion" ng-change="formChange()"></textarea>
            <label for="observacion" translate="form_observation_input"></label>
          </div>
        </div>

      </form>
      <!-- END LEFT SIDE FORM -->


      <!-- MAP EDITOR COMPONENT -->
      <div class="col s12 m6">
        <div class="row">
            <!-- LOOK UP LOCATION BUTTON -->
            <div class="valign-demo  valign-wrapper">
              <div class="valign full-width actions">
                <button class="waves-effect waves-light btn btn-large full btn-pin-geo"
                  ng-href=""
                  ng-click="lookupLocation()">
                </button>
              </div>
            </div>
            <label translate="form_gps_find"></label>

            <!-- INPUT LATITUDE LONGITUDE -->
            <input id="latitude" readonly type="text" name="latitude"
            class="validate" ng-model="place.latitude" ng-change="onLatLonInputChange()">
            <input id="longitude" readonly  type="text" name="longitude" class="validate" ng-model="place.longitude" ng-change="onLatLonInputChange()">

            <!-- PROGRESS BAR -->
            <div ng-cloak ng-show="waitingLocation">
              <div class="progress">
                <div class="indeterminate"></div>
              </div>
            </div>

            <!-- POSITION EDITOR [MAP] -->
            <ng-map id="mapEditor"
              lazy-init="true" zoom="14">
              <marker ng-repeat="pos in positions"
                position="[[pos.latitude]],[[pos.longitude]]"
                on-dragend="onDragEnd()"
                draggable="true">
              </marker>
            </ng-map>
          </div>
        </div>
    <!-- TERMS AND CONDITIONS CHECK -->
    <div class="row">
      <div class="input-field col s12">
        <p>
          <input type="checkbox" name="acepta_terminos"
          class="filled-in" id="terminosCheck"
          ng-change="formChange()"
          ng-model="aceptaTerminos"/>
          <label for="terminosCheck">
            <a href="terms" target="_blank" translate="terms_and_conditions1"></a> <span translate="terms_and_conditions2"></span></label>
          </p>
        </div>
      </div>
    </div>
    <!-- FORM BUTTON -->
    <div class="row">
      <div class="col s12 m5">
        <p></p>
      </div>
      <div class="col s12 m6">
        <div class="valign-demo  valign-wrapper">
          <div class="valign full-width actions">
            <button type="submit" class="waves-effect waves-light btn btn-large full"
            ng-href="" ng-click="clicky()">
            <div class="preloader-wrapper small active" ng-cloak ng-show="spinerflag">
              <div class="spinner-layer spinner-red-only">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
            <div class="" ng-cloak ng-show="!spinerflag" translate="send">
            </div>
          </button>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="landing-service-footer">
  <p translate="footer_text"></p>
</footer>
@stop

@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&key=AIzaSyBoXKGMHwhiMfdCqGsa6BPBuX43L-2Fwqs"></script>
<script src="https://www.google.com/recaptcha/api.js?hl=es-419&onload=vcRecaptchaApiLoaded&render=explicit" async defer>
</script>

{!!Html::script('bower_components/materialize/dist/js/materialize.min.js')!!}
{!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}
{!!Html::script('bower_components/angular-recaptcha/release/angular-recaptcha.min.js')!!}
{!!Html::script('bower_components/angular-translate/angular-translate.js')!!}
{!!Html::script('bower_components/angucomplete-alt/dist/angucomplete-alt.min.js')!!}
{!!Html::script('scripts/translations/es.js')!!}
{!!Html::script('scripts/translations/en.js')!!}
{!!Html::script('scripts/translations/br.js')!!}
{!!Html::script('scripts/form/app.js')!!}
{!!Html::script('scripts/form/controllers/form/controller.js')!!}
{!!Html::script('scripts/home/services/places.js')!!}

@stop
