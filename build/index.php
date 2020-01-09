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
  <header class="sheet-header">
    <div class="character-name">
      <input-group value="char.name" label="character name"></input-group>
    </div>
    <div class="character-data">
      <input-group value="char.classes()" label="class"></input-group>
      <input-group value="char.level()" label="level"></input-group>
      <input-group value="char.background.name" label="background"></input-group>
      <input-group value="char.player" label="player name"></input-group>
      <input-group value="char.race.name" label="race"></input-group>
      <input-group value="char.alignment_law+' '+char.alignment_good" label="alignment"></input-group>
      <input-group value="char.exp" label="experience"></input-group>
      <input-group value="char.deity" label="deity"></input-group>
    </div>
  </header>
  <main class="sheet-main">
    <div class="column stats">
      <stat-block ng-repeat="stat in stats" name="stat" value="char.stat(stat).value"></stat-block>
    </div>
    <div class="column">
      <input-group class="inspiration" value="char.inspiration" label="Inspiration"></input-group>
      <input-group class="proficiency" value="char.proficiency" label="Proficiency Bonus"></input-group>
      <div class="saving-throws block filigre">
        <table>
          <tbody>
            <tr class="saving-throw" ng-repeat="stat in stats">
              <td class="dot">
                <input class="check" type="checkbox" ng-checked="char.saving_throws.indexOf(stat.slice(0, 3).toLowerCase()) > -1"/>
                <span class="bubble"></span>
              </td>
              <td class="value">{{char.stat(stat).value}}</td>
              <td class="name">{{stat}}</td>
            </tr>
          </tbody>
        </table>
          <h4 class="block-title"> Saving Throws</h4>
        </div>
      
        <div class="block filigre skills">
          <table>
            <tbody>
              <tr class="skill" ng-repeat="skill in char.skills">
                <td class="dot" ng-class="{'expertise': skill.expertise}">
                <input class="check" type="checkbox" ng-checked="skill.proficiency || skill.expertise"/>
                <span class="bubble"></span>
              </td>
              <td class="value"> {{char.stat(skill.stat).value}}</td>
              <td class="name"> {{skill.name}} <span class="skill-stat">({{skill.stat}})</span></td>
            </tr>
          </tbody>
          <h4 class="block-title"> Skills</h4>
        </table>
      </div>
    </div>
    <div class="column">
      <div class="row">
        <input-group class="inline armor-class" value="char.armorClass()" label="Armor Class"></input-group>
        <input-group class="inline initiative" value="char.initiative" label="Initiative"></input-group>
        <input-group class="inline speed" value="char.race.speed" label="Speed"></input-group>
      </div>
      <div class="row">
        <div class="block filigre hp">
          <p>Hit point maximum: <input type="number" ng-model="char.hp_max"/></p>
          <p>Current Hit points: <input type="number" ng-model="char.hp"/></p>
          <p>Temporary HP: <input type="number" ng-model="char.hp"/></p>
        </div>
      </div>
      <div class="block filigre hit-dice">
        <p>Total: {{char.hp_max}}</p>
        <p>{{char.hitDice()}}</p>
        <h4 class="block-title">Hit Dice</h4>
      </div>
      <div class="block filigre death-saves">
        <p>Successes: 
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
        </p>
        <p>Failures: 
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
        </p>
        <h4 class="block-title">Death Saves</h4>
      </div>
      <div class="block filigre attacks">
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
        <h4 class="block-title">Attacks & Spellcasting</h4>
      </div>
    </div>
    <div class="column">
      <div class="block filigre personality-traits">
        <textarea ng-model="char.personalityTraits"></textarea>
        <h4 class="block-title">Personality Traits</h4>
      </div>
      <div class="block filigre ideals">
        <textarea ng-model="char.ideals"></textarea>
        <h4 class="block-title">Ideals</h4>
      </div>
      <div class="block filigre bonds">
        <textarea ng-model="char.bonds"></textarea>
        <h4 class="block-title">Bonds</h4>
      </div>
      <div class="block filigre flaws">
        <textarea ng-model="char.flaws"></textarea>
        <h4 class="block-title">Flaws</h4>
      </div>
      <div class="block filigre features-traits">
        <textarea ng-model="char.featuresTraits"></textarea>
        <h4 class="block-title">FEATURES & TRAITS</h4>
      </div>
      <div class="block filigre abilities">
        <h3 ng-repeat="ability in char.abilities" title="{{ability.description}}">{{ability.name}}</h3>
        <h4 class="block-title">Abilities</h4>
      </div>
      <div class="block filigre proficiencies">
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
        <h4 class="block-title">PROFICIENCIES</h4>
      </div>
      <div class="block filigre languages">
        <ul>
          <li ng-repeat="language in char.languages">{{language.name}}</li>
        </ul>
        <h4 class="block-title">LANGUAGES</h4>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="/js/angular.min.js"></script>
  <script type="text/javascript" src="/js/angular-route.min.js"></script>
  <script src="/js/app.js"></script>
  <script src="/js/services.js"></script>
  <script src="/js/directives.js"></script>
  <script src="/js/controllers.js"></script>
  <!-- <script src="/js/filters.js"></script> -->
</body>
</html>
