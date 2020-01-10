(function() {
  'use strict';

  function sheetController($scope, $location, game, character) {
    $scope.char = character;
    $scope.game = game;
    character.load(1);
    $scope.mode = 'inventory';
    $scope.modes = ['all', 'combat', 'social', 'character', 'inventory'];
    $scope.setMode = function(m) {
      $scope.mode = m;
    }
    $scope.isMode = function(m){
      return $scope.mode == 'all' || $scope.mode == m;
    }
  }

  const dependencies = ['$scope'];
  dependencies.push('$location');
  dependencies.push('game');
  dependencies.push('character');
  dependencies.push(sheetController);
  app.controller('sheetCtrl', dependencies);
}());
