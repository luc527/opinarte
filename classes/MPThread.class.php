<?php
require_once('autoload.php');

date_default_timezone_set('America/Sao_Paulo');

// Thread de mensagens privadas
class MPThread extends AbsId {
	private $titulo;
	private $mensagens = array();
	private $usuarios = array();

	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	public function titulo() {
		return $this->titulo;
	}

	public function setMensagem($mp) {
		if ($mp instanceof MP) {
			array_push($this->mensagens, $mp);
		}
	}
	public function mensagens() {
		return $this->mensagens;
	}

	public function setUsuario($us) {
		if ($us instanceof Usuario) {
			array_push($this->usuarios, $us);
		}
	}
	public function usuarios() {
		return $this->usuarios;
	}

	/**
	 * Calcula tempo desde a última mensagem.
	 */
	private function calcTempoDesdeUltimaMsg() {
		$ultima = $this->mensagens[0]; // [0] porque o select é ORDER BY dtHr DESC; ou seja, as últimas primeiro
		$data_ultima = new DateTime($ultima->data_hora());
		$data_atual = new DateTime(date("Y-m-d H:i:s"));
		$diff = $data_ultima->diff($data_atual);
		return $diff;
	}

	/**
	 * Recebe retorno da função calcTempoDesdeUltimaMsg e transforma em texto
	 */
	public function tempoDesdeUltimaMsg() {
		$diff = $this->calcTempoDesdeUltimaMsg();
		$txt = "";
		if($diff->y > 0) {
			$txt .= $diff->y." ano";
			if ($diff->y > 1) {
				$txt .= 's';
			}
			$txt .= ", ";
		}
		if($diff->m == 1) {
			$txt .= $diff->m." mês, ";
		} else if ($diff->m > 1) {
			$txt .= $diff->m." meses, ";
		}
		if($diff->d > 0) {
			$txt .= $diff->d." dia";
			if ($diff->d > 1) {
				$txt .= 's';
			}
			$txt .= ", ";
		}
		if($diff->h > 0) {
			$txt .= $diff->h." hora";
			if ($diff->h > 1) {
				$txt .= 's';
			}
			$txt .= ", ";
		}
		if($diff->i > 0) {
			$txt .= $diff->i." minuto";
			if ($diff->i > 1) {
				$txt .= 's';
			}
			$txt .= ", ";
		}
		$txt .= $diff->s." segundo";
		if ($diff->s > 1) {
			$txt .= 's';
		}
		return $txt;
	}
}
?>