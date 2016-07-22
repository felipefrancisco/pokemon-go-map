<section class="off col-md-3 sidebar left-sidebar main-sidebar">

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="initial-view">

                    <i class="fa fa-remove close-sidebar" ng-click="events.closeMainSidebar($event)"></i>

                    <h3 class="title">Welcome, Trainer.</h3>

                    <div class="article">
                        <p class="text">
                            This is a colaborative <strong><a href="http://pokemongolive.com" target="_blank">Pokémon GO</a> map</strong> tool to help players find their favorite Pokémon <strong>location</strong> around the world.
                        </p>

                        <p class="text hidden-xs">
                            <b>How to contrbute:</b> left click and hold anywhere on the map for 1 second, the pokemon selection will appear.
                        </p>

                        <p class="text hidden-md hidden-lg hidden-print">
                            To contribute to the map, please, open the map on your computer :)
                        </p>
                    </div>

                    <article class="alert alert-success">
                        <p>You can now tell other trainers wheter you spotted a marked pokémon on the map, just select any pokémon and click the green button. (need to be logged in).</p>
                    </article>

                    <article class="alert alert-info">
                        <p>You can now report invalid pokemon markers for exclusion and add more than 1 pokemon into the same circled area!</p>
                    </article>

                    <p class="text">
                        <span class="text-danger">
                            Feel free to send suggestions or report any bugs by <a href="https://github.com/felipefrancisco/pokemon-go-map/issues" target="_blank">clicking here</a>.
                        </span>
                    </p>

                    <p class="copyright">
                        Created by <author><a href="https://github.com/felipefrancisco">@felipefrancisco</a></author>
                    </p>

                    <hr />

                    <div class="latest-pokemon-box hidden-xs">
                        <p class="text">
                            Latest added Pokemon
                            <span class="total">Total: @{{ totalMarkers }}</span>
                        </p>

                        <div class="list-group">
                            <a href="#" class="list-group-item" ng-repeat="marker in latest" ng-click="events.latest(marker)">
                                <img ng-src="@{{marker.src}}">
                                <div class="box">
                                    <div class="location">Pokémon #@{{marker.number}}</div>
                                    <div class="date">@{{marker.date}}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>