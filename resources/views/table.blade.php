
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">M3U Address
</th>
      <th scope="col">Username
</th>
      <th scope="col">Password
</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($users as $user)

    <tr>
      <th scope="row">{{$user->address}}</th>
      <td>{{$user->username}}</td>
      <td>{{$user->password}}</td>
    </tr>
    @endforeach

  </tbody>
</table>

</div>


</body>
</html>

