@extends('laravelinstaller::master')
  @section('content')
  <div class="user health-check">
    <div class="row mb-4">
        <div class="col-md-1 col-anim-bullet envspinner">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="col-md-11 col-text-bullet">Updating environment variables</div>
    </div>
    <div class="row mb-4">
        <div class="col-md-1 col-anim-bullet migspinner">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="col-md-11 col-text-bullet">Running migrations</div>
    </div>
    <div class="row mb-4">
        <div class="col-md-1 col-anim-bullet linkspinner">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="col-md-11 col-text-bullet">Creating storage link</div>
    </div>

  </div>
  @stop
  @section('scripts')
    <script>
        $(document).ready(function() {
            let baseUrl = "{{url('/')}}";
            let successbtn = '<span class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>';
            let failbtn = '<span class="btn btn-danger btn-circle btn-sm"><i class="fas fa-times"></i></span>';
            let reloadbtn = '<i class="fas fa-redo-alt"></i> Click here to refresh';

            $.ajax({
                url: baseUrl+'/install/save/environment',
                type: 'post',
                cache: false,
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
            }).done(function(response) {
                    // success environment variables saved successfully
                    $('.envspinner').html(successbtn);
                    // timeout set to 2 seconds in case environment change causes server to reload
                    setTimeout( function() {
                        $.ajax({
                            url: baseUrl+'/install/run/migrations',
                            type: 'post',
                            cache: false,
                            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
                        }).done(function(response) {
                            // success migrations ran successfully
                            $('.migspinner').html(successbtn);
                            $.ajax({
                                url: baseUrl+'/install/save/storage',
                                type: 'post',
                                cache: false,
                                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
                            }).done(function(response) {
                                // success link created succesfully
                                $('.linkspinner').html(successbtn);
                                $('h1.title').text('{{$titleComplete}}');
                                $('button.btn-submit').after('<a href="'+baseUrl+'" class="btn btn-primary">'+reloadbtn+'</a>');
                                $('button.btn-submit').remove();
                            }).fail(function(error) {
                                // console.log(error)
                                $('.linkspinner').html(failbtn);
                                $('h1.title').text('{{$titleIncomplete}}');
                            });

                        }).fail(function(error) {
                            // console.log(error)
                            $('.migspinner').html(failbtn);
                            $('.linkspinner').html(failbtn);
                            $('h1.title').text('{{$titleIncomplete}}');
                        });
                    }, 2000);
            }).fail(function(error){
                    // console.log(error)
                    $('.envspinner').html(failbtn);
                    $('.migspinner').html(failbtn);
                    $('.linkspinner').html(failbtn);
                    $('h1.title').text('{{$titleIncomplete}}');
            });
        });
    </script>
  @stop
