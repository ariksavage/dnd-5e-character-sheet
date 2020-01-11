<html ng-app="Sheet" ng-controller="sheetCtrl">
<head>
  <meta charset="utf-8"/>
  <base href="/">
  <title>D&D 5e Sheet</title>
  <link rel="stylesheet" href="/css/main.css"/>
  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="/img/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/img/favicons/favicon-16x16.png">
  <link rel="manifest" href="/img/favicons/site.webmanifest">
  <link rel="mask-icon" href="/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="/img/favicons/favicon.ico">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-config" content="/img/favicons/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">
</head>
<body>
  <div class="filters">
    <div class="radio" ng-repeat="m in modes" ng-click="setMode(m)" ng-class="{'active': m == mode}">
      {{m}}
    </div>
  </div>
  <header class="sheet-header">
    <div class="character-name">
      <input-group value="char.name" label="character name"></input-group>
    </div>
    <div class="character-data">
      <input-group class="class" value="char.classes()" label="class"></input-group>
      <input-group class="level" value="char.level()" label="level"></input-group>
      <input-group class=" background" value="char.background.name" label="background"></input-group>
      <input-group class="player" value="char.player" label="player name"></input-group>
      <input-group class="race" value="char.race.name" label="race"></input-group>
      <div class="input-group alignment">
        <select ng-model="char.alignment_law" ng-options=" a for a in game.alignments.law"></select>
        <select ng-model="char.alignment_good" ng-options=" a for a in game.alignments.good"></select>
        <label class="label">Alignment</label>
      </div>
      <input-group value="char.exp" label="experience"></input-group>
      <input-group value="char.deity" label="deity"></input-group>
    </div>
  </header>
    
  <div class="stats">
    <stat-block ng-repeat="stat in game.stats" name="stat" value="char.stat(stat).value"></stat-block>
  </div>
  <main class="sheet-main">
    <block title="portrait" class="character-image portrait">
      <img ng-src="{{char.image_face}}"/>
    </block>
    <block title="Skills" class="skills" ng-if="isMode('social')">
      <table>
        <tbody>
          <tr class="skill" ng-repeat="skill in char.skills">
            <td>
              <bubble fill="skill.proficiency" ring="skill.expertise"></bubble>
            </td>
            <td class="value"> {{char.stat(skill.stat).bonus}}</td>
            <td class="name"> {{skill.name}} <span class="skill-stat">({{skill.stat}})</span></td>
          </tr>
        </tbody>
      </table>
      <!-- non skill proficiencies -->
    </block>
    <block title="Saving Throws" class="saving-throws" ng-if="isMode('social')">
      <table>
        <tbody>
          <tr class="saving-throw" ng-repeat="stat in game.stats">
            <td>
              <bubble fill="char.savingThrows().indexOf(stat.slice(0, 3).toLowerCase()) > -1"></bubble>
            </td>
            <td class="value">{{char.stat(stat).value}}</td>
            <td class="name">{{stat}}</td>
          </tr>
        </tbody>
      </table>
    </block>
    <block title="Languages" class="languages"  ng-if="isMode('social')" ng-if="isMode('social')">
      <ul>
        <li ng-repeat="language in char.languages">{{language.name}}</li>
      </ul>
    </block>
    <block title="Proficiencies" class="proficiencies two-col" ng-if="isMode('combat')">
      <div class="set">
        <h4>Weapons</h4>
        <ul>
          <li ng-repeat="proficiency in char.proficiencies('weapon')">{{proficiency.name}}</li>
        </ul>
      </div>
      <div class="set">
        <h4>Armor</h4>
        <ul>
          <li ng-repeat="proficiency in char.proficiencies('armor')">{{proficiency.name}}</li>
        </ul>
      </div>
      <div class="set">
      <h4>Tools</h4>
      <ul>
        <li ng-repeat="proficiency in char.proficiencies('tool')">{{proficiency.name}}</li>
      </ul>
      </div>
    </block>
    <block title="Attacks & Spellcasting" class="attacks-spellcasting" ng-if="isMode('combat')">
      <table>
        <thead>
          <tr>
            <td>Proficiency</td>
            <td>Name</td>
            <td>Attack Bonus</td>
            <td> Damage/Type</td>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="a in char.weapons()" class="attack">
            <td class="proficiency"><buuble></buuble></td>
            <td class="name">{{a.name}}</td>
            <td class="bonus" >{{a.damage_dice}}d{{a.damage_sides}}</td>
            <td class="type">{{a.damage_type}}</td>
          </tr>
        </tbody>
      </table>
    </block>
    <div class="alt-stats" ng-if="isMode('combat')">
      <input-group class="inspiration horizontal" value="char.inspiration" label="Inspiration"></input-group>
      <input-group class="proficiency horizontal" value="char.proficiency" label="Proficiency Bonus"></input-group>
      <div class="row">
        <input-group class="inline armor-class filigre-shield" value="char.armorClass()" label="Armor Class"></input-group>
        <input-group class="inline initiative filigre-square" value="char.initiative" label="Initiative"></input-group>
        <input-group class="inline speed filigre-square" value="char.race.speed" label="Speed"></input-group>
      </div>
    </div>
    <block title="Hit Points" class="hit-points" ng-if="isMode('combat')">
      <p>Hit point maximum: <input type="number" ng-model="char.hp_max"/></p>
      <p>Current Hit points: <input type="number" ng-model="char.hp"/></p>
      <p>Temporary HP: <input type="number" ng-model="char.hp"/></p>
    </block>
    <block title="Hit Dice" class="hit-dice" ng-if="isMode('combat')">
      <p>Total: {{char.hp_max}}</p>
      <p>{{char.hitDice()}}</p>
    </block>
    <block title="Death Saves" class="death-saves" ng-if="isMode('combat')">
      <div class="success saves">
        <label>Successes:</label>
        <div class="inline dot">
          <input class="check" type="checkbox" ng-checked="char.death_save_success > 0"/>
          <span class="bubble"></span>
        </div>
        <div class="inline dot">
          <input class="check" type="checkbox" ng-checked="char.death_save_success > 1"/>
          <span class="bubble"></span>
        </div>
        <div class="inline dot">
          <input class="check" type="checkbox" ng-checked="char.death_save_success > 2"/>
          <span class="bubble"></span>
        </div>
      </div>
      <div class="failure saves">
        <label>Failures:</label>
          <div class="inline dot">
            <input class="check" type="checkbox" ng-checked="char.death_save_failure > 0"/>
            <span class="bubble"></span>
          </div>
          <div class="inline dot">
            <input class="check" type="checkbox" ng-checked="char.death_save_failure > 1"/>
            <span class="bubble"></span>
          </div>
          <div class="inline dot">
            <input class="check" type="checkbox" ng-checked="char.death_save_failure > 2"/>
            <span class="bubble"></span>
          </div>
      </div>
    </block>
    <block title="Abilities" class="abilities" ng-if="isMode('combat')">
      <h3 ng-repeat="ability in char.abilities" title="{{ability.description}}">{{ability.name}}</h3>
    </block>
    <block title="Personality Traits" class="personality-traits" ng-if="isMode('character')" ng-if="isMode('character')">
      <textarea ng-model="char.personalityTraits"></textarea>
    </block>
    <block title="Ideals" class="ideals" ng-if="isMode('character')">
      <textarea ng-model="char.ideals"></textarea>
    </block>
    <block title="Bonds" class="bonds" ng-if="isMode('character')">
      <textarea ng-model="char.bonds"></textarea>
    </block>
    <block title="Flaws" class="flaws" ng-if="isMode('character')">
      <textarea ng-model="char.flaws"></textarea>
    </block>
    <block title="equipment" ng-if="isMode('inventory')">
      <div ng-repeat="slot in char.equipSlots()" class="slot {{slot}}">
        {{slot.toUpperCase().replace('_',' ')}} 
        <select ng-model="char.equipment[slot]" ng-options="item.name for item in char.itemsBySlot(slot)">
          <option value="">- {{slot}} -</option>
        </select>
      </div>
      <div class="slot hand two" ng-if="!char.equipment.left_hand && !char.equipment.right_hand">
        TWO HAND
        <select ng-model="char.equipment.both_hands" ng-options="item.name for item in char.itemsBySlot('two-hand')">
          <option value="">- two hands -</option>
        </select>
      </div>
      <div class="slot hand left" ng-if="!char.equipment.both_hands">
        LEFT HAND
        <select ng-model="char.equipment.left_hand" ng-options="item.name for item in char.itemsBySlot('one-hand')">
          <option value="">- left hand -</option>
        </select>
      </div>
      <div class="slot hand right" ng-if="!char.equipment.both_hands">
        RIGHT HAND
        <select ng-model="char.equipment.right_hand" ng-options="item.name for item in char.itemsBySlot('one-hand')">
          <option value="">- right hand -</option>
        </select>
      </div>
    </block>
    <block title="inventory" class="inventory" ng-if="isMode('inventory')">
      <table>
        <tbody>
          <tr ng-repeat="item in char.inventory">
            <td>{{item.name}}</td>
            <td>{{item.description}}</td>
            <td>{{item.qty}}</td>
          </tr>
        </tbody>
      </table>
    </block>
    
  </main>
  <script type="text/javascript" src="/js/angular.min.js"></script>
  <script type="text/javascript" src="/js/angular-route.min.js"></script>
  <script src="/js/app.js"></script>
  <script src="/js/services.js"></script>
  <script src="/js/directives.js"></script>
  <script src="/js/controllers.js"></script>
  <!-- <script src="/js/filters.js"></script> -->
</body>
</html>
