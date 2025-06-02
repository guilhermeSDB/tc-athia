export interface Empresa {
  id: number;
  cnpj: string;              // ex: "12.345.678/0001-99"
  razao_social: string;
  nome_fantasia?: string | null;
  created_at: string;        // ex: "2025-05-30T14:23:00Z"
  updated_at: string;
  deleted_at: string | null;
}
