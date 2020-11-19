@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="/users">< Back</a> |
            {{ Request::route()->getName() == 'add_user' ? 'Add New' : 'Edit'}} User            
            <input type="hidden" value="{{ request()->route('id') }}" name="id_user">        
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" placeholder="Name" class="form-control">
            </div> 
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" placeholder="Email" class="form-control">
            </div>   
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password" class="form-control">
            </div>       
            <div class="form-group">
                <label for="">Role</label>
                <select name="role" class="form-control">
                    <option value="">Pilih Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Guest</option>
                </select>
            </div>         
            <button id="submitButton" class="btn btn-success">{{ Request::route()->getName() == 'add_user' ? 'Create' : 'Edit'}}</button>
        </div>
    </div>
    <script>
        if (localStorage.getItem('token')){
            if (localStorage.getItem('role') != 1){
                window.location.href = '/posts';
            } 
        } else {
            window.location.href = '/login';
        }      
          
        if(window.location.pathname != '/users/add'){
            $(document).ready(function() {     
                $id_user = $("input[name=id_user]").val();  
                $.ajax({
                    url: "{{ url('') }}"+ "/api/user/" + $id_user,
                    type: "GET",
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function(resp){
                        data = resp.data.rows

                        $("input[name=name]").val(data.name);
                        $("input[name=email]").val(data.email);                        
                        $("select[name=role]").val(data.role);
                    }
                });
            });
            $('#submitButton').on('click', function (e) {
                e.preventDefault(); 
                
                var name     = $("input[name=name]").val();
                var email    = $("input[name=email]").val();
                var password = $("input[name=password]").val();            
                var role     = $("select[name=role]").val();   

                $.ajax({
                    type: "PATCH",
                    url: "{{ url('api/user') }}",                
                    data: {
                        id: $("input[name=id_user]").val(),
                        name: name,
                        email: email,
                        password: password,
                        role: role
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function (resp) {
                        window.location.href = '/users';
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        } else {
            $('#submitButton').on('click', function (e) {
                e.preventDefault(); 
                
                var name     = $("input[name=name]").val();
                var email    = $("input[name=email]").val();
                var password = $("input[name=password]").val();            
                var role     = $("select[name=role]").val();   

                $.ajax({
                    type: "POST",
                    url: "{{ url('api/user') }}",                
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        role: role
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function (resp) {
                        window.location.href = '/users';
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        }        
    </script>
@endsection