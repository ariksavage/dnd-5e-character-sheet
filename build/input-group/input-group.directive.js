(function() {
  'use strict';

  function inputGroupDirective() {
    return {
      restrict: 'E',
      replace: true,
      transclude: false,
      scope: {
        label: '@',
        value: '='
      },
      templateUrl: '/templates/input-group.template.html',
      controller: 'inputGroupCtrl',
    };
  }

  app.directive('inputGroup', [inputGroupDirective]);
}());
