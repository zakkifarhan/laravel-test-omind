<!doctype html>
<html lang="en">
    <head>    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>        

        <title>Omind Competency Test</title>    
    </head>
    <body>    
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
            <div class="container">
                <a class="navbar-brand" href="/">PT. Omind Muda Berkarya Indonesia</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-none" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>                            
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" id="logout">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>         
            </div>        
        </nav>
        <div class="container">
            <div class="jumbotron">
                <h1 class="display-4">Omind Competency Test</h1>
                <p class="lead">Backend Developer - M. Farhan Muzakki (farhan.zakki@gmail.com)</p>                
                <hr class="my-4">
                @yield('content')

                <hr>
                <b>Note:</b>
                <ul>
                    <li>
                        <b>Akun Admin</b><br>
                        Email: farhan.zakki@gmail.com <br>
                        Password: admin123
                    </li> 
                </ul> 
                <hr>
                <b>Aktor:</b>
                <ul>
                    <li>
                        Admin 
                        <ul>
                            <li>Authentication (Login, Logout)</li>
                            <li>Create, Read, Update, Delete Guest</li>
                            <li>Create, Read, Update, Delete Other Admin</li>
                            <li>See Guest's Post</li>
                        </ul>
                    </li> 
                    <li>
                        Guest
                        <ul>
                            <li>Authentication (Login, Logout)</li>
                            <li>Create, Read, Update, Delete Post</li>
                        </ul>
                    </li>
                </ul>          
            </div>            
        </div>                  

        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    <script>        
        if (localStorage.getItem('token')){            
            $(document).ready(function() {
                $.ajax({
                    url: "{{ url('api/auth/me') }}",
                    type: "GET",
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function(resp){
                        $("#navbarDropdown").append(resp.name + ' ' + (resp.role == 1 ? '(Admin)' : '(Guest)'));
                        $('#navbarDropdown').removeClass('d-none')

                        localStorage.setItem('name', resp.name)
                        localStorage.setItem('email', resp.email)
                        localStorage.setItem('role', resp.role)
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseJSON.message);

                        localStorage.removeItem('token');
                        localStorage.removeItem('name');
                        localStorage.removeItem('email');
                        localStorage.removeItem('role');

                        window.location.href = '/login';                        
                    }
                });
            });
        }  

        $("#logout").click(function(e){
            e.preventDefault();

            $.ajax({
                type:'POST',
                url:"{{ url('api/auth/logout') }}",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                },
                success:function(data){
                    localStorage.removeItem('token');
                    localStorage.removeItem('name');
                    localStorage.removeItem('email');
                    localStorage.removeItem('role');

                    window.location.href = '/login';
                }
            });
        });
    </script>
</html>