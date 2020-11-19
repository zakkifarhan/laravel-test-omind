@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="/posts/add" class="btn btn-success float-right"><i class="fa fa-plus"></i> Create New Post</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col" colspan=3>Action</th>
                    </tr>
                </thead>
                <tbody id="bodyData">

                </tbody>
            </table>
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

        $(document).ready(function() {                        
            $.ajax({
                url: "{{ url('api/post') }}",
                type: "GET",
                dataType: 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer '+ localStorage.getItem('token'));
                },
                success: function(resp){
                    var resultData = resp.data.rows;
                    var bodyData = '';
                    var i=1;
                    $.each(resultData,function(index,row){
                        var editUrl = '/posts/'+ row.id +'/edit';
                        bodyData+="<tr>"
                        bodyData+=
                            "<td>"+ i++ +"</td>"+
                            "<td>"+row.title+"</td>"+
                            "<td>"+row.description+"</td>"+
                            "<td>" + 
                                "<a class='btn btn-primary' href='"+editUrl+"'>Edit</a>"+
                                "<button class='btn btn-danger delete' onclick=destroy("+row.id+") style='margin-left:20px;'>Delete</button>"+                                
                            "</td>";
                        bodyData+="</tr>";
                        
                    })
                    $("#bodyData").append(bodyData);
                }
            });            
        }); 

        function destroy(x) {
            var isDelete = confirm("Are you sure want to delete this data?");
            if (isDelete == true) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('') }}" + "/api/post?id=" + x,
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
            }             
        }     
    </script>
@endsection