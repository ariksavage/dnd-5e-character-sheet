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
    service.equippedArmor = function() {
      if (!service.inventory){
        return false;
      }
      const inv = service.inventory;
      const armor = inv.filter(item => {
        let isArmor = item.type.indexOf('armor') > -1;
        let isEquipped = item.equipped;
        return isArmor && isEquipped;
      });
      return armor;
    }
    service.statCalc = function(text){
      const dex = service.stat('dex').bonus;
      text = text.replace('dex', dex);
      const str = service.stat('str').bonus;
      text = text.replace('str', str);
      const con = service.stat('con').bonus;
      text = text.replace('con', con);
      const cha = service.stat('cha').bonus;
      text = text.replace('cha', cha);
      const int = service.stat('int').bonus;
      text = text.replace('int', int);
      const wis = service.stat('wis').bonus;
      text = text.replace('wis', wis);
      let val = eval(text);
      return val;     
    }
    service.armorClass = function() {
      let ac = 0;
      const armor = service.equippedArmor();
      if (armor.length > 0){
        for (let i=0; i < armor.length; i++) {
          let arm = armor[i];
          let a = service.statCalc(arm.ac);
          ac += a;
        }
      } else {
        ac = 10;
      }
      return ac;
    }
    service.savingThrows = function(){
      const throws = [];
      if(service.jobs){
        service.jobs.forEach(job => {
          throws.push(job.saving_throw_prof_1);
          throws.push(job.saving_throw_prof_2);
        });
      }
      return throws;
    }
    service.proficiencies = function(type = null) {
      const prof = [];

      if(service.jobs && service.jobs.length > 0){
        for (let i=0; i<service.jobs.length; i++){
          for (let j=0; j<service.jobs[i].proficiencies.length; j++){
            if(!type || service.jobs[i].proficiencies[j].type == type){
              prof.push(service.jobs[i].proficiencies[j]);
            }
          }
        }
      }

      if (service.background) {
        for (let k=0; k < service.background.proficiencies.length; k++) {
          if(!type || service.background.proficiencies[k].type == type){
            prof.push(service.background.proficiencies[k]);
          }
        }
      }
      return prof;
    }

    service.load = function(id) {
      return api.get('character', 'get', id).then(
        response => {
          const character = response.data;
          api.get('job','getJobsByPC',id).then( response => {
            character.jobs = response.data;
            race.load(character.race).then( response => {
              character.race = angular.copy(race);
              for (let i=0; i<race.abilities.length; i++){
                character.abilities.push(race.abilities[i]);
              }
              angular.merge(service, character);
            });
          });
        }
      )
    }
    
    return service;
  }

  
  const dependencies =['stat'];
  dependencies.push('api');
  dependencies.push('race');
  dependencies.push('$http');
  dependencies.push(characterService);
  app.factory('character', dependencies);
}());
