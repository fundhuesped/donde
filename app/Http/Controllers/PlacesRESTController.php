<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProvinciaRESTController;
use App\Evaluation;
use App\Provincia;
use App\Partido;
use App\Places;
use App\Ciudad;
use App\PlaceLog;
use Validator; 
use DB;
use Auth;
use App;

class PlacesRESTController extends Controller
{

    public function debug_to_console( $data ) {
      $output = $data;
      if ( is_array( $output ) )
        $output = implode( ',', $output);

      echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    public static function showAll($pais, $provincia, $partido, $ciudad, $service){
        $places = DB::table('places')
          ->join('ciudad', 'places.idciudad', '=', 'ciudad.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->where($service, '=', 1)
          ->where('nombre_ciudad', $ciudad)
          ->where('nombre_pais', $pais)
          ->where('nombre_provincia', $provincia)
          ->where('nombre_partido', $partido)
          ->where('places.aprobado', '=', 1)
          ->select()
          ->get();

      $resu = array();

        if ($service == "condones") {
            $resu['title'] = 'Preservativos';
            $resu['icon'] = 'condones.png';
            $resu['titleCopySeo'] = 'consigo Preservativos';
            $resu['descriptionCopy'] = 'lugares que distribuyen Preservativos de forma gratuita';
            $resu['titleCopySingle'] = 'lugar que distribuye Preservativos de forma gratuita.';
            $resu['titleCopyMultiple'] = 'lugares que distribuyen Preservativos de forma gratuita.';

            $resu['newServiceTitle'] = ' Preservativos ';
            $resu['newServiceTitleSingle'] = ' Preservativos ';

            $resu['preCopyFound'] = ' lugares de entrega gratuita de ';
            $resu['preCopyFoundSingle'] = ' lugar de entrega gratuita de ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares de entrega gratuita de  ';
        }


        if ($service == "prueba") {
            $resu['title'] = 'Test VIH';
            $resu['icon'] = 'prueba.png';
            $resu['titleCopySeo'] = 'puedo hacer Test VIH';
            $resu['descriptionCopy'] = 'los lugares que realizan el Test de VIH de manera gratuita';

            $resu['titleCopySingle'] = 'lugar para hacer Test VIH.';
            $resu['titleCopyMultiple'] = 'lugares que hagan Test VIH.';

            $resu['newServiceTitle'] = ' Centros de Testeo de VIH ';
            $resu['newServiceTitleSingle'] = ' Centro de Testeo de VIH ';

            $resu['preCopyFound'] = '';
            $resu['preCopyFoundSingle'] = '';

            $resu['titleCopyNotFound'] = 'No tenemos registrados  ';
        }

        if ($service == "infectologia") {
            $resu['title'] = 'Centros de Infectología';
            $resu['icon'] = 'infectologia.png';
            $resu['titleCopySeo'] = 'hay Centros de Infectología';
            $resu['descriptionCopy'] = 'dónde hay Centros de Infectología';

            $resu['titleCopySingle'] = ' Centro de Infectología.';
            $resu['titleCopyMultiple'] = 'Centros de Infectología.';

            $resu['newServiceTitle'] = ' Centros de Infectología ';
            $resu['newServiceTitleSingle'] = ' Centro de Infectología ';

            $resu['preCopyFound'] = '';
            $resu['preCopyFoundSingle'] = '';

            $resu['titleCopyNotFound'] = "No tenemos registrados " ;
        }

        if ($service == "vacunatorio") {
            $resu['title'] = 'Vacunatorios';
            $resu['icon'] = 'vacunatorio.png';
            $resu['titleCopySeo'] = 'hay vacunatorios';

            $resu['titleCopySingle'] = 'Vacunatorio.';
            $resu['descriptionCopy'] = 'los vacunatorios más cercanos, sus horarios de atención e información de contacto';
            $resu['titleCopyMultiple'] = 'Vacunatorios.';

            $resu['newServiceTitle'] = ' Vacunatorios ';
            $resu['newServiceTitleSingle'] = ' Vacunatorio ';

            $resu['preCopyFound'] = '';
            $resu['preCopyFoundSingle'] = '';

            $resu['titleCopyNotFound'] = 'No tenemos registrados ';
        }


        if ($service == "ile") {
            $resu['title'] = 'Interrupción Legal del Embarazo';
            $resu['icon'] = 'ile.png';
            $resu['titleCopySeo'] = 'puedo obtener información sobre Interrupción Legal del Embarazo';

            $resu['titleCopySingle'] = 'lugar para obtener información sobre Interrupción Legal del Embarazo.';
            $resu['descriptionCopy'] = 'dónde obtener información sobre Interrupción Legal del Embarazo';
            $resu['titleCopyMultiple'] = 'lugares para obtener información sobre Interrupción Legal del Embarazo.';

            $resu['newServiceTitle'] = ' Interrupción Legal del Embarazo';
            $resu['newServiceTitleSingle'] = ' Interrupción Legal del Embarazo';

            $resu['preCopyFound'] = ' lugares para obtener información sobre';
            $resu['preCopyFoundSingle'] = ' lugar para obtener información sobre ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares para obtener información sobre ';
        }

        if ($service == "ssr") {
            $resu['title'] = 'Métodos Anticonceptivos';
            $resu['icon'] = 'ssr.png';
            $resu['titleCopySeo'] = 'puedo obtener información sobre Métodos Anticonceptivos';

            $resu['titleCopySingle'] = 'lugar para obtener información sobre Métodos Anticonceptivos.';
            $resu['descriptionCopy'] = 'dónde obtener información sobre Métodos Anticonceptivos';
            $resu['titleCopyMultiple'] = 'lugares para obtener información sobre Métodos Anticonceptivos.';

            $resu['newServiceTitle'] = ' Métodos Anticonceptivos ';
            $resu['newServiceTitleSingle'] = ' Métodos Anticonceptivos ';

            $resu['preCopyFound'] = ' lugares para obtener información sobre';
            $resu['preCopyFoundSingle'] = ' lugar para obtener información sobre ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares para obtener información sobre ';
        }

        $horario='';
        $responsable='';
        $telefono='';

        foreach ($places as $p) {
            switch ($p) {
          case ($service == "condones"):
            $p->horario = $p->horario_distrib;
            $p->responsable = $p->responsable_distrib;
            $p->telefono = $p->tel_distrib;
            break;

          case ($service == "prueba"):
            $p->horario = $p->horario_testeo;
            $p->responsable = $p->responsable_testeo;
            $p->telefono = $p->tel_testeo;
            break;

          case ($service == "vacunatorio"):
            $p->horario = $p->horario_vac;
            $p->responsable = $p->responsable_vac;
            $p->telefono = $p->tel_vac;
            break;

          case ($service == "infectologia"):
            $p->horario = $p->horario_infectologia;
            $p->responsable = $p->responsable_infectologia;
            $p->telefono = $p->tel_infectologia;
            break;

          case ($service == "ile"):
            $p->horario = $p->horario_ile;
            $p->responsable = $p->responsable_ile;
            $p->telefono = $p->tel_ile;
            break;

            case ($service == "ssr"):
              $p->horario = $p->horario_ssr;
              $p->responsable = $p->responsable_ssr;
              $p->telefono = $p->tel_ssr;
              break;
      }
            if (($p->horario == "" || $p->horario == " ")) {
                $p->horario = " - ";
            }
            if (($p->responsable == "" || $p->responsable == " ")) {
                $p->responsable = " - ";
            }
            if (($p->telefono == "" || $p->telefono == " ")) {
                $p->telefono = " - ";
            }
        }
        $cantidad = count($places);

        //return json_encode(array('lugares' => $places, 'cantidad' => $cantidad, 'textos' => $resu));

        return view('seo.placesList', compact('places', 'cantidad', 'pais', 'provincia', 'partido','ciudad', 'resu'));
    }


    public static function getScalar($pid, $cid, $bid)
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function getPlaceById($id){
     
     $place = DB::table('places')
      ->join('pais', 'pais.id', '=', 'places.idPais')
      ->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
      ->where('places.placeId', '=', $id)
      ->select('places.*', 'pais.nombre_pais', 'ciudad.nombre_ciudad')
      ->get();

      return $place;
    }

    public static function getScalarCampus($id)
    {
        return DB::table('places')
      ->where('places.idPartido', $id)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    //Add evaluations count for selected service
    public function addEvaluationsForPlaces($places, $service){

      for ($i=0; $i < count($places); $i++) {
        $id = $places[$i]['placeId'];
        $evals = Evaluation::join('places', 'places.placeId', '=', 'evaluation.idPlace')
        ->where('evaluation.aprobado',1)
        ->where('evaluation.idPlace',$id)
        ->select('places.placeId','places.establecimiento', 'evaluation.comentario',
        'evaluation.que_busca', 'evaluation.service', 'evaluation.voto', 'evaluation.updated_at',
        'evaluation.reply_admin', 'evaluation.reply_date', 'evaluation.reply_content')
        ->get();
        $evals = $evals->toArray();
        $N = 0;
        for ($j=0; $j < count($evals); $j++) {
          if($evals[$j]['service'] == $service){
            $N++;
          }
        }
        $places[$i]['cantidad_votos_filtered'] = $N;
      }

      return $places;
    }

    public static function getScalarLatLon($lat, $lng, $service)
    {
        //distance in Meters rounded and multiples of 10
        $places = Places::select(DB::raw('*,round(6373 * acos(
                  cos( radians('.$lat.') )
                  * cos( radians( places.latitude ) )
                  * cos( radians( places.longitude ) - radians('.$lng.') )
                  + sin( radians('.$lat.') )
                  * sin( radians( places.latitude ) ) )
                  ,2) * 1000 AS distance'), 'pais.nombre_pais', 'ciudad.nombre_ciudad')
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
                     ->where('places.aprobado', '=', 1)
                     ->having('distance', '<', 10000)
                     ->orderBy('distance')
                     ->take(50)
                     ->get();

        $places = App::make('App\Http\Controllers\PlacesRESTController')->addEvaluationsForPlaces($places,$service);
        return $places;
    }

    // Check if this method is still useful
    public static function getScalarServices($pid, $cid, $bid, $service)
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where($service, '=', 1)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    // List approved places that belong to a city by service
    static public function getScalarServicesByCity($pid,$cid,$bid,$lid,$service){

     $places = Places::join('ciudad', 'places.idCiudad', '=' , 'ciudad.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where($service,'=',1)
        ->where('places.idCiudad', $lid)
        ->where('places.idPartido', $bid)
        ->where('places.idProvincia', $cid)
        ->where('places.idPais', $pid)
        ->where('places.aprobado', '=', 1)
        ->select()
        ->get();

      $places = App::make('App\Http\Controllers\PlacesRESTController')->addEvaluationsForPlaces($places,$service);
      return $places;
    }

    public static function getScalarServicesCampus($id, $service){

        return DB::table('places')
          ->where($service, '=', 1)
          ->where('places.idPartido', $id)
          ->where('places.aprobado', '=', 1)
          ->select()
          ->get();
          
    }

    public static function scopeIsLike($query, $q)
    {
        foreach ($q as $eachQueryString) {
            $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
            $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
            $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
        }
        return $query;
    }

    public static function search($q)
    {
        $keys = explode(" ", $q);

        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where(function ($query) use ($keys) {
          foreach ($keys as $eachQueryString) {
              $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
          }
      })
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function searchFilterByUser($q)
    {
        if (Auth::user()->roll == 'administrador') {
            $keys = explode(" ", $q);

            $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where(function ($query) use ($keys) {
            foreach ($keys as $eachQueryString) {
                $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
            }
        })
        ->where('places.aprobado', '=', 1)
        ->where('ciudad.habilitado', '=', 1)
        ->where('partido.habilitado', '=', 1)
        ->where('provincia.habilitado', '=', 1)
        ->where('pais.habilitado', '=', 1)
        ->select()
        ->get();
        } else {
            $userId = Auth::user()->id;
            $keys = explode(" ", $q);

            $places = DB::table('places')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->join('user_country', 'user_country.id_country', '=', 'pais.id')
        ->where(function ($query) use ($keys) {
            foreach ($keys as $eachQueryString) {
                $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
            }
        })
        ->where('places.aprobado', '=', 1)
        ->where('ciudad.habilitado', '=', 1)
        ->where('partido.habilitado', '=', 1)
        ->where('provincia.habilitado', '=', 1)
        ->where('pais.habilitado', '=', 1)
        ->where('user_country.id_user', '=', $userId)
        ->select()
        ->get();
        }
        return $places;
    }
    public static function searchFilterByUserExact($q)
    {
      if (Auth::user()->roll == 'administrador') {
        
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where(function ($query) use ($q) {

          $query->orWhere('establecimiento', 'LIKE', '%'.$q .'%');
          $query->orWhere('calle', 'LIKE', '%'.$q .'%');
          $query->orWhere('altura', 'LIKE', '%'.$q .'%');

        })
        ->where('places.aprobado', '=', 1)
        ->where('ciudad.habilitado', '=', 1)
        ->where('partido.habilitado', '=', 1)
        ->where('provincia.habilitado', '=', 1)
        ->where('pais.habilitado', '=', 1)
        ->select()
        ->get();
      } else {
        $userId = Auth::user()->id;

        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where(function ($query) use ($q) {

         $query->orWhere('establecimiento', 'LIKE', '%'.$q .'%');
         $query->orWhere('calle', 'LIKE', '%'.$q .'%');
         $query->orWhere('altura', 'LIKE', '%'.$q .'%');

       })
        ->where('places.aprobado', '=', 1)
        ->where('ciudad.habilitado', '=', 1)
        ->where('partido.habilitado', '=', 1)
        ->where('provincia.habilitado', '=', 1)
        ->where('pais.habilitado', '=', 1)
        ->where('user_country.id_user', '=', $userId)
        ->select()
        ->get();
      }
      return $places;
    }

    public static function searchPlacesEval($q)
    {
        $keys = explode(" ", $q);

        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->leftjoin('evaluation', 'places.placeId', '=', 'evaluation.idPlace')
      ->where(function ($query) use ($keys) {
          foreach ($keys as $eachQueryString) {
              $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
          }
      })
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }



    public static function showApproved($pid, $cid, $bid)
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function showApprovedSearchActive($pid, $bid, $did, $cid)
    {
        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $bid)
      ->where('places.idPartido', $did)
      ->where('places.idCiudad', $cid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }    

    public static function showApprovedActive($pid, $cid, $did, $bid)
    {
        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $did)
      ->where('places.idciudad', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    
    public static function panelShowApprovedActive($paisId=null, $pciaId=null, $partyId=null, $cityId=null)
    {

      $q = DB::table('places');
      
      $q->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
        ->join('partido', 'partido.id', '=', 'places.idPartido')
        ->join('provincia', 'provincia.id', '=', 'places.idProvincia')
        ->join('pais', 'pais.id', '=', 'places.idPais');

      if ($cityId){
        $q->where('ciudad.id', '=', $cityId);
      }
      if ($partyId){
        $q->where('partido.id', '=', $partyId);
      }
      if ($pciaId){
        $q->where('provincia.id', '=', $pciaId);
      } 
      if ($paisId){
        $q->where('pais.id', '=', $paisId);
      } 

        
        
      $q->where('places.aprobado', '=', 1);

      

      return $q->select()
          ->get();
    }
        

    public static function showApprovedFilterByService($paisId, $provinciaId, $partidoId, $servicios)
    {
        $places = DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $paisId)
      ->where('places.idProvincia', $provinciaId)
      ->where('places.idPartido', $partidoId)
      ->where('places.aprobado', '=', 1)
       ->where(function ($query) use ($servicios) {
           if (in_array("condones", $servicios)) {
               $query->orWhere('places.condones', 1);
           }
           if (in_array("prueba", $servicios)) {
               $query->orWhere('places.prueba', 1);
           }
           if (in_array("vacunatorios", $servicios)) {
               $query->orWhere('places.vacunatorio', 1);
           }
           if (in_array("cdi", $servicios)) {
               $query->orWhere('places.infectologia', 1);
           }
           if (in_array("ssr", $servicios)) {
               $query->orWhere('places.ssr', 1);
           }
           if (in_array("dc", $servicios)) {
               $query->orWhere('places.dc', 1);
           }
           if (in_array("mac", $servicios)) {
               $query->orWhere('places.mac', 1);
           }
       })
    ->get();
        return $places;
    }

    public static function showApprovedFilterByTag($tagId)
    {
      $places = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.logId', $tagId)
      ->get();
      return $places;
    }

  public static function getAprobedPlaces($idPais="null", $idProvincia="null",$idPartido="null", $idCiudad="null")
    {
      $places =[];
      
       // Export filter by country
       if ((isset($idPais)) && ($idPais != "null") && (($idProvincia == "null") || (!isset($idProvincia)))) {
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')  
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.idPais', $idPais)
        ->where('places.aprobado', '=', 1)
        ->get();
      }// Export filter by country and province
      elseif ((isset($idPais)) && ($idPais != "null") && (isset($idProvincia)) && ($idProvincia != "null") && (($idPartido == "null") || (!isset($idPartido)))) {
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')  
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.idPais', $idPais)
        ->where('places.idProvincia', $idProvincia)
        ->where('places.aprobado', '=', 1)
        ->get();
      }elseif ((isset($idPais)) && ($idPais != "null") && (isset($idProvincia)) && ($idProvincia != "null") && (isset($idPartido)) && ($idPartido != "null") && (($idCiudad == "null") || (!isset($idCiudad)))) {
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')  
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.idPais', $idPais)
        ->where('places.idProvincia', $idProvincia)
        ->where('places.idPartido', $idPartido)
        ->where('places.aprobado', '=', 1)
        ->get();
      }// Export filter by country, province, party and city
      elseif ((isset($idPais)) && ($idPais != "null") && (isset($idProvincia)) && ($idProvincia != "null") && (isset($idPartido)) && ($idPartido != "null") && (isset($idCiudad) && ($idCiudad != "null"))) {
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')  
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.idPais', $idPais)
        ->where('places.idProvincia', $idProvincia)
        ->where('places.idPartido', $idPartido)
        ->where('places.idCiudad', $idCiudad)
        ->where('places.aprobado', '=', 1)
        ->get();
      }elseif ( $idPais == "null"  &&  $idProvincia == "null" && $idPartido == "null" && $idCiudad == "null") {
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')  
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.aprobado', '=', 1)
        ->get();
      }
      else{
        $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')  
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.aprobado', '=', 1)
        ->get();
      }
      
        return $places;
    }

    public static function counters()
    {
        $counters = array();
        $counters['lugares'] = DB::table('places')->count();
        $counters['rechazados'] = DB::table('places')
                    ->where('places.aprobado', '=', -1)
                     ->count();
        $counters['aprobados'] = DB::table('places')

                    ->where('places.aprobado', '=', 1)
                     ->count();
        $counters['pendientes'] = DB::table('places')

                    ->where('places.aprobado', '=', 0)
                     ->count();
        $counters['sinGeo'] = DB::table('places')

                    ->whereNull('places.latitude')
                    ->count();
        $counters['conGeo'] = DB::table('places')
                      ->whereNull('places.latitude')
                     ->count();
        $counters['errorGeo'] = DB::table('places')
                       ->where('places.confidence', '=', 0.5)
                     ->count();
        $counters['conGeo'] = DB::table('places')
                      ->whereNotNull('places.latitude')
                     ->count();

        $counters['paises'] = DB::table('pais')
                     ->count();
        $counters['ciudades'] = DB::table('provincia')
                     ->count();
        $counters['partido'] = DB::table('partido')
                     ->count();
        $counters['evaluations'] = DB::table('evaluation')
                     ->count();
      // $counters['placesEvaluation'] = DB::table('evaluation')->count();
      $counters['placesEvaluation'] = DB::table('evaluation')->distinct()->count(["idPlace"]);



        return $counters;
    }

    public static function countersFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        $counters = array();
        if ($roll == 'administrador') {
          $counters['lugares'] = DB::table('places')->count();
          $counters['rechazados'] = DB::table('places')
          ->where('places.aprobado', '=', -1)
          ->where('places.aprobado', '=', -1)
          ->count();
          $counters['aprobados'] = DB::table('places')
          ->where('places.aprobado', '=', 1)
          ->count();
          $counters['pendientes'] = DB::table('places')
          ->where('places.aprobado', '=', 0)
          ->count();
          $counters['sinGeo'] = DB::table('places')
          ->whereNull('places.latitude')
          ->count();
          $counters['conGeo'] = DB::table('places')
          ->whereNull('places.latitude')
          ->count();
          $counters['errorGeo'] = DB::table('places')
          ->where('places.confidence', '=', 0.5)
          ->count();
          $counters['conGeo'] = DB::table('places')
          ->whereNotNull('places.latitude')
          ->count();
          $counters['paises'] = DB::table('pais')
          ->count();
          $counters['ciudades'] = DB::table('provincia')
          ->count();
          $counters['partido'] = DB::table('partido')
          ->count();
          $counters['evaluaciones'] = DB::table('evaluation')
          ->count()-1;
          $counters['imports'] = DB::table('places_log')
          ->count();
          // $counters['placesEvaluation'] = DB::table('evaluation')->count();
          $counters['placesEvaluation'] = DB::table('evaluation')->distinct()->count(["idPlace"]);
        } else {
          $counters['lugares'] = DB::table('places')
                                   ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                                   ->where('user_country.id_user', '=', $userId)
                                   ->count();
            $counters['rechazados'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                        ->where('places.aprobado', '=', -1)
                         ->count();
            $counters['aprobados'] = DB::table('places')
                          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                          ->where('user_country.id_user', '=', $userId)
                        ->where('places.aprobado', '=', 1)
                         ->count();
            $counters['pendientes'] = DB::table('places')
                     ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                     ->where('user_country.id_user', '=', $userId)
                        ->where('places.aprobado', '=', 0)
                         ->count();
            $counters['sinGeo'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                        ->whereNull('places.latitude')
                        ->count();
            $counters['conGeo'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                          ->whereNull('places.latitude')
                         ->count();
            $counters['errorGeo'] = DB::table('places')
                          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                          ->where('user_country.id_user', '=', $userId)
                           ->where('places.confidence', '=', 0.5)
                         ->count();
            $counters['conGeo'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                          ->whereNotNull('places.latitude')
                         ->count();

            $counters['paises'] = DB::table('pais')
                        ->join('user_country', 'user_country.id_country', '=', 'pais.id')
                        ->where('user_country.id_user', '=', $userId)
                         ->count();
            $counters['ciudades'] = DB::table('provincia')
                        ->join('user_country', 'user_country.id_country', '=', 'provincia.idPais')
                        ->where('user_country.id_user', '=', $userId)
                         ->count();
            $counters['partido'] = DB::table('partido')
                        ->join('user_country', 'user_country.id_country', '=', 'partido.idPais')
                        ->where('user_country.id_user', '=', $userId)
                         ->count();
            $counters['evaluations'] = DB::table('evaluation')
          ->join('places', 'places.placeId', '=', 'evaluation.idPlace')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
                         ->count();
          // $counters['placesEvaluation'] = DB::table('evaluation')->count();
          $counters['placesEvaluation'] = DB::table('evaluation')
          ->join('places', 'places.placeId', '=', 'evaluation.idPlace')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
          ->distinct()
          ->count(["idPlace"]);
        }

        return $counters;
    }

    public static function getCitiRanking()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        if ($roll == 'administrador') {
            return
              DB::table('places')
                     ->select(

                      DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
        } else {
            $plac= DB::table('places')
                     ->select(

                      DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                     ->where('user_country.id_user', '=', $userId)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();

            return $plac;
        }
    }

    public static function getCountryRanking()
    {
        
            return
              DB::table('places')
                     ->select(
                      DB::raw('count(*) as lugares, nombre_pais , id'))
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPais')
                     ->get();
        
    }


    public static function getNonGeoFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        if ($roll == 'administrador') {
            return
            DB::table('places')
                   ->select(DB::raw('count(*) as lugares, nombre_pais,
                      nombre_provincia, nombre_partido'))
                   ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                   ->join('partido', 'places.idPartido', '=', 'partido.id')
                   ->join('pais', 'places.idPais', '=', 'pais.id')
                   ->whereNull('latitude')
                   ->orWhereNull('longitude')
                   ->orderBy('lugares', 'desc')
                   ->groupBy('idPartido')
                   ->get();
        } else {
            return
            DB::table('places')
                   ->select(DB::raw('count(*) as lugares, nombre_pais,
                      nombre_provincia, nombre_partido'))
                   ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                   ->join('partido', 'places.idPartido', '=', 'partido.id')
                   ->join('pais', 'places.idPais', '=', 'pais.id')
                   ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                   ->where('user_country.id_user', '=', $userId)
                   ->whereNull('latitude')
                   ->orWhereNull('longitude')
                   ->orderBy('lugares', 'desc')
                   ->groupBy('idPartido')
                   ->get();
        }
    }

    public static function getNonGeo()
    {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->whereNull('latitude')
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
    }

    public static function getBadGeoFilterByUser()
    {
      $userId = Auth::user()->id;
      $roll = Auth::user()->roll;
      if ($roll == 'administrador') {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->where('confidence', '=', 0.5)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
      }
      else {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                     ->where('user_country.id_user', '=', $userId)
                     ->where('confidence', '=', 0.5)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
      }


    }

    public static function getBadGeo()
    {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->where('confidence', '=', 0.5)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
    }

    public static function showDreprecated(){
      $result = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.aprobado', '=', -1)
      ->select()
      ->get();
      return $result;
    }

    public static function showDreprecatedFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        if ($roll == 'administrador') {
            return DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->where('places.aprobado', '=', -1)
          ->select()
          ->get();
        } else {
            return DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
          ->where('places.aprobado', '=', -1)
          ->select()
          ->get();
        }
    }

    public function showPending()
    {
        // return
    $resu = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.aprobado', '=', 0)
      ->select()
      ->get();


        return $resu;
    }

    public function showPendingFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;

        if ($roll == 'administrador') {
            $resu = DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->where('places.aprobado', '=', 0)
          ->select()
          ->get();
        } else {
            $resu = DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
          ->where('places.aprobado', '=', 0)
          ->select()
          ->get();
        }

        return $resu;
    }

    public function showAllTypes(){
      return App::make('App\Http\Controllers\ImportadorController')->placeTypes;
    }

    public function showPanel($id)
    {
        return DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.placeId', '=', $id)
      ->select()
      ->get();
    }

    public function block(Request $request, $id)
    {
        $request_params = $request->all();

        $place = Places::find($id);

        $place->aprobado = -1;

        $place->updated_at = date("Y-m-d H:i:s");
        $place->save();

        return [];
    }

    public function blockAll(Request $request, $ids)
    {
        $request_params = $request->all();

        $idsArray = explode(',', $ids);
        
        $models = Places::findMany($idsArray);

        foreach ($models as $place) {
          $place->aprobado = -1;
          $place->updated_at = date("Y-m-d H:i:s");
          $place->save();
        }

        return [];
    }

    public function approve(Request $request, $id)
    {
        $request_params = $request->all();

        $place = Places::find($id);
        if(!$place) return;

        $city = app('App\Http\Controllers\CiudadRESTController')->approveCity($place->idCiudad);
        if(!$city) return;

        $place->aprobado = 1;

        $place->updated_at = date("Y-m-d H:i:s");
        $place->save();

        return [];
    }

    public function update(Request $request, $id)
    {
      $request_params = $request->all();
      $request_params['validTypes'] = App::make('App\Http\Controllers\ImportadorController')->placeTypes;

      $rules = array(
        'establecimiento' => 'required|max:150|min:2',
        'idCiudad' => 'required',
        'idPartido' => 'required',
        'idProvincia' => 'required',
        'idPais' => 'required',
        'tipo' => ['required','in_array:validTypes.*']
      );

      $messages = array(
        'required'  => 'El :attribute es requerido.',
        'max'       => 'El :attribute debe poseer un maximo de :max caracteres.',
        'min'       => 'El :attribute debe poseer un minimo de :min caracteres.',
        'in_array'  => 'El :attribute ingresado no es un tipo válido.');

      $validator = Validator::make($request_params, $rules, $messages);
      
      if ($validator->passes()) {
        $place = Places::find($id);

        $placeLog = new PlaceLog;
        $placeLog->entry_type = "update_manual";
        $placeLog->modification_date = date("Y-m-d");
        $placeLog->user_id = Auth::user()->id;
        $placeLog->save();

        
        $place->establecimiento = $request_params['establecimiento'];
        $place->calle = $request_params['calle'];
        $place->tipo = $request_params['tipo'];
        $place->altura = $request_params['altura'];
        $place->piso_dpto = $request_params['piso_dpto'];
        $place->observacion = $request_params['observacion'];
        $place->cruce = $request_params['cruce'];
        $place->latitude = $request_params['latitude'];
        $place->longitude = $request_params['longitude'];
        $place->confidence = $request_params['confidence'];
        $place->barrio_localidad = $request_params['barrio_localidad'];

        $place->prueba = $request_params['prueba'];
        $place->responsable_testeo = $request_params['responsable_testeo'];
        $place->ubicacion_testeo = $request_params['ubicacion_testeo'];
        $place->horario_testeo = $request_params['horario_testeo'];
        $place->mail_testeo = $request_params['mail_testeo'];
        $place->tel_testeo = $request_params['tel_testeo'];
        $place->web_testeo = $request_params['web_testeo'];
        $place->observaciones_testeo = $request_params['observaciones_testeo'];

        $place->condones = $request_params['condones'];
        $place->responsable_distrib = $request_params['responsable_distrib'];
        $place->ubicacion_distrib = $request_params['ubicacion_distrib'];
        $place->horario_distrib = $request_params['horario_distrib'];
        $place->mail_distrib = $request_params['mail_distrib'];
        $place->tel_distrib = $request_params['tel_distrib'];
        $place->web_distrib = $request_params['web_distrib'];
        $place->comentarios_distrib = $request_params['comentarios_distrib'];

        $place->infectologia = $request_params['infectologia'];
        $place->responsable_infectologia = $request_params['responsable_infectologia'];
        $place->ubicacion_infectologia = $request_params['ubicacion_infectologia'];
        $place->horario_infectologia = $request_params['horario_infectologia'];
        $place->mail_infectologia = $request_params['mail_infectologia'];
        $place->tel_infectologia = $request_params['tel_infectologia'];
        $place->web_infectologia = $request_params['web_infectologia'];
        $place->comentarios_infectologia = $request_params['comentarios_infectologia'];

        $place->vacunatorio = $request_params['vacunatorio'];
        $place->responsable_vac = $request_params['responsable_vac'];
        $place->ubicacion_vac = $request_params['ubicacion_vac'];
        $place->horario_vac = $request_params['horario_vac'];
        $place->mail_vac = $request_params['mail_vac'];
        $place->tel_vac = $request_params['tel_vac'];
        $place->web_vac = $request_params['web_vac'];
        $place->comentarios_vac = $request_params['comentarios_vac'];

        $place->es_rapido = $request_params['es_rapido'];
        $place->es_anticonceptivos = $request_params['es_anticonceptivos'];
        
        $place->mac = $request_params['mac'];
        $place->responsable_mac = $request_params['responsable_mac'];
        $place->ubicacion_mac = $request_params['ubicacion_mac'];
        $place->horario_mac = $request_params['horario_mac'];
        $place->mail_mac = $request_params['mail_mac'];
        $place->tel_mac = $request_params['tel_mac'];
        $place->web_mac = $request_params['web_mac'];
        $place->comentarios_mac = $request_params['comentarios_mac'];

        $place->ssr = $request_params['ssr'];
        $place->responsable_ssr = $request_params['responsable_ssr'];
        $place->ubicacion_ssr = $request_params['ubicacion_ssr'];
        $place->horario_ssr = $request_params['horario_ssr'];
        $place->mail_ssr = $request_params['mail_ssr'];
        $place->tel_ssr = $request_params['tel_ssr'];
        $place->web_ssr = $request_params['web_ssr'];
        $place->comentarios_ssr = $request_params['comentarios_ssr'];

         $place->ile = $request_params['ile'];
        $place->responsable_ile = $request_params['responsable_ile'];
        $place->ubicacion_ile = $request_params['ubicacion_ile'];
        $place->horario_ile = $request_params['horario_ile'];
        $place->mail_ile = $request_params['mail_ile'];
        $place->tel_ile = $request_params['tel_ile'];
        $place->web_ile = $request_params['web_ile'];
        $place->comentarios_ile = $request_params['comentarios_ile'];

        $place->servicetype_dc = $request_params['servicetype_dc'];
        $place->servicetype_ssr = $request_params['servicetype_ssr'];
        $place->servicetype_mac = $request_params['servicetype_mac'];
        $place->servicetype_prueba = $request_params['servicetype_prueba'];
        $place->servicetype_ile = $request_params['servicetype_ile'];
        $place->servicetype_condones = $request_params['servicetype_condones'];

        $place->friendly_prueba = $request_params['friendly_prueba'];
        $place->friendly_condones = $request_params['friendly_condones'];
        $place->friendly_infectologia = $request_params['friendly_infectologia'];
        $place->friendly_vacunatorio = $request_params['friendly_vacunatorio'];
        $place->friendly_ssr = $request_params['friendly_ssr'];
        $place->friendly_ile = $request_params['friendly_ile'];
        $place->friendly_mac = $request_params['friendly_mac'];
        $place->friendly_dc = $request_params['friendly_dc'];

        //Updating ciudad
        if ($request_params['idPais'] == 0){
          // =============================================================================
          // ID PAIS
          // =============================================================================
          $place->idPais = DB::table('pais')
          ->where('pais.nombre_pais', '=',$request_params['nombre_pais'])
          ->value('id');

          //si no existe
          if ( !$place->idPais ){
              $place->idPais = DB::table('pais')->max('id') + 1;
              DB::table('pais')->insert([
                  'id' => $place->idPais,
                  'nombre_pais' => $request_params['nombre_pais'],
                  'habilitado' => 0,
                  'created_at' => date("Y-m-d H:i:s")
              ]);
          }

          // =============================================================================
          // ID PROVINCIA
          // =============================================================================
          $place->idProvincia = DB::table('provincia')
          ->join('pais','pais.id','=','provincia.idPais')
          ->where('pais.nombre_pais', '=', $request_params['nombre_pais'])
          ->where('provincia.nombre_provincia', '=', $request_params['nombre_provincia'])
          ->value('provincia.id');

          //si no existe
          if ( !$place->idProvincia ){
              $place->idProvincia = DB::table('provincia')->max('id') + 1;
              DB::table('provincia')->insert([
                  'id' => $place->idProvincia,
                  'nombre_provincia' => $request_params['nombre_provincia'],
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
          ->where('pais.nombre_pais', '=', $request_params['nombre_pais'])
          ->where('provincia.nombre_provincia', '=', $request_params['nombre_provincia'])
          ->where('partido.nombre_partido', '=', $request_params['nombre_partido'])
          ->value('partido.id');

          //si no existe
          if ( !$place->idPartido ){
              $place->idPartido = DB::table('partido')->max('id') + 1;
              DB::table('partido')->insert([
                  'id' => $place->idPartido,
                  'nombre_partido' =>  $request_params['nombre_partido'],
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
          ->where('pais.nombre_pais', '=', $request_params['nombre_pais'])
          ->where('provincia.nombre_provincia', '=', $request_params['nombre_provincia'])
          ->where('partido.nombre_partido', '=',$request_params['nombre_partido'])
          ->where('ciudad.nombre_ciudad', '=', $request_params['nombre_ciudad'])
          ->value('ciudad.id');

          //si no existe
          if ( !$place->idCiudad ){
              $place->idCiudad = DB::table('ciudad')->max('id') + 1;
              DB::table('ciudad')->insert([
                  'id' => $place->idCiudad,
                  'nombre_ciudad' =>  $request_params['nombre_ciudad'],
                  'habilitado' => 0,
                  'created_at' => date("Y-m-d H:i:s"),
                  'idPais'    => $place->idPais,
                  'idProvincia'  => $place->idProvincia,
                  'idPartido'  => $place->idPartido,
              ]);
          }
        }

        $place->updated_at = date("Y-m-d H:i:s");
        $place->logId = $placeLog->id;
        $place->save();
      }

      return $validator->messages();
    }

    public function getAllPlaces(Request $request)
    {
        try {
            return DB::table('places')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllPartidos(Request $request)
    {
        try {
            return DB::table('partido')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllProvincias(Request $request)
    {
        try {
            return DB::table('provincia')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllPaises(Request $request)
    {
        try {
            return DB::table('pais')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllAutocomplete(Request $request){

          if($request->has("nombre_partido")){

              $param = "%".$request->nombre_partido."%";

              $ciudades = DB::table('ciudad')
                            ->select('ciudad.id','ciudad.nombre_ciudad', 'partido.nombre_partido', 'provincia.nombre_provincia', 'pais.nombre_pais', 'ciudad.idPartido', 'ciudad.idProvincia', 'ciudad.idPais')
                            ->join('partido', 'partido.id', '=', 'ciudad.idPartido')
                            ->join('provincia', 'provincia.id', '=', 'ciudad.idProvincia')
                            ->join('pais', 'pais.id', '=', 'ciudad.idPais')
                            ->where('ciudad.habilitado', '=', 1)
                            ->where('ciudad.nombre_ciudad', 'like', $param)
                            ->get();     

              $partidos = DB::table('partido')
                            ->select('partido.id','partido.nombre_partido', 'provincia.nombre_provincia', 'pais.nombre_pais', 'partido.idProvincia', 'partido.idPais')
                            ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
                            ->join('pais', 'pais.id', '=', 'partido.idPais')
                            ->where('partido.habilitado', '=', 1)
                            ->where('partido.nombre_partido', 'like', $param)
                            ->get();   

              $result = $partidos->merge($ciudades);                             

              return response()->json($result);
              
           }
    }

    public function getpPlacesByParty($pid, $service){

     $places = Places::join('ciudad', 'places.idCiudad', '=' , 'ciudad.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where($service,'=',1)
        ->where('places.idPartido', $pid)
        ->where('places.aprobado', '=', 1)
        ->select()
        ->get();

      $places = App::make('App\Http\Controllers\PlacesRESTController')->addEvaluationsForPlaces($places,$service);
      return $places;
    }  

    public function elimina_acentos($text) {
      $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
      $text = strtolower($text);
      $patron = array (
        '/\+/' => '',
        '/&agrave;/' => 'a',
        '/&egrave;/' => 'e',
        '/&igrave;/' => 'i',
        '/&ograve;/' => 'o',
        '/&ugrave;/' => 'u',
        '/&aacute;/' => 'a',
        '/&eacute;/' => 'e',
        '/&iacute;/' => 'i',
        '/&oacute;/' => 'o',
        '/&uacute;/' => 'u',
        '/&acirc;/' => 'a',
        '/&ecirc;/' => 'e',
        '/&icirc;/' => 'i',
        '/&ocirc;/' => 'o',
        '/&ucirc;/' => 'u',
        '/&atilde;/' => 'a',
        '/&etilde;/' => 'e',
        '/&itilde;/' => 'i',
        '/&otilde;/' => 'o',
        '/&utilde;/' => 'u',
        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',
        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',
            // Otras letras y caracteres especiales
        '/&aring;/' => 'a',
        '/&ntilde;/' => 'n',
            // Agregar aqui mas caracteres si es necesario
        );
      $text = preg_replace(array_keys($patron),array_values($patron),$text);
      return $text;
    }

    public function getPlacesByName($name, $service){

      $places = Places::join('pais', 'places.idPais', '=', 'pais.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->where($service,'=',1)
      ->where('ciudad.habilitado', '=', 1)
      ->where('partido.habilitado', '=', 1)
      ->where('places.aprobado', '=', 1)
      ->where(function ($query) use ($name) {
        $query->orWhere('calle', 'LIKE', '%'. $name .'%')
        ->orWhere('altura', 'LIKE', '%'. $name .'%')
        ->orWhere(DB::raw('concat(calle," ",altura)'), 'LIKE', '%'. $name .'%')
        ->orWhere('places.establecimiento', 'like', '%'.$name. '%');
      })
      ->select('places.*', 'pais.nombre_pais', 'ciudad.nombre_ciudad',
       'partido.nombre_partido', 'provincia.nombre_provincia')
      ->get();

      $places = App::make('App\Http\Controllers\PlacesRESTController')->addEvaluationsForPlaces($places,$service);
      
      return response()->json($places);
    }

    public function listAllAutocomplete(){
    // For the app
    $result = array();

    $partidos = DB::table('partido')
         ->select('partido.id','partido.nombre_partido','partido.idProvincia','provincia.nombre_provincia', 'partido.idPais','pais.nombre_pais')
         ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
         ->join('pais', 'pais.id', '=', 'partido.idPais')
         ->where('partido.habilitado', '=', 1)
         ->get();   

    $ciudades = DB::table('ciudad')
      ->select('ciudad.id','ciudad.nombre_ciudad','ciudad.idPartido', 'partido.nombre_partido', 'ciudad.idProvincia','provincia.nombre_provincia','ciudad.idPais','pais.nombre_pais')
      ->join('partido', 'partido.id', '=', 'ciudad.idPartido')
      ->join('provincia', 'provincia.id', '=', 'ciudad.idProvincia')
      ->join('pais', 'pais.id', '=', 'ciudad.idPais')
      ->where('ciudad.habilitado', '=', 1)
      ->get();   

     $result = $partidos->merge($ciudades);                             

     return response()->json($result);

  }

    public static function getBestRatedPlaces($pid)
    {
        return DB::table('places')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.idPartido', $pid)
        ->select('places.cantidad_votos', 'places.puntaje', 'places.rate')
        // ->select()
        ->orderBy('rate', 'desc') //asc el otro metodo
        ->get();
    }
}