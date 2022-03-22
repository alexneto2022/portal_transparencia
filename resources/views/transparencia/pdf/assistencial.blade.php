<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <title>Portal da Transparencia - HCP</title>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    -->

    <style>
    table.comBordaSimples 
    {
      border-collapse: collapse; /* CSS2 */
    }
    table.comBordaSimples td {
      border: 1px solid black;
    }
    table.comBordaSimples th {
      border: 1px solid black;
      background:  #28a745;
    }
    </style>
    </head>
<body>
    <div>
      <img src="{{asset('img/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
    <p><h3>RELATÓRIO ASSISTENCIAL - UNIDADE: {{$unidade->name}}</h3></p>
    </div>
    <table class="comBordaSimples" style="font-size: 8px; ">
        <thead >
          <tr>
            <th scope="col">Descrição:</th>
            <th scope="col">Meta Contratada/Mês</th>
            <th scope="col">Janeiro</th>
            <th scope="col">Fevereiro</th>
            <th scope="col">Março</th>
            <th scope="col">Abril</th>
            <th scope="col">Maio</th>
            <th scope="col">Junho</th>
            <th scope="col">Julho</th>
            <th scope="col">Agosto</th>
            <th scope="col">Setembro</th>
            <th scope="col">Outubro</th>
            <th scope="col">Novembro</th>
            <th scope="col">Dezembro</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($assistencials as $assistencial)
                <tr>
                    <td>{{$assistencial->descricao}}</td>
                    <td class="text-center">{{$assistencial->meta}}</td>
                    <td class="text-center">{{$assistencial->janeiro}}</td>
                    <td class="text-center">{{$assistencial->fevereiro}}</td>
                    <td class="text-center">{{$assistencial->marco}}</td>
                    <td class="text-center">{{$assistencial->abril}}</td>
                    <td class="text-center">{{$assistencial->maio}}</td>
                    <td class="text-center">{{$assistencial->junho}}</td>
                    <td class="text-center">{{$assistencial->julho}}</td>
                    <td class="text-center">{{$assistencial->agosto}}</td>
                    <td class="text-center">{{$assistencial->setembro}}</td>
                    <td class="text-center">{{$assistencial->outubro}}</td>
                    <td class="text-center">{{$assistencial->novembro}}</td>
                    <td class="text-center">{{$assistencial->dezembro}}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
      <!--
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      -->
</body>
</html>