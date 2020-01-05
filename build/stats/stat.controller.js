(function() {
  'use strict';

  function statController($scope, $location, stat) {
    $scope.test = 'Angular';
    $scope.bonus = function(){
      return stat.bonus($scope.value);
    }
  }

  const dependencies = ['$scope'];
  dependencies.push('$location');
  dependencies.push('stat');
  dependencies.push(statController);
  app.controller('statCtrl', dependencies);
}());
