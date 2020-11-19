@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" placeholder="Email" class="form-control">
            </div>   
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password" class="form-control">
            </div>              
            <button id="submitButton" class="btn btn-success">Login</button>
        </div>
    </div>  

    <script>
        if (localStorage.getItem('token')){
            if (localStorage.getItem('role') == 1){
                window.location.href = '/users';
            } else {
                window.location.href = '/posts';
            }            
        }

        $('#submitButton').on('click', function (e) {
            e.preventDefault(); 
            
            var email    = $("input[name=email]").val();
            var password = $("input[name=password]").val();            

            $.ajax({
                type: "POST",
                url: "{{ url('api/auth/login') }}",                
                data: {
                    email: email,
                    password: password
                },
                success: function (resp) {
                    localStorage.setItem('token', resp.access_token)
                    localStorage.setItem('name', resp.user.name)
                    localStorage.setItem('email', resp.user.email)
                    localStorage.setItem('role', resp.user.role)

                    if (resp.user.role == 1) {
                        window.location.href = '/users';
                    } else {
                        window.location.href = '/posts';
                    }
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseJSON.message);
                }
            });
        });
    </script> 
@endsection