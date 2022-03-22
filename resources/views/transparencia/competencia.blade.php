@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">COMPETÊNCIAS</h3>
		</div>
	</div>

	@if (Session::has('mensagem'))
		@if ($text == true)
		<div class="container">
	     <div class="alert alert-success {{ Session::get ('mensagem')['class'] }} ">
		      {{ Session::get ('mensagem')['msg'] }}
		 </div>
		</div>
		@endif
	@endif

	<div class="row" style="margin-top: 25px;">
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <a class="btn btn-link text-decoration-none" type="button" data-toggle="collapse" data-target="#legislacao" aria-expanded="true" aria-controls="legislacao">
                        Legislação <i class="fas fa-gavel"></i>
                      </a>
                    </h2>
                  </div>
                  <div id="legislacao" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                      <!--p style="font-size:15px; color: black">Lei Federal nº: 12.527/2011 - Lei de Acesso à Informação (Federal) <a class="badge badge-success" href="http://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm" target="_blank">Acessar</a></p>
                      <p style="font-size:15px; color: black">Decreto Federal nº 7.724/2012 (Norma regulamentadora LAI federal) <a class="badge badge-success" href="http://www.planalto.gov.br/ccivil_03/_ato2011-2014/2012/Decreto/D7724.htm" target="_blank">Acessar</a></p>
                      <p style="font-size:15px; color: black">Lei Estadual nº 14.804/2012 - Lei de Acesso à Informação (Estadual) <a class="badge badge-success" href="https://www.sefaz.pe.gov.br/Legislacao/Tributaria/Documents/legislacao/Leis_Tributarias/2012/Lei14804_2012.htm" target="_blank">Acessar</a></p>
                      <p style="font-size:15px; color: black">Decreto nº 38.787/2012 (Norma regulamentadora LAI estadual) <a class="badge badge-success" href="http://www2.sad.pe.gov.br/c/document_library/get_file?uuid=eabe5662-3852-4ea7-96b0-5e8fecbd5133&groupId=11927" target="_blank">Acessar</a></p>
                      <p style="font-size:15px; color: black">Lei Estadual nº 15.210/2013 - Lei das Organizações Sociais de Saúde (Estadual) <a class="badge badge-success" href="https://legis.alepe.pe.gov.br/texto.aspx?id=1932&tipo=TEXTOATUALIZADO" target="_blank">Acessar</a></p-->
                      <p style="font-size:15px; color: black">Legislação <a class="badge badge-success" href="http://hcpgestao.org.br/transparencia/unidades/ambas/LEGISLAÇÃO PORTAL.docx" target="_blank">Acessar</a></p>
                    </div>
                  </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="headingOne">
                      <h2 class="mb-0">
                        <a class="btn btn-link text-decoration-none" type="button" data-toggle="collapse" data-target="#matriz" aria-expanded="true" aria-controls="matriz">
                          Matriz de competência <i class="fas fa-dice-d6"></i>
                        </a>
						@if(Auth::check())
						 @foreach ($permissao_users as $permissao)
						  @if(($permissao->permissao_id == 3) && ($permissao->user_id == Auth::user()->id))
						   @if ($permissao->unidade_id == $unidade->id)
						     <a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('competenciaNovo', array($unidade->id))}}" > Novo <i class="fas fa-check"></i></a>
						   @endif
						  @endif
						 @endforeach
						@endif
                      </h2>
                    </div>
                    
				    <div id="matriz" class=" collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                          <div class="accordion" id="accordionExample1" style="font-size: 13px;">
                          @foreach ($competenciasMatriz->pluck('setor')->unique() as $competenciaMatriz)
                            <div class="card">
                                <button style="font-size: 12px; text-decoration: none; background-color:#28a745!important" class="btn btn-link bg-success text-white" type="button" data-toggle="collapse" href="#{{str_replace('/','_',str_replace(' ','_',$competenciaMatriz))}}SETORES" aria-expanded="true" aria-controls="{{str_replace('/','_',str_replace(' ','_',$competenciaMatriz))}}SETORES">
                                  {{$competenciaMatriz}} <i style="margin-right: 2px;" class="fas fa-hand-pointer"></i>
                                </button>
                                <div id="{{str_replace('/','_',str_replace(' ','_',$competenciaMatriz))}}SETORES" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample1">
                                  <div class="card-body border-0">
                                    <h6>CARGOS</h6>
                                    @foreach ($competenciasMatriz as $item)
                                        @if ($item->setor === $competenciaMatriz)
                                        <div class="container">
                                          <div class="row">
                                            <div class="col-10 text-left">
                                              <p style="margin-bottom: 2px;">
												@if(Auth::check())
                                                <h4 style="font-size: 15px; margin-bottom: 5px;" class="text-success"><strong><a href="{{route('competenciaCadastro', array($unidade->id, $item->id))}}">{{$item->cargo}}</a></strong></h4>
												@else
												<h4 style="font-size: 15px; margin-bottom: 5px;" class="text-success"><strong>{{$item->cargo}}</strong></h4>
												@endif
												
                                              </p>
                                            </div>
                                            <div class="col-2">
                                        <p style="margin-bottom: 2px;">
                                          <a style="font-size: 10px; margin-bottom: 5px; background-color: #549864 !important; border-color:#549864 !important;" class="btn btn-success btn-sm" data-toggle="collapse" href="#{{$item->id}}" role="button" aria-expanded="false" aria-controls="{{$item->id}}">Descrição <i class="fas fa-file-alt"></i></a>
                                        </p>
                                        </div>
                                      </div>
                                      
                                      <div class="row">
                                        <div class="collapse border-0" id="{{$item->id}}">
                                          <div class="card border-0 card-body text-justify">
                                            <h6>DESCRIÇÃO: </h6>{{$item->descricao}}
				                          </div>
                                        </div>
                                      </div>
                                    </div>
                                        @endif
                                    @endforeach
                                    
                                  </div>
                                </div>
                            </div>
                          @endforeach
                        </div>
                        </div>
                          <div class="col-1"></div>
                        </div>
                        </div>
                    </div>
				 </div>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection