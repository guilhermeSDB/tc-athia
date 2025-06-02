import { Empresa } from "./empresa";
import { Setor } from "./setor";

export interface EmpresaSetor extends Empresa {
	setores:Setor[]
}
