(function() {
  'use strict';

  function blockController($scope) {
  }

  const dependencies = ['$scope'];
  dependencies.push(blockController);
  app.controller('blockCtrl', dependencies);
}());
