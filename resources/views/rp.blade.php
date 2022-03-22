@extends('layouts.app')
@section('title','Termo de Referência')
@section('content')

<body>
	<section id="portfolio-details" class="portfolio-details">
		<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
		<div class="container">
			<div class="row gy-3">
				<section class="cards">
					@foreach($contratacao_servicos as $CS)
					<div class="card">
						<div class="image">
							<img src="{{asset('img')}}/{{$CS->path_img}}" alt="">
						</div>
						<div class="content">
							<center>
								<p class="title text--medium"><b>{{$CS->nomeUnidade}}</b></p>
							</center>
							@if($CS->tipoPrazo == 1 && $CS->prazoProrroga == "")
							<center>
								<p class="title text--medium">As Propostas devem ser enviadas a partir do dia: <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?> até o dia: <?php echo date('d/m/Y', strtotime($CS->prazoFinal)); ?>.</p>
							</center>
							@elseif($CS->prazoProrroga != "")
							<center>
								<p class="title text--medium">O envio das propostas foi prorrogado até o dia <?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?>.</p>
							</center>
							@elseif($CS->tipoPrazo == 0)
							<center>
								<p class="title text--medium">As propostas devem ser enviadas a partir do dia: <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?>, <br> faça o seu credenciamento. </p>
							</center>
							@endif
							<center><a style="margin-bottom:20px" href="{{ route('rp2', $CS->id) }}" class="btn btn-primary">Clique Aqui</a></center>
						</div>
					</div>
					@endforeach
				</section>
			</div>
		</div>
	</section>
</body>
@endsection