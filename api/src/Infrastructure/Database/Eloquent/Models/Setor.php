<?php

namespace App\Infrastructure\Database\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends Model
{
	use SoftDeletes;

	protected $table = 'setor';
	protected $fillable = ['descricao'];
	public $timestamps = true;

	public function empresas()
	{
		return $this->belongsToMany(
			Empresa::class,       // model destino
			'empresa_setor',      // tabela pivot
			'setor_id',           // foreign key na pivot que aponta para esta tabela (setor.id)
			'empresa_id'          // foreign key na pivot que aponta para empresa.id
		);
	}
}
