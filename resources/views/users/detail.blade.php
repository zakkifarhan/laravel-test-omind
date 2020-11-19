@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="/users">< Back</a> | Detail User            
            <input type="hidden" value="{{ request()->route('id') }}" name="id_user">        
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" placeholder="Name" class="form-control" readonly>
            </div> 
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" placeholder="Email" class="form-control" readonly>
            </div>               
            <hr>
            <b>Posts</b>            
            <table class="table mt-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody id="bodyData">

                </tbody>
            </table>
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
                        
                        var resultData = resp.data.rows.posts;
                        var bodyData = '';
                        var i=1;
                        $.each(resultData,function(index,row){
                            bodyData+="<tr>"
                            bodyData+=
                                "<td>"+ i++ +"</td>"+
                                "<td>"+row.title+"</td>"+
                                "<td>"+row.description+"</td>"
                            bodyData+="</tr>";
                            
                        })
                        $("#bodyData").append(bodyData);
                    }
                });
            });            
    </script>
@endsection