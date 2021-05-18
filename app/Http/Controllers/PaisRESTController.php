<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pais;
use App\Provincia;
use App\Partido;
use App\Ciudad;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PaisRESTController extends Controller{

    public function getCountriesByUser(){
      $countries;
        if (\Auth::user()->roll == 'administrador') {
            $countries = Pais::where('habilitado',1)->get();
        } else {
            $userId = \Auth::user()->id;
            $countries = Pais::where('habilitado',1)
            ->join('user_country', 'user_country.id_country', '=', 'pais.id')
            ->where('user_country.id_user', $userId)
            ->get();
        }
        return $countries;
    }

    public function getAll(){
        return Pais::where('habilitado', '=', 1)->get();
    }

    public function getProvinces($id){
        return
        Provincia::where('idPais', '=', $id)
            ->where('habilitado', '=', 1)
            ->orderBy('nombre_provincia')
            ->get();
    }

    public function getPartidos($id){
        $partidos = Partido::where('idProvincia', $id)
            ->where('habilitado', '=', 1)
            ->orderBy('nombre_partido')
            ->get();
        
       return $partidos;

    }     


    public function getCitiesByParty($id){
        $cities = Ciudad::where('idPartido', $id)
            ->where('habilitado', '=', 1)
            ->orderBy('nombre_ciudad')
            ->get();

        return $cities;

    }   

    public function getCities($id){
        return
            Partido::where('idProvincia', '=', $id)
                ->where('habilitado', '=', 1)
                ->orderBy('nombre_partido')->get();
    }
    public function getAllCities($id){
        return
            Partido::where('idProvincia', '=', $id)
                ->where('habilitado', '=', 1)
                ->orderBy('nombre_partido')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(){
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request){
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){
        return Pais::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id){
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){
    }

    public function showCitiespp($per_page, $q = ''){
      $keys = explode(" ", $q);

      $cities = DB::table('pais')
      ->leftJoin('places', function($join){
        $join->on('places.idPais', '=', 'pais.id')->where('places.aprobado','=','1');
      })
      ->select('pais.nombre_pais','pais.habilitado', 
                DB::raw("COUNT(places.idPais) as countPlaces")
            )
      ->where(function ($query) use ($keys) {
            foreach ($keys as $eachQueryString) {
                $query->orWhere('pais.nombre_pais', 'LIKE', '%'.$eachQueryString .'%');
            }
        })
      ->orderBy('countPlaces')
      ->paginate($per_page);

      return $cities;
    }
    
    public function showCities(){
      $cities = DB::table('pais')
      ->leftJoin('places', function($join){
        $join->on('places.idPais', '=', 'pais.id')->where('places.aprobado','=','1');
      })
      ->select('pais.id','pais.nombre_pais'. DB::raw("COUNT(places.idPais) as countPlaces"))
      ->groupBy('pais.id')
      ->orderBy('countPlaces');

      return $cities;
    }

    public function updateHabilitado(Request $request, $id){
        $request_params = $request->all();
        $p = Pais::find($id);

        if($request->has('habilitado')){
          $p->habilitado = $request_params['habilitado'] ? 1 : 0;
          $p->updated_at = date("Y-m-d H:i:s");
          $p->save();
        }
          return [];

    }

    public function showCountriesDetail(){
        $countries =  DB::table('pais')
                    ->where('habilitado',1)
                    ->orderBy('nombre_pais')
                    ->get();
        return view('seo.detail', compact('countries'));
    }

    public static function showByNombre($nombre){
        return Pais::where('nombre_pais', $nombre)->first();
    }

    public function approvePais($id){
      $pais = Pais::find($id);
      if(!$pais) return;

      if($pais->habilitado == 1) return $pais;
      $pais->habilitado = 1;
      $pais->updated_at = date("Y-m-d H:i:s");
      $pais->save();

      return $pais;
  }
}
