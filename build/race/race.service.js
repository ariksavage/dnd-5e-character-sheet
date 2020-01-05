(function() {
  'use strict';

  function raceService(stat, api, $http) {
    let service = {};
    service.load = function(id){
      return api.get('race', 'get', id).then(
      response => {
        console.log('race load', response);
        const race = response.data;
        angular.merge(service, race);
      }
    )}
    return service;
  }
  
  const dependencies =['stat'];
  dependencies.push('api');
  dependencies.push('$http');
  dependencies.push(raceService);
  app.factory('race', dependencies);
}());
