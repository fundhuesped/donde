dondev2App.controller('partyMapController',
  function(placesFactory, NgMap, copyService, $scope, $rootScope, $routeParams, $location, $http) {
    //controlador para busqueda escrita
    $rootScope.$watch('currentMarker', function() {
      $scope.currentMarker = $rootScope.currentMarker;
    })

    // Verificar que exista cargado un establecimiento
    checkCurrentMarker();
    function checkCurrentMarker(){
      if(!$rootScope.currentMarker || !$scope.currentMarker)
        window.history.back();
    }

    $scope.voteLimit = 5;

    $rootScope.main = false;
    $rootScope.geo = false;

    $scope.city = $routeParams.partido.split('-')[1];
    $scope.cityId = $routeParams.partido.split('-')[0];

    $scope.province = $routeParams.provincia.split('-')[1];
    $scope.provinceId = $routeParams.provincia.split('-')[0];

    $scope.country = $routeParams.pais.split('-')[1];
    $scope.countryId = $routeParams.pais.split('-')[0];

    $scope.serviceCode =  $routeParams.servicio.toLowerCase();
    $scope.service = copyService.getFor($routeParams.servicio);
    $rootScope.navBar = $scope.service;

    var search = {

      partido: $scope.cityId,
      provincia: $scope.provinceId,
      pais: $scope.countryId,
      service: $routeParams.servicio.toLowerCase(),

    };
    search[$routeParams.servicio.toLowerCase()] = true;

    $scope.addComment = function() {
      $scope.voteLimit++;
    }

    $scope.nextShowUp = function(item) {

      var urlCount = "api/v2/evaluacion/cantidad/" + item.placeId;
      $http.get(urlCount)
      .then(function(response) {
        item.votes = response.data[0];
      });

      var urlRate = "api/v2/evaluacion/promedio/" + item.placeId;
      $http.get(urlRate)
      .then(function(response) {
        item.rate = response.data[0];
        item.faceList = [{
          id: '1',
          image: '1',
          imageDefault: '1',
          imageBacon: '1active'
        },
        {
          id: '2',
          image: '2',
          imageDefault: '2',
          imageBacon: '2active'
        },
        {
          id: '3',
          image: '3',
          imageDefault: '3',
          imageBacon: '3active'
        },
        {
          id: '4',
          image: '4',
          imageDefault: '4',
          imageBacon: '4active'
        },
        {
          id: '5',
          image: '5',
          imageDefault: '5',
          imageBacon: '5active'
        }
        ];


        var pos = -1;
        for (var i = 0; i < item.faceList.length; i++) {
          item.faceList[i].image = item.faceList[i].imageDefault;
          if (item.faceList[i].id == item.rate) pos = i;
        }
          //si tiene votos cambio el color
          if (pos != -1)
            item.faceList[pos].image = item.faceList[pos].imageBacon;
        });

      var urlComments = "api/v2/evaluacion/comentarios/" + item.placeId;
      item.comments = [];
      $http.get(urlComments)
      .then(function(response) {
        item.comments = response.data;

      });

      $rootScope.currentMarker = item;
      $rootScope.centerMarkers.push($rootScope.currentMarker);

      //con esto centro el mapa en el place correspondiente
      $location.path('/localizar' + '/' + $routeParams.servicio + '/mapa');

    }


    $scope.showCurrent = function(i, p) {
      $rootScope.navBar = p.establecimiento;
      $scope.currentMarker = p;
    }

    $scope.closeCurrent = function() {
      $scope.currentMarker = undefined;
    }

    // if ($rootScope.places.length > 0 && $rootScope.currentMarker) {
    //   $rootScope.centerMarkers.push($rootScope.currentMarker);
    // }
    // else {
    //   placesFactory.getAllFor(search, function(data) {
    //     $rootScope.places = $scope.places = data;
    //     $rootScope.currentMarker = $scope.currentMarker = $scope.places[0];
    //     $rootScope.centerMarkers.push($rootScope.currentMarker);
    //   })
    // }
  });
