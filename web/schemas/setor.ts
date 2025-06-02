import { z } from "zod";


export const setorSchema = z.object({
	descricao: z
		.string()
		.min(1, "Descricao é obrigatório")
		.max(100, "Descrição deve ter no máximo 100 caracteres"),
});

export type SetorFormValues = z.infer<typeof setorSchema>;
