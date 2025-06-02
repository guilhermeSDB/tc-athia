<?php

namespace App\Infrastructure\Database\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
	use SoftDeletes;

	protected $table = 'empresa';
	protected $fillable = ['razao_social', 'nome_fantasia', 'cnpj'];
	public $timestamps = true;

	public function setores()
	{
		return $this->belongsToMany(
			Setor::class,         // model destino
			'empresa_setor',      // nome da tabela pivot
			'empresa_id',         // foreign key na pivot que aponta para esta tabela (empresa.id)
			'setor_id'            // foreign key na pivot que aponta para a tabela setor.id
		);
	}
}
