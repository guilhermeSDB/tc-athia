import { z } from "zod";

const limparMascara = (valor: string) => valor.replace(/\D/g, "");

export const empresaSchema = z.object({
  cnpj: z
		.string({
			required_error: 'CNPJ é obrigatório.',
		})
    .min(1, "CNPJ é obrigatório.")
    .refine((valor) => {
      const limpo = limparMascara(valor);
      return limpo.length === 14;
    }, "CNPJ deve conter exatamente 14 dígitos numéricos.")
    .refine((valor) => {
      const limpo = limparMascara(valor);
      return /^\d+$/.test(limpo);
		}, "CNPJ deve conter apenas números."),
  razao_social: z.string().min(1, "Razão Social é obrigatória"),
	nome_fantasia: z.string().optional().nullable(),
	setores: z.array(z.number()).optional(),
});

export type EmpresaFormValues = z.infer<typeof empresaSchema>;
