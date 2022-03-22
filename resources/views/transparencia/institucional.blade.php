@extends('navbar.default-navbar')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
	@if (Session::has('mensagem'))
		@if ($text == true)
		<div class="container">
	     <div class="alert alert-success {{ Session::get ('mensagem')['class'] }} ">
		      {{ Session::get ('mensagem')['msg'] }}
		 </div>
		</div>
		@endif
	@endif

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 18px;">INSTITUCIONAL</h3>
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
					@if(($permissao->permissao_id == 1) && ($permissao->user_id == Auth::user()->id))
					  @if ($permissao->unidade_id == $unidade->id)
			             <p style="margin-right: -930px"><a class="btn btn-dark btn-sm" style="margin-top: 10px;" href="{{route('institucionalNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></p>
			          @endif
			        @endif
			     @endforeach   
				@endif
		</div>
    </div>
	<form action="{{\Request::route('update',$unidade->id)}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-7" style="font-size: 13px;">  
            <table class="table-sm" style="line-height: 1.5;">
                <tbody>
	                 <tr>
                        <td style="border-top: none;"><strong>Perfil: </strong></td>
                        <td style="border-top: none;" id="txtPerfil">{{$unidade->owner}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CNPJ: </strong></td>
                        <td style="border-top: none;" id="txtCnpj">{{ preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})/", "\$1.\$2.\$3/\$4\$5-", $unidade->cnpj)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Nome Unidade: </strong></td>
                        <td style="border-top: none;" id="txtNome">{{$unidade->name}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Logradouro: </strong></td>
                        <td style="border-top: none;" id="txtLogradouro">{{$unidade->address}} , {{$unidade->numero == null ? ' s/n' : $unidade->numero}}</td>
				    </tr>
                    @if(isset($unidade->further_info) || $unidade->further_info !== null)
                    <tr>
                        <td style="border-top: none;"><strong>Complemento: </strong></td>
                        <td style="border-top: none;" id="txtComplemento">{{$unidade->further_info}}</td>
				    </tr>
                    @endif
                    <tr>
                        <td style="border-top: none;"><strong>Bairro: </strong></td>
                        <td style="border-top: none;" id="txtBairro">{{$unidade->district}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Cidade: </strong></td>
                        <td style="border-top: none;" id="txtCity">{{$unidade->city}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>UF: </strong></td>
                        <td style="border-top: none;" id="txtUf">{{$unidade->uf}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CEP: </strong></td>
                        <td style="border-top: none;" id="txtCep">{{preg_replace("/(\d{2})(\d{3})/", "\$1.\$2-", $unidade->cep)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Telefone: </strong></td>
                        <td style="border-top: none;" id="txtTelefone">{{preg_replace("/(\d{4})(\d{4})/", "\$1-\$2", $unidade->telefone)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Horário: </strong></td>
                        <td style="border-top: none;" id="txtHorario">{{$unidade->time}}</td>
				    </tr>
                    @if(isset($unidade->cnes) || $unidade->cnes !== null)
                    <tr>
                        <td style="border-top: none;"><strong>CNES: </strong></td>
                        <td style="border-top: none;" id="txtCnes">{{$unidade->cnes}}</td>
				    </tr>
                    @endif

                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div style="height: 30px;">
                <div class="h-25 d-inline-block" style="width: 120px;"></div>
            </div>
            @if($unidade->id == 8)
			 <div class="mapouter"><div class="gmap_canvas"><iframe width="400" height="250" frameborder="0" style="border:0;" allowfullscreen="" id="gmap_canvas" src="https://maps.google.com/maps?q=hospital%20provisorio%20do%20recife%201&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a></div><style></style></div>	
			@elseif($unidade->id == 9)
			<div class="mapouter"><div class="gmap_canvas"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.159385034622!2d-34.90809708567257!3d-7.878386480531887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7ab151d44d99239%3A0x674ab3fd2685eecb!2sUPA%20-%20Unidade%20de%20Pronto%20Atendimento%20-%20Tipo%20III%20Igarassu!5e0!3m2!1spt-BR!2sbr!4v1646248243745!5m2!1spt-BR!2sbr" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a></div><style></style></div>
			@else
             <iframe src="{{$unidade->google_maps}}" width="400" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
			@endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"  style="font-size: 13px;">
            <table style="line-height: 1.5;">
                <tbody>
                    @if(isset($unidade->capacity) || $unidade->capacity !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2" id="txtCapacity"><strong>Capacidade: </strong>{!! $unidade->capacity !!}</td>
				    </tr>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</tr>
                    @endif
                    @if(isset($unidade->specialty) || $unidade->specialty !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2" id="txtSpecialty"><strong>Especialidades: </strong>{!!$unidade->specialty!!}</td>
				    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="col-md-8">
            @if($unidade->id == 8)
             <h3 style="font-size: 18px;">INFORMAÇÕES SOBRE A UNIDADE DE SAÚDE: </h3>
			  <h3 style="font-size: 18px;">HOSPITAL DE CAMPANHA AURORA</h3> <br>
			  <p style="color:#28a745;"><strong>1.	INTRODUÇÃO</strong></p>

			  <p align="justify" style="color:#28a745;">O modelo de Organização Social de Saúde, a ser adotado para gestão do HOSPITAL DE CAMPANHA AURORA, 
			     busca a modernidade e o aprimoramento da eficiência na prestação dos serviços públicos de saúde, tendo por objetivos: </p>
			  <p align="justify" style="color:#28a745;">•	Potencializar a qualidade na execução dos serviços de saúde e atendimento à população 
				    com suspeita ou diagnosticada com o novo Coronavírus (Covid - 19 / Síndrome 
					Respiratória Aguda Grave - SRAG). </p>
			  <p align="justify" style="color:#28a745;">•	Ampliar a capacidade de atendimento, com oferta de leitos clínicos e de unidade de 
					terapia intensiva exclusivos para atendimentos aos pacientes com suspeita ou 
					diagnosticados com o novo Coronavírus (Covid - 19 / Síndrome Respiratória Aguda 
					Grave - SRAG);</p>
			  <p align="justify" style="color:#28a745;">•	Melhorar o serviço ofertado ao usuário SUS com assistência humanizada. </p>

			  <p style="color:#28a745;">2.	INFORMAÇÕES SOBRE A UNIDADE A SER GERIDA PELA OSS</p>

			  <p style="color:#28a745;">HOSPITAL DE CAMPANHA AURORA</p>

			  <p align="justify" style="color:#28a745;">O HOSPITAL DE CAMPANHA AURORA, situado na Rua da Aurora, 1675,
				Santo Amaro, Recife/PE.</p>

			  <p style="color:#28a745;">3.	SERVIÇOS </p>

			  <p align="justify" style="color:#28a745;">0 HOSPITAL DE CAMPANHA AURORA será estruturado com perfil de 
				 hospital de grande porte, 160 leitos aptos a realizar procedimentos de média e alta 
				 complexidade para atendimento exclusivo aos pacientes suspeitos ou diagnosticados com o 
				 novo Coronavírus (Covid - 19/ Síndrome Respiratória Aguda Grave - SRAG) através de Cuidados 
				 Intensivos e Internação, em regime de demanda regulada pelo Município do Recife. </p>
			  <p align="justify" style="color:#28a745;">3.1.	Serviço de Apoio Diagnóstico e Terapêutico - SADT A unidade hospitalar deverá 
						disponibilizar exames e ações de apoio diagnóstico e terapêutico a pacientes atendidos em 
						regime de Internação em leitos clínicos e de unidade terapia intensiva. </p>
			  <p style="color:#28a745;">3.2.	Internação </p>

			  <p align="justify" style="color:#28a745;">O hospital funcionará com capacidade operacional para 160 leitos de internação assim 
				 distribuídos:</p>
			  <p style="color:#28a745;">•	60 leitos clínicos de enfermaria de isolamento; </p>
			  <p style="color:#28a745;">•	100 leitos de Unidade de Terapia Intensiva — UTI Geral. </p>
			  <p align="justify" style="color:#28a745;">Todos os leitos do hospital deverão estar disponibilizados para a Central de Regulação Leitos do 
				 Estado. </p>
				 
			  <p style="color:#28a745;">3.2.1.	ASSISTÊNCIA HOSPITALAR</p>

			  <p align="justify" style="color:#28a745;">A assistência à saúde prestada em regime de hospitalização compreende o conjunto de 
				 atendimentos oferecidos ao paciente suspeito ou diagnosticado com o novo Coronavírus (Covid
				 - 19/ Síndrome Respiratória Aguda Grave - SRAG), desde sua admissão no hospital até sua alta 
				 hospitalar, incluindo-se aí todos os atendimentos e procedimentos necessários para obter ou 
				 completar o diagnóstico e as terapêuticas necessárias para o tratamento no âmbito hospitalar. 
				 No processo de hospitalização estão incluídos: </p>
			 <p align="justify" style="color:#28a745;">3.2.2.	Tratamento das possíveis complicações que possam ocorrer ao longo do processo 
						assistencial, tanto na fase de tratamento, quanto na fase de recuperação. </p>
			 <p align="justify" style="color:#28a745;">3.2.3.	Tratamentos concomitantes, diferentes daquele classificado como diagnóstico 
						principal que motivaram a internação do paciente, que podem ser necessários, 
						adicionalmente, devido às condições especiais do paciente e/ou outras causas. </p>
			 <p align="justify" style="color:#28a745;">3.2.4.	Tratamento medicamentoso que seja requerido durante o processo de internação.</p>
			 <p align="justify" style="color:#28a745;">3.2.5.	Procedimentos e cuidados de enfermagem, necessários durante o processo de 
						internação.</p>
			 <p align="justify" style="color:#28a745;">3.2.6.	Alimentação, incluída a assistência nutricional, alimentação enteral e parenteral. </p>
			 <p align="justify" style="color:#28a745;">3.2.7.	Assistência por equipe médica especializada, pessoal de enfermagem e pessoal técnico. </p>
			 <p align="justify" style="color:#28a745;">3.2.8.	O material descartável necessário para os cuidados de enfermagem e tratamentos. </p>

			 <p align="justify" style="color:#28a745;">3.2.9.	Diárias de hospitalização em quarto compartilhado ou individual, quando necessário, 
						devido às condições especiais do paciente e quarto de isolamento. </p>
			 <p style="color:#28a745;">3.2.10.	Sangue e hemoderivados. </p>
			 <p style="color:#28a745;">3.2.11.	Hemodiálise para os pacientes internados. </p>
			 <p style="color:#28a745;">3.2.12.	Fornecimento de roupas hospitalares. </p>
			 <p align="justify" style="color:#28a745;">3.2.13. Procedimentos especiais que se fizerem necessários ao adequado atendimento e 
						tratamento do paciente, de acordo com a capacidade instalada, respeitando a 
						complexidade e o perfil estabelecido para o HOSPITAL DE CAMPANHA AURORA </p>
			@endif
        </div>
	<br>
	<table>
		<tr>
			<td>
				<a href="{{route('transparenciaInstitucionalPdf', $unidade->id)}}" target="__blank" class="btn btn-success btn-sm" style="margin-top: 10px;">Download <i class="fas fa-file-pdf"></i></a>
			</td>
			<td> 
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
					@if(($permissao->permissao_id == 1) && ($permissao->user_id == Auth::user()->id))
					  @if ($permissao->unidade_id == $unidade->id)
			             <a class="btn btn-info btn-sm" style="margin-top: 10px;" href="{{route('institucionalCadastro', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
			          @endif
			        @endif
			     @endforeach   
				@endif
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
</div>

@endsection
