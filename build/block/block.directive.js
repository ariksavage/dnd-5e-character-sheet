(function() {
  'use strict';

  function blockDirective() {
    return {
      restrict: 'E',
      replace: true,
      transclude: true,
      scope: {
        title: '@',
      },
      templateUrl: '/templates/block.template.html',
      controller: 'blockCtrl',
    };
  }

  app.directive('block', [blockDirective]);
}());
