@extends('layouts.master')

@section('content')

<div ng-controller="MapController">

<?php /*
        <div class="row loading">
            <div class="col-md-6 col-md-offset-3">

                <h1>The site is down for maintenance.</h1>
                <div class="sub">
                    We are experiencing an unexpected heavy load, we're doing a quick maintenance to make the map load quicker.<br />
                    Thank you for all the support, I'm making improvements as fast as I can to improve your experience while using this tool :)
                </div>

            </div>
        </div>
 */ ?>


    <div class="pokemon-list-template">
    </div>

    <div id="map"></div>

    <div class="full-center-on-page" ng-show="center_loader">
        <div classs="loader">
            <img ng-src="@{{loading_icon}}">
        </div>
    </div>

    <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
    <button id="save-place" class="btn btn-sm btn-info hidden-xs" ng-show="token" ng-click="events.openMyLocationScreen()">
        Save to My Locations
    </button>

    <div class="filters panel hidden-xs" ng-show="!loading">

        <div class="panel-heading">
            Filters
        </div>

        <div class="pokemon-filters">

            <div class="panel-body">
                <div class="form-group">
                    <input class="form-control input-sm" name='pokemon_filter' type="text" ng-model="pokemon_filter" placeholder="e.g: Pikachu">
                </div>
            </div>

            <div class="pokemon-list">
                @foreach($pokemon as $poke)
                    <img src="images/pokemon/{{$poke->number}}.png" alt="{{ $poke->name }}" class="img-circle img-responsive pokemon" ng-click="events.pokemonFilterClick($event)" data-number="{{ $poke->number }}" data-query="{{ strtolower($poke->name) }}">
                @endforeach
            </div>
        </div>

        <div class="panel-footer" style="font-size:12px;" ng-show="filteredMarkers.length">
            Filtered (world wide): @{{ filteredMarkers.length }}
        </div>

    </div>

    <div class="float-right-box panel hidden-xs off-right my-markers-box" ng-show="!loading">

        <div class="panel-body">

            <p>
                Showing @{{ myMarkers.length }} Pokémon.
                <div class="sub">Filtering is not available when viewing only your own markers.</div>
            </p>

            <div class="latest-pokemon-box" ng-show="myMarkers.length">

                <hr />

                <p class="text last-added-text">
                    Latest added Pokemon
                    <div class="sub">Click to go to location</div>
                </p>

                <div class="list-group">
                    <a href="#" class="list-group-item" ng-repeat="marker in myMarkers | reverse | limitTo:5" ng-click="events.goToLocationHash(marker)">
                        <img ng-src="@{{marker.src}}">
                        <div class="box">
                            <div class="location">Pokémon #@{{marker.formated_number}}</div>
                            <div class="date">@{{marker.date}}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('sidebar.center')
    @include('sidebar.save-my-location')
    @include('sidebar.left-menu')

    @include('sidebar.add-pokemon')
    @include('sidebar.view-marker')

    <div class="row loading" ng-show="loading">
        <div class="col-md-6 col-md-offset-3">

            <h1>Hang on, the map is loading.</h1>
            <div class="sub">
                We are experiencing an unexpected heavy load, so the map can take up 30s to load.<br />
                Thank you for all the support, I'm making improvements as fast as I can to improve your experience while using this tool :)
            </div>

        </div>
    </div>

</div>

@endsection