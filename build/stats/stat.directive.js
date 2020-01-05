(function() {
  'use strict';

  function statDirective() {
    return {
      restrict: 'E',
      replace: true,
      transclude: false,
      scope: {
        name: '=',
        value: '='
      },
      templateUrl: '/templates/stat.template.html',
      controller: 'statCtrl',
    };
  }

  app.directive('statBlock', [statDirective]);
}());
