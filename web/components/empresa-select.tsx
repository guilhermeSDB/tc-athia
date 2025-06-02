import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Empresa } from "@/types/empresa";

interface EmpresaSelectProps {
  value: number | undefined;
  onChange: (value: string) => void;
  empresas?: Empresa[];
}

export const EmpresaSelect: React.FC<EmpresaSelectProps> = ({ value, onChange, empresas = [] }) => {
	const newValue = value === undefined ? "" : value.toString()
  return (
    <Select value={newValue} onValueChange={onChange}>
      <SelectTrigger className="w-[250px]">
        <SelectValue placeholder="Selecione uma empresa" />
      </SelectTrigger>
      <SelectContent>
        {empresas.map(empresa => (
          <SelectItem key={empresa.id} value={empresa.id.toString()}>
            {empresa.razao_social}
          </SelectItem>
        ))}
      </SelectContent>
    </Select>
  );
};
