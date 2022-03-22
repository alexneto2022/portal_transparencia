<?php

Route::get('/', 'IndexController@index')->name('welcome');
Route::get('/rp', 'IndexController@rp')->name('rp');
Route::get('/rp2/{id}', 'IndexController@rp2')->name('rp2');

Route::prefix('transparencia')->group( function(){
	Route::get('/{id}', 'IndexController@trasparenciaHome')->name('transparenciaHome');	
	Route::get('associados/export', 'IndexController@exportAssociados')->name('exportAssociados');
    Route::get('conselhoadmin/export', 'IndexController@exportConselhoAdm')->name('exportConselhoAdm');
    Route::get('conselhofisc/export', 'IndexController@exportConselhoFisc')->name('exportConselhoFisc');
    Route::get('superintendente/export', 'IndexController@exportSuperintendente')->name('exportSuperintendente');
    Route::get('estatuto/{id}', 'IndexController@transparenciaEstatuto')->name('transparenciaEstatuto');
    Route::get('documentos/{id}/{escolha}', 'IndexController@transparenciaDocumento')->name('transparenciaDocumento');
	Route::get('organizacional/{id}', 'IndexController@transparenciaOrganizacional')->name('transparenciaOrganizacional');
    Route::get('decreto/{id}', 'IndexController@transparenciaDecreto')->name('transparenciaDecreto');
    Route::get('manual/{id}', 'IndexController@transparenciaManual')->name('transparenciaManual');
    Route::get('pregao/{id}', 'IndexController@transparenciaPregao')->name('transparenciaPregao');
    Route::get('contratos-gestao/{id}/{escolha}', 'IndexController@transparenciaContratoGestao')->name('transparenciaContratoGestao');
    Route::get('despesas/{id}', 'IndexController@transparenciaDespesas')->name('transparenciaDespesas');
    Route::get('regulamento/{id}', 'IndexController@transparenciaRegulamento')->name('transparenciaRegulamento');
    Route::get('assistencial/{id}', 'IndexController@transparenciaAssistencial')->name('transparenciaAssistencial');
    Route::get('assistencial/export/{id}/{year}', 'IndexController@exportAssistencialMensal')->name('exportAssistencialMensal');
    Route::get('assistencial/export/{id}', 'IndexController@exportAssistencialAnual')->name('exportAssistencialAnual');
	Route::get('assistencial/{id}/visualizar', 'IndexController@visualizarAssistencial')->name('visualizarAssistencial');
    Route::get('institucional/{id}', 'IndexController@transparenciaInstitucionalPdf')->name('transparenciaInstitucionalPdf');
    Route::get('competencia/{id}', 'IndexController@transparenciaCompetencia')->name('transparenciaCompetencia');
	Route::get('relatorioGerencial/{id}', 'IndexController@transparenciaRelatorioGerencial')->name('transparenciaRelatorioGerencial');
    Route::get('relatorio-financeiro/{id}','IndexController@transparenciaFinanReports')->name('transparenciaFinanReports');
    Route::get('demonstrativo-financeiro/{id}','IndexController@transparenciaDemonstrative')->name('transparenciaDemonstrative');
    Route::get('demonstrativo-contabel/{id}','IndexController@transparenciaAccountable')->name('transparenciaAccountable');
	Route::get('membros/{id}/{escolha}', 'IndexController@transparenciaMembros')->name('transparenciaMembros');
    Route::get('repasses-recebidos/{id}','IndexController@transparenciaRepasses')->name('transparenciaRepasses');
    Route::get('repasses/export/{id}/{year}', 'IndexController@repassesExport')->name('repassesExport');
	Route::get('repasses-recebidos/export/{id}/{year}', 'IndexController@repassesSomExport')->name('repassesSomExport');
    Route::get('contratacao/{id}','IndexController@transparenciaContratacao')->name('transparenciaContratacao');
	Route::get('contratacao/{id}/pesquisarMesCotacao/{mes}/{ano}','IndexController@pesquisarMesCotacao')->name('pesquisarMesCotacao');
    Route::get('recursos-humanos/{id}','IndexController@transparenciaRecursosHumanos')->name('transparenciaRecursosHumanos');
	Route::get('bens-publicos/{id}','IndexController@transparenciaBensPublicos')->name('transparenciaBensPublicos');
	Route::get('pdf/assistencial/{id}/{year}','IndexController@assistencialPdf')->name('assistencialPdf'); 
	Route::get('covenio/{id}','IndexController@transparenciaCovenio')->name('transparenciaCovenio');
	Route::get('relcontasAtual/{id}','IndexController@transparenciaContasAtual')->name('transparenciaContasAtual');
	Route::get('relmensalExecucao/{id}','IndexController@transparenciaRelMensalExecucao')->name('transparenciaRelMensalExecucao');
	Route::get('relfinanceiroExercicio/{id}','IndexController@transparenciaMensalFinanceiroExercico')->name('transparenciaMensalFinanceiroExercico');
	Route::get('resultadoProcessosCotacao/{id}','IndexController@transparenciaProcessoCotacao')->name('transparenciaProcessoCotacao');
	Route::get('ouvidoria/{id}','IndexController@transparenciaOuvidoria')->name('transparenciaOuvidoria');
	Route::get('home_compras/ordem_compra/ordemCompraVisualizar/{id}','IndexController@visualizarOrdemCompra')->name('visualizarOrdemCompra');
	Route::post('home_compras/ordem_compra/ordemCompraVisualizar/{id}','IndexController@procuraVisualizarOrdemCompra')->name('procuraVisualizarOrdemCompra');
	Route::get('recursos-humanos/{id}/selecaoPcadastro/despesasUsuarioRH','IndexController@despesasUsuarioRH')->name('despesasUsuarioRH');
	Route::post('recursos-humanos/{id}/selecaoPcadastro/despesasRH','IndexController@despesasUsuarioRHProcurar')->name('despesasUsuarioRHProcurar');
});

Auth::routes();

Route::get('auth/login','UserController@telaLogin')->name('telaLogin');
Route::get('auth/login/reset','UserController@telaEmail')->name('telaEmail');
//Route::get('auth/register', 'UserController@telaRegistro')->name('telaRegistro');
//Route::post('auth/register', 'UserController@store')->name('store');
Route::get('auth/passwords/email', 'UserController@telaEmail')->name('telaEmail');
Route::post('auth/login', 'UserController@Login')->name('Login');
Route::get('auth/login/emailreset', 'UserController@emailReset')->name('emailReset');
Route::post('auth/login/emailreset','UserController@emailReset')->name('emailReset');
Route::get('auth/passwords/reset', 'UserController@telaReset')->name('telaReset');
Route::post('auth/passwords/reset','UserController@resetarSenha')->name('resetarSenha');

Route::middleware(['auth'])->group( function() {

	//Ordem de Compra
	Route::get('home_compras', 'HomeController@home_compras')->name('home_compras');
	Route::get('home_compras/ordem_compra/{id}','HomeController@transparenciaOrdemCompra')->name('transparenciaOrdemCompra');
	Route::post('home_compras/ordem_compra/{id}','HomeController@procuraOrdemCompra')->name('procuraOrdemCompra');
	Route::get('home_compras/ordem_compra/novo/{id}/arquivo','HomeController@transparenciaOrdemCompraNovoArquivo')->name('transparenciaOrdemCompraNovoArquivo');
	Route::post('home_compras/ordem_compra/novo/{id}/arquivo','HomeController@storeOrdemCompraNovoArquivo')->name('storeOrdemCompraNovoArquivo');
	Route::get('home_compras/ordem_compra/novo/{id}','HomeController@transparenciaOrdemCompraNovo')->name('transparenciaOrdemCompraNovo');
	Route::get('home_compras/ordem_compra/alterar/ordemCompraAlterar/{unidade_id}/{id}','HomeController@ordemCompraAlterar')->name('ordemCompraAlterar');
	Route::get('home_compras/ordem_compra/excluir/ordemCompraExcluir/{unidade_id}/{id}','HomeController@ordemCompraExcluir')->name('ordemCompraExcluir');
	Route::post('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/{id_processo}','HomeController@storeArquivoOrdemCompra')->name('storeArquivoOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/addOrdemCompra','HomeController@addOrdemCompra')->name('addOrdemCompra');
	Route::post('home_compras/ordem_compra/{id}/cadastcadastroArquivosOrdemCompraroCotacoes/addOrdemCompra', 'HomeController@storeExcelOrdemCompra')->name('storeExcelOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/addOrdemCompra','HomeController@addOrdemCompra')->name('addOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/{id_processo}','HomeController@arquivosOrdemCompra')->name('arquivosOrdemCompra');
	Route::post('home_compras/ordem_compra/novo/{id}','HomeController@storeOrdemCompra')->name('storeOrdemCompra');
	Route::post('home_compras/ordem_compra/alterar/ordemCompraAlterar/{unidade_id}/{id}','HomeController@updateOrdemCompra')->name('updateOrdemCompra');
	Route::post('home_compras/ordem_compra/excluir/ordemCompraExcluir/{unidade_id}/{id}','HomeController@destroyOrdemCompra')->name('destroyOrdemCompra');
	
	//Contratação de serviços
	Route::get('contracaoServicos/','ContratacaoServicosController@paginaContratacaoServicos')->name('paginaContratacaoServicos');
	Route::post('contracaoServicos/','ContratacaoServicosController@paginaContratacaoServicos')->name('paginaContratacaoServicos');
	Route::get('contracaoServicos/nova','ContratacaoServicosController@novaContratacaoServicos')->name('novaContratacaoServicos');
	Route::post('contracaoServicos/nova','ContratacaoServicosController@novaContratacaoServicos')->name('novaContratacaoServicos');
	Route::post('contracaoServicos/cadastro','ContratacaoServicosController@salvarContratacaoServicos')->name('salvarContratacaoServicos');
	Route::get('contracaoServicos/pesquisa','ContratacaoServicosController@pesquisarContratacao')->name('pesquisarContratacao');
	Route::post('contracaoServicos/pesquisa','ContratacaoServicosController@pesquisarContratacao')->name('pesquisarContratacao');
	Route::get('contracaoServicos/paginaexcluir/{id}','ContratacaoServicosController@pagExcluirContratacao')->name('pagExcluirContratacao');
	Route::get('contracaoServicos/confirmexcluir/{id}','ContratacaoServicosController@excluirContratacao')->name('excluirContratacao');
	Route::get('contracaoServicos/excEspContr/{idContr}/{idEsp}','ContratacaoServicosController@exclEspeContr')->name('exclEspeContr');
	Route::get('contracaoServicos/paginaAlterar/{id}','ContratacaoServicosController@pagAlteraContratacao')->name('pagAlteraContratacao');
	Route::get('contracaoServicos/confirAlterar/{id}','ContratacaoServicosController@alteraContratacao')->name('alteraContratacao');
	Route::post('contracaoServicos/confirAlterar/{id}','ContratacaoServicosController@alteraContratacao')->name('alteraContratacao');
	Route::get('contracaoServicos/exclArqContr/{id}','ContratacaoServicosController@exclArqContr')->name('exclArqContr');
	Route::post('contracaoServicos/exclArqContr/{id}','ContratacaoServicosController@exclArqContr')->name('exclArqContr');
	Route::get('contracaoServicos/pagProrrContr/{id}','ContratacaoServicosController@pagProrrContr')->name('pagProrrContr');
	Route::post('contracaoServicos/prorrContr/{id}','ContratacaoServicosController@prorrContr')->name('prorrContr');
	Route::get('contracaoServicos/exclArqErratContr/{id}','ContratacaoServicosController@exclArqErratContr')->name('exclArqErratContr');
	Route::post('contracaoServicos/exclArqErratContr/{id}','ContratacaoServicosController@exclArqErratContr')->name('exclArqErratContr');
	

	Route::get('especialidade/cadastro','ContratacaoServicosController@paginaEspecialidade')->name('paginaEspecialidade');
	Route::post('especialidade/cadastro','ContratacaoServicosController@paginaEspecialidade')->name('paginaEspecialidade');
	Route::get('especialidade/nova','ContratacaoServicosController@novaEspecialidade')->name('novaEspecialidade');
	Route::post('especialidade/nova','ContratacaoServicosController@novaEspecialidade')->name('novaEspecialidade');
	Route::post('especialidade/cadastro','ContratacaoServicosController@salvarEspecialidade')->name('salvarEspecialidade');
	Route::get('especialidade/','ContratacaoServicosController@pesquisarEspecialidade')->name('pesquisarEspecialidade');
	Route::post('especialidade/','ContratacaoServicosController@pesquisarEspecialidade')->name('pesquisarEspecialidade');
	Route::get('especialidade/paginaExclusao/{id}','ContratacaoServicosController@pagExcluirEspeciali')->name('pagExcluirEspeciali');
	Route::get('especialidade/confirExclusao/{id}','ContratacaoServicosController@excluirEspecialidade')->name('excluirEspecialidade');
	Route::get('especialidade/paginaAlterar/{id}','ContratacaoServicosController@pagAlteraEspeciali')->name('pagAlteraEspeciali');
	Route::get('especialidade/confirAlterar/{id}','ContratacaoServicosController@AlteraEspeciali')->name('AlteraEspeciali');
	Route::post('especialidade/confirAlterar/{id}','ContratacaoServicosController@AlteraEspeciali')->name('AlteraEspeciali');


	Route::prefix('home')->group( function(){
		Route::get('', 'HomeController@index')->name('home');
		Route::get('/{id}', 'HomeController@index')->name('index');	
		
		//Permissao
		Route::get('permissao/{id}', 'PermissaoController@cadastroPermissao')->name('cadastroPermissao');
		Route::get('permissao/{id}/permissaoNovo', 'PermissaoController@permissaoNovo')->name('permissaoNovo');
		Route::get('permissao/{id}/permissaoUsuarioNovo', 'PermissaoController@permissaoUsuarioNovo')->name('permissaoUsuarioNovo');
		Route::get('permissao/{id}/permissaoAlterar/{id_permissao}', 'PermissaoController@permissaoAlterar')->name('permissaoAlterar');
		Route::post('permissao/{id}/permissaoAlterar/{id_permissao}','PermissaoController@update')->name('update');
		Route::get('permissao/{id}/permissaoExcluir/{id_permissao}', 'PermissaoController@permissaoExcluir')->name('permissaoExcluir');
		Route::post('permissao/{id}/permissaoExcluir/{id_permissao}','PermissaoController@destroy')->name('destroy');
		////
		
		//Institucional
		Route::get('institucionalCadastro/{id}', 'InstitucionalController@institucionalCadastro')->name('institucionalCadastro');
		Route::get('institucionalCadastro/{id}/institucionalNovo','InstitucionalController@institucionalNovo')->name('institucionalNovo');
		Route::get('institucionalCadastro/institucionalAlterar/{id}','InstitucionalController@institucionalAlterar')->name('institucionalAlterar');
		Route::get('institucionalCadastro/institucionalExcluir/{id}','InstitucionalController@institucionalExcluir')->name('institucionalExcluir');
		Route::post('institucionalCadastro/institucionalAlterar/{id}','InstitucionalController@update')->name('update');
		Route::post('institucionalCadastro/institucionalExcluir/{id}','InstitucionalController@destroy')->name('destroy');

		//Organizacional
		Route::get('organizacionalNovo/{id}', 'OrganizationalController@organizacionalNovo')->name('organizacionalNovo');
		Route::get('organizacionalCadastro/{id}', 'OrganizationalController@organizacionalCadastro')->name('organizacionalCadastro');
		Route::get('organizacionalCadastro/{id}/{id_item}', 'OrganizationalController@organizacionalValidar')->name('organizacionalValidar');
		Route::get('organizacionalAlterar/{id_item}/unidade/{id_unidade}', 'OrganizationalController@organizacionalAlterar')->name('organizacionalAlterar');
		Route::get('organizacionalExcluir/{id_item}/unidade/{id_unidade}', 'OrganizationalController@organizacionalExcluir')->name('organizacionalExcluir');
		Route::post('organizacionalAlterar/{id_item}/unidade/{id_unidade}','OrganizationalController@update')->name('update');
		Route::post('organizacionalExcluir/{id_item}/unidade/{id_unidade}','OrganizationalController@destroy')->name('destroy');
		////
	
		//RegimentoInterno
		Route::get('regimento/{id}','RegimentoInternoController@regimentoCadastro')->name('regimentoCadastro');
		Route::get('regimento/{id}/regimentoNovo','RegimentoInternoController@regimentoNovo')->name('regimentoNovo');
		Route::get('regimento/{id}/regimentoExcluir/{id_escolha}','RegimentoInternoController@regimentoExcluir')->name('regimentoExcluir');
		Route::post('regimento/{id}/regimentoExcluir/{id_escolha}','RegimentoInternoController@destroy')->name('destroy');
		Route::get('organograma/{id}','OrganizationalController@organograma')->name('organograma');
		Route::get('organograma/{id}/organogramaNovo','OrganizationalController@organogramaNovo')->name('organogramaNovo');
		Route::get('organograma/{id}/organogramaExcluir','OrganizationalController@organogramaExcluir')->name('organogramaExcluir');
		Route::post('organograma/{id}/organogramaExcluir','OrganizationalController@destroyOrganograma')->name('destroyOrganograma');
		////

		//Competências
		Route::get('competencia/{id_unidade}/competenciaListar','CompetenciaController@competenciaListar')->name('competenciaListar');
		Route::get('competencia/{id_unidade}/competenciaNovo','CompetenciaController@competenciaNovo')->name('competenciaNovo');
		Route::get('competencia/{id_unidade}/competenciaCadastro/{id_item}', 'CompetenciaController@competenciaCadastro')->name('competenciaCadastro');
		Route::get('competencia/{id_unidade}/competenciaCadastro/{id_item}/competenciaValidar', 'CompetenciaController@competenciaValidar')->name('competenciaValidar');
		Route::get('competencia/{id_unidade}/competenciaExcluir/{id_item}','CompetenciaController@competenciaExcluir')->name('competenciaExcluir');
		Route::get('competencia/{id_unidade}/competenciaAlterar/{id_item}', 'CompetenciaController@competenciaAlterar')->name('competenciaAlterar');
		Route::post('/competencia/{id_unidade}/competenciaAlterar/{id_item}','CompetenciaController@update')->name('update');
		Route::post('/competencia/{id_unidade}/competenciaExcluir/{id_item}','CompetenciaController@destroy')->name('destroy');
		///
		
		//Associados:	
		Route::get('membros/{id}/Associados/associadoNovo','AssociadoController@associadoNovo')->name('associadoNovo');
		Route::get('membros/{id}/Associados/associadoNovo/associadoValidar/{id_item}','AssociadoController@associadoValidar')->name('associadoValidar');
		Route::get('membros/{id}/Associados/listarAssociado','AssociadoController@listarAssociado')->name('listarAssociado');
		Route::get('membros/{id_unidade}/Associados/associadoAlterar/{id_associado}','AssociadoController@associadoAlterar')->name('associadoAlterar');
		Route::get('membros/{id}/Associados/associadoExcluir/{id_associado}','AssociadoController@associadoExcluir')->name('associadoExcluir');
		Route::post('membros/{id_unidade}/Associados/associadoAlterar/{id_associado}','AssociadoController@update')->name('update');
		Route::post('membros/{id_unidade}/Associados/associadoExcluir/{id_associado}','AssociadoController@destroy')->name('destroy');
		////
	
		//ConselhoAdm
		Route::get('membros/{id}/Associados/listarConselhoAdm','ConselhoAdmController@listarConselhoAdm')->name('listarConselhoAdm');
		Route::get('membros/{id}/Associados/conselhoAdmNovo','ConselhoAdmController@conselhoAdmNovo')->name('conselhoAdmNovo');
		Route::get('membros/{id}/Associados/conselhoAdmNovo/conselhoAdmValidar/{id_item}','ConselhoAdmController@conselhoAdmValidar')->name('conselhoAdmValidar');
		Route::get('membros/{id_unidade}/Associados/conselhoAdmAlterar/{id_associado}','ConselhoAdmController@conselhoAdmAlterar')->name('conselhoAdmAlterar');
		Route::get('membros/{id}/Associados/conselhoAdmExcluir/{id_associado}','ConselhoAdmController@conselhoAdmExcluir')->name('conselhoAdmExcluir');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmAlterar/{id_associado}','ConselhoAdmController@update')->name('update');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmExcluir/{id_associado}','ConselhoAdmController@destroy')->name('destroy');
		////

		//ConselhoFisc
		Route::get('membros/{id}/Associados/listarConselhoFisc','ConselhoFiscController@listarConselhoFisc')->name('listarConselhoFisc');
		Route::get('membros/{id}/Associados/conselhoFiscNovo/conselhoFiscValidar/{id_item}','ConselhoFiscController@conselhoFiscValidar')->name('conselhoFiscValidar');
		Route::get('membros/{id}/Associados/conselhoFiscNovo','ConselhoFiscController@conselhoFiscNovo')->name('conselhoFiscNovo');
		Route::get('membros/{id_unidade}/Associados/conselhoFiscAlterar/{id_associado}','ConselhoFiscController@conselhoFiscAlterar')->name('conselhoFiscAlterar');
		Route::get('membros/{id}/Associados/conselhoFiscExcluir/{id_associado}','ConselhoFiscController@conselhoFiscExcluir')->name('conselhoFiscExcluir');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscAlterar/{id_associado}','ConselhoFiscController@update')->name('update');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscExcluir/{id_associado}','ConselhoFiscController@destroy')->name('destroy');
		////
		
		//Superintendente
		Route::get('membros/{id}/Superentendentes/listarSuper','SuperintendentesController@listarSuper')->name('listarSuper');
		Route::get('membros/{id}/Superentendentes/listarSuper/superValidar/{id_item}','SuperintendentesController@superValidar')->name('superValidar');
		Route::get('membros/{id}/Superentendentes/superNovo','SuperintendentesController@superNovo')->name('superNovo');
		Route::get('membros/{id_unidade}/Superentendentes/superAlterar/{id_super}','SuperintendentesController@superAlterar')->name('superAlterar');
		Route::get('membros/{id}/Superentendentes/superExcluir/{id_super}','SuperintendentesController@superExcluir')->name('superExcluir');
		Route::post('membros/{id_unidade}/Superentendentes/superAlterar/{id_super}','SuperintendentesController@update')->name('update');
		Route::post('membros/{id_unidade}/Superentendentes/superExcluir/{id_super}','SuperintendentesController@destroy')->name('destroy');
		////
		
		//ContratodeGestão
		Route::get('contratos-gestao/{id_unidade}/contratoCadastro','ContratoController@contratoCadastro')->name('contratoCadastro');
		Route::get('contratos-gestao/{id_unidade}/contratoCadastro/contratoValidar/{id_item}','ContratoController@contratoValidar')->name('contratoValidar');
		Route::get('contratos-gestao/{id_unidade}/contratoNovo','ContratoController@contratoNovo')->name('contratoNovo');
		Route::get('contratos-gestao/{id_unidade}/contratoAlterar/{escolha}','ContratoController@contratoAlterar')->name('contratoAlterar');
		Route::get('contratos-gestao/{id_unidade}/contratoExcluir/{escolha}','ContratoController@contratoExcluir')->name('contratoExcluir');
		Route::post('contratos-gestao/{id_unidade}/contratoAlterar/{escolha}','ContratoController@update')->name('update');
		Route::post('contratos-gestao/{id_uniddae}/contratoExcluir/{escolha}','ContratoController@destroy')->name('destroy');
		////

		//Demonstrativo Financeiro
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroCadastro','DemonstrativoFinanceiroController@demonstrativoFinanCadastro')->name('demonstrativoFinanCadastro');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroCadastro/financeiroValidar/{id_item}','DemonstrativoFinanceiroController@demonstrativoFinanValidar')->name('demonstrativoFinanValidar');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroNovo','DemonstrativoFinanceiroController@demonstrativoFinanNovo')->name('demonstrativoFinanNovo');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroAlterar/{id_item}','DemonstrativoFinanceiroController@demonstrativoFinanAlterar')->name('demonstrativoFinanAlterar');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroExcluir/{id_item}','DemonstrativoFinanceiroController@demonstrativoFinanExcluir')->name('demonstrativoFinanExcluir');
		//Route::post('demonstrativo-financeiro/{id_unidade}/financeiroAlterar/{id_item}','DemonstrativoFinanceiroController@update')->name('update');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroExcluir/{id_item}','DemonstrativoFinanceiroController@destroy')->name('destroy');
		////

		//Demonstrativo Contabil
		Route::get('demonstrativo-contabel/{id_unidade}/contabelCadastro','DemonstracaoContabelController@demonstrativoContCadastro')->name('demonstrativoContCadastro');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelCadastro/{id_item}','DemonstracaoContabelController@demonstrativoContValidar')->name('demonstrativoContValidar');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelNovo','DemonstracaoContabelController@demonstrativoContNovo')->name('demonstrativoContNovo');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelExcluir/{id_item}','DemonstracaoContabelController@demonstrativoContExcluir')->name('demonstrativoContExcluir');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelExcluir/{id_item}','DemonstracaoContabelController@destroy')->name('destroy');
		////
		
		//Repasses Recebidos	
		Route::get('repasses-recebidos/{id}/repassesCadastro','RepasseController@repasseCadastro')->name('repasseCadastro');
		Route::get('repasses-recebidos/{id}/repassesCadastro/{id_item}/repasseValidar','RepasseController@repasseValidar')->name('repasseValidar');
		Route::get('repasses-recebidos/{id}/repassesNovo','RepasseController@repasseNovo')->name('repasseNovo');
		Route::get('repasses-recebidos/{id_unidade}/repassesAlterar/{id_item}','RepasseController@repasseAlterar')->name('repasseAlterar');
		Route::get('repasses-recebidos/{id}/repassesExcluir/{id_item}','RepasseController@repasseExcluir')->name('repasseExcluir');
		Route::post('repasses-recebidos/{id_unidade}/repassesAlterar/{id_item}','RepasseController@update')->name('update');
		Route::post('repasses-recebidos/{id_unidade}/repassesExcluir/{id_item}','RepasseController@destroy')->name('destroy');
		////

		//Contratacoes
		Route::get('contratacao/{id}/contratacaoCadastro','ContratacaoController@contratacaoCadastro')->name('contratacaoCadastro');
		Route::get('contratacao/{id}/cadastroContratos/','ContratacaoController@cadastroContratos')->name('cadastroContratos');
		Route::get('contratacao/{id}/cadastroContratos/pesquisarPrestador/','ContratacaoController@pesquisarPrestador')->name('pesquisarPrestador');	
		Route::post('contratacao/{id}/cadastroContratos/procurarPrestador','ContratacaoController@procurarPrestador')->name('procurarPrestador');	
		Route::get('contratacao/{id}/cadastroContratos/{id_prestador}','ContratacaoController@pesqPresdator')->name('pesqPresdator');
		Route::get('contratacao/{id}/cadastroPrestador','ContratacaoController@prestadorCadastro')->name('prestadorCadastro');
		Route::get('contratacao/{id}/cadastroResponsavel/{id_contrato}','ContratacaoController@responsavelCadastro')->name('responsavelCadastro');
		Route::get('contratacao/{id}/validarResponsavel/{id_contrato}/{id_gestor}','ContratacaoController@validarGestorContrato')->name('validarGestorContrato');
		Route::get('contratacao/{id}/responsavelNovo/{id_contrato}','ContratacaoController@responsavelNovo')->name('responsavelNovo');
		Route::get('contratacao/{id}/excluirContratos/{id_contrato}/{id_prestador}','ContratacaoController@excluirContratos')->name('excluirContratos');
		Route::get('contratacao/{id}/excluirCotacoes/{id_cotacao}','ContratacaoController@excluirCotacoes')->name('excluirCotacoes');
		Route::get('contratacao/{id}/validarCotacoes/{id_cotacao}','ContratacaoController@validarCotacoes')->name('validarCotacoes');
		Route::get('contratacao/{id}/alterarContratos/{id_contrato}/{id_prestador}', 'ContratacaoController@alterarContratos')->name('alterarContratos');
		Route::get('contratacao/{id}/alterarAditivo/{id_contrato}/{id_prestador}', 'ContratacaoController@alterarAditivo')->name('alterarAditivo');
		Route::get('contratacao/{id}/cadastroCotacoes/addCotacao','ContratacaoController@addCotacao')->name('addCotacao');
		Route::get('contratacao/{id}/cadastroArquivosCotacoes/{id_processo}','ContratacaoController@arquivosCotacoes')->name('arquivosCotacoes');
		Route::post('contratacao/{id}/alterarContratos/{id_contrato}/{id_prestador}', 'ContratacaoController@updateContratos')->name('updateContratos');
		Route::post('contratacao/{id}/alterarAditivo/{id_contrato}/{id_prestador}', 'ContratacaoController@updateAditivo')->name('updateAditivo');
		Route::post('contratacao/{id}/excluirContratos/{id_contrato}/{id_prestador}','ContratacaoController@destroy')->name('destroy');
		Route::get('contratacao/{id}/excluirContratos/{id_aditivo}', 'ContratacaoController@excluirAditivos')->name('excluirAditivos');
		Route::get('contratacao/{id}/excluirAditivos/{id_aditivo}/{id_prestador}', 'ContratacaoController@excluirAditivo')->name('excluirAditivo');
		Route::post('contratacao/{id}/excluirAditivos/{id_aditivo}/{id_prestador}','ContratacaoController@destroyAditivo')->name('destroyAditivo');
		////

		//Cotacoes
		Route::get('contratacao/{id}/cadastroCotacoes','ContratacaoController@cadastroCotacoes')->name('cadastroCotacoes');
		Route::get('contratacao/{id}/cadastroCotacoes/cotacoesNovo','ContratacaoController@cotacoesNovo')->name('cotacoesNovo');
		Route::get('contratacao/{id}/cadastroCotacoes/excluirCotacoes/{id_cotacao}','ContratacaoController@excluirCotacoes')->name('excluirCotacoes');
		Route::post('contratacao/{id}/cadastroCotacoes/excluirCotacoes/{id_cotacao}','ContratacaoController@destroyCotacao')->name('destroyCotacao');
		////

		//RH - SeleçãoPessoal
		Route::get('recursos-humanos/{id}/selecaoPCadastro','RHController@selecaoPCadastro')->name('selecaoPCadastro');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPValidar/{id_item}','RHController@selecaoPValidar')->name('selecaoPValidar');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo','RHController@selecaoPNovo')->name('selecaoPNovo');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPAlterar/{id_item}','RHController@selecaoPAlterar')->name('selecaoPAlterar');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPExcluir/{id_item}','RHController@selecaoPExcluir')->name('selecaoPExcluir');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/despesasRH','RHController@despesasRH')->name('despesasRH');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo/selecaoPCargos','RHController@selecaoPCargos')->name('selecaoPCargos');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/excluirDespesasRH','RHController@excluirDespesasRH')->name('excluirDespesasRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/excluirDespesasRH','RHController@destroyDespesasRH')->name('destroyDespesasRH');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPAlterar/{id_item}','RHController@updateSelecao')->name('updateSelecao');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPExcluir/{id_item}','RHController@destroySelecao')->name('destroySelecao');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/despesasRH','RHController@despesasRHProcurar')->name('despesasRHProcurar');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/alterarDespesaRH/{ano}/{mes}/{tipo}','RHController@alterarRH')->name('alterarRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/alterarDespesaRH/{ano}/{mes}/{tipo}','RHController@updateDespesasRH')->name('updateDespesasRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/deletarDespesaRH/{ano}/{mes}/{tipo}','RHController@deletarRH')->name('deletarRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/deletarDespesaRH/{ano}/{mes}/{tipo}','RHController@destroyDespesasRH')->name('destroyDespesasRH');


		//RH - Processo Seletivo
		Route::get('recursos-humanos/{id}/processoSCadastro','RHController@processoSCadastro')->name('processoSCadastro');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSValidar/{id_item}','RHController@processoSValidar')->name('processoSValidar');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSNovo','RHController@processoSNovo')->name('processoSNovo');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSExcluir/{id_item}','RHController@processoSExcluir')->name('processoSExcluir');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSExcluir/{id_item}','RHController@destroySeletivo')->name('destroySeletivo');

		//RH - SP Cedidos
		Route::get('recursos-humanos/{id}/servidoresPCadastro','RHController@servidoresPCadastro')->name('servidoresPCadastro');

		//RH - Regulamento
		Route::get('recursos-humanos/{id}/regulamentoCadastro','RHController@regulamentoCadastro')->name('regulamentoCadastro');
		////
		
		//DespesasPessoais
		Route::get('recursos-humanos/{id}/despesas','DespesasPessoaisController@cadastroDespesas')->name('cadastroDespesas');
		Route::post('recursos-humanos/{id}/despesas','DespesasPessoaisController@storeDespesas')->name('storeDespesas');

		//Assistencial
		Route::get('assistencial/{id}/assistencialCadastro','AssistencialController@assistencialCadastro')->name('assistencialCadastro');
		Route::get('assistencial/{id}/assistencialCadastro/{id_item}/assistencialValidar/{ano}','AssistencialController@assistencialValidar')->name('assistencialValidar');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialNovo','AssistencialController@assistencialNovo')->name('assistencialNovo');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialExcluir/{id_item}','AssistencialController@assistencialExcluir')->name('assistencialExcluir');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialAlterar/{id_item}','AssistencialController@assistencialAlterar')->name('assistencialAlterar');
		//Route::get('assistencial/visualizar/{id}', 'IndexController@visualizarAssistencial')->name('visualizarAssistencial');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialExcluir/{id_item}','AssistencialController@destroy')->name('destroy');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialAlterar/{id_item}','AssistencialController@update')->name('update');
		////

		//Estatuto/Ata
		Route::get('estatuto/{id}/estatutoCadastro', 'EstatutoController@estatutoCadastro')->name('estatutoCadastro');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoValidar/{id_item}', 'EstatutoController@estatutoValidar')->name('estatutoValidar');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoNovo', 'EstatutoController@estatutoNovo')->name('estatutoNovo');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoExcluir/{id_estatuto}', 'EstatutoController@estatutoExcluir')->name('estatutoExcluir');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoExcluir/{id_estatuto}', 'EstatutoController@destroy')->name('destroy');
		////

		//DocumentosRegularidade
		Route::get('documentos/{id}/documentosCadastro','DocumentacaoRegularidadeController@documentosCadastro')->name('documentosCadastro');
		Route::get('documentos/{id}/documentosCadastro/documentosValidar/{id_item}','DocumentacaoRegularidadeController@documentosValidar')->name('documentosValidar');
		Route::get('documentos/{id}/documentosCadastro/documentosNovo','DocumentacaoRegularidadeController@documentosNovo')->name('documentosNovo');
		Route::get('documentos/{id}/documentosCadastro/documentosExcluir/{id_escolha}','DocumentacaoRegularidadeController@documentosExcluir')->name('documentosExcluir');
		Route::post('documentos/{id}/documentosCadastro/documentosExcluir/{id_escolha}','DocumentacaoRegularidadeController@destroy')->name('destroy');
		////

		//Decreto
		Route::get('decreto/{id}/decretoCadastro','DecretoController@decretoCadastro')->name('decretoCadastro');
		Route::get('decreto/{id}/decretoCadastro/decretoValidar/{id_item}','DecretoController@decretoValidar')->name('decretoValidar');
		Route::get('decreto/{id}/decretoNovo','DecretoController@decretoNovo')->name('decretoNovo');
		Route::get('decreto/{id}/decretoExcluir/{id_escolha}','DecretoController@decretoExcluir')->name('decretoExcluir');
		Route::post('decreto/{id}/decretoExcluir/{id_escolha}','DecretoController@destroy')->name('destroy');
		////
		
		//Regulamento
		Route::get('regulamento/{id}/regulamentoCadastro','RegulamentoController@regulamentoCadastro')->name('regulamentoCadastro');
		Route::get('regulamento/{id}/regulamentoCadastro/regulamentoValidar/{id_item}','RegulamentoController@regulamentoValidar')->name('regulamentoValidar');
		Route::get('regulamento/{id}/regulamentoNovo','RegulamentoController@regulamentoNovo')->name('regulamentoNovo');
		Route::get('regulamento/{id}/regulamentoExcluir/{id_escolha}','RegulamentoController@regulamentoExcluir')->name('regulamentoExcluir');
		Route::post('regulamento/{id}/regulamentoExcluir/{id_escolha}','RegulamentoController@destroy')->name('destroy');
		////

		//Covênio
		Route::get('covenio/{id}/cadastroCovenio', 'CoveniosController@covenioCadastro')->name('covenioCadastro');
		Route::get('covenio/{id}/covenioNovo', 'CoveniosController@covenioNovo')->name('covenioNovo');
		Route::get('covenio/{id}/excluirCovenio/{id_escolha}', 'CoveniosController@covenioExcluir')->name('covenioExcluir');
		Route::post('covenio/{id}/excluirCovenio/{id_escolha}', 'CoveniosController@destroy')->name('destroy');	
		////
		
		//RelatorioGerencial
		Route::get('relmensalExecucao/{id}', 'IndexController@transparenciaRelatorioGerencial')->name('transparenciaRelatorioGerencial');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial', 'RelatorioGerencialController@cadastroRelGerencial')->name('cadastroRelGerencial');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialNovo', 'RelatorioGerencialController@relatorioGerencialNovo')->name('relatorioGerencialNovo');
		Route::post('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialNovo', 'RelatorioGerencialController@storeRelatorioG')->name('storeRelatorioG');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialExcluir/{id_rel}', 'RelatorioGerencialController@relatorioGerencialExcluir')->name('relatorioGerencialExcluir');
		Route::post('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialExcluir/{id_rel}', 'RelatorioGerencialController@destroy')->name('destroy');
		
		//ServidoresCedidos
		Route::get('servidoresCedidos/{id}', 'ServidoresCedidosController@servidoresCadastro')->name('servidoresCadastro');
		Route::get('servidoresCedidos/{id}/servidoresNovo', 'ServidoresCedidosController@servidoresNovo')->name('servidoresNovo');
		Route::get('servidoresCedidos/{id}/servidoresAlterar/{id_servidor}', 'ServidoresCedidosController@servidoresAlterar')->name('servidoresAlterar');
		Route::get('servidoresCedidos/{id}/servidoresExcluir/{id_servidor}', 'ServidoresCedidosController@servidoresExcluir')->name('servidoresExcluir');
		Route::post('servidoresCedidos/{id}/servidoresNovo/', 'ServidoresCedidosController@storeServidores')->name('storeServidores');
		Route::post('servidoresCedidos/{id}/servidoresAlterar/{id_servidor}/', 'ServidoresCedidosController@updateServidores')->name('updateServidores');
		Route::post('servidoresCedidos/{id}/servidoresExcluir/{id_servidor}', 'ServidoresCedidosController@destroyServidores')->name('destroyServidores');
		////
		
		//RelatorioFinanceiro
		Route::get('relatorio_financeiro/{id}','RelatorioFinanceiroController@cadastroRelatorio')->name('cadastroRelatorio');
		Route::get('relatorio_financeiro/{id}/relatorioNovo','RelatorioFinanceiroController@relatorioNovo')->name('relatorioNovo');
		Route::post('relatorio_financeiro/{id}/relatorioNovo','RelatorioFinanceiroController@storeRelatorio')->name('storeRelatorio');
		Route::get('relatorio_financeiro/{id}/relatorioExcluir/{id_rel}','RelatorioFinanceiroController@relatorioExcluir')->name('relatorioExcluir');
		Route::post('relatorio_financeiro/{id}/relatorioExcluir/{id_rel}','RelatorioFinanceiroController@destroyRelatorio')->name('destroyRelatorio');
		////
		
		//Ouvidoria
		Route::get('ouvidoria/{id}','OuvidoriaController@sicCadastro')->name('sicCadastro');
		Route::get('ouvidoria/{id}/ouvidoriaNovo','OuvidoriaController@ouvidoriaNovo')->name('ouvidoriaNovo');
		Route::get('ouvidoria/{id}/ouvidoriaAlterar/{id_ouvidoria}','OuvidoriaController@ouvidoriaAlterar')->name('ouvidoriaAlterar');
		Route::get('ouvidoria/{id}/ouvidoriaExcluir/{id_ouvidoria}','OuvidoriaController@ouvidoriaExcluir')->name('ouvidoriaExcluir');
		Route::post('ouvidoria/{id}/ouvidoriaExcluir/{id_ouvidoria}','OuvidoriaController@destroyOuvidoria')->name('destroyOuvidoria');
		Route::post('ouvidoria/{id}/ouvidoriaAlterar/{id_ouvidoria}','OuvidoriaController@updateOuvidoria')->name('updateOuvidoria');
		Route::post('ouvidoria/{id}/ouvidoriaNovo','OuvidoriaController@storeOuvidoria')->name('storeOuvidoria');
		////		
		
		//Assistencial Covid
		Route::get('assistencial/{id}/cadastroAssistencialCovid','AssistencialCovidController@assistencialCovidCadastro')->name('assistencialCovidCadastro');
		Route::get('assistencial/{id}/cadastroAssistencialCovid/novo','AssistencialCovidController@assistencialCovidNovo')->name('assistencialCovidNovo');
		Route::get('assistencial/{id}/excluirAssistencialCovid/{id_covid}','AssistencialCovidController@assistencialCovidExcluir')->name('assistencialCovidExcluir');
		Route::get('assistencial/pesquisarMesCovid/{mes}/{ano}','AssistencialCovidController@pesquisarMesCovid')->name('pesquisarMesCovid');
		Route::post('assistencial/{id}/cadastroAssistencialCovid/novo','AssistencialCovidController@store')->name('store');
		////
		
		//Stores
		Route::post('institucionalCadastro/{id}/institucionalNovo', 'InstitucionalController@store')->name('store');
		Route::post('membros/{id_unidade}/Associados/associadoNovo','AssociadoController@store')->name('store');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmNovo','ConselhoAdmController@store')->name('store');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscNovo','ConselhoFiscController@store')->name('store');
		Route::post('membros/{id_unidade}/Superentendentes/superNovo','SuperintendentesController@store')->name('store');
		Route::post('competencia/{id_unidade}/competenciaNovo','CompetenciaController@store')->name('store');
		Route::post('contratos-gestao/{id_unidade}/contratoNovo','ContratoController@store')->name('store');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroNovo','DemonstrativoFinanceiroController@store')->name('store');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelNovo','DemonstracaoContabelController@store')->name('store');
		Route::post('repasses-recebidos/{id}/repassesNovo','RepasseController@store')->name('store');
		Route::post('contratacao/{id}/cadastroPrestador','ContratacaoController@storePrestador')->name('storePrestador');
		Route::post('contratacao/{id}/cadastroContratos','ContratacaoController@storeContratos')->name('storeContratos');
		Route::post('contratacao/{id}/cadastroContratos/{id_item}','ContratacaoController@storeContratos')->name('storeContratos');
		Route::post('contratacao/{id}/cadastroCotacoes/cotacoesNovo','ContratacaoController@storeCotacoes')->name('storeCotacoes');
		Route::post('contratacao/{id}/responsavelNovo/{id_contrato}','ContratacaoController@storeGestor')->name('storeGestor');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo','RHController@storeSelecao')->name('storeSelecao');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo/selecaoPCargos','RHController@storeCargos')->name('storeCargos');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSNovo','RHController@storeSeletivo')->name('storeSeletivo');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialNovo','AssistencialController@storeAssistencial')->name('storeAssistencial');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialNovo/{id_escolha}','AssistencialController@storeAssistencial')->name('storeAssistencial');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoNovo', 'EstatutoController@store')->name('store');	
		Route::post('documentos/{id}/documentosCadastro/documentosNovo','DocumentacaoRegularidadeController@store')->name('store');
		Route::post('regimento/{id}/regimentoNovo','RegimentoInternoController@store')->name('store');
		Route::post('organograma/{id}/organogramaNovo','OrganizationalController@storeOrganograma')->name('storeOrganograma');
		Route::post('decreto/{id}/decretoNovo','DecretoController@store')->name('store');
		Route::post('regulamento/{id}/regulamentoNovo','RegulamentoController@store')->name('store');
		Route::post('organizacionalNovo/{id}','OrganizationalController@store')->name('store');
		Route::post('covenio/{id}/covenioNovo', 'CoveniosController@store')->name('store');
		Route::post('permissao/{id}/permissaoNovo', 'PermissaoController@store')->name('store');
		Route::post('permissao/{id}/permissaoUsuarioNovo', 'PermissaoController@storePermissaoUsuario')->name('storePermissaoUsuario');
		Route::post('contratacao/{id}/cadastroCotacoes/addCotacao', 'ContratacaoController@storeExcelCotacao')->name('storeExcelCotacao');
		Route::post('contratacao/{id}/cadastroArquivosCotacoes/{id_processo}','ContratacaoController@storeArquivoCotacao')->name('storeArquivoCotacao');
	  });	
});

Route::get('/admin', function(){
    return 'You are an admin inside contracts';
})->middleware('auth','auth.admin');