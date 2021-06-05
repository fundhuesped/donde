<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SeoController extends Controller {

	public function showServices($pais,$provincia,$partido,$ciudad){
		//info para la vista de services
		$servicio1 = array('icon' => 'preservativos.png',
			'title' => 'site.condones_name',
			'code' => 'condones',
			'content'=>'site.condones_content');

		$servicio2 = array('icon' => 'test.png',
			'title' => 'site.prueba_name',
			'code' => 'prueba',
			'content' => 'site.prueba_content');

		$servicio3 = array('icon' => 'mac.png',
			'title' => 'site.ssr_name',
			'code' => 'ssr',
			'content' => 'site.ssr_content');

		$servicio4 = array('icon' => 'infectologia.png',
			'title' => 'site.infecto_name',
			'code' => 'infectologia',
			'content' => 'site.dc_content');

		$servicio5 = array('icon' => 'vacunatorios.png',
			'title' => 'site.vacunas_name',
			'code' => 'vacunatorio',
			'content' => 'site.mac_content');

		$servicio6 = array('icon' => 'ile.png',
			'title' => 'site.ile_name',
			'code' => 'ile',
			'content' => 'site.ile_content');

		$allElements = [$servicio1 , $servicio2 , $servicio3, $servicio4, $servicio5, $servicio6];
		return view('seo.services',compact('pais','provincia','partido','ciudad','allElements'));

	}

	public function changeLang($lang){

		if (isset($lang) && $lang !== null){
			try {
				\App::setLocale($lang);
				session(['lang' => $lang]);
				return $arrayName = array('status' => 'ok');
			} catch (Exception $e) {
				return $arrayName = array('status' => 'error');
			}
		}
		else return $arrayName = array('status' => 'error');
	}


	public function index(){
		echo "SEO";
	}

	public function create(){
	}

	public function store(){
	}

	public function show($id){
	}

	public function edit($id){
	}

	public function update($id){
	}

	public function destroy($id){
	}

}