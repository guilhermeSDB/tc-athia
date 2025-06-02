import { Download } from "lucide-react";
import React from "react";
import { Button } from "./ui/button";

/* eslint-disable  @typescript-eslint/no-explicit-any */

interface ExportCSVButtonProps {
  data: any[];
	filename?: string;
	disabled: boolean
}

const ExportCSVButton: React.FC<ExportCSVButtonProps> = ({
  data,
	filename = "dados.csv",
	disabled = true
}) => {
  const exportToCSV = () => {
    if (!data || data.length === 0) return alert("Nenhum dado para exportar.");

    const keys = Object.keys(data[0]);
    const csvRows = [
      keys.join(","), // cabeçalhos
      ...data.map(row =>
        keys.map(k => `"${(row[k] ?? "").toString().replace(/"/g, '""')}"`).join(",")
      ),
    ];

    const csvString = csvRows.join("\n");
    const blob = new Blob([csvString], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", filename);
    link.click();
  };

  return (
    <Button
      onClick={exportToCSV}
			className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
			disabled={disabled}
    >
      <Download className="w-4 h-4 mr-2" />
      Exportar CSV
    </Button>
  );
};

export default ExportCSVButton;
