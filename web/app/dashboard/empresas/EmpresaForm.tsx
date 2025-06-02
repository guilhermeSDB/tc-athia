"use client";

import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { InputCNPJ } from "@/components/ui/input-cnpj";
import { useSetores } from "@/hooks/use-setores";
import { EmpresaFormValues, empresaSchema } from "@/schemas/empresa";
import { zodResolver } from "@hookform/resolvers/zod";
import { Loader } from "lucide-react";
import React from "react";
import { useForm } from "react-hook-form";
import { SetorMultiSelect } from "../setores/SetorMultiSelect";

type EmpresaFormProps = {
	onSubmit: (data: EmpresaFormValues) => void;
	defaultValues?: Partial<EmpresaFormValues>;
	loading?: boolean;
	error?: string | null;
	mode?: "create" | "edit";
};

export const EmpresaForm = ({
	onSubmit,
	defaultValues,
	loading = false,
	error,
	mode = "create",
}: EmpresaFormProps) => {
	const { data: setoresDisponiveis = [] } = useSetores();
	const form = useForm<EmpresaFormValues>({
		resolver: zodResolver(empresaSchema),
		defaultValues: defaultValues || {
			cnpj: "",
			razao_social: "",
			nome_fantasia: "",
			setores: [],
		},
	});

	React.useEffect(() => {
		if (defaultValues) {
			form.reset(defaultValues);
		}
	}, [defaultValues, form]);


	return (
		<Form {...form}>
			<form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
				{error && (
					<Alert variant="destructive">
						<AlertTitle>Erro</AlertTitle>
						<AlertDescription>{error}</AlertDescription>
					</Alert>
				)}

				<InputCNPJ control={form.control} name="cnpj" />

				<FormField
					control={form.control}
					name="razao_social"
					render={({ field }) => (
						<FormItem>
							<FormLabel>Razão Social</FormLabel>
							<FormControl>
								<Input {...field} />
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				<FormField
					control={form.control}
					name="nome_fantasia"
					render={({ field }) => (
						<FormItem>
							<FormLabel>Nome Fantasia</FormLabel>
							<FormControl>
								<Input {...field} value={field.value ?? ""} />
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				<FormField
					control={form.control}
					name="setores"
					render={({ field }) => (
						<FormItem className="w-full">
							<FormLabel>Setores</FormLabel>
							<SetorMultiSelect
								value={field.value || []}
								options={setoresDisponiveis}
								onChange={field.onChange}
							/>
							<FormMessage />
						</FormItem>
					)}
				/>

				<div className="flex justify-end gap-2">
					<Button type="submit" disabled={loading}>
						{loading && <Loader className="w-4 h-4 mr-2 animate-spin" />}
						{mode === "edit" ? "Atualizar" : "Salvar"}
					</Button>
				</div>
			</form>
		</Form>
	);
};
