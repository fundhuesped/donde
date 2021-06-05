<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProvinciaRESTController;
use App\Provincia;
use App\Places;
use App\PlaceLog;
use Validator;
use DB;
use App;

class NewPlacesRESTController extends Controller
{

    public function getParam($params, $key, $default ='')
    {
        // Get all of our request params

        return ( (

          !isset($params[$key])) || empty($params[$key]))
        ? $default : $params[$key];
    }

    public function parseTipo($request): Request{
      $index = (int) $request['tipo'];
      $tipos = App::make('App\Http\Controllers\ImportadorController')->placeTypes;
      
      if(isset($index) && $index < count($tipos))
        $request['tipo'] = $tipos[$index];
      else
        $request['tipo'] = null;

      return $request;
    }

    public function autocorrectOptServices($request){
      $optServices = App::make('App\Http\Controllers\ImportadorController')->placeOptServices;
      
      foreach ($optServices as $optService => $mainService) {
        if($request[$optService] == true && $request[$mainService] == false){
          $request[$mainService] = true;
        }
      }

      return $request;
    }

    public function hasServices($request){
      $mainServices = App::make('App\Http\Controllers\ImportadorController')->placeMainServices;

      foreach ($mainServices as $key => $service) {
        if($request[$service] == true){
          $request['hasServices'] = true;
          break;
        }
      }

      return $request;
    }


    /**
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      $request = $this->parseTipo($request);
      $request = $this->autocorrectOptServices($request);
      $request = $this->hasServices($request);
      $request_params = $request->all();

      $rules = array(
        'establecimiento' => 'required|max:150|min:3',
        'nombreCiudad' => 'required',
        'tipo' => 'required',
        'calle' => 'required',
        'altura' => 'required',
        'hasServices' => 'required',
        'uploader_name' => 'required',
        'uploader_email' => 'required_without:uploader_tel',
        'uploader_tel' => 'required_without:uploader_email',
      );

      $messages = array(
       'required'         => 'El :attribute es requerido.',
       'required_without' => 'El :attribute es requerido cuando :values no esta presente.',
       'max'              => 'El :attribute debe poseer un maximo de :max caracteres.',
       'min'              => 'El :attribute debe poseer un minimo de :min caracteres.'
      );

      $validator = Validator::make($request_params,$rules,$messages);
      $params = $request_params;

      if ($validator->passes ()){
        $placeLog = new PlaceLog;
        $placeLog->entry_type = "sugerido";
        $placeLog->modification_date = date("Y-m-d");
        $placeLog->save();

        $place = new Places;
        $place->establecimiento = $this->getParam($params,'establecimiento');
        $place->calle = $this->getParam($params,'calle');
        $place->tipo = $this->getParam($params,'tipo');
        $place->altura = $this->getParam($params,'altura');
        $place->piso_dpto = $this->getParam($params,'piso_dpto');
        $place->observacion = $this->getParam($params,'observacion');
        $place->cruce = $this->getParam($params,'cruce');
        $place->latitude = $this->getParam($params,'latitude');
        $place->longitude = $this->getParam($params,'longitude');
        $place->barrio_localidad = $this->getParam($params,'barrio_localidad');


        $place->condones = $this->getParam($params,'condones',false);
        $place->responsable_distrib = $this->getParam($params,'responsable_distrib');
        $place->ubicacion_distrib = $this->getParam($params,'ubicacion_distrib');
        $place->horario_distrib = $this->getParam($params,'horario_distrib');
        $place->mail_distrib = $this->getParam($params,'mail_distrib');
        $place->tel_distrib = $this->getParam($params,'tel_distrib');
        $place->web_distrib = $this->getParam($params,'web_distrib');
        $place->comentarios_distrib = $this->getParam($params,'comentarios_distrib');

        $place->prueba = $this->getParam($params,'prueba',false);
        $place->es_rapido = $this->getParam($params,'es_rapido',false);
        $place->responsable_testeo = $this->getParam($params,'responsable_testeo');
        $place->ubicacion_testeo = $this->getParam($params,'ubicacion_testeo');
        $place->horario_testeo = $this->getParam($params,'horario_testeo');
        $place->mail_testeo = $this->getParam($params,'mail_testeo');
        $place->tel_testeo = $this->getParam($params,'tel_testeo');
        $place->web_testeo = $this->getParam($params,'web_testeo');
        $place->observaciones_testeo = $this->getParam($params,'observaciones_testeo');

        $place->infectologia = $this->getParam($params,'infectologia',false);
        $place->responsable_infectologia = $this->getParam($params,'responsable_infectologia');
        $place->ubicacion_infectologia = $this->getParam($params,'ubicacion_infectologia');
        $place->horario_infectologia = $this->getParam($params,'horario_infectologia');
        $place->mail_infectologia = $this->getParam($params,'mail_infectologia');
        $place->tel_infectologia = $this->getParam($params,'tel_infectologia');
        $place->web_infectologia = $this->getParam($params,'web_infectologia');
        $place->comentarios_infectologia = $this->getParam($params,'comentarios_infectologia');

        $place->vacunatorio = $this->getParam($params,'vacunatorio',false);
        $place->responsable_vac = $this->getParam($params,'responsable_vac');
        $place->ubicacion_vac = $this->getParam($params,'ubicacion_vac');
        $place->horario_vac = $this->getParam($params,'horario_vac');
        $place->mail_vac = $this->getParam($params,'mail_vac');
        $place->tel_vac = $this->getParam($params,'tel_vac');
        $place->web_vac = $this->getParam($params,'web_vac');
        $place->comentarios_vac = $this->getParam($params,'comentarios_vac');

        $place->mac = $this->getParam($params,'mac',false);
        $place->responsable_mac = $this->getParam($params,'responsable_mac');
        $place->ubicacion_mac = $this->getParam($params,'ubicacion_mac');
        $place->horario_mac = $this->getParam($params,'horario_mac');
        $place->mail_mac = $this->getParam($params,'mail_mac');
        $place->tel_mac = $this->getParam($params,'tel_mac');
        $place->web_mac = $this->getParam($params,'web_mac');
        $place->comentarios_mac = $this->getParam($params,'comentarios_mac');

        $place->ile = $this->getParam($params,'ile',false);
        $place->responsable_ile = $this->getParam($params,'responsable_ile');
        $place->ubicacion_ile = $this->getParam($params,'ubicacion_ile');
        $place->horario_ile = $this->getParam($params,'horario_ile');
        $place->mail_ile = $this->getParam($params,'mail_ile');
        $place->tel_ile = $this->getParam($params,'tel_ile');
        $place->web_ile = $this->getParam($params,'web_ile');
        $place->comentarios_ile = $this->getParam($params,'comentarios_ile');

        $place->dc = $this->getParam($params,'dc',false);
        $place->responsable_dc = $this->getParam($params,'responsable_dc');
        $place->ubicacion_dc = $this->getParam($params,'ubicacion_dc');
        $place->horario_dc = $this->getParam($params,'horario_dc');
        $place->mail_dc = $this->getParam($params,'mail_dc');
        $place->tel_dc = $this->getParam($params,'tel_dc');
        $place->web_dc = $this->getParam($params,'web_dc');
        $place->comentarios_dc = $this->getParam($params,'comentarios_dc');

        $place->ssr = $this->getParam($params,'ssr',false);
        $place->es_anticonceptivos = $this->getParam($params,'es_anticonceptivos',false);
        $place->responsable_ssr = $this->getParam($params,'responsable_ssr');
        $place->ubicacion_ssr = $this->getParam($params,'ubicacion_ssr');
        $place->horario_ssr = $this->getParam($params,'horario_ssr');
        $place->mail_ssr = $this->getParam($params,'mail_ssr');
        $place->tel_ssr = $this->getParam($params,'tel_ssr');
        $place->web_ssr = $this->getParam($params,'web_ssr');
        $place->comentarios_ssr = $this->getParam($params,'comentarios_ssr');

        $place->aprobado = 0;


        $nombre_pais = $this->getParam($params,'nombrePais');
        $nombre_provincia = $this->getParam($params,'nombreProvincia');
        $nombre_partido = $this->getParam($params,'nombrePartido');
        $nombre_ciudad = $this->getParam($params,'nombreCiudad');

        // =============================================================================
        // ID PAIS
        // =============================================================================
        $place->idPais = DB::table('pais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->value('id');

        //si no existe
        if ( !$place->idPais ){
            $place->idPais = DB::table('pais')->max('id') + 1;
            DB::table('pais')->insert([
                'id' => $place->idPais,
                'nombre_pais' => $nombre_pais,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }

        // =============================================================================
        // ID PROVINCIA
        // =============================================================================
        $place->idProvincia = DB::table('provincia')
        ->join('pais','pais.id','=','provincia.idPais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->where('provincia.nombre_provincia', '=', $nombre_provincia)
        ->value('provincia.id');

        //si no existe
        if ( !$place->idProvincia ){
            $place->idProvincia = DB::table('provincia')->max('id') + 1;
            DB::table('provincia')->insert([
                'id' => $place->idProvincia,
                'nombre_provincia' => $nombre_provincia,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'idPais'    => $place->idPais
            ]);
        }

        // =============================================================================
        // ID PARTIDO
        // =============================================================================
        $place->idPartido = DB::table('partido')
        ->join('provincia','provincia.id','=','partido.idProvincia')
        ->join('pais','pais.id','=','partido.idPais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->where('provincia.nombre_provincia', '=', $nombre_provincia)
        ->where('partido.nombre_partido', '=', $nombre_partido)
        ->value('partido.id');

        //si no existe
        if ( !$place->idPartido ){
            $place->idPartido = DB::table('partido')->max('id') + 1;
            DB::table('partido')->insert([
                'id' => $place->idPartido,
                'nombre_partido' => $nombre_partido,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'idPais'    => $place->idPais,
                'idProvincia'  => $place->idProvincia,
            ]);
        }
        // =============================================================================
        // ID CIUDAD
        // =============================================================================
        $place->idCiudad = DB::table('ciudad')
        ->join('partido','partido.id','=','ciudad.idPartido')
        ->join('provincia','provincia.id','=','ciudad.idProvincia')
        ->join('pais','pais.id','=','ciudad.idPais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->where('provincia.nombre_provincia', '=', $nombre_provincia)
        ->where('partido.nombre_partido', '=', $nombre_partido)
        ->where('ciudad.nombre_ciudad', '=', $nombre_ciudad)
        ->value('ciudad.id');

        //si no existe
        if ( !$place->idCiudad ){
            $place->idCiudad = DB::table('ciudad')->max('id') + 1;
            DB::table('ciudad')->insert([
                'id' => $place->idCiudad,
                'nombre_ciudad' => $nombre_ciudad,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'idPais'    => $place->idPais,
                'idProvincia'  => $place->idProvincia,
                'idPartido'  => $place->idPartido,
            ]);
        }

        /*Form uploader info*/
        $place->uploader_name = $this->getParam($params,'uploader_name');
        $place->uploader_email = $this->getParam($params,'uploader_email');
        $place->uploader_tel = $this->getParam($params,'uploader_tel');

        if ($this->getParam($params,'condones') && $this->getParam($params,'servicetype_condones')) $place->servicetype_condones =  $this->getParam($params,'servicetype_condones');
        if ($this->getParam($params,'prueba') && $this->getParam($params,'servicetype_prueba')) $place->servicetype_prueba =  $this->getParam($params,'servicetype_prueba');
        if ($this->getParam($params,'mac') && $this->getParam($params,'servicetype_mac')) $place->servicetype_mac =  $this->getParam($params,'servicetype_mac');
        if ($this->getParam($params,'ile') && $this->getParam($params,'servicetype_ile')) $place->servicetype_ile =  $this->getParam($params,'servicetype_ile');
        if ($this->getParam($params,'ssr') && $this->getParam($params,'servicetype_ssr')) $place->servicetype_ssr =  $this->getParam($params,'servicetype_ssr');
        if ($this->getParam($params,'dc') && $this->getParam($params,'servicetype_dc')) $place->servicetype_dc =  $this->getParam($params,'servicetype_dc');

        if ($this->getParam($params,'condones')) $place->friendly_condones =  $this->getParam($params,'friendly_condones');
        if ($this->getParam($params,'prueba')) $place->friendly_prueba =  $this->getParam($params,'friendly_prueba');
        if ($this->getParam($params,'vacunatorio')) $place->friendly_vacunatorio =  $this->getParam($params,'friendly_vacunatorio');
        if ($this->getParam($params,'infectologia')) $place->friendly_infectologia =  $this->getParam($params,'friendly_infectologia');
        if ($this->getParam($params,'ssr')) $place->friendly_ssr =  $this->getParam($params,'friendly_ssr');
        if ($this->getParam($params,'ile')) $place->friendly_ile =  $this->getParam($params,'friendly_ile');
        if ($this->getParam($params,'mac')) $place->friendly_mac =  $this->getParam($params,'friendly_mac');
        if ($this->getParam($params,'dc')) $place->friendly_dc =  $this->getParam($params,'friendly_dc');

        if (isset($request_params['otro_partido']))
        {
            if ($request_params['otro_partido'] != '')
            {
               $localidad_tmp =
               DB::table('partido')
                ->where('partido.idPais',$place->idPais)
                ->where('partido.idProvincia', $place->idProvincia)
                ->where('nombre_partido','=',$request_params['otro_partido'])
                ->select()
                ->get();



              if(count($localidad_tmp) === 0){
                  $localidad = new Partido;
                  $localidad->nombre_partido =
                    $request_params['otro_partido'];
                  $localidad->idProvincia = $place->idProvincia;
                  $localidad->idPais = $place->idPais;
                  $localidad->habilitado = true;
                  $localidad->updated_at = date("Y-m-d H:i:s");
                  $localidad->created_at = date("Y-m-d H:i:s");
                  $localidad->save();
                  $place->idPartido = $localidad->id;
              }else{
                  $place->idPartido = $localidad_tmp[0]->id;
              }
            }

        }
        $place->created_at = date("Y-m-d H:i:s");
        $place->updated_at = date("Y-m-d H:i:s");
        $place->logId = $placeLog->id;
        $place->save();
      }

      return $validator->messages();
    }

    /**
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeAR(Request $request)
    {
      $request_params = $request->all();

      $rules = array(
          'establecimiento' => 'required|max:150|min:2',
          'nombreCiudad' => 'required',
          'tipo' => 'required',
          'uploader_name' => 'required',
          'uploader_email' => 'required_without:uploader_tel',
          'uploader_tel' => 'required_without:uploader_email'
      );

     $messages = array(
         'required'     => 'El :attribute es requerido.',
         'max'          => 'El :attribute debe poseer un maximo de :max caracteres.',
         'min'          => 'El :attribute debe poseer un minimo de :min caracteres.'
     );

      $validator = Validator::make($request_params,$rules,$messages);
      $params = $request_params;
      if ($validator->passes ()){
        $placeLog = new PlaceLog;
        $placeLog->entry_type = "sugerido";
        $placeLog->modification_date = date("Y-m-d");
        $placeLog->save();

        $place = new Places;
        $place->establecimiento = $this->getParam($params,'establecimiento');
        $place->calle = $this->getParam($params,'calle');
        $place->tipo = $this->getParam($params,'tipo');
        $place->altura = $this->getParam($params,'altura');
        $place->piso_dpto = $this->getParam($params,'piso_dpto');
        $place->observacion = $this->getParam($params,'observacion');
        $place->cruce = $this->getParam($params,'cruce');
        $place->latitude = $this->getParam($params,'latitude');
        $place->longitude = $this->getParam($params,'longitude');
        $place->barrio_localidad = $this->getParam($params,'barrio_localidad');


        $place->condones = $this->getParam($params,'condones',false);
        $place->responsable_distrib = $this->getParam($params,'responsable_distrib');
        $place->ubicacion_distrib = $this->getParam($params,'ubicacion_distrib');
        $place->horario_distrib = $this->getParam($params,'horario_distrib');
        $place->mail_distrib = $this->getParam($params,'mail_distrib');
        $place->tel_distrib = $this->getParam($params,'tel_distrib');
        $place->web_distrib = $this->getParam($params,'web_distrib');
        $place->comentarios_distrib = $this->getParam($params,'comentarios_distrib');

        $place->prueba = $this->getParam($params,'prueba',false);
        $place->es_rapido = $this->getParam($params,'es_rapido',false);
        $place->responsable_testeo = $this->getParam($params,'responsable_testeo');
        $place->ubicacion_testeo = $this->getParam($params,'ubicacion_testeo');
        $place->horario_testeo = $this->getParam($params,'horario_testeo');
        $place->mail_testeo = $this->getParam($params,'mail_testeo');
        $place->tel_testeo = $this->getParam($params,'tel_testeo');
        $place->web_testeo = $this->getParam($params,'web_testeo');
        $place->observaciones_testeo = $this->getParam($params,'observaciones_testeo');

        $place->infectologia = $this->getParam($params,'infectologia',false);
        $place->responsable_infectologia = $this->getParam($params,'responsable_infectologia');
        $place->ubicacion_infectologia = $this->getParam($params,'ubicacion_infectologia');
        $place->horario_infectologia = $this->getParam($params,'horario_infectologia');
        $place->mail_infectologia = $this->getParam($params,'mail_infectologia');
        $place->tel_infectologia = $this->getParam($params,'tel_infectologia');
        $place->web_infectologia = $this->getParam($params,'web_infectologia');
        $place->comentarios_infectologia = $this->getParam($params,'comentarios_infectologia');

        $place->vacunatorio = $this->getParam($params,'vacunatorio',false);
        $place->responsable_vac = $this->getParam($params,'responsable_vac');
        $place->ubicacion_vac = $this->getParam($params,'ubicacion_vac');
        $place->horario_vac = $this->getParam($params,'horario_vac');
        $place->mail_vac = $this->getParam($params,'mail_vac');
        $place->tel_vac = $this->getParam($params,'tel_vac');
        $place->web_vac = $this->getParam($params,'web_vac');
        $place->comentarios_vac = $this->getParam($params,'comentarios_vac');

        $place->mac = $this->getParam($params,'mac',false);
        $place->responsable_mac = $this->getParam($params,'responsable_mac');
        $place->ubicacion_mac = $this->getParam($params,'ubicacion_mac');
        $place->horario_mac = $this->getParam($params,'horario_mac');
        $place->mail_mac = $this->getParam($params,'mail_mac');
        $place->tel_mac = $this->getParam($params,'tel_mac');
        $place->web_mac = $this->getParam($params,'web_mac');
        $place->comentarios_mac = $this->getParam($params,'comentarios_mac');

        $place->ile = $this->getParam($params,'ile',false);
        $place->responsable_ile = $this->getParam($params,'responsable_ile');
        $place->ubicacion_ile = $this->getParam($params,'ubicacion_ile');
        $place->horario_ile = $this->getParam($params,'horario_ile');
        $place->mail_ile = $this->getParam($params,'mail_ile');
        $place->tel_ile = $this->getParam($params,'tel_ile');
        $place->web_ile = $this->getParam($params,'web_ile');
        $place->comentarios_ile = $this->getParam($params,'comentarios_ile');

        $place->dc = $this->getParam($params,'dc',false);
        $place->responsable_dc = $this->getParam($params,'responsable_dc');
        $place->ubicacion_dc = $this->getParam($params,'ubicacion_dc');
        $place->horario_dc = $this->getParam($params,'horario_dc');
        $place->mail_dc = $this->getParam($params,'mail_dc');
        $place->tel_dc = $this->getParam($params,'tel_dc');
        $place->web_dc = $this->getParam($params,'web_dc');
        $place->comentarios_dc = $this->getParam($params,'comentarios_dc');

        $place->ssr = $this->getParam($params,'ssr',false);
        $place->responsable_ssr = $this->getParam($params,'responsable_ssr');
        $place->ubicacion_ssr = $this->getParam($params,'ubicacion_ssr');
        $place->horario_ssr = $this->getParam($params,'horario_ssr');
        $place->mail_ssr = $this->getParam($params,'mail_ssr');
        $place->tel_ssr = $this->getParam($params,'tel_ssr');
        $place->web_ssr = $this->getParam($params,'web_ssr');
        $place->comentarios_ssr = $this->getParam($params,'comentarios_ssr');

        $place->aprobado = 0;


        $nombre_pais = $this->getParam($params,'nombrePais');
        $nombre_provincia = $this->getParam($params,'nombreProvincia');
        $nombre_partido = $this->getParam($params,'nombrePartido');
        $nombre_ciudad = $this->getParam($params,'nombreCiudad');

        // =============================================================================
        // ID PAIS
        // =============================================================================
        $place->idPais = DB::table('pais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->value('id');

        //si no existe
        if ( !$place->idPais ){
            $place->idPais = DB::table('pais')->max('id') + 1;
            DB::table('pais')->insert([
                'id' => $place->idPais,
                'nombre_pais' => $nombre_pais,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }

        // =============================================================================
        // ID PROVINCIA
        // =============================================================================
        $place->idProvincia = DB::table('provincia')
        ->join('pais','pais.id','=','provincia.idPais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->where('provincia.nombre_provincia', '=', $nombre_provincia)
        ->value('provincia.id');

        //si no existe
        if ( !$place->idProvincia ){
            $place->idProvincia = DB::table('provincia')->max('id') + 1;
            DB::table('provincia')->insert([
                'id' => $place->idProvincia,
                'nombre_provincia' => $nombre_provincia,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'idPais'    => $place->idPais
            ]);
        }

        // =============================================================================
        // ID PARTIDO
        // =============================================================================
        $place->idPartido = DB::table('partido')
        ->join('provincia','provincia.id','=','partido.idProvincia')
        ->join('pais','pais.id','=','partido.idPais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->where('provincia.nombre_provincia', '=', $nombre_provincia)
        ->where('partido.nombre_partido', '=', $nombre_partido)
        ->value('partido.id');

        //si no existe
        if ( !$place->idPartido ){
            $place->idPartido = DB::table('partido')->max('id') + 1;
            DB::table('partido')->insert([
                'id' => $place->idPartido,
                'nombre_partido' => $nombre_partido,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'idPais'    => $place->idPais,
                'idProvincia'  => $place->idProvincia,
            ]);
        }
        // =============================================================================
        // ID CIUDAD
        // =============================================================================
        $place->idCiudad = DB::table('ciudad')
        ->join('partido','partido.id','=','ciudad.idPartido')
        ->join('provincia','provincia.id','=','ciudad.idProvincia')
        ->join('pais','pais.id','=','ciudad.idPais')
        ->where('pais.nombre_pais', '=', $nombre_pais)
        ->where('provincia.nombre_provincia', '=', $nombre_provincia)
        ->where('partido.nombre_partido', '=', $nombre_partido)
        ->where('ciudad.nombre_ciudad', '=', $nombre_ciudad)
        ->value('ciudad.id');

        //si no existe
        if ( !$place->idCiudad ){
            $place->idCiudad = DB::table('ciudad')->max('id') + 1;
            DB::table('ciudad')->insert([
                'id' => $place->idCiudad,
                'nombre_ciudad' => $nombre_ciudad,
                'habilitado' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'idPais'    => $place->idPais,
                'idProvincia'  => $place->idProvincia,
                'idPartido'  => $place->idPartido,
            ]);
        }

        /*Form uploader info*/
        $place->uploader_name = $this->getParam($params,'uploader_name');
        $place->uploader_email = $this->getParam($params,'uploader_email');
        $place->uploader_tel = $this->getParam($params,'uploader_tel');

        if ($this->getParam($params,'condones') && $this->getParam($params,'servicetype_condones')) $place->servicetype_condones =  $this->getParam($params,'servicetype_condones');
        if ($this->getParam($params,'prueba') && $this->getParam($params,'servicetype_prueba')) $place->servicetype_prueba =  $this->getParam($params,'servicetype_prueba');
        if ($this->getParam($params,'mac') && $this->getParam($params,'servicetype_mac')) $place->servicetype_mac =  $this->getParam($params,'servicetype_mac');
        if ($this->getParam($params,'ile') && $this->getParam($params,'servicetype_ile')) $place->servicetype_ile =  $this->getParam($params,'servicetype_ile');
        if ($this->getParam($params,'ssr') && $this->getParam($params,'servicetype_ssr')) $place->servicetype_ssr =  $this->getParam($params,'servicetype_ssr');
        if ($this->getParam($params,'dc') && $this->getParam($params,'servicetype_dc')) $place->servicetype_dc =  $this->getParam($params,'servicetype_dc');

        if ($this->getParam($params,'condones')) $place->friendly_condones =  $this->getParam($params,'friendly_condones');
        if ($this->getParam($params,'ile')) $place->friendly_ile =  $this->getParam($params,'friendly_ile');
        if ($this->getParam($params,'mac')) $place->friendly_mac =  $this->getParam($params,'friendly_mac');
        if ($this->getParam($params,'prueba')) $place->friendly_prueba =  $this->getParam($params,'friendly_prueba');
        if ($this->getParam($params,'ssr')) $place->friendly_ssr =  $this->getParam($params,'friendly_ssr');
        if ($this->getParam($params,'dc')) $place->friendly_dc =  $this->getParam($params,'friendly_dc');

        if (isset($request_params['otro_partido']))
        {
            if ($request_params['otro_partido'] != '')
            {
               $localidad_tmp =
               DB::table('partido')
                ->where('partido.idPais',$place->idPais)
                ->where('partido.idProvincia', $place->idProvincia)
                ->where('nombre_partido','=',$request_params['otro_partido'])
                ->select()
                ->get();



              if(count($localidad_tmp) === 0){
                  $localidad = new Partido;
                  $localidad->nombre_partido =
                    $request_params['otro_partido'];
                  $localidad->idProvincia = $place->idProvincia;
                  $localidad->idPais = $place->idPais;
                  $localidad->habilitado = true;
                  $localidad->updated_at = date("Y-m-d H:i:s");
                  $localidad->created_at = date("Y-m-d H:i:s");
                  $localidad->save();
                  $place->idPartido = $localidad->id;
              }else{
                  $place->idPartido = $localidad_tmp[0]->id;
              }
            }

        }
        $place->created_at = date("Y-m-d H:i:s");
        $place->updated_at = date("Y-m-d H:i:s");
        $place->logId = $placeLog->id;
        $place->save();

      }

      return $validator->messages();
    }



}
