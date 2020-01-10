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
  <main class="sheet-main social" ng-if="isMode('social')">
    <block title="Skills" class="skills">
      <table>
        <tbody>
          <tr class="skill" ng-repeat="skill in char.skills">
            <td>
              <bubble fill="skill.proficiency" ring="skill.expertise"></bubble>
            </td>
            <td class="value"> {{char.stat(skill.stat).value}}</td>
            <td class="name"> {{skill.name}} <span class="skill-stat">({{skill.stat}})</span></td>
          </tr>
        </tbody>
      </table>
    </block>
    <div class="row">
      <input-group class="inspiration horizontal" value="char.inspiration" label="Inspiration"></input-group>
      <input-group class="proficiency horizontal" value="char.proficiency" label="Proficiency Bonus"></input-group>
    </div>
    <block title="Saving Throws" class="saving-throws">
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
    <block title="Languages" class="languages"  ng-if="isMode('social')">
      <ul>
        <li ng-repeat="language in char.languages">{{language.name}}</li>
      </ul>
    </block>
  </main>
  <main class="sheet-main combat" ng-if="isMode('combat')">
    <block title="Proficiencies" class="proficiencies two-col">
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
    <block title="Attacks & Spellcasting" class="attacks-spellcasting" >
      <table>
        <thead>
          <tr>
            <td>Name</td>
            <td>Attack Bonus</td>
            <td> Damage/Type</td>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="a in char.attacks" class="attack">
            <td class="name">{{a.name}}</td>
            <td class="bonus" >{{a.atkBonus}}</td>
            <td class="type">{{a.damageType}}</td>
          </tr>
        </tbody>
      </table>
    </block>
    <div class="row ac-init-speed">
      <input-group class="inline armor-class filigre-shield" value="char.armorClass()" label="Armor Class"></input-group>
      <input-group class="inline initiative filigre-square" value="char.initiative" label="Initiative"></input-group>
      <input-group class="inline speed filigre-square" value="char.race.speed" label="Speed"></input-group>
    </div>
    <block title="Hit Points" class="hit-points" >
      <p>Hit point maximum: <input type="number" ng-model="char.hp_max"/></p>
      <p>Current Hit points: <input type="number" ng-model="char.hp"/></p>
      <p>Temporary HP: <input type="number" ng-model="char.hp"/></p>
    </block>
    <block title="Hit Dice" class="hit-dice" >
      <p>Total: {{char.hp_max}}</p>
      <p>{{char.hitDice()}}</p>
    </block>
    <block title="Death Saves" class="death-saves">
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
    <block title="Features & Traits" class="features-traits" >
      <textarea ng-model="char.featuresTraits"></textarea>
    </block>
    <block title="Abilities" class="abilities">
      <h3 ng-repeat="ability in char.abilities" title="{{ability.description}}">{{ability.name}}</h3>
    </block>
  </main>
  <main class="sheet-main character" ng-if="isMode('character')">
    <block title="Personality Traits" class="personality-traits" ng-if="isMode('character')">
      <textarea ng-model="char.personalityTraits"></textarea>
    </block>
    <block title="Ideals" class="ideals">
      <textarea ng-model="char.ideals"></textarea>
    </block>
    <block title="Bonds" class="bonds">
      <textarea ng-model="char.bonds"></textarea>
    </block>
    <block title="Flaws" class="flaws">
      <textarea ng-model="char.flaws"></textarea>
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
