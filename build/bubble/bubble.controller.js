(function() {
  'use strict';

  function bubbleController($scope) {
  }

  const dependencies = ['$scope'];
  dependencies.push(bubbleController);
  app.controller('bubbleCtrl', dependencies);
}());
