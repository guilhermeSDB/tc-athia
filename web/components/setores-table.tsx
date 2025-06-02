"use client";

import { SetorModal } from "@/app/dashboard/setores/SetorModal";
import { Alert } from "@/components/ui/alert"; // ou alguma notificação de erro
import { useDeleteSetor } from "@/hooks/use-delete-setor";
import { useSetores } from "@/hooks/use-setores";
import { format } from "date-fns";
import { DataTable } from "./data-table";
import { DeleteSetorDialog } from "./delete-setor-dialog";
import { Button } from "./ui/button";

export function SetoresTable() {
	const { data, isLoading, error, refetch } = useSetores();
	const deleteMutation = useDeleteSetor();

	if (isLoading) {
		return (
			<div className="flex justify-center py-8">
				<span>Carregando...</span>
			</div>
		);
	}

	if (error) {
		return (
			<Alert variant="destructive" className="my-4">
				<p>Erro ao carregar as setores: {error.message}</p>
			</Alert>
		);
	}

	return (
		<div className="space-y-4 p-6">
			<div className="flex justify-end">
				<SetorModal
					trigger={
						<Button variant="outline" className="flex items-center gap-2">
							+ Adicionar Setor
						</Button>
					}
					onSuccess={() => refetch()}
					setorId={0}
				/>
			</div>

			<DataTable
				data={data ?? []}
				columns={[
					{ key: "id", header: "ID" },
					{ key: "descricao", header: "Descrição" },
					{ key: "created_at", header: "Criado em", render: (setor) => format(new Date(setor.created_at), "dd/MM/yyyy 'às' HH:mm") },
				]}
				actions={(setor) => (
					<>
						<SetorModal
							setorId={setor.id}
							trigger={<Button size="sm" variant="outline">Editar</Button>}
							onSuccess={() => refetch()}
						/>
						<DeleteSetorDialog
							descricao={setor.descricao}
							isLoading={deleteMutation.isPending}
							onConfirm={() => deleteMutation.mutate(setor.id)}
						/>
					</>
				)}
			/>
		</div>
	);
}
