<?php

class Usuario extends AbsIdNome
{
	private $senha;
	private $data_nasc;
	private $img_perfil;
	private $email;
	private $data_criaConta;
	private $sobre_mim;
	private $ultimo_login;
	private $adm;

	private $amigos = [];
	private $pedidosAmizadeRecebidos = [];
	private $pedidosAmizadeFeitos = [];

	private $obras_fav = array();
	private $artistas_fav = array();
	private $obras_rel = array();
	private $obras_nota = array();

	private $comentarios_feitos = [];
	private $comentarios_recebidos = [];
	private $resenhas = array();
	private $listas = array();
	private $relacoes = array(); // tabela 'relacao' BD
	private $contribuicoes = array(); // tabela 'contribuicao'
	private $contribuicoes_aval = array(); // contribuicoes avaliadas pelo administrador

	public function setSenha($senha)
	{
		$this->senha = sha1($senha);
	}
	public function getSenha()
	{
		return $this->senha;
	}

	public function getData_nasc()
	{
		return $this->data_nasc;
	}
	public function setData_nasc($data)
	{
		$this->data_nasc = $data;
	}

	public function getImgPerfil()
	{
		return $this->img_perfil;
	}
	public function setImgPerfil($i)
	{
		$this->img_perfil = $i;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function getEmail()
	{
		return $this->email;
	}

	public function setData_criaConta($dt)
	{
		$this->data_criaConta = $dt;
	}
	public function getData_criaConta()
	{
		return $this->data_criaConta;
	}

	public function setSobre_mim($sobre)
	{
		$this->sobre_mim = $sobre;
	}
	public function getSobre_mim()
	{
		return $this->sobre_mim;
	}

	public function setUltimoLogin($dt)
	{
		$this->ultimo_login = $dt;
	}
	public function getUltimoLogin()
	{
		return $this->ultimo_login;
	}

	public function setObra_fav($obra)
	{
		if ($obra instanceof Obra) {
			array_push($this->obras_fav, $obra);
		}
	}
	public function getObras_fav()
	{
		return $this->obras_fav;
	}

	public function setArtista_fav($artista)
	{
		if ($artista instanceof Artista) {
			array_push($this->artistas_fav, $artista);
		}
	}
	public function getArtistas_fav()
	{
		return $this->artistas_fav;
	}

	public function setObra_rel($obra)
	{
		if ($obra instanceof UsuarioRelObra) {
			array_push($this->obras_rel, $obra);
		}
	}

	public function getObras_rel()
	{
		return $this->obras_rel;
	}

	public function setObra_nota($obra)
	{
		if ($obra instanceof UsuarioNotaObra) {
			array_push($this->obras_nota, $obra);
		}
	}

	public function getObras_nota()
	{
		return $this->obras_nota;
	}

	public function setResenha($r)
	{
		if ($r instanceof Resenha) array_push($this->resenhas, $r);
	}
	public function getResenhas()
	{
		return $this->resenhas;
	}

	public function setAdm($a)
	{
		$this->adm = $a;
	}
	public function getAdm()
	{
		return $this->adm;
	}

	public function setLista($l)
	{
		if ($l instanceof Lista) {
			array_push($this->listas, $l);
		}
	}
	public function listas()
	{
		return $this->listas;
	}

	public function setRelacao($r)
	{
		if ($r instanceof Relacao) {
			array_push($this->relacoes, $r);
		}
	}
	public function getRelacoes()
	{
		return $this->relacoes;
	}

	public function setContribuicao($c)
	{
		if ($c instanceof Contribuicao) {
			array_push($this->contribuicoes, $c);
		}
	}
	public function getContribuicoes()
	{
		return $this->contribuicoes;
	}

	public function setContribuicaoAval($c)
	{
		if ($c instanceof Contribuicao) {
			array_push($this->contribuicoes_aval, $c);
		}
	}
	public function getContribuicoesAval()
	{
		return $this->contribuicoes_aval;
	}

	public function setComentario_feito($cmt)
	{
		if ($cmt instanceof Comentario) {
			$this->comentarios_feitos[] = $cmt;
		}
	}
	public function comentarios_feitos()
	{
		return $this->comentarios_feitos;
	}

	public function setComentario_recebido($cmt)
	{
		if ($cmt instanceof Comentario) {
			$this->comentarios_recebidos[] = $cmt;
		}
	}
	public function comentarios_recebidos()
	{
		return $this->comentarios_recebidos;
	}

	public function setAmigo($usuario)
	{
		if ($usuario instanceof Usuario) {
			$this->amigos[] = $usuario;
		}
	}
	public function getAmigos()
	{
		return $this->amigos;
	}

	public function setPedidoAmizadeFeito($pedido)
	{ 
		if ($pedido instanceof Usuario) {
			$this->pedidosAmizadeFeitos[] = $pedido;
		}
	}
	public function getPedidosAmizadeFeitos()
	{ 
		return $this->pedidosAmizadeFeitos;
	}

	public function setPedidoAmizadeRecebido($pedido)
	{ 
		if ($pedido instanceof Usuario) {
			$this->pedidosAmizadeRecebidos[] = $pedido;
		}
	}
	public function getPedidosAmizadeRecebidos()
	{ 
		return $this->pedidosAmizadeRecebidos;
	}
}
