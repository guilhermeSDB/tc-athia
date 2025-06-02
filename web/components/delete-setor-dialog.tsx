import {
	AlertDialog,
	AlertDialogAction,
	AlertDialogCancel,
	AlertDialogContent,
	AlertDialogDescription,
	AlertDialogFooter,
	AlertDialogHeader,
	AlertDialogTitle,
	AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import { Button } from "@/components/ui/button";

type DeleteSetorDialogProps = {
	descricao: string;
	onConfirm: () => void;
	isLoading?: boolean;
};

export function DeleteSetorDialog({
	descricao,
	onConfirm,
	isLoading = false,
}: DeleteSetorDialogProps) {
	return (
		<AlertDialog>
			<AlertDialogTrigger asChild>
				<Button size="sm" variant="destructive" disabled={isLoading}>
					{isLoading ? "Deletando..." : "Deletar"}
				</Button>
			</AlertDialogTrigger>
			<AlertDialogContent>
				<AlertDialogHeader>
					<AlertDialogTitle>
						Tem certeza que deseja deletar este setor?
					</AlertDialogTitle>
					<AlertDialogDescription>
						Esta ação não poderá ser desfeita. Isso irá remover o setor
						<strong> “{descricao}”</strong> do sistema.
					</AlertDialogDescription>
				</AlertDialogHeader>
				<AlertDialogFooter>
					<AlertDialogCancel>Cancelar</AlertDialogCancel>
					<AlertDialogAction
						onClick={onConfirm}
						disabled={isLoading}
						className="bg-red-600 hover:bg-red-700"
					>
						{isLoading ? "Deletando..." : "Confirmar"}
					</AlertDialogAction>
				</AlertDialogFooter>
			</AlertDialogContent>
		</AlertDialog>
	);
}
