<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        

        <title>Portal da Transparencia - HCP</title>



        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

        <!-- OWN STYLE -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>
<body>

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 18px;">INSTITUCIONAL</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7" style="font-size: 13px;">  
            <table class="table-sm" style="line-height: 1.5;">
                <tbody>
                    <tr>
                        <td style="border-top: none;"><strong>Perfil: </strong></td>
                        <td style="border-top: none;">{{$unidade->owner}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CNPJ: </strong></td>
                        <td style="border-top: none;">{{ preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})/", "\$1.\$2.\$3/\$4\$5-", $unidade->cnpj)}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Nome Unidade: </strong></td>
                        <td style="border-top: none;">{{$unidade->name}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Logradouro: </strong></td>
                        <td style="border-top: none;">{{$unidade->address}}, {{$unidade->numero == null ? 's/n' : $unidade->numero}}</td>
                    </tr>
                    @if(isset($unidade->further_info) || $unidade->further_info !== null)
                    <tr>
                        <td style="border-top: none;"><strong>Complemento: </strong></td>
                        <td style="border-top: none;">{{$unidade->further_info}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="border-top: none;"><strong>Bairro: </strong></td>
                        <td style="border-top: none;">{{$unidade->district}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Cidade: </strong></td>
                        <td style="border-top: none;">{{$unidade->city}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>UF: </strong></td>
                        <td style="border-top: none;">{{$unidade->uf}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CEP: </strong></td>
                        <td style="border-top: none;">{{preg_replace("/(\d{2})(\d{3})/", "\$1.\$2-", $unidade->cep)}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Telefone: </strong></td>
                        <td style="border-top: none;">{{preg_replace("/(\d{4})(\d{4})/", "\$1-\$2", $unidade->telefone)}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Horário: </strong></td>
                        <td style="border-top: none;">{{$unidade->time}}</td>
                    </tr>
                    @if(isset($unidade->cnes) || $unidade->cnes !== null)
                    <tr>
                        <td style="border-top: none;"><strong>CNES: </strong></td>
                        <td style="border-top: none;">{{$unidade->cnes}}</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"  style="font-size: 13px;">
            <table class="table-sm" style="line-height: 1.5;">
                <tbody>
                    @if(isset($unidade->capacity) || $unidade->capacity !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2"><strong>Capacidade: </strong>{!!$unidade->capacity!!}</td>
                    </tr>
                    @endif
                    @if(isset($unidade->specialty) || $unidade->specialty !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2"><strong>Especialidades: </strong>{!!$unidade->specialty!!}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>
    
</body>
</html>