(function() {
  'use strict';

  function characterService(stat, api, race, $http) {
    let service = {};
    service.stat = function(statName) {
        let stat = statName.slice(0, 3).toLowerCase();
        let base = this[stat];
        let val = base;
        if (this.race) {
          let raceBonus = this.race[stat] || 0;
          val = val + raceBonus;
        }

        if (this.feats){
          // Add any bonuses from feats
          this.feats.forEach(feat => {
            val += feat[stat] || 0;
          });
        }
        return {
          name: statName,
          value: val,
          bonus: Math.floor((val - 10) / 2)
        }
      }
    service.classes = function(){
      if (!service.jobs){
        return false;
      }
      let classes = '';
      service.jobs.forEach(job => {
        if (classes != ''){
          classes +=', ';
        }
        classes += job.name;
        if (service.jobs.length > 1){
          classes += ' ('+job.level+')';
        }
      });
      return classes;
    }
    service.level = function(){
      if (!service.jobs){
        return false;
      }
      let lvl = 0;
      service.jobs.forEach(job => {
        lvl += job.level;
      });
      return lvl;
    }
    service.hitDice = function(){
      if (!service.jobs){
        return false;
      }
      let dice = '';
      service.jobs.forEach(job => {
        if (dice != ''){
          dice +=', ';
        }
        dice += job.level+' D'+job.hit_die;
      });
      return dice;
    }
    service.armorClass = function(){
      const dex = service.stat('dex').bonus;
      let base = 10; // or armor worn;
      return dex + base;
    }

    service.load = function(id) {
      return api.get('character', 'get', id).then(
      response => {
        const character = response.data;
        console.log('race', character.race);
        race.load(character.race).then( response => {

          character.race = angular.copy(race);
          angular.merge(service, character);
        });
        
      }
    )}
    
    return service;
  }

  
  const dependencies =['stat'];
  dependencies.push('api');
  dependencies.push('race');
  dependencies.push('$http');
  dependencies.push(characterService);
  app.factory('character', dependencies);
}());
