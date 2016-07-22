<div class="off col-md-3 sidebar left-sidebar add-pokemon-sidebar idden-xs">

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="register-view" ng-show="!token">

                    <h3 class="title">Welcome, Trainer</h3>

                    <p class="text">In order to add new pokemon to the map, plase, sign in:</p>

                    <hr />

                    <form class="form register-form" role="form">

                        <a class="btn btn-block btn-social btn-facebook" ng-click="events.login()">
                            <i class="fa fa-facebook"></i> Sign in with Facebook
                        </a>

                        <a class="btn btn-block btn-social btn-google-plus" ng-click="events.googleLoginClick()" >
                            <i class="fa fa-google-plus"></i> Sign in with Google
                        </a>

                        <a class="g-signin2" data-onsuccess="googleLogin" style="display:none;"></a>

                    </form>

                </div>

                <div class="initial-view" ng-show="token">

                    <i class="fa fa-remove close-sidebar" ng-click="events.closeAddSidebar($event)"></i>

                    <h3 class="title">Place Pokémon</h3>

                    <hr />

                    <div class="pokemon-selection-box">
                        <p class="text">
                            Select the pokémon to be placed on the map:
                        </p>

                        <div class="pokemon-nav-container">

                            <div class="form-group">
                                <input type="text" class="form-control nav-search-box" id="username" name="username" placeholder="e.g.: Pikachu">
                            </div>

                            <ul class="pokemon-nav-list">
                                <li class="pokemon-list-item pokemon" data-query="@{{p.name | lowercase}}" ng-repeat="p in pokemons">
                                    <img ng-src="@{{p.src}}" alt="@{{p.name}}" class="img-circle img-responsive" data-number="@{{p.number}}" ng-click="events.select($event)">
                                </li>
                            </ul>
                        </div>
                    </div>

                    <button ng-show="currentMarker.uuid" type="button" class="btn btn-success btn-md btn-block"  ng-click="events.finishAddingPokemon($event)" >Finish</button>

                </div>
            </div>
        </div>
    </div>
</div>