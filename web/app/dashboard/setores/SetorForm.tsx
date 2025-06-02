"use client";

import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { SetorFormValues, setorSchema } from "@/schemas/setor";
import { zodResolver } from "@hookform/resolvers/zod";
import { Loader } from "lucide-react";
import React from "react";
import { useForm } from "react-hook-form";

type SetorFormProps = {
	onSubmit: (data: SetorFormValues) => void;
	defaultValues?: Partial<SetorFormValues>;
	loading?: boolean;
	error?: string | null;
	mode?: "create" | "edit";
};

export const SetorForm = ({
	onSubmit,
	defaultValues,
	loading = false,
	error,
	mode = "create",
}: SetorFormProps) => {
	const form = useForm<SetorFormValues>({
		resolver: zodResolver(setorSchema),
		defaultValues: defaultValues || {
			descricao: "",
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

				<FormField
					control={form.control}
					name="descricao"
					render={({ field }) => (
						<FormItem>
							<FormLabel>Descrição</FormLabel>
							<FormControl>
								<Input {...field} />
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				{error && (
					<Alert variant="destructive">
						<AlertTitle>Erro</AlertTitle>
						<AlertDescription>{error}</AlertDescription>
					</Alert>
				)}

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
