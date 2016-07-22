<section class="center save-my-location-screen off hidden-xs">

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="initial-view">

                    <i class="fa fa-remove close-sidebar" ng-click="events.closeMyLocationsScreen($event)"></i>

                    <h3 class="title">Save view into My Locations</h3>

                    <div class="article">

                        <p class="text">
                            Plase, give a name to this location:
                        </p>

                        <div class="form-group">
                            <input class='form-control text-center' name="mylocation" ng-model="mylocation_name">
                        </div>

                        <div class="form-group text-center">
                            <button type="button" class="btn btn-success btn-md" ng-click="events.location()">Save this view into My Locations</button>
                        </div>

                        <p class="text">
                            You can find your saved locations on the blue sidebar, on the left.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>
</section>