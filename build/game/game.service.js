(function() {
  'use strict';

  function gameService() {
    let game = {};
    game.stats = [
      'Charisma',
      'Constitution',
      'Dexterity',
      'Intelligence',
      'Strength',
      'Wisdom'
    ];
    game.alignments = {
      law: ['Lawful', 'Neutral', 'Chaotic'],
      good: ['Good', 'Neutral', 'Evil']
    };
    return game;
  }
  
  const dependencies =[gameService];
  app.factory('game', dependencies);
}());
