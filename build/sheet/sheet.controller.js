(function() {
  'use strict';

  function sheetController($scope, $location, character) {
    $scope.char = character;
    character.load(1);
    //test
    $scope.stats = [
      'Charisma',
      'Constitution',
      'Dexterity',
      'Intelligence',
      'Strength',
      'Wisdom'
    ];
  }

  const dependencies = ['$scope'];
  dependencies.push('$location');
  dependencies.push('character');
  dependencies.push(sheetController);
  app.controller('sheetCtrl', dependencies);
}());
