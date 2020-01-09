(function() {
  'use strict';
  app.factory('api', ['$http',   function($http) {
    const service = {};

    service.get = function(type, action, param = null) {
      let url = '/api/'+type+'/'+action;

      if (param){
        url += '/'+param;
      }
      const promise = $http.get(url).then(
        success => {
          return success;
        },
        error => {
          console.error(error);
          alert("Unable to connect to API");
        }
      );
      return promise;
    }
    return service;
  }]);
}());
