@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 15px;"><strong>CONVÊNIOS</strong></h3>
            <h3 style="font-size: 12px;"></h3>
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-1 col-sm-0"></div>
        <div class="col-md-10 col-sm-12">
            <div id="accordion border-0">
                <div class="card">
                    <div class="card-header border-0 text-center" id="headingOne">
                        <h5 class="mb-0">
                            <a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#homologação" aria-expanded="true" aria-controls="homologação">
                                <strong style="margin-right: 5px;">Aviso de homologação de pregão eletrônico</strong> <i class="fas fa-gavel"></i><i class="fas fa-at" style="font-size: 8px;"></i>
                            </a>
                        </h5>
                    </div>
                    <div id="homologação" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="d-flex justify-content-center">
                            <p style="margin-top: 10px;">
                                <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#2018" role="button" aria-expanded="false" aria-controls="2018">
                                    2018
                                </a>
                                <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#2019" role="button" aria-expanded="false" aria-controls="2019">
                                    2019
                                </a>
                            </p>
                        </div>
                        <div class="collapse" id="2018">
                            @foreach($pregaos[2018] as $pregao)
                            @if($pregao->type == 'Aviso de homologação')
                            <div class="card-body" style="font-size: 12px;">
                                {{$pregao->title}}
                                <a href="{{asset('storage/')}}/{{$pregao->path_file}}" target="_blank" class="badge badge-primary">Download</a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="collapse" id="2019">
                            @foreach($pregaos[2019] as $pregao)
                            @if($pregao->type == 'Aviso de homologação')
                            <div class="card-body" style="font-size: 12px;">
                                {{$pregao->title}}
                                <a href="{{asset('storage/')}}/{{$pregao->path_file}}" target="_blank" class="badge badge-primary">Download</a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header border-0 text-center" id="headingOne">
                        <h5 class="mb-0">
                            <a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#aviso" aria-expanded="true" aria-controls="aviso">
                                <strong style="margin-right: 5px;">Aviso de licitação de pregão eletrônico</strong><i class="fas fa-gavel"></i><i class="fas fa-at" style="font-size: 8px;"></i>
                            </a>
                        </h5>
                    </div>
                    <div id="aviso" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="d-flex justify-content-center">
                            <p style="margin-top: 10px;">
                                <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#Licitacao-2018" role="button" aria-expanded="false" aria-controls="Licitacao-2018">
                                    2018
                                </a>
                                <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#Licitacao-2019" role="button" aria-expanded="false" aria-controls="Licitacao-2019">
                                    2019
                                </a>
                            </p>
                        </div>
                        <div class="collapse" id="Licitacao-2018">
                            @foreach($pregaos[2018] as $pregao)
                            @if($pregao->type == 'Aviso de licitação')
                            <div class="card-body" style="font-size: 12px;">
                                {{$pregao->title}}
                                <a href="{{asset('storage/')}}/{{$pregao->path_file}}" target="_blank" class="badge badge-primary">Download</a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="collapse" id="Licitacao-2019">
                            @foreach($pregaos[2019] as $pregao)
                            @if($pregao->type == 'Aviso de licitação')
                            <div class="card-body" style="font-size: 12px;">
                                {{$pregao->title}}
                                <a href="{{asset('storage/')}}/{{$pregao->path_file}}" target="_blank" class="badge badge-primary">Download</a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header border-0 text-center" id="headingOne">
                        <h5 class="mb-0">
                            <a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#edital" aria-expanded="true" aria-controls="edital">
                                <strong style="margin-right: 5px;">Edital de pregão eletrônico</strong><i class="fas fa-gavel"></i><i class="fas fa-at" style="font-size: 8px;"></i>
                            </a>
                        </h5>
                    </div>
                    <div id="edital" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="d-flex justify-content-center">
                            <p style="margin-top: 10px;">
                                <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#Edital-licitacao-2018" role="button" aria-expanded="false" aria-controls="Edital-licitacao-2018">
                                    2018
                                </a>
                                <a class="btn btn-secondary btn-sm" data-toggle="collapse" href="#Edital-licitacao-2019" role="button" aria-expanded="false" aria-controls="Edital-licitacao-2019">
                                    2019
                                </a>
                            </p>
                        </div>
                        <div class="collapse" id="Edital-licitacao-2018">
                            @foreach($pregaos[2018] as $pregao)
                            @if($pregao->type == 'Edital de licitação')
                            <div class="card-body" style="font-size: 12px;">
                                {{$pregao->title}}
                                <a href="{{asset('storage/')}}/{{$pregao->path_file}}" target="_blank" class="badge badge-primary">Download</a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="collapse" id="Edital-licitacao-2019">
                            @foreach($pregaos[2019] as $pregao)
                            @if($pregao->type == 'Edital de licitação')
                            <div class="card-body" style="font-size: 12px;">
                                {{$pregao->title}}
                                <a href="{{asset('storage/')}}/{{$pregao->path_file}}" target="_blank" class="badge badge-primary">Download</a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-0"></div>
    </div>

</div>
@endsection
