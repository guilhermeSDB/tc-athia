import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Setor } from "@/types/setor";

interface SetorSelectProps {
  value: number | undefined;
  onChange: (value: string) => void;
  setores?: Setor[];
}

export const SetorSelect: React.FC<SetorSelectProps> = ({ value, onChange, setores = [] }) => {
	const newValue = value === undefined ? "" : value.toString()
  return (
    <Select value={newValue} onValueChange={onChange}>
      <SelectTrigger className="w-[250px]">
        <SelectValue placeholder="Selecione um setor" />
      </SelectTrigger>
      <SelectContent>
        {setores.map(setor => (
          <SelectItem key={setor.id} value={setor.id.toString()}>
            {setor.descricao}
          </SelectItem>
        ))}
      </SelectContent>
    </Select>
  );
};
