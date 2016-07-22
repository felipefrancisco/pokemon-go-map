<section class="center splash-screen hidden-xs" ng-show="!loading">

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <section class="initial-view">

                    <i class="fa fa-remove close-sidebar" ng-click="events.closeSplashScreen($event)"></i>

                    <h3 class="title">Welcome, Trainer.</h3>

                    <article class="article">
                        <p class="text">
                            This is a colaborative <strong><a href="http://pokemongolive.com" target="_blank">Pokémon GO</a> map</strong> tool created to help players find their favorite Pokémon <strong>location</strong> around the world.
                        </p>

                        <hr />

                        <p class="text hidden-xs">
                            <h4>How to use</h4>
                            Left click and hold anywhere on the map for 1 second, the pokemon selection will appear.
                        </p>

                        <p class="text hidden-md hidden-lg hidden-print">
                            To contribute to the map, please, open the map on your computer :)
                        </p>
                    </article>

                    <article class="share-box">
                        <div class="fb-share-button" data-href="http://www.pokemon-map.com/" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.pokemon-map.com%2F&amp;src=sdkpreparse">Share</a>
                        </div>
                        <div class="tweet">
                            <a class="twitter-share-button" data-text="Pokémon GO World Map - A collaborative map to help players on finding Pokémon around the world. #PokemonGO" href="https://twitter.com/intent/tweet">Tweet</a>
                        </div>
                    </article>

                    <article class="donate">
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHNwYJKoZIhvcNAQcEoIIHKDCCByQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYAu+fD9EbxP04b3IAFN/pFFFQ8OUHb7cBLxE1owLCN5NNQaAAh/66vJgnOXy26/o3wMp+dGD8CNousWn5w3kLEG10PPDEYadjQtCdPvS4IAlcmF00qYTlBVHabKDZ2rvjpjGFXjmFAPszbBbE3Ox+VirY8ecpoFqJuk3V79nVVT8zELMAkGBSsOAwIaBQAwgbQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIPjIlc12gHT2AgZCzXzCZIGsRjA4roYYWuHiWqBgL3Q7gCmxwzuh8J0chHHykaUeDHYwcX4Pjo47ldjPm43qGkOCqNIe7yylL3CF3yke/pUJLMRhL6HVJT/aViqz6E3zz+eepmS6yH5j9i62oZQWdH8xQfKpat4uzU6YwYDEzWHJ3mLXS3EudUJISWeCGM6GFx4vKuwzuotrSIDWgggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0xNjA3MTgyMDU1NTZaMCMGCSqGSIb3DQEJBDEWBBS45mIL+R7z0Z2/5/LjTV/i4wUWAjANBgkqhkiG9w0BAQEFAASBgJmw25X71U3uH3PK+VJ+ETpH1MPzGt2DFXiz4D0/8Tyz/JtMa1m1nwuutw3R7kBuq+5S0opMLuH4Tq7YDixZdr7Se4bKr/rnJVUkYERrOiG9G2KGxK743f8BRCZq570ZDRLBJxnRPsgOEww9Dp+7krqWhgyvvCFFVVuy0K7CxtQG-----END PKCS7-----
">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    </article>

                    <hr />

                    <article class="alert alert-success">
                        <p>We've gone <b>Open Source</b>!! Checkout our github repository <a href="https://github.com/felipefrancisco/pokemon-go-map/" target="_blank">clicking here</a>.</p>
                    </article>

                    <article class="alert alert-info">
                        <p>I'm now selecting <b>moderators</b> to help with the map. Please, <a href="https://github.com/felipefrancisco/pokemon-go-map/issues/20" target="_blank">click here</a> for further information.</p>
                    </article>

                    <p class="text">
                        <span class="text-danger">
                            Feel free to send suggestions or report any bugs by <a href="https://github.com/felipefrancisco/pokemon-go-map/issues" target="_blank">clicking here</a>.
                        </span>
                    </p>

                    <p class="text">
                        <span class="total">Pokémon on map: @{{ totalMarkers }}</span>
                    </p>

                    <p class="copyright">
                        Created by <author><a href="https://github.com/felipefrancisco">@felipefrancisco</a></author>
                    </p>

                    <hr />

                    <p class="copyright">
                        {{ $version }}
                    </p>


                    <!--
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
                                        -->
                </section>
            </div>
        </div>
    </section>
</section>

<section class="col-md-3 sidebar left-sidebar main-sidebar hidden-md hidden-lg" ng-show="!loading">

    <section class="content">


            <div class="col-md-12">

                <div class="initial-view">

                    <i class="fa fa-remove close-sidebar" ng-click="events.closeMainSidebar($event)"></i>

                    <h3 class="title">Welcome, Trainer.</h3>

                    <div class="article">
                        <p class="text">
                            This is a colaborative <strong><a href="http://pokemongolive.com" target="_blank">Pokémon GO</a> map</strong> tool created to help players find their favorite Pokémon <strong>location</strong> around the world.
                        </p>

                        <p class="text">
                            To contribute to the map, please, open the map on your computer.
                        </p>

                        <p class="text">


                            <article class="alert alert-danger">
                                <p>Servers are loaded with lots of people using the map at the same time, also, we're being DDoS attacked during all day. I'm doing improvements on the servers to make sure that you guys can use the map normally. Thanks for your patience and support.</p>
                            </article>

                            <p class="text-danger">
                                Mobile support is limited as of now, please use the map on a computer to access all the features.
                            </p>
                        </p>

                    </div>


                    <div class="share-box">
                        <div class="fb-share-button" data-href="http://www.pokemon-map.com/" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.pokemon-map.com%2F&amp;src=sdkpreparse">Share</a>
                        </div>
                        <div class="tweet">
                            <a class="twitter-share-button" data-text="Pokémon GO World Map - A collaborative map to help players on finding Pokémon around the world. #PokemonGO" href="https://twitter.com/intent/tweet">Tweet</a>
                        </div>
                    </div>

                    <p class="copyright">
                        Created by <author><a href="https://github.com/felipefrancisco">@felipefrancisco</a></author>
                    </p>
                </div>
            </div>

    </section>
</section>