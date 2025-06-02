import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { EmpresaSetor } from '@/types/empresa-setor';

type EmpresaSetorReportCardProps = {
    empresaSetor: EmpresaSetor;
};

export function EmpresaSetorReportCard({ empresaSetor }: EmpresaSetorReportCardProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>{empresaSetor.razao_social}</CardTitle>
            </CardHeader>
            <CardContent>
                <p>CNPJ: {empresaSetor.cnpj}</p>
                <p>Nome Fantasia: {empresaSetor.nome_fantasia}</p>
                <Separator className="my-4" />
                <h4 className="text-lg font-semibold mb-2">Setores:</h4>
                {
                    empresaSetor.setores.length > 0 ? (
                        <ul>
                            {empresaSetor.setores.map((setor) => (
                                <li key={setor.id}>- {setor.descricao}</li>
                            ))}
                        </ul>
                    ) : (
                        <p>Nenhum setor associado.</p>
                    )
                }
            </CardContent>
        </Card>
    );
} 
