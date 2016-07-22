<div class="off col-md-3 sidebar left-sidebar view-pokemon-sidebar hidden-xs">

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="initial-view">

                    <i class="fa fa-remove close-sidebar" ng-click="events.closeAddSidebar($event)"></i>

                    <h3 class="title">View Pokémon</h3>

                    <hr />

                    <div class="view-marker-box">

                        <div class="latest-pokemon-box" data-uuid="@{{currentMarker.uuid}}">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <img ng-src="@{{currentMarker.model.src}}">
                                    <div class="box">
                                        <div class="location">Pokémon #@{{currentMarker.model.formated_number}}</div>
                                        <div class="date">@{{currentMarker.model.date}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div ng-show="token">

                            <div class="report-box" ng-show="!owner">
                                <button href="#" ng-click="events.report()" ng-disabled="reported" type="button" class="btn btn-danger btn-md btn-block remove">@{{ reported_label }}</button>
                            </div>

                            <div class="remove-box" ng-show="owner">
                                <button href="#" ng-click="events.remove()"  type="button" class="btn btn-md btn-block remove" >Remove this marker</button>
                            </div>

                            <div ng-show="!owner">
                                <hr />

                                <div class="sight-box">
                                    <button href="#" ng-click="events.sight()"  ng-disabled="seen" type="button" class="btn btn-success btn-md btn-block remove" >@{{ seen_label }}</button>
                                </div>
                            </div>

                        </div>

                        <hr />

                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge">@{{ currentMarker.model.sights }}</span>
                                Trainers spotted it here:
                            </li>
                            <li class="list-group-item">
                                <span class="badge">@{{ currentMarker.model.reports }}</span>
                                Trainers reported this:
                            </li>
                        </ul>

                        <hr />

                        <div class="text-bottom" ng-show="!token">
                            To report or confirm this marker, please, sign in <a href="#" ng-click="events.viewMarkerClickHere()">clicking here</a>.
                        </div>

                    <?php /*
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge">14</span>
                                Frequency
                            </li>
                        </ul>


                        <button disabled type="button" class="btn btn-success btn-sm btn-block">I saw this pokemon here</button>


                        */ ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>