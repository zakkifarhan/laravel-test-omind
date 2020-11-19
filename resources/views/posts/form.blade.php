@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="/posts">< Back</a> |
            {{ Request::route()->getName() == 'add_post' ? 'Add New' : 'Edit'}} Post            
            <input type="hidden" value="{{ request()->route('id') }}" name="id_post">        
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" placeholder="Title" class="form-control">
            </div> 
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" rows="4" cols="50" placeholder="Description" class="form-control"></textarea>
            </div>        
            <button id="submitButton" class="btn btn-success">{{ Request::route()->getName() == 'add_post' ? 'Create' : 'Edit'}}</button>
        </div>
    </div>
    <script> 
        if (localStorage.getItem('token')){
            if (localStorage.getItem('role') != 2){
                window.location.href = '/users';
            } 
        } else {
            window.location.href = '/login';
        }   
        
        if(window.location.pathname != '/posts/add'){
            $(document).ready(function() {                     
                $id_post = $("input[name=id_post]").val();  
                $.ajax({
                    url: "{{ url('') }}"+ "/api/post/" + $id_post,
                    type: "GET",
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function(resp){
                        data = resp.data.rows

                        $("input[name=title]").val(data.title);
                        $("textarea[name=description]").val(data.description);
                    }
                });
            });
            $('#submitButton').on('click', function (e) {
                e.preventDefault(); 
                
                var title     = $("input[name=title]").val();
                var description    = $("textarea[name=description]").val();

                $.ajax({
                    type: "PATCH",
                    url: "{{ url('api/post') }}",                
                    data: {
                        id: $("input[name=id_post]").val(),
                        title: title,
                        description: description
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function (resp) {
                        window.location.href = '/posts';
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        } else {
            $('#submitButton').on('click', function (e) {
                e.preventDefault(); 
                
                var title     = $("input[name=title]").val();
                var description    = $("textarea[name=description]").val();  

                $.ajax({
                    type: "POST",
                    url: "{{ url('api/post') }}",                
                    data: {
                        title: title,
                        description: description
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                    },
                    success: function (resp) {
                        window.location.href = '/posts';
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        }        
    </script>
@endsection