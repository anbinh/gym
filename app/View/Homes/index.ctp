
<div ng-app="App" ng-controller="ListController" layout="column" layout-align="top right">
  <md-toolbar>
  	<div class="md-toolbar-tools">
  		<span class="md-flex">Flickr Search</span>
  	</div>
  </md-toolbar>
  <md-content layout="column" layout-align="center center">
  	<div class="app-content">
  		<form ng-submit="search()">
  			<md-text-float class="long" label="Search for" ng-model="searchTerm"></md-text-float>
  		</form>
  		<md-card ng-repeat="picture in results.photos.photo">
  			<img ng-src="http://farm{{picture.farm}}.staticflickr.com/{{picture.server}}/{{picture.id}}_{{picture.secret}}_b.jpg" class="md-card-image"/>
  			<h3>{{picture.title}}</h3>
  		</md-card>
  	</div>
      <section layout="row" layout-sm="column" layout-align="center center">
          <md-button class="md-raised">Button</md-button>
          <md-button class="md-raised md-primary">Primary</md-button>
          <md-button ng-disabled="true" class="md-raised md-primary">Disabled</md-button>
          <md-button class="md-raised md-warn">Warn</md-button>
      </section>
  </md-content>
  <div layout="row" layout-sm="column">
    <div flex>
      I'm above on mobile, and to the left on larger devices.
    </div>
    <div flex>
      I'm below on mobile, and to the right on larger devices.
    </div>
  </div>
  <div layout="row">
    <div flex>
      [flex]
    </div>
    <div flex>
      [flex]
    </div>
    <div flex hide-sm>
      [flex]
    </div>
  </div>
</div>