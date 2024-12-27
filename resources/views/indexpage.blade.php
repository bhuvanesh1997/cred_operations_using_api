<!DOCTYPE html>
<html>
<body>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
<h2>Add Edit</h2>
<form id="addedit">
  @csrf
  <label for="fname">Name:</label><br>
  <input type="text" id="fname" name="fname"><br>
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email"><br>
  <label for="mobile">Mobile:</label><br>
  <input type="text" id="mobile" name="mobile"><br>
  <input type="hidden" id="edit_id" name="edit_id"><br>
  <input type="submit" name="submit" id="submit" value="Save">
</form> 

<hr>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>List Users</h2>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Created At</th>
      <th>Name</th>
      <th>Email</th>
      <th>Mobile</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="tabledata">
    
  </tbody>
</table>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
  function loadData(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({                                      
      url: 'getdata',              
      type: "post",
      data: {_token: CSRF_TOKEN},
      dataType: 'html',                
      success: function(response){
        $('#tabledata').html('');
        $('#tabledata').html(response);
      }
    });
  }
  $(document).ready(function (){
    loadData();
  });
  
  $('#addedit').submit(function (e) {
    e.preventDefault();
    var submit = $('#submit').val();
    $.ajax({                                      
      url: 'savedata',              
      type: "post",
      data: $('form').serialize(),
      dataType: 'json',      
      success: function(response){
        if(response == 'success'){
          if(submit == 'Save'){
            alert("Saved successfully.");
          }
          else{
            $('#submit').val('Save');
            alert("Updated successfully.");
          }
          loadData();
          $('#addedit')[0].reset();
        }
      }
    });
  });

  function edit(id){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({                                      
      url: 'getdata',              
      type: "post",
      data: {_token: CSRF_TOKEN,id:id},
      dataType: 'json',                
      success: function(response){
        $('#fname').val(response.name);
        $('#email').val(response.email);
        $('#mobile').val(response.mobile);
        $('#edit_id').val(id);
        $('#submit').val('Update');
      }
    });
  }

  function deletedate(id){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({                                      
      url: 'deleteData',              
      type: "post",
      data: {_token: CSRF_TOKEN,id:id},
      dataType: 'json',                
      success: function(response){
        alert('Deleted successfully');
          loadData();
      }
    });
  }
</script>
</body>
</html>