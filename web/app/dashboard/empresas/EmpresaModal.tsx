"use client";

import {
	Dialog,
	DialogContent,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from "@/components/ui/dialog";
import { useCreateEmpresa } from "@/hooks/use-create-empresa";
import { useEmpresa } from "@/hooks/use-empresa";
import { useUpdateEmpresa } from "@/hooks/use-update-empresa";
import { EmpresaFormValues } from "@/schemas/empresa";
import { Loader } from "lucide-react";
import React from "react";
import { EmpresaForm } from "./EmpresaForm";

type EmpresaModalProps = {
	trigger: React.ReactNode;
	empresaId: number;
	onSuccess?: () => void;
};

export function EmpresaModal({ trigger, empresaId, onSuccess }: EmpresaModalProps) {
	const [open, setOpen] = React.useState(false);
	const { data, isLoading: isFetching } = useEmpresa(empresaId, {
		enabled: open,
	});
	const create = useCreateEmpresa();
	const update = useUpdateEmpresa();

	const isEditMode = !!empresaId;

	const handleSubmit = (values: EmpresaFormValues) => {
		const payload = {
			...values,
			nome_fantasia:
				!values.nome_fantasia || values.nome_fantasia.trim().length === 0
					? undefined
					: values.nome_fantasia,
		};

		const mutation = isEditMode
			? update
				.mutateAsync({ id: Number(empresaId), ...payload })
			: create.mutateAsync(payload);

		mutation
			.then(() => {
				onSuccess?.();
				setOpen(false);
			})
			.catch(() => { });
	};

	return (
		<Dialog open={open} onOpenChange={setOpen}>
			<DialogTrigger asChild>{trigger}</DialogTrigger>

			<DialogContent>
				<DialogHeader>
					<DialogTitle>{isEditMode ? "Editar Empresa" : "Nova Empresa"}</DialogTitle>
				</DialogHeader>

				{isEditMode && isFetching ? (
					<div className="flex justify-center py-6">
						<Loader className="w-6 h-6 animate-spin text-muted-foreground" />
					</div>
				) : (
					<EmpresaForm
						mode={isEditMode ? "edit" : "create"}
						defaultValues={isEditMode ? data : undefined}
						loading={create.isPending || update.isPending}
						error={(create.error as Error)?.message || (update.error as Error)?.message}
						onSubmit={handleSubmit}
					/>
				)}
			</DialogContent>
		</Dialog>
	);
}
