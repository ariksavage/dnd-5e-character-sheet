(function() {
  'use strict';

  function sheetController($scope, $location, game, character) {
    $scope.char = character;
    $scope.game = game;
    character.load(1);
  }

  const dependencies = ['$scope'];
  dependencies.push('$location');
  dependencies.push('game');
  dependencies.push('character');
  dependencies.push(sheetController);
  app.controller('sheetCtrl', dependencies);
}());
