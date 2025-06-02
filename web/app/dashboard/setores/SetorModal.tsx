"use client";

import {
	Dialog,
	DialogContent,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from "@/components/ui/dialog";
import { useCreateSetor } from "@/hooks/use-create-setor";
import { useSetor } from "@/hooks/use-setor";
import { useUpdateSetor } from "@/hooks/use-update-setor";
import { SetorFormValues } from "@/schemas/setor";
import { Loader } from "lucide-react";
import React from "react";
import { SetorForm } from "./SetorForm";

type SetorModalProps = {
	trigger: React.ReactNode;
	setorId: number;
	onSuccess?: () => void;
};

export function SetorModal({ trigger, setorId, onSuccess }: SetorModalProps) {
	const [open, setOpen] = React.useState(false);
	const { data, isLoading: isFetching } = useSetor(setorId, {
		enabled: open,
	});
	const create = useCreateSetor();
	const update = useUpdateSetor();

	const isEditMode = !!setorId;

	const handleSubmit = (values: SetorFormValues) => {
		const mutation = isEditMode
			? update.mutateAsync({ id: Number(setorId), ...values })
			: create.mutateAsync(values);

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
					<DialogTitle>{isEditMode ? "Editar Setor" : "Novo Setor"}</DialogTitle>
				</DialogHeader>

				{isEditMode && isFetching ? (
					<div className="flex justify-center py-6">
						<Loader className="w-6 h-6 animate-spin text-muted-foreground" />
					</div>
				) : (
					<SetorForm
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
