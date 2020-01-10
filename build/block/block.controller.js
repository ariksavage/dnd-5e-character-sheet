(function() {
  'use strict';

  function blockController($scope) {
    $scope.collapse = false;
    $scope.toggleCollapse = function(){
      $scope.collapse = !$scope.collapse;
    }
  }

  const dependencies = ['$scope'];
  dependencies.push(blockController);
  app.controller('blockCtrl', dependencies);
}());
