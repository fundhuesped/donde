dondev2App.config(function($interpolateProvider, $locationProvider) {
  $interpolateProvider.startSymbol('[[');
  $interpolateProvider.endSymbol(']]');
}).controller('panelplaceController', function($timeout, copyService, placesFactory, NgMap, $scope, $rootScope, $http, $location, $route, $routeParams, $window, $translate) {

  $scope.spinerflag = false;

  angular.element(document).ready(function() {

    $scope.loading = true;
    $scope.onDragEnd = function(e) {
      $rootScope.place.latitude = e.latLng.lat();
      $rootScope.place.longitude = e.latLng.lng();
      $rootScope.place.confidence = 1;
    };
    $scope.updatePlacePredictions = function( searchQuery ){

        if ( !searchQuery )
            searchQuery = " ";

        var cb = function(r, status,c){
            $scope.placesPredictions = r.data.localidades;
            $scope.formChange();

        };

        $http.get('https://apis.datos.gob.ar/georef/api/localidades?nombre='+ searchQuery).then(cb);
  
       
  }
  

  //Sets the place ID, updates the place google details, and updates the place useful informacion
  $scope.updateAddressComponents = function( autocompleteData ){
      if ( autocompleteData )
        $scope.placeID = autocompleteData.originalObject.id;
      else
        $scope.placeID = -1;
      $scope.currentPlace = autocompleteData.originalObject;
      console.log(autocompleteData.originalObject);

          $scope.locationChange();
          $scope.formChange();
      

  }
  $scope.currentPlace = {};
  $scope.locationOut = function(){
    if (!$scope.currentPlace.id){
      $scope.searchStr = "";
      if($('#ciudad_value').val() != ''){
        $('#ciudad_value').toggleClass('valid');
      }
      setTimeout(function(){ 
         $('#ciudad_value').val('') },200);
      $scope.formChange();
    }
    
  }

  //Sets the place location information
  $scope.locationChange = function() {
      //Pais
        $scope.place.nombre_pais = "Argentina";
        //Provincia
        $scope.place.nombre_provincia = $scope.currentPlace.provincia.nombre;
        //Ciudad
        $scope.place.nombre_ciudad = $scope.currentPlace.nombre.toLowerCase().toProperCase();
        $scope.place.barrio_localidad = $scope.currentPlace.nombre.toLowerCase().toProperCase();
        //Partido
        $scope.place.nombre_partido =$scope.currentPlace.departamento.nombre;
        $scope.place.googlePlaceID = $scope.currentPlace.id;

        $scope.place.idPais = 0;
        $scope.place.idProvincia = 0;
        $scope.place.idCiudad = 0;
        $scope.place.idPartido = 0;

  }

    $http.get('../../api/v2/evaluacion/panel/notificacion/' + $scope.placeId).success(function(response) {
      $scope.badge = response;
      $scope.id = $scope.placeId;
    });

    $http.get('../../api/v1/panel/places/' + $scope.placeId).success(function(response) {
      $rootScope.place = response[0];

      $http.get('../../api/v1/allPlacesTypes')
      .success(function(response) {
        //hacer esto ACA porque sino materialize se carga antes que angular y no se visualiza el populate en el select
        setTimeout(function(){$('select').material_select();},500);

        $scope.placesTypes = [];
        for (var i = 0; i < response.length; i++) {
          $scope.placesTypes.push({name: response[i], value: response[i]});
        }
        $scope.selectedType = response.find(e => e == $rootScope.place.tipo);
      });

      response[0].es_anticonceptivos = (response[0].es_anticonceptivos == 1)
        ? true
        : false;
      response[0].es_rapido = (response[0].es_rapido == 1)
        ? true
        : false;
      response[0].mac = (response[0].mac == 1)
        ? true
        : false;
      response[0].ile = (response[0].ile == 1)
        ? true
        : false;
      response[0].condones = (response[0].condones == 1)
        ? true
        : false;
      response[0].prueba = (response[0].prueba == 1)
        ? true
        : false;
      response[0].vacunatorio = (response[0].vacunatorio == 1)
        ? true
        : false;
      response[0].infectologia = (response[0].infectologia == 1)
        ? true
        : false;
      response[0].ssr = (response[0].ssr == 1)
        ? true
        : false;
      response[0].dc = (response[0].dc == 1)
        ? true
        : false;

      response[0].friendly_ile = (response[0].friendly_ile == 1)
        ? true
        : false;
      response[0].friendly_prueba = (response[0].friendly_prueba == 1)
        ? true
        : false;
      response[0].friendly_condones = (response[0].friendly_condones == 1)
        ? true
        : false;
      response[0].friendly_mac = (response[0].friendly_mac == 1)
        ? true
        : false;
      response[0].friendly_ssr = (response[0].friendly_ssr == 1)
        ? true
        : false;
      response[0].friendly_dc = (response[0].friendly_dc == 1)
        ? true
        : false;

      //controlador exportar avaluaciones
      $rootScope.exportEvaluation = function(evaluationList) {
        var data = evaluationList;
        var req = {
          method: 'POST',
          url: '../../panel/importer/eval-export',
          headers: {
            'Content-Type': 'application/force-download'
          },
          data: {
            evaluationList
          },
          data2: data
        }

        $http(req).then(function(response) {}, function(response) {});

      }

      $scope.evaluationList = [];
      $http.get('../../api/v2/evaluacion/panel/comentarios/' + $scope.placeId).success(function(response) {

        for (var i = response.length - 1; i >= 0; i--) {
          response[i].info_ok = response[i].info_ok == 1
            ? "Si"
            : "No";
          response[i].privacidad_ok = response[i].privacidad_ok == 1
            ? "SI"
            : "No";
          response[i].comodo = response[i].comodo == 1
            ? "SI"
            : "No";
          response[i].es_gratuito = response[i].es_gratuito == 1
            ? "SI"
            : "No";
          response[i].informacion_vacunas = response[i].informacion_vacunas == 1
            ? "SI"
            : "No";
          response[i].que_busca = response[i].que_busca.split(',');

        }
        $scope.evaluationList = response;
      });

      if (typeof response[0] !== "undefined" && response[0] != 0) {
        if (typeof response[0].latitude !== "undefined" && response[0].latitude != 0) {
          var lat = response[0].latitude;
          var lon = response[0].longitude;


          var reg = new RegExp("^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}");
          if(isNaN(lat) || lat < -127 || lat > 75 || isNaN(lon) || lon < -127 || lon > 75){
            lat = 0;
            lon = 0;
          }
 

          var imageSize = Math.round($(window).width() / 2);

          var imageHeight = Math.round($(window).height() * 0.75);
          if ($(window).height() < 800) {
            imageHeight = Math.round($(window).height() / 3);
          }

          var formatedSize = imageSize + "x" + imageHeight;
          var googleMaps = "https://maps.googleapis.com/maps/api/staticmap?center=" + lat + "," + lon + "&zoom=14&size=" + formatedSize;
          googleMaps += "&markers=color:blue%7Clabel:C%7C" + lat + "," + lon;
          var streetView = "https://maps.googleapis.com/maps/api/streetview?size=" + formatedSize + "&location=" + lat + "," + lon + "&heading=100"
          $scope.googleMaps = googleMaps;
          $scope.streetView = streetView;
          $rootScope.place.position = [lat, lon];

          $scope.positions = [];
          $scope.positions.push($rootScope.place);
          $scope.center = [lat, lon];

          $scope.loading = false;

          $http.get('../../api/v1/countries/all').success(function(countries) {

            $scope.countries = countries;
            $scope.loadCity();
            $scope.showPartidos();
            $scope.showProvince();

          });
          var map = NgMap.initMap('mapEditor');

          map.panTo(new google.maps.LatLng(lat, lon));

        } else {
          var lat = 0;
          var lon = 0;

          var imageSize = Math.round($(window).width() / 2);

          var imageHeight = Math.round($(window).height() * 0.75);
          if ($(window).height() < 800) {
            imageHeight = Math.round($(window).height() / 3);
          }

          var formatedSize = imageSize + "x" + imageHeight;
          var googleMaps = "https://maps.googleapis.com/maps/api/staticmap?center=" + lat + "," + lon + "&zoom=14&size=" + formatedSize;
          googleMaps += "&markers=color:blue%7Clabel:C%7C" + lat + "," + lon;
          var streetView = "https://maps.googleapis.com/maps/api/streetview?size=" + formatedSize + "&location=" + lat + "," + lon + "&heading=100"
          $scope.googleMaps = googleMaps;
          $scope.streetView = streetView;
          $rootScope.place.position = [lat, lon];

          $scope.positions = [];
          $scope.positions.push($rootScope.place);
          $scope.center = [lat, lon];

          

          $http.get('../../api/v1/countries/all').success(function(countries) {

            $scope.countries = countries;
            $scope.loadCity();
            $scope.showPartidos();
            $scope.showProvince();

          });
          var map = NgMap.initMap('mapEditor');

          map.panTo(new google.maps.LatLng(lat, lon));
        }
      }
      $scope.loading = false;
    });
  });

  $scope.loadCity = function() {

    $scope.showCity = true;

    $http.get('../../api/v1/parties/' + $rootScope.place.idPartido + '/cities').success(function(cities) {
      $scope.cities = cities;
    });

  };

  $scope.showPartidos = function(){
    $scope.partidoOn = true;
    $http.get('../../api/v1/provinces/'+ $rootScope.place.idProvincia + '/partidos')
        .success(function(parties){
         $scope.parties = parties;
      });
  }

  $scope.showProvince = function() {

    $scope.provinceOn = true;
    $http.get('../../api/v1/countries/' + $rootScope.place.idPais + '/provinces').success(function(provinces) {
      $scope.provinces = provinces;
    });

  }

  function invalidForm() {

    return false;
  }

  $scope.formChange = function() {
    $rootScope.place.tipo = $scope.selectedType;
    if (invalidForm()) {
      $scope.invalid = true;
    } else {
      $scope.invalid = false;
    }
  };

  $scope.clickyDis = function() {

    if (confirm("Desea realmente rechazar la peticion de la lugar " + $rootScope.place.establecimiento + "?")) {

      $scope.spinerflag = true;

      $http.post('../../api/v1/panel/places/' + $rootScope.place.placeId + '/block').then(function(response) {
        if (response.data.length == 0) {
          Materialize.toast('Hemos rechazado a   ' + $rootScope.place.establecimiento, 5000);
          $rootScope.place.aprobado = 0;

        } else {
          for (var propertyName in response.data) {
            Materialize.toast(response.data[propertyName], 10000);
          };
        }

        $scope.spinerflag = false;

      }, function(response) {
        Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
        $scope.spinerflag = false;
      });
    }
  };
  $scope.clickyApr = function() {

    if (confirm("Desea realmente aprobar la peticion de la lugar " + $rootScope.place.establecimiento + "?")) {

      $scope.spinerflag = true;

      $http.post('../../api/v1/panel/places/' + $rootScope.place.placeId + '/approve').then(function(response) {
        if(!response.data){
          Materialize.toast('Ocurrió un error al procesar los datos ingresados, por favor verifique la base de datos.', 5000);
        }
        else if(response.data.length == 0) {
          Materialize.toast('Hemos aprobado a   ' + $rootScope.place.establecimiento, 5000);
          $rootScope.place.aprobado = 1;

        } else {
          for (var propertyName in response.data) {
            Materialize.toast(response.data[propertyName], 10000);
          };
        }

        $scope.spinerflag = false;

      }, function(response) {
        Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
        $scope.spinerflag = false;
      });
    }
  };

  $scope.reloadRoute = function() {
    $route.reload();
  }

  function updateEvaluationStatus() {
    $http.get('../../api/v2/evaluacion/panel/comentarios/' + $scope.placeId).success(function(response) {

      for (var i = response.length - 1; i >= 0; i--) {
        response[i].info_ok = response[i].info_ok == 1
          ? "Si"
          : "No";
        response[i].privacidad_ok = response[i].privacidad_ok == 1
          ? "SI"
          : "No";
        response[i].comodo = response[i].comodo == 1
          ? "SI"
          : "No";
        response[i].informacion_vacunas = response[i].informacion_vacunas == 1
          ? "SI"
          : "No";
        response[i].es_gratuito = response[i].es_gratuito == 1
          ? "SI"
          : "No";
      }
      $scope.evaluationList = response;
    });

  }

  $scope.voteYes = function(evaluation) {
    $http.post('../../api/v2/evaluacion/panel/' + evaluation.id + '/approve').then(function(response) {
      if (response.data.length == 0) {
        Materialize.toast('Hemos aprobado la calificación', 3000);
        updateEvaluationStatus();

      } else {
        for (var propertyName in response.data) {
          Materialize.toast(response.data[propertyName], 5000);
        };
      }
    }, //del then
        function(response) {
      Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
    });
  }

  $scope.voteNo = function(evaluation) {
    $http.post('../../api/v2/evaluacion/panel/' + evaluation.id + '/block').then(function(response) {
      if (response.data.length == 0) {
        Materialize.toast('Hemos desaprobado la calificación', 3000);
        updateEvaluationStatus();

      } else {
        for (var propertyName in response.data) {
          Materialize.toast(response.data[propertyName], 5000);
        };
      }
    }, //del then
        function(response) {
      Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
    });
  }

  $scope.isCheckBoxChecked = function(d) {
    if (d == true || d == 1)
      return true;
    else
      return false;
      /*
      if (d === 1 || d === true){
        return true;
      }
      else {
        return false;
      }
      */
    }

  $scope.trackCiudad = function() {
    $scope.place.nombre_ciudad = $scope.place.ciudad.nombre_ciudad;
    $scope.place.idCiudad = $scope.place.ciudad.id;
  }

  $scope.clicky = function() {

    $scope.spinerflag = true;

    var httpdata = $rootScope.place;

    if (typeof $scope.otra_ciudad !== "undefined") {

      data["otra_ciudad"] = $rootScope.otra_ciudad;
      data["nombre_ciudad"] = $rootScope.otra_ciudad;

    }
    console.log(httpdata);
    $http.post('../../api/v1/panel/places/' + $rootScope.place.placeId + '/update', httpdata).then(function(response) {
      if (response.data.length == 0) {

        Materialize.toast('Hemos guardado los datos de  ' + $rootScope.place.establecimiento, 5000);
        //document.location.href = $location.path() + '../../panel';

      } else {
        for (var propertyName in response.data) {
          Materialize.toast(response.data[propertyName], 10000);
        };
      }
      $scope.spinerflag = false;
    }, function(response) {
      Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
      $scope.spinerflag = false;
    });

  };

  // TODO: reemplazar por contenido dinamico
  $scope.checkboxService = [];
  setUpServices();

  function setUpServices(){
    $scope.services = copyService.getAll();
    $scope.selectedServiceList = [];
    for (var i = 0; i < $scope.services.length; i++) {
      if($scope.services[i].show_on_home)
        $scope.selectedServiceList.push($scope.services[i].codeAlt)
    }
  }

  $scope.toggle = function(shortname) {
    var idx = $scope.selectedServiceList.indexOf(shortname);
    if (idx > -1) {
      $scope.selectedServiceList.splice(idx, 1);
    } else {
      $scope.selectedServiceList.push(shortname);
    }
  };

  $scope.exists = function(shortname) {
    var b = $scope.selectedServiceList.indexOf(shortname) > -1;
    return b;
  };

  $scope.isIndeterminate = function() {
    return ($scope.selectedServiceList.length !== 0 && $scope.selectedServiceList.length !== $scope.services.length);
  };

  $scope.isChecked = function() {
    return $scope.selectedServiceList.length === $scope.services.length;
  };

  $scope.toggleAll = function() {
    if ($scope.selectedServiceList.length === $scope.services.length) {
      $scope.selectedServiceList = [];
    } else if ($scope.selectedServiceList.length === 0 || $scope.selectedServiceList.length > 0) {
      $scope.selectedServiceList = $scope.services.slice(0);
    }
  };

  $scope.serviceFilter = function(evaluation) {
    var a = $scope.selectedServiceList.indexOf(evaluation.service);
    return a > -1;
  };

  $scope.exportEvaluationsFilterByService = function(placeId) {
    //$rootScope.loadingPost = true;

    var f = document.createElement("form");
    f.setAttribute('method', "post");
    f.setAttribute('action', "../../panel/importer/evaluationsExportFilterByService");
    f.style.display = 'none';
    var i1 = document.createElement("input"); //input element, text
    i1.setAttribute('type', "hidden");
    i1.setAttribute('name', "placeId");
    i1.setAttribute('value', placeId);

    $scope.selectedServiceList.map(function(m){
      if (m == 'vacunatorio'){
        $scope.selectedServiceList.push('vacunatorios');
      };
      if (m == 'infectologia'){
        $scope.selectedServiceList.push('cdi');
      }
    })
    var i2 = document.createElement("input"); //input element, text
    i2.setAttribute('type', "hidden");
    i2.setAttribute('name', "selectedServiceList");
    i2.setAttribute('value', $scope.selectedServiceList);

    var s = document.createElement("input"); //input element, Submit button
    s.setAttribute('type', "submit");
    s.setAttribute('value', "Submit");
    s.setAttribute('display', "hidden");

    f.appendChild(i1);
    f.appendChild(i2);
    f.appendChild(s);

    document.getElementsByTagName('body')[0].appendChild(f);
    f.submit();
    document.removeChild(f);

  };

  $scope.showCondonIcon = function(service, icon) {

    return service == icon;
  };

});
