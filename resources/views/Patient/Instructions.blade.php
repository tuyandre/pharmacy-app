<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Instructions</title>
</head>
<body>
   <div class="container">
       <br>
       <div class="row">
           <div class="col-md-12">
               <h4 class="text-center"><b>Instructions for {{ $medecine->name }}</b></h4>
           </div>
       </div>
       <div class="row">
           <div class="col-md-8 offset-md-2">
               <br>
            <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Instruction</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>

 @foreach ($medecine->instructions as $item)
     <tr>
        <th scope="row">
            {{$counter}}
        </th>
        <?php $counter++ ?>
        <td>{{ $item->name }}</td>
     </tr>
 @endforeach

                </tbody>
              </table>
           </div>
       </div>
   </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</html>
