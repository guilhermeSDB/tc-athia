"use client";

import { EmpresaModal } from "@/app/dashboard/empresas/EmpresaModal";
import { Alert } from "@/components/ui/alert"; // ou alguma notificação de erro
import { useDeleteEmpresa } from "@/hooks/use-delete-empresa";
import { useEmpresas } from "@/hooks/use-empresas";
import { maskCNPJ } from "@/utils/format";
import { format } from "date-fns";
import { DataTable } from "./data-table";
import { DeleteEmpresaDialog } from "./delete-empresa-dialog";
import { Button } from "./ui/button";

export function EmpresasTable() {
	const { data, isLoading, error, refetch } = useEmpresas();
	const deleteMutation = useDeleteEmpresa();

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
				<p>Erro ao carregar as empresas: {error.message}</p>
			</Alert>
		);
	}

	return (
		<div className="space-y-4 p-6">
			<div className="flex justify-end">
				<EmpresaModal
					trigger={
						<Button variant="outline" className="flex items-center gap-2">
							+ Adicionar Empresa
						</Button>
					}
					onSuccess={() => refetch()}
					empresaId={0}
				/>
			</div>

			<DataTable
				data={data ?? []}
				columns={[
					{ key: "id", header: "ID" },
					{ key: "cnpj", header: "CNPJ", render: (empresa) => maskCNPJ(empresa.cnpj) },
					{ key: "razao_social", header: "Razão Social" },
					{ key: "nome_fantasia", header: "Nome Fantasia", render: (empresa) => empresa.nome_fantasia ?? "—" },
					{ key: "created_at", header: "Criado em", render: (empresa) => format(new Date(empresa.created_at), "dd/MM/yyyy 'às' HH:mm") },
				]}
				actions={(empresa) => (
					<>
						<EmpresaModal
							empresaId={empresa.id}
							trigger={<Button size="sm" variant="outline">Editar</Button>}
							onSuccess={() => refetch()}
						/>
						<DeleteEmpresaDialog
							razaoSocial={empresa.razao_social}
							isLoading={deleteMutation.isPending}
							onConfirm={() => deleteMutation.mutate(empresa.id)}
						/>
					</>
				)}
			/>
		</div>
	);
}
