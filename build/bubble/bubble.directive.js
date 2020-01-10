(function() {
  'use strict';

  function bubbleDirective() {
    return {
      restrict: 'E',
      replace: false,
      transclude: true,
      scope: {
        fill: '=',
        ring: '=?'
      },
      templateUrl: '/templates/bubble.template.html',
      controller: 'bubbleCtrl',
    };
  }

  app.directive('bubble', [bubbleDirective]);
}());
