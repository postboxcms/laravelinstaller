@extends('laravelinstaller::master')
  @section('content')
  <div class="user db-details">
    @csrf
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image bg-install-image">
            <img src="{{asset('images/cms-background.jpg')}}"/>
            </div> --}}
            <div class="col-lg-12">
                <div class="form-group">
                    <select name="connection" class="form-control form-control-select">
                    <option value="mysql">MySQL</option>
                    <option value="sqlite">SQLite</option>
                    <option value="pgsql">Postgre SQL</option>
                    <option value="sqlsrv">SQL Server</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="form-group">
            <input required value="{{$db['host']}}" type="text" name="host" class="form-control form-control-user @error('host') is-invalid @enderror" id="host" aria-describedby="host" placeholder="Database host ({{env('DB_HOST')}})">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="form-group">
            <input required value="{{$db['port']}}" type="text" name="port" class="form-control form-control-user @error('port') is-invalid @enderror" id="port" aria-describedby="port" placeholder="Database port ({{env('DB_PORT')}})">
                @error('port')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <input required value="{{$db['database']}}" type="text" name="database" class="form-control form-control-user @error('database') is-invalid @enderror" id="database" aria-describedby="database" placeholder="Database name ({{env('DB_DATABASE')}})">
                @error('database')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <input required value="{{$db['user']}}" type="text" name="user" class="form-control form-control-user @error('user') is-invalid @enderror" id="user" aria-describedby="user" placeholder="Database user ({{env('DB_USERNAME')}})">
                @error('user')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <input value="{{$db['password']}}" type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" aria-describedby="password" placeholder="Database password ({{env('DB_PASSWORD')}})">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
        </div>
 @stop

