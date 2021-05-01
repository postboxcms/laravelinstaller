@extends('laravelinstaller::master')
  @section('content')
            <!-- Nested Row within Card Body -->
            @csrf

            <div class="user health-check">
                <div class="row mb-4">
                    <div class="col-md-6 col-sm-12 col-xs-12 col-xl-6 col-lg-12">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Name:</b> <br/> {{ $appData['title'] }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Description:</b> <br/>{{ $appData['description'] }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Keywords:</b> <br/>{{ $appData['keywords'] }}</b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 col-xl-6 col-lg-12">
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Database connection type:</b> <br/>{{ $dbData['connection'] }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Database host:</b> <br/>{{ $dbData['host'] }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Database port:</b> <br/>{{ $dbData['port'] }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Database name:</b> <br/>{{ $dbData['database'] }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Database username:</b> <br/>{{ $dbData['user'] }}</b></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>                                    </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                                <h3><b>Database password:</b> <br/>{{str_repeat('*',strlen($dbData['password']))}}</b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  @stop
