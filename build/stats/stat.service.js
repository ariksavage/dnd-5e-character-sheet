(function() {
  'use strict';

  function statService() {
    const service = {};
    service.bonus = function(V) {
      return Math.floor((V-10) / 2);
    }
    service.new = function(name, value){
      return {
        name: name,
        value: value
      }
    }
    return service;
  }

  const dependencies = [statService];
  app.factory('stat', dependencies);
}());
